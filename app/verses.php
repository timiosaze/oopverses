<?php 


class Verses {
	
	public $id;
	public $verse;
	public $content;
	public $user_id;
	public $created_at;

	public function find_all_verses($user_id)
	{
		return $this->find_by_query("SELECT * FROM verses WHERE user_id = $user_id");
	}

	public function find_verse_by_id($id, $user_id)
	{
		$result = $this->find_by_query("SELECT * FROM verses WHERE id = $id AND user_id = $user_id LIMIT 1");
		return !empty($result) ? array_shift($result) : false;

	}
	public function find_by_query($sql){

		global $database;
		$result = $database->query($sql);
		$object_result = array();
		while($row = $result->fetch_array(MYSQLI_BOTH)){
			$object_result[] = $this->instantiate($row);
		}
		return $object_result;
	}

	public function instantiate($the_verses){
		$verses = new self();
		foreach ($the_verses as $the_attribute => $value) {
			if($verses->has_the_attribute($the_attribute)){
				$verses->$the_attribute = $value;
			}
		}
		return $verses;

	}

	public function has_the_attribute($the_attribute){
		$array_properties = get_object_vars($this);
		return array_key_exists($the_attribute, $array_properties);
	}

	public function create()
	{
		global $database;
		$sql = "INSERT INTO verses (verse, content, user_id, created_at) ";
		$sql .= "VALUES ('";
		$sql .= $database->escape_string($this->verse) . "', '";
		$sql .= $database->escape_string($this->content) . "', '";
		$sql .= $database->escape_string($this->user_id) . "', '";
		$sql .= date("Y-m-d H:i:s") . "')";

		if($database->query($sql)){
			$this->id = $database->the_insert_id();
			return true;
		} else {
			return false;
		}
	}

	public function update()
	{
		global $database;
		$sql = "UPDATE verses SET ";
		$sql .= "verse = '" . $database->escape_string($this->verse) . "', ";
		$sql .= "content = '" . $database->escape_string($this->content) . "', ";
		$sql .= "created_at= '" . date("Y-m-d H:i:s") . "' ";
		$sql .= "WHERE user_id = " . $database->escape_string($this->user_id) . " "; 
		$sql .= "AND id = " . $database->escape_string($this->id);

		$database->query($sql);

		return ($database->connection->affected_rows) ? true : false; 
	}

	public function delete($del_id, $user_id)
	{
		global $database;
		$sql = "DELETE FROM verses WHERE ";
		$sql .= "user_id = $user_id ";
		$sql .= "AND id = $del_id " ;

		$database->query($sql);
		return ($database->connection->affected_rows) ? true : false;
	}

	public function count($user_id)
	{
		global $database;
		$sql = "SELECT * FROM verses WHERE user_id = $user_id";
		$rows = $database->query($sql);
		return $rows->num_rows;
	}
}


