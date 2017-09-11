<?php

use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\kiosk\models\TbService;
use frontend\modules\settings\models\TbServiceMdName;

echo $this->render('_assets');

$this->title = 'Counter Service';
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
                            <?php Pjax::begin(['id' => 'pjax-grid']); ?>
                            <?php
                            $form = ActiveForm::begin([
                                        //'options' => ['data' => ['pjax' => true]],
                                        'id' => 'from-data'
                            ]);
                            $config = ['template' => "{input}\n{error}\n{hint}"];
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    $mdData = ArrayHelper::map(TbServiceMdName::find()->all(), 'service_md_name_id', 'service_md_name');
                                    $data = ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroupid', 'servicegroup_name');
                                    $dataService = ArrayHelper::map(TbService::find()->all(), 'serviceid', 'service_name');
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
                                          'heading' => '<h3 class="panel-title">' . Icon::show('television', ['class' => 'fa-2x']) . ' Counter Service</h3>',
                                          'type' => GridView::TYPE_PRIMARY,
                                          'after' =>
                                          Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', ['/settings/default/create-counterservice'], ['class' => 'btn btn-success', 'role' => 'modal-remote',]) . ' ' .
                                          Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', false, [
                                          'class' => 'btn btn-danger',
                                          'onclick' => 'Delete();',
                                          ]) . ' ' .
                                          Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
                                          ], */
                                        ],
                                        'attributes' => [
                                            'counterserviceid' => [// primary key attribute
                                                'type' => TabularForm::INPUT_HIDDEN,
                                                'columnOptions' => ['hidden' => true]
                                            ],
                                            'counterservice_name' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ชื่อช่องบริการ'],
                                            'counterservice_callnumber' => ['type' => TabularForm::INPUT_TEXT,'label' => 'หมายเลข'],
                                            'counterservice_type' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ประเภท'],
                                            'servicegroupid' => [
                                                'type' => TabularForm::INPUT_WIDGET,
                                                'widgetClass' => \kartik\widgets\Select2::classname(),
                                                'options' => [
                                                    'data' => $data,
                                                    'pluginOptions' => [
                                                        'placeholder' => 'Select a state ...',
                                                    //'allowClear' => true
                                                    ],
                                                ],
                                                'label' => 'กลุ่มบริการ'
                                            ],
                                            'serviceid' => [
                                                'type' => TabularForm::INPUT_WIDGET,
                                                'widgetClass' => \kartik\widgets\Select2::classname(),
                                                'options' => [
                                                    'data' => $dataService,
                                                    'pluginOptions' => [
                                                        'placeholder' => 'Select a state ...',
                                                        'allowClear' => true
                                                    ],
                                                ],
                                                'label' => 'กลุ่มบริการ'
                                            ],
                                            'userid' => [
                                                'type' => TabularForm::INPUT_WIDGET,
                                                'widgetClass' => \kartik\widgets\Select2::classname(),
                                                'options' => [
                                                    'data' => $mdData,
                                                    'pluginOptions' => [
                                                        'placeholder' => 'Select a state ...',
                                                        'allowClear' => true
                                                    ],
                                                ],
                                                'label' => 'แพทย์'
                                            ],
                                            'sound_stationid' => ['type' => TabularForm::INPUT_TEXT,'label' => 'เครื่องเล่นเสียงที่'],
                                            'sound_typeid' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ประเภทเสียง'],
                                            'counterservice_status' => ['type' => TabularForm::INPUT_TEXT,'label' => 'สถานะ'],
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', ['/settings/default/create-counterservice'], ['class' => 'btn btn-success', 'role' => 'modal-remote',]) . ' ' .
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
<?php echo $this->render('_script', ['url' => \yii\helpers\Url::to(['/settings/default/delete-counter-service'])]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>