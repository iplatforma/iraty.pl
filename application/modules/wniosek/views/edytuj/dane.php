<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('supplement/header');

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url()?>">Strona główna</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li><a href="<?=site_url('wniosek/'.$formularz['id'])?>">Wniosek</a></li><li>Dane pożyczkobiorcy</li></ul></section>


<article id="content" class="wniosek">
	<form id="dane" action="<?=site_url('wniosek/zapisz/dane/'.$formularz['id'])?>" method="post">
		<header><h4>Dane osobowe</h4></header>
        <div class="hr less"></div>
        <? if($this->select('wniosek','rodzaj',$formularz['id']) == '1') { ?>
        <div class="form"><label>Imię</label><input type="text" name="imie" value="<?=$formularz['imie']?>"></div>
        <div class="form"><label>Drugie imię</label><input type="text" name="dimie" value="<?=$formularz['dimie']?>"></div>
        <div class="form"><label>Nazwisko</label><input type="text" name="nazwisko" value="<?=$formularz['nazwisko']?>"></div>
        <div class="form"><label>Nazwisko panieńskie matki</label><input type="text" name="nmatki" value="<?=$formularz['nmatki']?>"></div>
        <div class="form"><label>PESEL</label><input type="text" name="pesel" value="<?=$formularz['pesel']?>"></div>
        <div class="form"><label>Seria i numer dowodu osobistego</label><input type="text" name="dowod" value="<?=$formularz['dowod']?>"></div>
		<header><h4>Adres zameldowania</h4></header>
        <div class="hr less"></div>
        <div class="form"><label>Ulica, numer domu/lokalu</label><input type="text" name="ulica" value="<?=$formularz['ulica']?>"></div>
        <div class="form"><label>Kod pocztowy</label><input type="text" name="kod_pocztowy" value="<?=$formularz['kod_pocztowy']?>" placeholder="__-___"></div>
        <div class="form"><label>Miejscowość</label><input type="text" name="miejscowosc" value="<?=$formularz['miejscowosc']?>"></div>
        <div class="form">
            <label>Województwo</label>
            <select name="wojewodztwo">
                <option value=""></option>
                <? foreach($wojewodztwo->result() as $dane) { ?>
                <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['wojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                <? } ?>
            </select>
        </div>
		<header><h4>Adres korespondencyjny</h4></header>
		<p class="less"><input type="checkbox" id="korespondencyjny" name="korespondencyjny"<?=$this->checked($formularz['korespondencyjny'])?>><label for="korespondencyjny">Zaznacz i wypełnij, jeśli adres do korespondencji jest inny niż adres zameldowania.</label></p>
        <div class="hr less"></div>
        <div class="korespondencyjny">
            <div class="form"><label>Ulica, numer domu/lokalu</label><input type="text" name="korulica" value="<?=$formularz['korulica']?>"></div>
            <div class="form"><label>Kod pocztowy</label><input type="text" name="korkod_pocztowy" value="<?=$formularz['korkod_pocztowy']?>" placeholder="__-___"></div>
            <div class="form"><label>Miejscowość</label><input type="text" name="kormiejscowosc" value="<?=$formularz['kormiejscowosc']?>"></div>
            <div class="form">
            	<label>Województwo</label>
                <select name="korwojewodztwo">
                    <option value=""></option>
                    <? foreach($wojewodztwo->result() as $dane) { ?>
                    <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['korwojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                    <? } ?>
                </select>
			</div>
        </div>
		<header><h4>Pozostałe dane</h4></header>
        <div class="hr less"></div>
        <div class="form">
        	<label>Wykształcenie</label>
        	<select name="wyksztalcenie">
            	<option value=""></option>
                <? foreach($wyksztalcenie->result() as $dane) { ?>
                <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['wyksztalcenie'])?>><?=$dane->wyksztalcenie?></option>
                <? } ?>
            </select>
        </div>
        <div class="form">
        	<label>Liczba dzieci na utrzymaniu</label>
			<select name="dzieci">
            	<option value=""></option>
                <? foreach($dzieci->result() as $dane) { ?>
                <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['dzieci'])?>><?=$dane->dzieci?></option>
                <? } ?>
            </select>
		</div>
        <div class="form">
        	<label>Stan cywilny</label>
        	<select name="stan">
            	<option value=""></option>
                <? foreach($stan_cywilny->result() as $dane) { ?>
                <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['stan'])?>><?=$dane->stan?></option>
                <? } ?>
            </select>
        </div>

        <div class="form wspolnota"><label>Imię współmałżonka</label><input type="text" name="wimie" value="<?=$formularz['wimie']?>"></div>
        <div class="form wspolnota"><label>Nazwisko współmałżonka</label><input type="text" name="wnazwisko" value="<?=$formularz['wnazwisko']?>"></div>
        <div class="form wspolnota"><label>Średni dochód netto współmałżonka</label><input type="text" name="wdochod" value="<?=$formularz['wdochod']?>" placeholder="z ostatnich 3 miesięcy"><span>PLN</span></div>

        <div class="form">
        	<label>Status mieszkaniowy</label>
        	<select name="mieszkanie">
            	<option value=""></option>
                <? foreach($mieszkanie->result() as $dane) { ?>
                <option value="<?=$dane->id?>"<?=$this->selected($dane->id,$formularz['mieszkanie'])?>><?=$dane->status?></option>
                <? } ?>
            </select>
        </div>
        <div class="form"><label>Telefon komórkowy</label><input type="text" name="telefonkom" class="telefon" value="<?=$formularz['telefonkom']?>"></div>
        <div class="form"><label>Telefon stacjonarny</label><input type="text" name="telefonstac" class="telefon" value="<?=$formularz['telefonstac']?>"></div>
        <div class="form"><label>Telefon służbowy</label><input type="text" name="telefonsluzb" class="telefon" value="<?=$formularz['telefonsluzb']?>"></div>
        <div class="form"><label>Adres e-mail</label><input type="text" name="email" value="<?=$formularz['email']?>"></div>
        <? } else { ?>
        <? if($this->select('wniosek','rodzaj',$formularz['id']) == '2') { ?>
        <div class="form"><label>Firma</label><input type="text" name="firma" value="<?=$formularz['firma']?>"></div>
        <div class="form"><label>NIP</label><input type="text" name="nip" value="<?=$formularz['nip']?>"></div>
        <? } ?>
        <div class="form"><label>Osoba kontaktowa</label><input type="text" name="osoba" value="<?=$formularz['osoba']?>"></div>
        <div class="form"><label>Telefon komórkowy</label><input type="text" name="telefonkom" class="telefon" value="<?=$formularz['telefonkom']?>"></div>
        <div class="form"><label>Adres e-mail</label><input type="text" name="email" value="<?=$formularz['email']?>"></div>
        <? } ?>
        <input type="submit" value="Zapisz zmiany">
    </form>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>