<?php

namespace frontend\modules\main\models;

use Yii;

/**
 * This is the model class for table "tb_caller".
 *
 * @property integer $caller_ids
 * @property string $qnum
 * @property integer $counterserviceid
 * @property integer $callerid
 * @property string $call_timestp
 * @property string $call_status
 * @property integer $q_ids
 */
class TbCaller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_caller';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['counterserviceid', 'callerid', 'q_ids'], 'integer'],
            [['call_timestp'], 'safe'],
            [['qnum'], 'string', 'max' => 50],
            [['call_status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'caller_ids' => 'Caller Ids',
            'qnum' => 'Qnum',
            'counterserviceid' => 'Counterserviceid',
            'callerid' => 'Callerid',
            'call_timestp' => 'Call Timestp',
            'call_status' => 'Call Status',
            'q_ids' => 'Q Ids',
        ];
    }

    /**
     * @inheritdoc
     * @return TbCallerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbCallerQuery(get_called_class());
    }
    
    public function getCountername()
    {
        return $this->hasOne(TbCounterservice::className(), ['counterserviceid' => 'counterserviceid']);
    }
}
