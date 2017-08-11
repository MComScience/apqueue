<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "tb_service".
 *
 * @property integer $serviceid
 * @property string $service_name
 * @property integer $service_groupid
 * @property integer $service_route
 * @property integer $prn_profileid
 * @property integer $prn_copyqty
 * @property integer $service_numdigit
 * @property string $service_prefix
 * @property string $service_status
 */
class TbService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name', 'service_groupid', 'service_route'], 'required'],
            [['service_groupid', 'service_route', 'prn_profileid', 'prn_copyqty', 'service_numdigit'], 'integer'],
            [['service_name'], 'string', 'max' => 100],
            [['service_prefix'], 'string', 'max' => 2],
            [['service_status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'serviceid' => 'Serviceid',
            'service_name' => 'Service Name',
            'service_groupid' => 'Service Groupid',
            'service_route' => 'Service Route',
            'prn_profileid' => 'Prn Profileid',
            'prn_copyqty' => 'Prn Copyqty',
            'service_numdigit' => 'Service Numdigit',
            'service_prefix' => 'Service Prefix',
            'service_status' => 'Service Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TbServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbServiceQuery(get_called_class());
    }
}
