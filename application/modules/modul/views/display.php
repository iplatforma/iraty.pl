<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Moduły podstrony "<?=modules::run('podstrona/pobierz',$this->uri->segment(2))->header?>"</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('zarzadzanie/podstrona')?>" class="button icon"><i class="fa fa-arrow-left"></i> Cofnij</a>
        	<a href="<?=site_url('modul/'.$this->uri->segment(2).'/dodaj')?>" class="button icon"><i class="fa fa-plus"></i> Dodaj moduł</a>
            <a href="<?=$this->subsite_link($this->uri->segment(2))?>" class="button icon" target="_blank"><i class="fa fa-eye"></i> Podgląd podstrony</a>
        </aside>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Nazwa modułu</th>
                <th>Typ</th>
                <th>Background</th>
                <th>Priorytet [0-999]</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr>
            	<td><?=$dane->header?></td>
            	<td><?=$dane->type=='bg'?'Z tłem':($dane->type=='package'?'Pakiet':($dane->type=='news'?'Aktualności':'Treść'))?></td>
            	<td><? if($dane->background) { ?><a href="<?=assets('img/background/'.$dane->background)?>" rel="galeria"><i class="fa fa-eye"></i></a><? } else { ?>---<? } ?></td>
                <td class="right"><span class="grey"><?=$dane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$dane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fa fa-arrows-alt"></i></a></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj moduł"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj moduł"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <? if($dane->type=='bg') { ?><a href="<?=current_url()?>#background-<?=$dane->id?>" rel="facebox" title="Edytuj tło"><i class="fa fa-desktop"></i></a><? } ?>
                        <? if($dane->type=='package') { ?>
	                        <a href="<?=current_url()?>#konfigurator-<?=$dane->id?>" rel="facebox" title="Edytuj pakiet"><i class="fa fa-edit"></i></a>
						<? } else { ?>
                        	<a href="<?=site_url('modul/edytuj/'.$dane->id)?>" title="Edytuj treść modułu"><i class="fa fa-edit"></i></a>
                        <? } ?>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń moduł"><i class="fa fa-times"></i></a>
                    </aside>
				</td>
			</tr>
            <? } ?>
        </table>
		<? foreach($pobierz->result() as $dane) { ?>
			<? if($dane->status == 0) { ?>
            <div id="aktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-on"></i>
                <p>Czy jesteś pewien, że chcesz aktywować wybraną moduł?</p>
                <p><a href="<?=site_url('modul/status/'.$dane->id.'/1')?>">Tak, aktywuj moduł!</a></p>
            </div>
    	    <? } else { ?>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybraną moduł?</p>
                <p><a href="<?=site_url('modul/status/'.$dane->id.'/0')?>">Tak, dezaktywuj moduł!</a></p>
            </div>
			<? } ?>
        	<? if($dane->type=='bg') { ?>
            <div class="hide" id="background-<?=$dane->id?>">
            	<header><h3>Edytuj tło</h3></header>
                <form action="<?=site_url('modul/tlo/dodaj')?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="zdjecie">
                    <label class="checkbox" for="parallax"><input type="checkbox" id="parallax" name="parallax" value="1" <?=$dane->parallax=='1'?' checked':NULL?>> Z efektem parallax</label>
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz tło">
                </form>
                <? if($dane->background) { ?><p class="full">lub <a href="<?=site_url('modul/tlo/usun/'.$dane->id)?>" title="Usuń zdjęcie tła">usuń zdjęcie tła</a>.</p><? } ?>
            </div>
            <? } ?>
        	<? if($dane->type=='package') { ?>
                <div class="hide" id="konfigurator-<?=$dane->id?>">
                    <header><h3>Zmień pakiet</h3></header>
                    <form action="<?=site_url('modul/zapisz')?>" method="post" enctype="multipart/form-data">
                        <select name="package">
                            <? foreach(modules::run('konfigurator/pobierz')->result() as $pakiet) { ?>
                            <option value="<?=$pakiet->id?>"<?=$this->selected($dane->package,$pakiet->id)?>><?=$pakiet->kategoria?></option>
                            <?  } ?>
                        </select>
                        <input type="hidden" name="typ" value="package">
                        <input type="hidden" name="site" value="<?=$dane->site?>">
                        <input type="hidden" name="wpis" value="<?=$dane->id?>">
                        <input type="submit" value="Zmień pakiet">
                    </form>
                </div>
			<? } ?>
           <div id="zmien-priorytet-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('modul/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                    <label>Większa liczba określa wyższą pozycję</label>
                    <input type="text" name="order" placeholder="Priorytet" value="<?=$dane->order?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zmień priorytet">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń moduł</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć moduł?</p>
                <p><a href="<?=site_url('modul/usun/'.$dane->id)?>">Tak, usuń moduł!</a></p>
            </div>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>