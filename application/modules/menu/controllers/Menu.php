<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->data['site']['class'] = 'wide';
		$this->load->model('menu_model');
	}
	
	public function index() {
		if($this->uri->segment(2) !== 'menu') {
			redirect(site_url('zarzadzanie/menu'));
		}
		$this->admin();
		$this->total_rows = $this->pobierz_limit('all')->num_rows();
		$this->load->paginate();
		$this->data['paginate'] = $this->pagination->create_links();
		$this->data['pobierz'] = $this->pobierz_limit();
		$this->data['meta']['title'] = 'Zarządzanie menu';
		$this->load->view('menu/display',$this->data);
	}
	
	public function pobierz($id=NULL,$limit=NULL) {
		return $this->menu_model->pobierz($id,$limit);
	}
	
	public function pobierz_limit($limit=NULL) {
		return $this->menu_model->pobierz_limit($limit);
	}
	
	public function parent($id) {
		return $this->menu_model->parent($id);
	}
	
	public function pobierz_typ($typ) {
		return $this->menu_model->pobierz_typ($typ);
	}

	public function dodaj() {
		$this->admin();
		$this->data['meta']['title'] = 'Dodaj wpis';
		$this->load->view('menu/dodaj',$this->data);
	}
	
	public function edytuj() {
		$this->admin();
		$this->data['wpis'] = $this->pobierz($this->uri->segment(3));
		$this->data['meta']['title'] = 'Edytuj wybrany wpis';
		$this->load->view('menu/edytuj',$this->data);
	}

	public function zapisz() {
		$this->admin();
		$data = array(
			'nazwa' => $this->input->post('nazwa'),
			'typ' => $this->input->post('typ'),
			'parent' => $this->input->post('parent')?$this->input->post('parent'):NULL,
			'link_type' => $this->input->post('link_type'),
			'url' => ($this->input->post('link_type')=='lz'?($this->input->post('url')?$this->input->post('url'):NULL):NULL),
			'site' => ($this->input->post('link_type')=='lp'?($this->input->post('site')?$this->input->post('site'):NULL):NULL)
		);
		if($this->input->post('wpis')) {
			$id = $this->input->post('wpis'); 
		} else { 
			$id = NULL;
		}
		if($this->menu_model->zapisz($data,$id)) {
			if($id) {
				$this->session->set_userdata('notice','Wpis został zaktualizowany.');
			} else {
				$this->session->set_userdata('notice','Wpis został dodany.');
			}
			redirect(site_url('zarzadzanie/menu')); 
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
			if($this->menu_model->zapisz($data,$id)) {
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
		if($this->menu_model->zapisz($data,$id)) {
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
		$title = modules::run('menu/pobierz',$id)->title;
		if($this->menu_model->usun($id)) {
			$this->session->set_userdata('notice','Wpis został usunięty');
			redirect(site_url('zarzadzanie/menu'));
		} else {
			$this->session->set_userdata('error','Wpis nie został usunięty');
			redirect($this->agent->referrer());
		}
	}

}
