<?php

namespace frontend\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\Preferences;
use app\models\UsersPreferences;
use frontend\models\RegistrationForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\components\Common;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistrationForm();
        $preferences = Preferences::find()->asArray()->all();
        $model->scenario = 'create';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');
            
            if ($model->picture && !empty($model->picture) && $model->validate()) {
                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $model->picture->extension;
                $filePath = Yii::getAlias('@anyname')."\uploads\\" . $fileName;
                if ($model->picture->saveAs($filePath)) {                    
                    $model->picture = $fileName;
                }  
                $user           = new Users();
                $user->username = $model['username'];
                $user->email    = $model['email'];
                $user->password = md5($model['password']);
                $user->picture  = $model['picture'];
                if ($user->save(false)) {
                    //Save preferences
                    foreach ($model['preference_ids'] as $key => $value) {
                        $usersPreference = new UsersPreferences();
                        $usersPreference->user_id = $user->id;
                        $usersPreference->preference_id = $value;
                        $usersPreference->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'Signup Successfully.');
                    return $this->redirect('index');
                }                
            }
        }        
        return $this->render('create', [
            'model' => $model,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $preferences = Preferences::find()->asArray()->all();
        
        $model = $this->findModel($id);
        $model->scenario = 'update';

        //Get selected preferences
        $amSelected = [];
        if (!empty($model->usersPreferences)) {
            foreach ($model->usersPreferences as $key => $value) {
                $amSelected[] = $value->preference->id;
            }
        }

        $oldimage = $model->picture;
        $upload_path = Yii::getAlias('@anyname')."\uploads\\";
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        /*if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }*/

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->picture = UploadedFile::getInstance($model, 'picture');
            
            if ($model->validate())
            {
                if ($model->picture && !empty($model->picture)) {
                    //Delete old image
                    $oldImagePath = $upload_path.$oldimage;
                    Common::deleteImage($oldImagePath);

                    $uid = uniqid(time(), true);
                    $fileName = $uid . '.' . $model->picture->extension;
                    $filePath = $upload_path . $fileName;
                    if ($model->picture->saveAs($filePath)) 
                    {                    
                        $model->picture = $fileName;                    
                    }
                }
                else
                {
                    $model->picture = $oldimage;
                }

                $user           = Users::findOne($model->id);
                $user->username = $model->username;
                $user->email    = $model->email;
                $user->picture  = $model->picture;
                if ($user->save(false)) {
                    //Delete old
                    UsersPreferences::deleteAll('user_id = :user_id', [':user_id' => $user->id]);
                    //Save preferences
                    foreach ($model['preference_ids'] as $key => $value) {
                        $usersPreference = new UsersPreferences();
                        $usersPreference->user_id = $user->id;
                        $usersPreference->preference_id = $value;
                        $usersPreference->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'Update Successfully.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'preferences' => $preferences,
            'amSelected' => $amSelected,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $upload_path = Yii::getAlias('@anyname')."\uploads\\";

        $model = $this->findModel($id);
        $oldImagePath = $upload_path.$model->picture;
        Common::deleteImage($oldImagePath);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
