<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            APQUEUE APP
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
                <ul class="nav navbar-nav">
                    <li>
                        <?= Html::a('Logout', ['/user/security/logout'], ['data-method' => 'post']); ?>
                    </li>
                    <li>
                        <?= Html::a('Profile', ['/user/settings/profile']); ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <?php /*
                  <li class="dropdown">
                  <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                  <i class="pe-7s-speaker"></i>
                  </a>
                  <ul class="dropdown-menu hdropdown notification animated flipInX">
                  <li>
                  <a>
                  <span class="label label-success">NEW</span> It is a long established.
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="label label-warning">WAR</span> There are many variations.
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="label label-danger">ERR</span> Contrary to popular belief.
                  </a>
                  </li>
                  <li class="summary"><a href="#">See all notifications</a></li>
                  </ul>
                  </li>
                  <li class="dropdown">
                  <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                  <i class="pe-7s-keypad"></i>
                  </a>

                  <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                  <table>
                  <tbody>
                  <tr>
                  <td>
                  <a href="<?= Url::to('/menuconfig/default/widgets'); ?>">
                  <i class="pe pe-7s-portfolio text-info"></i>
                  <h5>Projects</h5>
                  </a>
                  </td>
                  <td>
                  <a href="mailbox.html">
                  <i class="pe pe-7s-mail text-warning"></i>
                  <h5>Email</h5>
                  </a>
                  </td>
                  <td>
                  <a href="contacts.html">
                  <i class="pe pe-7s-users text-success"></i>
                  <h5>Contacts</h5>
                  </a>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <a href="forum.html">
                  <i class="pe pe-7s-comment text-info"></i>
                  <h5>Forum</h5>
                  </a>
                  </td>
                  <td>
                  <a href="analytics.html">
                  <i class="pe pe-7s-graph1 text-danger"></i>
                  <h5>Analytics</h5>
                  </a>
                  </td>
                  <td>
                  <a href="file_manager.html">
                  <i class="pe pe-7s-box1 text-success"></i>
                  <h5>Files</h5>
                  </a>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  </div>
                  </li>
                  <li class="dropdown">
                  <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                  <i class="pe-7s-mail"></i>
                  <span class="label label-success">4</span>
                  </a>
                  <ul class="dropdown-menu hdropdown animated flipInX">
                  <div class="title">
                  You have 4 new messages
                  </div>
                  <li>
                  <a>
                  It is a long established.
                  </a>
                  </li>
                  <li>
                  <a>
                  There are many variations.
                  </a>
                  </li>
                  <li>
                  <a>
                  Lorem Ipsum is simply dummy.
                  </a>
                  </li>
                  <li>
                  <a>
                  Contrary to popular belief.
                  </a>
                  </li>
                  <li class="summary"><a href="#">See All Messages</a></li>
                  </ul>
                  </li>
                  <li>
                  <a href="#" id="sidebar" class="right-sidebar-toggle">
                  <i class="pe-7s-upload pe-7s-news-paper"></i>
                  </a>
                  </li>
                 * 
                 */ ?>
                <li>
                    <a class="login-area dropdown-toggle" data-toggle="dropdown" title="Mails" href="#">
                        <section>
                            <h5>
                                <span class="profile" >
                                    <span id="time" style="font-size: 14pt;">
                                        <i class="fa fa-calendar"></i> 
                                        <?php
                                        echo Yii::$app->thaiYearformat->asDate('full');
                                        ?>
                                        &nbsp;
                                        <i class="fa fa-clock-o"></i>
                                        &nbsp;
                                        <text id="hours"></text> :
                                        <text id="min"></text> :
                                        <text id="sec"></text>
                                    </span>
                                </span>
                            </h5>
                        </section>
                    </a>
                </li>
                <?php if(!Yii::$app->user->isGuest) : ?>
                <li class="dropdown">
                    <?= Html::a('<i class="pe-7s-upload pe-rotate-90"></i>', ['/user/security/logout'], ['data-method' => 'post']); ?>
                </li>
                <?php else :  ?>
                <li class="dropdown">
                    <?= Html::a('<i class="pe-7s-unlock"></i> Login', ['/user/login'], []); ?>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/clock.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>