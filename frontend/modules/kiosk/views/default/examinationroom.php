<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use kartik\icons\Icon;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$this->title = 'ห้องตรวจโรค';
?>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="hpanel hgreen">
        <div class="panel-heading hbuilt" style="font-size: 22pt;">
            <?= Html::encode($this->title) ?>
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 1</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,21,"ห้องตรวจ 1");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service21">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 6</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,26,"ห้องตรวจ 6");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service26">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 2</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,22,"ห้องตรวจ 2");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service22">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 7</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,27,"ห้องตรวจ 7");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service27">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 3</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,23,"ห้องตรวจ 3");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service23">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 8</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,28,"ห้องตรวจ 8");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service28">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 4</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,24,"ห้องตรวจ 4");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service24">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 9</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,29,"ห้องตรวจ 9");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service29">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 5</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,25,"ห้องตรวจ 5");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service25">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid white;">
                    <?= Html::a(Icon::show('user-md', []) . '<strong>ห้องตรวจ 10</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,30,"ห้องตรวจ 10");']) ?>
                </div>
                <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                    <div id="Service30">
                        <strong><?= Html::encode('0/0') ?></strong>
                        <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <marquee direction="left"><p style="font-size: 18pt;">สถาบันบำราศนราดูร</p></marquee>
    </div>
</div>
<br/>
<?= $this->render('modal'); ?>
<?= $this->render('js'); ?>