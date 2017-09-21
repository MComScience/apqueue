<?php

namespace app\modules\report\controllers;

use kartik\mpdf\Pdf;
use Yii;
use yii\data\SqlDataProvider;

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

    public function actionExport() {
        $request = Yii::$app->request;
        if($request->isPost){
            $provider = new SqlDataProvider([
                'sql' => 'SELECT
                    t1.DATE,
                    t1.Q_qty,
                    t2.wt_avg
                FROM
                    (
                        SELECT
                            DATE(tb_quequ_data.q_timestp) AS DATE,
                            Count(tb_quequ_data.ids) AS Q_qty
                        FROM
                            tb_quequ_data
                        WHERE tb_quequ_data.q_timestp BETWEEN :date1 AND :date2
                        GROUP BY
                            DATE(tb_quequ_data.q_timestp)
                    ) t1
                INNER JOIN (
                    SELECT
                        DATE(tb_quequ_data.q_timestp) AS DATE,
                        Avg(
                            TIMESTAMPDIFF(
                                MINUTE,
                                tb_quequ_data.q_timestp,
                                tb_caller_data.call_timestp
                            )
                        ) AS wt_avg
                    FROM
                        tb_caller_data
                    RIGHT JOIN tb_quequ_data ON tb_quequ_data.q_ids = tb_caller_data.q_ids
                    GROUP BY
                        DATE(tb_quequ_data.q_timestp)
                ) t2 ON t1.date = t2.date',
                'pagination' => [
                    'pageSize' => false,
                ],
                'params' => [':date1' => $request->post('dp_1'),':date2' =>date("Y-m-d",strtotime('+1 day', strtotime($request->post('dp_2'))))],
            ]);
        }else{
            $provider = new SqlDataProvider([
                'sql' => 'SELECT
                    t1.DATE,
                    t1.Q_qty,
                    t2.wt_avg
                FROM
                    (
                        SELECT
                            DATE(tb_quequ_data.q_timestp) AS DATE,
                            Count(tb_quequ_data.ids) AS Q_qty
                        FROM
                            tb_quequ_data
                        GROUP BY
                            DATE(tb_quequ_data.q_timestp)
                    ) t1
                INNER JOIN (
                    SELECT
                        DATE(tb_quequ_data.q_timestp) AS DATE,
                        Avg(
                            TIMESTAMPDIFF(
                                MINUTE,
                                tb_quequ_data.q_timestp,
                                tb_caller_data.call_timestp
                            )
                        ) AS wt_avg
                    FROM
                        tb_caller_data
                    RIGHT JOIN tb_quequ_data ON tb_quequ_data.q_ids = tb_caller_data.q_ids
                    GROUP BY
                        DATE(tb_quequ_data.q_timestp)
                ) t2 ON t1.date = t2.date',
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
        }
        
        return $this->render('export',[
            'provider' => $provider
        ]);
    }
}
