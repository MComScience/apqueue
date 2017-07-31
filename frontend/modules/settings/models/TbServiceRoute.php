<?php

namespace frontend\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tb_service_route".
 *
 * @property integer $ids
 * @property integer $service_route
 * @property integer $service_group_seq
 * @property string $service_status
 */
class TbServiceRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_service_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_route', 'service_group_seq', 'service_status'], 'required'],
            [['service_route', 'service_group_seq'], 'integer'],
            [['service_status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'service_route' => 'Service Route',
            'service_group_seq' => 'Service Group Seq',
            'service_status' => 'Service Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TbServiceRouteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbServiceRouteQuery(get_called_class());
    }
}
