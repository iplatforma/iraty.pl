<? defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="filtr">
    <form action="<?=site_url('wniosek/filtruj')?>" enctype="multipart/form-data" method="post">
        <div class="form"><label>Nazwisko</label><input type="text" name="filter_wniosek_nazwisko" value="<?=$this->session->userdata('filter_wniosek_nazwisko')?>"></div>
        <div class="form"><label>Telefon</label><input type="text" name="filter_wniosek_telefon" value="<?=$this->session->userdata('filter_wniosek_telefon')?>"></div>
        <div class="form"><label>Adres e-mail</label><input type="text" name="filter_wniosek_email" value="<?=$this->session->userdata('filter_wniosek_email')?>"></div>
        <div class="form"><label>PESEL</label><input type="text" name="filter_wniosek_pesel" value="<?=$this->session->userdata('filter_wniosek_pesel')?>"></div>
        <div class="form"><label>Wnioski złożone od</label><input type="text" name="filter_wniosek_data" class="data" value="<?=$this->session->userdata('filter_wniosek_data')?>" placeholder="RRRR-MM-DD"></div>
        <div class="form"><label>Wnioski złożone do</label><input type="text" name="filter_wniosek_kdata" class="data" value="<?=$this->session->userdata('filter_wniosek_kdata')?>" placeholder="RRRR-MM-DD"></div>
        <div class="form">
        	<label>Partner</label>
            <select name="filter_wniosek_partner">
            	<option value="0">wszyscy</option>
            	<option value="indywidualny"<?=$this->selected('indywidualny',$this->session->userdata('filter_wniosek_partner'))?>>wniosek indywidualny</option>
                <? foreach($partnerzy['partner'] as $partner) {?>
                <option value="<?=$partner['id']?>"<?=$this->selected($partner['id'],$this->session->userdata('filter_wniosek_partner'))?>><?=$partner['nazwa']?></option>
                <? } ?>
            </select>
        </div>
        <div class="form">
        	<label>Status</label>
            <select name="filter_wniosek_status">
            	<option value="0">wszystkie</option>
				<? foreach($statusy->result() as $status) { ?>
                    <option value="<?=$status->id?>"<?=$this->selected($status->id,$this->session->userdata('filter_wniosek_status'))?>><?=$status->status?></option>
                <? } ?>
            </select>
		</div>
        <div class="form">
        	<label>Rodzaj finansowania</label>
        	<select name="filter_wniosek_rodzaj">
        		<option value="0">wszystkie</option>
        		<option value="1"<?=$this->selected('1',$this->session->userdata('filter_wniosek_rodzaj'))?>>raty</option>
        		<option value="2"<?=$this->selected('2',$this->session->userdata('filter_wniosek_rodzaj'))?>>leasing</option>
        		<option value="3"<?=$this->selected('3',$this->session->userdata('filter_wniosek_rodzaj'))?>>gotówka</option>
        		<option value="4"<?=$this->selected('4',$this->session->userdata('filter_wniosek_rodzaj'))?>>pozostałe</option>
			</select>
		</div>
        <div class="form"><input type="submit" value="Filtruj wnioski"></div>
    </form>
    <a href="<?=site_url('wniosek/filtruj')?>" id="clearbox" title="Resetuj filtrowanie"><i class="fa fa-search-minus"></i>Wyczyść filtrowanie</a>
    <a href="javascript:void(0);" id="closebox" title="Zamknij okno"><i class="fa fa-times"></i></a>
</div>
<ul class="filters">
	<? if($this->session->userdata('filter_wniosek_nazwisko')) { ?>
    	<li><span>nazwisko:</span> <?=$this->session->userdata('filter_wniosek_nazwisko')?><a href="<?=site_url('wniosek/filtr/usun/nazwisko')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_telefon')) { ?>
    	<li><span>telefon:</span> <?=$this->session->userdata('filter_wniosek_telefon')?><a href="<?=site_url('wniosek/filtr/usun/telefon')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_email')) { ?>
    	<li><span>e-mail:</span> <?=$this->session->userdata('filter_wniosek_email')?><a href="<?=site_url('wniosek/filtr/usun/email')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_pesel')) { ?>
    	<li><span>pesel:</span> <?=$this->session->userdata('filter_wniosek_pesel')?><a href="<?=site_url('wniosek/filtr/usun/pesel')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_data')) { ?>
    	<li><span>data od:</span> <?=$this->session->userdata('filter_wniosek_data')?><a href="<?=site_url('wniosek/filtr/usun/data')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_kdata')) { ?>
    	<li><span>data do:</span> <?=$this->session->userdata('filter_wniosek_kdata')?><a href="<?=site_url('wniosek/filtr/usun/kdata')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_partner')) { ?>
    	<? if($this->session->userdata('filter_wniosek_partner') == 'indywidualny') { ?>
	    	<li><span>partner:</span> wniosek indywidualny<a href="<?=site_url('wniosek/filtr/usun/partner')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>    
        <? } else {?>
	    	<li><span>partner:</span> <?=$this->partner($this->session->userdata('filter_wniosek_partner'))?><a href="<?=site_url('wniosek/filtr/usun/partner')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
         <? } ?>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_status')) { ?>
    	<li><span>status:</span> <?=$this->status($this->session->userdata('filter_wniosek_status'))?><a href="<?=site_url('wniosek/filtr/usun/status')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_wniosek_rodzaj')) { ?>
    	<li><span>rodzaj:</span> <?=$this->rodzaj($this->session->userdata('filter_wniosek_rodzaj'))?><a href="<?=site_url('wniosek/filtr/usun/rodzaj')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
</ul>
