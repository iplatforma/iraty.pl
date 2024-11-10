<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('blog_model');
	}
	
	public function index() {
		if($this->uri->segment(2) !== 'blog') {
			redirect(site_url('zarzadzanie/blog'));
		}
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie wpisami';
		$this->load->view('blog/display',$this->data);
	}
	
	public function pobierz($id=NULL,$limit=NULL) {
		return $this->blog_model->pobierz($id,$limit);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->blog_model->pobierz_limit($limit);
	}
	
	public function pozostale($id) {
		return $this->blog_model->pozostale($id);
	}

	public function dodaj() {
		$this->admin();
		$this->data['meta']['title'] = 'Dodaj wpis';
		$this->load->view('blog/dodaj',$this->data);
	}
	
	public function edytuj() {
		$this->admin();
		$this->data['wpis'] = $this->pobierz($this->uri->segment(3));
		$this->data['meta']['title'] = 'Edytuj wybrany wpis';
		$this->load->view('blog/edytuj',$this->data);
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'title' => $this->input->post('title'),
			'tresc' => $this->input->post('tresc')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
			$data['date'] = unix_to_human(time(),TRUE, 'eu');
		}
		if($this->blog_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('zarzadzanie/blog')); 
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}
	
	public function kolejnosc() {
		$this->admin();
		$data = array(
			'date' => $this->input->post('date')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
			if($this->blog_model->zapisz($data,$id)) {
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
		if($this->blog_model->zapisz($data,$id)) {
			$this->session->set_userdata('notice','Status został zmieniony.');
			redirect($this->agent->referrer());
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}		
		
	public function usun() {
		$this->admin();
		$id = $this->uri->segment(3);
		$title = modules::run('blog/pobierz',$id)->title;
		if($this->blog_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect(site_url('zarzadzanie/blog'));
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}
	
	public function do_upload($nazwa) {
		$config['upload_path'] = './assets/img/blog/';
		$config['allowed_types'] = '*';
		$config['file_name'] = $nazwa;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('zdjecie')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function glowne_dodaj() {
		$this->admin();
		$this->load->library('phpthumb_lib');
		$id = $this->input->post('wpis');
		$typ = $this->input->post('typ');
		$file_name = url_title(convert_accented_characters(($id.' '.$this->load->select('blog','title',$id).' '.substr(md5(time()),0,6)),'-',TRUE));
		if($this->do_upload($file_name)) {
			$upload_data = $this->upload->data(); 
			$file_name = $upload_data['file_name'];
			$data = array($typ => $file_name);
			$thumb = Phpthumb_lib::create('assets/img/blog/'.$file_name); $thumb->resize(1000); $thumb ->save('assets/img/blog/semi/'.$file_name);
			$thumb = Phpthumb_lib::create('assets/img/blog/'.$file_name); $thumb->resize(600); $thumb->cropFromCenter(520,260); $thumb ->save('assets/img/blog/thumb/'.$file_name);
			if($this->blog_model->zapisz($data,$id)) {
				$this->session->set_userdata('notice','Zdjęcie główne zostało ustawione.');
			} else { 
				$this->session->set_userdata('error','Wystąpił błąd, zdjęcie nie zostało ustawione.');
			}
		} else {
			$this->session->set_userdata('error',$this->upload->display_errors());
		}
		redirect($this->agent->referrer()); 
	}
	
	public function glowne_usun() {
		$id = $this->uri->segment(4);
		$typ = $this->uri->segment(2);
		$data = array($typ => NULL);
		if($this->blog_model->zapisz($data,$id)) {
			$this->session->set_userdata('notice','Zdjęcie główne zostało usunięte.');
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, zdjęcie nie zostało usunięte.');
		}
		redirect($this->agent->referrer());
	}

}
