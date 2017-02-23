$(function () {
    if (localStorage.getItem("servicegroup") === 'ห้องตรวจโรค') {
        $("#servicegroup").val(2).trigger("change");
    } else if (localStorage.getItem("servicegroup") === 'คัดกรองผู้ป่วยนอก') {
        //localStorage.setItem("servicegroup", "คัดกรองผู้ป่วยนอก");
        $("#servicegroup").val(1).trigger("change");
    }
    /*
     QueryTableCalling($('#servicegroup :selected').val());
     QueryTableWaiting($('#servicegroup :selected').val());
     QueryTableHoldlist($('#servicegroup :selected').val());
     */
    /* Socket เวลาออกบัตร ให้แสดงข้อมุลอัตโนมัติ */
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    socket.on('request_service', function (data) {
        QueryTableWaiting($('#servicegroup :selected').val());
        $('#notif_audio')[0].play();
    });
    /* Socket เวลาเรียกคิว ให้แสดงข้อมุลอัตโนมัติ */
    socket.on('request_calling', function (data) {
        QueryTableCalling($('#servicegroup :selected').val());
        QueryTableWaiting($('#servicegroup :selected').val());
        QueryTableHoldlist($('#servicegroup :selected').val());
        //console.log(data.qnum);
        $('#notif_audio')[0].play();
    });
    /* Socket Event Delete */
    socket.on('request_delete_hold_recall', function (data) {
        QueryTableCalling($('#servicegroup :selected').val());
        QueryTableWaiting($('#servicegroup :selected').val());
        QueryTableHoldlist($('#servicegroup :selected').val());
    });
});
/* Apply */
function Apply() {
    var ServiceGroupID = $('#servicegroup :selected').val() || 0; /*เก็บค่า id Service */
    if (ServiceGroupID === 0) {
        swal("กรุณาเลือก Service", "", "warning");
    } else {
        QueryTableCalling(ServiceGroupID);
        QueryTableWaiting(ServiceGroupID);
        QueryTableHoldlist(ServiceGroupID);
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
                "info": false,
                "language": {
                    "lengthMenu": "_MENU_",
                },
                "ordering": false,
                "paging": false,
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
                "info": false,
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
/* Query Table Waitiing to display */
function QueryTableHoldlist(ServiceGroupID) {
    $.ajax({
        url: '/apqueue/main/default/tableholdlist',
        type: 'POST',
        data: {ServiceGroupID: ServiceGroupID},
        dataType: 'json',
        success: function (result) {
            $('#tb-holdlist-content').html(result);
            $('#table-holdlist').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 10,
                "responsive": true,
                "info": false,
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
/* SetLocalStorage On Change ServiceGroup */
$('#servicegroup').on('change', function (e) {
    var ServiceGroupName = $(this).find("option:selected").text() || null;
    HiddenInput();
    if (ServiceGroupName !== "Select Service...") {
        if (localStorage.getItem("servicegroup") === ServiceGroupName) {
            localStorage.setItem("servicegroup", ServiceGroupName);
        } else {
            localStorage.setItem("servicegroup", ServiceGroupName);
        }
    } else {
        localStorage.removeItem("servicegroup");
    }
    QueryTableCalling($(this).find("option:selected").val());
    QueryTableWaiting($(this).find("option:selected").val());
    QueryTableHoldlist($(this).find("option:selected").val());
});
/* Function Select */
function SelectCall() {
    var QNumber = $('input[id=QNumber]').val() || null; //เก็บค่า QNumber
    var ServiceGroupID = $('#servicegroup :selected').val() || null; //เก็บค่า ServiceGroupID
    if (ServiceGroupID === null) {
        swal("กรุณาเลือก Service!", "", "warning");
    } else if (QNumber === null) {
        swal("กรุณากรอกเลขคิวหรือบาร์โค้ด!", "", "warning");
    } else {
        if ($('.hide-service').hasClass('display-none') && ServiceGroupID === '1') {
            $('.hide-counter').addClass('display-none');
            $('.hide-counter').hide();
            $('.hide-service').removeClass('display-none');
            $('.hide-service').show();
        } else if ($('.hide-counter').hasClass('display-none') && ServiceGroupID === '2') {
            $('.hide-service').addClass('display-none');
            $('.hide-service').hide();
            $('.hide-counter').removeClass('display-none');
            $('.hide-counter').show();
        }
        $('#modal-counter').modal('show');
        $('.modal-title').html(ServiceGroupID === '1' ? "เลือกช่องบริการ Qnum " + QNumber : "เลือกห้องตรวจ Qnum " + QNumber);
    }
}
$('#form-horizontal').on('beforeSubmit', function (e) {
    e.preventDefault();
    var dataArray = $(this).serializeArray();
    dataObj = {};
    $(dataArray).each(function (i, field) {
        dataObj[field.name] = field.value;
    });
    //console.log(dataObj['QNumber']);
    SelectCall();
    return false;
});
$("#QNumber").on("keyup", function () {
    var txtval = $(this).val() || null;
    if (txtval === null) {
        HiddenInput();
    }
});

function HiddenInput() {
    $('.hide-input1').addClass('display-none');
    $('.hide-input1').hide();
    $('.hide-input2').addClass('display-none');
    $('.hide-input2').hide();
    $('.hide-input-call').addClass('display-none');
    $('.hide-input-call').hide();
    $('#QNumber').val(null);
    $("#Counter1").val(null).trigger("change");
    $("#Counter2").val(null).trigger("change");
    $("div[id=step-0]").css("display", "none");
}
/* On Change Counter1 */
$('#Counter1').on('change', function (e) {
    var CounterName = $(this).find("option:selected").text() || null;
    if (CounterName !== "Select...") {
        $('.hide-input-call').removeClass('display-none');
        $('.hide-input-call').show();
    } else {
        $('.hide-input-call').addClass('display-none');
        $('.hide-input-call').hide();
    }
});
/* On Change Counter1 */
$('#Counter2').on('change', function (e) {
    var CounterName = $(this).find("option:selected").text() || null;
    if (CounterName !== "Select...") {
        $('.hide-input-call').removeClass('display-none');
        $('.hide-input-call').show();
    } else {
        $('.hide-input-call').addClass('display-none');
        $('.hide-input-call').hide();
    }
});
/* Call */
function Call() {
    var QNumber = $('input[id=QNumber]').val() || null; //เก็บค่า QNumber
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    var ServiceGroupID = $('#servicegroup :selected').val() || null; //เก็บค่า ServiceGroupID
    var counters = new Array();
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            counters.push($(this).val());
        }
    });
    if (counters.length === 0) {
        if (ServiceGroupID === '1') {
            swal("เลือกช่องบริการ!", "", "warning");
        } else {
            swal("เลือกห้องตรวจ!", "", "warning");
        }
    } else {
        $.ajax({
            url: '/apqueue/main/default/call',
            type: 'POST',
            data: {QNumber: QNumber, counters: counters},
            dataType: 'json',
            success: function (result) {
                if (result === 'เรียกซ้ำ') {
                    swal(result, "", "error");
                } else if (result === 'ไม่มีหมายเลขคิว') {
                    swal(result + ' ' + QNumber, "", "warning");
                } else {
                    //$("#tbody-tablecalling").prepend(result);
                    socket.emit('request_calling', {
                        request_calling: QNumber,
                        service_name: $('#servicegroup :selected').text(),
                    });
                    blinker("#tr-" + QNumber);
                    HiddenInput();
                    $('#modal-counter').modal('hide');
                }
            },
            error: function (xhr, status, error) {
                swal(error, "", "error");
            }
        });
    }
}
/* blinker กระพริบเวลาเรียก */
function blinker(id) {
    var varCounter = 0;
    var intervalId = setInterval(function () {
        varCounter++;
        if ($(id).hasClass('success')) {
            $(id).removeClass('success');
            $(id).addClass('default');
        } else {
            $('tr.default').removeClass('default');
            $(id).addClass('success');
        }
        if (varCounter === 10) {
            clearInterval(intervalId);
        }
    }, 500);
}
function blinkercall(id) {
    if (document.getElementById(id))
    {
        var varCounter = 0;
        var intervalId = setInterval(function () {
            varCounter++;
            var d = document.getElementById(id);
            d.style.color = (d.style.color == 'black' ? 'red' : 'black');
            if (varCounter === 5) {
                clearInterval(intervalId);
                d.style.color = '#6A6C6F';
            }
        }, 500);
    }
}
/* Delete */
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
                            socket.emit('request_delete_hold_recall', {
                                request_delete_hold_recall: "Delete",
                                service_name: $('#servicegroup :selected').text(),
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
/* Hold */
function Hold(e) {
    var q_ids = (e.getAttribute("data-id"));
    var q_num = (e.getAttribute("qnum"));
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    HiddenInput();
    swal({
        title: "Hold " + q_num + " ?",
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
                        url: '/apqueue/main/default/hold',
                        type: 'POST',
                        data: {q_ids: q_ids},
                        dataType: 'json',
                        success: function (result) {
                            socket.emit('request_delete_hold_recall', {
                                request_delete_hold_recall: "Hold",
                                service_name: $('#servicegroup :selected').text(),
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
/* Call Button */
function CallButton(e) {
    var QNumber = (e.getAttribute("qnum"));
    $('input[id=QNumber]').val(e.getAttribute("qnum"));
    SelectCall();
    //$('html, body').animate({scrollTop: 0}, 300);
    //blinkercall('Select-Counter' + ServiceGroupID);
}
/* Recall */
function Recall(e) {
    var caller_ids = (e.getAttribute("data-id"));
    var q_num = (e.getAttribute("qnum"));
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    HiddenInput();
    swal({
        title: "Recall " + q_num + " ?",
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
                        url: '/apqueue/main/default/recall',
                        type: 'POST',
                        data: {caller_ids: caller_ids},
                        dataType: 'json',
                        success: function (result) {
                            /* result == q_num */
                            socket.emit('request_delete_hold_recall', {
                                request_delete_hold_recall: result,
                                service_name: $('#servicegroup :selected').text(),
                            });
                            swal.close();
                            blinker("#tr-" + q_num);
                        },
                        error: function (xhr, status, error) {
                            swal(error, "", "error");
                        }
                    });
                }
            });
}
/* End */
function End(e) {
    var q_ids = (e.getAttribute("data-id"));
    var q_num = (e.getAttribute("qnum"));
    var socket = io.connect('http://' + window.location.hostname + ':3000');
    HiddenInput();
    swal({
        title: "End " + q_num + " ?",
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
                        url: '/apqueue/main/default/end',
                        type: 'POST',
                        data: {q_ids: q_ids},
                        dataType: 'json',
                        success: function (result) {
                            socket.emit('request_delete_hold_recall', {
                                request_delete_hold_recall: "End",
                                service_name: $('#servicegroup :selected').text(),
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
/* Reset From */
function Reset() {
    HiddenInput();
}
$('input[type=checkbox]').on('change', function () {
    if ($(this).is(':checked')) {
        $('input[type=checkbox]').checkboxX('reset');
    } else {
        $(this).prop('checked', true);
    }
});
$('#modal-counter').on('shown.bs.modal', function () {
    $('input[type=checkbox]').checkboxX('reset');
})
$('#modal-counter').on('hidden.bs.modal', function (e) {
    $('input[type=checkbox]').checkboxX('reset');
    HiddenInput();
})