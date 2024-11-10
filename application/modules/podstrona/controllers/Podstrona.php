<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podstrona extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('podstrona_model');
	}
	
	public function index() {
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie podstronami';
		$this->load->view('podstrona/display',$this->data);
	}

	public function menu() {
		return $this->podstrona_model->menu();
	}
	
	public function url($url) {
		return $this->podstrona_model->url($url);
	}
	
	public function pobierz($id=NULL) {
		return $this->podstrona_model->pobierz($id);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->podstrona_model->pobierz_limit($limit);
	}
	
	public function parent($id) {
		return $this->podstrona_model->parent($id);
	}
	
	public function footer($id=NULL) {
		return $this->podstrona_model->footer($id);
	}
	
	public function footerview($id=NULL) {
		return $this->podstrona_model->footerview($id);
	}
	
	public function menuview($id=NULL) {
		return $this->podstrona_model->menuview($id);
	}
	
	public function wyswietl($id) {
		return $this->podstrona_model->wyswietl($id);
	}
	
	public function dodaj() {
		$this->admin();
		if($this->uri->segment(3)) {
			$this->data['meta']['title'] = 'Dodaj podstronę';
			$this->load->view('podstrona/dodaj',$this->data);
		} else {
			$this->data['meta']['title'] = 'Dodaj stronę';
			$this->load->view('podstrona/dodaj-strona',$this->data);
		}
	}
	
	public function edytuj() {
		$this->admin();
		$this->data['wpis'] = $this->pobierz($this->uri->segment(3));
		if($this->data['wpis']->parent == NULL) {
			$this->data['meta']['title'] = 'Edytuj treść strony';
			$this->load->view('podstrona/edytuj-strona',$this->data);
		} else {
			$this->data['meta']['title'] = 'Edytuj treść podstrony';
			$this->load->view('podstrona/edytuj',$this->data);
		}
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'header' => $this->input->post('header'),
			'url' => $this->load->url($this->input->post('header')),
			'menu' => ($this->input->post('menu')?$this->input->post('menu'):'0'),
			'footer' => ($this->input->post('footer')?$this->input->post('footer'):NULL),
			'parent' => ($this->input->post('parent')?$this->input->post('parent'):NULL),
			'title' => $this->input->post('title'),
			'keywords' => $this->input->post('keywords'),
			'description' => $this->input->post('description')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->podstrona_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('zarzadzanie/podstrona')); 
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
			if($this->podstrona_model->zapisz($data,$id)) {
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
		if($this->podstrona_model->zapisz($data,$id)) {
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
		if($this->podstrona_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect($this->agent->referrer());
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}
	
	public function wyniki($url,$limit=NULL) {
		return $this->podstrona_model->wyniki($url,$limit);
	}

}
