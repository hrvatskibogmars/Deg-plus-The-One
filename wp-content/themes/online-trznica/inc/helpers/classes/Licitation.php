<?php

class Licitation
{
    private $id;
    private $userId;
    private $amount;
    private $designated_table;


    public static function getWinnerOfTheTable($tableId)
    {
        global $wpdb;
        
        $sql = 'SELECT * FROM deg_licitation
          WHERE designated_table = %d
          ORDER BY amount DESC 
          LIMIT 1
        ';
        
        $result = $wpdb->get_row(
            $wpdb->prepare(
                $sql,
                array(
                    $tableId
                )
            )
        );
        
        return $result;
    }
    
    /**
     * @return array
     */
    public static function getAll()
    {
        global $wpdb;
        
        $sql = 'SELECT * FROM deg_licitation';

        $results = $wpdb->get_results(
            $sql
        );

        $output = [];
        foreach ($results as $result) {
            $licitation = new Licitation();
            $licitation->fillWithDBData($result);
            $output[] = $licitation;
        }

        return $output;
    }

    /**
     * @param $userId
     * @return Licitation|null
     */
    public static function getForUser($userId, $tableId)
    {
        global $wpdb;

        $sql = 'SELECT * FROM deg_licitation WHERE userId = %d AND designated_table = %d';

        $result = $wpdb->get_row(
            $wpdb->prepare(
                $sql,
                array(
                    $userId,
                    $tableId
                )
            )
        );

        if(!$result) return null;

        $licitation = new Licitation();
        $licitation->fillWithDBData($result);

        return $licitation;
    }

    public function save()
    {
        global $wpdb;

        if($this->id) {
            return $this->update();
        }

        $sql = 'INSERT INTO deg_licitation(userId, amount, designated_table) VALUES(%d, %d, %d)';

        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    $this->userId,
                    $this->amount,
                    $this->designated_table,
                )
            )
        );

        $this->id = $wpdb->insert_id;

        return $result;
    }

    public function update()
    {
        global $wpdb;

        if(!$this->id) {
            return $this->save();
        }

        $sql = 'UPDATE deg_licitation
        SET amount = %d
        WHERE id = %d';

        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    $this->id,
                    $this->amount
                )
            )
        );

        return $result;
    }


    private function fillWithDBData($data)
    {
        $this->id       = $data->id;
        $this->userId   = $data->userId;
        $this->amount   = $data->amount;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param mixed $designated_table
     */
    public function setDesignatedTable($designated_table)
    {
        $this->designated_table = $designated_table;
    }



}