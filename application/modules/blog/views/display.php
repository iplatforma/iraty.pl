<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie blogiem</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('blog/dodaj')?>" class="button green icon"><i class="fa fa-plus"></i> Dodaj nowy wpis</a>
        </aside>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th></th>
            	<th>Nagłówek</th>
            	<th>Treść</th>
                <th>Data publikacji</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr<?=$this->statusview($dane->status)?>>
            	<td><? if($dane->src) { ?><img src="<?=assets('img/blog/thumb/'.$dane->src)?>"><? } ?></td>
            	<td><?=$dane->title?></td>
            	<td><?=word_limiter(strip_tags($dane->tresc),30,'(...)')?></td>
                <td class="right"><?=$dane->date?></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj wpis"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj wpis"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <a href="<?=current_url()?>#dodaj-glowne-<?=$dane->id?>" rel="facebox" title="Edytuj zdjęcie"><i class="fa fa-camera"></i></a>
                        <a href="<?=current_url()?>#zmien-data-<?=$dane->id?>" rel="facebox" title="Zmień datę"><i class="fa fa-clock"></i></a>
                        <a href="<?=site_url('blog/edytuj/'.$dane->id)?>" title="Edytuj wpis"><i class="fa fa-edit"></i></a>
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
                <p><a href="<?=site_url('blog/status/'.$dane->id.'/1')?>">Tak, aktywuj wpis!</a></p>
            </div>
            <? } else { ?>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybrany wpis?</p>
                <p><a href="<?=site_url('blog/status/'.$dane->id.'/0')?>">Tak, dezaktywuj wpis!</a></p>
            </div>
            <? } ?>
            <div id="dodaj-glowne-<?=$dane->id?>" class="hide">
                <header><h3>Ustaw zdjęcie</h3></header>
                <? if($dane->src) { ?><img src="<?=assets('img/blog/thumb/'.$dane->src)?>" style="max-width:100%;"><? } ?>
                <form action="<?=site_url('blog/src/dodaj')?>" enctype="multipart/form-data" method="post">
                    <label>Wybierz zdjęcie</label>
                    <input type="file" name="zdjecie">
                    <input type="hidden" name="typ" value="src">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz zdjęcie">
                </form>
                <? if($dane->src) { ?><p class="full">lub <a href="<?=site_url('blog/src/usun/'.$dane->id)?>" title="Usuń zdjęcie główne">usuń zdjęcie</a>.</p><? } ?>
            </div>
           <div id="zmien-data-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('blog/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                    <input type="text" name="date" placeholder="Priorytet" value="<?=$dane->date?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zmień priorytet">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń wpis</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć wpis?</p>
                <p><a href="<?=site_url('blog/usun/'.$dane->id)?>">Tak, usuń wpis!</a></p>
            </div>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>