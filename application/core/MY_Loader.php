<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	function potwierdzenie() {
		if($this->komunikat()) {
			return 
			'<script type="text/javascript">
			(function() {
				  $(function() {
					  '.$this->komunikat().'
				  });
			}).call(this);
			</script>';
		} else { return false; }
	}
	
	function komunikat() {
		$wynik = NULL;
		if($this->session->userdata('notice')) {
			$wynik = '$.growl.notice({title: "Potwierdzenie",message: "'.$this->session->userdata('notice').'", duration:5000,size:"large"});';
		}
		if($this->session->userdata('error')) {
			$wynik .= '$.growl.error({title: "Błąd wykonania",message: "'.$this->session->userdata('error').'", duration:15000,size:"large"});';
		}		
		if($this->session->userdata('warning')) {
			$wynik .= '$.growl.warning({title: "Uwaga!",message: "'.$this->session->userdata('warning').'", duration:8000,size:"large"});';
		}
		if($wynik) { return $wynik; } else {return false; }
	}
	
	function administrator($id) {
		 $login = $this->load->select('admin','login',$id);
		 if($login) {
			return '<a href="'.site_url('administrator/historia/'.$id).'" title="Historia administracyjna">'.$login.' (ID: '.$id.')</a>'; 
		 } else {
			return '<a href="'.site_url($id).'" title="Historia administracyjna"><em>brak informacji</em> (ID: '.$id.')</a>'; 
		 }
	}
	
    public function _curl($url, $method = 'unserialize')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('klucz' => 'abc'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        if ('unserialize' === $method) {
            @$wynik = unserialize($data);
        } else if ('json' === $method) {
            @$wynik = json_decode($data);
        } else {
            @$wynik = $data;
        }

        curl_close($ch);

        return $wynik;
    }
	
    function oprocentowaniePartner($id)
    {
        $wynik = $this->_curl('https://www.platformafinansowa.pl/oprocentowanie/partner/pokaz/' . $id, 'unserialize');
        return $wynik['oprocentowanie'];
    }

    function oprocentowanie()
    {
        $wynik = $this->_curl('https://www.platformafinansowa.pl/oprocentowanie/pokaz', 'unserialize');
        return $wynik['procent'];
    }

    function finansowa_ustawienie($name)
    {
        return $this->_curl('https://www.platformafinansowa.pl/pokaz_ustawienie/' . $name, 'none');
    }

    function oprocentowanie_przedzialy()
    {
        $wynik = $this->_curl('https://www.platformafinansowa.pl/oprocentowanie/pokaz', 'json');
        return $wynik;
    }

    function ubezpieczenie()
    {
        $wynik = $this->_curl('https://www.platformafinansowa.pl/ubezpieczenie/pokaz', 'unserialize');
        return $wynik['procent'];
    }
	
    public function partner($id)
    {
        if (!$id) {
            return '<span class="grey">wniosek indywidualny</span>';
        }
        $wynik = modules::run('partners/finansowa_dane', $id);
        if ($wynik) {
            return $wynik['nazwa'];
        } else {
            return '<span class="red">Partner nie istnieje w bazie</span>';
        }
    }
	
    public function wnioskodawca($id)
    {
        if (!$id) {
            return NULL;
        }
        $this->db->select("CONCAT(imie, ' ', dimie, ' ',nazwisko) AS wnioskodawca", false);
        $this->db->from('dane');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->wnioskodawca;
        } else {
            return 'brak informacji';
        }
    }

    public function wnioskodawca_finansowe($id)
    {
        if (!$id) {
            return NULL;
        }
        $this->db->select("firma,osoba", false);
        $this->db->from('dane');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($query->row()->firma) {
                return $query->row()->firma;
            } else {
                return $query->row()->osoba;
            }
        } else {
            return 'brak informacji';
        }
    }

    public function kwota($kwota)
    {
        return number_format($kwota, 2, '.', ',') . ' PLN';
    }
	
    function selectdirect($tabela, $rekord, $direct, $id)
    {
        $this->db->select($rekord);
        $this->db->from($tabela);
        $this->db->where($direct, $id);
        $pobierz = $this->db->get();
        if ($pobierz->num_rows() > 0) {
            return $pobierz->row()->$rekord;
        } else {
            return NULL;
        }
    }
	
	function active($var,$compare) {
		if($var == $compare) {
			return ' class="active"';
		}
	}

	function status($status) {
		switch($status) {
			case 1: $result = 'opublikowane'; break;
			default: $result = '<span class="grey">nieopublikowane</span>';
		}
		return $result;
	}
	
	function statusview($status) {
		switch($status) {
			case 1: $result = ''; break;
			default: $result = ' class="deactivated"';
		}
		return $result;
	}
	
	function url($var) {
		return url_title(convert_accented_characters($var),'-',false);
	}
	
	function blog_link($id) {
		$title = $this->load->select('blog','title',$id);
		$link = 'blog/'.url_title(convert_accented_characters($id.' '.$title),'dash',true);
		return site_url($link);
	}

	function subsite_link($id,$lang=NULL) {
		if($this->load->select('podstrona','url',$id) == NULL) {
			$link = url_title(convert_accented_characters(($this->load->select('podstrona','header',$id))),'dash',true);
			$link = $link.'-p-'.$id;
		} else {
			$link = $this->load->select('podstrona','url',$id);
		}
		if($id == '1') {
			$link = NULL;
		}
		return site_url($link);
	}
	
	function replace($content) {
		$searchReplaceArray = array();
		if(strpos($content,'%formularz_kontakt%') !== false) {
			$searchReplaceArray['%formularz_kontakt%'] = $this->load->view('formularz-kontakt','',true);
		}
		$content = str_replace(
		  array_keys($searchReplaceArray), 
		  array_values($searchReplaceArray), 
		  $content
		);
		return $content;
	}
		
	function data($data,$hour=NULL) {
		$dzien 		= date("j",strtotime($data)); 
		$miesiac 	= date("n",strtotime($data));
		$tmpMiesiac = array('', 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia' );
		$miesiac = $tmpMiesiac[ $miesiac ];
		$rok 		= date("Y",strtotime($data));
		$godzina = date("H",strtotime($data));
		$minuta = date("i",strtotime($data));
		if($hour == true) {
			return $dzien.' '.$miesiac.' '.$rok. ', '. $godzina. ':' .$minuta;
		} else {
			return $dzien.' '.$miesiac.' '.$rok;
		}
	}
	
	function day($data) {
		$dzien 		= date("N",$data); 
		$tmpDzien = array('', 'poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota', 'niedziela');
		$dzien = $tmpDzien[ $dzien ];
		return $dzien;
	}
	
	function programdata($data) {
		$dnia 		= date("j",$data); 
		$dzien 		= date("N",$data); 
		$tmpDzien = array('', 'poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota', 'niedziela');
		$dzien = $tmpDzien[ $dzien ];
		$miesiac 	= date("n",$data);
		$tmpMiesiac = array('', 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia' );
		$miesiac = $tmpMiesiac[ $miesiac ];
		$rok 		= date("Y",$data);
		$godzina = date("H",$data);
		$minuta = date("i",$data);
		return $dzien.', '.$dnia.' '.$miesiac;
	}
	
	function czysc() {
		$this->session->unset_userdata('notice');
		$this->session->unset_userdata('error');
		$this->session->unset_userdata('warning');
	}
	
	function select($tabela,$rekord,$id) {
		$this->db->select($rekord);
		$this->db->from($tabela);
		$this->db->where('id',$id);
		$pobierz = $this->db->get();
		if($pobierz->num_rows() > 0) {
			return $pobierz->row()->$rekord;
		} else { return NULL; }
	}
	
	function direct($tabela,$rekord,$where,$id) {
		$this->db->select($rekord);
		$this->db->from($tabela);
		$this->db->where($where,$id);
		$pobierz = $this->db->get();
		if($pobierz->num_rows() > 0) {
			return $pobierz->row()->$rekord;
		} else { return NULL; }
	}
	
	public function selected($var,$compare) {
		if($var == $compare) { return ' selected'; }
	}
	
	public function checked($var,$compare) {
		if($var == $compare) { return ' checked'; }
	}
	
	public function paginate() { /* paginacja wyników */
		$this->load->library('pagination');
		$config['base_url'] = '/'.$this->uri->segment(1).'/'.$this->uri->segment(2);
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->total_rows;
		$config['per_page'] = 10;
		$config['num_links'] = 5;
		return $this->pagination->initialize($config);
	}
	
	public function array_sort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();
	
		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}
	
			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}
	
			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}
	
		return $new_array;
	}
	
}