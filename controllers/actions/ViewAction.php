<?php

namespace app\controllers\actions;

use Yii;
use yii\data\SqlDataProvider;

use app\models\Organization;
use app\models\OrganizationParent;

class ViewAction extends \yii\rest\ViewAction
{
    public function findModel($organizationName)
    {
        $model = Organization::find()->where(['organization_name' => $organizationName])->one();
        if (!empty($model)) {
            $queryStruct = ' FROM ' . Organization::tableName() . ' AS org'
                . ' INNER JOIN ('
                    . 'SELECT parent_id AS organization_id, "parent" AS relationship_type FROM ' . OrganizationParent::tableName() . ' WHERE organization_id=:organizationId ' //parents
                    . ' UNION ALL '
                    . 'SELECT organization_id AS organization_id, "daughter" AS relationship_type FROM ' . OrganizationParent::tableName() . ' WHERE parent_id=:organizationId ' // children
                    . ' UNION ALL '
                    . 'SELECT DISTINCT neighborgs.organization_id AS organization_id, "sister" AS relationship_type FROM ' . OrganizationParent::tableName() . ' AS current '
                    . ' INNER JOIN ' . OrganizationParent::tableName() . ' AS neighborgs ON current.parent_id=neighborgs.parent_id '
                    . ' WHERE current.organization_id=:organizationId AND neighborgs.organization_id<>:organizationId' // neighbors
                    . ') tmp ON tmp.organization_id=org.organization_id ';
            
            $count = Yii::$app->db->createCommand('SELECT COUNT(*) ' . $queryStruct, [':organizationId' => $model->organization_id])->queryScalar();
            
            $sql = 'SELECT org.organization_id, org.organization_name, tmp.relationship_type '
                . $queryStruct
                . 'ORDER BY org.organization_name ASC';
            
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
                'params' => [':organizationId' => $model->organization_id],
                'pagination' => [
                    'defaultPageSize' => 100,
                ],
            ]);
            return $dataProvider->getModels();
        } else {
            throw new \yii\web\NotFoundHttpException("Organization not found: $organizationName");
        }
    }
}
