<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "tb_orderdetail".
 *
 * @property integer $orderdetailid
 * @property string $orderdetail_dec
 */
class TbOrderdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_orderdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderdetail_dec'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderdetailid' => 'Orderdetailid',
            'orderdetail_dec' => 'Orderdetail Dec',
        ];
    }

    /**
     * @inheritdoc
     * @return TbOrderdetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbOrderdetailQuery(get_called_class());
    }
}
