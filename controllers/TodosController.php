<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TodosModel;
use app\models\UserModel;

class TodosController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $todos = TodosModel::find()->all();
        return $this->asJson($todos);
    }

    public function actionGetTodoById()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $todo_id = $data->todo_id;
        $todo = TodosModel::findOne($todo_id);

        if (!$todo) {
            return $this->errorResponse('Todo deos not exist');
        }

        return $this->asJson(
            $todo
        );
    }

    public function actionGetTodoByUser()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $user_id = $data->user_id;
        $user = UserModel::findOne($user_id);

        if (!$user) {
            return $this->errorResponse('User deos not exist');
        }

        $todo = TodosModel::find()->where(['user_id' => $user_id])->all();

        return $this->asJson(
            $todo
        );
    }

    public function actionTest()
    {
        $sesService = Yii::$app->sesService->getClient();

        $senderEmail = 'kiran.vinzoda@aeonx.digital';
        $recipientEmail = 'vinzodakiran4@gmail.com';
        $subject = 'Test Email from Yii Application';
        $body = 'This is the body of the email. You can use HTML formatting if desired.';

        $test = $sesService->sendEmail([
            'Source' => $senderEmail,
            'Destination' => [
                'ToAddresses' => [$recipientEmail],
            ],
            'Message' => [
                'Subject' => [
                    'Data' => $subject,
                    'Charset' => 'UTF-8',
                ],
                'Body' => [
                    'Text' => [
                        'Data' => $body,
                        'Charset' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        return 'Email sent successfully!';
    }


    public function actionTestt()
    {
        $ses_endpoint = 'https://email.ap-south-1.amazonaws.com'; // Replace with your SES endpoint
        $region = 'ap-south-1'; // Replace with your desired region

        // AWS SES credentials
        $access_key = 'AKIAQ7AKFCNM4IATGPLZ'; // Replace with your AWS Access Key ID
        $secret_key = 'fyEvQRvcp0cxw5J4W/r1lm/9L7ZRVdCtldBt0erp'; // Replace with your AWS Secret Access Key

        // Email data
        $to_email = 'vinzodakiran4@gmail.com';
        $from_email = 'kiran.vinzoda@aeonx.digital';
        $subject = 'Test email from AWS SES';
        $body = 'This is the body of the email sent using AWS SES without the SDK.';

        // Compose the HTTP request
        $endpoint = '/'; // The SES endpoint path
        $http_method = 'POST';
        $headers = [
            'Host' => parse_url($ses_endpoint, PHP_URL_HOST),
            'Content-Type' => 'application/x-www-form-urlencoded',
            'X-Amz-Date' => gmdate('Ymd\THis\Z', time()), // Include the 'X-Amz-Date' header
        ];

        // Additional parameters required for the SES API
        $params = [
            'Action' => 'SendEmail',
            'Destination.ToAddresses.member.1' => $to_email,
            'Message.Subject.Data' => $subject,
            'Message.Body.Text.Data' => $body,
            'Source' => $from_email,
        ];

        // Create the canonical request
        $canonical_request = implode("\n", [strtoupper($http_method), $endpoint, http_build_query($params)]);

        // Create the string to sign
        $string_to_sign = implode("\n", ['AWS4-HMAC-SHA256', gmdate('Ymd\THis\Z', time()), gmdate('Ymd', time()) . '/' . $region . '/ses/aws4_request', hash('sha256', $canonical_request)]);

        // Create the signing key
        $kSecret = 'AWS4' . $secret_key;
        $kDate = hash_hmac('sha256', gmdate('Ymd', time()), $kSecret, true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', 'ses', $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);

        // Calculate the signature
        $signature = hash_hmac('sha256', $string_to_sign, $kSigning);

        // Add the signature to the headers
        $headers['Authorization'] = 'AWS4-HMAC-SHA256 Credential=' . $access_key . '/' . gmdate('Ymd', time()) . '/' . $region . '/ses/aws4_request, SignedHeaders=' . implode(';', array_keys($headers)) . ', Signature=' . $signature;

        // Send the HTTP request using cURL
        $ch = curl_init($ses_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function ($key, $value) {
            return $key . ': ' . $value;
        }, array_keys($headers), $headers));

        $response = curl_exec($ch);
        print($response);
        if ($response === false) {
            // Error handling
            echo 'Error: ' . curl_error($ch);
        } else {
            // Success
            echo 'Email sent successfully!';
        }

        curl_close($ch);
    }
    public function actionAddTodo()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $title = $data->title;
        $desc = $data->desc;
        $user_id = $data->user_id;
        $user = UserModel::findOne($user_id);

        if (!$user) {
            return $this->errorResponse('User deos not exist');
        }

        $todo = new TodosModel();

        $todo->title = $title;
        $todo->desc = $desc;
        $todo->user_id = $user_id;
        $todo->save();

        return $this->asJson(
            $todo
        );
    }

    public function actionEditTodo()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $title = $data->title;
        $desc = $data->desc;
        $todo_id = $data->todo_id;

        $todo = TodosModel::findOne($todo_id);

        if (!$todo) {
            return $this->errorResponse('Todo deos not exist');
        }

        $todo->title = $title;
        $todo->desc = $desc;
        $todo->save();

        return $this->asJson(
            $todo
        );
    }

    public function actionDeleteTodo()
    {
        $request = Yii::$app->request;
        $data = json_decode($request->rawBody);

        $todo_id = $data->todo_id;

        $todo = TodosModel::findOne($todo_id);
        if (!$todo) {
            return $this->errorResponse('Todo deos not exist');
        }

        $todo->is_deleted = 1;
        $todo->save();

        return $this->asJson(
            $todo
        );
    }

    private function errorResponse($message)
    {

        // set response ucode to 400
        Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }
}
