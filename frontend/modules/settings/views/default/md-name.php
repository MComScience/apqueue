<?php

use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Html;
use kartik\builder\TabularForm;

echo $this->render('_assets');

$this->title = 'แพทย์';
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
                                        ],
                                        'attributes' => [
                                            'service_md_name_id' => [// primary key attribute
                                                'type' => TabularForm::INPUT_HIDDEN,
                                                'columnOptions' => ['hidden' => true]
                                            ],
                                            'service_md_name' => ['type' => TabularForm::INPUT_TEXT,'label' => 'ชื่อแพทย์'],
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', ['/settings/default/create-mdname'], ['class' => 'btn btn-success', 'role' => 'modal-remote',]) . ' ' .
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
<?php echo $this->render('_script', ['url' => \yii\helpers\Url::to(['/settings/default/delete-md'])]); ?>