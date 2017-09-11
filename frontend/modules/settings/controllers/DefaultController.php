<?php

namespace frontend\modules\settings\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\settings\models\TbDisplayConfig;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use frontend\modules\main\models\TbCounterservice;
use \yii\web\Response;
use yii\helpers\Html;
use frontend\modules\main\models\TbServicegroup;
use frontend\modules\settings\models\TbServiceRoute;
use frontend\modules\kiosk\models\TbService;
use frontend\modules\kiosk\models\TbQuequ;
use frontend\modules\main\models\TbCaller;
use frontend\modules\settings\models\TbSounds;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\helpers\FileHelper;
use frontend\modules\kiosk\models\TbQuequSearch;
use frontend\modules\settings\models\TbServiceMdName;

/**
 * Default controller for the `settings` module
 */
class DefaultController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($action->id == 'view') {
            $this->layout = '@frontend/themes/homer/layouts/display.php';
        }

        return true;
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-all' => ['post'],
                    'delete-counter-service' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSoundList() {
        $dataProvider = new ActiveDataProvider([
            'query' => TbSounds::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('sound-list', ['dataProvider' => $dataProvider]);
    }

    public function actionCreateSounds() {
        $model = new TbSounds();
        if ($model->load(Yii::$app->request->post())) {

            $this->CreateDir($model->ref);

            $model->file = $this->uploadMultipleFile($model);
            $model->created_by = \Yii::$app->user->getId();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['update-sounds', 'id' => $model->id]);
            }
        } else {
            return $this->render('_from_sounds', ['model' => $model]);
        }
    }

    public function actionUpdateSounds($id) {
        $model = TbSounds::findOne($id);
        $tempFiles = $model->file;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = $this->uploadMultipleFile($model, $tempFiles);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->refresh();
            }
        }

        return $this->render('_from_sounds', [
                    'model' => $model,
        ]);
    }

    public function actionDeleteSounds($id) {
        $model = TbSounds::findOne($id);
        FileHelper::removeDirectory(TbSounds::getUploadPath() . $model['ref']);
        $model->delete();
        Yii::$app->session->setFlash('success', "Deleted.");
        return $this->redirect(['sound-list']);
    }

    private function CreateDir($folderName) {
        if ($folderName != NULL) {
            $basePath = TbSounds::getUploadPath();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
//BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    private function uploadMultipleFile($model, $tempFile = null) {
        $files = [];
        $json = '';
        $tempFile = Json::decode($tempFile);
        $UploadedFiles = UploadedFile::getInstances($model, 'file');
        if ($UploadedFiles !== null) {
            foreach ($UploadedFiles as $file) {
                try {
                    $oldFileName = $file->basename . '.' . $file->extension;
                    $newFileName = md5($file->basename . time()) . '.' . $file->extension;
                    $file->saveAs(TbSounds::UPLOAD_FOLDER . '/' . $model->ref . '/' . $oldFileName);
                    $files[$newFileName] = [
                        'filename' => $oldFileName,
                        'size' => $file->size,
                        'type' => $file->type
                    ];
                } catch (Exception $e) {
                    
                }
            }
            $json = json::encode(ArrayHelper::merge($tempFile, $files));
        } else {
            $json = $tempFile;
        }
        return $json;
    }

    public function actionDeletefile($id, $field, $fileName) {
        $status = ['success' => false];
        if (in_array($field, ['file'])) {
            $model = TbSounds::findOne($id);
            $files = Json::decode($model->{$field});
            if (array_key_exists($fileName, $files)) {
                if ($this->deleteFile('file', $model->ref, $files[$fileName]['filename'])) {
                    $status = ['success' => true];
                    unset($files[$fileName]);
                    $model->{$field} = Json::encode($files);
                    $model->created_by = $model['created_by'];
                    $model->created_at = $model['created_at'];
                    $model->updated_at = new Expression('NOW()');
                    $model->save();
                }
            }
        }
        echo json_encode($status);
    }

    private function deleteFile($type = 'file', $ref, $fileName) {
        if (in_array($type, ['file'])) {
            if ($type === 'file') {
                $filePath = TbSounds::getUploadPath() . $ref . '/' . $fileName;
            }
            @unlink($filePath);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDisplay() {
        $model = new TbDisplayConfig();
        $dataProvider = new ActiveDataProvider([
            'query' => TbDisplayConfig::find()->indexBy('id'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
            Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            return $this->redirect(['display']); // redirect to your next desired page
        } elseif ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['display']);
            }
        } else {
            return $this->render('display', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionCounterService() {
        $model = new TbCounterservice();
        $dataProvider = new ActiveDataProvider([
            'query' => TbCounterservice::find()->indexBy('counterserviceid'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
//Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            return "Processed {$count} records successfully."; // redirect to your next desired page
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['counter-service']);
            } else {
                return \yii\widgets\ActiveForm::validate($model);
            }
        } else {
            return $this->render('counter-service', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionServiceGroup() {
        $model = new TbServicegroup();
        $dataProvider = new ActiveDataProvider([
            'query' => TbServicegroup::find()->indexBy('servicegroupid'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
            return "Processed {$count} records successfully.";
//return $this->redirect(['service-group']); // redirect to your next desired page
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['service-group']);
            } else {
                return \yii\widgets\ActiveForm::validate($model);
            }
        } else {
            return $this->render('service-group', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionMdName() {
        $model = new TbServiceMdName();
        $dataProvider = new ActiveDataProvider([
            'query' => TbServiceMdName::find()->indexBy('service_md_name_id'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
            return "Processed {$count} records successfully.";
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['md-name']);
            } else {
                return \yii\widgets\ActiveForm::validate($model);
            }
        } else {
            return $this->render('md-name', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionServiceRoute() {
        $model = new TbServiceRoute();
        $dataProvider = new ActiveDataProvider([
            'query' => TbServiceRoute::find()->indexBy('ids'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
            return "Processed {$count} records successfully.";
//return $this->redirect(['service-group']); // redirect to your next desired page
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['service-route']);
            } else {
                return \yii\widgets\ActiveForm::validate($model);
            }
        } else {
            return $this->render('service-route', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionService() {
        $model = new TbService();
        $dataProvider = new ActiveDataProvider([
            'query' => TbService::find()->indexBy('serviceid'),
        ]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $count = 0;
            foreach ($models as $index => $model) {
                if ($model->save()) {
                    $count++;
                }
            }
            return "Processed {$count} records successfully.";
//return $this->redirect(['service-group']); // redirect to your next desired page
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Save successfully.");
                return $this->redirect(['service']);
            } else {
                return \yii\widgets\ActiveForm::validate($model);
            }
        } else {
            return $this->render('service', ['dataProvider' => $dataProvider, 'model' => $model]);
        }
    }

    public function actionDeleteAll() {
        $delete_ids = explode(',', Yii::$app->request->post('ids'));
        TbDisplayConfig::deleteAll(['in', 'id', $delete_ids]);
        return 'Deleted!';
    }

    public function actionView($id) {
        if (($model = TbDisplayConfig::findOne($id)) !== null) {
            return $this->render('view', ['model' => $model]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateCounterservice() {
        $request = Yii::$app->request;
        $model = new TbCounterservice();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create Counter Service",
                    'content' => $this->renderAjax('_from_counter_service', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create Counter Service",
                    'content' => '<span class="text-success">Create TbCounterservice success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create-counterservice'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create Counter Service",
                    'content' => $this->renderAjax('_from_counter_service', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
//return $this->redirect(['view', 'id' => $model->counterserviceid]);
            } else {
                return $this->render('_from_counter_service', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionDeleteCounterService() {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys;
        foreach ($pks as $pk) {
            $model = TbCounterservice::findOne($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['counter-service']);
        }
    }

    public function actionCreateServicegroup() {
        $request = Yii::$app->request;
        $model = new TbServicegroup();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create Service Group",
                    'content' => $this->renderAjax('_from_service_group', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create Service Group",
                    'content' => '<span class="text-success">Create TbCounterservice success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create-servicegroup'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create Service Group",
                    'content' => $this->renderAjax('_from_service_group', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
//return $this->redirect(['view', 'id' => $model->counterserviceid]);
            } else {
                return $this->render('_from_service_group', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionCreateMdname() {
        $request = Yii::$app->request;
        $model = new TbServiceMdName();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "เพิ่มรายชื่อแพทย์",
                    'content' => $this->renderAjax('_from_md', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "เพิ่มรายชื่อแพทย์",
                    'content' => '<span class="text-success">Create TbCounterservice success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create-servicegroup'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "เพิ่มรายชื่อแพทย์",
                    'content' => $this->renderAjax('_from_md', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
//return $this->redirect(['view', 'id' => $model->counterserviceid]);
            } else {
                return $this->render('_from_md', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionCreateService() {
        $request = Yii::$app->request;
        $model = new TbService();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create Service",
                    'content' => $this->renderAjax('_from_service', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create Service",
                    'content' => '<span class="text-success">Create TbCounterservice success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create-service'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create Service",
                    'content' => $this->renderAjax('_from_service', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
//return $this->redirect(['view', 'id' => $model->counterserviceid]);
            } else {
                return $this->render('_from_service', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionCreateServiceRoute() {
        $request = Yii::$app->request;
        $model = new TbServiceRoute();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create Service Route",
                    'content' => $this->renderAjax('_from_service_route', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create Service Route",
                    'content' => '<span class="text-success">Create TbCounterservice success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create-service-route'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create Service Route",
                    'content' => $this->renderAjax('_from_service_route', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
//return $this->redirect(['view', 'id' => $model->counterserviceid]);
            } else {
                return $this->render('_from_service_route', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionDeleteServicegroup() {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys;
        foreach ($pks as $pk) {
            $model = TbServicegroup::findOne($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['service-group']);
        }
    }

    public function actionDeleteMd() {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys;
        foreach ($pks as $pk) {
            $model = TbServiceMdName::findOne($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['md-name']);
        }
    }

    public function actionDeleteService() {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys;
        foreach ($pks as $pk) {
            $model = TbService::findOne($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['service-group']);
        }
    }

    public function actionDeleteServiceRoute() {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys;
        foreach ($pks as $pk) {
            $model = TbServiceRoute::findOne($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['service-route']);
        }
    }

    public function actionAddSettings($id) {
        $request = Yii::$app->request;
        $model = TbDisplayConfig::findOne($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Settings " . $model['display_name'],
                    'content' => $this->renderAjax('_from_add_settings', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="glyphicon glyphicon-floppy-disk"></i>' . ' Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => $model['display_name'],
                    'content' => '<span class="text-success">Save success!</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['/settings/default/add-settings', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            }
        }
    }

    public function actionResetQ() {
        $searchModel = new TbQuequSearch();
        $provider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('reset-q', [
            'searchModel' => $searchModel,
            'provider' => $provider,
        ]);
    }

    public function actionDelete($id) {
        if (($model = TbQuequ::findOne($id)) != null) {
            $model->delete();
            return 'Delete Completed!';
        }
    }

    public function actionDeleteAllQ() {
        TbQuequ::deleteAll();
        TbCaller::deleteAll();
        return 'Delete Completed!';
    }

}
