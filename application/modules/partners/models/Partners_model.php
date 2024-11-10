<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners_model extends CI_Model {
	
	public function _check_login($login,$haslo) {
		$this->db->select("*");
		$this->db->from('partner');
		$this->db->where('id',$login);
		$this->db->where('haslo',$haslo);
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		//return $this->db->get()->row()->id;
		return $this->db->get();
	}
	
	public function _get_partnerzy($limit=NULL) {
		$this->db->select("*",false);
		$this->db->from('partner');
		if($this->session->userdata('filter_partner_nazwa')) { $this->db->like('nazwa', $this->session->userdata('filter_partner_nazwa')); }
		if($this->session->userdata('filter_partner_nip')) { $this->db->like('nip', $this->session->userdata('filter_partner_nip')); }
		if($this->session->userdata('filter_partner_telefon')) { $this->db->like('telefon', $this->session->userdata('filter_partner_telefon')); }
		if($this->session->userdata('filter_partner_email')) { $this->db->like('email', $this->session->userdata('filter_partner_email')); }
		if($this->session->userdata('filter_partner_opiekun')) { $this->db->where('opiekun', $this->session->userdata('filter_partner_opiekun')); }
		if($this->session->userdata('filter_partner_status')) { $this->db->where('status', $this->session->userdata('filter_partner_status')); }
		$this->db->order_by('id','DESC');
		if(!$limit) { $start = $this->uri->segment(3); $this->db->limit(20,$start); }
		return $this->db->get();
	}
	
	public function _get_partner($id) {
		$this->db->select("*",false);
		$this->db->from('partner');
		$this->db->where('id',$id);
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$pobierz = $query->result();
		return $pobierz[0];
	}
	
	public function get_dane($id) {
		$this->db->select("*",false);
		$this->db->from('partner');
		$this->db->where('id',$id);
		$this->db->where('status','2');
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$pobierz = $query->result();
			return $pobierz[0];
		} else {
			return NULL;
		}
	}
	
	public function _get_partner_by($rekord,$id) {
		$this->db->select($rekord);
		$this->db->from('partner');
		$this->db->where('id',$id);
		return $this->db->get()->row()->$rekord;
	}
	
	public function _get_partnerzy_from_xml() {
		$this->load->helper('xml');
		$this->load->library('simplexml');
		$xml = file_get_contents(asset_url().'/files/partners.xml');
		$xmlData = $this->simplexml->xml_parse($xml);
		return $xmlData;
	}
	
	public function _set_status($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('partner',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function _set_oprocentowanie($data,$id) {
		$this->db->where('partner',$id);
		$this->db->update('prowizja',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function sprawdz_haslo($data) {
		$this->db->select('id');
		$this->db->from('partner');
		$this->db->where('haslo',$data['haslo']);
		$this->db->where('id',$this->session->userdata('partner'));
		if($this->db->get()->num_rows() > 0) { return true; } else {return false; }
	}
	
	public function zmien_haslo($data) {
		$this->db->where('id',$this->session->userdata('partner'));
		$this->db->update('partner',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function zmien_partner($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('partner',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function zapisz($dane,$id=NULL) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('partner',$dane);			
		} else {
			$this->db->insert('partner',$dane);
			$id = $this->db->insert_id();
			$this->db->insert('prowizja',array('partner'=>$id, 'oprocentowanie'=>$this->load->oprocentowanie(), 'admin'=>$this->session->userdata('admin_id'), 'data'=>unix_to_human(time(),TRUE, 'eu')));
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function _xml_partner() {
		$string = '<?xml version="1.0" encoding="UTF-8"?>
		<partners>
		</partners>';
		$xml = new SimpleXMLElement($string);
		$this->db->select("id,nazwa",false);
		$this->db->from('partner');
		$this->db->order_by('nazwa','ASC');
		$partnerzy = $this->db->get();
		foreach($partnerzy->result() as $partner) {
		$group = $xml -> addChild('partner');
		$id = $group -> addChild('id',$partner->id);
		$nazwa = $group -> addChild('nazwa',html_escape($partner->nazwa));
		}
		return $xml->asXML('assets/files/partners.xml');
	}

	public function _delete_partner($id) { /*usuwa wniosek */
		if($this->db->delete('partner',array('id' => $id))) { return true; } else { return false; }
	}

	/* DOTYCZY STREFY PUBLICZNEJ */
	public function hold_post() {
		$data['firma'] = $this->input->post('firma',TRUE);
		$data['nazwisko'] = $this->input->post('nazwisko',TRUE);
		$data['www'] = $this->input->post('www',TRUE);
		$data['email'] = $this->input->post('email',TRUE);
		$data['telefon'] = $this->input->post('telefon',TRUE);
		$data['tresc'] = $this->input->post('tresc',TRUE);
		return $data;
	}
	
	public function send_offer($data) {
		$config = array(
			'mailtype' => 'html',
			'protocol' => 'smtp',
			'charset' => 'utf-8',
			'priority' => 3,
			'smtp_crypto' => 'ssl',
			'smtp_host' => 'serwer1450004.home.pl',
			'smtp_port' => 465,
			'smtp_user' => 'powiadomienia@solven.pl',
			'smtp_pass' => 'bIRa0dY&f*Mi'
		);
		$this->load->library('email',$config);
		$body = '
		<p><strong>Firma</strong>: '.$data['firma'].'</p>
		<p><strong>Nazwisko</strong>: '.$data['nazwisko'].'</p>
		<p><strong>Adres strony www</strong>: '.$data['www'].'</p>
		';
		$body .= '<div style="width:800px;height:300px;border:1px solid #F00;background-color:#f0f0f0;margin:0 auto;display:table;"><p><strong>Tymczasowa</strong> treść <em>maila</em>...</p></div>';
		$this->email->from('powiadomienia@solven.pl', 'Biuro Solven');
		$this->email->to('biuro@solven.pl');
//		$this->email->cc('gomes2001@gmail.com');
//		$this->email->bcc('gomes2001@gmail.com');	
		$this->email->subject('Zgłoszenie współpracy partnerskiej');
		$this->email->message($body);
		$this->email->send();
	}

	
}
?>