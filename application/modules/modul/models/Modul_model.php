<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modul_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}
	
	public function pobierz($site=NULL,$id=NULL) {
		$this->db->select("*");
		$this->db->from('modul');
		if($site) { $this->db->where('site',$site); }
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($site,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('modul');
		$this->db->where('site',$site);
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('order','DESC');
		return $this->db->get();
	}
	
	public function parent($id) {
		$this->db->select("*");
		$this->db->from('modul');
		$this->db->where('parent',$id);
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function footer($id=NULL) {
		$this->db->select("*");
		$this->db->from('footer');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('modul',$data);
		} else {
			$this->db->insert('modul',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function usun($id) {
		if($this->db->delete('modul',array('id' => $id))) { return true; } else { return false; }
	}
	
	public function szukaj($data) {
		$this->db->insert('szukaj',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function fraza($url) {
		$this->db->select("*");
		$this->db->from('szukaj');
		$this->db->where('url',$url);
		$this->db->order_by('data','DESC');
		$this->db->limit(1);
		return $this->db->get()->row();
	}	

	public function wyniki($url,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('modul');
		$like = "
				((header LIKE '% ".$url." %' OR header LIKE '".$url."%' OR header LIKE '%".$url."')
				OR 
				(text LIKE '% ".$url." %' OR text LIKE '".$url."%' OR text LIKE '%".$url."'))
				";
		$this->db->where($like,NULL,FALSE);
		$this->db->where('status','1');
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(20,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}
			
}
?>