/**
 * Created by Mazhar on 10/25/2014.
 */
function genericError(jqXHR, textStatus, errorThrown) {

    var message = "Error : ";
    var statusErrorMap = {
        '400': " Server understood the request but request content was invalid.",
        '401': " Unauthorised access.",
        '403': " Forbidden resource can't be accessed",
        '500': " Internal Server or Coding Error.",
        '503': " Service Unavailable"
    };

    //jsonValue = jQuery.parseJSON(jqXHR.responseText);
    //message = message + " !!! Message : " + jsonValue.Message;

    if (jqXHR.status) {

        message = message + jqXHR.status;
        if (statusErrorMap[jqXHR.status] != undefined) {
            message = message + statusErrorMap[jqXHR.status];
        }
    }
    /*
     * textStatus has values like "timeout", "error", "abort", and "parsererror"
     * */
    if (textStatus == 'parsererror') {
        message = message + " Parsing JSON Request failed.";
    } else if (textStatus == 'timeout') {
        message = message + " Request Time out.";
    } else if (textStatus == 'abort') {
        message = message + " Request was aborted by the server";
    }
    /*
     *  errorThrown has values like "Not Found" or "Internal Server Error."
     * */
    if (errorThrown) {
        message = message + " " + errorThrown;
    }

    $.ajax({
        type: "POST",
        url: cms_url['dhakaGate_error'],
        data: {
            'error': message
        },
        async: true,
        success: function(value) {
            var cls = 'red';
            var heading = "Error";
           // var errorMessage = "It feels embarrassing ! !! !!! <br>We are in deep trouble ! Help us by contacting our support immediately. \nWith the error code. <br><br> \"" + message + "\"";
            alertMessage(this, cls, heading, message);

        },
        error: function() {
            var cls = 'red';
            var heading = "Error";
            var errorMessage = "It feels embarrassing ! !! !!! <br>We are in deep trouble ! Help us by contacting our support immediately. \nWith the error code. <br><br> \"" + message + "\"";
            alertMessage(this, cls, heading, errorMessage);
        }
    });
}