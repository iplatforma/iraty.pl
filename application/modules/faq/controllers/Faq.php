<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('faq_model');
	}
	
	public function index() {
		if($this->uri->segment(2) !== 'faq') {
			redirect(site_url('zarzadzanie/faq'));
		}
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie wpisami';
		$this->load->view('faq/display',$this->data);
	}
	
	public function kategorie() {
		$this->admin();
		$this->total_rows = $this->kategorie_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->kategorie_limit();
		$this->data['meta']['title'] = 'Zarządzanie wpisami';
		$this->load->view('faq/kategorie',$this->data);
	}
	
	public function pobierz($id=NULL,$limit=NULL) {
		return $this->faq_model->pobierz($id,$limit);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->faq_model->pobierz_limit($limit);
	}
	
	public function pobierz_kategoria($id=NULL,$limit=NULL) {
		return $this->faq_model->pobierz_kategoria($id,$limit);
	}

	public function kategoria($id=NULL,$limit=NULL) {
		return $this->faq_model->kategoria($id,$limit);
	}
	
	public function kategorie_limit($limit=NULL) {
		return $this->faq_model->kategorie_limit($limit);
	}
	
	public function pozostale($id) {
		return $this->faq_model->pozostale($id);
	}

	public function dodaj() {
		$this->admin();
		$this->data['meta']['title'] = 'Dodaj wpis';
		$this->load->view('faq/dodaj',$this->data);
	}
	
	public function edytuj() {
		$this->admin();
		$this->data['wpis'] = $this->pobierz($this->uri->segment(3));
		$this->data['meta']['title'] = 'Edytuj wybrany wpis';
		$this->load->view('faq/edytuj',$this->data);
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'title' => $this->input->post('title'),
			'kategoria' => $this->input->post('kategoria'),
			'tresc' => $this->input->post('tresc')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->faq_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('zarzadzanie/faq')); 
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
			if($this->faq_model->zapisz($data,$id)) {
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
		if($this->faq_model->zapisz($data,$id)) {
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
		$title = modules::run('faq/pobierz',$id)->title;
		if($this->faq_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect(site_url('zarzadzanie/faq'));
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}

	public function kategorie_zapisz() {
		$this->admin();
		$data = array(
			'kategoria' => $this->input->post('kategoria')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->faq_model->kategorie_zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('faq/kategorie')); 
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}

}
