<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\icons\Icon;

echo $this->render('_assets');
$this->title = 'Settings Sounds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <?php echo $this->render('_tabs') ?>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <p><?= Html::a(Icon::show('plus', [], Icon::BSG) . ' Add Sound', ['/settings/default/create-sounds'], ['class' => 'btn btn-primary']) ?></p>
                        <?php Pjax::begin([]); ?>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => '\kartik\grid\SerialColumn'],
                                'ref',
                                //'file:text',
                                [
                                    'attribute' => 'file',
                                    'format' => 'text',
                                    'value' => function ($model, $key, $index, $column) {
                                        $data = $model->getFilenameSounds($model['file']);
                                        return $data['filename']; 
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\DataColumn', 
                                    'format' => 'size',
                                    'label' => 'Total Size',
                                    'value' => function ($model, $key, $index, $column) {
                                        $data = $model->getFilenameSounds($model['file']);
                                        return $data['totalsize'];
                                    },
                                ],
                                'created_at:datetime',
                                'updated_at:datetime',
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'template' => '{update} {delete}',
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'update') {
                                            return Url::to(['/settings/default/update-sounds', 'id' => $key]);
                                        }
                                        if ($action === 'delete') {
                                            return Url::to(['/settings/default/delete-sounds', 'id' => $key]);
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>