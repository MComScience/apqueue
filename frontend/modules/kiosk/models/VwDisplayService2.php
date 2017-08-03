<?php

namespace frontend\modules\kiosk\models;

use Yii;

/**
 * This is the model class for table "vw_display_service2".
 *
 * @property string $qnum
 * @property integer $counterservice_callnumber
 * @property string $counterservice_name
 */
class VwDisplayService2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_display_service2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qnum'], 'string'],
            [['counterservice_callnumber'], 'integer'],
            [['counterservice_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qnum' => 'Qnum',
            'counterservice_callnumber' => 'Counterservice Callnumber',
            'counterservice_name' => 'Counterservice Name',
        ];
    }
}
