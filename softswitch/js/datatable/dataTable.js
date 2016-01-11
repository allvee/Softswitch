function addDataTable1() {
        $('#dataTables-campaign').dataTable({
            "processing": true,
            "ajax": {
                url: "scriptsTest/post.php",
                type: 'POST'
            },
            "columns": [
                {"data": "Tid"},
                {"data": "Text"},
                {"data": "Uid"}
            ],
            "searching": true,
            "ordering": true
        });
    }

    function addDataTable2() {
        $('#dataTables-campaign').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "scriptsTest/post.php",
                type: 'POST'
            },
            "columns": [
                {"data": "Tid"},
                {"data": "Text"},
                {"data": "Uid"}
            ],
            "searching": true,
            "ordering": true
        });
    }