<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie kategoriami FAQ</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=current_url()?>#dodaj" rel="facebox" class="button green icon"><i class="fa fa-plus"></i> Dodaj nową kategorię</a>
        	<a href="<?=site_url('zarzadzanie/faq')?>" class="button green icon"><i class="fa fa-chevron-left"></i> Cofnij</a>
        </aside>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Kategoria</th>
                <th>Priorytet</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr>
            	<td><?=$dane->kategoria?></td>
                <td class="right"><span class="grey"><?=$dane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$dane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fa fa-arrows-alt"></i></a></td>
                <td class="settings">
                	<aside class="admin">
                        <a href="<?=current_url()?>#edytuj-<?=$dane->id?>" rel="facebox" title="Edytuj"><i class="fa fa-edit"></i></a>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń wpis"><i class="fa fa-times"></i></a>
                    </aside>
				</td>
			</tr>
            <? } ?>
        </table>
       <div id="dodaj" class="hide">
            <header><h3>Dodaj</h3></header>
            <form action="<?=site_url('faq/kategorie/zapisz')?>" enctype="multipart/form-data" method="post">
                <label>Nazwa kategorii</label>
                <input type="text" name="kategoria" placeholder="Nazwa kategorii">
                <input type="submit" value="Zapisz zmiany">
            </form>
        </div>
		<? foreach($pobierz->result() as $dane) { ?>
           <div id="edytuj-<?=$dane->id?>" class="hide">
                <header><h3>Edytuj</h3></header>
                <form action="<?=site_url('faq/kategorie/zapisz')?>" enctype="multipart/form-data" method="post">
                    <label>Nazwa kategorii</label>
                    <input type="text" name="kategoria" placeholder="Nazwa kategorii" value="<?=$dane->kategoria?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz zmiany">
                </form>
            </div>
           <div id="zmien-priorytet-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('faq/kategorie/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
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