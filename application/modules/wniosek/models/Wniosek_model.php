<? defined('BASEPATH') OR exit('No direct script access allowed');

class Wniosek_model extends CI_Model
{

    public function _get_wnioski($limit = NULL)
    { /* pobiera wnioski */
        $this->db->select("*, wniosek.zmiana AS aktualizacja", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->where('active', '1');
        $this->db->where('usun', '0');
        if ($this->session->userdata('filter_wniosek_nazwisko')) {
            $this->db->like('nazwisko', $this->session->userdata('filter_wniosek_nazwisko'));
        }
        if ($this->session->userdata('filter_wniosek_telefon')) {
            $this->db->like('telefonkom', $this->session->userdata('filter_wniosek_telefon'));
        }
        if ($this->session->userdata('filter_wniosek_email')) {
            $this->db->like('email', $this->session->userdata('filter_wniosek_email'));
        }
        if ($this->session->userdata('filter_wniosek_pesel')) {
            $this->db->like('pesel', $this->session->userdata('filter_wniosek_pesel'));
        }
        if ($this->session->userdata('filter_wniosek_data') and $this->session->userdata('filter_wniosek_kdata')) {
            $this->db->where('data >=', $this->session->userdata('filter_wniosek_data') . ' 00:00:00');
            $this->db->where('data <=', $this->session->userdata('filter_wniosek_kdata') . ' 23:59:59');
        } elseif ($this->session->userdata('filter_wniosek_data') and !$this->session->userdata('filter_wniosek_kdata')) {
            $this->db->where('data >=', $this->session->userdata('filter_wniosek_data') . ' 00:00:00');
        } elseif (!$this->session->userdata('filter_wniosek_data') and $this->session->userdata('filter_wniosek_kdata')) {
            $this->db->where('data <=', $this->session->userdata('filter_wniosek_kdata') . ' 23:59:59');
        }
        if ($this->session->userdata('filter_wniosek_partner')) {
            $this->db->where('partner', $this->session->userdata('filter_wniosek_partner'));
        }
        if ($this->session->userdata('filter_wniosek_partner') == 'indywidualny') {
            $this->db->where('partner', '0');
        }
        if ($this->session->userdata('filter_wniosek_status')) {
            $this->db->where('status', $this->session->userdata('filter_wniosek_status'));
        }
        if ($this->session->userdata('filter_wniosek_rodzaj')) {
            $this->db->where('rodzaj', $this->session->userdata('filter_wniosek_rodzaj'));
        }
        $this->db->order_by('wniosek.data', 'DESC');
//		$this->db->where('partner',1579);
        if (!$limit) {
            $start = $this->uri->segment(3);
            $this->db->limit(20, $start);
        }
        return $this->db->get();
    }

    public function _get_wniosek($id)
    { /* pobiera wniosek */
        $rodzaj = $this->load->select('wniosek', 'rodzaj', $id);
        $this->db->select("*", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        if ($rodzaj == '1') {
            $this->db->join('zakup', 'zakup.wniosek = wniosek.id', 'left');
            $this->db->join('dochod', 'dochod.id = wniosek.id', 'left');
        }
        $this->db->where('wniosek.id', $id);
        $this->db->where('wniosek.usun', '0');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $pobierz = $query->result();
            return $pobierz[0];
        } else {
            return false;
        }
    }

    public function _get_wnioski_archiwum($limit = NULL)
    { /* pobiera wnioski */
        $this->db->select("*");
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->where('active', '1');
        $this->db->where('usun', '1');
        $this->db->order_by('wniosek.data', 'DESC');
        if (!$limit) {
            $start = $this->uri->segment(3);
            $this->db->limit(20, $start);
        }
        return $this->db->get();
    }

    public function _get_wniosek_archiwum($id)
    { /* pobiera wniosek */
        $rodzaj = $this->load->select('wniosek', 'rodzaj', $id);
        $this->db->select("*");
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        if ($rodzaj == '1') {
            $this->db->join('zakup', 'zakup.wniosek = wniosek.id', 'left');
            $this->db->join('dochod', 'dochod.id = wniosek.id', 'left');
        }
        $this->db->where('wniosek.id', $id);
        $this->db->where('wniosek.usun', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $pobierz = $query->result();
            return $pobierz[0];
        } else {
            return false;
        }
    }

    public function _get_wnioski_limit($limit, $status = NULL)
    { /* pobiera wnioski z limitem i określonym statusem */
        $this->db->select("*", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->where('active', '1');
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('wniosek.data', 'DESC');
        $this->db->limit($limit);
        return $this->db->get();
    }

    public function _delete_wniosek($id)
    { /*usuwa wniosek */
        if ($this->db->delete('wniosek', array('id' => $id)) and $this->db->delete('dane', array('id' => $id)) and $this->db->delete('dochod', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    public function _get_wnioski_by_partner($partner, $limit = NULL)
    { /* Wnioski pobierane dla partnera */
        $this->db->select("*", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->where('active', '1');
        $this->db->where('partner', $partner);
        $this->db->order_by('wniosek.id', 'DESC');
        $start = $this->uri->segment(3);
        if (!$limit) {
            $this->db->limit(20, $start);
        }
        return $this->db->get();
    }

    public function _get_wniosek_by_partner($id, $partner)
    { /* Wniosek pobierany dla partnera */
        $this->db->select("*", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->join('zakup', 'zakup.wniosek = wniosek.id', 'left');
        $this->db->join('dochod', 'dochod.id = wniosek.id', 'left');
        $this->db->where('wniosek.id', $id);
        $this->db->where('partner', $partner);
        $this->db->order_by('wniosek.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $pobierz = $query->result();
            return $pobierz[0];
        } else {
            return false;
        }
    }

    public function _get_parameters($id)
    {
        $this->db->select("*", false);
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->join('dochod', 'dochod.id = wniosek.id', 'left');
        $this->db->where('wniosek.id', $id);
        $this->db->order_by('wniosek.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $pobierz = $query->result_array();
            return $pobierz[0];
        } else {
            return false;
        }
    }

    public function _get_status()
    { /* Statusy jakie mogą zostać przypisane do wniosku */
        $this->db->select("id,status");
        $this->db->from('status');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _set_status($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('wniosek', $data);
        $status = $this->db->affected_rows();
        if ($data['status'] == 5) {
            modules::run('prowizja/dodaj', $id);
        } else {
            modules::run('prowizja/usun', $id);
        }
        return ($status != 1) ? false : true;
    }

    public function archiwum($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('wniosek', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zmien_partner($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('wniosek', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zmien_finansujacy($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('wniosek', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function _get_wyksztalcenie()
    { /* Wykształcenie - wyświetlane w składanym wniosku */
        $this->db->select("id,wyksztalcenie");
        $this->db->from('wyksztalcenie');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_dokument()
    {
        $this->db->select("id,dokument");
        $this->db->from('dokument');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_dzieci()
    { /* Liczba dzieci - wyświetlane w składanym wniosku */
        $this->db->select("id,dzieci");
        $this->db->from('dzieci');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_stan_cywilny()
    { /* Stan cywilny - wyświetlane w składanym wniosku */
        $this->db->select("id,stan");
        $this->db->from('stan_cywilny');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_mieszkanie()
    { /* Status mieszkaniowy - wyświetlane w składanym wniosku */
        $this->db->select("id,status");
        $this->db->from('mieszkanie');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_rodzaj()
    { /* Rodzaj pożyczki - wyświetlane w składanym wniosku */
        $this->db->select("id,rodzaj");
        $this->db->from('rodzaj');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function _get_wojewodztwo()
    { /* Województwa - wyświetlane w składanym wniosku */
        $this->db->select("id,wojewodztwo");
        $this->db->from('wojewodztwo');
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function rozpocznij_wniosek($data, $zakup = NULL, $produkt = NULL)
    {
        $this->db->insert('wniosek', $data);
        $wniosek['id'] = $this->db->insert_id();
        $this->session->set_userdata('wniosek', $wniosek['id']);
        $this->db->insert('dane', $wniosek);
        $this->db->insert('dochod', $wniosek);
        if ($zakup) {
            $zakup['wniosek'] = $wniosek['id'];
            $this->db->insert('zakup', $zakup);
            $zakup['id'] = $this->db->insert_id();
            if ($produkt) {
                foreach ($produkt as $dane) {
                    $dane['zakup'] = $zakup['id'];
                    $dane['wniosek'] = $wniosek['id'];
                    $this->db->insert('produkt', $dane);
                }
            }
        }
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function _get_parametry($rekord, $wniosek)
    { /* Pobiera rekordy z tabeli wniosek - do formularzy/wniosków */
        $this->db->select($rekord);
        $this->db->from('wniosek');
        $this->db->where('id', $wniosek);
        return $this->db->get()->row()->$rekord;
    }

    public function _get_zakup($rekord, $wniosek)
    { /* Pobiera rekordy z tabeli zakup - do formularzy/wniosków */
        $this->db->select($rekord);
        $this->db->from('zakup');
        $this->db->where('wniosek', $wniosek);
        return $this->db->get()->row()->$rekord;
    }

    public function _get_dane($rekord, $wniosek)
    { /* Pobiera rekordy z tabeli dane - do formularzy/wniosków */
        $this->db->select($rekord);
        $this->db->from('dane');
        $this->db->where('id', $wniosek);
        return $this->db->get()->row()->$rekord;
    }

    public function _get_dochod($rekord, $wniosek)
    { /* Pobiera rekordy z tabeli dochod - do formularzy/wniosków */
        $this->db->select($rekord);
        $this->db->from('dochod');
        $this->db->where('id', $wniosek);
        return $this->db->get()->row()->$rekord;
    }

    public function _get_produkt($wniosek)
    { /* Pobiera rekordy z tabeli dochod - do formularzy/wniosków */
        $rodzaj = $this->load->select('wniosek', 'rodzaj', $wniosek);
        if ($rodzaj == '2') {
            $this->db->select('*');
            $this->db->from('przedmiot');
        } else {
            $this->db->select('produkt,wysylka,ilosc,cena');
            $this->db->from('produkt');
        }
        $this->db->where('wniosek', $wniosek);
        return $this->db->get();
    }

    public function zapisz_dane($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('dane', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zapisz_dochod($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('dochod', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zapisz_wniosek($data)
    {
        $this->db->where('id', $this->session->userdata('wniosek'));
        $this->db->update('wniosek', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zloz_wniosek($data, $produkt = NULL)
    {
        $this->db->insert('wniosek', array('kwota' => $data['kwota'], 'partner' => $data['partner'], 'klasyfikacja' => $data['klasyfikacja'], 'temat' => $data['temat'], 'wiadomosc' => $data['wiadomosc'], 'data' => $data['zmiana'], 'zmiana' => $data['zmiana'], 'status' => '1', 'active' => '1', 'ip' => $data['ip'], 'rodzaj' => $data['rodzaj'], 'nazwa' => $data['nazwa']));
        $id = $this->db->insert_id();
        $this->session->set_userdata('wniosek', $id);
        $this->db->insert('dane', array('id' => $id, 'osoba' => $data['osoba'], 'firma' => $data['firma'], 'nip' => $data['nip'], 'telefonkom' => $data['telefon'], 'email' => $data['email'], 'zmiana' => $data['zmiana']));
        foreach ($produkt as $przedmiot) {
            $this->db->insert('przedmiot', array('wniosek' => $id, 'przedmiot' => $przedmiot['przedmiot'], 'cena' => $przedmiot['cena'], 'stan' => $przedmiot['stan'], 'dostawca' => $przedmiot['dostawca']));
        }
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zapisz_parametry($data, $id)
    {
        $data['oprocentowanie'] = $this->_get_oprocentowanie();
        $prowizja = (($data['oprocentowanie'] * $data['raty']) / 100) * $data['kwota'];
        $brutto = $prowizja + $data['kwota'];
        $data['wRata'] = $brutto / $data['raty'];
        $this->db->where('id', $id);
        $this->db->update('wniosek', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function zapisz_zakup($wniosek, $zakup, $produkt)
    {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->update('wniosek', $wniosek);
        if ($zakup) {
            $this->db->where('wniosek', $this->uri->segment(4));
            $this->db->update('zakup', $zakup);
            if ($produkt) {
                $this->db->delete('produkt', array('wniosek' => $this->uri->segment(4)));
                foreach ($produkt as $dane) {
                    $dane['zakup'] = $this->_get_zakup('id', $this->uri->segment(4));
                    $dane['wniosek'] = $this->uri->segment(4);
                    $this->db->insert('produkt', $dane);
                }
            }
        }
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function _get_oprocentowanie()
    {
        $this->db->select('procent');
        $this->db->from('oprocentowanie');
        return $this->db->get()->row()->procent;
    }

    public function _get_finansujacy($limit = NULL)
    {
        $this->db->select("*");
        $this->db->from('finansujacy');
        $this->db->order_by('id', 'ASC');
        if (!$limit) {
            $start = $this->uri->segment(3);
            $this->db->limit(20, $start);
        }
        return $this->db->get();
    }

    public function zapisz_finansujacy($data, $id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('finansujacy', $data);
        } else {
            $this->db->insert('finansujacy', $data);
        }
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function usun_finansujacy($id)
    {
        if ($this->db->delete('finansujacy', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    public function _get_wnioski_raport()
    { /* pobiera wnioski */
        $this->db->select("*");
        $this->db->from('wniosek');
        $this->db->join('dane', 'dane.id = wniosek.id', 'left');
        $this->db->where('active', '1');
        $this->db->where('usun', '0');
        $this->db->where('rodzaj', '1');
        $this->db->order_by('wniosek.status', 'ASC');
        return $this->db->get();
    }

    // do integracji curl z finansową //

    public function curl_wniosek($wniosek)
    { /* Pobiera rekordy z tabeli wniosek - do formularzy/wniosków */
        $this->db->select();
        $this->db->from('wniosek');
        $this->db->where('id', $wniosek);
        return $this->db->get();
    }

    public function curl_dane($wniosek)
    { /* Pobiera rekordy z tabeli dane - do formularzy/wniosków */
        $this->db->select();
        $this->db->from('dane');
        $this->db->where('id', $wniosek);

        return $this->db->get();
    }

    /**
     * Pobiera rekordy z tabeli dochod - do formularzy/wniosków
     *
     * @param $wniosek
     * @return mixed
     */
    public function curl_dochod($wniosek)
    {
        $this->db->select();
        $this->db->from('dochod');
        $this->db->where('id', $wniosek);

        return $this->db->get();
    }

    /**
     * Pobiera rekordy z tabeli zakup - do formularzy/wniosków
     *
     * @param $wniosek
     * @return mixed
     */
    public function curl_zakup($wniosek)
    {
        $this->db->select('tryb,wysylka');
        $this->db->from('zakup');
        $this->db->where('wniosek', $wniosek);

        return $this->db->get();
    }

    /**
     * Pobiera rekordy z tabeli dochod - do formularzy/wniosków
     *
     * @param $wniosek
     * @return mixed
     */
    public function curl_produkt($wniosek)
    {
        $this->db->select('id,nazwa,produkt,ilosc,wysylka,cena');
        $this->db->from('produkt');
        $this->db->where('wniosek', $wniosek);

        return $this->db->get();
    }

}