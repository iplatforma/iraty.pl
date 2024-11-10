<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie menu</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('menu/dodaj')?>" class="button green icon"><i class="fa fa-plus"></i> Dodaj nową pozycję</a>
        </aside>
        <table class="dane">
        	<tr>
                <th>Typ</th>
            	<th>Nazwa</th>
            	<th>Podstrona</th>
                <th>Link</th>
                <th>Priorytet wyświetlania</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr<?=$this->statusview($dane->status)?>>
            	<td><?=$dane->typ?></td>
            	<td><strong><?=$dane->nazwa?></strong></td>
                <td>---</td>
                <td>
				<?=($dane->url?'<a href="'.$dane->url.'" target="_blank">'.$dane->url.'</a>':NULL)?>
                <?=($dane->site?'<a href="'.$this->subsite_link($dane->site).'" target="_blank">'.$this->subsite_link($dane->site).'</a>':NULL)?>
                <?=(!$dane->url and !$dane->site)?'---':NULL?>
                </td>
                <td><span class="grey"><?=$dane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$dane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fas fa-arrows-alt"></i></a></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj wpis"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj wpis"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <a href="<?=site_url('menu/edytuj/'.$dane->id)?>" title="Edytuj wpis"><i class="fa fa-edit"></i></a>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń wpis"><i class="fa fa-times"></i></a>
                    </aside>
				</td>
			</tr>
				<? foreach(modules::run('menu/parent',$dane->id)->result() as $pdane) { ?>
                <tr<?=$this->statusview($pdane->status)?>>
                    <td><?=$pdane->typ?></td>
                    <td><em><?=$dane->nazwa?></em></td>
                    <td><strong><?=$pdane->nazwa?></strong></td>
                    <td>
                    <?=($pdane->url?'<a href="'.$pdane->url.'" target="_blank">'.$pdane->url.'</a>':NULL)?>
                    <?=($pdane->site?'<a href="'.$this->subsite_link($pdane->site).'" target="_blank">'.$this->subsite_link($pdane->site).'</a>':NULL)?>
	                <?=(!$pdane->url and !$pdane->site)?'---':NULL?>
                    </td>
                    <td><span class="grey"><?=$pdane->order?></span><a href="<?=current_url()?>#zmien-priorytet-<?=$pdane->id?>" class="priority" rel="facebox" title="Zmień priorytet"><i class="fas fa-arrows-alt"></i></a></td>
                    <td class="settings">
                        <aside class="admin">
                            <? if($pdane->status == 0) { ?>
                            <a href="<?=current_url()?>#aktywuj-<?=$pdane->id?>" rel="facebox" title="Aktywuj wpis"><i class="fa fa-toggle-on"></i></a>
                            <? } else { ?>
                            <a href="<?=current_url()?>#dezaktywuj-<?=$pdane->id?>" rel="facebox" title="Dezaktywuj wpis"><i class="fa fa-toggle-off"></i></a>
                            <? } ?>
                            <a href="<?=site_url('menu/edytuj/'.$pdane->id)?>" title="Edytuj wpis"><i class="fa fa-edit"></i></a>
                            <a href="<?=current_url()?>#usun-<?=$pdane->id?>" rel="facebox" title="Usuń wpis"><i class="fa fa-times"></i></a>
                        </aside>
                    </td>
                </tr>
                <? } ?>
            <? } ?>
        </table>
		<? foreach($pobierz->result() as $dane) { ?>
            <div id="aktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-on"></i>
                <p>Czy jesteś pewien, że chcesz aktywować wybrany wpis?</p>
                <p><a href="<?=site_url('menu/status/'.$dane->id.'/1')?>">Tak, aktywuj wpis!</a></p>
            </div>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybrany wpis?</p>
                <p><a href="<?=site_url('menu/status/'.$dane->id.'/0')?>">Tak, dezaktywuj wpis!</a></p>
            </div>
            <div id="zmien-priorytet-<?=$dane->id?>" class="hide">
                <header><h3>Zmień priorytet</h3></header>
                <form action="<?=site_url('menu/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                    <input type="text" name="order" placeholder="Priorytet" value="<?=$dane->order?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zmień priorytet">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń wpis</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć wpis?</p>
                <p><a href="<?=site_url('menu/usun/'.$dane->id)?>">Tak, usuń wpis!</a></p>
            </div>
			<? foreach(modules::run('menu/parent',$dane->id)->result() as $pdane) { ?>
                <div id="aktywuj-<?=$pdane->id?>" class="hide">
                    <header><h3>Zmień status wpisu</h3></header>
                    <i class="fa fa-toggle-on"></i>
                    <p>Czy jesteś pewien, że chcesz aktywować wybrany wpis?</p>
                    <p><a href="<?=site_url('menu/status/'.$pdane->id.'/1')?>">Tak, aktywuj wpis!</a></p>
                </div>
                <div id="dezaktywuj-<?=$pdane->id?>" class="hide">
                    <header><h3>Zmień status wpisu</h3></header>
                    <i class="fa fa-toggle-off"></i>
                    <p>Czy jesteś pewien, że chcesz zdezaktywować wybrany wpis?</p>
                    <p><a href="<?=site_url('menu/status/'.$pdane->id.'/0')?>">Tak, dezaktywuj wpis!</a></p>
                </div>
                <div id="zmien-priorytet-<?=$pdane->id?>" class="hide">
                    <header><h3>Zmień priorytet</h3></header>
                    <form action="<?=site_url('menu/kolejnosc/zapisz')?>" enctype="multipart/form-data" method="post">
                        <input type="text" name="order" placeholder="Priorytet" value="<?=$pdane->order?>">
                        <input type="hidden" name="wpis" value="<?=$pdane->id?>">
                        <input type="submit" value="Zmień priorytet">
                    </form>
                </div>
                <div class="hide" id="usun-<?=$pdane->id?>">
                    <header><h3>Usuń wpis</h3></header>
                    <i class="fa fa-close"></i>
                    <p>Czy jesteś pewien, że chcesz usunąć wpis?</p>
                    <p><a href="<?=site_url('menu/usun/'.$pdane->id)?>">Tak, usuń wpis!</a></p>
                </div>
            <? } ?>
        <? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>