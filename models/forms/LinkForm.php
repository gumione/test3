<?php
namespace app\models\forms;

use yii\base\Model;
use app\models\Link;
use app\components\TokenGenerator;

/**
 * This is the form model class for table "links".
 *
 * @property string $full_url
 * @property integer $limit
 * @property integer $ttl_hrs
 * @property integer $ttl_min
 * @property integer $ttl_sec
 */
class LinkForm extends Model
{

    public $full_url;
    public $limit;
    public $ttl_hrs;
    public $ttl_min;
    public $ttl_sec;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_url', 'limit', 'ttl_hrs', 'ttl_min', 'ttl_sec'], 'required'],
            [['limit'], 'integer'],
            [['ttl_hrs'], 'integer', 'min' => 0, 'max' => 24],
            [['ttl_min', 'ttl_sec'], 'integer', 'min' => 0, 'max' => 59],
            [['full_url'], 'string', 'max' => 512],
            [['full_url'], 'url'],
            ['ttl_hrs', function($attribute, $params) {
                    if ((($this->ttl_hrs * 3600) + ($this->ttl_min * 60) + ($this->ttl_sec)) > 60 * 60 * 24) {
                        $this->addError('ttl_hrs', 'Lifetime Should be less than 24hrs');
                        $this->addError('ttl_min', 'Lifetime Should be less than 24hrs');
                        $this->addError('ttl_sec', 'Lifetime Should be less than 24hrs');
                    }
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_url' => 'Link',
            'limit' => 'Clicks limit',
            'ttl_hrs' => 'Hours',
            'ttl_min' => 'Minutes',
            'ttl_sec' => 'Seconds',
        ];
    }

    public function createLink(TokenGenerator $tokenGenerator): ?Link
    {
        if (!$this->validate()) {
            return null;
        }

        $record = new Link();

        $record->full_url = $this->full_url;
        $record->limit = $this->limit;
        $record->expires_at = time() + (($this->ttl_hrs * 3600) + ($this->ttl_min * 60) + ($this->ttl_sec));

        // actually, if we need (in case of optimization) we could "save" 1 DB request if we don't use unique token validator in Link model
        // and use try-catch to catch db unique index exception, then regenerate the token
        while ($record->getErrors('token') !== null) {
            $record->token = $tokenGenerator->generate();
            if ($record->save()) {
                return $record;
            }
        }
    }
}
