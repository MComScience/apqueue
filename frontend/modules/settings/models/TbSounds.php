<?php

namespace frontend\modules\settings\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * This is the model class for table "tb_sounds".
 *
 * @property integer $id
 * @property string $ref
 * @property string $file
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 */
class TbSounds extends \yii\db\ActiveRecord {

    const UPLOAD_FOLDER = 'sounds';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_sounds';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ref'], 'required'],
            [['id', 'created_by'], 'integer'],
            [['file'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['ref'], 'string', 'max' => 50],
            [['file'], 'file', 'maxFiles' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ref' => 'Folder',
            'file' => 'Sound Files',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @inheritdoc
     * @return TbSoundsQuery the active query used by this AR class.
     */
    public static function find() {
        return new TbSoundsQuery(get_called_class());
    }

    public static function getUploadPath() {
        return Yii::getAlias('@webroot') . '/' . self::UPLOAD_FOLDER . '/';
    }

    public static function getUploadUrl() {
        return Url::base(true) . '/' . self::UPLOAD_FOLDER . '/';
    }

    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $files = Json::decode($data);
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    $initial[] = [
//                        '<div class="file-preview-audio">'
//                        .'<audio class="kv-preview-data">'
//                        .'<source src="'.$this->getUploadUrl() . $this->ref . '/' . $value.'"'.' type="audio/wav">'
//                        .'<div class="file-preview-other"><span class="file-other-icon"><i class="glyphicon glyphicon-file"></i></span></div>'
//                        .'</audio>'
//                        .'</div>'
                        $this->getUploadUrl() . $this->ref . '/' . $value['filename']
                    ];
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value['filename'],
                        'url' => Url::to(['/settings/default/deletefile', 'id' => $this->id, 'fileName' => $key, 'field' => $field]),
                        'key' => $key,
                        'type' => 'audio',
                        'filetype' => $value['type'],
                        'size' => $value['size']
                    ];
                } else {
                    $initial[] = '';
                }
            }
        }
        return $initial;
    }

    public function getFilenameSounds($data) {
        $files = Json::decode($data);
        $filename = [];
        $totalsize = [];
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                $filename[] = $value['filename'];
                $totalsize[] = $value['size'];
            }
        }
        return [
            'filename' => implode(" , ", $filename),
            'totalsize' => array_sum($totalsize),
        ];
    }
}