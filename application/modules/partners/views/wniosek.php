<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li><a href="<?=site_url('partner')?>">Wnioski klientów</a></li><li>Wniosek</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Wniosek klienta</h3>
    </header>
    <div class="hr"></div>
	<p><?=$this->wnioskodawca($dane->id)?></p>
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?></td>
        </tr>
    	<tr>
        	<td class="header">Wartość towarów</td>
            <td><?=$this->kwota($dane->wartosc)?></td>
        	<td class="header">Wpłata własna</td>
            <td><?=$this->kwota($dane->wplata)?></td>
        </tr>
    	<tr>
        	<td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>
            <td></td>
            <td></td>
        </tr>
    	<tr>
        	<td class="header">Imię</td>
            <td><?=$dane->imie?></td>
        	<td class="header">Drugie imię</td>
            <td><?=$dane->dimie?></td>
        </tr>
    	<tr>
        	<td class="header">Nazwisko</td>
            <td><?=$dane->nazwisko?></td>
        	<td class="header">Nazwisko panieńskie matki</td>
            <td><?=$dane->nmatki?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon komórkowy</td>
            <td><?=$dane->telefonkom?></td>
        	<td class="header">Telefon stacjonarny</td>
            <td><?=$dane->telefonstac?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon służbowy</td>
            <td><?=$dane->telefonsluzb?></td>
        	<td class="header">Adres e-mail</td>
            <td><?=$dane->email?></td>
        </tr>
    </table>

	<? if($dane->rodzaj == 1) {?>
    <header><h4>Szczegóły zakupu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane wniosek">
        <tr>
        	<td class="header">Tryb wniosku</td>
            <td><?=$dane->tryb?></td>
        </tr>
    	<tr>
        	<td class="header">Koszt wysyłki</td>
            <td><?=$this->kwota($dane->wysylka)?></td>
        </tr>
        <? $lacznie = 0; foreach($produkty->result() as $produkt) {?>
        <tr>
        	<td class="header">Produkt</td>
            <td class="notransform"><a href="<?=$produkt->produkt?>" target="_blank"><?=$produkt->produkt?></a></td>
        </tr>
        <tr>
        	<td class="header">Cena produktu</td>
            <td><?=$this->kwota($produkt->cena)?></td>
        </tr>
        <?
        	$lacznie = $lacznie + $produkt->cena;
		} 
		?>
        <tr>
        	<td class="header">Łącznie z kosztem wysyłki</td>
            <td class="header"><?=$this->kwota($lacznie+$dane->wysylka)?></td>
        </tr>
    </table>
    <? } ?>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>