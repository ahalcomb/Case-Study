<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAppAutoload() {
	    $autoloader = new Zend_Loader_Autoloader_Resource(array(
	            'namespace' => 'Application',
	            'basePath' => APPLICATION_PATH,
	            'resourceTypes' => array(
	                    'model' => array(
	                            'path' => 'models/',
	                            'namespace' => 'Model_',
	                    ),
	                    'model_db' => array(
	                        'path' => 'models/DbTable/',
	                        'namespace' => 'Model_DbTable_'
	                    )
	            )
	    ));
	}

}

