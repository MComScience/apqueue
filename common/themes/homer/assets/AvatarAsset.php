<?php

namespace common\themes\homer\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * AvatarAsset is an asset bundle for avatar image.
 */
class AvatarAsset extends AssetBundle
{
    public $sourcePath = '@common/themes/homer/assets/images';

    public static function getDefaultAvatar($size = 'small')
    {
        $avatars = [
            'small' => 'avatar-48x48.png',
            'medium' => 'avatar-96x96.png',
            'large' => 'avatar-144x144.png',
            'default' => 'profile.jpg',
        ];

        if (isset(Yii::$app->assetManager->bundles[self::className()]) && isset($avatars[$size])) {
            return Yii::$app->assetManager->bundles[self::className()]->baseUrl . '/' . $avatars[$size];
        }

        return false;
    }
}