<?php

namespace app\controllers\actions;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\Organization;
use app\models\OrganizationParent;

class CreateAction extends \yii\rest\CreateAction
{
    protected $savedModels = [];
    
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        $post = Yii::$app->getRequest()->post();
        if (!empty($post)) {
            foreach ($post as $organizationData) {
                $this->saveOrganization($organizationData);  
            }
        } else {
            throw new \yii\web\BadRequestHttpException('POST data cannot be empty');
        }

        return $this->savedModels;
    }
    
    protected function saveOrganization($organizationData, $parentId = 0)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new Organization([
            'scenario' => $this->scenario,
        ]);

        $model->load($organizationData, '');
        if (!$model->save()) {
            $isExist = false;
            $errors = $model->getErrors('organization_name');
            foreach ($errors as $error) {
                if (strpos($error, 'has already been taken') != false) {
                    $isExist = true;
                    $model = Organization::find()->where(['organization_name' => $model->organization_name])->one();
                }
            }
            if (!$isExist) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
        $organizationParent = OrganizationParent::find()->where(['organization_id' => $model->organization_id, 'parent_id' => $parentId])->one();
        if (empty($organizationParent)) {
            $organizationParent = new OrganizationParent;
            $organizationParent->organization_id = $model->organization_id;
            $organizationParent->parent_id = $parentId;
            if (!$organizationParent->save()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            } 
        }
        if (!empty($organizationData['daughters'])) {
            foreach ($organizationData['daughters'] as $daughterData) {
                $this->saveOrganization($daughterData, $model->organization_id);
            }
        }
        $this->savedModels[] = $model;
    }
}
