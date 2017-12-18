<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use kartik\icons\Icon;
use frontend\modules\main\models\TbCounterservice;
use frontend\modules\kiosk\models\TbService;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);
$modeldata = TbCounterservice::find()->where(['counterservice_type' => 2])->all();
$dataService = TbService::find()->where(['service_groupid' => 1])->all();
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
        <div class="row">
            <div class="col-sm-12">
                <div class="hpanel hgreen">
                    <div class="panel-heading hbuilt" style="font-size: 14pt;">
                        <?= Html::encode($this->title) ?>
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php foreach($dataService as $key => $item): ?>
                            <div class="row">
                                <div class="col-sm-8" style="border: 1px solid white;">
                                    <?= Html::a('<strong>'.$item['service_name'].'</strong>', false, ['class' => 'btn btn-info btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService('.$item['service_groupid'].','.$item['serviceid'].',"'.$item['service_name'].'");']) ?>
                                </div>
                                <div class="col-sm-4" style="border: 1px solid #3498db;font-size: 20pt;background-color: white;color: #3498db;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                                    <div id="Service<?= $item['serviceid']; ?>">
                                        <strong>0 คิว</strong>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="hpanel hgreen">
                    <div class="panel-heading hbuilt" style="font-size: 14pt;">
                        <?= Html::encode('จำนวนคิวรอทั้งหมด') ?>
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8" style="border: 1px solid white;">
                                <?= Html::a('<strong>คัดกรองผู้ป่วยนอก</strong>', false, ['class' => 'btn btn-default btn-lg btn-block', 'style' => 'font-size: 18pt;']) ?>
                            </div>
                            <div class="col-sm-4" style="border: 1px solid #d9dbdd;font-size: 20pt;background-color: white;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                                <div id="SumAll-Service1">
                                    <strong>0 คิว</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8" style="border: 1px solid white;">
                                <?= Html::a('<strong>ห้องตรวจโรค</strong>', false, ['class' => 'btn btn-default btn-lg btn-block', 'style' => 'font-size: 18pt;']) ?>
                            </div>
                            <div class="col-sm-4" style="border: 1px solid #d9dbdd;font-size: 20pt;background-color: white;text-align: center;height: 54px;border-radius: 6px;padding-top:10px">
                                <div id="SumAll-Service2">
                                    <strong>0 คิว</strong>
                                </div>
                            </div>
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
                            <?php if(!@$model->tbServiceMdName->service_md_name) {?>
                                <?= Html::button(Icon::show('user-md', []).'<strong>'.$model['counterservice_name'].'</strong><p style="line-height: 0.9;font-size: 11pt;">&nbsp;</p>',['class' => 'btn btn-warning btn-lg btn-block', 'style' => 'font-size: 18pt;','disabled' => true]); ?>
                            <?php }else{?>
                                <?= Html::a(Icon::show('user-md', []).'<strong>'.$model['counterservice_name'].'</strong><p style="line-height: 0.9;font-size: 11pt;">'.(empty(@$model->tbServiceMdName->service_md_name) ? '&nbsp;' : @$model->tbServiceMdName->service_md_name).'</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,'.$model['serviceid'].',"'.$model['counterservice_name'].'");']) ?>
                            <?php } ?>
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
