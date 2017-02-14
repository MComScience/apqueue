<?php

use common\themes\homer\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\kiosk\models\TbOrderdetail;

$order = TbOrderdetail::find()->all();
?>
<?php
Modal::begin([
    'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Cancel',['class' => 'btn btn-default','data-dismiss' => 'modal'])
]);
?>
<?= Html::beginForm(['order/update'], 'post', []) ?>
<?php foreach ($order as $v) : ?>
    <div class="radio">
        <label><?= Html::input('radio', 'ordername', $v['orderdetailid'], ['class' => 'i-checks']) ?> <?= $v['orderdetail_dec']; ?></label>
    </div>
<?php endforeach; ?>
<?= Html::endForm() ?>
<?php
Modal::end();
?>
