function coolMazharConfirmFunction(x, heading, message) {
    var elem = $(x).closest('.item');

    $.confirm({
        'title': heading,
        'message': message,
        'buttons': {
            'Yes': {
                'class': 'blue',
                'id': 'yes_btn',
                'action': function () {
                }
            },
            'No': {
                'class': 'gray',
                'action': function () {
                } // Nothing to do in this case. You can as well omit the action property.   plagin_edited_finction.js
            }
        }
    });
}

function cuteConfirmFunction(x, heading, message) {
    var elem = $(x).closest('.item');

    $.confirm({
        'title': heading,
        'message': message,
        'buttons': {
            'Yes': {
                'class': 'blue',
                'action': function () {

                }
            },
            'No': {
                'class': 'gray',
                'action': function () {


                } // Nothing to do in this case. You can as well omit the action property.   plagin_edited_finction.js
            }
        }
    });
}

function myconfirmfunction(x, heading, message) {
    var elem = $(x).closest('.item');

    $.confirm({
        'title': heading,
        'message': message,
        'buttons': {
            'Yes': {
                'class': 'blue',
                'action': function () {

                }
            },
            'No': {
                'class': 'gray',
                'action': function () {


                } // Nothing to do in this case. You can as well omit the action property.   plagin_edited_finction.js
            }
        }
    });
}

function deleteConfirm(id, url, table_id) {
    /*===============================================================================================================================
     id= deleted table row id.
     url= add php page url which have deletion code.
     table_id=html table id or dive id or any kind of id ,
     ID=post php id to get deletion row id.

     =================================================================================================================================
     */
    $.confirm({
        'title': "Delete message Alert",
        'message': "Are You Sure To Delete This Row?",
        'buttons': {
            'Yes': {
                'class': 'blue',
                'action': function () {
                    $.post(url,
                        {'ID': id},
                        function (result) {
                            $(table_id).html(result);

                        });
                }
            },
            'No': {
                'class': 'gray',
                'action': function () {


                } // Nothing to do in this case. You can as well omit the action property.   plagin_edited_finction.js
            }
        }
    });
}

/*================================================
 * function alertMessage
 * @param cls string defines css class
 * @param heading string message header
 * @param message string message body
 * examples:
 * cls 'blue' for normal alert
 * cls 'red' for error alert
 * cls 'green' for success alert
 * cls 'yellow' for warning alert
 * ================================================*/
function alertMessage(x, cls, heading, message) {

    $.confirm({
        'title': heading,
        'message': message,
        'class': cls,
        'buttons': {
            'OK': {
                'class': cls,
                'action': function () {
                }
            }
        }
    });
}

/*================================================
 * function confirmMessage
 * @param id string defines button id for onclick function
 * @param heading string message header
 * @param message string message body
 * ================================================*/
function confirmMessage(x, id, heading, message) {

    $.confirm({
        'title': heading,
        'message': message,
        'buttons': {
            'Yes': {
                'class': 'blue',
                'id': id,
                'action': function () {
                }
            },
            'No': {
                'class': 'gray',
                'action': function () {
                } // Nothing to do in this case. You can as well omit the action property.   plagin_edited_finction.js
            }
        }
    });
}
	
 