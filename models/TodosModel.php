<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todos".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property int|null $user_id
 * @property int|null $is_deleted
 * @property string|null $started_on
 * @property string|null $updated_on
 */
class TodosModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            [['user_id', 'is_deleted'], 'integer'],
            [['started_on', 'updated_on'], 'safe'],
            [['title', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'user_id' => 'User ID',
            'is_deleted' => 'Is Deleted',
            'started_on' => 'Started On',
            'updated_on' => 'Updated On',
        ];
    }
}
