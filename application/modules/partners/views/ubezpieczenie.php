<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li><a href="<?=site_url('partner/ubezpieczenia')?>">Wnioski ubezpieczeniowe</a></li><li>Wniosek</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Wniosek ubezpieczeniowy</h3>
    </header>   
    <div class="hr less"></div>

    <table class="wniosek dane">
    	<tr>
        	<td class="header">Deklaracja</td>
            <td><?=$dane->deklaracja?></td>
        	<td class="header">Data złożenia</td>
            <td><?=$dane->data_zlozenia?></td>
        </tr>
    	<tr>
        	<td class="header">Forma płatności</td>
            <td><?=$dane->forma_platnosci==1?'Gotówką w dniu podpisania deklaracji':'Przelew w ciągu 7 dni od daty podpisania deklaracji'?></td>
        	<td class="header">Kwota ubezpieczenia</td>
            <td colspan="3"><?=$this->kwota($dane->wartosc)?></td>
        </tr>
        <? if($dane->typ == 1) {?>
    	<tr>
        	<td class="header">Imię i nazwisko</td>
            <td><?=$dane->imie?> <?=$dane->nazwisko?></td>
        	<td class="header">PESEL</td>
            <td><?=$dane->pesel?></td>        
		</tr>
        <? } else { ?>
    	<tr>
        	<td class="header">Nazwa firmy</td>
            <td><?=$dane->nazwa?> <?=$dane->nazwisko?></td>
        	<td class="header">NIP/REGON</td>
            <td><?=$dane->nip?> / <?=$dane->regon?></td>
        </tr>
		<? } ?>
    	<tr>        
        	<td class="header">Adres</td>
            <td><?=$dane->ulica?> <?=$dane->dom?><?=$dane->lokal?'/'.$dane->lokal:''?><br><?=$dane->kod_pocztowy?> <?=$dane->miejscowosc?></td>
        	<td class="header">Adres e-mail</td>
            <td><?=$dane->email?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon</td>
            <td><?=$dane->telefon?></td>
            <td class="header">IP użytkownika</td>
            <td><?=$dane->ip?></td>
        </tr>
        <tr>
        	<td colspan="4" class="notransform">
			<? if($dane->typ == '1') { ?>
       			<? if($dane->zgoda1 == '1') { ?>Oświadczam, że otrzymałem, zapoznałem się i akceptuję treść Ogólnych Warunków Umowy "HOME ASSISTANCE".<br><? } ?>
       			<? if($dane->zgoda2 == '1') { ?>Wyrażam zgodę na przetwarzanie moich danych osobowych w celu realizacji umowy.<br><? } ?>
       			<? if($dane->zgoda3 == '1') { ?>Niniejsze oświadczenie oraz dane osobowe składam dobrowolnie, a podane przeze mnie informacje są zgodne z prawdą.<br><? } ?>
       			<? if($dane->zgoda4 == '1') { ?>Wyrażam zgodę na przetwarzanie moich danych osobowych w celach marketingowych przez Platforma Sp. z o.o.<? } else { ?>
                Nie wyrażam zgody na przetwarzanie moich danych osobowych w celach marketingowych przez Platforma Sp. z o.o.<? } ?>
            <? } ?>
			<? if($dane->typ == '2') { ?>
       			<? if($dane->zgoda11 == '1') { ?>Oświadczam, że otrzymałem, zapoznałem się i akceptuję treść Ogólnych Warunków Umowy "OFFICE ASSISTANCE".<br><? } ?>
       			<? if($dane->zgoda21 == '1') { ?>Wyrażam zgodę na przetwarzanie moich danych osobowych w celu realizacji umowy.<br><? } ?>
       			<? if($dane->zgoda31 == '1') { ?>Niniejsze oświadczenie oraz dane osobowe składam dobrowolnie, a podane przeze mnie informacje są zgodne z prawdą.<br><? } ?>
       			<? if($dane->zgoda41 == '1') { ?>Wyrażam zgodę na przetwarzanie moich danych osobowych w celach marketingowych przez Platforma Sp. z o.o.<br><? } else { ?>
                Nie wyrażam zgody na przetwarzanie moich danych osobowych w celach marketingowych przez Platforma Sp. z o.o.<br><? } ?>
       			<? if($dane->zgoda51 == '1') { ?>Wyrażam zgodę na wystawianie i przesyłanie przez Platforma Sp. z o.o. faktur VAT, duplikatów faktur oraz korekt faktur w formie elektronicznej.<? } ?>
            <? } ?>            
            </td>
        </tr>
    </table>

    <header><h4>Dokumenty<a name="dokumenty"></a></h4></header>
    <div class="hr less"></div>
    <? if($dane->typ == 1) { $type = 'home'; } elseif($dane->typ == 2) { $type = 'office'; } ?>
    <p><a href="<?=site_url('ubezpieczenie/deklaracja/'.$type.'/'.$dane->hash)?>" target="_blank">Deklaracja przystąpienia</a></p>
    <p><a href="<?=site_url('ubezpieczenie/certyfikat/'.$type.'/'.$dane->hash)?>" target="_blank">Certyfikat</a></p>
    <? if($dane->typ == '1') { ?><p><a href="<?=asset_url()?>files/assistance/home-owu.pdf" target="_blank">OWU</a></p>
    <? } else { ?><p><a href="<?=asset_url()?>files/assistance/office-owu.pdf" target="_blank">OWU</a></p><? } ?>  



</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>