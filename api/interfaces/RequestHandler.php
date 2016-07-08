<?php
/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 19/04/16
 * Time: 13:24
 */

namespace app\interfaces;


interface RequestHandler
{
    /**
     * Handle GET request for api node.
     *
     * @param array $data
     * @return mixed
     */
    public function get( $data = array() );

    /**
     * Handle POST request for api node
     * 
     * @param array $data
     * @return mixed
     */
    public function post( $data = array() );

    /**
     * Handle DELETE request for api node.
     * @param array $data
     * @return mixed
     */
    public function delete( $data = array() );

    /**
     * Handle PUT request for api node.
     * 
     * @param array $data
     * @return mixed
     */
    public function put( $data = array() );


    /**
     * Output final result
     * @return mixed
     */
    public function output();
}