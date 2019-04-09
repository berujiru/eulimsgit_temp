<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

?>

<div class="row">
        <div class="col-sm-6">
        <?= GridView::widget([
        'dataProvider' => $testnamedataprovider,
        'id'=>'testname-grid',
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'containerOptions'=>[
            'style'=>'overflow:auto; height:250px',
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'panel' => [
           'heading'=>'<h3 class="panel-title">Methods</h3>',
           'type'=>'primary',
           'before' => '',
           'after'=>false,
        ],
        'toolbar' => false,
        'columns' => [
            [
                'label' => '',
                'format' => 'raw', 
                'vAlign' => 'middle',
                'contentOptions' => ['style' => 'width: 3%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {     
                    return "<span class='btn btn-primary glyphicon glyphicon-plus' id='offer' onclick=deleteworkflow(".$data->method_id.")></span>";
                 }          
            ],
            [     
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 40%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
        
                    if ($method_query){
                        return $method_query->method;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Reference',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {

                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
                    if ($method_query){
                        return $method_query->reference;
                    }else{
                        return "";
                    }
                            
                 }                        
            ],
            [    
                'label' => 'Fee',
                'format' => 'raw',
                'width'=> '150px',
                'contentOptions' => ['style' => 'width: 10%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
                    if ($method_query){
                        
                        return number_format($method_query->fee,2);
                    }else{
                        return "";
                    }
                 }                
            ]
       ],
    ]); ?>
        </div>
            <div class="col-sm-6">
            <?= GridView::widget([
        'dataProvider' => $testnamedataprovider,
        'id'=>'testname-grid',
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'containerOptions'=>[
            'style'=>'overflow:auto; height:250px',
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'panel' => [
           'heading'=>'<h3 class="panel-title">Packages</h3>',
           'type'=>'primary',
           'before' => '',
           'after'=>false,
        ],
        'toolbar' => false,
        'columns' => [
            [
                'label' => '',
                'format' => 'raw', 
                'vAlign' => 'middle',
                'contentOptions' => ['style' => 'width: 3%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {     
                    return "<span class='btn btn-danger glyphicon glyphicon-minus' id='offer' onclick=deleteworkflow(".$data->method_id.")></span>";
                 }          
            ],
            [     
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 40%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
        
                    if ($method_query){
                        return $method_query->method;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Reference',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {

                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
                    if ($method_query){
                        return $method_query->reference;
                    }else{
                        return "";
                    }
                            
                 }                        
            ],
            [    
                'label' => 'Fee',
                'format' => 'raw',
                'width'=> '150px',
                'contentOptions' => ['style' => 'width: 10%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
                    if ($method_query){
                        
                        return number_format($method_query->fee,2);
                    }else{
                        return "";
                    }
                 }                
            ]
       ],
    ]); ?>
      
        </div>
</div>