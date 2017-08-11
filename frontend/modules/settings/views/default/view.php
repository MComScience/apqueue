<?php
$this->title = 'Display Preview';
?>
<style type="text/css">
    .normalheader {
        display: none;
    }
    .table-responsive{
        border: 0px;
    }
    th {
        width: 100%;
    }
    th p {
        text-align: center;
        font-size: <?= $model['font_size'] ?>;
        color: <?= $model['font_color'] ?>;
        background-color: <?= $model['header_color'] ?>;
        border-radius: 15px;
        border: 5px solid white;
        padding: 5px;
    }
    td {

    }
    td p {
        text-align: center;
        font-size: <?= $model['font_size'] ?>;
        color: <?= $model['font_color'] ?>;
        background-color: <?= $model['column_color'] ?>;
        border-radius: 15px;
        border: 5px solid white;
        padding: 5px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="hpanel">
            <div class="panel-heading">

            </div>
            <div class="panel-body" style="background-color: <?= $model['bg_color'] ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="content-display">
                            <table width="100%" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th style="padding:0px;">
                                            <p style="font-size:<?= $model['font_size'] ?>;color:<?= $model['font_color'] ?>;background-color:<?= $model['header_color'] ?>;text-align: center;border-radius: 15px;border: 5px solid white;padding: 5px;">
                                                <strong class="col-sm-6">หมายเลข</strong><strong>ช่องบริการ</strong>
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-tabledisplay">
                                    <?php for ($x = 1; $x < 5; $x++): ?>
                                    <tr>
                                        <td style="padding:0px;border-top: 0px;">
                                            <p style="font-size:<?= $model['font_size'] ?>;color:<?= $model['font_color'] ?>;background-color:<?= $model['column_color'] ?>;text-align: center;border-radius: 15px;border: 5px solid white;padding: 5px;">
                                            <strong class="col-sm-6">A00<?= $x;?></strong><strong>1</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>