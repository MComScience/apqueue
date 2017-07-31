<?php /*
  <div class="menuconfig-default-index">
  <h1><?= $this->context->action->uniqueId ?></h1>
  <p>
  This is the view content for action "<?= $this->context->action->id ?>".
  The action belongs to the controller "<?= get_class($this->context) ?>"
  in the "<?= $this->context->module->id ?>" module.
  </p>
  <p>
  You may customize this page by editing the following file:<br>
  <code><?= __FILE__ ?></code>
  </p>
  </div>
 * 
 */ ?>
<?php

use app\modules\menu\assets\MenuAsset;
use yii\helpers\Url;

MenuAsset::register($this);
$this->title = 'Menu Dragtable';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4">
        <div id="nestable-menu">
            <button type="button" data-action="expand-all" class="btn btn-default btn-sm">Expand All</button>
            <button type="button" data-action="collapse-all" class="btn btn-default btn-sm">Collapse All</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Main Menus
            </div>
            <div class="panel-body">
                <div class="dd" id="nestable2">
                    <?php mainlist($mainlist); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Backend Menus
            </div>
            <div class="panel-body">
                <div class="dd" id="nestable2">
                    <?php backendlist($backendlist); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function mainlist($mainlist) {
    ?>

    <ol class="dd-list">
        <?php foreach ($mainlist as $item): ?>
            <li class="dd-item" data-id="<?php echo $item["id"]; ?>">
                <div class="dd-handle">
                    <span class="pull-right"> <?php echo $item["router"]; ?> </span>
                    <span class="label h-bg-navy-blue"><i class="fa <?php echo $item["icon"]; ?>"></i></span> <?php echo $item["title"]; ?>
                </div>     
                <?php if (array_key_exists("children", $item)): ?>
                    <?php mainlist($item["children"]); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>

    <?php
}
?>
<?php

function backendlist($backendlist) {
    ?>

    <ol class="dd-list">
        <?php foreach ($backendlist as $itemlist): ?>
            <li class="dd-item" data-id="<?php echo $itemlist["id"]; ?>">
                <div class="dd-handle">
                    <span class="pull-right"> <?php echo $itemlist["router"]; ?> </span>
                    <span class="label h-bg-navy-blue"><i class="fa <?php echo $itemlist["icon"]; ?>"></i></span> <?php echo $itemlist["title"]; ?>
                </div>   
                <?php if (array_key_exists("children", $itemlist)): ?>
                    <?php backendlist($itemlist["children"]); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>

    <?php
}
?>

<?php 
$baseUrl = Url::base(true);
$script = <<< JS
$(document).ready(function () {
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown",
    };

    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target), output = list.data('output');

        $.ajax({
            method: "POST",
            url: "$baseUrl/menuconfig/default/saveondrag",
            data: {
                list: list.nestable('serialize')
            },
            success: function (data) {
                toastr.success('The changes have been Saved!');
            },
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    };

    $('.dd').nestable({
        group: 1,
        maxDepth: 4,
    }).on('change', updateOutput);
});
$(function () {
        $('.dd').nestable('collapseAll');
        
        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                    action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

    });

JS;
$this->registerJs($script);
?>