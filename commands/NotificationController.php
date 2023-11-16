<?php

namespace app\commands;

use yii\console\Controller;


class NotificationController extends Controller
{
    public function actionIndex()
    {
        // Your cron job logic goes here
        echo "Cron job executed successfully.\n";
    }
}
