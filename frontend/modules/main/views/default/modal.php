<?php

use common\themes\homer\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\main\classes\MainQuery;
use kartik\checkbox\CheckboxX;
use frontend\modules\main\models\TbCounterservice;

$counter1 = TbCounterservice::find()->where(['servicegroupid' => 1])->all();
$counter2 = TbCounterservice::find()->where(['servicegroupid' => 2])->all();
?>
<?php if (Yii::$app->controller->action->id == 'index') : ?>

    <?php
    Modal::begin([
        'id' => 'modal-counter',
        'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
        'footer' => Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
        . Html::a('Call', false, ['class' => 'btn btn-success', 'onclick' => 'Call(this);']),
    ]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <audio id="notif_audio">
                <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
            </audio>
            <?= Html::beginForm(['counter'], 'post', []) ?>
            <?php foreach ($counter1 as $v) : ?>
                <div class="form-group has-success hide-service display-none" style="display: none;">
                    <div class="col-sm-6">
                        <?php
                        echo CheckboxX::widget([
                            'name' => 'kv-adv-' . $v['counterserviceid'],
                            //'value' => $v['counterserviceid'],
                            'options' => ['id' => $v['counterserviceid']],
                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => $v['counterservice_name'],
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
                                'valueChecked' => $v['counterserviceid'],
                            ],
                        ]);
                        ?>  
                    </div>
                </div>
            <?php endforeach; ?>
            <?php foreach ($counter2 as $v) : ?>
                <div class="form-group has-success hide-counter display-none" style="display: none;">
                    <div class="col-sm-6">
                        <?php
                        echo CheckboxX::widget([
                            'name' => 'kv-adv-' . $v['counterserviceid'],
                            //'value' => $v['counterserviceid'],
                            'options' => ['id' => $v['counterserviceid']],
                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => $v['counterservice_name'],
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
                                'valueChecked' => $v['counterserviceid'],
                            ],
                        ]);
                        ?>  
                    </div>
                </div>
            <?php endforeach; ?>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php
    Modal::end();
    ?>

<?php endif; ?>
<?php if (Yii::$app->controller->action->id == 'order-check') : ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
            Modal::begin([
                'id' => 'modal-orderdetail',
                'header' => '<h4 class="modal-title" style="text-align: center;">' . Html::encode('') . '</h4>',
                'footer' => Html::button('Cancel', ['class' => 'btn btn-default btn-lg', 'data-dismiss' => 'modal']) . ' '
                . Html::a('Save', false, ['class' => 'btn btn-success btn-lg', 'onclick' => 'Save(this);']),
            ]);
            ?>
            <audio id="notif_audio">
                <source src="/apqueue/sounds/alert.mp3" type="audio/mpeg">
            </audio>
            <div id="order-list"></div>
            <?php
            Modal::end();
            ?>
        </div>
    </div>

<?php endif; ?>
