/**  
*  author@ zubayer
* data is array 
* data[0] => [col1,col2 ~ coln]
* data[1~n] => [value1,value2 ~ valuen]
* params = ['table':'table_selector',allowed 
**/

/** implementation guide

 var distributor_params = new Object();
                    distributor_params.table_selector = '.delear_list';
                    distributor_params.table_heading = ['Name', 'Balance', 'Status', 'Topup Service', 'Actions'];
                    distributor_params.table_cols = ['firstName', 'balance', 'dealerstatus', 'topupsub', 'Actions'];
                    //pagination
                    var pagination_params = new Object();
                    pagination_params.type = 'static'
                    pagination_params.table_selector = '.delear_list';
                    pagination_params.no_of_row_per_page = 10;
                    //set as table parsms
                    distributor_params.pagination = pagination_params;

                    //generate table
                    generateDataTable(row_array, 'process_delear_list_action', distributor_params);
 */

function generateDataTable(data, actionGenerator, params) {
    //process action section
    if (typeof (table[actionGenerator]) == 'function') {
        var action_array = table[actionGenerator](data);
    } else {
        var action_array = null;
    }

    //   process table data
    if (typeof (action_array) != null) {

        var table_data = table['table_data_processor'](data, action_array);
    } else {
        var table_data = table['table_data_processor'](data);
    }
    //genrateTable View
    table['view_processor'](table_data, params);

    //process pagination
    if (params.pagination != undefined) {
        table['pagination'](params.pagination);
    }

}
var table = new Array();

/** 
* @ zubayer
* table data processor
* row_array = cols+data_rows
* action_array = heading + html
* 
* if actions is not empty return merge value else return row_array
* dev status : done
*/
table['table_data_processor'] = function (row_array, action_array) {
    var return_array = new Array();
    if (action_array == 'undefined' || action_array == null) {
        return_array = row_array;
    } else {
        //merge row array with acton array
        var rows_with_action = new Array();
        $.each(row_array, function (ind, val) {
            val.push(action_array[ind]);
            rows_with_action.push(val);
        });
        return_array = rows_with_action;
    }
    return return_array;
}


/**
* table view Processor
* params = ['table_selector':'selector_value','table_cols':'cols1|col2|col3...coln']
*/

table['view_processor'] = function (table_data, params) {

    $(params.table_selector).empty().html('<thead><tr></tr></thead><tbody></tbody>');
    var visible_field = table['visible_fields'](table_data, params);


    //table head processor
    $.each(params.table_heading, function (p, q) {
        //console.log(q);
        $(params.table_selector + ' thead tr').append('<th>' + q + '</th>');
    })
    //table body processor
    $.each(table_data, function (ind, val) {
        if (ind != 0) {
            $(params.table_selector + ' tbody').append('<tr></tr>');
            $.each(visible_field, function (p, q) {
                //console.log(q);
                $(params.table_selector + ' tbody tr:last').append('<td>' + val[q] + '</td>');
            })
        }
    });

}

//get visible field
table['visible_fields'] = function (table_data, params) {
    var visible_field = new Array();
    $.each(params.table_cols, function (ind, val) {
        $.each(table_data[0], function (p, q) {
            if (val == q) {
                visible_field.push(p)
            }
        });
    });
    return visible_field;
}
table['pagination'] = function (data) {
    //process table pagination
   
    table['createPaginationHtml'](data);
}

/*
*  createPaginationHtml @ zubayer
*  params.type = static/dynamic
*  params.table_selector = id/class(css)
*  params.no_of_row_per_page
*
*/

table['createPaginationHtml'] = function (params) {
    
    if (params.type == 'static') {
        
        var table_rows = $(params.table_selector + " tr").length-1;
        var last_page_rows = table_rows % params.no_of_row_per_page;
        var full_pages = (table_rows - last_page_rows) / params.no_of_row_per_page;
        if (last_page_rows > 0) {
            var total_page = full_pages + 1;
        } else {
            var total_page = full_pages;
        }
       
        if (total_page > 1) {
            var paginationHtml = '<ul class="pagination">'
            for (var i = 1; i <= total_page; i++) {
                paginationHtml += '<li  id="' + i + '_active"><a onclick="visitNPage(' + i + ',' + params.no_of_row_per_page + ',\'' + params.type + '\',\'' + params.table_selector + '\')">' + i + '</a></li>'
            }
            paginationHtml += '</ul>';
            $(params.table_selector).next('div').remove();
            $(params.table_selector).after("<div class='pagination_holder'></div>");
            $('.pagination_holder').empty().html(paginationHtml);
        }else{
            $('.pagination_holder').remove();
        }
    }
    //PROCESS default load
    visitNPage(1, params.no_of_row_per_page, params.type, params.table_selector);
}

//pagination on click navigation between pages @ zubayer
function visitNPage(page_no, no_of_rows, type, selector) {
    if (type == 'static') {
        var visibility_start = (page_no * no_of_rows) - no_of_rows;
        var visibility_end = visibility_start + no_of_rows;
        $.each($(selector + ' tbody tr'), function (ind, val) {
            if (ind >= visibility_start && ind < visibility_end) {
                $(selector + ' tbody tr:eq(' + ind + ')').show();
                $('ul.pagination li').removeAttr('class');
                $('#'+page_no+'_active').attr('class','active');
            } else {
                $(selector + ' tbody tr:eq(' + ind + ')').hide();
            }
        })
    }
}