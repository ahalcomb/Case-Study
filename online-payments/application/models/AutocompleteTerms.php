<?php

class Application_Model_AutocompleteTerms extends Application_Model_DbTable_AutocompleteTerms
{
	
	protected $_name = 'autocomplete_terms';
	protected $_primary = 'autocomplete_term_id';
	
	public function init()
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->table = 'autocomplete_terms';
	}
	
	public function getById($id)
	{
		$select = $this->select()->from('autocomplete_terms')->where( 'autocomplete_term_id = ?', $id );
		return $this->db->query($select)->fetch();
	}

	public function getByName($name)
	{
		$select = $this->select()->from('autocomplete_terms')->where( 'lower(name) = ?', strtolower($name) );
		return $this->db->query($select)->fetch();
	}
	
	public function searchTerms($value){
		$return = array();

		$select = $this->select()->from('autocomplete_terms', array('name'))
		->where( 'lower(name) LIKE ?', '%'. strtolower($value) . '%' );

		$result = $this->db->query($select)->fetchAll();	

		foreach ($result as $value) {
			$return[] = $value['name'];
		}

		return $return;

	}

}