<?php
use yii\helpers\Html;
$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-md-6">
        <div class="hpanel">
            <div class="panel-body">
                <div class="text-center">
                    <h2 class="m-b-xs text-success"><?php echo 'คัดกรองผู้ป่วยนอก'; ?></h2>
                    <div class="m">
                        <i class="pe-7s-monitor fa-5x"></i>
                    </div>
                    <?= Html::a('Select Display',['/display1'],['class' => 'btn btn-success btn-lg']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="hpanel">
            <div class="panel-body">
                <div class="text-center">
                    <h2 class="m-b-xs text-success"><?php echo 'ห้องตรวจโรคอายุรกรรม'; ?></h2>
                    <div class="m">
                        <i class="pe-7s-monitor fa-5x"></i>
                    </div>
                    <?= Html::a('Select Display',['/display2'],['class' => 'btn btn-success btn-lg']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="hpanel">
            <div class="panel-body">
                <div class="text-center">
                    <h2 class="m-b-xs text-success"><?php echo 'เสียงเรียก'; ?></h2>
                    <div class="m">
                        <i class="pe-7s-speaker fa-5x"></i>
                    </div>
                    <?= Html::a('Open Page Sound',['/main/default/sound'],['class' => 'btn btn-success btn-lg']) ?>
                </div>
            </div>
        </div>
    </div>
</div>