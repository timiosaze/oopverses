<?php 

class User {

	public $id;
	public $username;
	public $email;
	public $password;

	

	public function find_all_users(){
		return $this->find_by_query("SELECT * FROM users");
	}

	public function find_user_by_id($id){
		$the_result = $this->find_by_query("SELECT * FROM users WHERE id = $id LIMIT 1");
		return !empty($the_result) ? array_shift($the_result) : false;
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

	public function instantiate($found_user){
		$the_user = new self();
		// $the_user->id 		= $found_user['id'];
		// $the_user->email 	= $found_user['email'];
		// $the_user->username = $found_user['username'];
		// $the_user->password = $found_user['password'];
		foreach ($found_user as $the_attribute => $value) {
			if($the_user->has_the_attribute($the_attribute)){
				$the_user->$the_attribute = $value;
			}
		}
		return $the_user;

	}
	public function verify_user($email, $password)
	{
		global $database;
		$email = $database->escape_string($email);
		$password = $database->escape_string($password);
		$sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
		$row = $database->query($sql);
		if($row->num_rows === 1){
			if(password_verify($password, $row['password'])){
				$the_result = $this->find_by_query($sql);
			}
		}
		return !empty($the_result) ? $the_result : false;
	}
	public function check_mail($email)
	{
		global $database;
		$sql = "SELECT email FROM users WHERE email = '$email'";
		$result = $database->query($sql);
		if($result->num_rows >= 1){
			return false;
		} else {
			return true;
		}
	}
	public function has_the_attribute($the_attribute){
		$array_properties = get_object_vars($this);
		return array_key_exists($the_attribute, $array_properties);
	}

	public function create()
	{
		global $database;
		$sql =  "INSERT INTO users (username, email, password)";
		$sql .= "VALUES ('";
		$sql .= $database->escape_string($this->username) . "', '";
		$sql .= $database->escape_string($this->email) . "', '";
		$sql .= $database->escape_string($this->password) . "')";

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
		$sql = "UPDATE users SET ";
		$sql .= "username= '" .$database->escape_string($this->username) ."', ";
		$sql .= "email= '" .$database->escape_string($this->email) ."', ";
		$sql .= "password= '" .$database->escape_string($this->password)."' ";
		$sql .= "WHERE id = " .$database->escape_string($this->id);

		$database->query($sql);

		return ($database->connection->affected_rows()) ? true : false;
	}

	public function delete()
	{
		global $database;
		$sql = "DELETE FROM users WHERE id = '" .$database->escape_string($this->id) ."' ";
		$sql .= " LIMIT 1";

		$database->query($sql);
		return ($database->connection->affected_rows()) ? true : false;
	}
}


 ?>