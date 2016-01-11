(function ($) {
    $.confirm = function (params) {

        if ($('#confirmOverlay').length) {
            // A confirm is already shown on the page:
            return false;
        }

        var buttonHTML = '';
        $.each(params.buttons, function (name, obj) {

            // Generating the markup for the buttons:

            buttonHTML += '<a href="#" class="button ' + obj['class'] + '" id="' + obj['id'] + '">' + name + '<span></span></a>';

            if (!obj.action) {
                obj.action = function () {
                };
            }
        });

        var markup = [
            '<div id="confirmOverlay"><div class="container-fluid"><div class="row"><div class="col-lg-12"><div class="row"><div class="col-md-12 col-sm-12"><br><br></div></div><div class="row"><div class="col-md-3 col-sm-3"></div>',
            '<div id="confirmBox" class="col-md-6 col-sm-6 pull-right">',
            '<h1 class="', params.class, '">', params.title, '</h1>',
            '<p>', params.message, '</p>',
            '<div id="confirmButtons">',
            buttonHTML,
            '</div></div><div class="col-md-3 col-sm-3"></div></div></div></div></div></div></div>'
        ].join('');

        $(markup).hide().appendTo('body').fadeIn();

        var buttons = $('#confirmBox .button'),
            i = 0;

        $.each(params.buttons, function (name, obj) {
            buttons.eq(i++).click(function () {

                // Calling the action attribute when a
                // click occurs, and hiding the confirm.

                obj.action();
                $.confirm.hide();
                return false;
            });
        });
    }
    $.confirm.hide = function () {
        $('#confirmOverlay').fadeOut(function () {
            $(this).remove();
        });
    }
})(jQuery);