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
        <p>Czy jesteś pewien, że chcesz usunąć wniosek <strong><?=$this->wnioskodawca($dane->id)?></strong>?</p>
        <p><a href="<?=site_url('wniosek/usun/'.$dane->id)?>">Tak, usuń wniosek!</a></p>
    </div>
	<header>
    	<h3>Wniosek ratalny</h3>
    </header>   
    <ul class="submenu">
    	<li><a href="#szczegoly-zakupu">Szczegóły zakupu</a></li>
    	<li><a href="#zrodlo-dochodu">Źródło dochodu</a></li>
        <li><a href="#notatki">Notatki</a></li>
        <li><a href="#dokumenty">Dokumenty</a></li>
        <li><a href="#historia-administracyjna">Historia administracyjna</a></li>
    </ul>
    <div class="hr less"></div>
	<p><?=$this->wnioskodawca($dane->id)?> (<?=$this->status($dane->status)?>)</p>
       
    <aside class="admin">
    	<ul>
        	<li><a href="<?=site_url('wniosek/edytuj/parametry/'.$dane->id)?>" title="Edytuj parametry pożyczki"><i class="fa fa-bar-chart"></i></a></li>
        	<li><a href="<?=site_url('wniosek/edytuj/dane/'.$dane->id)?>" title="Edytuj dane pożyczkobiorcy"><i class="fa fa-pencil"></i></a></li>
        </ul>
    </aside>
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?> (dodatkowa gotówka: <?=$this->kwota($dane->gotowka)?>)</td>
        	<td class="header">Wartość towarów</td>
            <td><?=$this->kwota($dane->wartosc)?></td>
        </tr>
    	<tr>
        	<td class="header">Wpłata własna</td>
            <td><?=$this->kwota($dane->wplata)?></td>
        	<td class="header">Ilość rat</td>
            <td><?=$dane->raty?> rat</td>
        </tr>
    	<tr>
        	<td class="header">Oprocentowanie</td>
            <td><?=number_format($dane->oprocentowanie,2)?>%</td>
        	<td class="header">Wysokość raty</td>
            <td><?=$this->kwota($dane->wRata)?></td>
        </tr>
    	<tr>
        	<td class="header">Partner</td>
            <td><?=$this->partner($dane->partner)?><a href="#edytuj-partner" rel="facebox" title="Zmień partnera"><i class="fa fa-shopping-cart"></i></a><a href="<?=site_url('partner/'.$dane->partner)?>"><i class="fa fa-arrow-right"></i></a></td>
        	<td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>
        </tr>
    	<tr>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        	<td class="header">Aktualizacja statusu</td>
            <td><?=$dane->zmiana?></td>
        </tr>
    	<tr>
        	<td class="header">IP wnioskodawcy</td>
            <td><?=$dane->ip?></td>
        	<td class="header">Klasyfikacja</td>
            <td><?=$dane->klasyfikacja?></td>
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
        	<td class="header">PESEL</td>
            <td><?=$dane->pesel?></td>
        	<td class="header">Numer dowodu osobistego</td>
            <td><?=$dane->dowod?></td>
        </tr>
    	<tr>
        	<td class="header">Adres</td>
            <td><?=$this->adres('','dane',$dane->id)?></td>
        	<td class="header">Adres korespondencyjny</td>
            <td><?=$this->adres('kor','dane',$dane->id)?></td>
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
    	<tr>
        	<td class="header">Wykształcenie</td>
            <td><?=$this->wyksztalcenie($dane->wyksztalcenie)?></td>
        	<td class="header">Liczba dzieci</td>
            <td><?=$this->dzieci($dane->dzieci)?></td>
        </tr>
    	<tr>
			<td class="header">Status mieszkaniowy</td>
            <td><?=$this->mieszkanie($dane->mieszkanie)?></td>
        	<td class="header">Stan cywilny</td>
            <td><?=$this->stan($dane->stan)?><? if($dane->wimie) { ?><br><?=$dane->wimie?> <?=$dane->wnazwisko?> <?=$this->kwota($dane->wdochod)?><? } ?></td>
        </tr>
    	<tr>
			<td class="header">Dodatkowe informacje</td>
            <td colspan="3"><?=$dane->dodatkowe?></td>
        </tr>
    </table>
    <div id="edytuj-partner" class="hide">
    	<header><h3>Edytuj partnera</h3></header>
        <form action="<?=site_url('wniosek/partner/zmien')?>" enctype="multipart/form-data" method="post">
        	<label>Wybierz partnera</label>
            <select name="partner">
            	<option value="0">wniosek indywidualny</option>
                <? foreach($partnerzy['partner'] as $partner) {?>
                <option value="<?=$partner['id']?>"<?=$this->selected($partner['id'],$dane->partner)?>><?=htmlentities($partner['nazwa'])?></option>
                <? } ?>
            </select>
        	<input type="hidden" name="wpis" value="<?=$dane->id?>">
            <input type="submit" value="Zapisz zmianę">
        </form>
    </div>

    <header><h4>Szczegóły zakupu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=site_url('wniosek/edytuj/zakup/'.$dane->id)?>" title="Edytuj szczegóły zakupu"><i class="fa fa-cart-arrow-down"></i></a></li>
        </ul>
    </aside>
    <table class="dane wniosek">
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
    
    <header><h4>Źródło dochodu<a name="zrodlo-dochodu"></a></h4></header>
    <div class="hr less"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=site_url('wniosek/edytuj/dochod/'.$dane->id)?>" title="Edytuj źródło dochodu"><i class="fa fa-briefcase"></i></a></li>
        </ul>
    </aside>
    <? if($dane->uop) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Umowa o pracę</strong></td>
        </tr>
    	<tr>
        	<td class="header">Średni dochód netto z ostatnich 3 miesięcy</td>
            <td><?=$this->kwota($dane->uop_dochod)?></td>
        	<td class="header">Zawód wykonywany</td>
            <td><?=$dane->uop_zawod?></td>
        </tr>
    	<tr>
        	<td class="header">Data zatrudnienia</td>
            <td><?=$dane->uop_zatrudnienie?></td>
        	<td class="header">Data końca zatrudnienia</td>
            <td><?=$dane->uop_nieokreslony ? 'czas nieokreślony' : $dane->uop_kzatrudnienie?></td>
        </tr>
    	<tr>
        	<td class="header">Nazwa pracodawcy</td>
            <td><?=$dane->uop_pracodawca?></td>
        	<td class="header">NIP pracodawcy</td>
            <td><?=$dane->uop_nip?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon do pracodawcy</td>
            <td><?=$dane->uop_telefon?></td>
        	<td class="header">Adres pracodawcy</td>
            <td><?=$this->adres('uop_','dochod',$dane->id)?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->sm) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Służby mundurowe</strong></td>
        </tr>
    	<tr>
        	<td class="header">Miesięczny dochód netto</td>
            <td><?=$this->kwota($dane->sm_dochod)?></td>
        	<td class="header">Numer legitymacji służbowej:</td>
            <td><?=$dane->sm_legitymacja?></td>
        </tr>
    	<tr>
        	<td class="header">Stanowisko</td>
            <td><?=$dane->sm_stanowisko?></td>
        	<td class="header"></td>
            <td></td>
        </tr>
    	<tr>
        	<td class="header">Data zatrudnienia</td>
            <td><?=$dane->sm_zatrudnienie?></td>
        	<td class="header">Data końca zatrudnienia</td>
            <td><?=$dane->sm_nieokreslony ? 'czas nieokreślony' : $dane->sm_kzatrudnienie?></td>
        </tr>
    	<tr>
        	<td class="header">Nazwa pracodawcy</td>
            <td><?=$dane->sm_pracodawca?></td>
        	<td class="header">NIP pracodawcy</td>
            <td><?=$dane->sm_nip?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon do pracodawcy</td>
            <td><?=$dane->sm_telefon?></td>
        	<td class="header">Adres pracodawcy</td>
            <td><?=$this->adres('sm_','dochod',$dane->id)?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->emer) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Emerytura</strong></td>
        </tr>
    	<tr>
        	<td class="header">Dochód netto</td>
            <td><?=$this->kwota($dane->emer_dochod)?></td>
        	<td class="header">Numer legitymacji emeryta</td>
            <td><?=$dane->emer_legitymacja?></td>
        </tr>
    	<tr>
        	<td class="header">Numer świadczenia emerytalnego</td>
            <td><?=$dane->emer_swiadczenie?></td>
        	<td class="header">Data przyznania świadczenia</td>
            <td><?=$dane->emer_zatrudnienie?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->renta) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Renta</strong></td>
        </tr>
    	<tr>
        	<td class="header">Dochód netto</td>
            <td><?=$this->kwota($dane->renta_dochod)?></td>
        	<td class="header">Numer legitymacji rencisty</td>
            <td><?=$dane->renta_legitymacja?></td>
        </tr>
    	<tr>
        	<td class="header">Numer świadczenia rentowego</td>
            <td><?=$dane->renta_swiadczenie?></td>
        	<td class="header"></td>
            <td></td>
        </tr>
    	<tr>
        	<td class="header">Data przyznania świadczenia</td>
            <td><?=$dane->renta_zatrudnienie?></td>
        	<td class="header">Data końca świadczenia</td>
            <td><?=$dane->renta_nieokreslony ? 'czas nieokreślony' : $dane->renta_kzatrudnienie?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->dg_kpr) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Działalność gospodarcza - Księga przychodów i rozchodów</strong></td>
        </tr>
    	<tr>
        	<td class="header">Dochód netto (średnia z ostatnich 3 miesięcy)</td>
            <td><?=$this->kwota($dane->dg_kpr_dochod)?></td>
        	<td class="header">NIP</td>
            <td><?=$dane->dg_kpr_nip?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->dg_r) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Działalność gospodarcza - Ryczałt</strong></td>
        </tr>
    	<tr>
        	<td class="header">Przychód (średnia z ostatnich 3 miesięcy)</td>
            <td><?=$this->kwota($dane->dg_r_przychod)?></td>
        	<td class="header">NIP</td>
            <td><?=$dane->dg_r_nip?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->dg_kp) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Działalność gospodarcza - Karta podatkowa</strong></td>
        </tr>
    	<tr>
        	<td class="header">Kwota podatku na bieżący rok</td>
            <td><?=$this->kwota($dane->dg_kp_podatek)?></td>
        	<td class="header">NIP</td>
            <td><?=$dane->dg_kp_nip?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->uz) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Umowa zlecenie</strong></td>
        </tr>
    	<tr>
        	<td class="header">Średni dochód netto z ostatnich 6 miesięcy</td>
            <td><?=$this->kwota($dane->uz_dochod)?></td>
        	<td class="header">Zawód wykonywany</td>
            <td><?=$dane->uz_zawod?></td>
        </tr>
    	<tr>
        	<td class="header">Data zatrudnienia</td>
            <td><?=$dane->uz_zatrudnienie?></td>
        	<td class="header">Data końca zatrudnienia</td>
            <td><?=$dane->uz_kzatrudnienie?></td>
        </tr>
    	<tr>
        	<td class="header">Nazwa pracodawcy</td>
            <td><?=$dane->uz_pracodawca?></td>
        	<td class="header">NIP pracodawcy</td>
            <td><?=$dane->uz_nip?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon do pracodawcy</td>
            <td><?=$dane->uz_telefon?></td>
        	<td class="header">Adres pracodawcy</td>
            <td><?=$this->adres('uz_','dochod',$dane->id)?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->uod) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Umowa o dzieło</strong></td>
        </tr>
    	<tr>
        	<td class="header">Średni dochód netto z ostatnich 12 miesięcy</td>
            <td><?=$this->kwota($dane->uod_dochod)?></td>
        	<td class="header">Zawód wykonywany</td>
            <td><?=$dane->uod_zawod?></td>
        </tr>
    	<tr>
        	<td class="header">Data zatrudnienia</td>
            <td><?=$dane->uod_zatrudnienie?></td>
        	<td class="header">Data końca zatrudnienia</td>
            <td><?=$dane->uod_kzatrudnienie?></td>
        </tr>
    	<tr>
        	<td class="header">Nazwa pracodawcy</td>
            <td><?=$dane->uod_pracodawca?></td>
        	<td class="header">NIP pracodawcy</td>
            <td><?=$dane->uod_nip?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon do pracodawcy</td>
            <td><?=$dane->uod_telefon?></td>
        	<td class="header">Adres pracodawcy</td>
            <td><?=$this->adres('uod_','dochod',$dane->id)?></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->gr) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Gospodarstwo rolne</strong></td>
        </tr>
    	<tr>
        	<td class="header">Data rozpoczęcia uzyskiwania bieżącego dochodu</td>
            <td><?=$dane->gr_zatrudnienie?></td>
        	<td class="header">Forma władania</td>
            <td><?=$dane->gr_wladanie?></td>
        </tr>
    	<tr>
        	<td class="header">Ilość Właścicieli/Dzierżawców</td>
            <td><?=$dane->gr_ilosc?></td>
        	<td class="header">Urzędy gmin, w których zarejestrowane są Gospodarstwa</td>
            <td><?=$dane->gr_urzedy?></td>
        </tr>
    	<tr>
        	<td class="header">Roczny dochód netto (na podstawie faktur)</td>
            <td><?=$this->kwota($dane->gr_dochod)?></td>
        	<td class="header">Ilość hektarów</td>
            <td><?=$dane->gr_hektary?></td>
        </tr>
    	<tr>
        	<td class="header">NIP</td>
            <td><?=$dane->gr_nip?></td>
        	<td class="header"></td>
            <td></td>
        </tr>
	</table>
    <? } ?>
    <? if($dane->un) { ?>
    <table class="dane wniosek">
    	<tr>
        	<td class="center" colspan="4"><strong>Umowa najmu</strong></td>
        </tr>
    	<tr>
        	<td class="header">Dochód netto</td>
            <td><?=$this->kwota($dane->un_dochod)?></td>
        	<td class="header"></td>
            <td></td>
        </tr>
    	<tr>
        	<td class="header">Data rozpoczęcia uzyskiwania dochodu</td>
            <td><?=$dane->un_zatrudnienie?></td>
        	<td class="header">Data zakończenia uzyskiwania dochodu</td>
            <td><?=$dane->un_kzatrudnienie?></td>
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