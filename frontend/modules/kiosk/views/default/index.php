<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;


SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$this->title = Yii::$app->name;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                <h1><?= Html::encode('คัดกรองผู้ป่วยนอก') ?></h1>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(1);']) ?>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;font-size: 20pt;background-color: #3498db;color: white;text-align: center;height: 57px;border-radius: 3px;padding-top:10px">
                        <div id="Service1">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยใหม่/ไม่ตรงนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;','onclick' => 'QService(2);']) ?>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;font-size: 20pt;background-color: #3498db;color: white;text-align: center;height: 57px;border-radius: 3px;padding-top:10px">
                        <div id="Service2">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้สูงอายุ 70 ปี</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;','onclick' => 'QService(3);']) ?>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;font-size: 20pt;background-color: #3498db;color: white;text-align: center;height: 57px;border-radius: 3px;padding-top:10px">
                        <div id="Service3">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                <h1><?= Html::encode('ห้องตรวจโรค') ?></h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-2">
                        <p style="font-size: 18pt;">รอ/จ่าย</p>
                    </div>
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-2">
                        <p style="font-size: 18pt;">รอ/จ่าย</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 1</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content1">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 6</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content6">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 2</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content2">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 7</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content7">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 3</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content3">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 8</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content8">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 4</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content4">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 9</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content9">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 5</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content5">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid white;">
                        <?= Html::a('<strong>ห้องตรวจ 10</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2" style="border: 1px solid white;font-size: 18pt;background-color: #62cb31;color: white;text-align: center;height: 80px;border-radius: 3px;padding-top:10px">
                        <div id="content10">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <marquee direction="left"><p style="font-size: 18pt;">สถาบันบำราศนราดูล</p></marquee>
    </div>
</div>
<br/>
<?= $this->render('modal'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/kiosk/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

