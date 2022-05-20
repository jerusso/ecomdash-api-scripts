<?php
/**
 * Class for connecting to BS DB
 */

class BS_DB
{
	//local vars
	//private $db = 'example-bd';
	//private $usr = 'example-admin';//user name for ecomdash DB
	//private $pwd = 'password';//pwr for user


	//live vars
	//private $db = 'example-bd';
	//private $usr = 'example-admin';//user name for ecomdash DB
	//private $pwd = 'password';//pwr for user


	/**
	 * connect to ecomdash DB
	 */
	public function connectToDB() {
			$username = $this->usr;
			$password = $this->pwd;

		try {
			$connBS = new PDO("mysql:host=localhost;dbname=$this->db", $username, $password);
			$connBS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $pe) {
			 die("Could not connect to the database $this->db :" . $pe->getMessage());
		}

		return $connBS;

	}


}

?>
