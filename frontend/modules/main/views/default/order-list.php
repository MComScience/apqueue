<?php

use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use frontend\modules\kiosk\models\TbQueueorderdetail;
?>
<audio id="notif_audio">
    <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
</audio>
<?= Html::beginForm(['orderdetail'], 'post', ['id' => 'orderdetail']) ?>
<?php foreach ($orderdetail as $v) : ?>
    <?php
    $query = TbQueueorderdetail::find()->where(['q_ids' => $q_ids, 'orderdetailid' => $v['orderdetailid']])->all();
    ?>
    <?php if (!empty($query)): ?>
        <div class="form-group has-success">
            <?php
            echo CheckboxX::widget([
                'name' => 'kv-adv-' . $v['orderdetailid'],
                'value' => TbQueueorderdetail::findOne(['q_ids' => $q_ids, 'orderdetailid' => $v['orderdetailid'], 'q_result' => 'Y']) != null ? $v['orderdetailid'] : 0,
                'options' => ['id' => $v['orderdetailid']],
                'initInputType' => CheckboxX::INPUT_CHECKBOX,
                'autoLabel' => true,
                'labelSettings' => [
                    'label' => $v['orderdetail_dec'],
                    'position' => CheckboxX::LABEL_RIGHT,
                    'options' => [
                        'style' => 'font-size:16pt;',
                    //'checked' => true
                    ]
                ],
                'pluginOptions' => [
                    'size' => 'xl',
                    //'iconChecked' => '<b>&check;</b>',
                    //'iconUnchecked' => '<b>X</b>',
                    'threeState' => false,
                    'theme' => 'krajee-flatblue',
                    'valueChecked' => $v['orderdetailid'],
                ],
            ]);
            ?>  
        </div>
    <?php else: ?>
        <div class="form-group has-success">
            <?php /*
              echo CheckboxX::widget([
              'name' => 'kv-adv-' . $v['orderdetailid'],
              //'value' => $v['orderdetailid'],
              'options' => ['id' => $v['orderdetailid']],
              'initInputType' => CheckboxX::INPUT_CHECKBOX,
              'autoLabel' => true,
              'labelSettings' => [
              'label' => $v['orderdetail_dec'],
              'position' => CheckboxX::LABEL_RIGHT,
              'options' => [
              'style' => 'font-size:16pt;',
              //'checked' => true
              ]
              ],
              'pluginOptions' => [
              'size' => 'xl',
              //'iconChecked' => '<b>&check;</b>',
              //'iconUnchecked' => '<b>X</b>',
              'threeState' => false,
              'theme' => 'krajee-flatblue',
              'valueChecked' => $v['orderdetailid'],
              ],
              ]); */
            ?>  
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<?= Html::input('text', 'q_ids', $q_ids, ['class' => 'form-control', 'type' => 'hidden']) ?>
<?= Html::endForm() ?>
<script>
    $('input[type=checkbox]').on('change', function () {
        if ($(this).is(':checked')) {

        } else {
            $.ajax({
                type: 'POST',
                url: '/apqueue/main/default/save-orderdetail',
                data: {orderid: $(this).val(), q_ids: <?= $q_ids ?>},
                dataType: "json",
                success: function (result) {
                    
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
        }
    });
</script>