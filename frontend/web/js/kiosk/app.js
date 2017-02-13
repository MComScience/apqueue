function RequestQ(service) {
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
                    swal.close();
                   // swal("Deleted!", "Your imaginary file has been deleted.", "success");
                } else {
                    
                }
            });
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
