<?php

namespace frontend\modules\main\models;

use Yii;
use frontend\modules\settings\models\TbServiceMdName;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "tb_counterservice".
 *
 * @property integer $counterserviceid
 * @property string $counterservice_name
 * @property integer $servicegroupid
 * @property integer $userid
 * @property string $serviceid
 * @property integer $sound_stationid
 * @property integer $sound_typeid
 * @property string $counterservice_status
 */
class TbCounterservice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_counterservice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicegroupid', 'userid', 'sound_stationid', 'sound_typeid'], 'integer'],
            [['counterservice_name'], 'string', 'max' => 100],
            [['serviceid'], 'string', 'max' => 20],
            [['counterservice_status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'counterserviceid' => 'Counterserviceid',
            'counterservice_name' => 'Counterservice Name',
            'servicegroupid' => 'Servicegroupid',
            'userid' => 'Userid',
            'serviceid' => 'Serviceid',
            'sound_stationid' => 'Sound Stationid',
            'sound_typeid' => 'Sound Typeid',
            'counterservice_status' => 'Counterservice Status',
        ];
    }

    public function getTbServiceMdName()
    {
        return $this->hasOne(TbServiceMdName::className(), ['service_md_name_id' => 'userid']);
    }

    /**
     * @inheritdoc
     * @return TbCounterserviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbCounterserviceQuery(get_called_class());
    }

    public function getChildServeice($id){
        $result = [];
        if($id != null){
            $result = ArrayHelper::map(TbCounterservice::find()->andWhere(['servicegroupid'=>$id])->asArray()->all(),'counterserviceid','counterservice_name');
        }
        return $result;
    }
}
