<?php

	class error {

		private $message;

		public function __construct($message){
			$this->message = $message;
		}

		public function print_error(){
			echo('<div class="alert alert-danger alert-dismissible" role="alert">
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
				'.$this->message.'
			</div>');
		}		
	}

?>