// boots all thing after document ready
$(document).ready(function() {
	// heaeder
	genereateHeader('header');

   // footer
	generateFooter('footer');

	// toogle menu
	$("#toggle1").click(function() {
		$("#submenu2").slideUp();
		$("#submenu1").slideToggle(400);

	});

	$("#toggle2").click(function() {
		$("#submenu1").slideUp();
		$("#submenu2").slideToggle(400);
	});

	//init page
	var auth_status = isAuth();

	if(auth_status != null){
		$(".leftbody").show();
		$(".rightbody").show();
		categoryView('content','add','');
		generateLeftMenu('leftbar');
		$("#login_holder").css({display:'none'});
	}else{
		$(".leftbody").hide();
		$(".rightbody").hide()
		loginView('login_holder','login_directory');
	}

});

/*controller*/

//categoryController @zubayer
function categoryController(type,id){

	postFormData('categoryForm', service_url['new_category_url'], function(data){
		if(data.readyState == 4){
           	var responseResult = JSON.parse(data.responseText);
            $("#statusDiv").html(responseResult.message);
            $(".success").show("slow");
            $(".success").prepend("<div class='closeStatus' style='cursor:pointer;float:right;margin-right:10px;'>X</div>");
            $(".closeStatus").click(function(){
                $(".success").slideUp("slow");
            });

           if(responseResult.success == 1){
			categoryView('content','add');
			generateLeftMenu('leftbar');
           }

		}
	});
}

//content controller @zubayer
function contentController(type,id,catId){
	postFormData('contentForm', service_url['new_content_url'], function(data){
		if(data.readyState == 4){

           	var responseResult = JSON.parse(data.responseText);

            $("#statusDiv").html(responseResult.message);
            $(".success").show("slow");
            $(".success").prepend("<div class='closeStatus' style='cursor:pointer;float:right;margin-right:10px;'>X</div>");
            $(".closeStatus").click(function(){
                $(".success").slideUp("slow");
            });

           if(responseResult.success == 1){
			contentView('content','add',catId);
			generateLeftMenu('leftbar');
           }

		}
	});
}

//layoutController @mahfooj
function layoutController(type,id,catId){
	postFormData('layoutForm', service_url['edit_header_footer'], function(data){
		if(data.readyState == 4){
		    $("#statusDiv").html(data.responseText);
            $(".success").show("slow");
			layoutView('content');

            setTimeout(function () {
                $(".success").hide("slow")
            }, 4000);
        }
	});
}
//loginController @zubayer
function loginController(){
	var validate = validate_form('loginForm');
	if(validate == true){
		var validation_status = is_form_valid('loginForm');

	}

	if(validation_status == false){
		postFormData('loginForm',service_url['login'] , function(data){
			if(data.readyState == 4){
				if(data.response != false){
					login(data.response)
				}else{
					alert('Username and password does not match.');
				}
			}
		});
	}
}



/*views*/
//loginView @zubayer
function loginView(targetElementId,data_id){
	var login_form = $("#"+data_id).html();
	$("#"+targetElementId).html(login_form);
}

//categoryView
function categoryView(targetElementId,type,id){
    //$(".success").hide("slow");
	if( type == 'add'){
		//console.log(type);
		getJson('',service_url['get_category_url'], function(data){
			if(data.readyState == 4){
				var catList = JSON.parse(data.response);
				generateCatForm(type,id,catList,'');
			}
		});
	}else{
		getJson('',service_url['get_category_url'], function(data){
			if(data.readyState ==4){

				var catList = JSON.parse(data.response);
				generateCatForm(type,id,catList);

                var details;
                $.each(catList,function(index,val){
                    if(val.tbid == id){
                        details = val;
                    }
                });
				//var details = JSON.parse(catList[i]]);
                //details
                //console.log(details.titleThumb);
                var cat_form_fields = ['parent','title','titleThumb','catLayout','catLayoutName','catListTarget','catListLayout','catListLayoutName','contentListTarget','contentListLayout','contentListLayoutName','rowSep','columnNo','status'];
				$.each(cat_form_fields,function(index,val){
				    //console.log(val);
					var c_f = "[name='"+val+"']";

                    if(val == "status"){
                        if(details.status == 1){
                            $(c_f).attr("checked","checked");
                        }else{                             
                                        if($(c_f).prop('checked')){
                                            $(c_f).removeAttr("checked");
                                        }                                                                                    
                        }
                    }else if(val == "titleThumb"){
                        if(details.titleThumb != ""){
                            var img;
                            img = "<img src='"+ cms_url['get_cms_url']+details.titleThumb +"'>"
                            $("#catimgSource").html(img);
                        }
                    }
                    else{
                         var value = escapeSpecialChar(details[val]);
					     $(c_f).val(value);
                    }
				});
			}
		});
	}

	function generateCatForm(type,id,catData,details){
		var formHtml ='' ;
		var extra_field ='' ;
		if(type == 'edit'){
			   extra_field = '<input type="hidden" name="tbid" value="'+id+'">';
			}else{
			   extra_field  = ' ';
		}
		//cat options
        var treeData = catTree(catData,0);
        var treeHtml = treeListForSelect(treeData,0);
        var catOptions = '<select name="parent" >';
		catOptions+= '<option value="0">------</option>'+treeHtml;
        catOptions += '</select>';

        formTitle = '<h1 class="title">'+type.toUpperCase()+' CATEGORY</h1>';
        formSubmitButton = "<button class=\"blackbutton\" type=\"button\" onclick=\"categoryController('"+type+"','"+id+"')\">SUBMIT</button>";

        $('#categoryFormDiv').find("#category_form_header").html(formTitle);
        $('#categoryFormDiv').find("#parent").html(catOptions);
        $('#categoryFormDiv').find("#category_extra_field").html(extra_field);
        $('#categoryFormDiv').find("#categorySubmitButton").html(formSubmitButton);

        formHtml = $('#categoryFormDiv').html();

		$('#'+targetElementId).empty().html(formHtml);
	}

   //approve permission

	var my_details = JSON.parse(checkSesssion('is_auth'));
    var my_permissions = JSON.parse(my_details[0].permissions);
    if(my_permissions.category['approve'] == undefined){
    	$('#categoryForm #approve_holder').remove();
    }


}
    //content view
    function contentView(targetElementId,type,catId,id){
        //$(".success").hide("slow");
    	if( type == 'add'){

				getJson('',service_url['get_category_url'], function(data){
					if(data.readyState == 4){

                        var catList = JSON.parse(data.response);

                        var details;
                        $.each(catList,function(index,val){
                            if(val.tbid == catId){
                                details = val;
                            }
                        });

                        generateContentForm(type,id,catId,details);
                    }
                });

    	}else
        {

        	getJson('',service_url['get_category_url'], function(data){
        		if(data.readyState == 4){

                    var catList = JSON.parse(data.response);

                    var category_details;
                    $.each(catList,function(index,val){
                        if(val.tbid == catId){
                            category_details = val;
                        }
                    });



				getJson('',service_url['get_content_url'], function(data){
					if(data.readyState == 4){

                        var contentList = JSON.parse(data.response);
                        //console.log(contentList);

                        var content_details;
                        $.each(contentList,function(index,val){
                            if(val.cid == id){
                                content_details = val;
                            }
                        });

                        generateContentForm(type,id,catId,category_details);

                        // for content type Processing
                        if( content_details.type == "FORM" )
                        {
                            switchContentType("FORM","#content");

                            var form_fields = ["cmsformLayout","statusDiv","cmsContentAdd","cmsContentList","contentFormHeader","cmsFormDiv","cmsContentForm","addEditURL","deleteURL","listURL","contentExtraField","contentSubmitButton","contentSubmitButtonText","addAction","editAction","listAction","deleteAction","defaultDisplayAction"];

                            var contentFormData = JSON.parse(content_details.formData);

                            $.each(form_fields,function(findex,fval){

    							 var c_f = "[name='"+fval+"']";
                                                                  
                                if( (fval == "addAction") || (fval == "editAction") || (fval == 'listAction') || (fval == 'deleteAction')  ){ 
                                    //console.log(fval+" "+contentFormData[fval]);
                                    if(contentFormData[fval] == 1){                                        
                                        $(c_f).attr("checked","checked");
                                    }else{                                        
                                        if($(c_f).prop('checked')){
                                            $(c_f).removeAttr("checked");
                                        }                                                                                    
                                    }
                                }else{      
                                     var value = escapeSpecialChar(contentFormData[fval]);   
    							     $(c_f).val(value);
                                }
                                 
    						});
                        }

                        var content_form_fields = ['title','details','type','rowSep','columnNo','url','allow_like','allow_comment','status'];

                        $.each(content_form_fields,function(index,val){
						    //console.log(val);
							var c_f = "[name='"+val+"']";

                            if(val == "status"){
                                if(content_details.status == 1){
                                    $(c_f).attr("checked","checked");
                                }else{                                        
                                        if($(c_f).prop('checked')){
                                            $(c_f).removeAttr("checked");
                                        }                                                                                    
                                    }
                            }else if(val == 'allow_like'){
                            	if(content_details.allow_like == 1){
                                    $(c_f).attr("checked","checked");
                                }else{                                        
                                        if($(c_f).prop('checked')){
                                            $(c_f).removeAttr("checked");
                                        }                                                                                    
                                    }
                            }else if(val == 'allow_comment'){
                            	if(content_details.allow_comment == 1){
                                    $(c_f).attr("checked","checked");
                                }else{                                        
                                        if($(c_f).prop('checked')){
                                            $(c_f).removeAttr("checked");
                                        }                                                                                    
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
            });   // end of category list callback

    	}

    	function generateContentForm(type,id,catId,catDetails){
    		var formHtml ='' ;
    		var extra_field ='' ;
    		if(type == 'edit'){
    			   extra_field = '<input type="hidden" name="cid" value="'+id+'">';
                   extra_field+= '<input type="hidden" name="catid" value="'+catId+'">';
    			}else{
    			   extra_field  = '<input type="hidden" name="catid" value="'+catId+'">';
    		}

            formTitle = '<h1 class="title">'+type.toUpperCase()+' CONTENT</h1>';
            formSubmitButton = "<button class=\"blackbutton\" type=\"button\" onclick=\"contentController('"+type+"','"+id+"','"+catId+"')\">SUBMIT</button>";
            catDetailTitle = catDetails.title;

            $('#contentFormDiv').find("#content_form_header").html(formTitle);
            $('#contentFormDiv').find("#content_category").html(catDetailTitle);
            $('#contentFormDiv').find("#content_extra_field").html(extra_field);
            $('#contentFormDiv').find("#contentSubmitButton").html(formSubmitButton);

            formHtml = $('#contentFormDiv').html();

            $('#'+targetElementId).empty().html(formHtml);
    	}

    	var my_details = JSON.parse(checkSesssion('is_auth'));
        var my_permissions = JSON.parse(my_details[0].permissions);
        if(my_permissions.contents['approve'] == undefined){
        	$('#contentForm #approve_holder').remove();
        }
    }

    /*
    *  content type switching action
    *  @mahfooz
    */
    function switchContentType(contentType,target){

			if(contentType == 'FORM'){
			  $(target+' #typeText').hide();
			  $(target+' #typeForm').show();
			}
			else {
			  $(target+' #typeForm').hide();
			  $(target+' #typeText').show();
			}
    }

    //layout view
    function layoutView(targetElementId){

        	getJson('',service_url['get_header_footer'], function(data){
        		if(data.readyState == 4){

                        var layoutDetails = JSON.parse(data.response);

                        generateLayoutForm(layoutDetails);

                        var layout_form_fields = ['header','footer'];

                        $.each(layout_form_fields,function(index,val){
						    //console.log(val);
							var c_f = "[name='"+val+"']";
                            if( !$.isEmptyObject(layoutDetails) ){
                                $(c_f).val(escapeSpecialChar(layoutDetails[0][val]));
                            }

						});
                }
            });   // end of category list callback



    	function generateLayoutForm(layoutDetails){
    		var formHtml ='' ;
    		var extra_field ='' ;

            if( $.isEmptyObject(layoutDetails) )
                id = ''
            else
               id = layoutDetails[0].id;

		   extra_field = '<input type="hidden" name="id" value="'+id+'">';

            formTitle = '<h1 class="title">Manage Layout</h1>';
            formSubmitButton = "<button class=\"blackbutton\" type=\"button\" onclick=\"layoutController('"+id+"')\">SUBMIT</button>";


            $('#layoutFormDiv').find("#layout_form_header").html(formTitle);
            $('#layoutFormDiv').find("#layout_extra_field").html(extra_field);
            $('#layoutFormDiv').find("#layoutSubmitButton").html(formSubmitButton);

            formHtml = $('#layoutFormDiv').html();

    		$('#'+targetElementId).empty().html(formHtml);
    	}
    }

 /*
  * userView
  * @zubayer
  */
 function  userView(tagrgetElementID,sourceId,type,id){
	 var user_form = $("#"+sourceId).html();
	 $("#"+tagrgetElementID).html(user_form);
	 //get permission list
	 getJson('', service_url['get_permission_list'] , function(data){
		if(data.readyState == 4){
			var permission_list = JSON.parse(data.response);
			var p_html = '<ul>';
			$.each(permission_list,function(index,value){
				//actions

				var m_actions = value.module_actions;
				var action_array = m_actions.split(",");


				if(parseInt(action_array.length) >= 1){
					var my_actions = '';
					$.each(action_array,function(ind,val){
						if(val != ""){
							my_actions += '<li><input type="checkbox" name="module#'+value.module_name+'#action#'+val+'" value="'+val+'">'+val+'</li>';
						}
					});
					if(my_actions != ''){
						p_html += '<li><input type="checkbox" name="module#'+value.module_name+'" value="'+value.module_name+'">'+value.module_name+'<ul>'+my_actions+'</ul></li>'
					}else{

					}

				}
				//module

			});
			p_html += '</ul>'

			$("#permission_block").html(p_html);




        	 //addForm

        	 if(type == 'add'){
        		 $("#userFormHeader").html('<h1 class="title">Add User</h1>');

        	 }
        	 //editForm
        	 else {
        		 $("#userFormHeader").html('<h1 class="title">Edit User</h1>');
        		 $("#userform-submit").attr('onclick','userController()');
        		 var edit_id = 'id='+id;
        		 getJson(edit_id, service_url['get_user'], function(data){
        			if(data.readyState == 4){

        				var edit_user_data = JSON.parse(data.response);
        				//set values
        				$.each(edit_user_data[0],function(ind,val){
        					$( "input[name='"+ind+"']" ).val(val)
        				})

        				//set permissions
        				var user_permissions = JSON.parse(edit_user_data[0]['permissions']);
        				$.each(user_permissions,function(p_ind,p_value){

        					$( "input[name='module#"+p_ind+"']" ).attr('checked',true);
        					$.each(p_value,function(a_ind,a_val){
        						//module#category#action#add
        						if(a_val == true){
        							$( "input[name='module#"+p_ind+"#action#"+a_ind+"']" ).attr('checked',true);
        						}

        						//console.log(a_val)
        					});
        				})
        				//append id value
        				$("#userForm").append('<input type="hidden" name="id" value="'+edit_user_data[0]['id']+'">');

        			}
        		 });
        	 }
     		}
	 });

 }
 //userController @zubayer
 function userController(type){
	 postFormData('userForm',service_url['add_user'],function(data){
			if(data.readyState == 4){
				//alert(data.responseText);
			}
	 });

    generateLeftMenu('leftbar');
 }
/*
 * directives
 * @zubayer
 * id => dom id
 */
// header
function genereateHeader(id) {
	$('#' + id).html('<h1 class="logoholder">DOZE</h1>');
}
// menu
function generateLeftMenu(id) {
    getJson('',service_url['get_category_url'], function(data){
        if(data.readyState == 4){
			var catMenu= catTree(JSON.parse(data.response),0);
			var cmsLeftMenu = printTree(catMenu);
			$('#' + id).html(cmsLeftMenu);
            printContentListUnderLeftMenu(); // left content menu loading

          //print user list under menu
            printUserListUnderLeftMenu();


       }
	}); //end of category json callback

}

//printUserListUnderLeftMenu @zubayer
function printUserListUnderLeftMenu(){
	var my_details = JSON.parse(checkSesssion('is_auth'));
    var my_permissions = JSON.parse(my_details[0].permissions);
    if(my_permissions.users['add'] == undefined){
    	$('.permission_users_add').remove();
    }
	getJson('',service_url['get_user'], function(data){
        if(data.readyState == 4){
        	var user_list_data = JSON.parse(data.response);

        	if(user_list_data.length >0){
        		$("#user_list_holoder").remove();
        		var user_list_html = '<ul id="user_list_holoder">';
	        	$.each(user_list_data,function(ind,val){ //userView('content','userFormDirective', 'add','no')
	        		var permission_block = '';
	        		user_list_html += '<li id="user_'+val.id+'">'+val.name+'<div class="categoryactionimg user-icon">';

	        			if(my_permissions.users != undefined){

	        				if(my_permissions.users['edit'] != undefined){
	        					permission_block += '<img title="Edit Category" class="permission_users_edit" src="img/edit.png" onclick="userView(\'content\',\'userFormDirective\',\'edit\', '+val.id+')">';
	        				}

	        				if(my_permissions.users['delete'] != undefined){
	        					permission_block += '<img title="Delete Category" class="permission_users_delete" src="img/delete.png" onclick="deleteUserController('+val.id+')">';
	        				}

	        				if(permission_block != ''){
	        					user_list_html += '<div class="actiontooltip ">'+permission_block+'</div>'
	        				}

	        			}

	        	});
	        	user_list_html += '</div></li></ul>';

	        	$("#users_list").append(user_list_html);
        	}

        }
	});
}

//delete user controller @ zubayer
function deleteUserController(id){
	var confimation = confirm('Are you sure ?');
	if(confimation == true){
		 var delete_id = 'id='+id;
		 getJson(delete_id, service_url['delete_user'],function(data){
		 if(data.readyState == 4){
			 generateLeftMenu('leftbar');
		  }
		 });
	}

}

// escape special char @Mahfooz
function escapeSpecialChar(value){
    if(value != undefined){
         value = value.replace(/\\'/g, "'");
        return value;
    }

}


/*
 * deleteCategory
 * @zubayaer
 */
function deleteCategory(id){
	var confimation = confirm('Are you sure ?');
    	if(confimation == true){
    	var delete_id = 'id='+id;
    	 getJson(delete_id, service_url['delete_category_by_id_url'],function(data){
    		 if(data.readyState == 4){
    			 generateLeftMenu('leftbar');
    		 }
    	 })
     }
}

/*
 * contentDelete
 * @zubayer
 */
function contentDelete(id){
	var confimation = confirm('Are you sure ?');
	if(confimation == true){
    	var delete_id = 'id='+id;

    	 getJson(delete_id,service_url['delete_content_url'],function(data){
    	   if(data.readyState == 4){
    		       generateLeftMenu('leftbar');
    		 }
    	 })

	}
}

/*
* generate content list under left menu
* @zubayer
*
*
*
*/
function printContentListUnderLeftMenu(){
	var my_details = JSON.parse(checkSesssion('is_auth'));
    var my_permissions = JSON.parse(my_details[0].permissions);


	getJson('',service_url['get_content_url'], function(data){

    		if(data.readyState == 4){
    		  var contentList = JSON.parse(data.response);

             //container loop
             $.each($('.content-holder-li'),function(){

                var container_id = $(this).attr('id');

               var my_html = '<ul class="category_contents">';

                //push content to specific Location
                $.each(contentList,function(index,value){
                    var d_id = 'content-holder-li-'+value.catid;

                    if(d_id == container_id){
                    	var permission_blok = '';
                    	//var content_title =
                    	if(value.status == 1){
                    		var title_span = '<span class="approved">';
                    	}else{
                    		var title_span = '<span class="not-approved">';
                    	}
                         my_html+= '<li>'+title_span+escapeSpecialChar(value.title)+'</span><div class="contentactionimg">';

                         if(my_permissions.contents != undefined){

                        	 if(my_permissions.contents['edit'] != undefined){
                        		 permission_blok += '&nbsp;<img title="Edit Content" class="permission_contents_edit" src="img/edit.png" onclick=\"contentView(\'content\',\'edit\',\''+ value.catid +'\',\''+value.cid+'\')\">';
                        	 }

                        	 if(my_permissions.contents['delete'] != undefined){
                        		 permission_blok += '&nbsp;<img title="Delete Content" class="permission_contents_delete" src="img/delete.png" onclick=\"contentDelete('+value.cid+')\">';
                        	 }
                        	//
                        	 if(permission_blok != ''){
                        		 my_html +='<div class="actiontooltip">'+permission_blok+'</div>';
                        	 }

                         }

                        my_html += '<div style="clear:both;"></div></div></li>';
                    }

                });
                my_html+= "</ul>"

                $("#"+container_id).append(my_html);
             });

             $('#leftbar').cmsPanelDropDown();

            } // </if
        }); // </get json
}



/*
 * Multilevel Category Subcategory content management manipulation
 * @mahfooz
 */

(function( $ ){
   $.fn.cmsPanelDropDown = function() {

    var $this = $(this);

    $this.find("ul li ul").hide(); // displaying only parent categories


	$this.find("ul li").each(function() {

        if($(this).find('.category_contents:last').html() != "") {

    		if($(this).find("ul").size() != 0){
    			$(this).find("a:first").prepend("<span>+</span>&nbsp;"); //add the multilevel sign next to the link
    		}
    		if($(this).find("a:first").attr('href') == "#"){ // preventing default link behavior
      			$(this).find("a:first").click(function(){return false;});
      		}
       }// preventing + sign which has no category content

	});

    $('.content-holder-li a').click(function() {

		if($(this).parent().find("ul").size() != 0){

			if($(this).parent().find("ul:first").is(":visible")){

				$(this).parent().find("ul:first").slideUp(700, function(){ // category closing
					$(this).parent("li").find("span:first").delay(700).html("+");
				});

				$(this).parent().find(".category_contents").slideUp(700, function(){ // category content closing
					$(this).parent("li:first").find("span:first").delay(700).html("+");
				});

			}else{

				$(this).parent().find("ul:first").slideDown(700, function(){ // category expanding
					$(this).parent("li").find("span:first").delay(700).html("-");
				});

				$(this).parent().find(".category_contents:last").slideDown(700, function(){ // category content expanding
					$(this).parent("li:first").find("span:first").delay(700).html("-");
				});

              }
		}

    });

   };
})( jQuery );

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
 * print tree
 * @zubayer
 *
 * data => object
 */
function printTree(data){
	//permission block
	var my_details = JSON.parse(checkSesssion('is_auth'));
    var my_permissions = JSON.parse(my_details[0].permissions);
    if(my_permissions.category['add'] == undefined){
    	$('.permission_category_add').remove();
    }
   	var my_html = '<ul class="menu">';

	$.each(data,function(index,value){
		var permission_html = '';
		if(value.status == 1){
			var cat_title = '<a href="#" class="approved">'+value.title + '</a>'
		}else{
			var cat_title = '<a href="#" class="not-approved">'+value.title + '</a>'
		}

		my_html += '<li id="content-holder-li-'+value.tbid+'" class="content-holder-li" >'+cat_title+'<div class="categoryactionimg">';

		if(my_permissions.category != undefined){

	    	var cat_permission = my_permissions.category;

	    		if(cat_permission['edit'] != undefined ){
					permission_html += '<img title="Edit Category"  src="img/edit.png" onclick=\"categoryView(\'content\',\'edit\',\''+value.tbid+'\')\">';
				}

				if(cat_permission['delete'] != undefined){
					permission_html += '<img title="Delete Category"  src="img/delete.png" onclick=\"deleteCategory('+value.tbid+')\">';
				}
			}

		 if(my_permissions.contents['add'] != undefined){
			 permission_html+= '<img title="Add Content"  src="img/add.png" onclick=\"contentView(\'content\',\'add\',\''+value.tbid+'\')\">';
         }

        if(permission_html != ''){
        	my_html +='<div class="actiontooltip">'+permission_html+'</div>';
        }
        my_html +=    '</div><div style="clear:both;">';

       	if(value.children != undefined){
			var children = printTree(value.children);
			my_html += children;
			my_html +='</li>';
		}else{
			my_html +='</li>';
		}
	});
	my_html += '</ul>';
	return my_html;
}

/*
 * category tree
 * @zubayer
 *
 * data -> object
 * parent -> integer
 *
 */
function catTree(data,parent) {
	var tree = new Array();
	$.each(data,function(index,value) {
		if (value['parent'] == parent) {
			var children = catTree(data,parseInt(value.id));
			if (children.length > 0) {
				value['children'] = children;
			}
			tree.push(value);
		}
	});
	return tree;
}

// footer
function generateFooter(id) {
	$('#' + id).html('2014 &copy; DOZE');
}

/*
 * Session handler
 * @zubayer
 */

/*
 * specification of this login
 *
 * var is_auth = true if logged else false, default false
 * var auth_user = json_data //{id,username,permission_as_object}
 */

/*
 * loggin
 */
function login(data){
	//console.log(data);
	setSession(data,'is_auth');
	var auth_status = isAuth();

	if(auth_status != null){
		$(".leftbody").show();
		$(".rightbody").show();
		categoryView('content','add','');
		generateLeftMenu('leftbar');

		$("#login_holder").css({display:'none'});
	}else{
		$(".leftbody").hide();
		$(".rightbody").hide()
		loginView('login_holder','login_directory');
	}



}

//logout @zubayer
function logout(){
	destroySession('is_auth');
	window.location.replace(logoutUrl);
}


/*
 * is logged
 */
function isAuth(){
	return checkSesssion('is_auth');
}

//set Session @zubayer
function setSession(data,set_to){

	sessionStorage.setItem(set_to,data);
}

//check session @zubayer
function checkSesssion(session_var){
	return sessionStorage.getItem(session_var);
}

//destroy sesssio @zubayer
function destroySession(destroybale_var){
	sessionStorage.removeItem(destroybale_var);
}

/*
 * ################################################################################################
 * Services
 */


/*
 * postJsonData
 * @zubayer
 *
 */


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


/**validation section @zubayer */

//validate form @zubayer
function validate_form(form_id){
	$('.error_message').remove();
	var validate_fields = $("#"+form_id+" :input");

	//fields loop
	$.each(validate_fields,function(index,val){

		var cur_fields  = $("#"+form_id+" [name='"+val.name+"']");
		var validate_rules = val.dataset.validate;


		if(validate_rules != undefined ){

			var val_rules = JSON.parse(validate_rules);

			//rules loop
			$.each(val_rules,function(ind,val){

				//rule wise loop
				$.each(val,function(rule_name,message){

					//check
					var field_value = $(cur_fields).val();
					var rule_status = validation[rule_name](field_value);

					if(rule_status == false){
						$(cur_fields).addClass('error');
						$(cur_fields).addClass(rule_name);
						$( "<div class='error_message'>"+message+"</div>" ).insertAfter(cur_fields);
					}else{
						$(cur_fields).removeClass('error');
						$(cur_fields).removeClass(rule_name);
					}

				})

				//$(cur_fields).class('dsf')
			})
		}



	});

	return true;
}

//is_form_validate @zubayer
function is_form_valid(form_id){
	var error = false;;
	var validate_fields = $("#"+form_id+" :input");
	$.each(validate_fields,function(index,val){
		var cur_field_status  = $("#"+form_id+" [name='"+val.name+"']").hasClass('error');

		if(cur_field_status == true){
			error = true;
		}
	});
	return error;

}

/* validation rules and defination @zubayer */
var validation = new Array();

//not_empty @zubayer
validation['not_empty'] = function (data){
	if(data == undefined){
		return false;
	}else if(data == ''){
		return false;
	}else if(data == null){
		return false;
	}
	return true;
}
//email @zubayer
validation['email'] = function (data) {
	var email_pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    if(data.match(email_pattern) == null){
    	return false
    }
    return true;
}
