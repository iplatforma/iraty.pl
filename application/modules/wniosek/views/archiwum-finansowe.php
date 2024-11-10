<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li><a href="<?=site_url('zarzadzanie/archiwum')?>">Archiwum wniosków</a></li><li>Wniosek</li></ul></section>

<article id="content" class="admin">
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#usun" rel="facebox" title="Usuń wniosek"><i class="fa  fa-close"></i></a></li>
        </ul>
    </aside>
    <div id="usun" class="hide">
    	<header><h3>Usuń wniosek</h3></header>
        <i class="fa  fa-close"></i>
        <p>Czy jesteś pewien, że chcesz usunąć wniosek <strong><?=$this->wnioskodawca_finansowe($dane->id)?></strong>?</p>
        <p><a href="<?=site_url('wniosek/usun/'.$dane->id)?>">Tak, usuń wniosek!</a></p>
    </div>
	<header>
    	<h3>Wniosek finansowy</h3>
    </header>   
    <ul class="submenu">
    	<? if($dane->rodzaj == '2') { ?><li><a href="#szczegoly-zakupu">Szczegóły leasingu</a></li><?  } ?>
        <li><a href="#notatki">Notatki</a></li>
        <li><a href="#dokumenty">Dokumenty</a></li>
        <li><a href="#historia-administracyjna">Historia administracyjna</a></li>
    </ul>
    <div class="hr less"></div>
	<p><?=$this->wnioskodawca_finansowe($this->uri->segment(2))?> (<?=$this->status($dane->status)?>)</p>
       
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Typ wniosku</td>
            <td><?=$this->rodzaj($dane->rodzaj)?></td>
            <td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>            
        </tr>
    	<tr>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        	<td class="header">Partner</td>
            <td><?=$this->partner($dane->partner)?></td>
		</tr>
        <tr>
        	<td class="header">Prowizja:</td>
            <td><?=$dane->prowizja?></td>
        	<td class="header">Finansujący</td>
            <td><?=$this->finansujacy($dane->finansujacy)?></td>
        </tr>
        <tr>
        	<td class="header">Notatka:</td>
            <td colspan="3"><?=$dane->notatka?></td>
        </tr>
    	<tr>
        	<td class="header">IP wnioskodawcy</td>
            <td colspan="3"><?=$dane->ip?></td>
        </tr>
        <? if($dane->rodzaj == '2') { ?>
	   	<tr>
        	<td class="header">Nazwa firmy</td>
            <td><?=$dane->firma?></td>
        	<td class="header">NIP</td>
            <td><?=$dane->nip?></td>
        </tr>
		<? } ?>        
	   	<tr>
        	<td class="header">Osoba kontaktowa</td>
            <td><?=$dane->osoba?></td>
        	<td class="header">Telefon</td>
            <td><?=$dane->telefonkom?></td>
        </tr>
	   	<tr>
        	<td class="header">Adres e-mail</td>
            <td><?=$dane->email?></td>
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?></td>
        </tr>
    	<tr>
        	<td class="header">Dodatkowe informacje</td>
            <td colspan="3"><?=$dane->dodatkowe?></td>
        </tr>
    </table>

	<? if($dane->rodzaj == '2') { ?>
    <header><h4>Szczegóły leasingu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane wniosek">
        <? $lacznie = 0; foreach($produkty->result() as $produkt) {?>
        <tr>
        	<td class="header">Produkt</td>
            <td class="notransform"><a href="<?=prep_url($produkt->przedmiot)?>" target="_blank"><?=$produkt->przedmiot?></a></td>
        	<td class="header">Cena</td>
            <td><?=$this->kwota($produkt->cena)?></td>
        </tr>
        <tr>
        	<td class="header">Stan</td>
            <td class="notransform"><?=$produkt->stan?></td>
        	<td class="header">Stawka amortyzacji</td>
            <td class="notransform"><?=$produkt->amortyzacja?></td>
        </tr>
        <tr>
        	<td class="header">Dostawca</td>
            <td colspan="3"><?=$produkt->dostawca?></td>
        </tr>
        <?
        	$lacznie = $lacznie + $produkt->cena;
		} 
		?>
        <tr>
        	<td colspan="2"></td>
        	<td class="header">Łącznie</td>
            <td class="header"><?=$this->kwota($lacznie)?></td>
        </tr>
    </table>
    <? } ?>
    
    <header><h4>Notatki<a name="notatki"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Notatka</th>
            <th>Opis pliku</th>
            <th>Administrator</th>
        </tr>
    <? foreach($notatka->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><?=$dane->notatka?></td>
            <td><a href="<?=site_url('assets/files/notes/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        </tr>
    <? } ?>
    </table>

    <header><h4>Dokumenty<a name="dokumenty"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Nazwa pliku</th>
            <th>Administrator</th>
        </tr>
    <? foreach($dokumenty->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><a href="<?=site_url('assets/files/documents/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        </tr>
    <? } ?>
    </table>

    <header><h4>Historia administracyjna<a name="historia-administracyjna"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Administrator</th>
            <th>Wykonane zadanie</th>
        </tr>
    <? foreach($historia->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
            <td><a href="<?=site_url('historia/'.$dane->admin)?>"><?=$this->admin($dane->admin)?></a></td>
        	<td><?=$dane->zadanie?></td>
        </tr>
    <? } ?>
    </table>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>