<?php

namespace app\commands;

use yii\console\Controller;
use Yii;
use app\models\UserModel;


class NotificationController extends Controller
{
    public function actionIndex()
    {

        $user_email = 'testcron@gmail.com';
        $user_password = 'testcron';
        $user = new UserModel();
        $user->email = $user_email;
        $user->password = $user_password;
        $user->save();
    }
}
