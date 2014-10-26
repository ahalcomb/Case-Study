<?php

class Application_Model_DbTable_AutocompleteTerms extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'autocomplete_terms';
	protected $_primary = 'autocomplete_term_id';

	// Save the transaction to the database
    public function insertTerms($name_arr)
    {
    	//first check if name exists

    	foreach ($name_arr as $name) {
	    	if ($name) {
		    	$existing_id = $this->getByName($name);

		    	if ($existing_id == false) {
					// Build up data set to be inserted
					$data = array(
						'name' => $name
					);
					$this->insert($data);
		    	}
	    	}
    	}

    	return true;
    }
	
}