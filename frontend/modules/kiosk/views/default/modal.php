<?php

use common\themes\homer\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\kiosk\models\TbOrderdetail;

$order = TbOrderdetail::find()->all();
?>
<?php
Modal::begin([
    'id' => 'modal-orderdetail',
    'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
    . Html::a('Print Withhout Order', false, ['class' => 'btn btn-info', 'onclick' => 'PrintWithoutOrder(this);']) . ' '
    . Html::a('Print', false, ['class' => 'btn btn-success','onclick' => 'Print(this);']),
]);
?>
<h2><?= Html::encode('เลือกช่องบริการ') ?></h2>
<audio id="notif_audio">
    <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
</audio>
<?= Html::beginForm(['orderdetail'], 'post', []) ?>
<?php foreach ($order as $v) : ?>
    <div class="radio">
        <label style="font-size:16pt;"><?= Html::input('checkbox', 'ordername', $v['orderdetailid'], ['class' => 'i-checks']) ?> <?= $v['orderdetail_dec']; ?></label>
    </div>
<?php endforeach; ?>
<input id="service-room-id" name="service_room" class="form-control" type="hidden"/>
<?= Html::endForm() ?>
<?php
Modal::end();
?>
