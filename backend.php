<?php
/**
* 
*/
class Backend
{
	function __construct()
	{
		include_once('db.php');
		$this->db = new Connection();
		$this->db->connect();
	}

	

}

return new Backend();
?>