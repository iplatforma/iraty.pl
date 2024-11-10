<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li>Lista wniosków</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Wnioski klientów</h3>
    </header>
    <ul class="submenu">
       <li><a href="<?=site_url('wniosek/raty/'.$this->session->userdata('partner'))?>">Wniosek ratalny</a></li>
       <li><a href="<?=site_url('wniosek/leasing/'.$this->session->userdata('partner'))?>">Wniosek o leasing</a></li>
       <li><a href="<?=site_url('wniosek/kredyt-gotowkowy/'.$this->session->userdata('partner'))?>">Wniosek o gotówkę</a></li>
    	<? if($this->select('partner','assistance',$this->session->userdata('partner')) == 1) { ?><li><a href="<?=site_url('ubezpieczenie/dodaj')?>">Wniosek ubezpieczeniowy</a></li><? } ?>
	</ul>
    <div class="hr"></div>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Wnioskodawca</th>
            <th class="right">Kwota pożyczki</th>
            <th class="center">Data złożenia</th>
            <th>Typ wniosku</th>
            <th>Status</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
        	<? if($dane->rodzaj == '1') { ?>
            <td><strong><a href="<?=site_url('partner/wniosek/'.$dane->id)?>"><?=$this->wnioskodawca($dane->id)?></a></strong></td>
            <? } else { ?>
        	<td><strong><a href="<?=site_url('partner/wniosek/'.$dane->id)?>"><?=$this->wnioskodawca_finansowe($dane->id)?></a></strong></td>
            <? } ?>
        	<td class="right"><?=$this->kwota($dane->kwota)?></td>
            <td class="center"><?=$dane->data?></td>
            <td><?=$this->rodzaj($dane->rodzaj)?></td>
            <td><?=$this->status($dane->status)?></td>        </tr>    	
    <? } ?>
    </table>
    <? if($pobierz->num_rows() < 1) { ?><p>Nie masz żadnych wniosków.</p><? } ?>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>