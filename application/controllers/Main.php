<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
	
    public function __construct()
    {
        parent::__construct();
	}
	
	public function popup_hide() {
		$cookie = array(
			'name' => 'popup',
			'value' => '1',
			'expire' => 2592000
		);
		set_cookie($cookie);
	}
	
	public function index()	{
		$this->data['site']['menu'] = NULL;
		$this->data['site']['class'] = 'main';
		$this->data['dane'] = modules::run('podstrona/pobierz',1);
		$this->data['moduly'] = modules::run('podstrona/wyswietl',1);
		$this->data['meta']['title'] = $this->data['dane']->title?$this->data['dane']->title:$this->data['dane']->header.' - '.$this->data['meta']['title'];
		$this->data['meta']['description'] = $this->data['dane']->description?$this->data['dane']->description:$this->data['meta']['description'];
		$this->data['meta']['keywords'] = $this->data['dane']->keywords?$this->data['dane']->keywords:$this->data['meta']['keywords'];
		$this->load->view('default',$this->data);
	}
	
    public function iframe()
    {
        $this->data['meta']['title'] = 'Kalkulacja raty - iRaty';
        $this->data['meta']['description'] = '';
        $this->data['canonical'] = true;
        if ($this->uri->segment(2)) {
            $this->data['partner'] = modules::run('partners/finansowa_dane', $this->uri->segment(2));
            if (!$this->data['partner']) {
                redirect('kalkulator');
            }
        }
        $this->data['footer'] = 'grey';
        $this->load->view('iframe', $this->data);
    }
	
    public function kalkulator_move()
    {
        if ($this->uri->rsegment(4)) {
            redirect('kalkulator/' . $this->uri->rsegment(3) . '/' . $this->uri->rsegment(4), 'location', 301);
        }
        redirect('kalkulator/' . $this->uri->rsegment(3), 'location', 301);
    }
	
    public function wniosek() {
        $partner_id = (int)$this->input->post('partner');
		$this->session->set_userdata('partner',$partner_id);
        $ilosc_rat = (int)$this->input->post('ilosc_rat');
        $integracja = $this->input->post('link');

        $this->data['produkty'] = [[]];

        /*jeszcze z samego wniosku  /czyli krok wcześniej/redirect location 301*/
        $this->session->unset_userdata('wniosek');
        $this->data['canonical'] = true;
        $this->data['meta']['title'] = 'Składasz wniosek - krok 1 - parametry kredytu';
        //$this->data['meta']['description'] = '';
		//$this->session->unset_userdata('info');
        $this->data['formularz']['partner'] = $partner_id;
        $this->data['formularz']['kwota'] = $this->input->post('kwota');
        $this->data['formularz']['wysylka'] = $this->input->post('wysylka');
        $this->data['formularz']['oprocentowanie_zero'] = $this->input->post('oprocentowanie_zero');
        $this->data['formularz']['oprocentowanie'] = $this->input->post('oprocentowanie');
        $this->data['formularz']['raty_oze'] = $this->input->post('raty_oze');
        $this->data['formularz']['ilosc_rat'] = $ilosc_rat;
        $this->data['formularz']['ubezpieczenie'] = $this->input->post('ubezpieczenie');
        $this->data['formularz']['rata'] = $this->input->post('rata');
        $this->data['formularz']['rodzaj'] = $this->input->post('rodzaj');
        $this->data['formularz']['info'] = $this->input->post('info');
		$this->data['formularz']['test'] = $this->input->post('test');
		$this->data['integracja'] = false;
		if($this->input->post('info')) { $this->data['integracja'] = true; }
		if($this->session->userdata('info')) { $this->data['formularz']['info'] = $this->session->userdata('info'); $this->data['integracja'] = false; }
        $this->data['formularz']['sklep'] = $this->input->post('sklep');
        $this->data['formularz']['backurl'] = ($this->input->post('backurl')?$this->input->post('backurl'):NULL);

        if (!empty($partner_id)) {
            $this->data['partner'] = modules::run('partners/finansowa_dane', $partner_id);
            $this->data['partner']['oprocentowanie_raty'] = unserialize($this->data['partner']['oprocentowanie_raty']);
        }
		
		$this->data['produkt'] = array();
		if($integracja and sizeof($integracja) > 0) {
			if(($this->input->post('nazwa') and sizeof($this->input->post('nazwa')) > 0) or ($this->input->post('link') and sizeof($this->input->post('link')) > 0)) {
				if($this->input->post('nazwa')) {
					$produkt = $this->input->post('nazwa');	
				} else {
					$produkt = $this->input->post('link');
				}
				$ilosc = sizeof($produkt);
				$lacznie = 0;
				$produkt['nazwa'] = $this->input->post('nazwa');
				$produkt['link'] = $this->input->post('link');
				$produkt['cena'] = $this->input->post('cena');
				$produkt['ilosc'] = $this->input->post('ilosc');
				for($key=0;$key<$ilosc;$key++) {
					if(@$produkt['nazwa'][$key]) { $this->data['produkt'][$key]['nazwa'] = $produkt['nazwa'][$key]; } else {
						$nazwa = explode('/',$produkt['link'][$key]);
						$czesci = sizeof($nazwa);
						$this->data['produkt'][$key]['nazwa'] = '';
						for($c=3;$c<$czesci;$c++) {
						$this->data['produkt'][$key]['nazwa'] .= '/'.$nazwa[$c];
						}
					}
					if(@$produkt['link'][$key]) { $this->data['produkt'][$key]['link'] = $produkt['link'][$key]; } 
					if(@$produkt['cena'][$key]) { $this->data['produkt'][$key]['cena'] = str_replace(',', '.',$produkt['cena'][$key]); } 
					if(@$produkt['ilosc'][$key]) { $this->data['produkt'][$key]['ilosc'] = $produkt['ilosc'][$key]; } else { $this->data['produkt'][$key]['ilosc'] = '1'; }
					$lacznie = $produkt['cena'][$key] + $lacznie;	
				}
			}
		}
				
		if($this->data['formularz']['kwota'] and ($this->data['formularz']['kwota'] < $lacznie)) {
			// 
			$this->data['produkt'] = array();
			$this->data['produkt'][0]['nazwa'] = 'Zamówienie '.$this->data['formularz']['info'];
			$this->data['produkt'][0]['link'] = $this->data['formularz']['info'];
			$this->data['produkt'][0]['cena'] = $this->data['formularz']['kwota'];
			$this->data['produkt'][0]['ilosc'] = '1';
		}

		$this->data['min'] = 6;
		$this->data['max'] = 60;
		$this->data['selected'] = 60;
		if($this->data['partner']['raty_oze']) {
			$this->data['min'] = 40;
			$this->data['max'] = 120;
		}
		if($this->data['partner']['raty_oze']) {
			$this->data['selected'] = 120;
		}
		if($this->data['partner']['raty_1060']) {
			$this->data['selected'] = 60;
		}
		if($this->data['partner']['oprocentowanie_zero'] or $this->data['partner']['raty_10']) {
			$this->data['selected'] = 10;
		}

        $this->data['formularz']['rabat_10p'] = $this->isRabat10p($partner_id, $ilosc_rat);
        $this->data['formularz']['partner_10p'] = $this->isRabat10p($partner_id, false);
        $this->data['formularz']['raty_10'] = $this->isRaty10($partner_id, $ilosc_rat);
        $this->data['formularz']['raty_1060'] = $this->isRaty1060($partner_id, $ilosc_rat);

        $this->load->view('zloz-wniosek-2', $this->data);
    }

	public function wniosek_start() {
		if($this->uri->segment(1) == 'zloz-wniosek') {
	        redirect('kalkulator', 'location', 301);	
		}
        $this->data['meta']['title'] = 'Kalkulator rat online';
        $this->data['meta']['description'] = 'Nasz internetowy kalkulator rat pomoże Ci wyliczyć wysokość miesięcznych opłat! Złóż wniosek przez internet i wybierz się na długo wyczekiwane zakupy!';
		$this->data['formularz'] = array();
		$this->data['partner'] = NULL;
		$this->data['oneMonth'] = NULL;
        $this->session->unset_userdata('allegro_cena');
        $this->session->unset_userdata('allegro_link');
        $this->data['canonical'] = true;
        if ($this->uri->segment(2)) {
            $this->data['partner'] = modules::run('partners/finansowa_dane', $this->uri->segment(2));
            if (!$this->data['partner']) {
                redirect('kalkulator');
            }
            $this->data['partner']['oprocentowanie_raty'] = unserialize($this->data['partner']['oprocentowanie_raty']);
        }
		if ($this->uri->segment(5)) {
			$this->session->set_userdata('info',$this->uri->segment(5));
		}
		$this->data['min'] = 6;
		$this->data['max'] = 60;
		$this->data['selected'] = 60;
		if($this->data['partner']['raty_oze']) {
			$this->data['min'] = 40;
			$this->data['max'] = 120;
		}
		if($this->data['partner']['raty_oze']) {
			$this->data['selected'] = 120;
		}
		if($this->data['partner']['raty_1060']) {
			$this->data['selected'] = 60;
		}
		if($this->data['partner']['oprocentowanie_zero'] or $this->data['partner']['raty_10']) {
			$this->data['selected'] = 10;
		}
		if($this->data['partner']['id'] == '3167') { /* PROKA */
			$this->data['min'] = 10;
			$this->data['max'] = 10;
			$this->data['selected'] = 10;
			$this->data['oneMonth'] = true;
		}
		$this->load->view('zloz-wniosek-start',$this->data);
	}
	
	public function wniosek_1() {
		$this->data['formularz'] = array();
		$this->data['min'] = 6;
		$this->data['max'] = 60;
		$this->load->view('zloz-wniosek',$this->data);
	}
	
	public function wniosek_2() {
		$this->data['formularz'] = array();
		$this->data['min'] = 6;
		$this->data['max'] = 60;
		$this->load->view('zloz-wniosek-2',$this->data);
	}

	public function wniosek_3() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 2 - dane kredytobiorcy';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->load->view('zloz-wniosek-3',$this->data);
	}
	
	public function wniosek_4() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 3 - wysyłka i faktura';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->data['partner'] = modules::run('partners/finansowa_dane', $this->session->userdata('partner'));
		$this->data['typ'] = $this->data['partner']['santander'];
		$this->load->view('zloz-wniosek-4',$this->data);
	}
	
	public function wniosek_5() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 4 - podsumowanie';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->load->view('zloz-wniosek-5',$this->data);
	}

	public function wniosek_6() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 4 - podsumowanie';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->load->view('zloz-wniosek-5-alt',$this->data);
	}
	
	public function wniosek_7() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 4 - podsumowanie';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->load->view('zloz-wniosek-7',$this->data);
	}
	
	public function wniosek_6_alt() {	
		$this->data['formularz'] = array();
        $this->data['meta']['title'] = 'Składasz wniosek - krok 4 - podsumowanie';
		$this->data['wniosek'] = $this->session->userdata('wniosek');
		$this->load->view('zloz-wniosek-5',$this->data);
	}
	
    public function rozpocznij_wniosek()
    {
        if ($this->input->post('ubezpieczenie_zakupu')) {
            $ubzakup = '1';
        } else {
            $ubzakup = '0';
        }
        $wniosek = array(
            'partner' => $this->input->post('partner'),
            'wplata' => ($this->input->post('wplata')?$this->input->post('wplata'):'0'),
            'wartosc' => ($this->input->post('wartosc')?$this->input->post('wartosc'):'0'),
            'gotowka' => '0',
            'oprocentowanie' => $this->input->post('oprocentowanie'),
            'ubezpieczenie' => ($this->input->post('ubezpieczenie')?$this->input->post('ubezpieczenie'):'0'),
            'rabat_10p' => $this->input->post('rabat_10p'),
            'ubezpieczenie_zakupu' => $ubzakup,
            'kwota' => $this->input->post('kwota'),
            'odroczenie' => ($this->input->post('odroczenie') ? $this->input->post('odroczenie') : null),
            'raty' => $this->input->post('ilosc_rat'),
            'wRata' => $this->input->post('rata'),
            'rodzaj' => ($this->input->post('rodzaj')?$this->input->post('rodzaj'):NULL),
            'backurl' => $this->input->post('backurl'),
            'info' => $this->input->post('info'),
            'sklep' => $this->input->post('sklep'),
            'data' => unix_to_human(time(), true, 'eu'),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version() . ' ' . $agent = $this->agent->mobile(),
            'zgoda' => '0',
			'test' => $this->input->post('test'),
            'disable_auto_export' => '1'
        );

        if ($this->input->post('inne_raty') !== null) {
            $wniosek['inne_raty'] = $this->input->post('inne_raty');
        }

        $wniosek['rabat_10p'] = $this->isRabat10p($wniosek['partner'], $wniosek['raty']);

        $wniosek['netto_partner'] = $wniosek['kwota'] = $wniosek['wartosc'] - $wniosek['wplata'];
        $zakup = array();
        $produkt = array();
        if ($wniosek['rodzaj'] == 1) {
            $zakup = array(
                'tryb' => 'internetowo',
                'wysylka' => $this->input->post('wysylka')
            );
            if (sizeof($zakup) > 0) {
				$ilosc = sizeof($this->input->post('produktlink'));
				$nazwa = $this->input->post('produktnazwa');
				$przedmiot = $this->input->post('produktlink');
				$cena = $this->input->post('cenalink');
				$liczba = $this->input->post('ilosc');
				//$wysylka = $this->input->post('wysylka');
				$dpartner = modules::run('partners/finansowa_dane', $this->session->userdata('partner'));
				$typ = $dpartner['santander'];
				$wysylka = '0';
				for ($i = 0; $i < $ilosc; $i++) {
					if (strlen($przedmiot[$i]) > 2) {
						$produkt[$i]['nazwa'] = ($typ==3?'Zamówienie':($nazwa[$i] . ($wniosek['rabat_10p'] == 1 ? '(rabat 10%)' : '')));
						$produkt[$i]['produkt'] = ($typ == 3?'---':$przedmiot[$i]);
						$produkt[$i]['ilosc'] = $liczba[$i];
						$produkt[$i]['cena'] = ($wniosek['rabat_10p'] == 1 ? $cena[$i] * 0.9 : $cena[$i]);
						//$produkt[$i]['wysylka'] = $wysylka[$i] ? $wysylka[$i] : '0.00';
						$produkt[$i]['wysylka'] = '0.00';
						$produkt[$i]['rabat_10p'] = $wniosek['rabat_10p'];
					}
				}
				$i++;
				$produkt[$i]['nazwa'] = 'Łączny koszt wysyłki';
				$produkt[$i]['produkt'] = '---';
				$produkt[$i]['cena'] = $this->input->post('wysylka');
				$produkt[$i]['wysylka'] = '0.00';
				$produkt[$i]['ilosc'] = '1';
				$produkt[$i]['rabat_10p'] = 0;
				// tutaj dodajesz produkt wysyłka...
				if (!$this->input->post('wysylka')) {
					$produkt[0]['wysylka'] = $this->input->post('wysylka');
				}
            }
        }

        $this->form_validation->set_rules('kwota', 'Kwota', 'required|numeric');
        $this->form_validation->set_rules('ilosc_rat', 'Ilość rat', 'required|integer');
        $this->form_validation->set_rules('rata', 'Wysokość raty', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $errors = form_error('kwota') . form_error('ilosc_rat') . form_error('rata');
            $this->session->set_userdata('error', $errors);
            redirect($this->agent->referrer());
        } else {
            $this->load->module('wniosek');
            if ($this->wniosek->rozpocznij_wniosek($wniosek, $zakup, $produkt)) {
                $this->session->set_userdata('notice', 'Rozpocząłeś składanie wniosku.');
                redirect('dane-osobowe', 'location', 301);
            } else {
                $this->session->set_userdata('error', 'Wystąpił błąd, spróbuj ponownie.');
                redirect($this->agent->referrer());
            }
        }
    }
	
    public function zapisz_dane()
    {
        $id = $this->uri->segment(4);
        if ($id) {
            $this->admin();
        }

        $zmienne = ['imie', 'nazwisko', 'pesel', 'telefonkom', 'email'];
        foreach ($zmienne as $zmienna) {
            $dane[$zmienna] = $this->input->post($zmienna);
        }
        $dane['zmiana'] = unix_to_human(time(), true, 'eu');

        $this->form_validation->set_rules('email', 'Adres e-mail', 'valid_email');

		$this->form_validation->set_rules('imie', 'Imię', 'required');
		$this->form_validation->set_rules('nazwisko', 'Nazwisko', 'required');
		$this->form_validation->set_rules('pesel', 'PESEL', 'required');


        if ($this->form_validation->run($this) == false) {
            $errors = form_error('telefonkom') . form_error('email');
            $errors .= form_error('imie') . form_error('nazwisko') . form_error('pesel');
            $this->session->set_userdata('error', $errors);
            redirect($this->agent->referrer());
        } else {
            $this->load->module('wniosek');
            if (!$this->uri->segment(4)) {
                $id = $this->session->userdata('wniosek');
            }

            if ($this->wniosek->zapisz_dane($dane, $id)) {
                $this->session->set_userdata('notice', 'Dane zostały zapisane.');
                redirect('wysylka-faktura', 'location', 301);
            } else {
                $this->session->set_userdata('error', 'Wystąpił błąd, spróbuj ponownie.');
                redirect($this->agent->referrer());
            }
        }
    }
	
	public function zapisz_faktura() {
		$data = array(
            'active' => '1',
            'status' => '1',
            'data' => unix_to_human(time(), true, 'eu')
        );
        if ($this->input->post('zgoda')) {
            $data['zgoda'] = '1';
        }
        if ($this->input->post('marketing')) {
            $data['marketing'] = '1';
        }

        for ($a = 2; $a <= 16; $a++) {
            if ($this->input->post('agree' . $a)) {
                $data['agree' . $a] = '1';
            } else {
                $data['agree' . $a] = '0';
            }
        }

        $this->load->module('wniosek');
        if ($this->wniosek->zapisz_wniosek($data)) {
            $faktura_wysylka = array(
                'faktura' => $this->input->post('faktura'),
                'faktura_odbiorca' => ($this->input->post('faktura') == 'fizyczna' ? $this->input->post('faktura_fizyczna_odbiorca') : $this->input->post('faktura_firma_odbiorca')),
                'faktura_nip' => $this->input->post('faktura_nip'),
                'faktura_ulica' => $this->input->post('faktura_ulica'),
                'faktura_nrdom' => $this->input->post('faktura_nrdom'),
                'faktura_nrlokal' => $this->input->post('faktura_nrlokal'),
                'faktura_kod_pocztowy' => $this->input->post('faktura_kod_pocztowy'),
                'faktura_miejscowosc' => $this->input->post('faktura_miejscowosc'),
            );
            modules::run('wniosek/zapisz_dane', $faktura_wysylka, $this->session->userdata('wniosek'));
			$this->session->set_userdata('notice', 'Dane zostały zapisane. Teraz wybierz warunki spłaty.');
			redirect('podsumowanie', 'location', 301);
        } else {
            $this->session->set_userdata('error', 'Wystąpił błąd, spróbuj ponownie.');
            redirect($this->agent->referrer());
        }
	}
	
    public function zapisz() {

        $this->load->module('wniosek');
			
			$wnioskodawca = $this->load->wnioskodawca($this->session->userdata('wniosek'));
            $produkty = modules::run('wniosek/_get_produkt', $this->session->userdata('wniosek'));
            $tryb_zakupu = ' // ' . $this->load->selectdirect('zakup', 'tryb', 'wniosek', $this->session->userdata('wniosek'));
            $zakup = '';
			foreach ($produkty->result() as $produkt) {
				$zakup .= '- ' . $produkt->produkt . ' - ' . $produkt->cena . '<br>';
			}

            if ($this->load->select('dane', 'email', $this->session->userdata('wniosek'))) {
                $data = [];
				/*
                $email_klient = [
                    'temat' => 'Wniosek został złożony',
                    'tresc' => modules::run('email/powiadomienie_klient', $data),
                    'email' => $this->load->select('dane', 'email', $this->session->userdata('wniosek'))
                ];
                modules::run('email/ratalna', $email_klient);
				*/
            }

            $id = $this->session->userdata('wniosek');

            $pobierz_wniosek = modules::run('wniosek/curl_wniosek', $id);
            $wniosek = $pobierz_wniosek->result_array();
            unset($wniosek[0]['id']);
            $parameters['wniosek'] = $wniosek[0];

            $pobierz_dane = modules::run('wniosek/curl_dane', $id);
            $dane = $pobierz_dane->result_array();
            unset($dane[0]['id']);
            $parameters['dane'] = $dane[0];

            $pobierz_dochod = modules::run('wniosek/curl_dochod', $id);
            $dochod = $pobierz_dochod->result_array();
            unset($dochod[0]['id']);
            $parameters['dochod'] = $dochod[0];

            $pobierz_zakup = modules::run('wniosek/curl_zakup', $id);
            $zakup = $pobierz_zakup->result_array();
            $parameters['zakup'] = $zakup[0];

            $pobierz_produkt = modules::run('wniosek/curl_produkt', $id);
            $produkt = $pobierz_produkt->result_array();
            $parameters['produkt'] = $produkt;

            $url = 'https://www.platformafinansowa.pl/import-ratalna';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: multipart/form-data"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['wniosek' => serialize($parameters)]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $numerWniosek = $data;
            curl_close($ch);

			if($parameters['wniosek']['test'] == 1) {
				$this->session->set_userdata('notice', 'Wniosek testowy został zapisany.');
                redirect(site_url('podsumowanie/test'));
			} else {
            $numerWniosekArray = explode('|', $numerWniosek);
			
            if ($parameters['wniosek']['disable_auto_export'] == 1 && count($numerWniosekArray) > 1) {
                $sum_products = 0;
				echo '
				<style type="text/css">
					@import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
					body {text-align:center;margin:10% auto;font-family:"Jost",sans-serif;}
					input[type="submit"],
					button[type="submit"] {font-family: "Inter", sans-serif;display:inline-block;color:#FFF;background-color:#E95E29;border:1px solid #E95E29;padding:15px 50px;font-size:16px;line-height:16px;color:#fff;border-radius:30px;font-weight:400;transition:all 0.3s ease;margin:20px auto;}
					input[type="submit"]:hover,
					button[type="submit"]:hover {cursor:pointer;background-color:#2D2E83;border:1px solid #2D2E83;color:#fff;text-decoration:none;}
					img {display:block;margin:60px auto;}
				</style>';
				echo '<img src="/assets/gfx/logo.svg">';
                $form[] = form_open('https://wniosek.eraty.pl/formularz', ['name' => 'auto_send']);
                foreach ($parameters['produkt'] as $x => $produkt) {
                    $y = $x + 1;
                    $sum = $produkt['cena']*$produkt['ilosc'] + $produkt['wysylka'];
                    $form[] = form_hidden('idTowaru' . $y, $produkt['id']);
                    $form[] = form_hidden('nazwaTowaru' . $y, ($produkt['ilosc'].' x '.$produkt['nazwa']));
                    $form[] = form_hidden('wartoscTowaru' . $y, (float)$sum);
                    $form[] = form_hidden('liczbaSztukTowaru' . $y, 1);
                    $form[] = form_hidden('jednostkaTowaru' . $y, 'szt');
                    $sum_products += $sum;
                }

                $personal = $parameters['dane'];
                $wniosek = $parameters['wniosek'];

                $form[] = form_hidden('wartoscTowarow', (float)$sum_products);
                $form[] = form_hidden('liczbaSztukTowarow', count($parameters['produkt']));
                $form[] = form_hidden('numerSklepu', $numerWniosekArray[1]);
                $form[] = form_hidden('typProduktu', '0');
                $form[] = form_hidden('sposobDostarczeniaTowaru', 'kurier');
                $form[] = form_hidden('nrZamowieniaSklep', $numerWniosekArray[0]);
                $form[] = form_hidden('pesel', $personal['pesel']);
                $form[] = form_hidden('imie', $personal['imie']);
                $form[] = form_hidden('nazwisko', $personal['nazwisko']);
                $form[] = form_hidden('email', $personal['email']);
                $form[] = form_hidden('telKontakt', $personal['telefonkom']);
				/*
                $form[] = form_hidden('ulica', $personal['wysylka_ulica']);
                $form[] = form_hidden('nrDomu', $personal['wysylka_nrdom']);
                $form[] = form_hidden('nrMieszkania', $personal['wysylka_nrlokal']);
                $form[] = form_hidden('miasto', $personal['wysylka_miejscowosc']);
                $form[] = form_hidden('kodPocz', $personal['wysylka_kod_pocztowy']);
                */
				$form[] = form_hidden('blokadaWplaty', '1');
                $form[] = form_hidden('char', 'ISO');
                $form[] = form_submit('', 'Rozpocznij');
             

                //                $form[] = form_hidden('liczbaRat', $wniosek['raty']);
                //                $form[] = form_hidden('wniosekZapisany', '');
                //                $form[] = form_hidden('wniosekAnulowany', '');

                $form[] = form_close();
               // echo '<button type="submit" class="btn btn-primary">Dalej</button><br />';
                echo "Za chwile nastąpi przekierowanie na stronę banku. Jeśli to nie nastąpi kliknij w przycisk poniżej:<br/>" . join('', $form);
                echo '<script>document.auto_send.submit();</script>';
                exit;
				
            }
			}

            $this->saveSession('force', false);
            $backurl = $this->load->select('wniosek', 'backurl', $this->session->userdata('wniosek'));
            if ($backurl) {
                redirect(prep_url($backurl . '?status=1&wniosek=' . $numerWniosek));
            } else {
                //$this->session->set_userdata('notice', 'Wniosek został złożony. Wkrótce się z Tobą skontaktujemy.');
                redirect(site_url());
            }
    }
	
    public function finalizuj() {

        $this->load->module('wniosek');
		
		$wniosek_id = $this->uri->segment(3);
		$wniosek_pf = $this->uri->segment(4);
		$sklep_pf = $this->uri->segment(5);
			
			$wnioskodawca = $this->load->wnioskodawca($wniosek_id);
            $produkty = modules::run('wniosek/_get_produkt', $wniosek_id);
            $tryb_zakupu = ' // ' . $this->load->selectdirect('zakup', 'tryb', 'wniosek', $wniosek_id);
            $zakup = '';
			foreach ($produkty->result() as $produkt) {
				$zakup .= '- ' . $produkt->produkt . ' - ' . $produkt->cena . '<br>';
			}

            $id = $wniosek_id;

            $pobierz_wniosek = modules::run('wniosek/curl_wniosek', $id);
            $wniosek = $pobierz_wniosek->result_array();
            unset($wniosek[0]['id']);
            $parameters['wniosek'] = $wniosek[0];

            $pobierz_dane = modules::run('wniosek/curl_dane', $id);
            $dane = $pobierz_dane->result_array();
            unset($dane[0]['id']);
            $parameters['dane'] = $dane[0];

            $pobierz_dochod = modules::run('wniosek/curl_dochod', $id);
            $dochod = $pobierz_dochod->result_array();
            unset($dochod[0]['id']);
            $parameters['dochod'] = $dochod[0];

            $pobierz_zakup = modules::run('wniosek/curl_zakup', $id);
            $zakup = $pobierz_zakup->result_array();
            $parameters['zakup'] = $zakup[0];

            $pobierz_produkt = modules::run('wniosek/curl_produkt', $id);
            $produkt = $pobierz_produkt->result_array();
            $parameters['produkt'] = $produkt;
/*
            $url = 'https://www.platformafinansowa.pl/import-ratalna';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: multipart/form-data"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['wniosek' => serialize($parameters)]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $numerWniosek = $data;
            curl_close($ch);
*/

            if ($parameters['wniosek']['disable_auto_export'] == 1) {
                $sum_products = 0;
				echo '
				<style type="text/css">
					@import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
					body {text-align:center;margin:10% auto;font-family:"Jost",sans-serif;}
					input[type="submit"],
					button[type="submit"] {font-family: "Inter", sans-serif;display:inline-block;color:#FFF;background-color:#E95E29;border:1px solid #E95E29;padding:15px 50px;font-size:16px;line-height:16px;color:#fff;border-radius:30px;font-weight:400;transition:all 0.3s ease;margin:20px auto;}
					input[type="submit"]:hover,
					button[type="submit"]:hover {cursor:pointer;background-color:#2D2E83;border:1px solid #2D2E83;color:#fff;text-decoration:none;}
					img {display:block;margin:60px auto;}
				</style>';
				echo '<img src="/assets/gfx/logo.svg">';
                $form[] = form_open('https://wniosek.eraty.pl/formularz', ['name' => 'auto_send']);
                foreach ($parameters['produkt'] as $x => $produkt) {
                    $y = $x + 1;
                    $sum = $produkt['cena']*$produkt['ilosc'] + $produkt['wysylka'];
                    $form[] = form_hidden('idTowaru' . $y, $produkt['id']);
                    $form[] = form_hidden('nazwaTowaru' . $y, ($produkt['ilosc'].' x '.$produkt['nazwa']));
                    $form[] = form_hidden('wartoscTowaru' . $y, (float)$sum);
                    $form[] = form_hidden('liczbaSztukTowaru' . $y, 1);
                    $form[] = form_hidden('jednostkaTowaru' . $y, 'szt');
                    $sum_products += $sum;
                }

                $personal = $parameters['dane'];
                $wniosek = $parameters['wniosek'];

                $form[] = form_hidden('wartoscTowarow', (float)$sum_products);
                $form[] = form_hidden('liczbaSztukTowarow', count($parameters['produkt']));
                $form[] = form_hidden('numerSklepu', $sklep_pf);
                $form[] = form_hidden('typProduktu', '0');
                $form[] = form_hidden('sposobDostarczeniaTowaru', 'kurier');
                $form[] = form_hidden('nrZamowieniaSklep', $wniosek_pf);
                $form[] = form_hidden('pesel', $personal['pesel']);
                $form[] = form_hidden('imie', $personal['imie']);
                $form[] = form_hidden('nazwisko', $personal['nazwisko']);
                $form[] = form_hidden('email', $personal['email']);
                $form[] = form_hidden('telKontakt', $personal['telefonkom']);
				/*
                $form[] = form_hidden('ulica', $personal['wysylka_ulica']);
                $form[] = form_hidden('nrDomu', $personal['wysylka_nrdom']);
                $form[] = form_hidden('nrMieszkania', $personal['wysylka_nrlokal']);
                $form[] = form_hidden('miasto', $personal['wysylka_miejscowosc']);
                $form[] = form_hidden('kodPocz', $personal['wysylka_kod_pocztowy']);
                */
				$form[] = form_hidden('blokadaWplaty', '1');
                $form[] = form_hidden('char', 'ISO');
                $form[] = form_submit('', 'Rozpocznij');
             

                //                $form[] = form_hidden('liczbaRat', $wniosek['raty']);
                //                $form[] = form_hidden('wniosekZapisany', '');
                //                $form[] = form_hidden('wniosekAnulowany', '');

                $form[] = form_close();
               // echo '<button type="submit" class="btn btn-primary">Dalej</button><br />';
                echo "Za chwile nastąpi przekierowanie na stronę banku. Jeśli to nie nastąpi kliknij w przycisk poniżej:<br/>" . join('', $form);
                echo '<script>document.auto_send.submit();</script>';
                exit;
				
            }

            $this->saveSession('force', false);
            $backurl = $this->load->select('wniosek', 'backurl', $wniosek_id);
            if ($backurl) {
                redirect(prep_url($backurl . '?status=1&wniosek=' . $wniosek_pf));
            } else {
                //$this->session->set_userdata('notice', 'Wniosek został złożony. Wkrótce się z Tobą skontaktujemy.');
                redirect(site_url());
            }
    }
	
	public function zapisz_uslugowy() {
		$data = array(
            'active' => '1',
            'status' => '1',
            'data' => unix_to_human(time(), true, 'eu')
        );
        if ($this->input->post('zgoda')) {
            $data['zgoda'] = '1';
        }
        if ($this->input->post('marketing')) {
            $data['marketing'] = '1';
        }

        for ($a = 2; $a <= 16; $a++) {
            if ($this->input->post('agree' . $a)) {
                $data['agree' . $a] = '1';
            } else {
                $data['agree' . $a] = '0';
            }
        }

        $this->load->module('wniosek');
        if ($this->wniosek->zapisz_wniosek($data)) {
            $faktura_wysylka = array(
                'faktura' => $this->input->post('faktura'),
                'faktura_odbiorca' => ($this->input->post('faktura') == 'fizyczna' ? $this->input->post('faktura_fizyczna_odbiorca') : $this->input->post('faktura_firma_odbiorca')),
                'faktura_nip' => $this->input->post('faktura_nip'),
                'faktura_ulica' => $this->input->post('faktura_ulica'),
                'faktura_nrdom' => $this->input->post('faktura_nrdom'),
                'faktura_nrlokal' => $this->input->post('faktura_nrlokal'),
                'faktura_kod_pocztowy' => $this->input->post('faktura_kod_pocztowy'),
                'faktura_miejscowosc' => $this->input->post('faktura_miejscowosc'),
            );
            modules::run('wniosek/zapisz_dane', $faktura_wysylka, $this->session->userdata('wniosek'));
			
        $this->load->module('wniosek');
            
			$wnioskodawca = $this->load->wnioskodawca($this->session->userdata('wniosek'));
            $produkty = modules::run('wniosek/_get_produkt', $this->session->userdata('wniosek'));
            $tryb_zakupu = ' // ' . $this->load->selectdirect('zakup', 'tryb', 'wniosek', $this->session->userdata('wniosek'));
            $zakup = '';
            foreach ($produkty->result() as $produkt) {
                $zakup .= '- ' . $produkt->produkt . ' - ' . $produkt->cena . '<br>';
            }
			
			//echo $this->load->select('dane', 'email', $this->session->userdata('wniosek')) .' '.$this->load->select('dane', 'telefonkom', $this->session->userdata('wniosek')); die;
			
            $id = $this->session->userdata('wniosek');

            $pobierz_wniosek = modules::run('wniosek/curl_wniosek', $id);
            $wniosek = $pobierz_wniosek->result_array();
            unset($wniosek[0]['id']);
            $parameters['wniosek'] = $wniosek[0];

            $pobierz_dane = modules::run('wniosek/curl_dane', $id);
            $dane = $pobierz_dane->result_array();
            unset($dane[0]['id']);
            $parameters['dane'] = $dane[0];

            $pobierz_dochod = modules::run('wniosek/curl_dochod', $id);
            $dochod = $pobierz_dochod->result_array();
            unset($dochod[0]['id']);
            $parameters['dochod'] = $dochod[0];

            $pobierz_zakup = modules::run('wniosek/curl_zakup', $id);
            $zakup = $pobierz_zakup->result_array();
            $parameters['zakup'] = $zakup[0];

            $pobierz_produkt = modules::run('wniosek/curl_produkt', $id);
            $produkt = $pobierz_produkt->result_array();
            $parameters['produkt'] = $produkt;

            $url = 'https://www.platformafinansowa.pl/import-ratalna';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: multipart/form-data"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['wniosek' => serialize($parameters)]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $numerWniosek = $data;
            curl_close($ch);
			
            $numerWniosekArray = explode('|', $numerWniosek);
			
			$numer = $this->session->userdata('wniosek')	;
			$data = array('wniosek' => $numer, 'pfwniosek' => $numerWniosekArray[0], 'pfsklep' => $numerWniosekArray[1]);
			$email_klient = array(
				'temat' => 'Dokończenie wniosku',
				'tresc' => modules::run('email/wniosek_uslugowy', $data),
				'email' => $this->load->select('dane', 'email', $numer)
			);
			modules::run('email', $email_klient);
			
			$this->load->library('Serwersms');
			$nadawca = 'i-Raty';
			$wiadomosc = 'Na wskazany we wniosku adres e-mail został wysłany Państwu dedykowany link do sfinalizowania wniosku.';
			$xml = SerwerSMS::wyslij_sms(['numer' => $this->load->select('dane', 'telefonkom', $numer), 'wiadomosc' => strip_tags($wiadomosc), 'nadawca' => $nadawca]);

			
			$this->session->set_userdata('notice', 'Dane zostały zapisane. Dziękujemy!');
			redirect('podsumowanie-alt');
        } else {
            $this->session->set_userdata('error', 'Wystąpił błąd, spróbuj ponownie.');
            redirect($this->agent->referrer());
        }
	}
	
	public function fintest() {
		$data['wniosek'] = 2973;
		$email_klient = array(
			'temat' => 'Dokończenie wniosku',
			'tresc' => modules::run('email/wniosek_uslugowy', $data),
			'email' => 'nciemieniewska@gmail.com'
		);
		modules::run('email', $email_klient);	
	}

    public function przywroc() {

        $this->load->module('wniosek');
            $this->session->set_userdata('wniosek',1597);
			$wnioskodawca = $this->load->wnioskodawca($this->session->userdata('wniosek'));
            $produkty = modules::run('wniosek/_get_produkt', $this->session->userdata('wniosek'));
            $tryb_zakupu = ' // ' . $this->load->selectdirect('zakup', 'tryb', 'wniosek', $this->session->userdata('wniosek'));
            $zakup = '';
            foreach ($produkty->result() as $produkt) {
                $zakup .= '- ' . $produkt->produkt . ' - ' . $produkt->cena . '<br>';
            }

            if ($this->load->select('dane', 'email', $this->session->userdata('wniosek'))) {
                $data = [];
				/*
                $email_klient = [
                    'temat' => 'Wniosek został złożony',
                    'tresc' => modules::run('email/powiadomienie_klient', $data),
                    'email' => $this->load->select('dane', 'email', $this->session->userdata('wniosek'))
                ];
                modules::run('email/ratalna', $email_klient);
				*/
            }

            $id = $this->session->userdata('wniosek');

            $pobierz_wniosek = modules::run('wniosek/curl_wniosek', $id);
            $wniosek = $pobierz_wniosek->result_array();
            unset($wniosek[0]['id']);
            $parameters['wniosek'] = $wniosek[0];

            $pobierz_dane = modules::run('wniosek/curl_dane', $id);
            $dane = $pobierz_dane->result_array();
            unset($dane[0]['id']);
            $parameters['dane'] = $dane[0];

            $pobierz_dochod = modules::run('wniosek/curl_dochod', $id);
            $dochod = $pobierz_dochod->result_array();
            unset($dochod[0]['id']);
            $parameters['dochod'] = $dochod[0];

            $pobierz_zakup = modules::run('wniosek/curl_zakup', $id);
            $zakup = $pobierz_zakup->result_array();
            $parameters['zakup'] = $zakup[0];

            $pobierz_produkt = modules::run('wniosek/curl_produkt', $id);
            $produkt = $pobierz_produkt->result_array();
            $parameters['produkt'] = $produkt;

            $url = 'https://www.platformafinansowa.pl/import-ratalna';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: multipart/form-data"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['wniosek' => serialize($parameters)]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $numerWniosek = $data;
            curl_close($ch);


            $numerWniosekArray = explode('|', $numerWniosek);

            if ($parameters['wniosek']['disable_auto_export'] == 1 && count($numerWniosekArray) > 1) {
                $sum_products = 0;
				echo '
				<style type="text/css">
					@import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
					body {text-align:center;margin:10% auto;font-family:"Jost",sans-serif;}
					input[type="submit"],
					button[type="submit"] {font-family: "Inter", sans-serif;display:inline-block;color:#FFF;background-color:#E95E29;border:1px solid #E95E29;padding:15px 50px;font-size:16px;line-height:16px;color:#fff;border-radius:30px;font-weight:400;transition:all 0.3s ease;margin:20px auto;}
					input[type="submit"]:hover,
					button[type="submit"]:hover {cursor:pointer;background-color:#2D2E83;border:1px solid #2D2E83;color:#fff;text-decoration:none;}
					img {display:block;margin:60px auto;}
				</style>';
				echo '<img src="/assets/gfx/logo.svg">';
                $form[] = form_open('https://wniosek.eraty.pl/formularz', ['name' => 'auto_send']);
                foreach ($parameters['produkt'] as $x => $produkt) {
                    $y = $x + 1;
                    $sum = $produkt['cena'] + $produkt['wysylka'];
                    $form[] = form_hidden('idTowaru' . $y, $produkt['id']);
                    $form[] = form_hidden('nazwaTowaru' . $y, $produkt['nazwa']);
                    $form[] = form_hidden('wartoscTowaru' . $y, (float)$sum);
                    $form[] = form_hidden('liczbaSztukTowaru' . $y, 1);
                    $form[] = form_hidden('jednostkaTowaru' . $y, 'szt');
                    $sum_products += $sum;
                }

                $personal = $parameters['dane'];
                $wniosek = $parameters['wniosek'];

                $form[] = form_hidden('wartoscTowarow', (float)$sum_products);
                $form[] = form_hidden('liczbaSztukTowarow', count($parameters['produkt']));
                $form[] = form_hidden('numerSklepu', $numerWniosekArray[1]);
                $form[] = form_hidden('typProduktu', '0');
                $form[] = form_hidden('sposobDostarczeniaTowaru', 'kurier');
                $form[] = form_hidden('nrZamowieniaSklep', $numerWniosekArray[0]);
                $form[] = form_hidden('pesel', $personal['pesel']);
                $form[] = form_hidden('imie', $personal['imie']);
                $form[] = form_hidden('nazwisko', $personal['nazwisko']);
                $form[] = form_hidden('email', $personal['email']);
                $form[] = form_hidden('telKontakt', $personal['telefonkom']);
				/*
                $form[] = form_hidden('ulica', $personal['wysylka_ulica']);
                $form[] = form_hidden('nrDomu', $personal['wysylka_nrdom']);
                $form[] = form_hidden('nrMieszkania', $personal['wysylka_nrlokal']);
                $form[] = form_hidden('miasto', $personal['wysylka_miejscowosc']);
                $form[] = form_hidden('kodPocz', $personal['wysylka_kod_pocztowy']);
                */
				$form[] = form_hidden('blokadaWplaty', '1');
                $form[] = form_hidden('char', 'ISO');
                $form[] = form_submit('', 'Rozpocznij');
             

                //                $form[] = form_hidden('liczbaRat', $wniosek['raty']);
                //                $form[] = form_hidden('wniosekZapisany', '');
                //                $form[] = form_hidden('wniosekAnulowany', '');

                $form[] = form_close();
               // echo '<button type="submit" class="btn btn-primary">Dalej</button><br />';
                echo "Za chwile nastąpi przekierowanie na stronę banku. Jeśli to nie nastąpi kliknij w przycisk poniżej:<br/>" . join('', $form);
                echo '<script>document.auto_send.submit();</script>';
                exit;
				
            }

            $this->saveSession('force', false);
            $backurl = $this->load->select('wniosek', 'backurl', $this->session->userdata('wniosek'));
            if ($backurl) {
                redirect(prep_url($backurl . '?status=1&wniosek=' . $numerWniosek));
            } else {
                //$this->session->set_userdata('notice', 'Wniosek został złożony. Wkrótce się z Tobą skontaktujemy.');
                redirect(site_url());
            }
    }

	
    private function isRabat10p($partner, $raty)
    {
        $rabat_10p = false;
        if (!empty($partner)) {
            $partner = modules::run('partners/finansowa_dane', $partner);

            $rabat_10p = (($raty >= 38 || false === $raty) && $partner['rabat_10p'] == 1 ? 1 : 0);
        }

        return ($rabat_10p ? 1 : 0);
    }
	
    private function isRaty10($partner, $raty)
    {
        $raty10 = false;
        $raty1060 = false;
        if (!empty($partner)) {
            $partner = modules::run('partners/finansowa_dane', $partner);
			
            $raty10 = (($raty == 10 || false === $raty) && $partner['raty_10'] == 1 ? 1 : 0);
        }
		if($raty10 == 1) {
        	return 1;
		} else {
			return 0;	
		}
    }

    private function isRaty1060($partner, $raty)
    {
        $raty1060 = false;
        if (!empty($partner)) {
            $partner = modules::run('partners/finansowa_dane', $partner);
			
            $raty1060 = ((($raty >= 10 && $raty <= 60) || false === $raty) && $partner['raty_1060'] == 1 ? 1 : 0);
        }
		if($raty1060 == 1) {
        	return 1;
		} else {
			return 0;	
		}
    }
	
    private function is_new()
    {
        $sess = $this->session->get_userdata();
        return (true == $sess['is_new']);
    }

	
	public function blog() {
		$this->data['site']['class'] = 'wide';
		$id = $this->uri->rsegment(3);
		if($id and $this->uri->rsegment(4)) {
			$this->data['dane'] = modules::run('blog/pobierz',$id);
			$this->data['pozostale'] = modules::run('blog/pozostale',$id);
			$this->data['meta']['title'] = $this->data['dane']->title.' - '.$this->data['meta']['title'];
			$this->load->view('blog-id',$this->data);
		} else {
			$this->data['blog'] = modules::run('blog/pobierz');
			$this->data['meta']['title'] = 'Blog - '.$this->data['meta']['title'];
			$this->load->view('blog',$this->data);
		}
	}	

	public function podstrona()	{
		if(modules::run('podstrona/url',$this->uri->segment(1))) {
			$id = modules::run('podstrona/url',$this->uri->segment(1))->id;
		} else {
			$id = 56; 
		}
		$this->data['dane'] = modules::run('podstrona/pobierz',$id);
		if(!$this->admin and $this->data['dane']->status == '0') { 
			redirect(site_url());
		}
		$this->data['moduly'] = modules::run('podstrona/wyswietl',$id);
		$this->data['meta']['title'] = $this->data['dane']->title?$this->data['dane']->title:$this->data['dane']->header.' - '.$this->data['meta']['title'];
		$this->data['meta']['description'] = $this->data['dane']->description?$this->data['dane']->description:$this->data['meta']['description'];
		$this->data['meta']['keywords'] = $this->data['dane']->keywords?$this->data['dane']->keywords:$this->data['meta']['keywords'];
		$this->load->view('podstrona',$this->data);
	}
	
	public function contrast() {
		if($this->session->userdata('contrast')) {
			$this->session->unset_userdata('contrast');
		} else {
			$this->session->set_userdata('contrast','1');
		}
	}
	
	public function font() {
		$type = $this->uri->segment(2);
		if($type=='standard') {
			$this->session->unset_userdata('font');
		} else if($type=='up') {
			$this->session->set_userdata('font','1');
		}
	}

	public function error404()	{
		$id = 56;
		$this->data['dane'] = modules::run('podstrona/pobierz',$id);
		$this->data['moduly'] = modules::run('podstrona/wyswietl',$id);
		$this->data['meta']['title'] = $this->data['dane']->title?$this->data['dane']->title:$this->data['dane']->header.' - '.$this->data['meta']['title'];
		$this->data['meta']['description'] = $this->data['dane']->description?$this->data['dane']->description:$this->data['meta']['description'];
		$this->data['meta']['keywords'] = $this->data['dane']->keywords?$this->data['dane']->keywords:$this->data['meta']['keywords'];
		$this->load->view('podstrona',$this->data);
	}

	public function administrator() {
		$this->data['site']['class'] = 'wide';
		$this->data['meta']['title'] = 'Panel administracyjny';
		$this->load->view('admin',$this->data);
	}	
	
	public function zarzadzanie() {
		$this->admin();
		$this->data['site']['class'] = 'wide';
		$this->data['meta']['title'] = 'Zarządzanie treścią';
		$this->load->view('zarzadzanie',$this->data);
	}
	
	public function loguj() {
		$data = array('login' => $this->input->post('login'), 'haslo' => sha1($this->input->post('haslo').MY_HASH));
		$this->load->model('main_model');
		$id = $this->main_model->loguj($data);
		if($id) {
			$this->session->set_userdata('admin_id',$id);
			$this->session->set_userdata('admin','abcdef');
			$this->session->set_userdata('notice','Zostałeś pomyślnie zalogowany.');
			redirect(site_url('zarzadzanie'));
		} else {
			$this->session->set_userdata('error','Nie zostałeś zalogowany.');
			redirect($this->agent->referrer());
		}
	}
	
	public function wyloguj() {
		$this->session->unset_userdata('admin');
		$this->session->set_userdata('notice','Zostałeś pomyślnie wylogowany.');
		redirect(site_url());
	}
	
	public function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LeG3DIUAAAAAN8J0TDceeERvBHQYZiWIMk3wwlK',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
	
	public function wyslij() {
		/*$res = $this->post_captcha($_POST['g-recaptcha-response']);	
		if (!$res['success']) {
			$this->session->set_userdata('error','Niepoprawna weryfikacja Captcha.');			
			redirect($this->agent->referrer());
		} else {
		*/	
			$data = array(
				'nazwisko' => $this->input->post('nazwa'),
				'email' => $this->input->post('email'),
				'telefon' => $this->input->post('telefon'),
				'wiadomosc' => $this->input->post('wiadomosc')
			);
			$email = array(
				'temat' => 'Wiadomość z działu kontakt',
				'tresc' => modules::run('email/kontakt',$data),
				'email' => 'wnioski@iplatnosci.pl'
			);
		//}
		if(modules::run('email',$email)) {
			$this->session->set_userdata('notice','Wiadomość została wysłana, dziękujemy!');
		} else {
			$this->session->set_userdata('error','Błąd serwera pocztowego, wiadomość nie została wysłana!');
		}
		redirect($this->agent->referrer());
	}
	
}
