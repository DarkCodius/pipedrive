<?php
namespace app\controllers;

use Yii;
/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{    
    public function actionIndex()
    { 
        return $this->render('index');
    }
    
    public function actionError()  
    {
        return $this->render('error');
    }
}
