<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie komunikatami</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=current_url()?>#dodaj" rel="facebox" class="button green icon"><i class="fa fa-plus"></i> Dodaj komunikat</a>
        </aside>
        <div class="hide" id="dodaj">
        	<header><h3>Dodaj komunikat</h3></header>
            <form action="<?=site_url('komunikaty/zapisz')?>" enctype="multipart/form-data" method="post">
            	<label>Treść komunikatu</label>
                <input type="text" name="title" placeholder="Treść komunikatu" required>
            	<label>Link (opcjonalnie)</label>
                <input type="text" name="link" placeholder="Link (opcjonalnie)">
                <input type="submit" value="Zapisz">
            </form>
        </div>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Treść</th>
                <th>Link</th>
                <th>Narzędzia</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr<?=$this->statusview($dane->status)?>>
            	<td><?=$dane->title?></td>
                <td><?=$dane->link?'<a href="'.$dane->link.'" target="_blank">'.$dane->link.'</a>':NULL?></td>
                <td class="settings">
                	<aside class="admin">
						<? if($dane->status == 0) { ?>
                        <a href="<?=current_url()?>#aktywuj-<?=$dane->id?>" rel="facebox" title="Aktywuj wpis"><i class="fa fa-toggle-on"></i></a>
                        <? } else { ?>
                        <a href="<?=current_url()?>#dezaktywuj-<?=$dane->id?>" rel="facebox" title="Dezaktywuj wpis"><i class="fa fa-toggle-off"></i></a>
                        <? } ?>
                        <a href="<?=current_url()?>#edytuj-<?=$dane->id?>" rel="facebox" title="Edytuj wpis"><i class="fa fa-edit"></i></a>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń wpis"><i class="fa fa-times"></i></a>
                    </aside>
				</td>
			</tr>
            <? } ?>
        </table>
		<? foreach($pobierz->result() as $dane) { ?>
            <div id="aktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-on"></i>
                <p>Czy jesteś pewien, że chcesz aktywować wybrany wpis?</p>
                <p><a href="<?=site_url('komunikaty/status/'.$dane->id.'/1')?>">Tak, aktywuj wpis!</a></p>
            </div>
            <div id="dezaktywuj-<?=$dane->id?>" class="hide">
                <header><h3>Zmień status wpisu</h3></header>
                <i class="fa fa-toggle-off"></i>
                <p>Czy jesteś pewien, że chcesz zdezaktywować wybrany wpis?</p>
                <p><a href="<?=site_url('komunikaty/status/'.$dane->id.'/0')?>">Tak, dezaktywuj wpis!</a></p>
            </div>
            <div class="hide" id="edytuj-<?=$dane->id?>">
                <header><h3>Edytuj komunikat</h3></header>
                <form action="<?=site_url('komunikaty/zapisz')?>" enctype="multipart/form-data" method="post">
	            	<label>Treść komunikatu</label>
                    <input type="text" name="title" placeholder="Treść komunikatu" value="<?=htmlentities($dane->title)?>" required>
                	<label>Link (opcjonalnie)</label>
	                <input type="text" name="link" placeholder="Link (opcjonalnie)" value="<?=$dane->link?>" >
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz zmianę">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń wpis</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć wpis?</p>
                <p><a href="<?=site_url('komunikaty/usun/'.$dane->id)?>">Tak, usuń wpis!</a></p>
            </div>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>