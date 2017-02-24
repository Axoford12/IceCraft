<?php
/**
 * User: Axoford12
 * Date: 2/24/2017
 * Time: 7:46 PM
 */

namespace app\models;


use yii\base\Model;

class ServerModel extends Model
{
    public $api;

    /**
     * This function will sync server with Multicraft Panel and Local Database.
     */
    public function syncServer(){

        return $this->_getServerListInMulticraft();
    }

    /**
     * @param $api
     * api of multicraft.
     * Get server List in multicraft
     */
    private function _getServerListInMulticraft(){
        return $this->api->listServers();
    }
}