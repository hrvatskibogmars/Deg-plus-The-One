<?php
namespace app\models\nodes;
use app\interfaces\RequestHandler;
use app\models\base\BaseNodeModel;

/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 14:32
 */
class LicitationNode extends BaseNodeModel implements RequestHandler
{

    /**
     * Handle GET request for api node.
     *
     * @param array $data
     * @return mixed
     */
    public function get($data = array())
    {

    }

    /**
     * Handle POST request for api node
     *
     * @param array $data
     * @return mixed
     */
    public function post($data = array())
    {
        // TODO: Implement post() method.
    }

    /**
     * Handle DELETE request for api node.
     * @param array $data
     * @return mixed
     */
    public function delete($data = array())
    {
        // TODO: Implement delete() method.
    }

    /**
     * Handle PUT request for api node.
     *
     * @param array $data
     * @return mixed
     */
    public function put($data = array())
    {
        $user = wp_get_current_user();
        $licitation = \Licitation::getForUser( $user->ID, $data['tableId']);

        if($licitation) {
            $licitation->setAmount($data['amount']);
            $licitation->save();
        } else {
            $licitation = new \Licitation();
            $licitation->setAmount($data['amount']);
            $licitation->setDesignatedTable($data['tableId']);
            $licitation->setUserId($user->ID);
            $licitation->save();
        }

        $this->setData(array("message" => "success"));
    }
}