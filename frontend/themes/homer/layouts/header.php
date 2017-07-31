<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
?>

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <?= Html::a('APQUEUE APP', ['/'], []) ?>
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">HOMER APP</span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="" class="form-control" name="search">
            </div>
        </form>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <?=
                Nav::widget([
                    'encodeLabels' => false,
                    'options' => [
                        'class' => 'nav navbar-nav'
                    ],
                    'items' => [
                        [
                            'label' => '<i class="fa fa-sign-in"></i> Login',
                            'url' => ['/user/security/login'],
                            'visible' => Yii::$app->user->isGuest
                        ],
                        [
                            'label' => '<i class="pe-7s-users"></i> Profile',
                            'url' => ['/user/settings/profile'],
                            'visible' => !Yii::$app->user->isGuest
                        ],
                        [
                            'label' => '<i class="fa fa-sign-out"></i> Logout',
                            'url' => ['/logout'],
                            'linkOptions' => ['data-method' => 'post'],
                            'visible' => !Yii::$app->user->isGuest
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="navbar-right">
            <?=
            Nav::widget([
                'encodeLabels' => false,
                'options' => [
                    'class' => 'nav navbar-nav no-borders'
                ],
                'items' => [
                    [
                        'label' => '<section>
                            <h5>
                                <span class="profile" >
                                    <span id="time" style="font-size: 14pt;">
                                        <i class="fa fa-calendar"></i>
                                         ' . Yii::$app->thaiYearformat->asDate('full') . '
                                        &nbsp;
                                        <i class="fa fa-clock-o"></i>
                                        &nbsp;
                                        <text id="hours">' . date('H') . '</text> :
                                        <text id="min">' . date('i') . '</text> :
                                        <text id="sec">' . date('s') . '</text>
                                    </span>
                                </span>
                            </h5>
                        </section>',
                        'url' => ['#'],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    /*
                    [
                        'label' => '<i class="pe-7s-speaker"></i>',
                        'url' => ['/main/default/sound'],
                        'visible' => !Yii::$app->user->isGuest
                    ],*/
                    [
                        'label' => '<i class="pe-7s-users"></i>',
                        'url' => ['/user/settings/profile'],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => '<i class="fa fa-sign-out"></i>',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                    [
                        'label' => '<i class="fa fa-sign-in"></i> Login',
                        'url' => ['/user/security/login'],
                        'visible' => Yii::$app->user->isGuest
                    ],
                ],
            ]);
            ?>
        </div>
    </nav>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/clock.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>