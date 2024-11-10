<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('email_model');
	}
	
	public function index($data) {
		return $this->email_model->wyslij($data);
	}

	public function wniosek_uslugowy($data) {
		return $this->email_model->wniosek_uslugowy($data);
	}

	public function kontakt($data) {
		return $this->email_model->kontakt($data);
	}

}
