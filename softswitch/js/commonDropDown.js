/**
 * Created by Mazhar on 3/10/2015.
 */

/*
 * for all dropdown just use
 * class="chosen-select"  in select tag
 * */
function dropdown_chosen_style() {
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $('.chosen-select').trigger('liszt:updated');
}


/* =========================================================
 * Created by Mazhar on 10/25/2014.
 *
 * generic call for drop down
 * ========================================================= */
function fetchDropDownOption(targetID, fetchURL, dataInfo, type) {

    var innerHTMLCode = connectServer(fetchURL, dataInfo, type);
    $(targetID).append(innerHTMLCode);
}
