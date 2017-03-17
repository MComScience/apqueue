<?php

namespace app\modules\report\controllers;

use kartik\mpdf\Pdf;
use Yii;

class ApqueueController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->renderAjax('index');
    }

    /*
      public function actionReport() {
      // get your HTML raw content without any layouts or scripts
      $content = $this->renderPartial('report');

      // setup kartik\mpdf\Pdf component
      $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::MODE_UTF8,
      // A4 paper format
      'format' => [80,80],

      'marginTop' => '10',
      'marginHeader' => '5',
      'marginLeft' => '5',
      'marginRight' => '5',
      'marginFooter' => '5',
      'marginBottom' => '5',
      'options' => [
      'defaultheaderline' => 0,
      'defaultfooterline' => 0,
      ],

      // portrait orientation
      'orientation' => Pdf::ORIENT_PORTRAIT,
      // stream to browser inline
      'destination' => Pdf::DEST_BROWSER,
      // your html content input
      'content' => $content,
      // format content from your own css file if needed or use the
      // enhanced bootstrap css built by Krajee for mPDF formatting
      //   'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
      // any css to be embedded if required
      //   'cssInline' => '.kv-heading-1{font-size:18px}',
      // set mPDF properties on the fly
      'options' => ['title' => 'Krajee Report Title'],
      // call mPDF methods on the fly
      'methods' => [
      'SetHeader' => ['Andaman software'],
      'SetFooter' => ['{PAGENO}'],
      ]
      ]);

      // return the pdf output as per the destination setting
      return $pdf->render();
      }

     */

    public function actionReport() {
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf ::DEST_FILE,
            'format' => [90, 80],
            'content' => $this->renderPartial('report', [
                'setheader' => false,
                'setcontent' => true,
                'setfooter' => false,
            ]),
            'marginTop' => '2',
            'marginHeader' => '2',
            'marginLeft' => '2',
            'marginRight' => '2',
            'marginFooter' => '2',
            'marginBottom' => '2',
            'options' => [
                'tempPath' => 'files/',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'report',
            ],
            //  'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            //  'cssInline' => 'body{font-size:16px}',
            'filename' => 'files/Report.pdf',
            'methods' => [
                'SetHeader' => '',
                'SetFooter' => '',
              
        ]]);

        echo $pdf->render();
    }

     public function actionPrinttest() {
        $printcmd = "java -classpath c:/java/libs/pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName TX80Thermal ".Yii::getAlias('@webroot') . '/files/Report.pdf';
        exec($printcmd);
        exit();
    }
}
