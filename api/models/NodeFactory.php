<?php
/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 19/04/16
 * Time: 14:50
 */

namespace app\models;

use app\interfaces\RequestHandler;
use app\models\nodes;


class NodeFactory
{
    const LICITATION_NODE = 'LicitationNode';

    /**
     * @param $type
     * @return RequestHandler
     */
    public function generate($type)
    {
        $className = '\app\models\nodes\\' . $type;
        return new $className;
    }
}