<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Session Dynamo Driver
 *
 */
 
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

class CI_Session_dynamo_driver extends CI_Session_driver implements SessionHandlerInterface {
    /**
     * Dynamo instance
     *
     */
    protected $_dynamo;
	protected $_sdk;
	protected $_tableName = 'session';
	
    /**
     * Key prefix
     *
     * @var    string
     */
    protected $_key_prefix = 'ci_session:';
	
	protected $_region = '';

	
	
    // ------------------------------------------------------------------------
    /**
     * Class constructor
     *
     * @param    array    $params    Configuration parameters
     * @return    void
     */
    public function __construct(&$params)
    {
        parent::__construct($params);
        if (empty($this->_config['save_path']))
        {
            log_message('error', 'Session: No database configured.');
        }
        if ($this->_config['match_ip'] === TRUE)
        {
            $this->_key_prefix .= $_SERVER['REMOTE_ADDR'].':';
        }
		$this->_region = config_item('sess_region');
		
		if(empty($this->_region)) {
			log_message('error', 'Session: Missing configuration.');
		}
		
		$this->_sdk = new Aws\Sdk(array(
						    'region'   => $this->_region,
						    'version'  => 'latest'
					));
		
		
    }
    // ------------------------------------------------------------------------
    /**
     * Open
     *
     * Sanitizes save_path and initializes connections.
     *
     * @param    string    $save_path    Server path(s)
     * @param    string    $name        Session cookie name, unused
     * @return    bool
     */
    public function open($save_path, $name)
    {
        $this->_dynamo = $this->_sdk->createDynamoDb();
        return TRUE;
    }
    // ------------------------------------------------------------------------
    /**
     * Read
     *
     * Reads session data and acquires a lock
     *
     * @param    string    $session_id    Session ID
     * @return    string    Serialized session data
     */
    public function read($session_id)
    {
        
        if ( !isset($this->_dynamo)) {
            return FALSE;
        }
        
        $this->_session_id = $session_id;
        
        $args = array(
            'TableName' => 'session',
            'Key' => array(
                'id' => array('S' => $this->_key_prefix.$session_id)
            ),
            'ConsistentRead' => true
        );
        
        $session_data_base = $this->_dynamo->getItem($args);
        $session_data = $session_data_base['Item']['data']['S'];
        
        $this->_fingerprint = md5($session_data);
        return $session_data;
        
    }
    // ------------------------------------------------------------------------
    /**
     * Write
     *
     * Writes (create / update) session data
     *
     * @param    string    $session_id    Session ID
     * @param    string    $session_data    Serialized session data
     * @return    bool
     */
    public function write($session_id, $session_data)
    {
        
        if ( !isset($this->_dynamo)) {
            return FALSE;
        }
        
        // Was the ID regenerated?
        elseif ($session_id !== $this->_session_id)
        {
            $this->_fingerprint = md5('');
            $this->_session_id = $session_id;
        }
        
        $args = array( 
        	'TableName' => $this->_tableName,
            'Item' => array(
                    'id' => array('S' =>$this->_key_prefix.$session_id),
                    'lastWrite' => array('S' =>''.time()),
                    'lastWriteDate' => array('S' =>''.date('Y/m/d h:i:s')),
                    'data' => array('S' => $session_data)
                	)
            );
        
        $this->_dynamo->putItem($args);
        
        return TRUE;
    }
    // ------------------------------------------------------------------------
    /**
     * Close
     *
     * Releases locks and closes connection.
     *
     * @return    bool
     */
    public function close()
    {
        if (isset($this->_dynamo))
        {
            $this->_dynamo = NULL;
        }
        return True;
    }
    // ------------------------------------------------------------------------
    /**
     * Destroy
     *
     * Destroys the current session.
     *
     * @param    string    $session_id    Session ID
     * @return    bool
     */
    public function destroy($session_id)
    {
        
        if ( !isset($this->_dynamo)) {
            return FALSE;
        }
        
        $args = array(
            'TableName' => 'session',
            'Key' => array(
                'id' => array('S' => $this->_key_prefix.$session_id)
            ),
            'ConsistentRead' => true
        );
        
        $this->_dynamo->deleteItem($args);
        return $this->_cookie_destroy();
    }
    // ------------------------------------------------------------------------
    /**
     * Garbage Collector
     *
     * Deletes expired sessions
     *
     * @param    int     $maxlifetime    Maximum lifetime of sessions
     * @return    bool
     */
    public function gc($maxlifetime)
    {
        // Not necessary, Dynamo takes care of that.
        if ( !isset($this->_dynamo)) {
            return FALSE;
        }
        $max = time()-$maxlifetime;
        $args = array(
            'TableName' => 'session',
            'FilterExpression' => 'lastWrite <= :max',
            'ExpressionAttributeValues' =>  array(
                ':max' => array('S' => "$max")
            )
        );

        $response = $this->_dynamo->scan($args);

        foreach ($response['Items'] as $item) {
            $this->_dynamo->deleteItem(
                array(
                    'TableName' => 'session',
                    'Key' => array(
                        'id' => array('S' => "{$item['id']['S']}")
                    )
                )
            );
        }
        return TRUE;
    }
}
