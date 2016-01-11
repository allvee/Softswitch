var APPLOGIN_ID = "#login";
var APPUID_ID = "#mn";
var APPPWD_ID = "#pwd";
var APPREGISTER_ID = "#register";
var APPLOGINRES_ID = "#loginResult";
var APPFORGOTPASS_ID = "#forgotPass";

var APPLOGINMAIN_ID = "#loginMain";
var APPMAIN_ID = "#gameMain";

var APPLOGOUT_ID = "#logout";
var APPSINGUP_ID = "#signup";

var MY_ID = ".my_div";
var BD_ID = ".bd_div";


var APP_NOTIFICATION_CLOSE_ID = "#notifClose";
var APP_NOTIFICATION_CONTENT_ID = "#notifContent";
var APP_NOTIFICATION_AREA_ID = "#notifyMain";
var APP_LOADING_ID = "#loadingdiv";
var ANDROID_ADDITIONAL_SECTION_ID = "#addroid";

var HTTPGET_UID_VAR = "mn";
var HTTPGET_PWD_VAR = "pwd";

var SMS_SRCLIST = "39393,2000,2580,2008,3690";
var SMS_DESTMN = "39393";
var SMS_REGTEXT = "ON DOZE";
var SMS_FORGOTPASS_TEXT = "GET PASSWD";
var SMS_SEND_SUCCESS_MSG = "You will receive a password shortly..! Use your mobile no and received password to login";
var SMS_SEND_FAILED_MSG = "Type ON DOZE and send to 39393. You will receive your password. Use your mobile no and received password to login";
var FORGOTPASS_SMS_SEND_SUCCESS_MSG = "You will receive a password shortly..! Use your mobile no and received password to login";
var FORGOTPASS_SMS_SEND_FAILED_MSG = "Type GET PASSWD and send to 39393. You will receive your password. Use your mobile no and received password to login";
var APP_AUTH_FAILED_MSG = "Invalid login details.. try again";
var LOGIN_SVC_CON_FAILED_MSG = "Cannot connect to login service.. Please try again";
var APP_INIT_LOGIN_MSG = "Initiating login....";

var APP_DOMAIN = "localhost";
var URL_HOME = "/HTML5/"; //should terminate with '/'
var AUTH_URL = URL_HOME + "authenticate.php?mn="; //<mn> and pwd=<pwd> will be added from function

var APP_START_FUNCTION = "startGame";

var RURL = document.domain;

var domainConfigs = [
    { "domain": "doze.my"
        , "SMS_SRCLIST": "39393,2000", "SMS_DESTMN": "39393", "SMS_REGTEXT": "ON DOZE"
        , "SMS_FORGOTPASS_TEXT": "GET PASSWD"
        , "SMS_SEND_SUCCESS_MSG": "You will receive a password shortly..! Use your mobile no and received password to login"
        , "SMS_SEND_FAILED_MSG": "Type ON DOZE and send to 39393. You will receive your password. Use your mobile no and received password to login"
        , "FORGOTPASS_SMS_SEND_SUCCESS_MSG": "You will receive a password shortly..! Use your mobile no and received password to login"
        , "FORGOTPASS_SMS_SEND_FAILED_MSG": "Type GET PASSWD and send to 39393. You will receive your password. Use your mobile no and received password to login"
    }
    , { "domain": "bd.doze.my"
        , "SMS_SRCLIST": "2580,022580,002580,25800230,25800000", "SMS_DESTMN": "2580", "SMS_REGTEXT": "START DOZE"
        , "SMS_FORGOTPASS_TEXT": "GET PASSWD"
        , "SMS_SEND_SUCCESS_MSG": "You will receive a password shortly..! Use your mobile no and received password to login"
        , "SMS_SEND_FAILED_MSG": "Type ON DOZE and send to 2580. You will receive your password. Use your mobile no and received password to login"
        , "FORGOTPASS_SMS_SEND_SUCCESS_MSG": "You will receive a password shortly..! Use your mobile no and received password to login"
        , "FORGOTPASS_SMS_SEND_FAILED_MSG": "Type GET PASSWD and send to 2580. You will receive your password. Use your mobile no and received password to login"
    }
];

var isAuthenticated = localStorage.isAuthenticated;
var mn = localStorage.MobileNo;
var pwd = localStorage.Password;
var initiateLogin = false;
var appStarted = "NO";
var FINAL_AUTH_URL = "";


var urlMN = HTTP_GET[HTTPGET_UID_VAR];
var urlPWD = HTTP_GET[HTTPGET_PWD_VAR];


function loadDomainDefaults() {
    APP_DOMAIN = document.domain;
    var urlPrefix = "http://" + APP_DOMAIN + URL_HOME; //should terminate with '/'
    FINAL_AUTH_URL = urlPrefix + AUTH_URL; //<mn> and pwd=<pwd> will be added from function

    for (i = 0; i < domainConfigs.length; i++) {
        if (domainConfigs[i].domain == APP_DOMAIN) {
            SMS_SRCLIST = domainConfigs[i].SMS_SRCLIST;
            SMS_DESTMN = domainConfigs[i].SMS_DESTMN;
            SMS_REGTEXT = domainConfigs[i].SMS_REGTEXT;
            SMS_FORGOTPASS_TEXT = domainConfigs[i].SMS_FORGOTPASS_TEXT;
            SMS_SEND_SUCCESS_MSG = domainConfigs[i].SMS_SEND_SUCCESS_MSG;
            SMS_SEND_FAILED_MSG = domainConfigs[i].SMS_SEND_FAILED_MSG;
            FORGOTPASS_SMS_SEND_SUCCESS_MSG = domainConfigs[i].FORGOTPASS_SMS_SEND_SUCCESS_MSG;
            FORGOTPASS_SMS_SEND_FAILED_MSG = domainConfigs[i].FORGOTPASS_SMS_SEND_FAILED_MSG;
            break;
        }
    }
}

function showNotification(msg) {
    $(APP_NOTIFICATION_AREA_ID).show();
    $(APP_NOTIFICATION_CONTENT_ID).html(msg);
}


function sendSMS(evt) {
    var smsText = evt.target.getAttribute("smsText");
    var smsBNO = evt.target.getAttribute("smsBNO");
    var smsSentMsg = evt.target.getAttribute("smsSentMsg");
    var smsUnavailableMsg = evt.target.getAttribute("smsUnavailableMsg");

    smsBNO.replace("BNO", SMS_DESTMN);
    smsSentMsg.replace("BNO", SMS_DESTMN);
    smsUnavailableMsg.replace("BNO", SMS_DESTMN);
        
    try {
        window.JSInterface.sendSMS(smsBNo, smsText);
        showNotification(smsSentMsg);
    } catch (e) {
        showNotification(smsUnavailableMsg);
    }

}

function checkAuth(mn, pwd) {
    if (appStarted == "NO") 
        $(APP_LOADING_ID).show();
		if(APP_DOMAIN == 'bd.doze.my')
		{
			var prefix = mn.substring(0,2); 
			if (prefix != '88')
			{
				mn = '88'+mn;
			}
		}
		$.get(FINAL_AUTH_URL + mn + "&pwd=" + pwd, function(data, status) {
        $(APP_LOADING_ID).hide();
        if (data == "OK") {
            localStorage.isAuthenticated = "YES";
            localStorage.MobileNo = mn;
            localStorage.Password = pwd;
            isAuthenticated = "YES";
            if (appStarted == "NO") {
                $(APPLOGINMAIN_ID).hide();
				$(APPSINGUP_ID).hide();//mehedi
                $(APPMAIN_ID).show();
                window[APP_START_FUNCTION]();
            }
            $(APPLOGINRES_ID).hide();
			$(APPLOGOUT_ID).show(); //mehedi
        }
        else if (data == "ERR") {
            $(APPLOGINMAIN_ID).show();
			$(APPSINGUP_ID).show();//mehedi
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(APP_AUTH_FAILED_MSG);
            localStorage.isAuthenticated = "NO";
            localStorage.MobileNo = "";
            localStorage.Password = "";
            isAuthenticated = "NO";
            if (appStarted == "YES") {
                $(APPMAIN_ID).hide();
                $(APPLOGINMAIN_ID).show();
				$(APPSINGUP_ID).show();//mehedi
            }
			$(APPLOGOUT_ID).hide(); //mehedi
        }
        else if (isAuthenticated != "YES") {
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(LOGIN_SVC_CON_FAILED_MSG);
        }
    });
}

function addUASpecificSection() {
    var ua = navigator.userAgent;

    if (HTTP_GET["imei"] != null)
        return;

    if (ua.search("Android") > 0) {
        $(ANDROID_ADDITIONAL_SECTION_ID).show();
    }
}
// domain change 
function domainChange(){
	
	var c_code = HTTP_GET["cc"];
	
	var this_domain = "";
	
	if(c_code === undefined) 
	{
		this_domain = document.domain;
	}
	else
	{
		if(c_code == 'MY')
		{
			this_domain = "doze.my";
		}
		else 
		{
			this_domain = "bd.doze.my";
		}
	}
	
	if(this_domain == "doze.my")
	{
		$(MY_ID).show();
		$(BD_ID).hide();
	}
	else
	{
		$(MY_ID).hide();
		$(BD_ID).show();
	}
}


function appInit() {
    loadDomainDefaults();
    registerSMSMN(SMS_SRCLIST);
    $(APPLOGINRES_ID).hide();
    addUASpecificSection();
	$(APPLOGOUT_ID).hide(); //mehedi
	domainChange(); // mehedi 
	
    $(document).on("click", "[action=\"sendSMS\"]", sendSMS);
    
    if (urlMN != null && urlPWD != null)
	{
        mn = urlMN;
        pwd = urlPWD;
        initiateLogin = true;
    }
	else
	{
		mn = 0163366370; 
		pwd = 6283;
		initiateLogin = true;
	}

    if (isAuthenticated == "YES") {
        $(APPLOGINMAIN_ID).hide();
		$(APPSINGUP_ID).hide();//mehedi
		$(APPLOGOUT_ID).show(); //mehedi
        $(APPMAIN_ID).show();
        window[APP_START_FUNCTION]();
        appStarted = "YES";
        checkAuth(mn, pwd);
    } else {
        $(APPMAIN_ID).hide();
		$(APPLOGOUT_ID).hide(); //mehedi
        if (initiateLogin) {
            $(APPLOGINMAIN_ID).hide();
			$(APPSINGUP_ID).hide();//mehedi
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(APP_INIT_LOGIN_MSG);
            checkAuth(mn, pwd);
        } else {
            $(APPLOGINMAIN_ID).show();
			$(APPSINGUP_ID).show();//mehedi
			$(APPLOGOUT_ID).hide(); // mehedi
        }
    }
    
    $(APP_NOTIFICATION_CLOSE_ID).click(function() {
        $(APP_NOTIFICATION_AREA_ID).hide();
    });

    $(APPLOGIN_ID).click(function() {
        mn = $(APPUID_ID).val();
        pwd = $(APPPWD_ID).val();
        checkAuth(mn, pwd);
    });

    $(APPREGISTER_ID).click(function() {
        try {
            window.JSInterface.sendSMS(SMS_DESTMN, SMS_REGTEXT);
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(SMS_SEND_SUCCESS_MSG);
        } catch (e) {
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(SMS_SEND_FAILED_MSG);
        }
    });

    $(APPFORGOTPASS_ID).click(function() {
        try {
            window.JSInterface.sendSMS(SMS_DESTMN, SMS_FORGOTPASS_TEXT);
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(FORGOTPASS_SMS_SEND_SUCCESS_MSG);
        } catch (e) {
            $(APPLOGINRES_ID).show();
            $(APPLOGINRES_ID).html(FORGOTPASS_SMS_SEND_FAILED_MSG);
        }
    });

}


function UserSMS(mn, msg) {
    $(APPLOGINRES_ID).html(msg);

    try {
        var sp = msg.search("\"");
        var tmp = msg.substr(sp, 200);    
        var msgInfo = JSON.parse("{"+tmp+"}");
        var svc = msgInfo.SVC;

        if (svc != "DOZE") {
            var handlerName = svc + '_smsHandler';
            window[handlerName](tmp);
            return;
        }

        var uid = msgInfo.UID;
        var pwd = msgInfo.PWD;

        $(APPLOGINMAIN_ID).hide();
		$(APPSINGUP_ID).hide();//mehedi
        $(APPLOGINRES_ID).show()
        $(APPLOGINRES_ID).html(APP_INIT_LOGIN_MSG);
        checkAuth(uid, pwd);
    } catch (e) {
        $(APPLOGINRES_ID).show()
        $(APPLOGINRES_ID).html(msg);
        return;
    }
    
}

function registerSMSMN(mnlist) {
    try{
        var msg = window.JSInterface.srcMN(mnlist);    
    }catch(err) {}
}
