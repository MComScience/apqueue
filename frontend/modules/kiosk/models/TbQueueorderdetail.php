<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "tb_queueorderdetail".
 *
 * @property integer $ids
 * @property integer $q_ids
 * @property integer $orderdetailid
 * @property string $q_result
 * @property string $q_result_tsp
 *
 * @property TbQuequ $qIds
 */
class TbQueueorderdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_queueorderdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_ids', 'orderdetailid'], 'integer'],
            [['q_result_tsp'], 'safe'],
            [['q_result'], 'string', 'max' => 10],
            [['q_ids'], 'exist', 'skipOnError' => true, 'targetClass' => TbQuequ::className(), 'targetAttribute' => ['q_ids' => 'q_ids']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'q_ids' => 'Q Ids',
            'orderdetailid' => 'Orderdetailid',
            'q_result' => 'Q Result',
            'q_result_tsp' => 'Q Result Tsp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQIds()
    {
        return $this->hasOne(TbQuequ::className(), ['q_ids' => 'q_ids']);
    }

    public function getTbOrderdetail()
    {
        return $this->hasOne(TbOrderdetail::className(), ['orderdetailid' => 'orderdetailid']);
    }

    /**
     * @inheritdoc
     * @return TbQueueorderdetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbQueueorderdetailQuery(get_called_class());
    }
}
