<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;

class OrganizationController extends ActiveController
{
    public $modelClass = 'app\models\Organization';
    
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
                'create' => [
                'class' => 'app\controllers\actions\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'view' => [
                'class' => 'app\controllers\actions\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];
    }
}
