<?php

use common\themes\homer\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\main\classes\MainQuery;
use kartik\checkbox\CheckboxX;

$counter1 = MainQuery::getCounterlist(1);
$counter2 = MainQuery::getCounterlist(2);
?>
<?php
Modal::begin([
    'id' => 'modal-counter',
    'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
    . Html::a('Print Withhout Order', false, ['class' => 'btn btn-info', 'onclick' => 'PrintWithoutOrder(this);']) . ' '
    . Html::a('Print', false, ['class' => 'btn btn-success','onclick' => 'Print(this);']),
]);
?>
<audio id="notif_audio">
    <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
</audio>
<?= Html::beginForm(['counter'], 'post', []) ?>
<?php foreach ($counter1 as $v) : ?>
<div class="form-group">
    <div class="radio">
        <label>
            <?= Html::input('radio', 'counter_name', $v['counterserviceid'], ['class' => 'i-checks']) ?>
            <?= $v['counterservice_name']; ?>
        </label>
    </div>
</div>
<?php endforeach; ?>
<?= Html::endForm() ?>
<?php
Modal::end();
?>