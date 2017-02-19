<?php
/**
 * User: Axoford12
 * Date: 2/19/2017
 * Time: 11:22 PM
 */

namespace app\models;


use yii\base\Model;

class UserListForm extends Model
{

    /**
     * @var $type
     * 代表所查找用户的依据
     * order by ....
     */
    public $type;

    /**
     * @var $param
     * 代表所要查询的依据附带的参数
     * The params that you want to search.
     */
    public $param;

    /**
     * 方法继承自model
     * @return array
     * 返回一个数组来告诉框架这个数据在浏览器的现实值
     * Return an array to tell explorer value to display.
     */
    public function attributeLabels()
    {
        return [
            'type' => \Yii::t('UserListForm','Please select a type'),
            'param' => \Yii::t('UserListForm','Please enter the param of this type')
        ];
    }

    public function getTypes(){
        // todo 实现这个方法 Implement this function
    }
}