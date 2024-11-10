<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('supplement/header');

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li><a href="<?=site_url('zarzadzanie/partnerzy')?>">Lista partnerów</a></li><li><a href="<?=site_url('partner/'.$formularz['id'])?>">Partner</a></li><li>Edytuj partnera</li></ul></section>

<article id="content" class="wniosek">
    <header><h3>Edytuj partnera</h3></header>
    <div class="hr"></div>
	<form id="dane" action="<?=site_url('partner/zapisz/'.$formularz['id'])?>" method="post">
		<header><h4>Dane partnera</h4></header>
        <div class="form"><label>Dane firmy</label><input type="text" name="dane" value="<?=$formularz['dane']?>"></div>
        <div class="form"><label>Nazwa firmy</label><input type="text" name="nazwa" value="<?=$formularz['nazwa']?>"></div>
        <div class="form"><label>Nazwa partnera</label><input type="text" name="partner" value="<?=$formularz['partner']?>"></div>
        <div class="form"><label>NIP</label><input type="text" name="nip" value="<?=$formularz['nip']?>"></div>
        <div class="form"><label>Opiekun</label><input type="text" name="opiekun" value="<?=$formularz['opiekun']?>"></div>
        <div class="form"><label>Osoba kontaktowa</label><input type="text" name="osoba" value="<?=$formularz['osoba']?>"></div>
        <div class="form"><label>Telefon</label><input type="text" name="telefon" value="<?=$formularz['telefon']?>"></div>
        <div class="form"><label>Adres e-mail</label><input type="text" name="email" value="<?=$formularz['email']?>"></div>
        <div class="form"><label>Numer konta bankowego</label><input type="text" name="konto" value="<?=$formularz['konto']?>"></div>
        <div class="form">
        	<label>Nadaj status</label>
            <select name="status">
            	<option value=""></option>
            	<option value="1"<?=$this->selected(1,$formularz['status'])?>>zablokowany</option>
            	<option value="2"<?=$this->selected(2,$formularz['status'])?>>aktywny</option>
        	</select>
        </div>
        <div class="hr less"></div>
		<header><h4>Informacje handlowe</h4></header>
        <div class="form"><label>Branża</label><input type="text" name="branza" value="<?=$formularz['branza']?>"></div>
        <div class="form"><label>Link do strony internetowej</label><input type="text" name="linkStrona" value="<?=$formularz['linkStrona']?>"></div>
        <div class="form"><label>Link do aukcji Allegro</label><input type="text" name="linkAukcja" value="<?=$formularz['linkAukcja']?>"></div>
        <div class="form"><label>Status Meritum</label><input type="text" name="statusMeritum" value="<?=$formularz['statusMeritum']?>"></div>
        <div class="form"><label>Status umowy z nami</label><input type="text" name="statusUmowa" value="<?=$formularz['statusUmowa']?>"></div>
        <div class="form"><label>Status wysłanej umowy z Meritum</label><input type="text" name="statusUmowaMeritum" value="<?=$formularz['statusUmowaMeritum']?>"></div>
        <div class="form"><label>Branża</label><input type="text" name="branza" value="<?=$formularz['branza']?>"></div>
        <div class="form"><label>Buttony</label><input type="text" name="buttony" value="<?=$formularz['buttony']?>"></div>
        <div class="form"><label>Buttony sprawdzenie</label><input type="text" name="buttonySprawdzenie" value="<?=$formularz['buttonySprawdzenie']?>"></div>
        <div class="form"><label>Prowizja dla opiekuna</label><input type="text" name="prowizjaOpiekun" value="<?=$formularz['prowizjaOpiekun']?>"></div>
        <div class="form"><label>Prowizja dla partnera</label><input type="text" name="prowizjaPartner" value="<?=$formularz['prowizjaPartner']?>"></div>
        <div class="form">
        	<label>Program assistance</label>
            <select name="assistance">
            	<option value="0"<?=$this->selected(0,$formularz['assistance'])?>>nieaktywny</option>
            	<option value="1"<?=$this->selected(1,$formularz['assistance'])?>>aktywny</option>
        	</select>
        </div>
        <div class="form"><label>Prowizja dla partnera [Home] / %</label><input type="text" name="prowizja_home" value="<?=$formularz['prowizja_home']?>"></div>
        <div class="form"><label>Prowizja dla partnera [Office] / %</label><input type="text" name="prowizja_office" value="<?=$formularz['prowizja_office']?>"></div>
        <div class="form"><label>Koszt Home Assistance</label><input type="text" name="koszt_home" value="<?=$formularz['koszt_home']?>"></div>
        <div class="form"><label>Koszt Office Assistance</label><input type="text" name="koszt_office" value="<?=$formularz['koszt_office']?>"></div>
        <input type="submit" value="Zapisz zmiany">
    </form>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>