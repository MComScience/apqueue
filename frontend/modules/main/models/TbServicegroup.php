<?php

namespace frontend\modules\main\models;

use Yii;

/**
 * This is the model class for table "tb_servicegroup".
 *
 * @property integer $servicegroupid
 * @property string $servicegroup_name
 */
class TbServicegroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_servicegroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicegroup_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'servicegroupid' => 'Servicegroupid',
            'servicegroup_name' => 'Servicegroup Name',
        ];
    }

    /**
     * @inheritdoc
     * @return TbQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbQuery(get_called_class());
    }
}
