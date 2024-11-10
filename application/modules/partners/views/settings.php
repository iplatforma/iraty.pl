<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section id="front" class="admin">
	<div class="settings">
    	<ul>
            <li><a href="<?=site_url('partner')?>" title="Wnioski klientów"><i class="fa fa-file-text"></i></a></li>
            <? if($this->select('partner','assistance',$this->session->userdata('partner')) == 1) { ?><li><a href="<?=site_url('partner/ubezpieczenia')?>" title="Panel ubezpieczeń"><i class="fa fa-umbrella"></i></a></li><? } ?>
            <li><a href="<?=site_url('partner/prowizja')?>" title="Prowizja partnera"><i class="fa fa-cart-arrow-down"></i></a></li>
            <li><a href="<?=site_url('partner/dane')?>" title="Dane partnera"><i class="fa fa-suitcase"></i></a></li>
            <li><a href="<?=current_url()?>#zmiana-hasla" rel="facebox" title="Zmiana hasła"><i class="fa fa-key"></i></a></li>
        	<li><a href="<?=site_url('partners/wyloguj')?>" title="Wyloguj się"><i class="fa fa-sign-out"></i></a></li>
        </ul>
    </div>
</section>

<div id="zmiana-hasla" class="hide">
    <header><h3>Zmiana hasła</h3></header>
    <form action="<?=site_url('partners/zmien_haslo')?>" enctype="multipart/form-data" method="post">
        <label>Obecne hasło</label>
        <input type="password" name="partner_haslo">
        <label>Nowe hasło</label>
        <input type="password" name="partner_nhaslo">
        <label>Powtórz nowe hasło</label>
        <input type="password" name="partner_pnhaslo">
        <input type="hidden" name="partner" value="<?=$this->session->userdata('partner')?>">
        <input type="submit" value="Zmień hasło">
    </form>
</div>


