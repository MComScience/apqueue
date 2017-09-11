<?php

use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use kartik\icons\Icon;
use frontend\modules\main\models\TbCounterservice;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$modeldata = TbCounterservice::find()->where(['counterservice_type' => 2])->all();
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
            <?php foreach($modeldata as $model): ?>
                <div class="">
                    <div class="col-sm-4" style="border: 1px solid white;">
                        <?= Html::a(Icon::show('user-md', []).'<strong>'.$model['counterservice_name'].'</strong><p style="line-height: 0.9;font-size: 14pt;">'.@$model->tbServiceMdName->service_md_name.'</p>', false, ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'font-size: 18pt;', 'onclick' => 'Kiosk.QService(2,'.$model['serviceid'].',"'.$model['counterservice_name'].'");']) ?>
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
<div class="row">
    <div class="col-md-12">
        <marquee direction="left"><p style="font-size: 18pt;">สถาบันบำราศนราดูร</p></marquee>
    </div>
</div>
<br/>
<?= $this->render('modal'); ?>
<?= $this->render('js'); ?>