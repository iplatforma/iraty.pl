<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}

	public function pobierz($id=NULL) {
		$this->db->select("*");
		$this->db->from('admin');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
//		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_historia($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('dziennik');
		if($id) { $this->db->where('administrator',$id); }
		if(!$limit) { 
			$start = $this->uri->segment(4);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('data','DESC');
		return $this->db->get();
	}	
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('admin');
//		if(!$this->admin()) { $this->db->where('status','1'); }
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}	
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('admin',$data);
		} else {
			$this->db->insert('admin',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function usun($id) {
		if($this->db->delete('admin',array('id' => $id))) { return true; } else { return false; }
	}
			
}
?>