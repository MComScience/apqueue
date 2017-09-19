<?php 
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
?>
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'id' => 'form-order']); ?>
    <?php foreach ($orderdetail as $index => $order) : ?>
        <div class="form-group">
            <?= Html::activeLabel($order, "[$index]orderdetailid", ['label' => '','class'=>'col-sm-2 control-label']) ?>
            <div class="col-sm-4">
                <?php echo $form->field($order, "[$index]orderdetailid",['showLabels'=>false])->widget(CheckboxX::classname(), [
                    'pluginOptions' => [
                        'size' => 'xl',
                        'threeState' => false,
                        'theme' => 'krajee-flatblue',
                        //'valueChecked' => $order[''],
                    ],
                    'labelSettings' => [
                        'label' => $order->orderdetail_dec,
                        'position' => CheckboxX::LABEL_RIGHT,
                        'options' => [
                            'style' => 'font-size:16pt;',
                        ]
                    ],
                    'options' => [
                        'value' => $tbq->getValueOrder($tbq['q_ids'],$order['orderdetailid']),
                    ]
                ]); ?>

                <?php echo $form->field($order, "[$index]order_ids")->hiddenInput([
                    'value' => $order['orderdetailid']
                    //$tbq->getOrderid($tbq['q_ids'],$order['orderdetailid']),
                ])->label(false); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php echo $form->field($tbq, "q_ids")->hiddenInput()->label(false); ?>
<?php ActiveForm::end(); ?>