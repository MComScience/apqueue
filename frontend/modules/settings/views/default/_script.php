<?php
$js = <<< JS
$('#from-data').on('beforeSubmit', function (e) {
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: "json",
        success: function (response)
        {
            // $.pjax.reload('#note_update_id'); for pjax update
            toastr.success(response);
        },
        error: function (xhr, status, error)
        {
            swal("Oops...", error, "error");
        }
    });
    return false; // Cancel form submitting.
});      
JS;
$this->registerJs($js);
?>

<script type="text/javascript">
    function Delete() {
        //event.preventDefault();
        var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });
        if (selectedIds.length == 0) {
            swal("No selection!", "กรุณาเลือกรายการที่ต้องการลบ!", "error");
        } else {
            swal({
                title: 'Are you sure?',
                text: selectedIds.length + " รายการที่เลือก",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm!',
                cancelButtonText: 'Cancel!',
            }).then(function () {
                $.ajax({
                    method: "POST",
                    url: "<?= $url ?>",
                    data: {pks: selectedIds},
                    dataType: "json",
                    success: function (result) {
                        $.pjax.reload({container: '#crud-datatable-pjax'});
                        swal.close();
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
            });
        }

    }
</script>