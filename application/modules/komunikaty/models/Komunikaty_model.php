<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komunikaty_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}

	public function pobierz($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('komunikaty');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('id','DESC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('komunikaty');
		if(!$this->admin()) { $this->db->where('status','1'); }
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}
	
	public function wyswietl() {
		$this->db->select("*");
		$this->db->from('komunikaty');
		$this->db->where('status','1');
		$this->db->limit(1);
		return $this->db->get();
	}		
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('komunikaty',$data);
		} else {
			$this->db->insert('komunikaty',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function status() {
		$this->db->update('komunikaty',array('status' => '0'));
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function usun($id) {
		if($this->db->delete('komunikaty',array('id' => $id))) { return true; } else { return false; }
	}
	
}
?>