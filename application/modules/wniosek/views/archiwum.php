<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 
$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li>Archiwum wniosków</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Archiwum wniosków</h3>
    </header>
    <div class="hr"></div>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Wnioskodawca</th>
            <th class="right">Kwota</th>
            <th class="center">Złożone</th>
            <th>Produkt</th>
            <th>Partner</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
        	<? if($dane->rodzaj == '1') { ?>
            <td><strong><a href="<?=site_url('archiwum/wniosek/'.$dane->id)?>"><?=$this->wnioskodawca($dane->id)?></a></strong></td>
            <? } else { ?>
        	<td><strong><a href="<?=site_url('archiwum/wniosek/'.$dane->id)?>"><?=$this->wnioskodawca_finansowe($dane->id)?></a></strong></td>
            <? } ?>
            <td class="right"><?=$this->kwota($dane->kwota)?></td>
            <td class="center"><?=$dane->data?></td>
            <td class="notransform"><?=$this->rodzaj($dane->rodzaj)?></td>
            <td><?=$this->partner($dane->partner)?></td>
        </tr>
    <? } ?>
    </table>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>