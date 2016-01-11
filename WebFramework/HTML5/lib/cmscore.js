var cmsCategoryLoaded=false, cmsContentLoaded=false;
var waitforCMSData;

//These variables are to be set at the beginning before using cms.
//CMS_CATEGORY_URL should return a JSON Object with details of Category
//CMS_CONTENT_URL should return a JSON Object with details of Content
// Both contents and categories should be linked to make proper navigation and presentation
var CMS_CATEGORY_URL = "";
var CMS_CONTENT_URL="";

/*=====================================================================================
*
* For common functions
*
* =====================================================================================*/
/*=====================================================================================
 *
 * For CMS Panel
 *
 * =====================================================================================*/
/*=====================================================================================
 *
 * For Website
 *
 * =====================================================================================*/

//function getCMSData: populates global structures/variables cmsCategory and cmsContents
//At first it attempts to retrieve data from localStores and populate the cmsCateogory and cmsContent structures/variables
//if localStore doesnt contain any data then the relevant step is skipped
//Afterwards, it makes ajax call to CMS_CATEGORY_URL and CMS_CONTENT_URL
//The output of the URLs are stored in localStore and global structures/variables respectively
function getCMSData()
{
    var localCMSCat=localStorage.cmsCategory;
    var localCMSCont=localStorage.cmsContent;

    if(localCMSCat!=null)
    {
        cmsCategory=JSON.parse(localCMSCat);
        cmsCategoryLoaded=true;
    }

    //console.log(localCMSCont);

    if(localCMSCont!=null)
    {
        cmsContent=JSON.parse(localCMSCont);
        cmsContentLoaded=true;
    }

    $.get(CMS_CATEGORY_URL, function(data, status){

        cmsCategory=JSON.parse(data);
        localStorage.cmsCategory=data;
        cmsCategoryLoaded=true;
    });

    
    $.get(CMS_CONTENT_URL, function(data, status) {
        //JSON.stringify(data)
        cmsContent = JSON.parse(data);
        localStorage.cmsContent = data;
        cmsContentLoaded = true;
    });
}


//function loadCategory: gets triggered when any Category is clicked
//loads the cms category by calling loadCMSCategory funciton
function loadCategory(evt) {
    var id = evt.target.getAttribute("catid");
    var target = evt.target.getAttribute("target");

    loadCMSCategory(id, target);

    evt.stopPropagation();
}

//function displayCategoryList: displays the category list under a specified root at a specified target using a specific layout
//generally the function is called from loadCMSCategory
//but it can be called separately as well to load a particular category list at some specific point
function displayCategoryList(parent, target, layout, parentTarget, nCol, separator) {
    var cat = "", catid = "";
    var dispCount = 0;
    var bakLayout = $(layout).html();

    if(nCol==null)
        nColl=0;
    if(separator==null)
        separator="";

	//console.log(cmsCategory);

    $(target).html("");
    for (var i = 0; i < cmsCategory.length; i++) {

        if (cmsCategory[i].parent == parent) {
            dispCount++;
            var cnt = cmsCategory[i];

            var keys = getKeys(cnt);

			

            for (n = 0; n < keys.length; n++) {
                var elemID = "#cmsCategory_" + keys[n];

                var tagName = $(elemID).prop("tagName");
				//console.log(tagName);

                if (tagName == "IMG")
                    $(elemID).attr("src", cnt[keys[n]])
                else if (tagName == "A")
                    $(elemID).attr("href", cnt[keys[n]])
                else
                    $(elemID).html(cnt[keys[n]]);
            }

           // $(layout).find("*").removeAttr("id");
            $(layout).find("*").attr("catid", cnt.id);
            $(layout).find("*").attr("target", parentTarget);

            cat = $(layout).html();
            $(target).append(cat);
            $(layout).html(bakLayout);
            if(nCol>0){
                if(dispCount%nCol==0 || cnt.isHighlited=="YES"){
                    $(target).append(separator);
                    if (cnt.isHighlited == "YES")
                        dispCount--;
                }
            }
        }
    }

}

//function loadContent: displays a specified content in a specified target using a specified layout
//adds custom attributes to elements for sending SMS - if loaded from ssd-tech mobile app framework these attributes help sending SMS from native mobile app
function loadContent(data, target, layout, readMore) {

    var cnt = JSON.parse(data);
    var content = "";
    var bakLayout = $(layout).html();

    var keys = getKeys(cnt);

    for (var i = 0; i < keys.length; i++) {
        var elemID = "#cmsContent_" + keys[i];
           
        var tagName = $(elemID).prop("tagName");
        if (tagName == "IMG")
            $(elemID).attr("src", cnt[keys[i]])
        else if (tagName == "A")
            $(elemID).attr("href", cnt[keys[i]])
        else{
            var contentFieldValue = escapeSpecialChar(cnt[keys[i]]); // escapes special character

            if(keys[i] == "details"){ // if content field is details then execute following code block

                if( readMore )
                {
                    /*
                    * Escaping html tags for snippet creation
                    */
                    contentFieldValue = escapeHtmlTag(contentFieldValue);

                    /*
                    * Creating snippets
                    */
                    if( contentFieldValue.length > 300 ){
                        var rxPattern  = new RegExp("^.{" + 300 + "}[^ ]*"); // reg ex pattern finding 300 strings with spaces at last
                        contentFieldValue = rxPattern.exec(contentFieldValue)[0]+"..."; // exec() method tests match in a string and returns the matched string
                    }

                    /*
                    *  readMoreHtml
                    */
                    var readMoreHtml = document.createElement('a');
                    var linkText = document.createTextNode("Read More");
                    readMoreHtml.appendChild(linkText);

                    readMoreHtml.setAttribute('onclick', 'displayContent('+cnt.id+',\''+target+'\',\''+layout+'\',\'ContentID\','+null+');');

                    var contentListLay = document.getElementById('content');
                    readMoreHtml.href = "javascript:void(0);";

                }

                $(elemID).html(contentFieldValue);
            } else {
                
                $(elemID).html(contentFieldValue);
            }

        }
    }

    if(  readMore != null ) // binds after #cmsContent_details defined in category contentListLayout
    {
        $("#cmsContent_details").after(readMoreHtml);
    }

    //$(layout).find("*").removeAttr("id");
   
    $(layout).find("*").attr("content_id", cnt.id);

    $(layout).find("[action=\"sendSMS\"]").attr("smsText", cnt.smsText);
    $(layout).find("[action=\"sendSMS\"]").attr("smsBNO", cnt.smsBNO);
    $(layout).find("[action=\"sendSMS\"]").attr("smsSentMsg", cnt.smsSentMsg);
    $(layout).find("[action=\"sendSMS\"]").attr("smsUnavailableMsg", cnt.smsUnavailableMsg);


    content = $(layout).html();

    $(layout).html(bakLayout);

   // displayLikeDislike(target,cnt);
   // displayComment(target,cnt);

    if(  readMore != null ) // if not readmore append everything
    {
        $(target).append(content+"<div id='contentLikeComment_"+cnt.id+"'></div><div id='contentCommentForm_"+cnt.id+"'></div>");
    }else{
        $(target).html(content+"<div id='contentLikeComment_"+cnt.id+"'></div><div id='contentCommentForm_"+cnt.id+"'></div>"); // if readmore is null then only html output
    }


}





//function handleURLContentData: handles the data received from a content URL and shows it using loadContent function
//this function is used to handle content from external source e.g. news feed, sports update etc.
//Associated with content type URL
function handleURLContentData(data, status) {
    var cnt = JSON.parse(data);
    loadContent(data, cnt.target, cnt.layout);
    $(cnt.target).show();
}

//function displayContent: displays a specific content at a specific target using the function loadContent
//makes ajax call for content type URL and binds the handler handleURLContentData for handling the output
//displayContent is called from displayContentList function mostly. But can be called from other places as well as required

function displayContent(key, target, layout, keyType, readMore) {
    $(target).html('');
    var content = "";
    var i;
    if(keyType==null)
        keyType="ArrayIndex";

    if(keyType=="ArrayIndex"){
        i=key;
    }else if(keyType=="ContentID"){
        for(i=0; i<cmsContent.length; i++)
        {
            if(cmsContent[i].id==key)
                break;
        }
    } else {
        return;
    }

    var phID="content_id_" + cmsContent[i].id;;
    var tmp = JSON.stringify(cmsContent[i]);
    
    
    if (cmsContent[i].type == "URL") {
        content = "<div id=\"" + phID + "\"><div>";
        $(target).append(content);
        $("#" + phID).hide();
        $.get(cmsContent[i].url+"target="+phID+"&layout="+layout.substr(1,100), handleURLContentData);
    }
    else if (cmsContent[i].type == "FORM") {
        loadFormContent(cmsContent[i].id, target, layout);
    }
    else {
        loadContent(tmp, target, layout, readMore);
    }
}

// displayOnlyContentList getting contents without catid field @mahfooz
function displayOnlyContentList( target, layout, numOfContent, readMore ) {
    if(numOfContent==null)
        numOfContent=4;

    $(target).html("");

    for (var i = 0; i < cmsContent.length; i++) {
        if ( cmsContent[i].type != "FORM") {
            displayContent(i, target, layout, "ArrayIndex",readMore);

        }
    }


}

//function displayContent: displays all the contents in a specified category in a specified target using a specified layout
//uses displayContent to display individual contents
//  flow of content display is  displayContentList   ->  displayContent  ->  loadContent (for regular content)
//                                                                       ->  handleURLContentData (for URL feeds)   ->  loadContent
function displayContentList(catid, target, layout, nCol, separator) {
    var dispCount = 0;
    if(nCol==null)
        nColl=0;
    if(separator==null)
        separator="";

    $(target).html("");
    for (var i = 0; i < cmsContent.length; i++) {
        if ( cmsContent[i].catid == catid) {
            //console.log(cmsContent[i].catid);
            dispCount++;
            displayContent(i, target, layout, "ArrayIndex","");
            if(nCol>0){
                if (dispCount % nCol == 0 || cmsContent[i].isHighlited == "YES") {
                    $(target).append(separator);
                    if (cmsContent[i].isHighlited == "YES")
                        dispCount--;
                }
            }
        }
    }

}

//function loadCMSParent: Loads the parent of specified category in the specified target
function loadCMSParent(catID, target) {
    for (var i = 0; i < cmsCategory.length; i++) {
        if (cmsCategory[i].id == catID) {
            loadCMSCategory(cmsCategory[i].parent, target);
            break;
        }
    }
}

//function goBackInTarget: Loads one level up Category in the target
//Identifies loaded category in the target and then loads its parent
function goBackInTarget(target) {
    var targetCat = target.substr(1, 100) + "_CAT_ID";
    var catID = window[targetCat];

    loadCMSParent(catID, target);
}

//function loadCMSCategory: loads a specified category at a specified html target
//calls displayCategoryList and displayContentList to load category list and content list
function loadCMSCategory(catID, target) {
    var catHTML = "";
    var targetCat = target.substr(1,100) + "_CAT_ID"; //without #
    var targetBackID = "#"+$(target).attr("cms_back_id"); //id for the back button

    window[targetCat] = catID; //storing the Category ID in the global variable named <target>_CAT_ID
    if ($(target).attr("cms_root") == catID) {
        $(targetBackID).hide();
    } else
        $(targetBackID).show();


    for (var i = 0; i < cmsCategory.length; i++) {
        if (cmsCategory[i].id == catID) {
            var hidden = "<div style=\"display: none\" id=\"CMS_HIDDEN\"></div>";
            $("#CMS_HIDDEN").remove();
            $("body").append(hidden);

            $("#CMS_HIDDEN").html(cmsCategory[i].catLayout);
            $("#CMS_HIDDEN").append(cmsCategory[i].catListLayout);
            $("#CMS_HIDDEN").append(cmsCategory[i].contentListLayout);
            /*
            displayCategoryList(catID, cmsCategory[i].catListTarget, cmsCategory[i].catListLayoutName, target, cmsCategory[i].columnNo, cmsCategory[i].rowSep);
            displayContentList(catID, cmsCategory[i].contentListTarget, cmsCategory[i].contentListLayoutName, cmsCategory[i].columnNo, cmsCategory[i].rowSep);
            catHTML = $(cmsCategory[i].catLayoutName).html();
             */

            $(target).html("");
            $(target).html(catHTML);
            break;
        }
    }
}


//function initCMS: Initializes CMS by calling getCMSData
//The function hooks the click event to all Category Elements in the html layout.
//It identifies the category elements by selecting the elements having the attribute catid
//  Whenever a category is clicked it calls the function loadCategory
//  Category Loading Seuqence is
//      loadCategory    ->  loadCMSCategory
//
//After cms data is loaded it calls the startFunction that is passed as parameter.
//  It is startFunction's responsibility to do the display of the cms data
//  There are associated functions to load cms data e.g. loadCMSCategory
//
//  CMS Loading Sequence is described below
//      loadCMSCategory ->  displayCategoryList
//                      ->  displayContentList   ->  displayContent  ->  loadContent (for regular content)
//                                                                   ->  handleURLContentData (for URL feeds)   ->  loadContent
//
//After initializing the cms data if keeps calling the getCMSData in every 5 seconds (5000 milisecond)
function initCMS(startFunction)
{
    $(document).on("click", "[catid]", loadCategory);
    getCMSData();

    waitforCMSData=setInterval(function(){
        if(cmsCategoryLoaded==false || cmsContentLoaded==false)
            return;

        clearInterval(waitforCMSData);
        window[startFunction]();
    }, 100);

    //setInterval(getCMSData, 5000); //keep checking for updated data every 5 sec
}


// header @mahfooz
function genereateHeader(id,target)
{
	getJson('',cms_service_url['get_header_footer'], function(data){

        if(data.readyState == 4)
        {
		    var headerFooterHtml = JSON.parse(data.responseText);
            $(id).html(escapeSpecialChar(headerFooterHtml[0].header));
            cmsAuthView(target);
        }
    });
}

// footer @mahfooz
function generateFooter(id)
{

	getJson('',cms_service_url['get_header_footer'], function(data){

        if(data.readyState == 4)
        {
		    var headerFooterHtml = JSON.parse(data.responseText);
            $('#' + id).html(headerFooterHtml[0].footer);
        }
    });

}

/*
 * dynamic Menu By multilevel category
 * @zubayer
 *
 *
 */
function printMenu(id,target){
 getJson('',CMS_CATEGORY_URL, function(data){
        if(data.readyState == 4){
   var catMenu= createTree(JSON.parse(data.response),0);
   var cmsLeftMenu = genTreeHtml(catMenu,1,target);
   $('#' + id).html(cmsLeftMenu);
       }
 });
}

/*
* menuContentLayout
* @Mahfooz
*/
function menuContentLayout(menu){
    var cid = $(menu).attr('data-cid');
    var target = $(menu).attr('data-target');

    loadCMSCategory( cid, target );
}

/*
 * Generate Menu
 * @zubayer
 *
 * data => object
 */
function genTreeHtml(data,menuClass,target){


     var my_html;
    if(menuClass == 1){
         my_html = '<ul class="nav"><li><a href="javascript:void(0)" onclick="location.reload()">Home</a></li>';
    }else{
         my_html = '<ul>';
    }


     $.each(data,function(index,value){
         if(value.isRegisteredCat == 0)
         {        
              if(value.children != undefined){
                 my_html += '<li class="dropdown"><a href="javascript:void(0)" data-cid="'+value.id+'" data-target="'+target+'" onclick="menuContentLayout(this)" >'+value.title+'</a>';
               var children = genTreeHtml(value.children,0,target);
               my_html += children;
            
              }else{
                 my_html += '<li><a href="javascript:void(0)" data-cid="'+value.id+'" data-target="'+target+'" onclick="menuContentLayout(this)" >'+value.title+'</a>';
              }
              my_html +='</li>';
         }                
     });

     
 my_html += '</ul>';
 return my_html;
}

/*   function buildDynamicForm: building dynamic form based on user's entry from cmsPanel
 *   @Mahfooz
 */
function buildDynamicForm(formContentData){

    var contentFormData = JSON.parse(formContentData.formData);
    //console.log(contentFormData);

    //creating dynamic elements
    var cmsformLayout = $("<div id='"+contentFormData.cmsformLayout.substring(1,contentFormData.cmsformLayout.length)+"_"+formContentData.id+"'></div>");
    var statusDiv = $("<div class='success' id='"+contentFormData.statusDiv.substring(1,contentFormData.statusDiv.length)+"_"+formContentData.id+"'></div>");
    var contentFormHeader = $("<div class='form_header' id='"+contentFormData.contentFormHeader.substring(1,contentFormData.contentFormHeader.length)+"_"+formContentData.id+"'></div>");
    var cmsContentAddAction = $("<button type='button' id='"+contentFormData.cmsContentAdd.substring(1,contentFormData.cmsContentAdd.length)+"_"+formContentData.id+"'>Add</button>");
    var cmsContentListAction = $("<button type='button' id='"+contentFormData.cmsContentList.substring(1,contentFormData.cmsContentList.length)+"_"+formContentData.id+"'>List</button>");
    var cmsFormDiv = $("<div class='innerholder' id='"+contentFormData.cmsFormDiv.substring(1,contentFormData.cmsFormDiv.length)+"_"+formContentData.id+"'></div>");
    var cmsContentForm = $("<form  id='"+contentFormData.cmsContentForm.substring(1,contentFormData.cmsContentForm.length)+"_"+formContentData.id+"'></form>");
    var cmsListDiv = $("<div class='innerholder' id='cmsListDiv_"+formContentData.id+"'></div>");
    var contentExtraField = $("<span id='"+contentFormData.contentExtraField.substring(1,contentFormData.contentExtraField.length)+"_"+formContentData.id+"'></span>");
    var contentSubmitButton = $("<button type='button' id='contentSubmitButton_"+formContentData.id+"'>"+contentFormData.contentSubmitButtonText+"</button>");

    //creating form with dynamic elements
    $(cmsformLayout).append(statusDiv);

    if(contentFormData.addAction != null){
        if(contentFormData.addAction == 1){
            $(cmsformLayout).append(cmsContentAddAction);
        }
    }

    if(contentFormData.listAction != null){
        if( contentFormData.listAction == 1 ){
            $(cmsformLayout).append(cmsContentListAction);
        }
    }    
    

    $(cmsformLayout).append(contentFormHeader);
    $(cmsformLayout).append(cmsFormDiv);
    $(cmsFormDiv).append(cmsContentForm);
    $(cmsContentForm).append(contentExtraField);
       
    
    $(cmsContentForm).append(formContentData.details);
    $(cmsContentForm).append(contentSubmitButton);
    $(cmsformLayout).append(cmsListDiv);
    
    $(cmsformLayout).css({"display":"none"});

    return cmsformLayout;
}

/*   function parseGetFormContentData: parse formContentData and return to the method that calls it
 *   @Mahfooz
 */
function parseGetFormContentData(formContentID){

    $.each(cmsContent,function(index,val){
        if( val.id == formContentID ){
          contentFormData = JSON.parse(val.formData);
        }
	});

    return contentFormData;
}

/*   function loadFormContent: displays a specified form content in a specified target using a specified layout
 *   @Mahfooz
 */

function loadFormContent( formContentID, target ){

    $.each(cmsContent,function(index,val){
        if( val.id == formContentID ){
          cmsFormHtml = buildDynamicForm(val);
          title = val.title;
          contentFormData = JSON.parse(val.formData);
        }
	});

     $(target).append(cmsFormHtml);
     $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).prepend("<h2>"+title+"</h2>");
     
    $(document).off("click",contentFormData.cmsContentAdd+"_"+formContentID).on("click", contentFormData.cmsContentAdd+"_"+formContentID, function(event){ // binding click event on add button
      formDisplayAction( target, formContentID , "add", "" , contentFormData.listURL, contentFormData.addEditURL );
    });

    $(document).off("click", contentFormData.cmsContentList+"_"+formContentID ).on("click", contentFormData.cmsContentList+"_"+formContentID, function(event){ // binding click event on list button
        $('.datepicker_recurring_start').datepicker();
      listDisplayAction( target, formContentID, contentFormData.listURL, contentFormData.addEditURL, contentFormData.deleteURL);
    });
    
    $('body').on('focus',target+' .datepicker_start', function(){ 
        $(this).datepicker();      
    }); 
    
    $('body').on('focus',target+' .datepicker_end', function(){ 
        $(this).datepicker();      
    });     
    
   // $('body').on('click','.input_date', function() {
     //   $(target+ this).datepicker('destroy').datepicker({showOn:'focus'}).focus();
   // });       

    $(document).off("click", target+" "+contentFormData.cmsformLayout+"_"+formContentID+" #contentSubmitButton"+"_"+formContentID ).on("click", target+" "+contentFormData.cmsformLayout+"_"+formContentID+" #contentSubmitButton"+"_"+formContentID , function(event){ // binding click event on form submit button

        formData = $(target+" "+contentFormData.cmsContentForm+"_"+formContentID).serialize();

        $.ajax({
		   type: "POST",
		   url: contentFormData.addEditURL,
		   data: formData,
		   dataType: "json",
		   success: function(responseResult){

                $(target+" "+contentFormData.statusDiv+"_"+formContentID).html(responseResult.message);
                $(target+" "+contentFormData.statusDiv+"_"+formContentID).show("slow");
                $(target+" "+contentFormData.statusDiv+"_"+formContentID).prepend("<div class='closeStatus' style='cursor:pointer;float:right;margin-right:10px;'>X</div>");
                $(target+" "+contentFormData.statusDiv+"_"+formContentID+" .closeStatus").click(function(){
                    $(target+" "+contentFormData.statusDiv+"_"+formContentID).slideUp("slow");
                });
		   }
		 });

         return false;
    });
    
  

    //listDisplayAction( target, formContentID );
    if(contentFormData.defaultDisplayAction == "addAction"){
        formDisplayAction(target,formContentID,"add","")
    }

    if(contentFormData.defaultDisplayAction == "listAction"){
      listDisplayAction( target, formContentID );
    }

    $(target).find(contentFormData.cmsformLayout+"_"+formContentID).css("display", "block");

}

//
/*   Add Button Action
 *   @Mahfooz
 */
function formDisplayAction(target,formContentID,type,id)
{
      contentFormData = parseGetFormContentData(formContentID);

      $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find("#cmsListDiv_"+formContentID).css({"display":"none"});
      $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find(contentFormData.cmsFormDiv+"_"+formContentID).css({"display":"block"});

      formView(formContentID,type,id,target);
}

//
/*   List Button Action
 *   @Mahfooz
 */
function listDisplayAction( target, formContentID )
{
      contentFormData = parseGetFormContentData(formContentID);

      $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find("#cmsListDiv_"+formContentID).css({"display": "block"});
      $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find(contentFormData.cmsFormDiv+"_"+formContentID).css({"display":"none"});

      listView(target,formContentID);
}

/*views*/
/*   Form View
 *   @Mahfooz
 */
function formView( formContentID, type, id, target ){

    contentFormData = parseGetFormContentData(formContentID);

    getJson('',contentFormData.listURL, function(data){
    	if( data.readyState == 4 ){

    	var list = JSON.parse(data.response);

        if( type == 'add'){

                generateForm(formContentID,type,id,target,contentFormData);
                var form_fields = getKeys(list[0]);

            	$.each(form_fields,function(index,val){
            	    var c_f = "[name='"+val+"']";

                 if(val != "status"){
                   $(target+" "+contentFormData.cmsFormDiv+"_"+formContentID+" "+c_f).val("");
                }

            	});

    	}
        else
        {
            var details;
            $.each(list,function(index,val){
                if(val.id == id){
                    details = val;
                }
            });

            generateForm(formContentID,type,id,target,contentFormData);

            var form_fields = getKeys(details);

        	$.each(form_fields,function(index,val)
            {

        		var c_f = "[name='"+val+"']";

                if(val == "status"){
                    if(details.status == 1){
                        $(target+" "+contentFormData.cmsFormDiv+"_"+formContentID+" "+c_f).attr("checked","checked");
                        $(target+" "+contentFormData.cmsFormDiv+"_"+formContentID+" "+c_f).attr("onclick","toggleCheck('"+target+"', '"+contentFormData.cmsFormDiv+"', '"+formContentID+"', '"+val+"')");
                    }
                }
                else{
                     var value = escapeSpecialChar(details[val]);
        		     $(target+" "+contentFormData.cmsFormDiv+"_"+formContentID+" "+c_f).val(value);
                }
        	});

    	}

    		}
    	});

	function generateForm(formContentID,type,id,target,contentFormData){

        var formHtml ='' ;
		var extra_field ='' ;

        if(type == 'edit'){
			   extra_field = '<input type="hidden" name="id" value="'+id+'">';
			}else{
			   extra_field  = ' ';
		}

        formTitle = type.toUpperCase();

        $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find(contentFormData.contentFormHeader+"_"+formContentID).html(formTitle);
        $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find(contentFormData.contentExtraField+"_"+formContentID).html(extra_field);
	}
}

/*
*  function toggleCheck() checks or unchecks checked attribute according to the status click
*/
function toggleCheck(target,formDiv,contentID,val){

    c_f = "[name='"+val+"']";
    var statusTarget = target+" "+formDiv+"_"+contentID+" "+c_f;

    if($(statusTarget).prop('checked'))
        $(statusTarget).removeAttr("checked");
    else
        $(statusTarget).attr("checked","checked");
}

/*views*/
//
/*   List View
 *   @Mahfooz
 */
function listView(target,formContentID){

        contentFormData = parseGetFormContentData(formContentID);

		getJson('',contentFormData.listURL, function(data){
			if(data.readyState ==4){
				var list = JSON.parse(data.response);

                    formTitle = "List";

                    $(target+" "+contentFormData.cmsformLayout+"_"+formContentID).find(contentFormData.contentFormHeader+"_"+formContentID).html(formTitle);

                    var fields = getKeys(list[0]);

                    $(target+" #cmsListDiv_"+formContentID).html('');
                    
                    $(target+" #cmsListDiv_"+formContentID).append("<div id='cmsListForm_"+formContentID+"'></div>");
                    //$("<div id='cmsListForm_"+formContentData.id+"'></div>");

                    //var rangeStartFilter = "Start Date: <input type='text' class='datepicker_recurring_start' id='startDate_"+formContentID+"' name='startDate_"+formContentID+"' >";
                    //var rangeEndFilter = "End Date: <input type='text' name='endDate_"+formContentID+"' id='endDate_"+formContentID+"' >";
                    
                    
                    
                    if(contentFormData.rangeFilter != null){
                        if( contentFormData.rangeFilter == 1 ){
                            var rangeFilterHtml = $("#rangeFilter").html();
                            $(target+" #cmsListForm_"+formContentID).append(rangeFilterHtml);                                                                    
                        }    
                    }
                    
                    //console.log(contentFormData.additionalUrls);
                    
                    if(contentFormData.additionalUrls != ""){
                       
                        var addtionalUrls = contentFormData.additionalUrls;
                        var extractUrls = addtionalUrls.split(",");
                                                
                         $.each(extractUrls,function(index,additionalUrl){
                               //console.log(additionalUrl);                             
                               if(additionalUrl != ""){ 
                                    getJson('',additionalUrl, function(data){
                                       if(data.readyState == 4){
                                            $(target+" #cmsListForm_"+formContentID).append(data.response+"<div style='clear:both;'></div>");     
                                        }                        
                                    });
                                }
                        });
                    }                     
                    
                    
                    var table = $("<table class='hovertable'></table>");
                    $(target+" #cmsListDiv_"+formContentID).append(table);


                    if(list.length > 0)
                    {
                        var listHeadHtml;
                        listHeadHtml+= "<tr>";
                        for (var i = 0; i < fields.length; i++) {
                          listHeadHtml+= "<th>"+fields[i]+"</th>";
                        }
                        if( (contentFormData.editAction == 1) || (contentFormData.deleteAction == 1)  ){
                            listHeadHtml+= "<th>Action</th>";
                        }
                        listHeadHtml+= "</tr>";

                        var listBodyHtml;

                        for (var i = 0; i < list.length; i++) {

                          id = list[i].id;

                          listBodyHtml+= "<tr>";

                            for (var j = 0; j < fields.length; j++) {
                                field = fields[j];
                                listBodyHtml+= "<td>"+list[i][field]+"</td>";
                            }

                          // edit delete action links
                          if( (contentFormData.editAction == 1) || (contentFormData.deleteAction == 1)  ){
                              listBodyHtml+= '<td>';
                              if( contentFormData.editAction == 1 ){
                                listBodyHtml+='<a href="javascript:void(0);" onclick=\"formDisplayAction(\''+ target +'\','+ formContentID +',\'edit\',\''+ id +'\')\" >Edit</a> ';
                              }
                              if( contentFormData.deleteAction == 1 ){
                                listBodyHtml+=' <a href="javascript:void(0);" id=\"'+id+'\" onclick=\"deleteContent(\''+ target +'\','+ formContentID +',\''+ id +'\')\">Delete</a>';
                              }
                              listBodyHtml+= '</td>';
                          }

                          listBodyHtml+= "</tr>";
                        }


                        table.append(listHeadHtml);
                        table.append(listBodyHtml);
                 }
                 else
                 {
                    var listHeadHtml;
                    listHeadHtml+= "<tr><th>There is no Data</th></tr>";
                    table.append(listHeadHtml);
                 }


			}
		});

}

/*
 *   function delete service call triggers for form content delete
 *   @Mahfooz
 */
function deleteContent(target,formContentID,id){

    contentFormData = parseGetFormContentData(formContentID);

    var confimation = confirm('Are you sure ?');
    	if(confimation == true){

        $(target+" #cmsListDiv_"+formContentID+" a[id='"+id+"']").closest("tr").slideUp();

    	var delete_id = 'id='+id;
    	 getJson(delete_id, contentFormData.deleteURL,function(data){
    		 if(data.readyState == 4){
    		 }
    	 })
     }
}

/*
 * function: cms content view for add/edit resused from cmsPanel.js
 *  @mahfooz
*/
function contentView(target,type,id){
    //$(".success").hide("slow");
	if( type == 'add'){

          generateContentForm(type,id,cmsCategory);

          var cms_auth = checkSession('cms_auth');
          var userInfo = JSON.parse(cms_auth);

          var c_f = "[name='userId']";
          $(c_f).val(userInfo[0].id);

	}else
    {

            var catList = cmsCategory;

			getJson('',CMS_CONTENT_URL, function(data){
				if(data.readyState == 4){

                    var contentList = JSON.parse(data.response);

                    var content_details;
                    $.each(contentList,function(index,val){
                        if(val.id == id){
                            content_details = val;
                        }
                    });

                    generateContentForm(type,id,catList);

                    var content_form_fields = ['catid','title','details','url','status','userId'];

                    $.each(content_form_fields,function(index,val){

						var c_f = "[name='"+val+"']";

                        if(val == "status"){
                            if(content_details.status == 1){
                                $(c_f).attr("checked","checked");
                            }
                        }else if(val == "url"){
                            if(content_details.url != ""){
                                var img;
                                img = "<img src='"+ cms_url['get_cms_url']+content_details.url +"'>"
                                $("#contentimgSource").html(img);
                            }
                        }
                        else{
                             var value = escapeSpecialChar(content_details[val]);
						     $(c_f).val(value);
                        }
					});
				}
			}); // end of content list callback

	}

	function generateContentForm(type,id,catData){
		var formHtml ='' ;
		var extra_field ='' ;
		if(type == 'edit'){
			   extra_field = '<input type="hidden" name="cid" value="'+id+'">';
			}

		//cat options
        var treeData = createTree(catData,0);
        var treeHtml = treeListForSelect(treeData,0);
        var catOptions = '<select name="catid" >';
		catOptions+= '<option value="0">------</option>'+treeHtml;
        catOptions += '</select>';

        formTitle = '<h1 class="title">'+type.toUpperCase()+' CONTENT</h1>';
        formSubmitButton = "<button class=\"blackbutton\" type=\"button\" onclick=\"contentController('"+type+"','"+id+"')\">SUBMIT</button>";
        catDetailTitle = catOptions;

        $('#contentFormDiv').find("#content_form_header").html(formTitle);
        $('#contentFormDiv').find("#content_category").html(catDetailTitle);
        $('#contentFormDiv').find("#content_extra_field").html(extra_field);
        $('#contentFormDiv').find("#contentSubmitButton").html(formSubmitButton);

        formHtml = $('#contentFormDiv').html();

        $(target).append(formHtml);
	}

}

//content controller resused from cmsPanel.js
// @mahfooz

function contentController(type,id){
	postFormData('contentForm', cms_service_url['new_content_url'], function(data){
		if(data.readyState == 4){

           	var responseResult = JSON.parse(data.responseText);

            $("#statusDiv").html(responseResult.message);
            $(".success").show("slow");
            $(".success").prepend("<div class='closeStatus' style='cursor:pointer;float:right;margin-right:10px;'>X</div>");
            $(".closeStatus").click(function(){
                $(".success").slideUp("slow");
            });

           if(responseResult.success == 1){
			 //contentView('content','add');
           }

		}
	});
}

/*views*/
//
/*   user content List View
 *   @Mahfooz
 */
function contentlistView(target){


getJson('',CMS_CONTENT_URL, function(data){
	if(data.readyState == 4)
    {
        var cms_auth = checkSession('cms_auth');


        var list = JSON.parse(data.response);
        var listHtml;

        var userInfo = JSON.parse(cms_auth);

        var title = "<h1>List</h1>";

        var fields = getKeys(list[0]);

        $(target).append(title);
        $(target).append('<table class="hovertable"></table>');

        var table = $(target).find("table");

        var contentFields = ['id','title','status','date'];

        if(list.length > 0)
        {
            var listHeadHtml;
            listHeadHtml+= "<tr>";
            for (var i = 0; i < contentFields.length; i++) {
                listHeadHtml+= "<th>"+contentFields[i]+"</th>";
            }
            listHeadHtml+= "<th>Action</th></tr>";

            var listBodyHtml;

            for (var i = 0; i < list.length; i++) {

              if(userInfo[0].id == list[i].userId )
              {
                  id = list[i].id;

                  listBodyHtml+= "<tr>";
                    for (var j = 0; j < contentFields.length; j++) {
                            field = contentFields[j];
                            listBodyHtml+= "<td>"+list[i][field]+"</td>";
                    }

                  listBodyHtml+= '<td><a href="javascript:void(0);" onclick=\"userContents(\''+ target +'\',\'edit\',\''+ id +'\')\" >Edit</a> - ';
                  listBodyHtml+='<a href="javascript:void(0);" id=\"'+id+'\" onclick=\"contentDelete(\''+ target +'\',\''+ list[i].cid +'\')\"\">Delete</a>';
                  listBodyHtml+= "</td></tr>";
              }

            }


            table.append(listHeadHtml);
            table.append(listBodyHtml);

         }
         else
         {
            var listHeadHtml;
            listHeadHtml+= "<tr><th>There is no Data</th></tr>";
            table.append(listHeadHtml);
         }

     }

    });

}

/*
 * contentDelete resused from cmsPanel.js
 * @mahfooz
 */
function contentDelete(target,id){
	var confimation = confirm('Are you sure ?');
	if(confimation == true){

       $(target+" a[id='"+id+"']").closest("tr").slideUp();

    	var delete_id = 'id='+id;

    	 getJson(delete_id,cms_service_url['delete_content_url'],function(data){
    	   if(data.readyState == 4){
    		 }
    	 })

	}
}

/*   userContents crud
 *   @Mahfooz
 */
function userContents(target,type,id){
    $(target).html("");
    $(target).append('<button type="button" onclick="userContents(\''+ target +'\',\'add\',\'\')" >Add</button>');
    $(target).append('<button type="button" onclick="userContents(\''+ target +'\',\'list\',\'\')" >List</button>');

    if( type == 'list' ){
        contentlistView(target);
    }else{
        contentView(target,type,id);
    }
}

/* ###################
*  Zubayer's sction
*/

//user login @ zubayer


function cmsLogout(redirect_url) {
    $.each(sessionStorage, function (ind, val) {
        destroySession(ind);
    })
	
	redirect_to(redirect_url)
}

//user cmsLoginView @ zubayer
function cmsLoginView(target){
	
	var cms_auth = checkSession('cms_auth');
	if (cms_auth == null) {
        var view_data = $('#loginDirective').html();
    	$(target).empty().html(view_data);
	} 
	
}

function cmsLoginController(target,formId){
	var validate = validate_form(target,formId);
	if(validate == true){
		var validation_status = is_form_valid(target,formId);

	}

	if(validation_status == false){
    	var cms_auth = checkSession('cms_auth');
    	if(cms_auth == null){
    		postFormData('cmsLoginForm',cms_service_url['cmsLogin'],function(data){
    			if(data.readyState == 4){ 
    			 
                    loginResult = JSON.parse(data.response);
    			                        
    				if(loginResult.loginStatus.success == 0){   					
                        serviceMessageView(loginResult.loginStatus.message);
    				}else{
    				    
    					 setSession(JSON.stringify(loginResult.userInfo),'cms_auth');
                        serviceMessageView(loginResult.loginStatus.message);
    					cmsAuthView(target);
                        /*
                        // iterate through category for registered category status = 1. 
                        $.each(cmsCategory,function(index,catVal){            
                            if( catVal.isRegisteredCat == 1){
                                loadCMSCategory( catVal.id, target );                                
                            }
                        });   
                        */

    				}
                    
    			}
    		});
    	}
    }
}
//cmsAuthView @ zubayer
function cmsAuthView(){
    //destroySession('cms_auth');
	var cms_auth = checkSession('cms_auth');
	if(cms_auth != null){
	    var logged_data = JSON.parse(cms_auth);
	    $("#auth_username").html(logged_data.name);
	    $("#auth_user_uid").html(logged_data.uid);
	} 
}

//user registrationView @ zubayer
function  cmsRegistrationView(type){
	var view_data = $('#registrationDirective').html();
    target = "#cmsData";
	$("#cmsData").empty().html(view_data);
	if(type == 'edit'){
		var cms_auth = checkSession('cms_auth');
		var auth_details = JSON.parse(cms_auth);
		var edit_id = '<input type="hidden" name="id" value="'+auth_details[0].id+'">';
		$("#cmsRegistrationForm").append(edit_id);
		var form_fields = ['name','address','phone','username'];
		$.each(form_fields,function(ind,val){
			$("input[name='"+val+"']").val(auth_details[0][val]);
		});

      $(target).prepend("<button type='button' onclick=\"userContents('"+target+"','list')\">Content List</button>");
	}
}
//cmsRegistraionController @zubayer
function cmsRegistraionController(target,formId){

	var validate = validate_form(target,formId);
	if(validate == true){
		var validation_status = is_form_valid(target,formId);

	}

	if(validation_status == false){

	postFormData('cmsRegistrationForm',cms_service_url['add_user'],function(data){
		if(data.readyState == 4){
		  
            regResult = JSON.parse(data.response);
		                        
			if(regResult.regStatus.success == 0){   					
                serviceMessageView(regResult.regStatus.message);
			}else{
                 serviceMessageView(regResult.regStatus.message);                
			}   
                   
		//	var res_data = JSON.parse(data.response);
		//	serviceMessageView(res_data.message);
			
           // var cms_auth = checkSession('cms_auth');
			
           /* if(cms_auth != null){
				var auth_details = JSON.parse(cms_auth);
				getJson('id='+auth_details[0].id, cms_service_url['get_user'], function(data){
					if(data.readyState == 4){
						destroySession('cms_auth');
						setSession(data.responseText,'cms_auth');
                        cmsLoginView(target);
					}
				});
			} */
            
		}
	});

    }
}



// #########  Session storage Handler

//set Session @zubayer
function setSession(data,set_to){
	sessionStorage.setItem(set_to,data);
}
//check session @zubayer
function checkSession(session_var){
	return sessionStorage.getItem(session_var);
}
//destroy sesssio @zubayer
function destroySession(destroybale_var){
	sessionStorage.removeItem(destroybale_var);
}


// ########## Global form handler
/*
* postFormData @zubayer
*
* #implementation var id -> form_id var service_url -> web serive end point var
* callBack -> is a method ( for a functio testCallBack(), just input
* testCallBack) #example postFormData('form_id','serviceUrl',testCallBack);
*/
function postFormData(id, service_url, callBack) {
	var formData = new FormData(document.getElementById(id));
	var xhr = new XMLHttpRequest();
	xhr.open('POST', service_url, true);
	xhr.send(formData);
	xhr.onreadystatechange = function() {
	callBack(xhr);
	};
}

function getJson(data, service_url, callBack) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', service_url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data);
	xhr.onreadystatechange = function () {
		callBack(xhr);
	};
}

//serviceMessageView @zubayer
function serviceMessageView(message){
	$("#statusDiv").empty().html(message);
	$(".success").show();
	$(".success").prepend("<div class='closeStatus' style='cursor:pointer;float:right;margin-right:10px;'>X</div>");
	$(".closeStatus").click(function(){
	    $(".success").slideUp();
	});

}
function serviceMessageDestroy() {
    $(".success").slideUp();
}



//integer @zubayer

//javascript datepicker 
// Mahfooz
var monthtext=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

function date_populate(dayfield, monthfield, yearfield){
    
    var today=new Date();
    var dayfield=document.getElementById(dayfield)
    var monthfield=document.getElementById(monthfield)
    var yearfield=document.getElementById(yearfield)
    
    for (var i=0; i<31; i++)
        dayfield.options[i]=new Option(i+1, i+1)
    dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) //select today's day
    
    for (var m=0; m<12; m++)
        monthfield.options[m]=new Option(monthtext[m], monthtext[m])
    monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
    
    var thisyear=today.getFullYear()
    for (var y=0; y<100; y++){
        yearfield.options[y]=new Option(thisyear, thisyear)
        thisyear-=1
    }
    yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}

function redirect_to(target_url) {
    window.location.replace(target_url);
}

/* auto complete @ belal+zubayer*/
function generateDefaultSuggestionData(autocomplete_url, field_selector, suggestion_data_index, condition_index, condition_matching_value) {

    $.ajax(
    {
        url: autocomplete_url,
    }).done(function (data) {

        var autocomplete_data = data.split("\n");
        if (autocomplete_data[condition_index] == condition_matching_value) {

            $(field_selector).attr("list", "suggestion");
            $(field_selector).after().append('<datalist id="suggestion"></datalist>');

            for (var j = 3; j < autocomplete_data.length; j++) {
                var suggestion_data = autocomplete_data[j].split("|");
                var option = document.createElement('option');
                option.value = suggestion_data[suggestion_data_index];
                $('#suggestion').append(option);
            }

        }
    })
}





/*
* service return to field:value
* @zubayer
*/

function createFieldValuePair(dataAsArray, field_array_location, row_start_location) {
    var field_array_pair = new Array();
    var field_value = new Object();
    var fields =  dataAsArray[field_array_location].split('|');
        
    for (var i = row_start_location; i < dataAsArray.length; i++) {
        var row_values = dataAsArray[i].split('|')
        $.each(fields, function (index, value) {
            field_value[value] = row_values[index];
        });
        field_array_pair.push(field_value);
    } 
    return field_array_pair;
}

/*process layout 
    header_loaction,auth_menu_location,footer_loation
*/
function processLayout(params) {
    
    getJson('', cms_service_url['get_header_footer'], function (data) {

        if (data.readyState == 4) {
            var headerFooterHtml = JSON.parse(data.responseText);

            $(params.header_location).html(escapeSpecialChar(headerFooterHtml[0].header));
            $(params.footer_location).html(escapeSpecialChar(headerFooterHtml[0].footer));

            // auth processor 
            var cms_auth = checkSession('cms_auth');
            if (cms_auth != null) {
                $(params.auth_menu_location).html(escapeSpecialChar(headerFooterHtml[0].auth_menu));
                //cmsAuthView();
            }
           //  cmsAuthView(target);
        }
    });
}