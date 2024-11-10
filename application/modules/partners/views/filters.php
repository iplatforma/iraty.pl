<? defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="filtr" class="partner">
    <form action="<?=site_url('partner/filtruj')?>" enctype="multipart/form-data" method="post">
        <div class="form"><label>Nazwa partnera</label><input type="text" name="filter_partner_nazwa"value="<?=$this->session->userdata('filter_partner_nazwa')?>"></div>
        <div class="form"><label>NIP</label><input type="text" name="filter_partner_nip"value="<?=$this->session->userdata('filter_partner_nip')?>"></div>
        <div class="form"><label>Telefon</label><input type="text" name="filter_partner_telefon"value="<?=$this->session->userdata('filter_partner_telefon')?>"></div>
        <div class="form"><label>Adres e-mail</label><input type="text" name="filter_partner_email"value="<?=$this->session->userdata('filter_partner_email')?>"></div>
        <div class="form">
        	<label>Opiekun</label>
            <select name="filter_partner_opiekun">
            	<option value=""></option>
            </select>
        </div>
        <div class="form">
        	<label>Status</label>
            <select name="filter_partner_status">
            	<option value="0">wszystkie</option>
                <option value="1"<?=$this->selected('1',$this->session->userdata('filter_partner_status'))?>>zablokowany</option>
            	<option value="2"<?=$this->selected('2',$this->session->userdata('filter_partner_status'))?>>aktywny</option>
            </select>
		</div>
        <div class="form"><label>&nbsp;</label><input type="submit" value="Filtruj partnerów"></div>
    </form>
	<a href="<?=site_url('partner/filtruj')?>" id="clearbox" title="Resetuj filtrowanie"><i class="fa fa-search-minus"></i>Wyczyść filtrowanie</a>
    <a href="javascript:void(0);" id="closebox" title="Zamknij okno"><i class="fa fa-times"></i></a>
</div>
<ul class="filters">
	<? if($this->session->userdata('filter_partner_nazwa')) { ?>
    	<li><span>nazwa:</span> <?=$this->session->userdata('filter_partner_nazwa')?><a href="<?=site_url('partner/filtr/usun/nazwa')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_partner_telefon')) { ?>
    	<li><span>telefon:</span> <?=$this->session->userdata('filter_partner_telefon')?><a href="<?=site_url('partner/filtr/usun/telefon')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_partner_email')) { ?>
    	<li><span>e-mail:</span> <?=$this->session->userdata('filter_partner_email')?><a href="<?=site_url('partner/filtr/usun/email')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_partner_nip')) { ?>
    	<li><span>nip:</span> <?=$this->session->userdata('filter_partner_nip')?><a href="<?=site_url('partner/filtr/usun/nip')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_partner_opiekun')) { ?>
    	<li><span>opiekun:</span> <?=$this->session->userdata('filter_partner_opiekun')?><a href="<?=site_url('partner/filtr/usun/opiekun')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
	<? if($this->session->userdata('filter_partner_status')) { ?>
    	<li><span>status:</span> <?=$this->load->partner_status($this->session->userdata('filter_partner_status'))?><a href="<?=site_url('partner/filtr/usun/status')?>" title="Usuń filtr"><i class="fa fa-times"></i></a></li>
	<? } ?>
</ul>
