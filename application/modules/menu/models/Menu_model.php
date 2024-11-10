<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}

	public function pobierz($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('menu');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('typ','ASC');
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where('parent IS NULL');
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('typ','ASC');
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function parent($id) {
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where('parent',$id);
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('typ','ASC');
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function pobierz_typ($typ) {
		$this->db->select("*");
		$this->db->from('menu');
		if($typ) { $this->db->where('typ',$typ);  }
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->where('parent IS NULL');
		$this->db->order_by('typ','ASC');
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('menu',$data);
		} else {
			$this->db->insert('menu',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function usun($id) {
		if($this->db->delete('menu',array('id' => $id))) { return true; } else { return false; }
	}
		
	public function glowne_dodaj($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('menu',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function glowne_usun($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('menu',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
}
?>