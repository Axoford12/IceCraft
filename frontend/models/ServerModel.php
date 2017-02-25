<?php
/**
 * User: Axoford12
 * Date: 2/24/2017
 * Time: 7:46 PM
 */

namespace app\models;


use yii\base\Exception;
use yii\base\Model;

class ServerModel extends Model
{
    const ACTION_IMPORT_FROM_MULTICRAFT = 1;
    const ACTION_IMPORT_FROM_LOCAL = 2;
    public $api;

    /**
     * @param $action
     * @return bool
     * @throws Exception
     * This function will sync server with Multicraft Panel and Local Database.
     */
    public function import($action)
    {
        if (!$action) {
            throw new Exception('Miss param:action');
        } elseif ($action == self::ACTION_IMPORT_FROM_MULTICRAFT) {
            $result = [];

            $data = $this->_getApiAnswer('listServers')['Servers'];
            foreach ($data as $id => $item) {
                $one = $this->_getApiAnswer('getServer', $id)['Server'];
                $one['owner'] = $this->_getApiAnswer('getServerOwner', $id)['user_id'];
                $result[] = $one;
            }
            $rows = [];
            foreach ($result as $item) {
                $rows[] = [$item['id'], time() + 36000, $item['owner'], $item['name']];
            }
            Server::deleteAll();
            \Yii::$app->db
                ->createCommand()
                ->batchInsert('server', ['id', 'time', 'owner', 'name'], $rows)
                ->execute();
        } elseif ($action == self::ACTION_IMPORT_FROM_LOCAL) {
            $data = Server::find()->asArray()->all();
            foreach ($data as $datum) {
                try {
                    $this->_getApiAnswer('getServer', $datum['id']);
                } catch (Exception $e) {



                    $result = $this->api->createServer($datum['name'],0,'', 10);

                    if($result['success']){
                        $serverInfo = $this->_getApiAnswer('getServer',$result['data']['id'])['Server'];
                        $model = Server::findOne(['id' => $datum['id']]);
                        $model->id = $serverInfo['id'];
                        $model->is_supp = $serverInfo['suspended'];
                        $model->port = $serverInfo['port'];
                        $model->time = strtotime(\Yii::$app->params['IceConfig']['time']);
                        $model->update();
                    }

                }
            }

        }


        return true;
    }


    /**
     * function of api
     * @param $func
     * @param int $param
     * @return array
     * @throws Exception
     */
    private function _getApiAnswer($func, $param = 0)
    {
        $data = $this->api->$func($param);
        if ($data['success']) {
            return $data['data'];
        } else {
            throw new Exception(\Yii::t('site', 'Cannot get server list :') . $data['errors'][0]);
        }
    }
}