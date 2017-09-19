<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use kartik\icons\Icon;
use frontend\modules\main\models\TbCounterservice;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);
$modeldata = TbCounterservice::find()->where(['counterservice_type' => 2])->all();
$this->title = 'คัดกรองผู้ป่วยนอก';
?>
<style type="text/css">
	.btn-success {
		white-space: unset !important;
	}
    .normalheader{
        display: none;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt" style="font-size: 14pt;">
                <?= Html::encode($this->title) ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(1,1,"ผู้ป่วยนัดหมาย");']) ?>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                        <div id="Service1">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยใหม่/ไม่ตรงนัดหมาย</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(1,2,"ผู้ป่วยใหม่/ไม่ตรงนัดหมาย");']) ?>
                    </div>
                    <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                        <div id="Service2">
                            <strong>- คิว</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้สูงอายุ 70 ปี</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(1,3,"ผู้สูงอายุ 70 ปี");']) ?>
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
            <div class="panel-heading hbuilt" style="font-size: 14pt;">
                <?php echo Icon::show('address-card-o', []); ?><?= Html::encode('ห้องตรวจโรค') ?>
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <?php foreach($modeldata as $model): ?>
                	<div class="">
                        <div class="col-sm-4" style="border: 1px solid white;">
                            <?= Html::a(Icon::show('user-md', []).'<strong>'.$model['counterservice_name'].'</strong><p style="line-height: 0.9;font-size: 11pt;">'.(empty(@$model->tbServiceMdName->service_md_name) ? '&nbsp;' : @$model->tbServiceMdName->service_md_name).'</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,'.$model['serviceid'].',"'.$model['counterservice_name'].'");']) ?>
                        </div>
                        <div class="col-sm-2" style="border: 1px solid #62cb31;font-size: 18pt;background-color: white;color: #62cb31;text-align: center;height: 80px;border-radius: 6px;padding-top:10px">
                            <div id="Service<?= $model['serviceid']; ?>">
                                <strong><?= Html::encode('0/0') ?></strong>
                                <p style="line-height: 0.9;"><strong><?= Html::encode('คิว') ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
