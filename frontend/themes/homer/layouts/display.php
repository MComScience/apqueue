<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use common\themes\homer\web\HomerAsset;

HomerAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@common/themes/homer/assets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico" type="image/x-icon">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | '.strtoupper(Yii::$app->params['app.brandLabel']) : null); ?></title>
        <?php $this->head() ?>
    </head>
    <body class="blank">

        <?php $this->beginBody() ?>
        <div class="splash"> 
            
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
        <div class="color-line"></div>

        <?= $content ?>  

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
