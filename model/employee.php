<?php
	
	require_once('../vendor/ircmaxell/ircmaxell.php');
	require_once('database.php');
	require_once('extraction.php');
	require_once('right_group.php');
	require_once('address.php');

	class employee {

		private $id;
		private $name;
		private $surname;
		private $short_phone;
		private $phone_number;
		private $mail;
		private $id_address;
		private $address;
		private $birthdate;
		private $right_group;
		private $login;
		private $password;

		private $pdo;

		public function __construct($id = 0){
			$this->pdo = database::getInstance();
			$this->tf = new textFinder();
			$this->id_address = -1;
			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function printLink(){
			return '<a href="../controller/viewEmployee.php?id='.$this->id.'">'.ucwords($this->name.' '.$this->surname).'</a>';
		}

		public function __autoload($class_name) {
		    include '../model/'.$class_name . '.php';
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM employee WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model employee :".$e->getMessage());
			}

			if($stmt_get->rowcount() != 0){
				$stmt_get = $stmt_get->fetch(PDO::FETCH_ASSOC);
				foreach($stmt_get as $key => $value){
					$this->$key = $value;
				}
				$this->getAddress();
				return true;
			} else {
				return false;
			}
		}

		public function getAddress(){
			$tmp = new address($this->id_address);
			$this->address = $tmp;
		}

		public function addToDatabase(){

			$this->birthdate = strtotime($this->birthdate);

			$nname = strtolower($this->name);
			$nsurname = strtolower($this->surname);

			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO employee(name,surname,mail,short_phone,phone_number,id_address,birthdate,right_group,login,password) VALUES(:name,:surname,:mail,:short_phone,:phone_number,:id_address,:birthdate,:right_group,:login,:password)");
			$stmt->bindParam(':name',$nname);
			$stmt->bindParam(':surname',$nsurname);
			$stmt->bindParam(':mail',$this->mail);
			$stmt->bindParam(':short_phone',$this->short_phone);
			$stmt->bindParam(':phone_number',$this->phone_number);
			$stmt->bindParam(':id_address',$this->id_address);
			$stmt->bindParam(':birthdate',$this->birthdate);
			$stmt->bindParam(':right_group',$this->right_group);
			$stmt->bindParam(':login',$this->login);
			$stmt->bindParam(':password',$this->password);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model employee :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM employee WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model employee :'.$e->getMessage());
			}
			$actual_employee = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_employee as $key => $value){
				if($actual_employee[$key] != $this->$key && $this->$key != ""){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE employee SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model employee :'.$e->getMessage());
					}
				}
			}
		}
		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM employee WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model employee :'.$e->getMessage());
			}
		}

		public function cryptpassword($password){
			return password_hash($password,PASSWORD_BCRYPT);
		}

		public function checkPassword($login,$password){
			$stmt = $this->pdo->PDOInstance->prepare("SELECT id,password FROM employee WHERE login = :login");
			$stmt->bindParam(':login',$login);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model employee :'.$e->getMessage());
			}

			if($stmt->rowcount() == 1){
				$stmt = $stmt->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password,$stmt["password"])){
					$this->setId($stmt["id"]);
					$this->getFromDatabase();
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function printTR(){
			if($this->address == NULL){
				$this->getAddress();
			}
			$right_group = new right_group($this->right_group);
			echo('<tr class="employee"><td>'.ucwords($this->name).'</td>
			<td>'.ucwords($this->surname).'</td>
			<td>'.$this->mail.'</td>
			<td>'.$this->short_phone.'</td>
			<td>'.$this->phone_number.'</td>
			<td>'.$this->address->printAddress().'</td>
			<td>'.date('d-m-y',$this->birthdate).'</td>
			<td>'.ucfirst($right_group->getName()).'</td>			
			<td><a href="../controller/viewEmployee.php?id='.$this->id.'"><button class=\'modif_product\'><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td></tr>');
		}

		public function printText(){
			return ucwords($this->surname.' '.$this->name);
		}

		public function printToModify($next){
			$extraction = new extraction();
			if($this->address == NULL){
				$this->getAddress();
			}
			$groups = $extraction->getRight_group();
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="'.ucwords($this->name).'">
				</div>
				<div class="form-group">
					<label for="surname">'.$this->tf->getText(53).'</label>
					<input name="surname" type="text" class="form-control" value="'.ucwords($this->surname).'">
				</div>
				<div class="form-group">
					<label for="mail">'.$this->tf->getText(51).'</label>
					<input name="mail" type="text" class="form-control" value="'.$this->mail.'">
				</div>
				<div class="form-group">
					<label for="short_phone">'.$this->tf->getText(54).'</label>
					<input name="short_phone" type="number" class="form-control" value="'.$this->short_phone.'">
				</div>
				<div class="form-group">
					<label for="phone_number">'.$this->tf->getText(45).'</label>
					<input name="phone_number" type="text" class="form-control" value="'.$this->phone_number.'">
				</div>
				<div class="form-group">
					<label for="address">'.$this->tf->getText(44).' '.$this->tf->getText(69).'</label>
					<input type="text" id="address" class="form-control" value="'.str_replace('<br/>',' ',$this->address->printAddress()).'">
					<input name="id_address" type="hidden" class="form-control" value="'.$this->id_address.'">
					<button id="addAddress" alt="employee" step="address" rel="'.$this->id.'" class=\'display btn btn-primary\'><span class=\'glyphicon glyphicon-plus\' aria-hidden=\'true\'></span></button></a>
					<button id="setAddress" alt="employee" step="address" rel="'.$this->id.'" class=\'display btn btn-primary\'><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a>
					<button id="getAddress" alt="employee" step="address" rel="'.$this->id.'" class=\'display btn btn-primary\'><span class=\'glyphicon glyphicon-search\' aria-hidden=\'true\'></span></button></a>
				</div>
				<div class="form-group">
					<label for="right_group">'.$this->tf->getText(57).'</label>
					<select name="right_group" class="form-control">
					');
						foreach($groups as $group){
							if($this->right_group == $group->getId()){
								echo('<option selected="selected" value="'.$group->getId().'">'.$group->getName().'</option>');
							} else {
								echo('<option value="'.$group->getId().'">'.ucfirst($group->getName()).'</option>');
							}
						}
					echo('
					</select>
				</div>
				<div class="form-group">
					<label for="birthdate">'.$this->tf->getText(56).'</label>
					<input name="birthdate" type="date" class="form-control" value="'.date('Y-m-d',$this->birthdate).'">
				</div>
				');
		}

		public function printToAdd($next){
			$extraction = new extraction();
			$groups = $extraction->getRight_group();
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="surname">'.$this->tf->getText(53).'</label>
					<input name="surname" type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="mail">'.$this->tf->getText(51).'</label>
					<input name="mail" type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="short_phone">'.$this->tf->getText(54).'</label>
					<input name="short_phone" type="number" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="phone_number">'.$this->tf->getText(45).'</label>
					<input name="phone_number" type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="right_group">'.$this->tf->getText(57).'</label>
					<select name="right_group" class="form-control">
					');
						$a = 0;
						foreach($groups as $group){
							if($a == 0){
								echo('<option selected="selected" value="'.$group->getId().'">'.ucfirst($group->getName()).'</option>');
								$a = 1;
							} else {
								echo('<option value="'.$group->getId().'">'.ucfirst($group->getName()).'</option>');
							}
						
						}
					echo('
					</select>
				</div>
				<div class="form-group">
					<label for="birthdate">'.$this->tf->getText(56).'</label>
					<input name="birthdate" type="date" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="login">'.$this->tf->getText(3).'</label>
					<input name="login" type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="password">'.$this->tf->getText(4).'</label>
					<input name="password" type="password" class="form-control" value="">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getName(){return ucwords($this->name);}
		public function getSurname(){return ucwords($this->surname);}
		public function getShort_phone(){return $this->short_phone;}
		public function getPhone_number(){return $this->phone_number;}
		public function getId_address(){return $this->id_address;}
		public function getBirthdate(){return $this->birthdate;}
		public function getRight_group(){return $this->right_group;}
		public function getLogin(){return $this->login;}
		public function getPassword(){return $this->password;}
		public function getMail(){return $this->mail;}

		public function setId($new){$this->id = $new;}
		public function setName($new){$this->name = $new;}
		public function setSurname($new){$this->surname = $new;}
		public function setShort_phone($new){$this->short_phone = $new;}
		public function setPhone_number($new){$this->phone_number = $new;}
		public function setId_address($new){$this->id_address = $new;}
		public function setBirthdate($new){$this->birthdate = $new;}
		public function setRight_group($new){$this->right_group = $new;}
		public function setLogin($new){$this->login = $new;}
		public function setMail($new){$this->mail = $new;}
		public function setPassword($new){$this->password = $this->cryptpassword($new);}
	}

?>