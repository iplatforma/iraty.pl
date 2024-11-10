<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie podstronami</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('podstrona/dodaj')?>" class="button icon"><i class="fa fa-plus"></i> Dodaj stronę</a>
        </aside>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Nazwa strony</th>
            	<th>Nazwa podstrony</th>
                <th>Priorytet [0-999]</th>
                <th>Ilość modułów</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr>
            	<td><?=$dane->header?></td>
                <td>---</td>
                <td class="right"><span class="grey"><?=$dane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$dane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fa fa-arrows-alt"></i></a></td>
                <td><?=modules::run('modul/pobierz',$dane->id)->num_rows()?></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj stronę"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj stronę"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <? if(modules::run('modul/pobierz',$dane->id)->num_rows() > 0) { ?><a href="<?=$this->subsite_link($dane->id)?>" title="Podgląd podstrony" target="_blank"><i class="fa fa-eye"></i></a><? } ?>
                        <? if($dane->menu) { ?><a href="<?=site_url('podstrona/dodaj/'.$dane->id)?>" title="Dodaj podstronę"><i class="fa fa-plus"></i></a><? } ?>
                        <a href="<?=site_url('podstrona/edytuj/'.$dane->id)?>" title="Edytuj dane podstrony"><i class="fa fa-edit"></i></a>
                        <a href="<?=site_url('modul/'.$dane->id)?>" title="Edytuj treść podstrony"><i class="fa fa-bars"></i></a>
                        <? if($dane->system=='0') { ?><a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń podstronę"><i class="fa fa-times"></i></a><? } ?>
                    </aside>
				</td>
			</tr>
				<? foreach(modules::run('podstrona/parent',$dane->id)->result() as $parent) { ?>
                <tr>
                    <td class="right"><span class="grey"><?=$parent->parent?modules::run('podstrona/pobierz',$parent->parent)->header:NULL?></span></td>
                    <td><?=$parent->header?></td>
	                <td class="right"><span class="grey"><?=$parent->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$parent->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fa fa-arrows-alt"></i></a></td>
	                <td><?=modules::run('modul/pobierz',$parent->id)->num_rows()?></td>
                    <td class="settings">
                        <aside class="admin">
							<? if($parent->status == 0) { ?>
                            <a href="<?=current_url()?>#aktywuj-<?=$parent->id?>" rel="facebox" title="Aktywuj podstronę"><i class="fa fa-toggle-on"></i></a>
                            <? } else { ?>
                            <a href="<?=current_url()?>#dezaktywuj-<?=$parent->id?>" rel="facebox" title="Dezaktywuj podstronę"><i class="fa fa-toggle-off"></i></a>
                            <? } ?>
                            <? if(modules::run('modul/pobierz',$parent->id)->num_rows() > 0) { ?><a href="<?=$this->subsite_link($parent->id)?>" title="Podgląd podstrony" target="_blank"><i class="fa fa-eye"></i></a><? } ?>
                            <a href="<?=site_url('podstrona/edytuj/'.$parent->id)?>" title="Edytuj dane podstrony"><i class="fa fa-edit"></i></a>
                            <a href="<?=site_url('modul/'.$parent->id)?>" title="Edytuj treść podstrony"><i class="fa fa-bars"></i></a>
                            <? if($dane->system=='0') { ?><a href="<?=current_url()?>#usun-<?=$parent->id?>" rel="facebox" title="Usuń podstronę"><i class="fa fa-times"></i></a><? } ?>
                        </aside>
                    </td>
                </tr>
                <? } ?>
            <? } ?>
        </table>
		<? foreach($pobierz->result() as $dane) { ?>
		<? if($dane->status == 0) { ?>
            <div id="aktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-on"></i>
                <p>Czy jesteś pewien, że chcesz aktywować wybraną stronę?</p>
                <p><a href="<?=site_url('podstrona/status/'.$dane->id.'/1')?>">Tak, aktywuj stronę!</a></p>
            </div>
        <? } else { ?>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybraną stronę?</p>
                <p><a href="<?=site_url('podstrona/status/'.$dane->id.'/0')?>">Tak, dezaktywuj stronę!</a></p>
            </div>
		<? } ?>
           <div id="zmien-priorytet-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('podstrona/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                    <label>Większa liczba określa wyższą pozycję</label>
                    <input type="text" name="order" placeholder="Priorytet" value="<?=$dane->order?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zmień priorytet">
                </form>
            </div>
        <? if($dane->system=='0') { ?>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń podstronę</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć podstronę?</p>
                <p><a href="<?=site_url('podstrona/usun/'.$dane->id)?>">Tak, usuń podstronę!</a></p>
            </div>
		<? } ?>
			<? foreach(modules::run('podstrona/parent',$dane->id)->result() as $parent) { ?>
				<? if($parent->status == 0) { ?>
                    <div id="aktywuj-<?=$parent->id?>" class="hide">
                        <header><h3>Zmień status wpisu</h3></header>
                        <i class="fa fa-toggle-on"></i>
                        <p>Czy jesteś pewien, że chcesz aktywować wybraną podstronę?</p>
                        <p><a href="<?=site_url('podstrona/status/'.$parent->id.'/1')?>">Tak, aktywuj podstronę!</a></p>
                    </div>
                <? } else { ?>
                    <div id="dezaktywuj-<?=$parent->id?>" class="hide">
                        <header><h3>Zmień status wpisu</h3></header>
                        <i class="fa fa-toggle-off"></i>
                        <p>Czy jesteś pewien, że chcesz zdezaktywować wybraną podstronę?</p>
                        <p><a href="<?=site_url('podstrona/status/'.$parent->id.'/0')?>">Tak, dezaktywuj podstronę!</a></p>
                    </div>
                <? } ?>
               <div id="zmien-priorytet-<?=$parent->id?>" class="hide">
                    <header><h3>Zmień priorytet</h3></header>
                    <form action="<?=site_url('podstrona/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                        <label>Większa liczba określa wyższą pozycję</label>
                        <input type="text" name="order" placeholder="Priorytet" value="<?=$parent->order?>">
                        <input type="hidden" name="wpis" value="<?=$parent->id?>">
                        <input type="submit" value="Zmień priorytet">
                    </form>
                </div>
                <div class="hide" id="usun-<?=$parent->id?>">
                    <header><h3>Usuń podstronę</h3></header>
                    <i class="fa fa-close"></i>
                    <p>Czy jesteś pewien, że chcesz usunąć podstronę?</p>
                    <p><a href="<?=site_url('podstrona/usun/'.$parent->id)?>">Tak, usuń podstronę!</a></p>
                </div>
            <? } ?>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>