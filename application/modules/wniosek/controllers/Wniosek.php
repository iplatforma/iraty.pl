<? defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Wniosek
 * @property Wniosek_model $wniosek_model
 */
class Wniosek extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$_table = 'wniosek';
        $this->load->model('wniosek_model');
    }

    public function filtruj()
    {
        if ($this->input->post('filter_wniosek_nazwisko')) {
            $this->session->set_userdata('filter_wniosek_nazwisko', $this->input->post('filter_wniosek_nazwisko'));
        } else {
            $this->session->unset_userdata('filter_wniosek_nazwisko');
        }
        if ($this->input->post('filter_wniosek_telefon')) {
            $this->session->set_userdata('filter_wniosek_telefon', $this->input->post('filter_wniosek_telefon'));
        } else {
            $this->session->unset_userdata('filter_wniosek_telefon');
        }
        if ($this->input->post('filter_wniosek_email')) {
            $this->session->set_userdata('filter_wniosek_email', $this->input->post('filter_wniosek_email'));
        } else {
            $this->session->unset_userdata('filter_wniosek_email');
        }
        if ($this->input->post('filter_wniosek_pesel')) {
            $this->session->set_userdata('filter_wniosek_pesel', $this->input->post('filter_wniosek_pesel'));
        } else {
            $this->session->unset_userdata('filter_wniosek_pesel');
        }
        if ($this->input->post('filter_wniosek_data')) {
            $this->session->set_userdata('filter_wniosek_data', $this->input->post('filter_wniosek_data'));
        } else {
            $this->session->unset_userdata('filter_wniosek_data');
        }
        if ($this->input->post('filter_wniosek_kdata')) {
            $this->session->set_userdata('filter_wniosek_kdata', $this->input->post('filter_wniosek_kdata'));
        } else {
            $this->session->unset_userdata('filter_wniosek_kdata');
        }
        if ($this->input->post('filter_wniosek_partner')) {
            if ($this->input->post('filter_wniosek_partner') == 'indywidualny') {
                $this->session->set_userdata('filter_wniosek_partner', 'indywidualny');
            } else {
                $this->session->set_userdata('filter_wniosek_partner', $this->input->post('filter_wniosek_partner'));
            }
        } else {
            $this->session->unset_userdata('filter_wniosek_partner');
        }
        if ($this->input->post('filter_wniosek_status')) {
            $this->session->set_userdata('filter_wniosek_status', $this->input->post('filter_wniosek_status'));
        } else {
            $this->session->unset_userdata('filter_wniosek_status');
        }
        if ($this->input->post('filter_wniosek_rodzaj')) {
            $this->session->set_userdata('filter_wniosek_rodzaj', $this->input->post('filter_wniosek_rodzaj'));
        } else {
            $this->session->unset_userdata('filter_wniosek_rodzaj');
        }
        redirect(site_url('zarzadzanie/wnioski'));
    }

    public function filtruj_usun()
    {
        $var = $this->uri->segment(4);
        switch ($var) {
            case "nazwisko":
                $this->session->unset_userdata('filter_wniosek_nazwisko');
                break;
            case "telefon":
                $this->session->unset_userdata('filter_wniosek_telefon');
                break;
            case "email":
                $this->session->unset_userdata('filter_wniosek_email');
                break;
            case "pesel":
                $this->session->unset_userdata('filter_wniosek_pesel');
                break;
            case "data":
                $this->session->unset_userdata('filter_wniosek_data');
                break;
            case "kdata":
                $this->session->unset_userdata('filter_wniosek_kdata');
                break;
            case "partner":
                $this->session->unset_userdata('filter_wniosek_partner');
                break;
            case "status":
                $this->session->unset_userdata('filter_wniosek_status');
                break;
            case "rodzaj":
                $this->session->unset_userdata('filter_wniosek_rodzaj');
                break;
        }
        $this->session->set_userdata('notice', 'Pole ' . $var . ' usunięte z filtrowania');
        redirect($this->agent->referrer());
    }

    public function index()
    { /* wyświetlenie wszystkich wniosków w administratorze */
        $this->admin();
        $this->total_rows = $this->_get_wnioski('all')->num_rows();
        if ($this->total_rows < 1) {
            $this->session->set_userdata('warning', 'Brak wniosków do wyświetlenia.');
        }
        $this->load->paginate();
        $this->data['partnerzy'] = modules::run('partners/_get_xml');
        $this->data['statusy'] = $this->_get_status();
        $this->data['pobierz'] = $this->_get_wnioski();
        $this->load->view('wszystkie', $this->data);
    }

    public function show()
    { /* wyświetlenie jednego wniosku wraz z doatkowymi danymi w administratorze */
        $this->admin();
        $id = $this->uri->segment(2);
        $this->data['dane'] = $this->_get_wniosek($id);
        $this->data['statusy'] = $this->_get_status();
        $this->data['produkty'] = $this->_get_produkt($id);
        $this->data['partnerzy'] = modules::run('partners/_get_xml');
        $this->data['finansujacy'] = modules::run('finansowe/_get_finansujacy');
        $this->data['notatka'] = modules::run('notatka/_get_notatka_by_wniosek', $id);
        $this->data['dokumenty'] = modules::run('dokumenty/_get_dokumenty_by_wniosek', $id);
        $this->data['historia'] = modules::run('historia/_get_historia_by_wniosek', $id);
        if ($this->data['dane']) {
            if ($this->data['dane']->rodzaj == '1') {
                $this->load->view('wniosek', $this->data);
            } else {
                $this->load->view('finansowe', $this->data);
            }
        } else {
            redirect(site_url());
        }
    }

    public function jquery($id)
    {
        $result = $this->_get_wniosek($id);
        echo json_encode($result);
    }

    public function archiwa()
    {
        $this->admin();
        $this->total_rows = $this->wniosek_model->_get_wnioski_archiwum('all')->num_rows();
        if ($this->total_rows < 1) {
            $this->session->set_userdata('warning', 'Brak wniosków do wyświetlenia.');
        }
        $this->load->paginate();
        $this->data['pobierz'] = $this->wniosek_model->_get_wnioski_archiwum();
        $this->load->view('archiwum', $this->data);
    }

    public function show_archiwum()
    {
        $this->admin();
        $id = $this->uri->segment(3);
        $this->data['dane'] = $this->wniosek_model->_get_wniosek_archiwum($id);
        $this->data['produkty'] = $this->_get_produkt($id);
        $this->data['notatka'] = modules::run('notatka/_get_notatka_by_wniosek', $id);
        $this->data['dokumenty'] = modules::run('dokumenty/_get_dokumenty_by_wniosek', $id);
        $this->data['historia'] = modules::run('historia/_get_historia_by_wniosek', $id);
        if ($this->data['dane']) {
            if ($this->data['dane']->rodzaj == '1') {
                $this->load->view('archiwum-wniosek', $this->data);
            } else {
                $this->load->view('archiwum-finansowe', $this->data);
            }
        } else {
            redirect(site_url());
        }
    }

    public function set_status()
    { /* zmienia status wniosku */
        $this->admin();
        $data = array('status' => $this->input->post('status'), 'zmiana' => unix_to_human(time(), TRUE, 'eu'));
        $id = $this->input->post('wpis');
        if ($this->wniosek_model->_set_status($data, $id)) {
            $this->session->set_userdata('notice', 'Status wniosku został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Status wniosku nie został zmieniony.');
        }
        redirect($this->agent->referrer());
    }


    public function faktura_wysylka()
    {
        $id = $this->uri->rsegment(3);
        $array = array(
            'odbiorca' => $this->wniosek_model->_get_dane('imie', $id) . ' ' . $this->wniosek_model->_get_dane('nazwisko', $id),
            'firma' => $this->wniosek_model->_get_dane('dg_nazwa', $id),
            'nip' => $this->wniosek_model->_get_dane('dg_nip', $id),
            'ulica' => $this->wniosek_model->_get_dane('ulica', $id),
            'nrdom' => $this->wniosek_model->_get_dane('nrdom', $id),
            'nrlokal' => $this->wniosek_model->_get_dane('nrlokal', $id),
            'kod_pocztowy' => $this->wniosek_model->_get_dane('kod_pocztowy', $id),
            'miejscowosc' => $this->wniosek_model->_get_dane('miejscowosc', $id)
        );
        echo json_encode($array);
    }

    public function edytuj_dane()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        $this->data['meta']['title'] = 'Edycja danych wniosku';
        $this->data['wyksztalcenie'] = $this->_get_wyksztalcenie();
        $this->data['dzieci'] = $this->_get_dzieci();
        $this->data['stan_cywilny'] = $this->_get_stan_cywilny();
        $this->data['mieszkanie'] = $this->_get_mieszkanie();
        $this->data['wojewodztwo'] = $this->_get_wojewodztwo();
        $zmienne = array('id', 'osoba', 'firma', 'nip', 'imie', 'dimie', 'nazwisko', 'nmatki', 'pesel', 'dowod', 'dowod_data', 'karta', 'karta_data', 'karta_kdata', 'ulica', 'kod_pocztowy', 'miejscowosc', 'wojewodztwo', 'korespondencyjny', 'korulica', 'korkod_pocztowy', 'kormiejscowosc', 'korwojewodztwo', 'wyksztalcenie', 'dzieci', 'stan', 'wimie', 'wnazwisko', 'wdochod', 'mieszkanie', 'telefonkom', 'telefonstac', 'telefonsluzb', 'email');
        foreach ($zmienne as $zmienna) {
            $this->data['formularz'][$zmienna] = $this->_get_dane($zmienna, $id);
        }
        $this->load->view('edytuj/dane', $this->data);
    }

    public function edytuj_dochod()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        $this->data['meta']['title'] = 'Edycja źródla dochodu';
        $this->data['wojewodztwo'] = modules::run('wniosek/_get_wojewodztwo');
        $zmienne = array('id', 'uop', 'uop_dochod', 'uop_zawod', 'uop_zatrudnienie', 'uop_kzatrudnienie', 'uop_nieokreslony', 'uop_pracodawca', 'uop_nip', 'uop_telefon', 'uop_preulica', 'uop_ulica', 'uop_nrdom', 'uop_nrlokal', 'uop_kod_pocztowy', 'uop_miejscowosc', 'uop_wojewodztwo', 'sm', 'sm_dochod', 'sm_stanowisko', 'sm_legitymacja', 'sm_zatrudnienie', 'sm_kzatrudnienie', 'sm_nieokreslony', 'sm_pracodawca', 'sm_nip', 'sm_telefon', 'sm_preulica', 'sm_ulica', 'sm_nrdom', 'sm_nrlokal', 'sm_kod_pocztowy', 'sm_miejscowosc', 'sm_wojewodztwo', 'emer', 'emer_dochod', 'emer_legitymacja', 'emer_swiadczenie', 'emer_zatrudnienie', 'renta', 'renta_dochod', 'renta_legitymacja', 'renta_swiadczenie', 'renta_zatrudnienie', 'renta_kzatrudnienie', 'renta_nieokreslony', 'dg_kpr', 'dg_kpr_dochod', 'dg_kpr_nip', 'dg_r', 'dg_r_przychod', 'dg_r_nip', 'dg_kp', 'dg_kp_podatek', 'dg_kp_nip', 'uz', 'uz_dochod', 'uz_zawod', 'uz_zatrudnienie', 'uz_kzatrudnienie', 'uz_pracodawca', 'uz_nip', 'uz_telefon', 'uz_preulica', 'uz_ulica', 'uz_nrdom', 'uz_nrlokal', 'uz_kod_pocztowy', 'uz_miejscowosc', 'uz_wojewodztwo', 'uod', 'uod_dochod', 'uod_zawod', 'uod_zatrudnienie', 'uod_kzatrudnienie', 'uod_pracodawca', 'uod_nip', 'uod_telefon', 'uod_preulica', 'uod_ulica', 'uod_nrdom', 'uod_nrlokal', 'uod_kod_pocztowy', 'uod_miejscowosc', 'uod_wojewodztwo', 'gr', 'gr_zatrudnienie', 'gr_wladanie', 'gr_ilosc', 'gr_urzedy', 'gr_dochod', 'gr_hektary', 'gr_nip', 'un', 'un_dochod', 'un_zatrudnienie', 'un_kzatrudnienie');
        foreach ($zmienne as $zmienna) {
            $this->data['formularz'][$zmienna] = $this->_get_dochod($zmienna, $id);
        }
        $this->load->view('edytuj/dochod', $this->data);
    }

    public function edytuj_parametry()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        $this->data['meta']['title'] = 'Edycja parametrów pożyczki';
        //$this->data['rodzaj'] = $this->_get_rodzaj();
        $zmienne = array('id', 'kwota', 'raty', 'wplata');
        foreach ($zmienne as $zmienna) {
            $this->data['formularz'][$zmienna] = $this->_get_parametry($zmienna, $id);
        }
        $this->load->view('edytuj/parametry', $this->data);
    }

    public function edytuj_zakup()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        $this->data['meta']['title'] = 'Edycja szczegółów zakupu';
        $this->data['formularz']['id'] = $this->_get_zakup('wniosek', $id);
        $this->data['formularz']['wysylka'] = $this->_get_zakup('wysylka', $id);
        $this->data['produkty'] = $this->_get_produkt($id);
        $this->load->view('edytuj/zakup', $this->data);
    }

    public function edytuj_przedmiot()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        $this->data['meta']['title'] = 'Edycja szczegółów leasingu';
//		$this->data['formularz']['id'] = $this->_get_przedmiot('wniosek',$id);
        $this->data['produkty'] = $this->_get_przedmiot($id);
        $this->load->view('edytuj/zakup', $this->data);
    }

    public function archiwum()
    {
        $this->admin();
        $id = $this->uri->segment(3);
        $data['usun'] = '1';
        if ($this->wniosek_model->archiwum($data, $id)) {
            $this->session->set_userdata('notice', 'Wniosek został przeniesiony do archiwum.');
        } else {
            $this->session->set_userdata('error', 'Wniosek nie został przeniesiony do archiwum.');
        }
        redirect(site_url('zarzadzanie/wnioski'));
    }

    public function usun()
    { /* usuwa wniosek - dla administratora*/
        $this->admin();
        $id = $this->uri->segment(3);
        if ($this->_delete_wniosek($id)) {
            $this->session->set_userdata('notice', 'Wniosek został usunięty');
            redirect(site_url('zarzadzanie/wnioski'));
        } else {
            $this->session->set_userdata('error', 'Wniosek nie został usunięty');
            redirect($this->agent->referrer());
        }
    }

    public function zmien_partner()
    {
        $this->admin();
        $id = $this->input->post('wpis');
        $data['partner'] = $this->input->post('partner');
        if ($this->wniosek_model->zmien_partner($data, $id)) {
            $this->session->set_userdata('notice', 'Partner został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Partner nie został zmienony.');
        }
        redirect($this->agent->referrer());
    }

    public function zmien_finansujacy()
    {
        $this->admin();
        $id = $this->input->post('wpis');
        $data['finansujacy'] = $this->input->post('finansujacy');
        if ($this->wniosek_model->zmien_finansujacy($data, $id)) {
            $this->session->set_userdata('notice', 'Finansujący został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Finansujący nie został zmienony.');
        }
        redirect($this->agent->referrer());
    }

    public function export()
    {
        $this->admin();
        $id = $this->uri->segment(3);
        $parameters = $this->_get_parameters($id);
//		$parameters['testowy'] = '1';
        $url = 'http://www.aplikacjakasowa.pl/import-platforma';
        //print_r($parameters);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data) {
            $this->session->set_userdata('notice', 'Wniosek został wyeksportowany do Aplikacji Kasowej.');
        } else {
            $this->session->set_userdata('error', 'Wniosek nie został wyeksportowany.');
        }
        redirect($this->agent->referrer());
    }

    public function finansujacy()
    { /* wyświetlenie wszystkich wniosków w administratorze */
        $this->admin();
        $this->total_rows = $this->_get_finansujacy('all')->num_rows();
        if ($this->total_rows < 1) {
            $this->session->set_userdata('warning', 'Brak finansujących do wyświetlenia.');
        }
        $this->load->paginate();
        $this->data['finansujacy'] = $this->_get_finansujacy();
        $this->load->view('finansujacy', $this->data);
    }

    public function usun_finansujacy()
    {
        $this->admin();
        $id = $this->uri->segment(4);
        if ($this->wniosek_model->usun_finansujacy($id)) {
            $this->session->set_userdata('notice', 'Finansujący został usunięty');
        } else {
            $this->session->set_userdata('error', 'Finansujący nie został usunięty');
        }
        redirect($this->agent->referrer());
    }

    public function zapisz_finansujacy()
    {
        $this->admin();
        $data['nazwa'] = $this->input->post('nazwa');
        $id = $this->input->post('wpis');
        if ($this->wniosek_model->zapisz_finansujacy($data, $id)) {
            $this->session->set_userdata('notice', 'Finansujący został zmieniony.');
        } else {
            $this->session->set_userdata('error', 'Finansujący nie został zmienony.');
        }
        redirect($this->agent->referrer());
    }

    public function _get_finansujacy($limit = NULL)
    {
        return $this->wniosek_model->_get_finansujacy($limit);
    }

    public function _get_parameters($id)
    {
        return $this->wniosek_model->_get_parameters($id);
    }

    public function _get_wnioski($limit = NULL)
    {
        return $this->wniosek_model->_get_wnioski($limit);
    }

    public function _get_wniosek($id)
    {
        return $this->wniosek_model->_get_wniosek($id);
    }

    public function _get_wnioski_by_partner($partner, $limit = NULL)
    {
        return $this->wniosek_model->_get_wnioski_by_partner($partner, $limit);
    }

    public function _get_wniosek_by_partner($id, $partner)
    {
        return $this->wniosek_model->_get_wniosek_by_partner($id, $partner);
    }

    public function _get_status()
    {
        return $this->wniosek_model->_get_status();
    }

    public function wnioski($limit, $status = NULL)
    { /* wyświetla na stronie głównej PAdmina */
        return $this->wniosek_model->_get_wnioski_limit($limit, $status);
    }

    public function wnioski_partner($limit, $partner)
    { /* wyświetla na stronie głównej PAdmina */
        return $this->wniosek_model->_get_wnioski_partner($limit, $partner);
    }

    public function _get_produkt($wniosek)
    {
        return $this->wniosek_model->_get_produkt($wniosek);
    }

    public function _get_rodzaj()
    {
        return $this->wniosek_model->_get_rodzaj();
    }

    public function _get_wyksztalcenie()
    {
        return $this->wniosek_model->_get_wyksztalcenie();
    }

    public function _get_dokument()
    {
        return $this->wniosek_model->_get_dokument();
    }

    public function _get_dzieci()
    {
        return $this->wniosek_model->_get_dzieci();
    }

    public function _get_stan_cywilny()
    {
        return $this->wniosek_model->_get_stan_cywilny();
    }

    public function _get_mieszkanie()
    {
        return $this->wniosek_model->_get_mieszkanie();
    }

    public function _get_wojewodztwo()
    {
        return $this->wniosek_model->_get_wojewodztwo();
    }

    public function _delete_wniosek($id)
    {
        return $this->wniosek_model->_delete_wniosek($id);
    }

    public function rozpocznij_wniosek($data, $zakup = NULL, $produkt = NULL)
    {
        return $this->wniosek_model->rozpocznij_wniosek($data, $zakup, $produkt);
    }

    public function zapisz_dane($data, $id)
    {
        return $this->wniosek_model->zapisz_dane($data, $id);
    }

    public function zapisz_dochod($data, $id)
    {
        return $this->wniosek_model->zapisz_dochod($data, $id);
    }

    public function zapisz_wniosek($data)
    {
        return $this->wniosek_model->zapisz_wniosek($data);
    }

    public function zloz_wniosek($data, $produkt = NULL)
    {
        return $this->wniosek_model->zloz_wniosek($data, $produkt);
    }

    public function zapisz_parametry($data, $id)
    {
        return $this->wniosek_model->zapisz_parametry($data, $id);
    }

    public function zapisz_zakup($wniosek, $zakup, $produkt)
    {
        return $this->wniosek_model->zapisz_zakup($wniosek, $zakup, $produkt);
    }

    public function _get_parametry($rekord, $wniosek)
    {
        return $this->wniosek_model->_get_parametry($rekord, $wniosek);
    }

    public function _get_zakup($rekord, $wniosek)
    {
        return $this->wniosek_model->_get_zakup($rekord, $wniosek);
    }

    public function _get_dane($rekord, $wniosek)
    {
        return $this->wniosek_model->_get_dane($rekord, $wniosek);
    }

    public function _get_dochod($rekord, $wniosek)
    {
        return $this->wniosek_model->_get_dochod($rekord, $wniosek);
    }

    public function generuj()
    {
        ini_set('memory_limit', '8024M');
        ini_set('max_execution_time', 300);
        if ($this->input->post('autoryzacja') != 'generujemy') {
            $this->session->set_userdata('error', 'Hasło jest błędne.');
            redirect($this->agent->referrer());
        }
        $this->load->library('excel');
        $objPHPExcel = new Excel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Platforma Sp z o.o.")
            ->setLastModifiedBy("Platforma Sp z o.o.")
            ->setTitle("Raport Platforma Sp z o.o.")
            ->setSubject("Raport Platforma Sp z o.o.");


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Dane')
            ->setCellValue('B1', 'Adres e-mail')
            ->setCellValue('C1', 'Telefon')
            ->setCellValue('D1', 'PESEL')
            ->setCellValue('E1', 'Klasyfikacja')
            ->setCellValue('F1', 'Status')
            ->setCellValue('G1', 'Wartość towarów')
            ->setCellValue('H1', 'Partner')
            ->setCellValue('I1', 'Data');

        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'height' => 12,
                'indent' => 1
            )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->applyFromArray($style);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(25);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:I1")->getFont()->setBold(true);


        // Miscellaneous glyphs, UTF-8
        $pobierz = $this->wniosek_model->_get_wnioski_raport();
        $i = 2;
        foreach ($pobierz->result() as $dane) {
            $id = $dane->id;
            $partner = NULL;
            if ($dane->partner != 0) {
                $partner = strtoupper(htmlspecialchars_decode($this->load->partner($dane->partner)));
            }
            $partner = mb_convert_case($partner, MB_CASE_UPPER, "UTF-8");
            $nazwisko = $dane->imie . ' ' . $dane->nazwisko;
            $nazwisko = mb_convert_case($nazwisko, MB_CASE_UPPER, "UTF-8");
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $nazwisko)
                ->setCellValue('B' . $i, $dane->email)
                ->setCellValue('C' . $i, $dane->telefonkom)
                ->setCellValue('D' . $i, $dane->pesel)
                ->setCellValue('E' . $i, $dane->klasyfikacja)
                ->setCellValue('F' . $i, $this->load->status($dane->status))
                ->setCellValue('G' . $i, $dane->wartosc)
                ->setCellValue('H' . $i, $partner)
                ->setCellValue('I' . $i, $dane->data);
            $i++;
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Raport Platforma');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $nazwa = 'Raport-Platforma';
        // Redirect output to a client's web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nazwa . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    // integracja z finansową //

    public function curl_wniosek($wniosek)
    {
        return $this->wniosek_model->curl_wniosek($wniosek);
    }

    public function curl_dane($wniosek)
    {
        return $this->wniosek_model->curl_dane($wniosek);
    }

    public function curl_dochod($wniosek)
    {
        return $this->wniosek_model->curl_dochod($wniosek);
    }

    public function curl_zakup($wniosek)
    {
        return $this->wniosek_model->curl_zakup($wniosek);
    }

    public function curl_produkt($wniosek)
    {
        return $this->wniosek_model->curl_produkt($wniosek);
    }

}
