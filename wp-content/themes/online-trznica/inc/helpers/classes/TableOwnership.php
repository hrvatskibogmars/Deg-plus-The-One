<?php

/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 12:46
 */
class TableOwnership
{
    private $userId;
    private $tableId;
    private $amount;


    private function fillWithData($data)
    {
        $this->userId   = $data->userId;
        $this->tableId  = $data->tableId;
        $this->amount   = $data->amount;
    }

}