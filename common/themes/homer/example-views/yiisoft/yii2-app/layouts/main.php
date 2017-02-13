<?php

use common\themes\homer\web\HomerAsset;
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
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
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="fixed-navbar fixed-sidebar">
            <?php $this->beginBody() ?>
            <!-- Simple splash screen-->
            <div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
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
            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
