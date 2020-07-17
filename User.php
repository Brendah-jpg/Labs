<?php
	include "Crud.php";
	include "authenticator.php";
	include_once 'DBConnector.php';
	class User implements Crud, Authenticator{
		private $user_id;
		private $first_name;
		private $last_name;
		private $city_name;
		private $username;
		private $password;
		private $fileToUpload;

		function __construct($first_name, $last_name, $city_name, $username, $password, $fileToUpload){
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->city_name = $city_name;
			$this->username = $username;
			$this->password = $password;
			$this->fileToUpload = $fileToUpload;
			}
				//problem?
		public static function create(){
			$instance = new self($first_name, $last_name, $city_name, $username, $password, $fileToUpload);
			return $instance;
		}
		public function setUsername($username){
			$this->username = $username;
		}

		public function getUsername(){
			return $this->username;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function getPassword(){
			return $this->password;
		}
		public function setUserId($user_id){
			$this->user_id = $user_id;
		}

		public function getUserId(){
			return $this-> $user_id;
		}
		public function hashPassword(){
			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		public function isPasswordCorrect(){
			$conn = new DBConnector;
			$found = false;
			$res = "SELECT * FROM user" or die ("Error ". mysqli_error());


			while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
				if(password_verify($this->getPassword(), $row['password']) && $this->getUsername()==$row['username']){
					$found = true;
				}
			}
			$conn->closeDatabase();
			return $found;
		}

		public function login(){
			if($this->isPasswordCorrect()){
				header("Location: private_page.php");
			}
		}

		public function createUserSession(){
			session_start();
			$_SESSION['username'] = $this->getUsername();

		}

		public function logout(){
			session_start();
			unset($_SESSION['username']);
			session_destroy();
			header("Location:lab1.php");
		}
		public function save(){

			$servername = "localhost";
			$username = "root";
			$password = "";
			$db = "ics3104";

			$conn = mysqli_connect($servername, $username, $password, $db);

			if(!$conn){
				die("Connection failure");
			}
			
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;
			$uname = $this->username;
			$this->hashPassword();
			$pass = $this->password;
			$fileToUpload = $this->fileToUpload;
			
			$res = "INSERT INTO user (first_name, last_name, user_city, username, password, file) VALUES ('$fn', '$ln', '$city', '$uname', '$pass', '$fileToUpload')";

			if(mysqli_query($conn, $res)){
				return $res; 
					}
			else {
			 	echo "Error: " . $res . "<br>" . mysqli_error($conn);
				 }
		}
		

		public function readAll(){

			$servername = "localhost";
			$username = "root";
			$password = "";
			$db = "ics3104";

			$conn = mysqli_connect($servername, $username, $password, $db);

			if(!$conn){
				die("Connection failure");
			}
			
			$query = "SELECT * FROM user";
			echo "<b> <center>Database Output </center> <b> <br><br>";

			if($result = $mysqli->query($query)){
				while ($row = $result->fetch_assoc()) {
					$id = $row["id"];
					$fname = $row["first_name"];
					$lname = $row["last_name"];
					$city_name = $row["user_city"];
					$uname = $row["username"];
					$password = $row["password"];

				echo '<tr>
						<td> '.$id.'</td>
						<td> '.$fname.'</td>
						<td> '.$lname.'</td>
						<td> '.$city_name.'</td>
						<td> '.$uname.'</td>
						<td> '.$password.'</td>

				</tr>';
				} $result->free();
			}
			
		}
		public function readUnique(){
			return null;
		}
		public function search(){
			return null;
		}
		public function update(){
			return null;
		}
		public function removeOne(){
			return null;
		}
		public function removeAll(){
			return null;
		}
		public function validateForm(){
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;
			$uname = $this->username;
			$psw = $this->password;
			$img = $this->fileToUpload;

			if($fn == "" || $ln == "" || $city == "" ||$uname == "" || $psw = "" || $img = ""){
				return false;
				}
			return true;
		}
		public function createFormErrorSessions(){
			session_start();
			$_SESSION['form_errors'] = "All fields are required";
			}

		public function isUserExist(){


			}
		}
	
?>