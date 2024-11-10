<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('administrator_model');
	}
	
	public function index() {
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie administratorami';
		$this->load->view('administrator/display',$this->data);
	}
	
	public function pobierz($id=NULL) {
		return $this->administrator_model->pobierz($id);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->administrator_model->pobierz_limit($limit);
	}
	
	public function pobierz_historia($id=NULL,$limit=NULL) {
		return $this->administrator_model->pobierz_historia($id,$limit);
	}
		
	public function historia() {
		$this->admin();
		$id = $this->uri->segment(3);
		$this->total_rows = $this->pobierz_historia($id,'all')->num_rows();
		$this->load->paginate_4();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_historia($id);
		$this->data['meta']['title'] = 'Historia działań administratora';
		$this->load->view('administrator/historia',$this->data);
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'login' => $this->input->post('login'),
			'haslo' => sha1($this->input->post('haslo').MY_HASH),
			'email' => $this->input->post('email'),
			'nazwisko' => $this->input->post('dane')
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->administrator_model->zapisz($data,$id)) {
			if($id) { $this->session->set_userdata('notice','Wpis został zaktualizowany.'); } else { $this->session->set_userdata('notice','Konto zostało utworzone.'); }
			redirect(site_url('zarzadzanie/administratorzy')); 
		} else { 
			$this->session->set_userdata('error','Wystąpił błąd, spróbuj ponownie.');
			redirect($this->agent->referrer());
		}
	}
	
	public function haslo() {
		$data = array('haslo' => sha1($this->input->post('haslo').MY_HASH));
		$id = $this->input->post('wpis');

		$this->form_validation->set_rules('haslo', 'Hasło', 'required');
		$this->form_validation->set_rules('phaslo', 'Ponownie wpisane hasło', 'required|matches[haslo]');

		if ($this->form_validation->run() == FALSE) {
			$errors = form_error('haslo').form_error('phaslo');
			$this->session->set_userdata('error', $errors);
		} else {
			if($this->administrator_model->zapisz($data,$id)) {
				$this->session->set_userdata('notice','Hasło zostało zmienione.');
			} else {
				$this->session->set_userdata('error','Hasło nie zostało zmienione.');
			}
		}
		redirect($this->agent->referrer());
	}
		
	public function usun() {
		$this->admin();
		$id = $this->uri->segment(3);
		if($this->administrator_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect(site_url('zarzadzanie/administratorzy'));
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}

}
