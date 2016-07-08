<?php
/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 19/04/16
 * Time: 13:32
 */

namespace app\models\base;
use \Flight as Flight;

class BaseNodeModel
{

    #region output displaying
    private $_hasError      = false;
    private $_errorMessage  = 'Something went wrong.';
    private $_code          = 500;
    private $_data          = array();

    /**
     * Changes output state to success.
     *
     * @param $data
     * @param int $code
     */
    public function setData($data, $code = 200){
        $this->_hasError    = false;
        $this->_data        = $data;
        $this->_code        = $code;
    }

    /**
     * Changes output state to error.
     *
     * @param $errorCode
     * @param $errorMsg
     */
    public function setError( $errorCode, $errorMsg ) {
        $this->_hasError        = true;
        $this->_code            = $errorCode;
        $this->_errorMessage    = $errorMsg;
    }

    /**
     * Outputs data in valid state.
     */
    public function output() {
        header('Content-Type: application/json; charset=utf-8');
        if($this->_hasError){
            $this->outputError();
        }else{
            $this->outputSuccess();    
        }
    }

    /**
     * Retrieve data for the output.
     *
     * @return array
     */
    public function getOutputData()
    {
        if($this->_hasError){
            return array( 'error' => $this->_errorMessage );
        } else {
            return $this->_data;
        }
    }
    #endregion

    #region helpers
    /**
     * @param $required
     * @param $data
     * @return bool
     */
    protected function hasRequired($required, $data)
    {
        $valid = true;
        foreach ($required as $r){
            if(!isset($data[$r]) || empty( $data[$r] )){
                $valid = false;
                break;
            }
        }

        return $valid;
    }

    /**
     * Formats and outputs error message.
     */
    private function outputError()
    {
        $request = Flight::request();
        $access = $request->scheme . ' ' . $request->method . ' ' . $request->base . $request->url . ', IP: ' . $request->ip . ', type: ' . $request->type . ', user_agent: ' . $request->user_agent;

        $errorPlural = is_array( $this->_errorMessage ) ? 'errors' : 'error';

        self::logAccessToDb( $access, $this->_code, json_encode(array( $errorPlural => $this->_errorMessage )));

        Flight::json( array( $errorPlural => $this->_errorMessage ), $this->_code );
    }

    public static function log($errorMessage, $log = 'log.txt')
    {
        $file = fopen($log, 'a');

        fwrite(
            $file,
            '[' .
            date('Y-m-d H:i:s') .
            ']' .
            ' ' .
            $errorMessage .
            '
'
        );

        fclose($file);
    }

    public static function logError(\Exception $error, $log = 'log.txt')
    {
        $file = fopen($log, 'a');

        fwrite(
            $file,
            '[' .
            date('Y-m-d H:i:s') .
            ']' .
            ' ' .
            $error->getMessage() .
            ' : ' . 
            $error->getTraceAsString() . 
            '
'
        );

        fclose($file);
    }

    /**
     * @param \Clrz_user $user
     * @param string $log
     */
    public static function logUserAccess($user, $log = 'access-log.txt')
    {
        $access = $user->getID();
        $access = '[' .
            date('Y-m-d H:i:s') .
            '] User access with user id: ' . $access .'
';

        if($log != 'db') {
            self::logAccessToFile( $access, $log );
        } else {
            self::logAccessToDb( $access );
        }
    }

    public static function logAccess($log = 'access-log.txt')
    {
        $request = Flight::request();
        $access = $request->scheme . ' ' . $request->method . ' ' . $request->base . $request->url . ', IP: ' . $request->ip . ', type: ' . $request->type . ', user_agent: ' . $request->user_agent;
        $access = '[' .
            date('Y-m-d H:i:s') .
            '] ' .
            $access .
            '
';
        if($log != 'db') {
            self::logAccessToFile( $access, $log );
        } else {
            self::logAccessToDb( $log );
        }
    }

    private static function logAccessToDb( $log, $code = 0, $message = '')
    {
        if(!self::checkIsLogOn())
            return false;

        global $wpdb;

        if(\Flight::has('user')) {
            /**
             * @var $user \Clrz_user
             */
            $user = \Flight::get('user');
            $userId = $user->getID();
        } else {
            $userId = 0;
        }
        
        $sql = 'INSERT INTO api_log(log_value, `user`, code, message, parameters) VALUES(%s, %d, %d, %s, %s)';
        $result = $wpdb->query(
            $wpdb->prepare(
                $sql,
                array(
                    $log,
                    $userId,
                    $code,
                    $message,
                    json_encode( self::extractParamsFromFlight() )
                )
            )
        );

        return $result;
    }

    private static function extractParamsFromFlight()
    {
        $query = \Flight::request()->query->getData();
        $data = \Flight::request()->data->getData();

        $putData = array();
        parse_str(file_get_contents("php://input"),$vars);

        $parameters = array_merge($query, $data, $putData);

        $output = array();
        foreach ($parameters as $key => $value) {
            if(sizeof($value) < 1024) {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    private static function logAccessToFile($access, $log = 'access-log.txt')
    {
        if(!self::checkIsLogOn())
            return false;

        if(!file_exists($log)) {
            @file_put_contents($log, '');
        }

        $file = fopen($log, 'a');
        fwrite(
            $file,
            $access
        );

        fclose($file);

        return true;
    }

    private static function checkIsLogOn()
    {
        global $vbulletin;
        
        if(!isset($vbulletin->options) || !isset($vbulletin->options['pvt_mobile_app_log_enabled']))
            return false;

        return (bool) $vbulletin->options['pvt_mobile_app_log_enabled'];
    }

    /**
     * Formats and outputs success data.
     */
    private function outputSuccess()
    {
        $request = Flight::request();
        $access = $request->scheme . ' ' . $request->method . ' ' . $request->base . $request->url . ', IP: ' . $request->ip . ', type: ' . $request->type . ', user_agent: ' . $request->user_agent;
        self::logAccessToDb( $access, $this->_code );
        Flight::json($this->_data, $this->_code);
    }
    #endregion
}