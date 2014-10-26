<?php

abstract class Jobs_Abstract
{
    protected $_logger;
    protected $_logName;
    public $_application;
    
    abstract protected function _jobLogic();

    public function run()
    {
    	$this->_initApplication();
    	
        try {
            $this->_jobLogic();
        } catch (Exception $e) {
            print_r($e); die;
        }
    }

    public function getLogger()
    {
        if (!isset($this->_logger)) {
            if (empty($this->_logName)) {
                $this->setDefaultLogName();
            }
        }

        return $this->_logger;
    }

    public function setLogName($name)
    {
        $this->_logName = $name;
    }

    public function setDefaultLogName()
    {
        $name = get_class($this) . "Job";
        $this->setLogName($name);
    }

    protected function _initApplication()
    {
		// Define path to document root
		defined('DOCUMENT_ROOT')
		   || define('DOCUMENT_ROOT', realpath(dirname(__FILE__) . '/../..'));
		
		
		// Define path to application directory
		defined('APPLICATION_PATH')
		    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/..'));
        
		// Define application environment
		if (is_file(APPLICATION_PATH . '/../.env')) {
		    $env = trim(file_get_contents(APPLICATION_PATH . '/../.env'));
		} else {
		    $env = 'production';
		}
		
		defined('APPLICATION_ENV')
		    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : $env));
		
		// Ensure library/ is on include_path
		set_include_path(implode(PATH_SEPARATOR, array(
		    realpath(APPLICATION_PATH . '/../library'),
		    get_include_path(),
		)));
		
		// Zend_Application
		require_once 'Zend/Application.php';
		
		// Create application, bootstrap, and run
		$this->_application = new Zend_Application(
		    APPLICATION_ENV,
		    APPLICATION_PATH . '/configs/application.ini'
		);
		$this->_application->bootstrap();
	}
}
