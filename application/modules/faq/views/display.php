<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie FAQ</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('faq/dodaj')?>" class="button green icon"><i class="fa fa-plus"></i> Dodaj nowy wpis</a>
        	<a href="<?=site_url('faq/kategorie')?>" class="button green icon"><i class="fa fa-folder"></i> Kategorie</a>
        </aside>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Kategoria</th>
            	<th>Nagłówek</th>
            	<th>Treść</th>
                <th>Priorytet</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr<?=$this->statusview($dane->status)?>>
            	<td><?=modules::run('faq/kategoria',$dane->kategoria)->kategoria?></td>
            	<td><?=$dane->title?></td>
            	<td><?=word_limiter(strip_tags($dane->tresc),15,'(...)')?></td>
                <td class="right"><span class="grey"><?=$dane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$dane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fa fa-arrows-alt"></i></a></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj wpis"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj wpis"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <a href="<?=current_url()?>#zmien-data-<?=$dane->id?>" rel="facebox" title="Zmień priorytet"><i class="fa fa-clock"></i></a>
                        <a href="<?=site_url('faq/edytuj/'.$dane->id)?>" title="Edytuj wpis"><i class="fa fa-edit"></i></a>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń wpis"><i class="fa fa-times"></i></a>
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
                <p>Czy jesteś pewien, że chcesz aktywować wybrany wpis?</p>
                <p><a href="<?=site_url('faq/status/'.$dane->id.'/1')?>">Tak, aktywuj wpis!</a></p>
            </div>
            <? } else { ?>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybrany wpis?</p>
                <p><a href="<?=site_url('faq/status/'.$dane->id.'/0')?>">Tak, dezaktywuj wpis!</a></p>
            </div>
            <? } ?>
           <div id="zmien-priorytet-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('faq/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                    <label>Większa liczba określa wyższą pozycję</label>
                    <input type="text" name="order" placeholder="Priorytet" value="<?=$dane->order?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zmień priorytet">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń wpis</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć wpis?</p>
                <p><a href="<?=site_url('faq/usun/'.$dane->id)?>">Tak, usuń wpis!</a></p>
            </div>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>