<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "tb_printlimit".
 *
 * @property string $ids
 * @property integer $q_printstationid
 * @property integer $q_count
 * @property integer $q_limitqty
 */
class TbPrintlimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_printlimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_printstationid', 'q_count', 'q_limitqty'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'q_printstationid' => 'Q Printstationid',
            'q_count' => 'Q Count',
            'q_limitqty' => 'Q Limitqty',
        ];
    }

    /**
     * @inheritdoc
     * @return TbPrintlimitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbPrintlimitQuery(get_called_class());
    }
}
