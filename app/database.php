<?php 
 
class Db
{
	public $connection;

	public function __construct()
	{
		$this->opendb_connection();
	}
	public function opendb_connection(){
		$this->connection = new mysqli('127.0.0.1', 'root', '', 'versesdb');
		if($this->connection === false){
			die("Error couldn't connect: ". $this->connection->connect_error);
		} 
	}

	public function query($sql){
		$result = $this->connection->query($sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result){
		if($result === false){
			die("Query Failed");
		}
	}

	public function escape_string($string){
		$escaped_string =$this->connection->real_escape_string($string);
		return $escaped_string;
	}

	public function the_insert_id(){
		return $this->connection->insert_id;
	}
}

$database = new Db();



