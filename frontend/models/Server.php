<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "server".
 *
 * @property string $id
 * @property string $name
 * @property string $owner
 * @property integer $time
 */
class Server extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'owner', 'time'], 'required'],
            [['owner', 'time'], 'integer'],
            [['name'], 'string', 'max' => 201],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'owner' => Yii::t('app', 'Owner'),
            'time' => Yii::t('app', 'Time'),
        ];
    }

}
