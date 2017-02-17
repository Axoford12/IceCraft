<?php
/**
 * User: Axoford12
 * Date: 2/17/2017
 * Time: 9:52 PM
 */

namespace app\models;


use Codeception\Lib\Interfaces\ActiveRecord;
use yii\base\Model;
use yii\db\Query;

class KeyGeneratorForm extends Model
{
    /**
     *  代表所要生成的Key数字;
     *  The number of keys you want to generate.
     */
    public $num;

    public function rules(){
        return [
            // Set num must be required.
            //  设置数字为必填项
            ['num','required','message' => '生成数'.\Yii::t('site','cannot be blank')],

            // Set num must be integer
            // 设置数字必须为整数
            ['num','integer','message' => '生成数'.\Yii::t('site','must be integer')],

            // Set num max = 30 , min = 0
            // 设置数字最大为30 ，最小为0
            ['num' ,'number' ,'max' => 30 ,'min' => 0]
        ];
    }

    public function attributeLabels()
    {
        return [
            'num' => '生成数'
        ];
    }

    public function generateKey(){
        $data = self::_getData($this->num);
        \Yii::$app
            ->db
            ->createCommand()
            ->batchInsert('keys',['id','value'],$data)
            ->execute();
        return true;
    }

    private static function _getData($num){
        $res = [];
        for ($i=0;$i<$num;$i++){
            $res[] = [null,\Yii::$app->security->generateRandomString()];
        }
        return $res;
    }

}