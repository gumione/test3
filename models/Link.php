<?php
namespace app\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $token
 * @property string $full_url
 * @property int $limit
 * @property int $expires_at
 * @property int $created_at
 */
class Link extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'full_url', 'limit', 'expires_at'], 'required'],
            [['limit', 'expires_at', 'created_at', 'views'], 'integer'],
            [['token'], 'string', 'max' => 8],
            [['full_url'], 'string', 'max' => 512],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'full_url' => 'Full Url',
            'limit' => 'Limit'
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => function() {
                    return time();
                },
            ],
        ];
    }
}
