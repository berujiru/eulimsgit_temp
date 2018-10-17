<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Services;
use common\models\lab\Sample;
use common\models\lab\Testname;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Sampletype;
use common\models\lab\ServicesSearch;
use common\models\lab\Labsampletype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
{
    /**
     * {@inheritdoc}
     */

    //  public function verbs() {
    //     parent::verbs();
    //     return [
    //         'index' => ['GET', 'HEAD'],
    //         'view' => ['GET', 'HEAD'],
    //         'create' => ['POST'],
    //         'update' => ['PUT', 'PATCH'],
    //         'delete' => ['DELETE'],
    //     ];
    // }
    // public function actions() {
    //     $actions = parent::actions();
    //     $actions['index']['prepareDataProvider'] = function($action) {
    //         return new \yii\data\ActiveDataProvider([
    //             'query' => Profile::find()->where(['user_id' => Yii::$app->user->id]),
    //         ]);
    //     };

    //     return $actions;
    // }


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
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Services();

        $modelmethod = new Methodreference();
        $searchModel = new ServicesSearch();

        
        $samplesQuery = Sample::find()->where(['sample_id' =>0]);
        $dataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                    'pageSize' => 10,
                ],
             
        ]);
        $sampletype = [];
        $test = [];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sampletype'=>$sampletype,
            'model'=>$model,
            'test'=>$test,
            'modelmethod'=>$modelmethod,
        ]);
    }

    /**
     * Displays a single Services model.
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
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->services_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->services_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Services model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
        
            $list =  Sampletype::find()
            ->innerJoin('tbl_lab_sampletype', 'tbl_lab_sampletype.sampletype_id=tbl_sampletype.sampletype_id')
            ->Where(['tbl_lab_sampletype.lab_id'=>$id])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['sampletype_id'], 'name' => $sampletype['type']];
                    if ($i == 0) {
                        $selected = $sampletype['sampletype_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function actionGetmethod()
	{

        $id = $_GET['id'];

        $labid = $_GET['lab_id'];
        $sampletypeid = $_GET['sample_type_id'];

        $methodreferenceid = $id;
        $model = new Methodreference();

        $testnameQuery = Methodreference::find()
        ->leftJoin('tbl_testname_method', 'tbl_testname_method.method_id=tbl_methodreference.method_reference_id')
        ->Where(['tbl_testname_method.testname_id'=>$id]);
         $testnameDataProvider = new ActiveDataProvider([
                 'query' => $testnameQuery,
                 'pagination' => [
                     'pageSize' => 10,
                 ],
              
         ]);
         
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sampletype = [];
        $test = [];

         return $this->renderAjax('_method', [
            'model'=>$model,
            'testnameDataProvider' => $testnameDataProvider,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sampletype'=>$sampletype,
            'test'=>$test,
            'methodreferenceid'=>$methodreferenceid,
            'labid'=>$labid,
            'sampletypeid'=>$sampletypeid,
         ]);
	
     }
     
     public function actionOffer()
     {
          $id = $_POST['id'];
          $labid = $_POST['labid'];
          $sampletypeid = $_POST['sampletypeid'];
          $methodreferenceid = $_POST['methodreferenceid'];

          $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
          $testnamemethod= Testnamemethod::find()->where(['testname_id' => $methodreferenceid])->one();

          $services = new Services();
          $services->rstl_id =   $GLOBALS['rstl_id'];
          $services->method_reference_id = $id;
          $services->sampletype_id = $sampletypeid;
          $services->testname_method_id = $testnamemethod->testname_method_id;
          $services->save();


          $services_model = Services::find()->where(['services_id' => $services->services_id])->one();

        //base sa ids ng services model
        //kunin yung model galing sa api para iinsert pababa going sa 7 tables 

        //   $labsampletype = new Labsampletype();
        //   $labsampletype->lab_sampletype_id =   
        //   $labsampletype->lab_id = 
        //   $labsampletype->sampletype_id = 
        //   $labsampletype->effective_date = 
        //   $labsampletype->added_by =
        //   $labsampletype->save();

        //   $sampletype = new Sampletype();
        //   $sampletype->sampletype_id =   
        //   $sampletype->type = 
        //   $sampletype->status_id = 
        //   $sampletype->save();

        //   $testnamemethod = new Testnamemethod();
        //   $testnamemethod->testname_method_id =  
        //   $testnamemethod->testname_id = 
        //   $testnamemethod->method_id = 
        //   $testnamemethod->create_time = 
        //   $testnamemethod->update_time = 
        //   $testnamemethod->save();

        //   $testname = new Testname();
        //   $testname->testname_id =   
        //   $testname->testName = 
        //   $testname->status_id = 
        //   $testname->create_time = 
        //   $testname->update_time = 
        //   $testname->save();

        //   $methodreference = new Methodreference();
        //   $methodreference->method_reference_id =   
        //   $methodreference->testname_id = 
        //   $methodreference->method = 
        //   $methodreference->reference = 
        //   $methodreference->fee = 
        //   $methodreference->create_time =
        //   $methodreference->update_time = 
        //   $methodreference->save();
          
     }

     public function actionUnoffer()
     {
          $id = $_POST['id'];

          $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

          $Connection= Yii::$app->labdb;
          $sql="DELETE FROM `tbl_services`  WHERE `method_reference_id`=".$id." AND `rstl_id`=".$GLOBALS['rstl_id']." ";
          $Command=$Connection->createCommand($sql);
          $Command->execute();   
     }

     public function actionSync()
     {
        $servicesquery = Services::find()->Where(['rstl_id'=>$GLOBALS['rstl_id']])->all();  
        $servicecount = count($servicesquery);
        $services = Services::find()->all();    

        $post = Yii::$app->request->post();
      //  $ctr = 0;

        if(isset($post)){

            //data here requires to the services lab list
            $myvar = Json::decode($post['data']);
            $ids="";
            foreach ($myvar as $var) {

            $services = new Services();
            $service->rstl_id =   $GLOBALS['rstl_id'];
            $service->method_reference_id = $id;
            $service->sampletype_id = $sampletypeid;
            $service->testname_method_id = $testnamemethod->testname_method_id;
            if($newCustomer->save(true)){
            }else{
                $ids=$ids.$var['id'].',';
            }
            $ctr++;
        }
       
    }
     \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;

     return [
        'num'=>$ctr,
        'ids'=>$ids
     ];   
     
     }
}
