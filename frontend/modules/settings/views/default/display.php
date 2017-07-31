<?php

use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;

echo $this->render('_assets');
$this->title = 'Settings Display';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .grid-view td {
        white-space: nowrap;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <?php echo $this->render('_tabs') ?>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <?php echo $this->render('_form', ['model' => $model]); ?>
                        <div class="hr-line-dashed"></div>
                        <div id="ajaxCrudDatatable">
                            <?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax-grid']); ?>
                            <?php
                            $form = ActiveForm::begin([
                                        'options' => ['data' => ['pjax' => true]],
                            ]);
                            $config = ['template' => "{input}\n{error}\n{hint}"];
                            ?>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    echo TabularForm::widget([
                                        'dataProvider' => $dataProvider,
                                        'form' => $form,
                                        'attributes' => $model->formAttribs,
                                        //'checkboxColumn' => false,
                                        'rowSelectedClass' => GridView::TYPE_SUCCESS,
                                        'gridSettings' => [
                                            'floatHeader' => false,
                                            'id' => 'crud-datatable',
                                            'pjax' => true,
                                            'layout' => "{summary}\n{items}\n{pager}",
//                                        'panel' => [
//                                            //'heading' => '<h3 class="panel-title">' . Icon::show('television', ['class' => 'fa-2x']) . ' Config Display</h3>',
//                                            //'type' => GridView::TYPE_PRIMARY,
//                                            'after' => Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', false, ['class' => 'btn btn-danger', 'id' => 'btn-delete', 'onclick' => 'Delete(this);']) . ' ' .
//                                            Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
//                                        ],
                                        ],
                                        'actionColumn' => [
                                            'class' => '\kartik\grid\ActionColumn',
                                            'template' => '{view} {setting} {apply}',
                                            'buttons' => [
                                                'view' => function ($url, $model, $key) {
                                                    return Html::a('<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-default', 'target' => '_blank', 'data-pjax' => 0]);
                                                },
                                                'setting' => function($url, $model, $key) {
                                                    return Html::a('ตั้งค่าเพิ่มเติม', ['/settings/default/add-settings', 'id' => $key], ['class' => 'btn btn-sm btn-primary', 'role' => 'modal-remote']);
                                                },
                                                'apply' => function ($url, $model, $key) {
                                                    return Html::a('Apply', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'ApplyDisplay(' . '"' . $model['display_name'] . '"' . ')']);
                                                },
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', false, ['class' => 'btn btn-danger', 'id' => 'btn-delete', 'onclick' => 'Delete(this);']) . ' ' .
                                    Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
                                    ?>
                                </div>
                            </div>
                            <?php
                            ActiveForm::end();
                            Pjax::end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('_modal'); ?>
<script type="text/javascript">
    function Delete() {
        var keys = $("#crud-datatable").yiiGridView("getSelectedRows");
        if (keys.length > 0) {
            swal({
                title: "Are you sure?",
                text: "Delete " + keys.length + " record!",
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
                                    "delete-all",
                                    {ids: keys.join()},
                                    function (result)
                                    {
                                        swal(result, "", "success");
                                        $.pjax.reload({container: '#pjax-grid'});
                                    }
                            ).fail(function (xhr, status, error) {
                                swal(error, "", "error");
                            });
                        }
                    });
        }
    }
    function ConfigState(state, id, display_name) {
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        socket.emit('display_state', {
            state_display: state,
            id: id,
            display_name: display_name
        });
    }

    function ApplyDisplay(DisplayName) {
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        socket.emit('apply_display', {
            display_name: DisplayName
        });
    }
</script>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>