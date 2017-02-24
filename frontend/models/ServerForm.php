<?php
/**
 * User: Axoford12
 * Date: 2/21/2017
 * Time: 12:22 AM
 */

namespace app\models;


use yii\base\Model;

/**
 * Class ServerForm
 * @package app\models
 * Ok so this model is a Server form
 * Just process some server data
 * and do some useful things
 *
 */
class ServerForm extends Model
{
    /**
     * @var $owner
     * The id of this server s owner.
     * In new updates I want this can be
     * owner's name not his or her id
     * Mau be it wall be implement
     * next develop circle
     */
    public $owner;

    /**
     * @var $time
     * As its name
     * This is a var of server
     * Means when this program should
     * stop this server. or close it
     * instance of int and it is a UNIX time.
     *
     */
    public $time;

    /**
     * @var $name
     * name of this server .
     *
     */
    public $name;

    /**
     * @return array
     * return an array of some rules
     * These rules may be a good func to avoid sql shoots...
     * I don't know how to describe this ...
     */
    public function rules()
    {
        return [
            ['owner', 'integer'],// Owner is an id so must be int.
            ['time', 'integer']// Time data must be a UNIX time so int.
        ];
    }

    /**
     * @param $api
     * This is a param of multicraft api connection.
     * It will be called in next turn
     * To create server in database and multcraft.
     * Use multicraft api
     */
    public function createServer($api)
    {
        $model = new Server();
        $model->insert(true,[
            'id' => null,
            'name' => $this->name,
            'time' => $this->time,
            'owner' => $this->owner
        ]);
    }


}