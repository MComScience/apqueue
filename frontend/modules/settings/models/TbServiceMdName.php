<?php

namespace frontend\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tb_service_md_name".
 *
 * @property integer $service_md_name_id
 * @property string $service_md_name
 */
class TbServiceMdName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_service_md_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_md_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_md_name_id' => 'Service Md Name ID',
            'service_md_name' => 'Service Md Name',
        ];
    }

    /**
     * @inheritdoc
     * @return TbServiceMdNameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbServiceMdNameQuery(get_called_class());
    }
}
