
var HTTP_GET = {};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function() {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    HTTP_GET[decode(arguments[1])] = decode(arguments[2]);
});

function getRandomNo(start, end) {
    var range = end - start + 1;

    var n = Math.floor(Math.random() * range) + start;

    return n;
}

function getKeys(obj) {
    var keys = [];
    for (var key in obj) {
        keys.push(key);
    }
    return keys;
}



Number.prototype.formatComma = function(c) {
    var d = '.', t = ',';
    var n = this,

    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

// escape special char @Mahfooz
function escapeSpecialChar(value){
    if(value != undefined){
         value = value.replace(/\\'/g, "'");
        return value;  
    }
                                                                               
}

// escape Html tag @Mahfooz
function escapeHtmlTag(htmlValue){
     if(htmlValue != undefined){
         value = htmlValue.replace(/(<([^>]+)>)/ig,"");
         return value;
     }
}

// counting words of string @mahfooz

function countWords(str) {

    var count = 0;
    for ( var i = 1; i <= str.length; i++) {
       if (str.charAt(i) == " ") {
            count ++;
        }
    }
    return count + 1;
}

/*
 * create treeListForSlect
 * @zubayer
 */
function treeListForSelect(data,level){
 var dashes ='';
 for(i = 0; i<level;i++){
  dashes +='-';
 }
 var my_html = '';
 $.each(data,function(index,value){
  my_html += '<option value="'+value.id+'">'+dashes+value.title+'</option>';
        if(value.children != undefined){
   var children = treeListForSelect(value.children,level+1);
   if(children != undefined){
    my_html += children;  
   }
   
  }
 });
 
 return my_html;
}

/*
 * create tree
 * @zubayer
 * 
 * data -> object
 * parent -> integer
 * 
 */
function createTree(data,parent) {
 var tree = new Array();
 $.each(data,function(index,value) {
  if (value['parent'] == parent) {
   var children = createTree(data,parseInt(value.id));
   if (children.length > 0) {
    value['children'] = children;
   }
   tree.push(value);
  }
 });
 return tree;
}

/*
 * getJson @zubayer
 *
 * #implementation
 *
 * var data = array/string/null you need to post var service_url = service end
 * point var callBack = callBack() method's name #example
 * getJson(data,service_url,callBack)
 *
 */
function getJson(data, service_url, callBack) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', service_url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data);
	xhr.onreadystatechange = function () {
		callBack(xhr);
	};
}

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
