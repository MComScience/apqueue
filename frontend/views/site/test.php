<?php

?>

<div class="container">
  <div class="row">
    <div id="notif"></div>
      <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
          <form class="form-horizontal">
          <fieldset>
            <legend class="text-center">Contact us</legend>
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Name</label>
              <div class="col-md-9">
                <input id="name" type="text" placeholder="Your name" class="form-control" autofocus>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="nicname">Nickname</label>
              <div class="col-md-9">
                  <input id="nickname" type="text" placeholder="Your Nickname" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="button" id="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
  </div>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php 
$script = <<< JS
$(document).ready(function(){
    $("#submit").click(function(){

       var dataString = { 
              name : $("#name").val(),
              nickname : $("#nickname").val()
            };

        $.ajax({
            type: "POST",
            url: "test-data",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $("#name").val('');
              $("#nickname").val('');

              if(data.success == true){
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );

                socket.emit('message', { 
                  name: data.name,
                  nickname: data.nickname
                });

              } else if(data.success == false){

                $("#name").val(data.name);
                $("#nickname").val(data.nickname);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });

    });

  });
JS;
$this->registerJs($script);
?>