<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int|null $is_deleted
 * @property string|null $started_on
 * @property string|null $updated_on
 */
class UserModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['is_deleted'], 'integer'],
            [['started_on', 'updated_on'], 'safe'],
            [['email', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'is_deleted' => 'Is Deleted',
            'started_on' => 'Started On',
            'updated_on' => 'Updated On',
        ];
    }
}
