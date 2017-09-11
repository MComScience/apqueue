<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;

echo $this->render('_assets');
$this->title = 'Reset Q';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <?php echo $this->render('_tabs') ?>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <p><?= Html::a(Icon::show('repeat', [], Icon::BSG) . ' Reset', false, ['class' => 'btn btn-danger','onclick' => 'return ResetQ(this);']) ?></p>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $provider,
                            'filterModel' => $searchModel,
                            //'columns' => $gridColumns,
                            'responsive' => true,
                            'hover' => true,
                            'striped' => false,
                            'pjax' => true,
                            'bordered' => false,
                            'columns' => [
                                [
                                    'class' => '\kartik\grid\SerialColumn'
                                ],
                                'q_num:text',
                                'serviceid',
                                'servicegroupid',
                                'q_qty:integer',
                                'q_wt',
                                'q_timestp:dateTime',
                                'q_issueid',
                                'q_ref',
                                'q_statusid',
                                'q_printstationid',
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function ResetQ() {
        swal({
            title: "Are you sure?",
            text: "Delete All record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "delete-all-q",
                                function (result)
                                {
                                    swal.close();
                                    $.pjax.reload({container: '#w1-pjax'});
                                }
                        ).fail(function (xhr, status, error) {
                            swal(error, "", "error");
                        });
                    }
                });
    }
</script>