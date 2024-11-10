<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li>Wniosek</li></ul></section>

<article id="content" class="admin">
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#status" rel="facebox" title="Zmień status wniosku"><i class="fa fa-external-link-square"></i></a></li>
        	<li><a href="<?=current_url()?>#dodaj-notatka" rel="facebox" title="Dodaj notatkę"><i class="fa fa-comment"></i></a></li>
        	<li><a href="<?=current_url()?>#dodaj-dokument" rel="facebox" title="Dodaj dokument"><i class="fa fa-file-text"></i></a></li>
        	<li><a href="<?=current_url()?>#archiwum" rel="facebox" title="Przenieś do archiwum"><i class="fa  fa-tags"></i></a></li>
        	<li><a href="<?=current_url()?>#usun" rel="facebox" title="Usuń wniosek"><i class="fa  fa-close"></i></a></li>
        </ul>
    </aside>
    <div id="status" class="hide">
    	<header><h3>Zmień status wniosku</h3></header>
        <form action="<?=site_url('wniosek/set_status')?>" enctype="multipart/form-data" method="post">
        	<select name="status">
				<? foreach($statusy->result() as $status) { ?>
					<option value="<?=$status->id?>"<?=$this->selected($status->id,$dane->status)?>><?=$status->status?></option>
				<? } ?>
            </select>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Zapisz zmianę">
        </form>
    </div>
    <div id="archiwum" class="hide">
    	<header><h3>Przenieś wniosek do archiwum</h3></header>
        <i class="fa  fa-close"></i>
        <p>Czy jesteś pewien, że chcesz przenieść wniosek <strong><?=$this->wnioskodawca($dane->id)?></strong> do archiwum?</p>
        <p><a href="<?=site_url('wniosek/archiwum/'.$dane->id)?>">Tak, przenieś wniosek do archiwum!</a></p>
    </div>
    <div id="usun" class="hide">
    	<header><h3>Usuń wniosek</h3></header>
        <i class="fa  fa-close"></i>
        <p>Czy jesteś pewien, że chcesz usunąć wniosek <strong><?=$this->wnioskodawca_finansowe($dane->id)?></strong>?</p>
        <p><a href="<?=site_url('wniosek/usun/'.$dane->id)?>">Tak, usuń wniosek!</a></p>
    </div>
	<header>
    	<h3>Wniosek finansowy</h3>
    </header>   
    <ul class="submenu">
    	<? if($dane->rodzaj == '2') { ?><li><a href="#szczegoly-zakupu">Szczegóły leasingu</a></li><?  } ?>
        <li><a href="#notatki">Notatki</a></li>
        <li><a href="#dokumenty">Dokumenty</a></li>
        <li><a href="#historia-administracyjna">Historia administracyjna</a></li>
    </ul>
    <div class="hr less"></div>
	<p><?=$this->wnioskodawca_finansowe($this->uri->segment(2))?> (<?=$this->status($dane->status)?>)</p>
       
    <aside class="admin">
    	<ul>
        	<li><a href="<?=site_url('wniosek/edytuj/dane/'.$dane->id)?>" title="Edytuj dane pożyczkobiorcy"><i class="fa fa-pencil"></i></a></li>
        </ul>
    </aside>
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Typ wniosku</td>
            <td><?=$this->rodzaj($dane->rodzaj)?><?=$dane->rodzaj == 4?'<br/>'.$dane->nazwa:''?></td>
            <td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>
        </tr>
    	<tr>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        	<td class="header">Aktualizacja statusu</td>
            <td><?=$dane->zmiana?></td>
		</tr>
        <? if($dane->rodzaj == '2') { ?>
        <tr>
        	<td class="header">Prowizja:</td>
            <td><?=$dane->prowizja?></td>
        	<td class="header">Finansujący</td>
            <td><?=$this->finansujacy($dane->finansujacy)?><a href="#edytuj-finansujacy" rel="facebox" title="Zmień finansującego"><i class="fa fa-bank"></i></a></td>
        </tr>
        <? } ?>
        <tr>
        	<td class="header">Partner</td>
            <td><?=$this->partner($dane->partner)?><a href="#edytuj-partner" rel="facebox" title="Zmień partnera"><i class="fa fa-shopping-cart"></i></a></td>
        	<td class="header">Notatka:</td>
            <td><?=$dane->notatka?></td>
        </tr>
    	<tr>
        	<td class="header">IP wnioskodawcy</td>
            <td><?=$dane->ip?></td>
        	<td class="header">Klasyfikacja</td>
            <td><?=$dane->klasyfikacja?></td>
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
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?></td>
        </tr>
    	<tr>
        	<td class="header">Dodatkowe informacje</td>
            <td colspan="3"><?=$dane->temat?'<strong>'.$dane->temat.'</strong><br>':''?><?=$dane->wiadomosc?></td>
        </tr>
    </table>
    <div id="edytuj-partner" class="hide">
    	<header><h3>Edytuj partnera</h3></header>
        <form action="<?=site_url('wniosek/partner/zmien')?>" enctype="multipart/form-data" method="post">
        	<label>Wybierz partnera</label>
            <select name="partner">
            	<option value="0">wniosek indywidualny</option>
                <? foreach($partnerzy['partner'] as $partner) {?>
                <option value="<?=$partner['id']?>"<?=$this->selected($partner['id'],$dane->partner)?>><?=$partner['nazwa']?></option>
                <? } ?>
            </select>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Zapisz zmianę">
        </form>
    </div>
    <div id="edytuj-finansujacy" class="hide">
    	<header><h3>Finansujący</h3></header>
        <form action="<?=site_url('wniosek/finansujacy/zmien')?>" enctype="multipart/form-data" method="post">
        	<label>Wybierz finansującego</label>
            <select name="finansujacy">
            	<option value="0">brak finansującego</option>
                <? foreach($finansujacy->result() as $finans) {?>
                <option value="<?=$finans->id?>"<?=$this->selected($finans->id,$dane->finansujacy)?>><?=$finans->nazwa?></option>
                <? } ?>
            </select>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Zapisz zmianę">
        </form>
    </div>    

	<? if($dane->rodzaj == '2') { ?>
    <header><h4>Szczegóły leasingu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=site_url('finansowe/edytuj/zakup/'.$dane->id)?>" title="Edytuj szczegóły leasingu"><i class="fa fa-cart-arrow-down"></i></a></li>
        </ul>
    </aside>
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
        	<td class="header">Stawka amortyzacji</td>
            <td class="notransform"><?=$produkt->amortyzacja?></td>
        </tr>
        <tr class="border">
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
    
    <header><h4>Notatki<a name="notatki"></a></h4></header>
    <div class="hr less"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#dodaj-notatka" rel="facebox" title="Dodaj notatkę"><i class="fa fa-comment"></i></a></li>
        </ul>
    </aside>
    <div id="dodaj-notatka" class="hide">
    	<header><h3>Dodaj notatkę</h3></header>
        <form action="<?=site_url('notatka/dodaj')?>" enctype="multipart/form-data" method="post">
        	<label>Treść notatki</label>
            <textarea name="notatka" required></textarea>
        	<label>Dołącz plik</label>
            <input type="file" name="userfile">
            <label>Opis pliku</label>
            <input type="text" name="opis">
        	<input type="hidden" name="wniosek" value="<?=$dane->id?>">
            <input type="submit" value="Dodaj notatkę">
        </form>
    </div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Notatka</th>
            <th>Opis pliku</th>
            <th>Administrator</th>
            <th>Narzędzia</th>
        </tr>
    <? foreach($notatka->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><?=$dane->notatka?></td>
            <td><a href="<?=site_url('assets/files/notes/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        	<td>
                <? if(!$dane->plik) { ?><a href="#plik-notatka-<?=$dane->id?>" rel="facebox" title="Załącz plik do notatki"><i class="fa fa-file"></i></a><? } ?>
                <a href="#edytuj-notatka-<?=$dane->id?>" rel="facebox" title="Edytuj notatkę"><i class="fa fa-comments-o "></i></a>
                <a href="#usun-notatka-<?=$dane->id?>" rel="facebox" title="Usuń notatkę"><i class="fa fa-close"></i></a>
            </td>
        </tr>
    <? } ?>
    </table>
    <? foreach($notatka->result() as $dane) { ?>
    <div id="plik-notatka-<?=$dane->id?>" class="hide">
    	<header><h3>Załącz plik do notatki</h3></header>
        <form action="<?=site_url('notatka/zalacz_plik')?>" enctype="multipart/form-data" method="post">
        	<label>Dołącz plik</label>
            <input type="file" name="userfile" required>
            <label>Opis pliku</label>
            <input type="text" name="opis" required>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Załącz plik do notatki">
        </form>
    </div>
    <div id="edytuj-notatka-<?=$dane->id?>" class="hide">
    	<header><h3>Edytuj notatkę</h3></header>
        <form action="<?=site_url('notatka/edytuj')?>" enctype="multipart/form-data" method="post">
        	<label>Treść notatki</label>
            <textarea name="notatka" required><?=$dane->notatka?></textarea>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Zapisz zmianę">
        </form>
    </div>
    <div id="usun-notatka-<?=$dane->id?>" class="hide">
    	<header><h3>Usuń notatkę</h3></header>
        <i class="fa  fa-close"></i>
        <p>Czy jesteś pewien, że chcesz usunąć wybraną notatkę?</p>
        <p><a href="<?=site_url('notatka/usun/'.$dane->id)?>">Tak, usuń notatkę!</a></p>
    </div>
    <? } ?>

    <header><h4>Dokumenty<a name="dokumenty"></a></h4></header>
    <div class="hr less"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#dodaj-dokument" rel="facebox" title="Dodaj dokument"><i class="fa fa-file-text"></i></a></li>
        </ul>
    </aside>
    <div id="dodaj-dokument" class="hide">
    	<header><h3>Dodaj dokument</h3></header>
        <form action="<?=site_url('dokumenty/dodaj')?>" enctype="multipart/form-data" method="post">
        	<label>Dołącz dokument</label>
            <input type="file" name="userfile" required>
            <label>Opis dokumentu</label>
            <input type="text" name="opis" required>
        	<input type="hidden" name="wniosek" value="<?=$this->uri->segment(2)?>">
            <input type="submit" value="Dodaj dokument">
        </form>
    </div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Nazwa pliku</th>
            <th>Administrator</th>
            <th>Narzędzia</th>
        </tr>
    <? foreach($dokumenty->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><a href="<?=site_url('assets/files/documents/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        	<td>
                <a href="#usun-dokument-<?=$dane->id?>" rel="facebox" title="Usuń dokument"><i class="fa fa-close"></i></a>
            </td>
        </tr>
    <? } ?>
    </table>
    <? foreach($dokumenty->result() as $dane) { ?>
    <div id="usun-dokument-<?=$dane->id?>" class="hide">
    	<header><h3>Usunięcie dokumentu</h3></header>
        <i class="fa  fa-close"></i>
        <p>Czy jesteś pewien, że chcesz usunąć dokument <strong><?=$dane->opis?></strong>?</p>
        <p><a href="<?=site_url('dokumenty/usun/'.$dane->id)?>">Tak, usuń dokument!</a></p>
    </div>
    <? } ?>    

    <header><h4>Historia administracyjna<a name="historia-administracyjna"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Administrator</th>
            <th>Wykonane zadanie</th>
        </tr>
    <? foreach($historia->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
            <td><a href="<?=site_url('historia/'.$dane->admin)?>"><?=$this->admin($dane->admin)?></a></td>
        	<td><?=$dane->zadanie?></td>
        </tr>
    <? } ?>
    </table>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>