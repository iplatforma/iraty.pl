<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}

	public function pobierz($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('faq');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('kategoria','DESC');
		$this->db->order_by('order','DESC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('faq');
		if(!$this->admin()) { $this->db->where('status','1'); }
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('kategoria','DESC');
		$this->db->order_by('order','DESC');
		return $this->db->get();
	}
	
	public function pobierz_kategoria($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('faq');
		if($id) { $this->db->where('kategoria',$id); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('order','DESC');
		return $this->db->get();
	}

	public function kategoria($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('faq_kategoria');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('kategoria','DESC');
		$this->db->order_by('order','DESC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}

	public function kategorie_limit($limit) {
		$this->db->select("*");
		$this->db->from('faq_kategoria');
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('order','DESC');
		$this->db->order_by('kategoria','DESC');
		return $this->db->get();
	}
	
	public function pozostale($id) {
		$this->db->select("*");
		$this->db->from('faq');
		$this->db->where('id !=',$id);
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->limit(5);
		$this->db->order_by('rand()');
		return $this->db->get();
	}
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('faq',$data);
		} else {
			$this->db->insert('faq',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function usun($id) {
		if($this->db->delete('faq',array('id' => $id))) { return true; } else { return false; }
	}
	
	public function kategorie_zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('faq_kategoria',$data);
		} else {
			$this->db->insert('faq_kategoria',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function kategorie_usun($id) {
		if($this->db->delete('faq_kategoria',array('id' => $id))) { return true; } else { return false; }
	}
	
}
?>