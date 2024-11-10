<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li><a href="<?=site_url('zarzadzanie/archiwum')?>">Archiwum wniosków</a></li><li>Wniosek</li></ul></section>

<article id="content" class="admin">
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#usun" rel="facebox" title="Usuń wniosek"><i class="fa  fa-close"></i></a></li>
        </ul>
    </aside>
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
       
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Wnioskowana kwota</td>
            <td><?=$this->kwota($dane->kwota)?></td>
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
            <td><?=$this->partner($dane->partner)?></td>
        	<td class="header">Status wniosku</td>
            <td><?=$this->status($dane->status)?></td>
        </tr>
    	<tr>
        	<td class="header">Data złożenia</td>
            <td><?=$dane->data?></td>
        	<td class="header">IP wnioskodawcy</td>
            <td><?=$dane->ip?></td>
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
        	<td class="header">Wykształcenie</td>
            <td><?=$this->wyksztalcenie($dane->wyksztalcenie)?></td>
        	<td class="header">Liczba dzieci</td>
            <td><?=$this->dzieci($dane->dzieci)?></td>
        </tr>
    	<tr>
        	<td class="header">Stan cywilny</td>
            <td><?=$this->stan($dane->stan)?></td>
			<? if($dane->wimie) { ?>
        	<td class="header">Małżonek/ka</td>
            <td><?=$dane->wimie?> <?=$dane->wnazwisko?> <?=$this->kwota($dane->wdochod)?></td>
        	<? } else { ?>
        	<td class="header"></td>
            <td></td>
       		<? } ?>
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

    <header><h4>Szczegóły zakupu<a name="szczegoly-zakupu"></a></h4></header>
    <div class="hr less"></div>
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
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Notatka</th>
            <th>Opis pliku</th>
            <th>Administrator</th>
        </tr>
    <? foreach($notatka->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><?=$dane->notatka?></td>
            <td><a href="<?=site_url('assets/files/notes/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        </tr>
    <? } ?>
    </table>

    <header><h4>Dokumenty<a name="dokumenty"></a></h4></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th>Data</th>
            <th>Nazwa pliku</th>
            <th>Administrator</th>
        </tr>
    <? foreach($dokumenty->result() as $dane) { ?>
    	<tr class="notransform">
        	<td><?=$dane->data?></td>
        	<td><a href="<?=site_url('assets/files/documents/'.$dane->plik)?>" target="_blank"><?=$dane->opis?></a></td>
            <td><?=$this->admin($dane->admin)?></td>
        </tr>
    <? } ?>
    </table>

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