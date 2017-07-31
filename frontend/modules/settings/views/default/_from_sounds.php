<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'Sounds';
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/theme.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 16pt;">
                <i class="pe-7s-volume1"></i> <?= Html::encode('Sounds') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="">
                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'ref', ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'ref', ['showLabels' => false])->textInput(['placeholder' => 'ชื่อโฟรเดอร์']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'file', ['label' => '', 'class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'file[]')->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'audio/*',
                                    'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'initialPreview' => $model->initialPreview($model->file, 'file', 'file'), //<-----
                                    'initialPreviewConfig' => $model->initialPreview($model->file, 'file', 'config'), //<-----
                                    //'overwriteInitial' => false,
                                    //'previewFileIcon' => '<i class="fa fa-file"></i>',
                                    'theme' => 'explorer',
                                    'overwriteInitial' => false,
                                    'initialPreviewShowDelete' => true,
                                    /*'uploadUrl' => Url::to(['/photo-library/upload-ajax']),
                                    'uploadExtraData' => [
                                        'ref' => $model->ref,
                                        'model' => $model
                                    ],*/
                                    'initialPreviewAsData' => true,
                                    'initialPreviewFileType' => 'audio',
                                    'allowedFileTypes' => ['audio'],
                                    'maxFileCount' => 20
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <hr>
                            <?= Html::a('Close', ['/settings/default/sound-list'], ['class' => 'btn btn-default']) ?>
                            <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?> 
                        </div>
                    </div>
                    <br><br>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/theme.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>