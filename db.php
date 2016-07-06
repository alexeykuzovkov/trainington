<?php
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir"){
            rrmdir($dir."/".$object);
         }else{ 
            unlink($dir."/".$object);
         }
       }
     }
     reset($objects);
     rmdir($dir);
  }
}
class Connection {
	private $db;
	function __construct() {

	}
	function __destruct() {
        $this->db->close();
    }

    function connect() {
    	$configs = include('config.php');
    	$this->db = new mysqli($configs["host"], $configs["user"], $configs["password"], $configs["db"]);
       	if ($this->db->connect_error) {
		    die('Connect Error (' . $this->db->connect_errno . ') ' . $this->db->connect_error);
		} 
		if (!$this->db->set_charset("utf8")) {
		    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
		} 
        $this->db->autocommit(TRUE);
    }
    function select($query, $values, $types) {

		$stmt = $this->db->prepare($query);

		$a_params = array();

		if (count($values)>0) {
			$a_params[] = & $types;
			for ($i=0; $i<count($values); $i++) {
				$a_params[] = & $values[$i];
			}
			call_user_func_array(array($stmt, 'bind_param'), $a_params);
		}

		$stmt->execute();

		$stmt->store_result();

		return $this->fetch($stmt);

    }
    function fetch($result)
	{    
	    $array = array();
	    
	    if($result instanceof mysqli_stmt)
	    {
	        $result->store_result();
	        
	        $variables = array();
	        $data = array();
	        $meta = $result->result_metadata();
	        
	        while($field = $meta->fetch_field())
	            $variables[] = &$data[$field->name]; // pass by reference
	        
	        call_user_func_array(array($result, 'bind_result'), $variables);
	        
	        $i=0;
	        while($result->fetch())
	        {
	            $array[$i] = array();
	            foreach($data as $k=>$v)
	                $array[$i][$k] = $v;
	            $i++;
	        }
	    }
	    elseif($result instanceof mysqli_result)
	    {
	        while($row = $result->fetch_assoc())
	            $array[] = $row;
	    }
	    
	    return $array;
	}
    /*
     * Пример $query
     * "INSERT INTO test(id) VALUES (?)"
     * Пример $values
     * $values = array(1, "Дерьмо");
     */
    function sql($query, $values, $types) {
		if (!($stmt = $this->db->prepare($query))) {
		    echo "Не удалось подготовить запрос: (" . $this->db->errno . ") " . $this->db->error;
		}
		
		$a_params = array();
	
		$a_params[] = & $types;

		for ($i=0; $i<count($values); $i++) {
			$a_params[] = & $values[$i];
		}

		call_user_func_array(array($stmt, 'bind_param'), $a_params);
	
		if (!$stmt->execute()) {
		    //echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
		    $iid = -1;
		}
		else {
			$iid = $stmt->insert_id;
		}
        $stmt->close();
        
        return $iid;
    }  
}
?>