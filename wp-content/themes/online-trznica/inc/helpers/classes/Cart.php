<?php

/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 19:27
 */
class Cart
{
    private $userId;
    private $data;

    public static function getForUser()
    {
        global $wpdb;

        $user = get_current_user_id();
        $sql = 'SELECT * FROM deg_cart WHERE userId = %d';

        $result = $wpdb->get_row(
            $wpdb->prepare(
                $sql,
                [
                    $user
                ]   
            )
        );

        if(!$result) return null;

        $cart = new Cart();
        $cart->fillFromDB($result);

        return $cart;
    }

    public function save()
    {
        global $wpdb;

        if(Cart::getForUser()) {
            return $this->update();
        }

        $sql = 'INSERT INTO deg_cart(userId, data) VALUES(%d, %s)';

        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    $this->userId,
                    serialize($this->data),
                )
            )
        );

        return $result;
    }

    public function update()
    {
        global $wpdb;

        if(!Cart::getForUser()) {
            return $this->save();
        }

        $sql = 'UPDATE deg_cart
        SET data = %s
        WHERE userId = %d';

        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    serialize($this->data),
                    $this->userId,
                )
            )
        );

        return $result;
    }

    private function fillFromDB($data){
        $this->userId = $data->userId;
        $this->data = unserialize( $data->data );
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }



}