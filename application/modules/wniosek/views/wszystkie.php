<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 
$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li>Lista wniosków</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Lista wniosków</h3>
    </header>
    <div class="hr"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="javascript:void(0);" id="filtrbox" title="Filtruj wnioski"><i class="fa fa-search"></i></a></li>
            <li><a href="<?=site_url('zarzadzanie/finansujacy')?>" title="Zarządzaj finansującymi"><i class="fa fa-credit-card"></i></a></li>
            <li><a href="<?=current_url()?>#raport" title="Generuj raport" rel="facebox"><i class="fa fa-file-excel-o"></i></a></li>
            <li><a href="<?=site_url('zarzadzanie/archiwum')?>" title="Archiwum wniosków"><i class="fa fa-trash"></i></a></li>
        </ul>
	</aside>
    <div id="raport" class="hide">
        <header><h3>Wygeneruj raport</h3></header>
        <form action="<?=site_url('wniosek/generuj')?>" enctype="multipart/form-data" method="post">
			<input type="password" name="autoryzacja" placeholder="Hasło dostępu">
            <input type="submit" value="Wygeneruj raport">
        </form>
    </div>
	<? $this->load->view('filters'); ?>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Wnioskodawca</th>
            <th class="right">Kwota</th>
            <th class="center">Złożone</th>
            <th>Produkt</th>
            <th>Partner</th>
            <th class="center">Aktualizacja</th>
            <th>Status</th>
            <th class="center">Narzędzia</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
        	<? if($dane->rodzaj == '1') { ?>
            <td><strong><a href="<?=site_url('wniosek/'.$dane->id)?>"><?=$this->wnioskodawca($dane->id)?></a></strong></td>
            <? } else { ?>
        	<td><strong><a href="<?=site_url('wniosek/'.$dane->id)?>"><?=$this->wnioskodawca_finansowe($dane->id)?></a></strong></td>
            <? } ?>
            <td class="right nowrap"><?=$this->kwota($dane->kwota)?></td>
            <td class="center"><?=$dane->data?></td>
            <td class="notransform"><?=$this->rodzaj($dane->rodzaj)?><?=$dane->rodzaj == 4?'<br/>'.$dane->nazwa:''?></td>
            <td><?=$this->partner($dane->partner)?></td>
            <td class="center"><?=$dane->aktualizacja?></td>
            <td class="notransform"><?=$this->status($dane->status)?></td>
            <td class="center nowrap">
            	<a href="<?=current_url()?>#status-<?=$dane->id?>" rel="facebox" title="Zmień status wniosku"><i class="fa fa-external-link "></i></a>
        		<a href="<?=current_url()?>#dodaj-notatka-<?=$dane->id?>" rel="facebox" title="Dodaj notatkę"><i class="fa fa-comment"></i></a>
                <a href="<?=site_url('wniosek/'.$dane->id)?>" title="Szczegóły wniosku"><i class="fa fa-eye "></i></a>
			</td>
        </tr>
    <? } ?>
    </table>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

<div class="bottomline"></div>

    <? foreach($pobierz->result() as $dane) { ?>
    	<div id="status-<?=$dane->id?>" class="hide">
        	<header><h3>Zmień status wniosku</h3></header>
            <form action="<?=site_url('wniosek/set_status')?>" enctype="multipart/form-data" method="post">
                <select name="status">
                    <? foreach($statusy->result() as $status) { ?>
                        <option value="<?=$status->id?>"<?=$this->selected($status->id,$dane->status)?>><?=$status->status?></option>
                    <? } ?>
                </select>
                <input type="hidden" name="wpis" value="<?=$dane->id?>">
                <input type="submit" value="Zapisz zmianę">
            </form>
        </div>
        <div id="dodaj-notatka-<?=$dane->id?>" class="hide">
            <header><h3>Dodaj notatkę</h3></header>
            <form action="<?=site_url('notatka/dodaj')?>" enctype="multipart/form-data" method="post">
                <label>Treść notatki</label>
                <textarea name="notatka" required></textarea>
                <label>Dołącz plik</label>
                <input type="file" name="userfile">
                <label>Opis pliku</label>
                <input type="text" name="opis">
                <input type="hidden" name="wniosek" value="<?=$dane->id?>">
                <input type="submit" value="Dodaj notatkę">
            </form>
        </div>
    <? } ?>

<? $this->load->view('supplement/footer'); ?>