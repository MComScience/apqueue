$(function () {
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    socket.on('request_service', function (data) {
        QueryTableOrdercheck();
    });
    QueryTableOrdercheck();
});
$('#form-horizontal').on('beforeSubmit', function (e) {
    e.preventDefault();
    LoadingClass();
    var dataArray = $(this).serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });
    $('.modal-title').html("รายการคำสั่ง QNum " + dataObj['QNumber']);
    $.ajax({
        type: 'POST',
        url: '/apqueue/main/default/get-orderlist',
        data: {QNumber: dataObj['QNumber']},
        dataType: "json",
        success: function (result) {
            if (result === 'ไม่มีหมายเลขคิว') {
                swal(result, "", "error");
                $('#wrapper').waitMe('hide');
            } else {
                $("#order-list").html(result);
                $('#wrapper').waitMe('hide');
                $("#modal-orderdetail").modal('show');
            }

        },
        error: function (xhr, status, error) {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
            $('#wrapper').waitMe('hide');
        },
    });
    return false;
});
function LoadingClass() {
    $('#wrapper').waitMe({
        effect: 'roundBounce', //roundBounce,ios,progressBar
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000', //default #000
        maxSize: '',
        source: 'img.svg',
        fontSize: '20px',
        onClose: function () {
        }
    });
}

function Save() {
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    var orderids = new Array(); //ID ที่เลือก
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            orderids.push($(this).val());
        }
    });
    var dataArray = $('#orderdetail').serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });
    $.ajax({
        type: 'POST',
        url: '/apqueue/main/default/save-orderdetail',
        data: {orderids: orderids, q_ids: dataObj['q_ids']},
        dataType: "json",
        success: function (result) {
            $("#order-list").html('');
            QueryTableOrdercheck();
            $('#orderdetail').trigger("reset");
            $('#form-horizontal').trigger("reset");
            $("#modal-orderdetail").modal('hide');
            socket.emit('request_service', {
                    request_service: 1
            });
        },
        error: function (xhr, status, error) {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
        },
    });
}
function Select(e) {
    var QNum = (e.getAttribute("data-id"));
    LoadingClass();
    $('.modal-title').html("รายการคำสั่ง QNum " + QNum);
    $.ajax({
        type: 'POST',
        url: '/apqueue/main/default/get-orderlist',
        data: {QNumber: QNum},
        dataType: "json",
        success: function (result) {
            $("#order-list").html(result);
            $('#wrapper').waitMe('hide');
            $("#modal-orderdetail").modal('show');
        },
        error: function (xhr, status, error) {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
        },
    });
}
function QueryTableOrdercheck() {
    $.ajax({
        url: '/apqueue/main/default/table-ordercheck',
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            $('#tb-ordercheck-content').html(result);
            $('#table-ordercheck').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 25,
                "responsive": true,
                "language": {
                    "lengthMenu": "_MENU_",
                },
            });
        },
        error: function (xhr, status, error) {
            swal(error, "", "error");
        }
    });
}

function Delete(e) {
    var q_ids = (e.getAttribute("data-id"));
    var q_num = (e.getAttribute("qnum"));
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    swal({
        title: "Delete " + q_num + " ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#74D348",
        confirmButtonText: "Confirm!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/apqueue/main/default/delete',
                        type: 'POST',
                        data: {q_ids: q_ids},
                        dataType: 'json',
                        success: function (result) {
                            QueryTableOrdercheck();
                            socket.emit('request_delete_hold_recall', {
                                request_delete_hold_recall: "Delete",
                                service_name: "ห้องตรวจโรคอายุรกรรม",
                            });
                            swal.close();
                        },
                        error: function (xhr, status, error) {
                            swal(error, "", "error");
                        }
                    });
                }
            });
}