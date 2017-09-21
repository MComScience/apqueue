<?php 
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'รายงาน';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <?php 
            echo Tabs::widget([
                'items' => [
                    [
                        'label' => 'รายงาน',
                        'active' => true,
                    ],
                ],
                'renderTabContent' => false
            ]);
            ?>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'id' => 'form-search']); ?>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">วันที่</label>
                            <div class="col-sm-3">
                                <?php echo DatePicker::widget([
                                    'name' => 'dp_1',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'language' => 'th',
                                    'value' => isset($_POST['dp_1']) ? $_POST['dp_1'] : '',
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]); ?>
                            </div>

                            <label for="" class="col-sm-1 control-label">ถึงวันที่</label>
                            <div class="col-sm-3">
                                <?php echo DatePicker::widget([
                                    'name' => 'dp_2',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'language' => 'th',
                                    'value' => isset($_POST['dp_2']) ? $_POST['dp_2'] : '',
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]); ?>
                            </div>

                            <div class="col-sm-3">
                                <?= Html::a('Reset',['/report/apqueue/export'], ['class' => 'btn btn-default']) ?>
                                <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>  
                            </div>
                        </div>
                            
                        <?php ActiveForm::end(); ?>

                        <br>

                        <?php
                        $pdfHeader = [
                            'L' => [
                                'content' => '',
                                'font-size' => 8,
                                'color' => '#333333',
                            ],
                            'C' => [
                                'content' => 'รายงาน',
                                'font-size' => 25,
                                'color' => '#333333',
                            ],
                            'R' => [
                                'content' => date('d/m/Y H:i:s'),
                                'font-size' => 8,
                                'color' => '#333333',
                            ],
                        ];
                        $pdfFooter = [
                            'L' => [
                                'content' => Yii::t('app', "Yii2 Export"),
                                'font-size' => 8,
                                'font-style' => 'B',
                                'color' => '#999999',
                            ],
                            'R' => [
                                'content' => '[ {PAGENO} ]',
                                'font-size' => 10,
                                'font-style' => 'B',
                                'font-family' => 'serif',
                                'color' => '#333333',
                            ],
                            'line' => true,
                        ];
                        echo GridView::widget([
                            'dataProvider'=> $provider,
                            'columns' => [
                                [
                                    'attribute' => 'DATE',
                                    'label' => 'วันที่',
                                    'hAlign' => 'center',
                                    'value' => function($model){
                                        return empty($model['DATE']) ? '' : date("m/d/Y", strtotime($model['DATE']));
                                    }
                                ],
                                [
                                    'attribute' => 'Q_qty',
                                    'label' => 'จำนวนคิว',
                                    'hAlign' => 'center'
                                ],
                                [
                                    'attribute' => 'wt_avg',
                                    'label' => 'ระยะเวลาที่รอคอยเฉลี่ย(นาที)',
                                    'hAlign' => 'center',
                                    'value' => function($model){
                                        return floor($model['wt_avg'] % 60);
                                    }
                                ]
                            ],
                            'responsive'=>true,
                            'hover'=>true,
                            'pjax' => true,
                            'export' => [
                                'fontAwesome'=>true,
                                'label' => 'พิมพ์รายงาน',
                                
                            ],
                            'exportConfig' => [
                                GridView::EXCEL => [
                                    'label' => Yii::t('app', 'Excel'),
                                    'icon' => 'file-excel-o',
                                    'iconOptions' => ['class' => 'text-success'],
                                    'showHeader' => true,
                                    'showPageSummary' => true,
                                    'showFooter' => true,
                                    'showCaption' => true,
                                    'filename' => Yii::t('app', 'grid-export'),
                                    'alertMsg' => Yii::t('app', 'The EXCEL export file will be generated for download.'),
                                    'options' => ['title' => Yii::t('app', 'Microsoft Excel 95+')],
                                    'mime' => 'application/vnd.ms-excel',
                                    'config' => [
                                        'worksheet' => Yii::t('app', 'ExportWorksheet'),
                                        'cssFile' => '',
                                    ],
                                ],
                                GridView::PDF => [
                                    'label' => Yii::t('app', 'PDF'),
                                    'icon' => 'file-pdf-o',
                                    'iconOptions' => ['class' => 'text-danger'],
                                    'showHeader' => true,
                                    'showPageSummary' => true,
                                    'showFooter' => true,
                                    'showCaption' => true,
                                    'filename' => Yii::t('app', 'grid-export'),
                                    'alertMsg' => Yii::t('app', 'The PDF export file will be generated for download.'),
                                    'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                                    'mime' => 'application/pdf',
                                    'config' => [
                                        'mode' => 'UTF-8',
                                        'format' => 'A4',
                                        'destination' => 'D',
                                        'marginTop' => 20,
                                        'marginBottom' => 20,
                                        'cssInline' => '.kv-wrap{padding:20px;}' .
                                            '.kv-align-center{text-align:center;}' .
                                            '.kv-align-left{text-align:left;}' .
                                            '.kv-align-right{text-align:right;}' .
                                            '.kv-align-top{vertical-align:top!important;}' .
                                            '.kv-align-bottom{vertical-align:bottom!important;}' .
                                            '.kv-align-middle{vertical-align:middle!important;}' .
                                            '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                                            '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                                            '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                                        'methods' => [
                                            'SetHeader' => [
                                                ['odd' => $pdfHeader, 'even' => $pdfHeader]
                                            ],
                                            'SetFooter' => [
                                                ['odd' => $pdfFooter, 'even' => $pdfFooter]
                                            ],
                                        ],
                                        'options' => [
                                            'title' => 'รายงาน',
                                            'subject' => Yii::t('app', 'PDF export generated by kartik-v/yii2-grid extension'),
                                            'keywords' => Yii::t('app', 'krajee, grid, export, yii2-grid, pdf'),
                                        ],
                                        'contentBefore' => '',
                                        'contentAfter' => '',
                                    ],
                                ],
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                            'panel' => [
                                'heading'=>false,
                                'before'=>'',
                                'after'=>false,
                                'footer'=>false
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
