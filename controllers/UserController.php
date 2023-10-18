<?php

namespace app\controllers;

use Yii;
use app\models\UserModel;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $user = UserModel::find()->all();
        return $this->asJson($user);
    }

    public function actionAddUser()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $user_email = $data->email;
        $user_password = $data->password;
        $user = UserModel::find()->where(['email' => $user_email])->one();

        if ($user) {
            return $this->errorResponse('email is alrady taken');
        }

        $user = new UserModel();

        $user->email = $user_email;
        $user->password = $user_password;
        $user->save();

        return $this->asJson(
            $user
        );
    }




    private function errorResponse($message)
    {

        // set response code to 400
        Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }
}
