<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Link;
use app\models\forms\LinkForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $uri = Yii::$app->request->get('uri', false);

        if ($uri !== false) {

            $targetUri = Yii::$app->linkResolver->resolve($uri);
            
            $this->redirect($targetUri ?? '/404');
        }

        $model = new LinkForm();

        if ($model->load(Yii::$app->request->post())) {
            $link = $model->createLink(Yii::$app->tokenGenerator);

            if ($link !== null) {
                Yii::$app->session->setFlash('success', $this->renderPartial('partial/_success', ['token' => $link->token]));

                return $this->redirect(['/']);
            }
        }

        return $this->render('index', [
                'model' => $model
        ]);
    }

    public function actionNotFound()
    {
        throw new \yii\web\NotFoundHttpException(404);
    }

    public function actionValidateLink()
    {
        $model = new LinkForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
