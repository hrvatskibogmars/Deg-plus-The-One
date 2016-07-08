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


    public static function getAll()
    {
        global $wpdb;

        $sql = 'SELECT * FROM deg_table_ownership';

        $results = $wpdb->get_results( $sql );

        $output = [];

        foreach ($results as $result) {
            $ownership = new TableOwnership();
            $ownership->fillWithData($result);
            $output[] = $ownership;
        }

        return $output;
    }

    public function save()
    {
        global $wpdb;

        $sql = 'INSERT INTO deg_table_ownership(userId, amount, tableId) VALUES(%d, %d, %d)';

        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    $this->userId,
                    $this->amount,
                    $this->tableId,
                )
            )
        );

        return $result;
    }

    public static function generateFromLicitation(Licitation $licitation)
    {
        $tableOwnership = new TableOwnership();
        $tableOwnership->userId = $licitation->getUserId();
        $tableOwnership->tableId = $licitation->getDesignatedTable();
        $tableOwnership->amount = $licitation->getAmount();

        $tableOwnership->save();
    }

    public static function deleteAll()
    {
        global $wpdb;

        $sql = "DELETE FROM deg_table_ownership";

        return $wpdb->query( $sql );
    }

    private function fillWithData($data)
    {
        $this->userId   = $data->userId;
        $this->tableId  = $data->tableId;
        $this->amount   = $data->amount;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }



}