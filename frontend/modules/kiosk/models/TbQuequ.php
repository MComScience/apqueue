<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "tb_quequ".
 *
 * @property integer $q_ids
 * @property string $q_num
 * @property integer $serviceid
 * @property integer $servicegroupid
 * @property integer $q_qty
 * @property integer $q_wt
 * @property string $q_timestp
 * @property integer $q_issueid
 * @property string $q_ref
 * @property integer $q_statusid
 * @property integer $q_printstationid
 *
 * @property TbQueueorderdetail[] $tbQueueorderdetails
 */
class TbQuequ extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_quequ';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serviceid', 'servicegroupid', 'q_qty', 'q_wt', 'q_issueid', 'q_statusid', 'q_printstationid'], 'integer'],
            [['q_timestp'], 'safe'],
            [['q_num'], 'string', 'max' => 20],
            [['q_ref'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q_ids' => 'Q Ids',
            'q_num' => 'Q Num',
            'serviceid' => 'Serviceid',
            'servicegroupid' => 'Servicegroupid',
            'q_qty' => 'Q Qty',
            'q_wt' => 'Q Wt',
            'q_timestp' => 'Q Timestp',
            'q_issueid' => 'Q Issueid',
            'q_ref' => 'Q Ref',
            'q_statusid' => 'Q Statusid',
            'q_printstationid' => 'Q Printstationid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbQueueorderdetails()
    {
        return $this->hasMany(TbQueueorderdetail::className(), ['q_ids' => 'q_ids']);
    }

    /**
     * @inheritdoc
     * @return TbQuequQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbQuequQuery(get_called_class());
    }
}
