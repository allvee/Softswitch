
var number_of_check = 0;
var check_id_arr = {};


function report_menu_start_audit_history() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
	 dataSet = connectServer(cms_url['audit_history'],dataInfo );
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
  //  table_data_audit_view(dataSet);
	$('#tbl_view_table').html(dataSet.response);

}



function table_initialize_audit_history(){
		    
	$('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_audit_history" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
}

function table_audit_history_dataset(dataSet){
	 //console.log(dataSet);
	$('#dataTables_audit_history').dataTable({

        "data": dataSet,
        "columns": [
           
            {"title": "Date", "class": "center"},
            {"title": "Audit Information", "class": "center"}
			
           
        ],
		"columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[2, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                "select_all", "select_none", "copy", "csv",
                {
                    "sExtends": "xls",
                    "sFileName": "*.xls"
                }
            ],
            "filter": "applied"
        },
		
		"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });
	
	var table = $('#dataTables_audit_history').DataTable();
	//console.log("tbl:",table);
	   // Order by the grouping
    $('#dataTables_audit_history tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    } ); 
	
	
}

function report_audit_history(){
	
	var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['audit_history'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
	table_initialize_audit_history();
    table_audit_history_dataset(dataSet);
	var table = $("#dataTables_audit_history").DataTable();
	table.columns(3).visible(false);
	//table.columns(3).visible(true);
	var data = table.cell( 1, 3).data();
	console.log("data:",data);
	
	//$('#tbl_view_table').append('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_audit_diff" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>').show();

	
	

	//table.columns(3).visible(false);
}


function table_audit_compare(dataSet){
	
	 $('#dataTables_compare_string').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "First Text", "class": "center"},
            {"title": "Second Text", "class": "center"},
            {"title": "Difference", "class": "center"}
			
           
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                "select_all", "select_none", "copy", "csv",
                {
                    "sExtends": "xls",
                    "sFileName": "*.xls"
                }
            ],
            "filter": "applied"
        }
    });
	
}
function report_audit_compare(first_id,second_id){
	var data = {};
	var res = "";
	data['id_1'] = first_id;
	data['id_2'] = second_id;
	res = connectServer(cms_url['get_audit_trial_compare_string'], data);
	display_content_custom("150", "#modalData");
	$("#tbl_view_table").html(res);
 
	
	$("tr#compare_row").prettyTextDiff({originalContainer:'#original_txt',changedContainer:'#changed_txt',diffContainer:'#diff_txt',cleanup:true});
			
}
/*
function check_audit_trail(obj,id){
		var id_name = id; 
		//$(obj).prop({"checked":true});
		check_id_arr[id_name] = id_name; 
		console.log("dd:",check_id_arr);
	
}*/