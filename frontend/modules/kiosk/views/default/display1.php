<?php
$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a class="btn btn-default" onclick="Play();">Play</a>
        <div class="hpanel hgreen">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo \wbraganca\videojs\VideoJsWidget::widget([
                            'options' => [
                                'id' => 'vedio-display',
                                'class' => 'video-js vjs-default-skin vjs-big-play-centered',
                                'poster' => "http://vjs.zencdn.net/v/oceans.png",
                                'controls' => true,
                                'preload' => 'auto',
                                'width' => '550',
                                'height' => '400',
                                'data' => [
                                    'setup' => [
                                        //'autoplay' => true,
                                        'loop' => true,
                                    // 'techOrder' => ['flash', 'html5']
                                    ],
                                ],
                            ],
                            'tags' => [
                                'source' => [
                                    ['src' => '/apqueue/videos/Video2.mp4', 'type' => 'video/mp4'],
                                ],
                                'track' => [
                                    ['kind' => 'captions', 'src' => 'http://vjs.zencdn.net/vtt/captions.vtt', 'srclang' => 'en', 'label' => 'English']
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <table width="100%" border="1">
                            <thead>
                                <tr>
                                    <th width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                        หมายเลข
                                    </th>
                                    <th width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                        ช่อง
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div id="blink"><strong>A-001</strong></div>
                                    </td>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div class="blink"><strong>1</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div id="blink"><strong>A-001</strong></div>
                                    </td>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div class="blink"><strong>1</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div id="blink"><strong>A-001</strong></div>
                                    </td>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: white;border: 1px solid #62cb31;color: #62cb31;">
                                        <div class="blink"><strong>1</strong></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <marquee direction="left"><p style="font-size: 18pt;">ข้อความวิ่งจากขวาไปซ้าย</p></marquee>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/kiosk/display.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
