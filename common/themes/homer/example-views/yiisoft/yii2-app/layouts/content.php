<?php

use yii\widgets\Breadcrumbs;
use common\themes\homer\widgets\Alert;
use yii\helpers\Html;
?>
<div id="wrapper">
    <div class="content animate-panel">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>
</div>