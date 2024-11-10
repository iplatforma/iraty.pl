<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li>Wnioski ubezpieczeniowe</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Wnioski ubezpieczeniowe</h3>
    </header>
    <ul class="submenu">
    	<li><a href="<?=site_url('ubezpieczenie/dodaj')?>">Złóż wniosek</a></li>
	</ul>
    <div class="hr"></div>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Ubezpieczony</th>
            <th>Deklaracja</th>
            <th class="right">Kwota</th>
            <th>Telefon/e-mail</th>
            <th class="center">Złożone</th>
            <th class="center">Szczegóły</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
        	<td><strong><a href="<?=site_url('partner/ubezpieczenie/'.$dane->id)?>"><?=$dane->imie.' '.$dane->nazwisko.' '.$dane->nazwa?></a></strong></td>
            <td class="right nowrap"><?=$dane->deklaracja?></td>
            <td class="right nowrap"><?=$this->kwota($dane->wartosc)?></td>
            <td><?=$dane->telefon.' '.$dane->email?></td>
            <td class="center"><?=$dane->data_zlozenia?></td>
            <td class="center nowrap">
                <a href="<?=site_url('partner/ubezpieczenie/'.$dane->id)?>" title="Szczegóły wniosku"><i class="fa fa-eye "></i></a>
			</td>
        </tr>
    <? } ?>
    </table>
    <? if($pobierz->num_rows() < 1) { ?><p>Nie masz żadnych wniosków.</p><? } ?>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>