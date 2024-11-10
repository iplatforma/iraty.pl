<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="header">
	<div class="justify">
		<ul class="crumbs">
        	<li><a href="<?=site_url()?>">Strona główna</a></li>
            <li>Zarządzanie administratorami</li>
        </ul>
    	<header><h2 class="less">Zarządzanie administratorami</h2></header>
        <? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=current_url()?>#dodaj" rel="facebox" class="button green icon"><i class="fa fa-user-plus"></i> Dodaj nowego administratora</a>
        </aside>
        <div id="dodaj" class="hide">
            <header><h3>Dodaj nowego administratora</h3></header>
            <form action="<?=site_url('administrator/zapisz')?>" method="post" enctype="multipart/form-data">
                <label>Login</label>
                <input type="text" name="login" placeholder="Login" autocomplete="off" required>
                <label>Hasło</label>
                <input type="text" name="haslo" placeholder="Hasło" autocomplete="off" required>
                <label>Dane administratora</label>
                <input type="text" name="dane" placeholder="Dane administratora" required>
                <label>Adres e-mail</label>
                <input type="email" name="email" placeholder="Adres e-mail">
                <input type="submit" value="Utwórz konto">
            </form>
        </div>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
            	<th>Login</th>
            	<th>Adres e-mail</th>
            	<th>Imię i nazwisko</th>
                <th>Narzędzia</th>
            </tr>
			<? $i = 1; foreach($pobierz->result() as $dane) { ?>
            <tr>
            	<td><?=$dane->login?></td>
            	<td><?=$dane->email?></td>
            	<td><?=$dane->nazwisko?></td>
                <td class="settings">
                	<aside class="admin">
                        <a href="<?=current_url()?>#edytuj-<?=$dane->id?>" rel="facebox" title="Edytuj dane administratora"><i class="fa fa-edit"></i></a>
                        <a href="<?=site_url('administrator/historia/'.$dane->id)?>" title="Historia działań administratora"><i class="fa fa-history"></i></a>
                        <a href="<?=current_url()?>#haslo-<?=$dane->id?>" rel="facebox" title="Zmień hasło"><i class="fa fa-key"></i></a>
                        <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń administratora"><i class="fa fa-times"></i></a>
                    </aside>
				</td>
			</tr>
            <? $i++; } ?>
        </table>
		<? foreach($pobierz->result() as $dane) { ?>
            <div id="edytuj-<?=$dane->id?>" class="hide">
                <header><h3>Edytuj dane administratora</h3></header>
                <form action="<?=site_url('administrator/zapisz')?>" method="post" enctype="multipart/form-data">
                    <label>Login</label>
                    <input type="text" name="login" placeholder="Login" autocomplete="off" value="<?=$dane->login?>" required>
                    <label>Dane administratora</label>
                    <input type="text" name="dane" placeholder="Dane administratora" value="<?=$dane->nazwisko?>" required>
                    <label>Adres e-mail</label>
                    <input type="email" name="email" placeholder="Adres e-mail" value="<?=$dane->email?>">
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz zmiany">
                </form>
            </div>
            <div id="haslo-<?=$dane->id?>" class="hide">
                <header><h3>Zmiana hasła do konta</h3></header>
                <form action="<?=site_url('administrator/haslo')?>" method="post" enctype="multipart/form-data">
                    <label>Nowe hasło</label>
                    <input type="password" name="haslo" placeholder="Nowe hasło" autocomplete="off" required>
                    <label>Wpisz ponownie nowe hasło</label>
                    <input type="password" name="phaslo" placeholder="Wpisz ponownie nowe hasło" autocomplete="off" required>
                    <input type="hidden" name="wpis" value="<?=$dane->id?>">
                    <input type="submit" value="Zapisz zmianę">
                </form>
            </div>
        	<div class="hide" id="usun-<?=$dane->id?>">
            	<header><h3>Usuń administratora</h3></header>
                <i class="fa fa-close"></i>
                <p>Czy jesteś pewien, że chcesz usunąć administratora?</p>
                <p><a href="<?=site_url('administrator/usun/'.$dane->id)?>">Tak, usuń administratora!</a></p>
            </div>
        <? } ?>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>