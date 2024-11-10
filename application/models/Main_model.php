<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function loguj($data) {
		$this->db->select('id');
		$this->db->from('admin');
		$this->db->where($data);
		$pobierz = $this->db->get();
		if($pobierz->num_rows() > 0) { return $pobierz->row()->id; } else { return false; }
	}
	
	public function klient_loguj($data) {
		$this->db->select('id');
		$this->db->from('klient');
		$this->db->where($data);
		$pobierz = $this->db->get();
		if($pobierz->num_rows() > 0) { return $pobierz->row()->id; } else { return false; }
	}
			
}
?>