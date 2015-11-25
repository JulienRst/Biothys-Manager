<?php

	require_once('database.php');
	require_once('address.php');
	require_once('group_company.php');
	require_once('customer.php');
	require_once('extraction.php');
	require_once('link_company_delivery_address.php');
	include_once('../controller/getText.php');

	class company {

		private $id;
		private $id_group_company;
		private $group_company;
		private $id_contact;
		private $contact;
		private $id_billing_address;
		private $billing_address;
		private $id_receiving_address;
		private $receiving_address;
		private $name;
		private $nationality;
		private $description;
		private $normal_billing_period;
		private $ust_id;
		private $phone_number;
		private $delivery_addresses;
		private $countryWhoBill;

		//DashBoard Only
		public $orders;
		public $alreadyPaid;
		public $ca;
		public $ordersMonth;

		

		private $pdo;

		public function __construct($id = 0){

			$this->pdo = database::getInstance();
			$this->id_contact = "";
			$this->id_billing_address = "";
			$this->id_receiving_address = "";
			$this->normal_billing_period = "";
			$this->receiving_address = new address();
			$this->billing_address = new address();
			$this->tf = new textFinder();
			$this->orders = array();
			$this->ordersMonth = array();
			$this->alreadyPaid = 0;
			$this->ca = 0;
			if($id != 0){
				$this->id = $id;
				$this->getFromDatabase();
			}
		}

		public function addOrder($order){
			array_push($this->orders,$order);
			$this->ca += $order->getPrice();
			$this->alreadyPaid += $order->getAlready_paid();
		}

		public function addOrderMonth($date,$order){
			if(array_key_exists($date,$this->ordersMonth)){
				$this->ordersMonth[$date] += $order->getPrice();
			} else {
				$this->ordersMonth[$date] = $order->getPrice();
			}
		}

		public function getFromDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * 
											FROM company
											WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);

			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo("Problem at ".$e->getLine()." from model company :".$e->getMessage());
			}

			if($stmt_get->rowcount() != 0){
				$stmt_get = $stmt_get->fetch(PDO::FETCH_ASSOC);
				foreach($stmt_get as $key => $value){
					$this->$key = $value;
				}
				$this->billing_address = new address($this->id_billing_address);
				$this->receiving_address = new address($this->id_receiving_address);				
				$this->group_company = new group_company($this->id_group_company);
				$this->contact = new customer($this->id_contact);

				$this->delivery_addresses = array();

				$stmt_da = $this->pdo->PDOInstance->prepare("SELECT id_address FROM link_company_delivery_address WHERE id_company = :id");
				$stmt_da->bindParam(':id',$this->id);

				try {
					$stmt_da->execute();
				} catch(Exception $e){
					echo("Problem at ".$e->getLine()." from model company :".$e->getMessage());
				}

				$result_da = $stmt_da->fetchAll(PDO::FETCH_ASSOC);

				foreach($result_da as $da){
					$nda = new address($da["id_address"]);
					array_push($this->delivery_addresses,$nda);
				}


				return true;
			} else {
				return false;
			}
		}

		public function addToDatabase(){

			$stmt_getId = $this->pdo->PDOInstance->prepare("SELECT MAX(id) as lid FROM company");
			$stmt_getId->execute();
			$ctnid = $stmt_getId->fetch();
			$id = $ctnid["lid"] + 1;


			$stmt = $this->pdo->PDOInstance->prepare("INSERT INTO company(id,id_group_company,id_contact,id_billing_address,id_receiving_address,ust_id,name,nationality,countryWhoBill,description,normal_billing_period,phone_number) VALUES(:id,:id_group_company,:id_contact,:id_billing_address,:id_receiving_address,:ust_id,:name,:nationality,:countryWhoBill,:description,:normal_billing_period,:phone_number)");
			$stmt->bindParam(':id',$id);
			$stmt->bindParam(':id_group_company',$this->id_group_company);
			$stmt->bindParam(':id_contact',$this->id_contact);
			$stmt->bindParam(':id_billing_address',$this->id_billing_address);
			$stmt->bindParam(':id_receiving_address',$this->id_receiving_address);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':nationality',$this->nationality);
			$stmt->bindParam(':countryWhoBill',$this->countryWhoBill);
			$stmt->bindParam(':description',$this->description);
			$stmt->bindParam(':normal_billing_period',$this->normal_billing_period);
			$stmt->bindParam(':ust_id',$this->ust_id);
			$stmt->bindParam(':phone_number',$this->phone_number);
			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
		}

		public function setToDatabase(){
			$stmt_get = $this->pdo->PDOInstance->prepare("SELECT * FROM company WHERE id = :id");
			$stmt_get->bindParam(':id',$this->id);
			try {
				$stmt_get->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
			$actual_company = $stmt_get->fetch(PDO::FETCH_ASSOC);

			foreach($actual_company as $key => $value){
				if($actual_company[$key] != $this->$key){
					$stmt = $this->pdo->PDOInstance->prepare("UPDATE company SET $key = :value WHERE id = :id");
					$stmt->bindParam(":value",$this->$key);
					$stmt->bindParam(":id",$this->id);
					try {
						$stmt->execute();
					}
					catch(Exception $e){
						echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
					}
				}
			}
		}

		public function eraseOfDatabase(){
			$stmt = $this->pdo->PDOInstance->prepare('DELETE FROM company WHERE id = :id');
			$stmt->bindParam(':id',$this->id);

			try {
				$stmt->execute();
			} catch(Exception $e){
				echo('Problem at '.$e->getLine().' from model company :'.$e->getMessage());
			}
		}

		public function printText(){
			return $this->name;
		}

		public function printTR(){
			echo('<tr>');
				echo('<td>'.$this->name.'</td>');
				echo('<td>');
				echo($this->group_company->printText());
				echo('</td>');
				echo('<td>');
				echo($this->description);
				echo('</td>');
				echo('<td>');
				echo($this->contact->printLink());
				echo('</td>');
				echo('<td>'.$this->billing_address->printAddress().'</td>');
				echo('<td>'.$this->phone_number.'</td>');
				echo('<td><a href="../controller/viewCompany.php?id='.$this->id.'"><button class=""><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
			echo('</tr>');
		}

		public function getBillingAddress(){
			$tmp = new address($this->id_billing_address);
			$this->billing_address = $tmp;
		}

		public function printToModify($next){
			$extraction = new extraction();
			if($this->billing_address == NULL){
				$this->getBillingAddress();
			}
			$groups = $extraction->get("group_company");
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
				<div class="form-group">
					<label for="nationality">'.$this->tf->getText(50).'</label>
					<input name="nationality" type="text" class="form-control" value="'.$this->nationality.'">
				</div>
				<div class="form-group">
					<label for="countryWhoBill">Country who bill</label>
					<input name="countryWhoBill" type="text" class="form-control" value="'.$this->countryWhoBill.'">
				</div>
				<div class="form-group">
					<label for="description">'.$this->tf->getText(42).'</label>
					<input name="description" type="text" class="form-control" value="'.$this->description.'">
				</div>
				<div class="form-group">
					<label for="phone_number">'.$this->tf->getText(45).'</label>
					<input name="phone_number" type="text" class="form-control" value="'.$this->phone_number.'">
				</div>
				<div class="form-group">
					<label for="id_group_company">'.$this->tf->getText(85).'</label>
					<select name="id_group_company" class="form-control">
					');
						foreach($groups as $group){
							if($this->id_group_company == $group->getId()){
								echo('<option selected="selected" value="'.$group->getId().'">'.ucfirst($group->getDesignation()).'</option>');
							} else {
								echo('<option value="'.$group->getId().'">'.ucfirst($group->getDesignation()).'</option>');
							}
						}
					echo('
					</select>
				</div>
				<div class="form-group">
					<label for="ust_id">UST Id</label>
					<input name="ust_id" type="text" class="form-control" value="'.$this->ust_id.'">
				</div>
				<div class="form-group">
					<label for="normal_billing_period">'.$this->tf->getText(86).'</label>
					<input name="normal_billing_period" type="text" class="form-control" value="'.$this->normal_billing_period.'">
				</div>
			');
		}

		public function printToAdd($next){
			$extraction = new extraction();
			if($this->billing_address == NULL){
				$this->getBillingAddress();
			}
			$groups = $extraction->get("group_company");
			echo('
				<input type="hidden" name="id" value="'.$this->id.'">
				<input type="hidden" name="next" value="'.$next.'">
				<input type="hidden" name="class" value="company">
				<div class="form-group">
					<label for="name">'.$this->tf->getText(25).'</label>
					<input name="name" type="text" class="form-control" value="'.$this->name.'">
				</div>
				<div class="form-group">
					<label for="nationality">'.$this->tf->getText(50).'</label>
					<input name="nationality" type="text" class="form-control" value="'.$this->nationality.'">
				</div>
				<div class="form-group">
					<label for="countryWhoBill">Country who bill</label>
					<input name="countryWhoBill" type="text" class="form-control" value="'.$this->countryWhoBill.'">
				</div>
				<div class="form-group">
					<label for="description">'.$this->tf->getText(42).'</label>
					<input name="description" type="text" class="form-control" value="'.$this->description.'">
				</div>
				<div class="form-group">
					<label for="phone_number">'.$this->tf->getText(45).'</label>
					<input name="phone_number" type="text" class="form-control" value="'.$this->phone_number.'">
				</div>
				<div class="form-group">
					<label for="id_contact">'.$this->tf->getText(43). ' '.$this->tf->getText(69).'</label>
					<input type="text" id="contact" class="form-control" value="'.$this->contact->getName().' | '.$this->contact->getMail().' | '.$this->contact->getPhone_number().'">
					<input name="id_contact" type="hidden" class="form-control" value="'.$this->id_contact.'">
					<button id="getContact" alt="company" step="billing_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
				<div class="form-group">
					<label for="id_billing_address">'.$this->tf->getText(87). ' '.$this->tf->getText(69).'</label>
					<input type="text" id="billing_address" class="form-control" value="'.str_replace('<br/>',' ',$this->billing_address->printAddress()).'">
					<input name="id_billing_address" type="hidden" class="form-control" value="'.$this->id_billing_address.'">
					<button id="addAddress" alt="company" step="billing_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
					<button id="setAddress" alt="company" step="billing_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a>
					<button id="getAddress" alt="company" step="billing_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
				<div class="form-group">
					<label for="id_receiving_address">'.$this->tf->getText(88). ' '.$this->tf->getText(69).'</label>
					<input type="text" id="receiving_address" class="form-control" value="'.str_replace('<br/>',' ',$this->receiving_address->printAddress()).'">
					<input name="id_receiving_address" type="hidden" class="form-control" value="'.$this->id_receiving_address.'">
					<button id="addAddress" alt="company" step="receiving_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
					<button id="setAddress" alt="company" step="receiving_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a>
					<button id="getAddress" alt="company" step="receiving_address" rel="'.$this->id.'" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
				');
				echo('
				<div class="form-group">
					<label for="id_group_company">'.$this->tf->getText(85).'</label>
					<select name="id_group_company" class="form-control">
					');
						foreach($groups as $group){
							echo('hey');
							if($this->id_group_company == $group->getId()){
								echo('<option selected="selected" value="'.$group->getId().'">'.ucfirst($group->getDesignation()).'</option>');
							} else {
								echo('<option value="'.$group->getId().'">'.ucfirst($group->getDesignation()).'</option>');
							}
						}
					echo('
					</select>
				</div>
				<div class="form-group">
					<label for="ust_id">UST Id</label>
					<input name="ust_id" type="text" class="form-control" value="'.$this->ust_id.'">
				</div>
				<div class="form-group">
					<label for="normal_billing_period">'.$this->tf->getText(86).'</label>
					<input name="normal_billing_period" type="text" class="form-control" value="'.$this->normal_billing_period.'">
				</div>
			');
		}

		public function getId(){return $this->id;}
		public function getId_group_company(){return $this->id_group_company;}
		public function getId_contact(){return $this->id_contact;}
		public function getId_billing_address(){return $this->id_billing_address;}
		public function getId_receiving_address(){return $this->id_receiving_address;}
		public function getName(){return $this->name;}
		public function getNationality(){return $this->nationality;}
		public function getDescription(){return $this->description;}
		public function getNormal_billing_period(){return $this->normal_billing_period;}
		public function getPhone_number(){return $this->phone_number;}
		public function getUst_id(){return $this->ust_id;}
		public function getCountryWhoBill(){return $this->countryWhoBill;}

		public function getGroup_company(){return $this->group_company;}
		//public function getAddress(){return $this->address;}
		public function getContac(){return $this->contact;}
		public function getDelivery_addresses(){return $this->delivery_addresses;}
		public function getReceiving_address(){return $this->receiving_address;}

		public function getOrders(){return $this->orders;}
		public function getOrdersMonth(){return $this->ordersMonth;}
		public function getAlready_paid(){return $this->alreadyPaid;}
		public function getCa(){return $this->ca;}

		public function setId($new){$this->id = $new;}
		public function setId_group_company($new){$this->id_group_company = $new;}
		public function setId_contact($new){$this->id_contact = $new;}
		public function setId_billing_address($new){$this->id_billing_address = $new;}
		public function setId_receiving_address($new){$this->id_receiving_address = $new;}
		public function setName($new){$this->name = $new;}
		public function setNationality($new){$this->nationality = $new;}
		public function setDescription($new){$this->description = $new;}
		public function setNormal_billing_period($new){$this->normal_billing_period = $new;}
		public function setPhone_number($new){$this->phone_number = $new;}
		public function setUst_id($new){$this->ust_id = $new;}
		public function setCountryWhoBill($new){$this->countryWhoBill = $new;}

		public function setGroup_company($new){$this->group_company = $new;}
		public function setAddress($new){$this->address = $new;}
		public function setContac($new){$this->contact = $new;}
	}
?>