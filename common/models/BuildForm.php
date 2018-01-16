<?php

namespace common\models;

use Yii;
use yii\base\Model;


class BuildForm extends Model
{
    public $user_id;
    public $status;
    public $buildname;
    public $description;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // buildname is required
            [['buildname'], 'required'],
        ];
    }
}
