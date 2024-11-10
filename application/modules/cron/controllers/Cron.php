<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		modules::run('xml/import');
	}

}
