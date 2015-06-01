<?php

public class Log
{
	private $id;
	private $type;
	private $dateCreated;
	private $data;
	private $idOrigin;
	private $idInteract;
	
	public function __construct($type, $dateCreated, $data, $idOrigin, $idInteract, $id = NULL){
			$id->_id = $id;
			$this->_type = $type;
			$this->_dateCreated = $dateCreated;
			$this->_data = $data;
			$this->_idOrigin = $idOrigin;
			$this->_idInteract = $idInteract;
			return $this;
		}
}

?>
