<?php

use common\themes\homer\web\HomerAsset;
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login' || Yii::$app->controller->action->id === 'register' || Yii::$app->controller->action->id === 'resend' || Yii::$app->controller->action->id === 'request' || Yii::$app->controller->action->id === 'reset') {
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        frontend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    HomerAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@common/themes/homer/assets');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <link rel="shortcut icon" href="<?= $directoryAsset ?>/images/favicon.png" type="image/x-icon">
            <?= Html::csrfMetaTags() ?>
            <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | APQUEUE' : null); ?></title>
            <?php $this->head() ?>
        </head>
        <body class="fixed-navbar fixed-sidebar hide-sidebar">
            <?php $this->beginBody() ?>
            <!-- Simple splash screen-->
            <div class="splash"> 
                <div class="color-line"></div>
                <div class="splash-title">
                    <h1>APQUEUE APP</h1>
                    <p></p>
                    <div class="spinner"> 
                        <div class="rect1"></div> 
                        <div class="rect2"></div> 
                        <div class="rect3"></div> 
                        <div class="rect4"></div> 
                        <div class="rect5"></div> 
                    </div> 
                </div> 
            </div>
            <?=
            $this->render(
                    'header.php', ['directoryAsset' => $directoryAsset]
            )
            ?>
            <?=
            $this->render(
                    'menu.php', ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?=
            $this->render(
                    'content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]
            )
            ?>
            <?= \bluezed\scrollTop\ScrollTop::widget() ?>
            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
