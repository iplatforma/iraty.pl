<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('partners_model');
    }

    public function index()
    { /* wyświetlenie wszystkich /ma być 10/ wniosków w panelu partnera | tu mają być wyświetlane dane partnera plus 10 ostatnich wnioskow, wszystkie będą pod partner/wnioski <- kwestia paginacji*/
        if (!$this->partner) {
            $this->load->view('login', $this->data);
        } else {
            $this->partner();
            $this->load->module('wniosek');
            $this->data['pobierz'] = $this->wniosek->_get_wnioski_by_partner($this->session->userdata('partner'));
            $this->total_rows = $this->wniosek->_get_wnioski_by_partner($this->session->userdata('partner'), 'all')->num_rows();
            $this->load->paginate();
            $this->load->view('display', $this->data);
        }
    }

    public function wnioski()
    { /* wyświetlenie wszystkich wniosków w panelu partnera | tu jest kwestia paginacji, strona index musi zawierac coś innego */
        $this->partner();
        $this->load->module('wniosek');
        $this->data['pobierz'] = $this->wniosek->_get_wnioski_by_partner($this->session->userdata('partner'));
        $this->total_rows = $this->wniosek->_get_wnioski_by_partner($this->session->userdata('partner'), 'all')->num_rows();
        $this->load->paginate();
        $this->load->view('wnioski', $this->data);
    }

    public function wszyscy()
    { /* wyświetlenie wszystkich PARTNERÓW w administratorze */
        $this->admin();
        $this->total_rows = $this->partners_model->_get_partnerzy('all')->num_rows();
        if ($this->total_rows < 1) {
            $this->session->set_userdata('warning', 'Brak partnerów do wyświetlenia.');
        }
        $this->load->paginate();
        $this->data['pobierz'] = $this->partners_model->_get_partnerzy();
        $this->load->view('wszyscy', $this->data);
    }

    public function filtruj()
    {
        if ($this->input->post('filter_partner_nazwa')) {
            $this->session->set_userdata('filter_partner_nazwa', $this->input->post('filter_partner_nazwa'));
        } else {
            $this->session->unset_userdata('filter_partner_nazwa');
        }
        if ($this->input->post('filter_partner_nip')) {
            $this->session->set_userdata('filter_partner_nip', $this->input->post('filter_partner_nip'));
        } else {
            $this->session->unset_userdata('filter_partner_nip');
        }
        if ($this->input->post('filter_partner_telefon')) {
            $this->session->set_userdata('filter_partner_telefon', $this->input->post('filter_partner_telefon'));
        } else {
            $this->session->unset_userdata('filter_partner_telefon');
        }
        if ($this->input->post('filter_partner_email')) {
            $this->session->set_userdata('filter_partner_email', $this->input->post('filter_partner_email'));
        } else {
            $this->session->unset_userdata('filter_partner_email');
        }
        if ($this->input->post('filter_partner_data')) {
            $this->session->set_userdata('filter_partner_opiekun', $this->input->post('filter_partner_opiekun'));
        } else {
            $this->session->unset_userdata('filter_partner_opiekun');
        }
        if ($this->input->post('filter_partner_status')) {
            $this->session->set_userdata('filter_partner_status', $this->input->post('filter_partner_status'));
        } else {
            $this->session->unset_userdata('filter_partner_status');
        }
        redirect(site_url('zarzadzanie/partnerzy'));
    }

    public function filtruj_usun()
    {
        $var = $this->uri->segment(4);
        switch ($var) {
            case "nazwa":
                $this->session->unset_userdata('filter_partner_nazwa');
                break;
            case "nip":
                $this->session->unset_userdata('filter_partner_nip');
                break;
            case "telefon":
                $this->session->unset_userdata('filter_partner_telefon');
                break;
            case "email":
                $this->session->unset_userdata('filter_partner_email');
                break;
            case "opiekun":
                $this->session->unset_userdata('filter_partner_opiekun');
                break;
            case "status":
                $this->session->unset_userdata('filter_partner_status');
                break;
        }
        $this->session->set_userdata('notice', 'Pole ' . $var . ' usunięte z filtrowania');
        redirect($this->agent->referrer());
    }

    public function set_status()
    { /* zmienia status wniosku */
        $this->admin();
        $data = array('status' => $this->input->post('status'));
        $id = $this->input->post('wpis');
        if ($this->partners_model->_set_status($data, $id)) {
            $this->session->set_userdata('notice', 'Status partnera został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Status partnera nie został zmieniony');
        }
        redirect($this->agent->referrer());
    }

    public function set_oprocentowanie()
    { /* zmienia status wniosku */
        $this->admin();
        $data = array('oprocentowanie' => $this->input->post('oprocentowanie'));
        $id = $this->input->post('wpis');
        if ($this->partners_model->_set_oprocentowanie($data, $id)) {
            $this->session->set_userdata('notice', 'Oprocentowanie partnera został zmienione.');
        } else {
            $this->session->set_userdata('error', 'Oprocentowanie partnera nie został zmienione');
        }
        redirect($this->agent->referrer());
    }

    public function dodaj()
    {
        $this->admin();
        $this->data['formularz'] = NULL;
        $this->load->view('dodaj', $this->data);
    }

    public function edytuj()
    {
        $this->admin();
        $id = $this->uri->segment(3);
        $zmienne = array('id', 'dane', 'nazwa', 'partner', 'nip', 'opiekun', 'osoba', 'telefon', 'email', 'konto', 'status', 'linkStrona', 'linkAukcja', 'branza', 'statusMeritum', 'statusUmowa', 'statusUmowaMeritum', 'buttony', 'buttonySprawdzenie', 'prowizjaOpiekun', 'prowizjaPartner', 'assistance', 'prowizja_home', 'prowizja_office', 'koszt_home', 'koszt_office');
        foreach ($zmienne as $zmienna) {
            $this->data['formularz'][$zmienna] = html_escape($this->partners_model->_get_partner_by($zmienna, $id));
        }
        $this->load->view('edytuj', $this->data);
    }

    public function usun()
    { /* usuwa partnera - dla administratora*/
        $this->admin();
        $id = $this->uri->segment(3);
        if ($this->partners_model->_delete_partner($id)) {
            $this->session->set_userdata('notice', 'Partner został usunięty');
            redirect(site_url('zarzadzanie/partnerzy'));
        } else {
            $this->session->set_userdata('error', 'Partner nie został usunięty');
            redirect($this->agent->referrer());
        }
    }

    public function zmien_partner()
    {
        $this->admin();
        $id = $this->input->post('wpis');
        $data['npartner'] = $this->input->post('npartner');
        if ($this->partners_model->zmien_partner($data, $id)) {
            $this->session->set_userdata('notice', 'Partner został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Partner nie został zmienony.');
        }
        redirect($this->agent->referrer());
    }

    public function zapisz()
    {
        $this->admin();
        $id = $this->uri->segment(3);

        $zmienne = array('dane', 'nazwa', 'partner', 'nip', 'opiekun', 'osoba', 'telefon', 'email', 'konto', 'status', 'linkStrona', 'linkAukcja', 'branza', 'statusMeritum', 'statusUmowa', 'statusUmowaMeritum', 'buttony', 'buttonySprawdzenie', 'prowizjaOpiekun', 'prowizjaPartner', 'assistance', 'prowizja_home', 'prowizja_office', 'koszt_home', 'koszt_office');
        foreach ($zmienne as $zmienna) {
            $dane[$zmienna] = $this->input->post($zmienna);
        }
        $dane['haslo'] = substr(md5($dane['nazwa'] . $dane['nip'] . strtotime("now")), 0, 8);
        if ($this->partners_model->zapisz($dane, $id)) {
            $this->partners_model->_xml_partner();
            if ($id) {
                $this->session->set_userdata('notice', 'Dane partnera zostały pomyślnie zmienone.');
                redirect(site_url('partner/' . $id));
            } else {
                $this->session->set_userdata('notice', 'Partner został dodany do bazy.');
                redirect(site_url('zarzadzanie/partnerzy'));
            }
        } else {
            if ($id) {
                $this->session->set_userdata('error', 'Dane partnera nie zostały zmienone.');
            } else {
                $this->session->set_userdata('error', 'Wystąpił błąd. Partner nie został dodany do bazy.');
            }
            redirect($this->agent->referrer());
        }
    }

    public function dane()
    { /* wyświetlenie danego jednego partnera w administratorze */
        $this->partner();
        $this->data['dane'] = $this->partners_model->_get_partner($this->session->userdata('partner'));
        $this->load->view('dane', $this->data);
    }

    public function prowizja()
    {
        $this->partner();
        $this->data['zestawienie'] = modules::run('prowizja/_get_zestawienie_partner', $this->session->userdata('partner'));
        $this->load->view('prowizja', $this->data);
    }

    public function zestawienie()
    {
        $this->partner();
        $data = $this->uri->segment(3);
        $this->data['pobierz'] = modules::run('prowizja/get_wpisy_partner', $this->session->userdata('partner'), $data);
        $this->load->view('zestawienie', $this->data);
    }

    public function show()
    { /* wyświetlenie danego jednego partnera w administratorze */
        $this->admin();
        $id = $this->uri->segment(2);
        $this->data['dane'] = $this->partners_model->_get_partner($id);
        $this->load->module('wniosek');
        $this->data['zestawienie'] = modules::run('prowizja/_get_zestawienie_partner', $id);
        $this->data['partnerzy'] = modules::run('partners/_get_xml');
        $this->data['wnioski'] = modules::run('wniosek/_get_wnioski_by_partner', $id);
        $this->data['notatka'] = modules::run('notatka/_get_notatka_by_partner', $id);
        $this->data['dokumenty'] = modules::run('dokumenty/_get_dokumenty_by_partner', $id);
        $this->data['historia'] = modules::run('historia/_get_historia_by_partner', $id);
        $this->load->view('partner', $this->data);
    }

    public function show_wniosek()
    { /* wyświetla wniosek który należy do partnera */
        $id = $this->uri->segment(3);
        $this->load->module('wniosek');
        $this->data['dane'] = $this->wniosek->_get_wniosek_by_partner($id, $this->session->userdata('partner'));
        $this->data['produkty'] = $this->wniosek->_get_produkt($id);
        if ($this->data['dane']) {
            if ($this->data['dane']->rodzaj == '1') {
                $this->load->view('wniosek', $this->data);
            } else {
                $this->load->view('finansowe', $this->data);
            }
        } else {
            $this->session->set_userdata('error', 'Wniosek nie istnieje lub nie masz dostępu do jego danych.');
            redirect(site_url('partner'));
        }
    }

    public function login()
    { /* logowanie dla partnerów */
        $row = $this->partners_model->_check_login($this->input->post('partner_login'), $this->input->post('partner_haslo'));
        if ($row->num_rows() > 0) {
            $this->session->set_userdata('partner', $row->row()->id);
            $this->session->set_userdata('notice', 'Zostałeś pomyślnie zalogowany do panelu partnera');
            redirect(site_url('partner'));
        } else {
            $this->load->library('user_agent');
            $this->session->set_userdata('error', 'Logowanie się nie udało.');
            redirect($this->agent->referrer());
        }
    }

    function wyloguj()
    { /*wylogowanie dla partnerów */
        $this->load->library('user_agent');
        $this->session->set_userdata('notice', 'Zostałeś pomyślnie wylogowany z panelu partnera.');
        $this->session->unset_userdata('partner');
        redirect(site_url());
    }

    public function zmien_haslo()
    {
        $this->data['haslo'] = $this->input->post('partner_haslo');
        if ($this->partners_model->sprawdz_haslo($this->data)) {
            $this->data['nhaslo'] = $this->input->post('partner_nhaslo');
            $this->data['pnhaslo'] = $this->input->post('partner_pnhaslo');

            if ($this->data['nhaslo'] == $this->data['pnhaslo']) {
                $data['haslo'] = $this->data['nhaslo'];
                if ($this->partners_model->zmien_haslo($data)) {
                    $this->session->set_userdata('notice', 'Hasło zostało pomyślnie zmienione.');
                } else {
                    $this->session->set_userdata('error', 'Wystąpił błąd bazy danych. Hasło nie zostało zmienione.');
                }
            } else {
                $this->session->set_userdata('warning', 'Podane hasła różnią się od siebie');
                $this->session->set_userdata('error', 'Hasło nie zostało zmienione.');
            }
        } else {
            $this->session->set_userdata('error', 'Podałeś błędne hasło do konta.');
        }
        redirect($this->agent->referrer());
    }

    public function email($partner)
    {
        $array = array();
        $dane = $this->partners_model->_get_partner($partner);
        $email1 = $dane->rezerwacje;
        $array[] = $email1;
        if ($dane->rezerwacje2) {
            $email2 = $dane->rezerwacje2;
            $array[] = $email2;
        }
        return $array;
    }

    public function _get_xml()
    {
        return $this->partners_model->_get_partnerzy_from_xml();
    }

    function xml_partner()
    {
        if ($this->partners_model->_xml_partner()) {
            $this->session->set_userdata('notice', 'Plik został wygenerowany.');
        }
        redirect(site_url());
    }

    public function get_dane($partner)
    {
        return $this->partners_model->get_dane($partner);
    }

    public function finansowa_dane($partner)
    {
        $url = 'https://www.platformafinansowa.pl/partner/pokaz/' . $partner;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('klucz' => 'abc'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $wynik = unserialize($data);
        curl_close($ch);
        return $wynik;
    }

    /* związane z podstronami na stronie */

    public function offer()
    { /* wysyła ofertę współpracy na stronie Dla partnerów */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firma', 'Nazwa sklepu/firmy', 'required');
        $this->form_validation->set_rules('nazwisko', 'Imię i nazwisko osoby kontaktowej', 'required');
        $this->form_validation->set_rules('www', 'Adres strony www', 'required|prep_url');
        $this->form_validation->set_rules('email', 'Adres e-mail', 'required|valid_email');
        $this->form_validation->set_rules('telefon', 'Telefon', 'required');
        $this->form_validation->set_rules('tresc', 'Treść korespondencji', 'required');
        $this->data['form'] = $this->partners_model->hold_post();
        if ($this->form_validation->run() == FALSE) {
            $this->data['captcha'] = $this->load->captcha();
            $this->load->view('partners', $this->data);
        } else {
            if (strtolower($this->session->userdata('captcha')) == strtolower($this->input->post('captcha'))) {
                $this->partners_model->send_offer($this->data['form']);
                $this->session->set_userdata('notice', 'Formularz został wysłany.');
                $this->session->set_flashdata('konwersja', 'ok');
                redirect(site_url('dla-partnerow.html#formularz'));
            } else {
                $this->session->set_userdata('warning', 'Kod z obrazka jest niepoprawny.');
                $this->session->set_userdata('error', 'Formularz nie został jeszcze wysłany.');
                $this->data['captcha'] = $this->load->captcha();
                $this->load->view('partners', $this->data);
            }
        }
    }

}
