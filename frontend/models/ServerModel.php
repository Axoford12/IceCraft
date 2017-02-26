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
    public $api_model;

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

            $data = $this->api_model->listServers['Servers'];
            foreach ($data as $id => $item) {
                $one = $this->api_model->getServer($id)['Server'];
                $one['owner'] = $this->api_model->getServerOwner($id)['user_id'];
                $result[] = $one;
            }
            $rows = [];
            foreach ($result as $item) {
                $rows[] = [$item['id'], strtotime(\Yii::$app->params['IceConfig']['time']), $item['owner'], $item['name']];
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
                    $this->api_model->getServer( $datum['id']);
                } catch (Exception $e) {

                    $result = $this->api_model->createServer($datum['name'],0,'', 10);

                    if($result['success']){
                        $serverInfo = $this->api_model->getServer($result['data']['id'])['Server'];
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


}