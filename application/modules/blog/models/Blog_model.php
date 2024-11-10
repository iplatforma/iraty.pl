<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function admin() {
		if($this->session->userdata('admin') == 'abcdef') { return true; } else { return false; }
	}

	public function pobierz($id=NULL,$limit=NULL) {
		$this->db->select("*");
		$this->db->from('blog');
		if($id) { $this->db->where('id',$id); $this->db->limit(1); }
		if(!$this->admin()) { $this->db->where('status','1'); }
		if($limit) { $this->db->limit($limit); }
		$this->db->order_by('date','DESC');
		if($id) {
			return $this->db->get()->row();
		} else {
			return $this->db->get();
		}
	}
	
	public function pobierz_limit($limit) {
		$this->db->select("*");
		$this->db->from('blog');
		if(!$this->admin()) { $this->db->where('status','1'); }
		if(!$limit) { 
			$start = $this->uri->segment(3);
			$this->db->limit(10,$start);
		} else {
			$this->db->limit($limit);
		}
		$this->db->order_by('date','DESC');
		return $this->db->get();
	}
	
	public function pozostale($id) {
		$this->db->select("*");
		$this->db->from('blog');
		$this->db->where('id !=',$id);
		if(!$this->admin()) { $this->db->where('status','1'); }
		$this->db->limit(5);
		$this->db->order_by('rand()');
		return $this->db->get();
	}
	
	public function zapisz($data,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('blog',$data);
		} else {
			$this->db->insert('blog',$data);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
		
	public function usun($id) {
		if($this->db->delete('blog',array('id' => $id))) { return true; } else { return false; }
	}
		
	public function glowne_dodaj($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('blog',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function glowne_usun($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('blog',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
}
?>