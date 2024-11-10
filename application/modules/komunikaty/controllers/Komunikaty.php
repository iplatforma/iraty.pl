<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komunikaty extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('komunikaty_model');
	}
	
	public function index() {
		if($this->uri->segment(2) !== 'komunikaty') {
			redirect(site_url('zarzadzanie/komunikaty'));
		}
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie wpisami';
		$this->load->view('komunikaty/display',$this->data);
	}
	
	public function pobierz($id=NULL,$limit=NULL) {
		return $this->komunikaty_model->pobierz($id,$limit);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->komunikaty_model->pobierz_limit($limit);
	}
	
	public function wyswietl() {
		return $this->komunikaty_model->wyswietl();
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'title' => $this->input->post('title'),
			'link' => $this->input->post('link')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->komunikaty_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('zarzadzanie/komunikaty')); 
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
		$this->komunikaty_model->status();
		if($this->komunikaty_model->zapisz($data,$id)) {
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
		$title = modules::run('komunikaty/pobierz',$id)->title;
		if($this->komunikaty_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect(site_url('zarzadzanie/komunikaty'));
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}

}
