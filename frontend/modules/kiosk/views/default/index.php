<?php
use yii\helpers\Html;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$this->title = Yii::$app->name;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                <h1>คัดกรองผู้ป่วยนอก</h1>
            </div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-md-6 col-md-offset-1" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยนัดหมาย</strong>',false,['class' => 'btn btn-success btn-lg btn-block','style' => 'font-size: 40pt;','onclick' => 'RequestQ(1);']) ?>
                    </div>
                    <div class="col-md-2 loaddingq1" style="border: 1px solid white;font-size: 40pt;background-color: #74d348;color: white;text-align: center;height: 93px;border-radius: 3px;padding-top:10px">
                        <strong><div id="content1">0 คิว</div></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-1" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้ป่วยใหม่</strong>',false,['class' => 'btn btn-success btn-lg btn-block','style' => 'font-size: 40pt;']) ?>
                    </div>
                    <div class="col-md-2 loaddingq2" style="border: 1px solid white;font-size: 40pt;background-color: #74d348;color: white;text-align: center;height: 93px;border-radius: 3px;padding-top:10px">
                        <strong>0 คิว</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-1" style="border: 1px solid white;">
                        <?= Html::a('<strong>ผู้นัดหมาย ไม่ตรงนัด</strong>',false,['class' => 'btn btn-success btn-lg btn-block','style' => 'font-size: 40pt;']) ?>
                    </div>
                    <div class="col-md-2 loaddingq3" style="border: 1px solid white;font-size: 40pt;background-color: #74d348;color: white;text-align: center;height: 93px;border-radius: 3px;padding-top:10px">
                        <strong>0 คิว</strong>
                    </div>
                </div>
                <marquee direction="left"><p style="font-size: 18pt;">สถาบันบำราศนราดูล</p></marquee>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/kiosk/app.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

