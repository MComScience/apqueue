<?php

use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Html;
use kartik\builder\TabularForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\settings\models\TbServiceRoute;

echo $this->render('_assets');

$this->title = 'Service';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <?php echo $this->render('_tabs') ?>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div id="ajaxCrudDatatable">
                            <?php Pjax::begin(['id' => 'pjax-grid',]); ?>
                            <?php
                            $form = ActiveForm::begin([
                                        //'options' => ['data' => ['pjax' => true]],
                                        'id' => 'from-data',
                            ]);
                            $config = ['template' => "{input}\n{error}\n{hint}"];
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    $dataServiceGroup = ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroupid', 'servicegroup_name');
                                    $dataServiceRoute = ArrayHelper::map(TbServiceRoute::find()->all(), 'ids', 'service_route');
                                    echo TabularForm::widget([
                                        'dataProvider' => $dataProvider,
                                        'form' => $form,
                                        //'checkboxColumn' => false,
                                        'actionColumn' => false,
                                        'rowSelectedClass' => GridView::TYPE_SUCCESS,
                                        'gridSettings' => [
                                            'floatHeader' => false,
                                            'id' => 'crud-datatable',
                                            'striped' => true,
                                            'pjax' => true,
                                        /*
                                          'panel' => [
                                          'heading' => '<h3 class="panel-title">' . Icon::show('television', ['class' => 'fa-2x']) . $this->title . '</h3>',
                                          'type' => GridView::TYPE_PRIMARY,
                                          'after' =>
                                          Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', ['/settings/default/create-service'], ['class' => 'btn btn-success', 'role' => 'modal-remote',]) . ' ' .
                                          Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', false, [
                                          'class' => 'btn btn-danger',
                                          'onclick' => 'Delete();',
                                          ]) . ' ' .
                                          Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
                                          ], */
                                        ],
                                        'attributes' => [
                                            'serviceid' => [// primary key attribute
                                                'type' => TabularForm::INPUT_HIDDEN,
                                                'columnOptions' => ['hidden' => true]
                                            ],
                                            'service_name' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ชื่อการบริการ'],
                                            'service_groupid' => [
                                                'type' => TabularForm::INPUT_WIDGET,
                                                'widgetClass' => Select2::classname(),
                                                'options' => [
                                                    'data' => $dataServiceGroup,
                                                    'pluginOptions' => [
                                                        'placeholder' => 'Select a state ...',
                                                    //'allowClear' => true
                                                    ],
                                                ],
                                                'label' => 'กลุ่มบริการ'
                                            ],
                                            'service_route' => [
                                                'type' => TabularForm::INPUT_WIDGET,
                                                'widgetClass' => Select2::classname(),
                                                'options' => [
                                                    'data' => $dataServiceRoute,
                                                    'pluginOptions' => [
                                                        'placeholder' => 'Select a state ...',
                                                    //'allowClear' => true
                                                    ],
                                                ],
                                                'label' => 'เส้นทางการบริการที่'
                                            ],
                                            'prn_profileid' => ['type' => TabularForm::INPUT_TEXT,'label' => 'รูปแบบการพิมพ์'],
                                            'prn_copyqty' => ['type' => TabularForm::INPUT_TEXT,'label' => 'จำนวนบัตรคิว'],
                                            'service_numdigit' => ['type' => TabularForm::INPUT_TEXT,'label' => 'จำนวนหลักเลขคิว'],
                                            'service_prefix' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ตัวอักษรนำหน้าเลขคิว'],
                                            'service_status' => ['type' => TabularForm::INPUT_TEXT,'label' => 'สถานะ'],
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', ['/settings/default/create-service'], ['class' => 'btn btn-success', 'role' => 'modal-remote',]) . ' ' .
                                    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', false, [
                                        'class' => 'btn btn-danger',
                                        'onclick' => 'Delete();',
                                    ]) . ' ' .
                                    Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
                                    ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('_modal'); ?>
<?php echo $this->render('_script', ['url' => \yii\helpers\Url::to(['/settings/default/delete-service'])]); ?>
