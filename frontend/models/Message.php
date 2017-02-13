<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property string $created_at
 * @property integer $read_status
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['name', 'email', 'subject', 'message', 'read_status'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['read_status'], 'integer'],
            [['name', 'email', 'subject'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'created_at' => 'Created At',
            'read_status' => 'Read Status',
        ];
    }
}
