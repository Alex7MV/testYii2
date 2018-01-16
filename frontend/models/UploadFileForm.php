<?php
/**
 * Created by PhpStorm.
 * User: aumoz
 * Date: 15.01.2018
 * Time: 16:25
 */

namespace frontend\models;

use Yii;
use yii\base\Model;

class UploadFileForm extends Model
{
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'xls, xlsx',
                'skipOnEmpty' => false]
        ];
    }

}