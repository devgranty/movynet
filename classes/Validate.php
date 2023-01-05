<?php

/**
 * 
 * Class Validate validates different inputs.
 *
 */
namespace Classes;
use Classes\Database;

class Validate{
	private $_db = null, $_query, $_count = 0;

	public function __construct(){
		$this->_db = Database::getInstance();
	}

	public function comparePassword($password1, $password2){
		if($password1 === $password2) return true;
		return false;
	}

	public function checkDuplicates($value, $table, $column){
		$this->_query = $this->_db->selectQuery($table, [$column], [
			'WHERE' => [$column=>$value]
		]);
		$this->_count = $this->_query->row_count();
		return $this->_count;
	}

	public function validateEmail($input){
		if(filter_var($input, FILTER_VALIDATE_EMAIL)) return true;
		return false;
	}

	public function validateInt($input){
		if(filter_var($input, FILTER_VALIDATE_INT) === 0 || !filter_var($input, FILTER_VALIDATE_INT) === false) return true;
		return false;
	}
}
