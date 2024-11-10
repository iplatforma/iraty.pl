<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podstrona_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}
	
	public function menu() {
		$this->db->select("*");
		$this->db->from('podstrona');
		$this->db->where('menu','1');
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}

	public function url($url) {
		$this->db->select("*");
		$this->db->from('podstrona');
		$this->db->where('url',$url);
		$this->db->order_by('id','ASC');
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	public function pobierz($id=NULL) {
		$this->db->select("*");
		$this->db->from('podstrona');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		$this->db->order_by('id','ASC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('podstrona');
		$this->db->where('parent',NULL);
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('menu','DESC');
		$this->db->order_by('footer','ASC');
		$this->db->order_by('order','DESC');
		return $this->db->get();
	}
	
	public function parent($id) {
		$this->db->select("*");
		$this->db->from('podstrona');
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
	
	public function footerview($id=NULL) {
		$this->db->select("*");
		$this->db->from('podstrona');
		if($id) { $this->db->where('footer',$id); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function menuview($id=NULL) {
		$this->db->select("*");
		$this->db->from('podstrona');
		if($id) { $this->db->where('parent',$id); } else { $this->db->where('menu', '1'); $this->db->where('parent',NULL); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function wyswietl($id) {
		$this->db->select("*");
		$this->db->from('modul');
		$this->db->where('site',$id);
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->order_by('order','DESC');
		$this->db->order_by('id','ASC');
		return $this->db->get();
	}
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('podstrona',$data);
		} else {
			$this->db->insert('podstrona',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function usun($id) {
		if($this->db->delete('podstrona',array('id' => $id))) { return true; } else { return false; }
	}
	
	public function wyniki($url,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('podstrona');
		$like = "
				(header LIKE '% ".$url." %' OR header LIKE '".$url."%' OR header LIKE '%".$url."')
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