//var servicegroupid = $('#servicegroup :selected').val();
$(function () {
    if (localStorage.getItem("servicegroup") === 'ห้องตรวจโรค') {
        $("#servicegroup").val(2).trigger("change");
    } else {
        localStorage.setItem("servicegroup", "คัดกรองผู้ป่วยนอก");
        $("#servicegroup").val(1).trigger("change");
    }
});
function Apply() {
    var ServiceGroupID = $('#servicegroup :selected').val() || 0; /*เก็บค่า id Service */
    if (ServiceGroupID === 0) {
        swal("กรุณาเลือก Service", "", "warning");
    } else {
        QueryTableCalling(ServiceGroupID);
        QueryTableWaiting(ServiceGroupID);
    }
}
/* Query Table Calling to display */
function QueryTableCalling(ServiceGroupID) {
    $.ajax({
        url: '/apqueue/main/default/tablecalling',
        type: 'POST',
        data: {ServiceGroupID: ServiceGroupID},
        dataType: 'json',
        success: function (result) {
            $('#tb-calling-content').html(result);
            $('#table-calling').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 10,
            });
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
/* Query Table Waitiing to display */
function QueryTableWaiting(ServiceGroupID) {
    $.ajax({
        url: '/apqueue/main/default/tablewaiting',
        type: 'POST',
        data: {ServiceGroupID: ServiceGroupID},
        dataType: 'json',
        success: function (result) {
            $('#tb-waiting-content').html(result);
            $('#table-waiting').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 10,
                "responsive": true,
                "aLengthMenu": [
                    [5, 10, 15, 20, 100, -1],
                    [5, 10, 15, 20, 100, "All"]
                ],
            });
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}
$('#servicegroup').on('change', function (e) {
    var ServiceGroupName = $(this).find("option:selected").text() || null;
    if (localStorage.getItem("servicegroup") === ServiceGroupName) {
        localStorage.setItem("servicegroup", ServiceGroupName);
    } else {
        localStorage.setItem("servicegroup", "คัดกรองผู้ป่วยนอก");
    }
});

