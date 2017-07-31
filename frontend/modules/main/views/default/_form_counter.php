 <?php
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use frontend\modules\main\models\TbCounterservice;

$counter1 = TbCounterservice::find()->where(['servicegroupid' => 1])->all();
$counter2 = TbCounterservice::find()->where(['servicegroupid' => 2])->all();
 ?>   
    <div class="row">
        <div class="col-sm-12">
            <audio id="notif_audio">
                <source src="<?= Yii::getAlias('@web').'/sounds/alert.mp3' ?>" type="audio/mpeg">
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
$this->registerJs(<<<JS
$('input[type=checkbox]').on('change', function () {
    var cerrentid = $(this).attr('id');
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            if(cerrentid !== $(this).attr('id')){
                $('#' + $(this).attr('id')).checkboxX('reset');
            }
        }
    });
});
JS
);?>