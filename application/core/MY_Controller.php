<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {
	
	public $data = array();
	
	function __construct() {
		parent::__construct();
			
		if($this->session->userdata('admin') == 'abcdef') {
			$this->admin = true;
		} else { $this->admin = false; }
        $this->data['footer'] = NULL;
        $this->data['partner'] = NULL;
        $this->data['partner_id'] = NULL;
		$this->data['site']['class'] = NULL;
		$this->data['site']['menu'] = 'subsite';
		$this->data['meta']['title'] = 'iRaty.pl';
		$this->data['meta']['keywords'] = '';
		$this->data['meta']['description'] = '';
	}
	
    protected function json($data)
    {
        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($data));
    }
	
	function admin() {
		if(!$this->admin) {
			$this->session->set_userdata('warning','Musisz się zalogować do panelu administracyjnego.'); redirect(site_url('admin'));
		} else { return true; }
	}
	
}
?>