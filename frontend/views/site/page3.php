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
                                        'autoplay' => true,
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
<audio id="notif_audio"><source src="/apqueue/sounds/notify.ogg" type="audio/ogg">
    <source src="/apqueue/sounds/notify.mp3" type="audio/mpeg">
    <source src="/apqueue/sounds/notify.wav" type="audio/wav">
</audio>
<div class="container">
<div id="new-message-notif"></div>
  <div class="row">
     <div class="table-responsive">
        <table id="mytable" class="table table-bordred table-striped">
          <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Time</th>
            <th>Read</th>
          </thead>
       
          <tbody id="message-tbody">
               
    <?php
              
       if(isset($message)){
            
          foreach($message as $row){
              
    ?>
              
          <tr>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->subject;?></td>
            <td><?php echo $row->created_at;?></td>
            <td><a style="cursor:pointer" data-toggle="modal" data-target=".bs-example-modal-sm" class="detail-message" id="<?php echo $row->id;?>"><span class="glyphicon glyphicon-search"></span></a></td>
          </tr>
    <?php
          
          }
              
              
       } else {
              
    ?>
              
              <tr id="no-message-notif">
                <td colspan="5" align="center"><div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only"></span> No message</div>
                </td>
              </tr>
              
    <?php
       }
    ?>
        
           </tbody>
    </table>

    </div>

  </div>
</div>


<hr>
<footer class="text-center">Simple Realtime Message &copy 2015</footer>
<hr>
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
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php 
$script = <<< JS
$(document).ready(function(){

		$("#load").hide();

     $(document).on("click",".detail-message",function() {
      
      $( "#load" ).show();

       var dataString = { 
              id : $(this).attr('id')
            };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('message/detail');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){

              $( "#load" ).hide();

              if(data.success == true){

                $("#show_name").html(data.name);
                $("#show_email").html(data.email);
                $("#show_subject").html(data.subject);
                $("#show_message").html(data.message);

                var socket = io.connect( 'http://'+window.location.hostname+':3000' );
                
                socket.emit('update_count_message', { 
                  update_count_message: data.update_count_message
                });

              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });

    });

  });

  var socket = io.connect( 'http://'+window.location.hostname+':3000' );

  socket.on( 'new_count_message', function( data ) {
  
      $( "#new_count_message" ).html( data.new_count_message );
      $('#notif_audio')[0].play();

  });

  socket.on( 'update_count_message', function( data ) {

      $( "#new_count_message" ).html( data.update_count_message );
    
  });

  socket.on( 'new_message', function( data ) {
  
      $( "#message-tbody" ).prepend('<tr><td>'+data.name+'</td><td>'+data.email+'</td><td>'+data.subject+'</td><td>'+data.created_at+'</td><td><a style="cursor:pointer" data-toggle="modal" data-target=".bs-example-modal-sm" class="detail-message" id="'+data.id+'"><span class="glyphicon glyphicon-search"></span></a></td></tr>');
      $( "#no-message-notif" ).html('');
      $( "#new-message-notif" ).html('<div class="alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New message ...</div>');
  });
JS;
$this->registerJs($script);
?>