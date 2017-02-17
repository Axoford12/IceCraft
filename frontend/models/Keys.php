<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "keys".
 *
 * @property string $id
 * @property string $value
 */
class Keys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'value' => Yii::t('site', 'Value'),
        ];
    }
}
