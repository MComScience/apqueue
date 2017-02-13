<?php
?>
<table width="100%" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                NickName
            </th>
        </tr>
    </thead>
    <tbody id="message-tbody">
        
    </tbody>
</table>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/socket.io.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php 
$script = <<< JS

  var socket = io.connect( 'http://'+window.location.hostname+':3000' );

  socket.on( 'message', function( data ) {
  
      $( "#message-tbody" ).prepend('<tr><td>'+data.name+'</td><td>'+data.nickname+'</td></tr>');
  });
JS;
$this->registerJs($script);
?>
