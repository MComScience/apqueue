<?php

use common\themes\homer\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\main\classes\MainQuery;

?>
<?php if (Yii::$app->controller->action->id == 'index') : ?>

<?php endif; ?>
<?php if (Yii::$app->controller->action->id == 'order-check') : ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
            Modal::begin([
                'id' => 'modal-orderdetail',
                'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
                'footer' => Html::button('Cancel', ['class' => 'btn btn-default btn-lg', 'data-dismiss' => 'modal']) . ' '
                . Html::a('Save', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'App.Save(this);']),
            ]);
            ?>
            <audio id="notif_audio">
                <source src="<?= Yii::getAlias('@web').'/sounds/alert.mp3' ?>" type="audio/mpeg">
            </audio>
            <div id="order-list"></div>
            <?php
            Modal::end();
            ?>
        </div>
    </div>

<?php endif; ?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    "size" => 'modal-lg'
])?>
<?php Modal::end(); ?>