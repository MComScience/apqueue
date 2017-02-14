$(function () {
    QueryQNum('AutoLoad','0');
});
function QService(serviceid) {
    swal({
        title: "Confirm?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#74D348",
        confirmButtonText: "OK!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    LoadingClass();
                    QueryQNum('ByConfirm',serviceid);
                } else {

                }
            });
}
function QueryQNum(Events,serviceid) {
    if (Events === 'AutoLoad') {
        $.ajax({
            type: 'POST',
            url: 'get-qnum',
            data: {Events:'Autoload'},
            dataType: "json",
            success: function (result) {
                $('#Service1').html('<strong>' + result.qserive1 + ' คิว</strong>');
                $('#Service2').html('<strong>' + result.qserive2 + ' คิว</strong>');
                $('#Service3').html('<strong>' + result.qserive3 + ' คิว</strong>');
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
    } else if (Events === 'ByConfirm') {
        $.ajax({
            type: 'POST',
            url: 'get-qnum',
            data: {serviceid: serviceid,Events:'ByConfirm'},
            dataType: "json",
            success: function (result) {
                $('#Service' + serviceid).html('<strong>' + result + ' คิว</strong>');
                $('#wrapper').waitMe('hide');
                swal.close();
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
    } else {

    }
}
function LoadingClass() {
    $('#wrapper').waitMe({
        effect: 'roundBounce', //bounce,rotateplane,stretch,orbit,roundBounce,win8,ios,facebook,rotation,timer,pulse,progressBar,bouncePulse,img
        text: 'Loadding...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000', //default #000
        maxSize: '',
        source: '/apqueue/vendor/waitMe/img.svg',
        fontSize: '27px',
        onClose: function () {
        }
    });
}
function GetClassLoading(service) {
    if (service === 1) {
        return 'loaddingq1';
    } else if (service === 2) {
        return 'loaddingq2';
    } else {
        return 'loaddingq3';
    }
}
