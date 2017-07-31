<?php
use softark\duallistbox\DualListbox;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => $model->formName(),'type'=>ActiveForm::TYPE_HORIZONTAL]); ?>
    <div class="form-group">
        <?php
            $options = [
                'multiple' => true,
                'size' => 2,
            ];
            // echo Html::activeListBox($model, $attribute, $items, $options);
            echo DualListbox::widget([
                'model' => $model,
                'attribute' => 'q_num',
                'items' => $items,
                'options' => $options,
                'clientOptions' => [
                    'moveOnSelect' => true,
                    'selectedListLabel' => 'Selected Items',
                    'nonSelectedListLabel' => 'Available Items',
                    'selectorMinimalHeight' => 200
                ],
            ]);
        ?>
    </div>
    <div class="form-group">
        <div class="pull-right">
            <?= Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"]) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>  
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
$("#TbQuequ").on('beforeSubmit', function (e) {
    alert($('[name="TbQuequ[q_num][]"]').val());
    return false;
});
JS
);
?>
