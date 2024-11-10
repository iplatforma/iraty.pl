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
    <div class="hr less"></div>
	<p><?=$this->wnioskodawca_finansowe($this->uri->segment(3))?> (<?=$this->status($dane->status)?>)</p>
       
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Typ wniosku</td>
            <td><?=$this->rodzaj($dane->rodzaj)?></td>
            <td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>            
        </tr>
    	<tr>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?></td>
		</tr>
        <? if($dane->rodzaj == '2') { ?>
	   	<tr>
        	<td class="header">Nazwa firmy</td>
            <td><?=$dane->firma?></td>
        	<td class="header">NIP</td>
            <td><?=$dane->nip?></td>
        </tr>
		<? } ?>        
	   	<tr>
        	<td class="header">Osoba kontaktowa</td>
            <td><?=$dane->osoba?></td>
        	<td class="header">Telefon</td>
            <td><?=$dane->telefonkom?></td>
        </tr>
	   	<tr>
        	<td class="header">Adres e-mail</td>
            <td><?=$dane->email?></td>
            <td></td>
            <td></td>
        </tr>
    </table>

	<? if($dane->rodzaj == '2') { ?>
    <header><h4>Szczegóły leasingu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane wniosek">
        <? $lacznie = 0; foreach($produkty->result() as $produkt) {?>
        <tr>
        	<td class="header">Produkt</td>
            <td class="notransform"><a href="<?=prep_url($produkt->przedmiot)?>" target="_blank"><?=$produkt->przedmiot?></a></td>
        	<td class="header">Cena</td>
            <td><?=$this->kwota($produkt->cena)?></td>
        </tr>
        <tr>
        	<td class="header">Stan</td>
            <td class="notransform"><?=$produkt->stan?></td>
        	<td class="header">Dostawca</td>
            <td colspan="3"><?=$produkt->dostawca?></td>
        </tr>
        <?
        	$lacznie = $lacznie + $produkt->cena;
		} 
		?>
        <tr>
        	<td colspan="2"></td>
        	<td class="header">Łącznie</td>
            <td class="header"><?=$this->kwota($lacznie)?></td>
        </tr>
    </table>
    <? } ?>

</article>

<? $this->load->view('supplement/footer'); ?>