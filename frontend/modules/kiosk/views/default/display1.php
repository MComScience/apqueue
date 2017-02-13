<?php
$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="hpanel hgreen">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo \wbraganca\videojs\VideoJsWidget::widget([
                            'options' => [
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
                            <tbody>
                                <tr>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                        หมายเลข
                                    </td>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                        ช่อง
                                    </td>
                                </tr>
                                <tr>
                                    <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                            <body onload="blinker();">
                                <div id="blink">A001</div>
                            </body>
                            </td>
                            <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                <div class="blink">1</div>
                            </td>
                            </tr>
                            <tr>
                                <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                    A001
                                </td>
                                <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                    1
                                </td>
                            </tr>
                            <tr>
                                <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                    A001
                                </td>
                                <td width="300px" height="100px" style="font-size: 30pt;text-align: center;background-color: #74d348;border: 1px solid white;color: white;">
                                    1
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
<script>
    function blinker()
    {
        if (document.getElementById("blink"))
        {
            var d = document.getElementById("blink");
            d.style.color = (d.style.color == 'yellow' ? 'white' : 'yellow');
            if($('.blink').css('color') === "rgb(255, 255, 255)"){
                $('.blink').css('color',"yellow");
            }else{
                $('.blink').css('color',"white");
            }
            setTimeout('blinker()', 500);
        }
    }
</script>
