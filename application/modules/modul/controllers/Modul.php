<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modul extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('modul_model');
	}
	
	public function index() {
		$this->admin();
		$site = $this->uri->segment(2);
		$this->total_rows = $this->pobierz_limit($site,'all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit($site);
		$this->data['meta']['title'] = 'Zarządzanie modułami';
		$this->load->view('modul/display',$this->data);
	}
	
	public function pobierz($site=NULL,$id=NULL) {
		return $this->modul_model->pobierz($site,$id);
	}
	
	public function pobierz_limit($site,$limit=NULL) {
		return $this->modul_model->pobierz_limit($site,$limit);
	}
	
	public function parent($id) {
		return $this->modul_model->parent($id);
	}
	
	public function footer($id=NULL) {
		return $this->modul_model->footer($id);
	}
	
	public function dodaj() {
		$this->admin();
		$this->data['meta']['title'] = 'Dodaj moduł';
		$this->load->view('modul/dodaj',$this->data);
	}
	
	public function edytuj() {
		$this->admin();
		$this->data['wpis'] = $this->pobierz(NULL,$this->uri->rsegment(3));
		$this->data['meta']['title'] = 'Edytuj treść modułu';
		$this->load->view('modul/edytuj',$this->data);
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'header' => ($this->input->post('typ')=='package'?('Pakiet: '.modules::run('konfigurator/pobierz',$this->input->post('package'))->kategoria):$this->input->post('header')),
			'text' => $this->input->post('tresc'),
			'background_color' => $this->input->post('background_color')?$this->input->post('background_color'):NULL,
			'package' => $this->input->post('package')?$this->input->post('package'):NULL,
			'type' => $this->input->post('typ'),
			'lat_lng' => $this->input->post('lat_lng')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
			$data['site'] = $this->input->post('site');
		}
		if($this->modul_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('modul/'.$this->input->post('site'))); 
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}
	
	
	public function kolejnosc() {
		$this->admin();
		$data = array(
			'order' => $this->input->post('order')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
			if($this->modul_model->zapisz($data,$id)) {
				$this->session->set_userdata('notice','Priorytet został zaktualizowany.');
				redirect($this->agent->referrer());
			} else { 
				$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
				redirect($this->agent->referrer());
			}
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}
	
	public function status() {
		$this->admin();
		$data = array(
			'status' => $this->uri->segment(4)
		);
		$id = $this->uri->segment(3); 
		if($this->modul_model->zapisz($data,$id)) {
			$this->session->set_userdata('notice','Status został zmieniony.');
			redirect($this->agent->referrer());
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}
	
	public function szukaj($keywords) {
		$data = array(
			'fraza' => $keywords,
			'url' => $this->load->url($keywords),
			'data' => unix_to_human(time(),TRUE, 'eu')
		);
		if($this->modul_model->szukaj($data)) {
			return $data['url'];
		}
	}
	
	public function fraza($url) {
		return $this->modul_model->fraza($url);
	}
	
	public function wyniki($url,$limit=NULL) {
		return $this->modul_model->wyniki($url,$limit);
	}
	
	public function do_upload($nazwa) {
		$config['upload_path'] = './assets/img/background/';
		$config['allowed_types'] = '*';
		$config['file_name'] = $nazwa;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('zdjecie')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function tlo_dodaj() {
		$this->admin();
		$this->load->library('phpthumb_lib');
		$id = $this->input->post('wpis');
		$file_name = url_title(convert_accented_characters(($this->load->select('modul','header',$id).' '.substr(md5(time()),0,6)),'-',TRUE));
		if(!$_FILES['zdjecie']['name']) {
			if($this->input->post('parallax') == '1') { $data['parallax'] = '1'; } else { $data['parallax'] = '0'; }
			$result = $this->modul_model->zapisz($data,$id);
			if($result) {
				$this->session->set_userdata('notice','Efekt został zmieniony.');
			} else { 
				$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			}
		} else {
			if($this->do_upload($file_name)) {
				$upload_data = $this->upload->data(); 
				$file_name = $upload_data['file_name'];
				$data = array('background' => $file_name);
				$semi = Phpthumb_lib::create('assets/img/background/'.$file_name); $semi->resize(2000,1100); $semi ->save('assets/img/background/'.$file_name);
				if($this->input->post('parallax') == '1') { $data['parallax'] = '1'; }
				$result = $this->modul_model->zapisz($data,$id);
				if($result) {
					$this->session->set_userdata('notice','Tło został zapisane.');
				} else { 
					$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
				}
			} else {
				$this->session->set_userdata('error',$this->upload->display_errors());
			}
		}
		redirect($this->agent->referrer()); 
	}

	public function tlo_usun() {
		$this->admin();
		$data = array(
			'background' => NULL,
			'parallax' => '0'
		);
		$id = $this->uri->segment(4);
		if($this->modul_model->zapisz($data,$id)) {
			$this->session->set_userdata('notice','Tło zostało usunięte.');
			redirect($this->agent->referrer());
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}		
	
	public function usun() {
		$this->admin();
		$id = $this->uri->segment(3);
		if($this->modul_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect($this->agent->referrer());
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}

}
