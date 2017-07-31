<?php

namespace frontend\modules\settings\models;

use Yii;
use kartik\builder\TabularForm;
use yii\helpers\ArrayHelper;
use frontend\modules\main\models\TbServicegroup;

/**
 * This is the model class for table "tb_display_config".
 *
 * @property integer $id
 * @property string $display_name
 * @property integer $state
 * @property string $header_color
 * @property string $column_color
 * @property string $font_color
 * @property string $font_size
 */
class TbDisplayConfig extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_display_config';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['display_name', 'state', 'header_color', 'column_color', 'font_color', 'font_size'], 'required'],
            [['state'], 'integer'],
            [['hold_query','limit','qhold_label'],'safe'],
            [['display_name', 'header_color', 'column_color', 'font_color', 'bg_color'], 'string', 'max' => 255],
            [['font_size'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'display_name' => 'Display',
            'state' => 'State',
            'header_color' => 'Header Color',
            'column_color' => 'Column Color',
            'font_color' => 'Font Color',
            'font_size' => 'Font Size',
            'bg_color' => 'Background Color',
            'hold_query' => 'hold query',
            'limit' => 'limit',
            'qhold_label' => 'qhold_label'
        ];
    }

    /**
     * @inheritdoc
     * @return TbDisplayConfigQuery the active query used by this AR class.
     */
    public static function find() {
        return new TbDisplayConfigQuery(get_called_class());
    }

    public function getFormAttribs() {
        $data = ArrayHelper::map(TbServicegroup::find()->all(), 'servicegroup_name', 'servicegroup_name');
        return [
            // primary key column
            'id' => [// primary key attribute
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            //'display_name' => ['type' => TabularForm::INPUT_TEXT],
            'display_name' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\Select2::classname(),
                'options' => [
                    'data' => $data,
                    'pluginOptions' => [
                    //'allowClear' => true
                    ],
                ]
            ],
            'state' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\SwitchInput::classname(),
                'options' => function($model, $key, $index, $widget) {
                    return [
                        'pluginOptions' => [
                            'animate' => false
                        ],
                        'pluginEvents' => [
                            "switchChange.bootstrapSwitch" => "function(event, state) { ConfigState(state," . $model['id'] . "," . '"' . $model['display_name'] . '"' . "); }",
                        ],
                    ];
                }
            ],
            'header_color' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\ColorInput::classname(),
                'options' => [
                    //'showDefaultPalette' => false,
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb',
                        'showPalette' => true,
                    ]
                ],
            ],
            'column_color' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\ColorInput::classname(),
                'options' => [
                    //'showDefaultPalette' => false,
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb',
                        'showPalette' => true,
                    ]
                ],
            ],
            'font_color' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\ColorInput::classname(),
                'options' => [
                    //'showDefaultPalette' => false,
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb',
                        'showPalette' => true,
                    ]
                ],
            ],
            'bg_color' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\ColorInput::classname(),
                'options' => [
                    //'showDefaultPalette' => false,
                    'pluginOptions' => [
                        'showInput' => false,
                        'preferredFormat' => 'rgb',
                        'showPalette' => true,
                    ]
                ],
            ],
            'font_size' => ['type' => TabularForm::INPUT_TEXT, 'columnOptions' => ['width' => '100px']],
        ];
    }

}
