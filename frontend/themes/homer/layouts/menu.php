<?php

use common\themes\homer\widgets\Menu;
use common\themes\homer\assets\AvatarAsset;
use yii\helpers\Url;
use yii\helpers\Html;

AvatarAsset::register($this);

$ctrl = Yii::$app->controller;
$url = '/' . $ctrl->module->id . '/' . $ctrl->id . '/' . $ctrl->action->id;

//$avatar = ($userAvatar = Yii::$app->user->identity->getAvatar('small', Yii::$app->user->identity->id)) ? $userAvatar : AvatarAsset::getDefaultAvatar('default');
?>
<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="<?= Url::to(['/user/settings/profile']); ?>">
                <img src="<?= $directoryAsset; ?>/images/profile.jpg" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase" style="font-size: 3px"><?= Yii::$app->user->identity->profile->name; ?></span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Founder of App <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="<?= Url::to(['/user/settings/profile']); ?>">Profile</a></li>
                        <li><a href="analytics.html">Analytics</a></li>
                        <li class="divider"></li>
                        <li><?= Html::a('Logout', ['/user/security/logout'], ['data-method' => 'post']) ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <?php /*
          $nav = new firdows\menu\models\Navigate();
          $menu = $nav->menu(2);
          echo Menu::widget([
          'items' => $menu,
          'options' => ['class' => 'nav', 'id' => 'side-menu'],
          ]); */
        ?>
        <?php
        echo Menu::widget(
                [
                    'options' => ['class' => 'nav', 'id' => 'side-menu'],
                    'items' => [
                        ['label' => 'Dashboard', 'url' => Url::to(['/']), 'active' => $this->context->route == 'site/index'],
                        ['label' => 'Analytics', 'url' => Url::to(['/debug']), 'visible' => Yii::$app->user->isGuest],
                        ['label' => 'Users', 'url' => Url::to(['/user/admin/index'])],
                        ['label' => 'Permissions', 'url' => Url::to(['/admin/assignment'])],
                        [
                            'label' => 'Kiosk',
                            'url' => '#',
                            'template' => '<a href="{url}" >{icon} {label} <span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => 'คัดกรองผู้ป่วยนอก', 'url' => Url::to(['/kiosk/default/index']),'active' => $url == '/kiosk/default/index'],
                                ['label' => 'คิวห้องตรวจโรค', 'url' => Url::to(['/kiosk/default/exmroom']),'active' => $url == '/kiosk/default/exmroom'],
                                ['label' => 'Dispaly1', 'url' => Url::to(['/kiosk/default/display1']),'active' => $url == '/kiosk/default/display1'],
                            ],
                        ],
                    ],
                ]
        )
        ?>
    </div>
</aside>



