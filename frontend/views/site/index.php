<?php
/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1><?= Yii::$app->name ?>!</h1>
    </div>
<!--    <div class="row">
        <div class="col-lg-4">
            <div class="hpanel">
                <div class="panel-heading hbuilt">Print</div>
                <div class="panel-body float-e-margins">
                    <p>
                        <a class="btn btn-outline btn-info btn-lg" onclick="PrintReport(1);">
                            <i class="fa fa-print"></i>
                            Printtest 1
                        </a>
                    </p>
                    <p>
                        <a class="btn btn-outline btn-info btn-lg" onclick="PrintReport(2);">
                            <i class="fa fa-print"></i>
                            Printtest 2
                        </a>
                    </p> 
                </div>
            </div>
        </div>
    </div>-->
</div>
<script type="text/javascript">
    function PrintReport(Copies) {
        var printWindow = window.open('report/apqueue/index', /*'_blank'*/"", "top=100,left=auto,width=" + screen.width + ",height=550");
        var Count = 0;
        printWindow.print();
        /*$.post(
         'report/apqueue/report',
         {
         
         },
         function ()
         {
         //newwindow.focus();
         //                    setTimeout(function () {
         //                        newwindow.print();
         //                        newwindow.close();
         //                    }, 3000);
         
         if (newwindow.focus) {
         while (Count < Copies) {
         
         Count++;
         }
         }
         //                    if (!newwindow.closed) {
         //                        newwindow.focus();
         //                    }
         //////                    return false;
         }
         )*/
    }

</script>