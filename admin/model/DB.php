<?php

Class DB{
	private $connection;
	public function getDBConnection(){
	 	$mysqli = new \mysqli("ip","username","password", "dbnamn");
		if ($mysqli->connect_errno) {
		    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		return $mysqli;
	 }
}

