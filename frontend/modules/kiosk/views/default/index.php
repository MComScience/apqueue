<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use kartik\icons\Icon;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$this->title = 'คัดกรองผู้ป่วยนอก';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 22pt;">
                <?= Html::encode($this->title) ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(1,1,"ผู้ป่วยนัดหมาย");']) ?>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                        <div id="Service1">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยใหม่/ไม่ตรงนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(1,2,"ผู้ป่วยใหม่/ไม่ตรงนัดหมาย");']) ?>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                        <div id="Service2">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้สูงอายุ 70 ปี</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(1,3,"ผู้สูงอายุ 70 ปี");']) ?>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
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
            <div class="panel-heading hbuilt" style="font-size: 22pt;">
                <?php echo Icon::show('address-card-o', []); ?><?= Html::encode('ห้องตรวจโรค') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
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
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 1</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,21,"ห้องตรวจ 1");']) ?>
                    </div>
                    <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                        <div id="Service21">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 6</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,26,"ห้องตรวจ 6");']) ?>
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
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 2</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,22,"ห้องตรวจ 2");']) ?>
                    </div>
                    <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                        <div id="Service22">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 7</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,27,"ห้องตรวจ 7");']) ?>
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
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 3</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,23,"ห้องตรวจ 3");']) ?>
                    </div>
                    <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                        <div id="Service23">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 8</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,28,"ห้องตรวจ 8");']) ?>
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
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 4</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,24,"ห้องตรวจ 4");']) ?>
                    </div>
                    <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                        <div id="Service24">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 9</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,29,"ห้องตรวจ 9");']) ?>
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
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 5</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,25,"ห้องตรวจ 5");']) ?>
                    </div>
                    <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                        <div id="Service25">
                            <strong><?= Html::encode('0/0') ?></strong>
                            <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>ห้องตรวจ 10</strong><p style="line-height: 0.9;font-size: 14pt;">แพทย์</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'QService(2,30,"ห้องตรวจ 10");']) ?>
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
</div>
<div class="row">
    <div class="col-md-12">
        <marquee direction="left"><p style="font-size: 18pt;">สถาบันบำราศนราดูล</p></marquee>
    </div>
</div>
<br/>
<?= $this->render('modal'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/kiosk/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
