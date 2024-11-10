<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('supplement/header');

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url()?>">Strona główna</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li><a href="<?=site_url('wniosek/'.$formularz['id'])?>">Wniosek</a></li><li>Źródło dochodu</li></ul></section>


<article id="content" class="wniosek">
	<form id="dochod" action="<?=site_url('wniosek/zapisz/dochod/'.$formularz['id'])?>" method="post">
        
		<header><h4>Umowa o pracę</h4></header>
        <p><?=validation_errors()?></p>
		<p class="less"><input type="checkbox" id="uop" name="uop" class="forma_dochodu"<?=$this->checked($formularz['uop'])?>><label for="uop">Zaznacz jeśli uzyskujesz dochód z tytułu umowy o pracę</label></p>
        <div class="hr"></div>
        <div class="uop">
            <div class="form"><label>Miesięczny dochód netto</label><input type="text" class="kwota" name="uop_dochod" value="<?=$formularz['uop_dochod']?>" placeholder="średnia z ostatnich 3 miesięcy"><span>PLN</span></div>
            <div class="form"><label>Zawód wykonywany</label><input type="text" name="uop_zawod" value="<?=$formularz['uop_zawod']?>"></div>
            <div class="form"><label>Data zatrudnienia</label><input class="data" type="text" name="uop_zatrudnienie" autocomplete="off" value="<?=$formularz['uop_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data końca zatrudnienia</label><input class="kdata uop_kzatrudnienia" type="text" name="uop_kzatrudnienie" autocomplete="off" value="<?=$formularz['uop_kzatrudnienie']?>" placeholder="RRRR-MM-DD">
            <div class="checkbox"><input type="checkbox" id="uop_nieokreslony" name="uop_nieokreslony" class="uop_kzatrudnienia"<?=$this->checked($formularz['uop_nieokreslony'])?>><label for="uop_nieokreslony">czas nieokreślony</label></div></div>
            <div class="form"><label>Nazwa pracodawcy</label><input type="text" name="uop_pracodawca" class="pracodawca" value="<?=$formularz['uop_pracodawca']?>"></div>
            <div class="form"><label>NIP pracodawcy<a href="javascript:void(0);" onclick="findnip('uop_pracodawca')" class="findnip uop_pracodawca">Znajdź NIP</a></label><input type="text" name="uop_nip" value="<?=$formularz['uop_nip']?>"></div>
            <div class="form"><label>Telefon do pracodawcy</label><input type="text" name="uop_telefon" class="telefon" value="<?=$formularz['uop_telefon']?>"></div>
            <div class="form"><label>Ulica, numer budynku/lokalu</label><input type="text" name="uop_ulica" value="<?=$formularz['uop_ulica']?>"></div>
            <div class="form"><label>Kod pocztowy</label><input type="text" name="uop_kod_pocztowy" value="<?=$formularz['uop_kod_pocztowy']?>" placeholder="__-___"></div>
            <div class="form"><label>Miejscowość</label><input type="text" name="uop_miejscowosc" value="<?=$formularz['uop_miejscowosc']?>"></div>
            <div class="form">
            	<label>Województwo</label>
            	<select name="uop_wojewodztwo">
                    <option value=""></option>
                    <? foreach($wojewodztwo->result() as $dane) { ?>
                    <option value="<?=$dane->id?>"<?=$this->selected($dane->id, $formularz['uop_wojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form"><label>&nbsp;</label></div>
        </div>

		<header><h4>Służby mundurowe</h4></header>
		<p class="less"><input type="checkbox" id="sm" name="sm" class="forma_dochodu"<?=$this->checked($formularz['sm'])?>><label for="sm">Zaznacz jeśli uzyskujesz dochód z tytułu służby mundurowej</label></p>
        <div class="hr"></div>
        <div class="sm">
            <div class="form"><label>Miesięczny dochód netto</label><input type="text" class="kwota" name="sm_dochod" value="<?=$formularz['sm_dochod']?>" placeholder="średnia z ostatnich 3 miesięcy"><span>PLN</span></div>
            <div class="form"><label>Stanowisko</label><input type="text" name="sm_stanowisko" value="<?=$formularz['sm_stanowisko']?>"></div>
            <div class="form"><label>Numer legitymacji służbowej</label><input type="text" name="sm_legitymacja" value="<?=$formularz['sm_legitymacja']?>"></div>
            <div class="form"><label>Data zatrudnienia</label><input class="data" type="text" name="sm_zatrudnienie" autocomplete="off" value="<?=$formularz['sm_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data końca zatrudnienia</label><input class="kdata sm_kzatrudnienia" type="text" name="sm_kzatrudnienie" autocomplete="off" value="<?=$formularz['sm_kzatrudnienie']?>" placeholder="RRRR-MM-DD">
            <div class="checkbox"><input type="checkbox" id="sm_nieokreslony" name="sm_nieokreslony" class="sm_kzatrudnienia"<?=$this->checked($formularz['sm_nieokreslony'])?>><label for="sm_nieokreslony">czas nieokreślony</label></div></div>
            <div class="form"><label>Nazwa pracodawcy</label><input type="text" name="sm_pracodawca" class="pracodawca" value="<?=$formularz['sm_pracodawca']?>"></div>
            <div class="form"><label>NIP pracodawcy<a href="javascript:void(0);" onclick="findnip('sm_pracodawca')" class="findnip sm_pracodawca">Znajdź NIP</a></label><input type="text" name="sm_nip" value="<?=$formularz['sm_nip']?>"></div>
            <div class="form"><label>Telefon do pracodawcy</label><input type="text" name="sm_telefon" class="telefon" value="<?=$formularz['sm_telefon']?>"></div>
            <div class="form"><label>Ulica, numer budynku/lokalu</label><input type="text" name="sm_ulica" value="<?=$formularz['sm_ulica']?>"></div>
            <div class="form"><label>Kod pocztowy</label><input type="text" name="sm_kod_pocztowy" placeholder="__-___" value="<?=$formularz['sm_kod_pocztowy']?>"></div>
            <div class="form"><label>Miejscowość</label><input type="text" name="sm_miejscowosc" value="<?=$formularz['sm_miejscowosc']?>"></div>
            <div class="form">
            	<label>Województwo</label>
            	<select name="sm_wojewodztwo">
                    <option value=""></option>
                    <? foreach($wojewodztwo->result() as $dane) { ?>
                    <option value="<?=$dane->id?>"<?=$this->selected($dane->id, $formularz['sm_wojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form"><label>&nbsp;</label></div>
        </div>
        
        <header><h4>Emerytura</h4></header>
		<p class="less"><input type="checkbox" id="emer" name="emer" class="forma_dochodu"<?=$this->checked($formularz['emer'])?>><label for="emer">Zaznacz jeśli uzyskujesz dochód z tytułu świadczenia emerytalnego</label></p>
        <div class="hr"></div>
        <div class="emer">
            <div class="form"><label>Dochód netto</label><input type="text" class="kwota" name="emer_dochod" value="<?=$formularz['emer_dochod']?>"><span>PLN</span></div>
            <div class="form"><label>Numer legitymacji emeryta</label><input type="text" name="emer_legitymacja" value="<?=$formularz['emer_legitymacja']?>"></div>
            <div class="form"><label>Numer świadczenia emerytalnego</label><input type="text" name="emer_swiadczenie" value="<?=$formularz['emer_swiadczenie']?>"></div>
            <div class="form"><label>Data przyznania świadczenia</label><input class="data" type="text" name="emer_zatrudnienie" value="<?=$formularz['emer_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
        </div>
        
		<header><h4>Renta</h4></header>
		<p class="less"><input type="checkbox" id="renta" name="renta" class="forma_dochodu"<?=$this->checked($formularz['renta'])?>><label for="renta">Zaznacz jeśli uzyskujesz dochód z tytułu świadczenia rentowego</label></p>
        <div class="hr"></div>
        <div class="renta">
            <div class="form"><label>Dochód netto</label><input type="text" class="kwota" name="renta_dochod" value="<?=$formularz['renta_dochod']?>"><span>PLN</span></div>
            <div class="form"><label>Numer legitymacji rencisty</label><input type="text" name="renta_legitymacja" value="<?=$formularz['renta_legitymacja']?>"></div>
            <div class="form"><label>Numer świadczenia rentowego</label><input type="text" name="renta_swiadczenie" value="<?=$formularz['renta_swiadczenie']?>"></div>
            <div class="form"><label>Data przyznania świadczenia</label><input class="data" type="text" name="renta_zatrudnienie" autocomplete="off" value="<?=$formularz['renta_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data końca świadczenia</label><input class="kdata renta_kzatrudnienia" type="text" name="renta_kzatrudnienie" autocomplete="off" value="<?=$formularz['renta_kzatrudnienie']?>" placeholder="RRRR-MM-DD">
            <div class="checkbox"><input type="checkbox" id="renta_nieokreslony" name="renta_nieokreslony" class="renta_kzatrudnienia"<?=$this->checked($formularz['renta_nieokreslony'])?>><label for="renta_nieokreslony">czas nieokreślony</label></div></div>
        </div>
        
		<header><h4>Działalność gospodarcza - Księga Przychodów i Rozchodów</h4></header>
		<p class="less"><input type="checkbox" id="dg_kpr" name="dg_kpr" class="forma_dochodu"<?=$this->checked($formularz['dg_kpr'])?>><label for="dg_kpr">Zaznacz jeśli uzyskujesz dochód z tytułu działalności gospodarczej - księgi przychodów i rozchodów</label></p>
        <div class="hr"></div>
        <div class="dg_kpr">
            <div class="form"><label>Dochód netto</label><input type="text" class="kwota" name="dg_kpr_dochod" value="<?=$formularz['dg_kpr_dochod']?>" placeholder="średnia z ostatnich 3 miesięcy"><span>PLN</span></div>
            <div class="form"><label>NIP</label><input type="text" name="dg_kpr_nip" value="<?=$formularz['dg_kpr_nip']?>"></div>
        </div>
        
		<header><h4>Działalność gospodarcza - ryczałt</h4></header>
		<p class="less"><input type="checkbox" id="dg_r" name="dg_r" class="forma_dochodu"<?=$this->checked($formularz['dg_r'])?>><label for="dg_r">Zaznacz jeśli uzyskujesz dochód z tytułu działalności gospodarczej - ryczałt</label></p>
        <div class="hr"></div>
        <div class="dg_r">
            <div class="form"><label>Przychód</label><input type="text" class="kwota" name="dg_r_przychod" value="<?=$formularz['dg_r_przychod']?>" placeholder="średnia z ostatnich 3 miesięcy"><span>PLN</span></div>
            <div class="form"><label>NIP</label><input type="text" name="dg_r_nip" value="<?=$formularz['dg_r_nip']?>"></div>
        </div>
        
		<header><h4>Działalność gospodarcza - karta podatkowa</h4></header>
		<p class="less"><input type="checkbox" id="dg_kp" name="dg_kp" class="forma_dochodu"<?=$this->checked($formularz['dg_kp'])?>><label for="dg_kp">Zaznacz jeśli uzyskujesz dochód z tytułu działalności gospodarczej - karta podatkowa</label></p>
        <div class="hr"></div>
        <div class="dg_kp">
            <div class="form"><label>Kwota podatku na bieżący rok</label><input type="text" class="kwota" name="dg_kp_podatek" value="<?=$formularz['dg_kp_podatek']?>"><span>PLN</span></div>
            <div class="form"><label>NIP</label><input type="text" name="dg_kp_nip" value="<?=$formularz['dg_kp_nip']?>"></div>
        </div>
        
		<header><h4>Umowa zlecenie</h4></header>
		<p class="less"><input type="checkbox" id="uz" name="uz" class="forma_dochodu"<?=$this->checked($formularz['uz'])?>><label for="uz">Zaznacz jeśli uzyskujesz dochód z tytułu umowy zlecenie</label></p>
        <div class="hr"></div>
        <div class="uz">
            <div class="form"><label>Miesięczny dochód netto</label><input type="text" class="kwota" name="uz_dochod" value="<?=$formularz['uz_dochod']?>" placeholder="średnia z ostatnich 6 miesięcy"><span>PLN</span></div>
            <div class="form"><label>Zawód wykonywany</label><input type="text" name="uz_zawod" value="<?=$formularz['uz_zawod']?>"></div>
            <div class="form"><label>Data zatrudnienia</label><input class="data" type="text" name="uz_zatrudnienie" autocomplete="off" value="<?=$formularz['uz_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data końca zatrudnienia</label><input class="kdata" type="text" name="uz_kzatrudnienie" autocomplete="off" value="<?=$formularz['uz_kzatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Nazwa pracodawcy</label><input type="text" name="uz_pracodawca" class="pracodawca" value="<?=$formularz['uz_pracodawca']?>"></div>
            <div class="form"><label>NIP pracodawcy<a href="javascript:void(0);" onclick="findnip('uz_pracodawca')" class="findnip uz_pracodawca">Znajdź NIP</a></label><input type="text" name="uz_nip" value="<?=$formularz['uz_nip']?>"></div>
            <div class="form"><label>Telefon do pracodawcy</label><input type="text" name="uz_telefon" class="telefon" value="<?=$formularz['uz_telefon']?>"></div>
            <div class="form"><label>Ulica, numer budynku/lokalu</label><input type="text" name="uz_ulica" value="<?=$formularz['uz_ulica']?>"></div>
            <div class="form"><label>Kod pocztowy</label><input type="text" name="uz_kod_pocztowy" value="<?=$formularz['uz_kod_pocztowy']?>" placeholder="__-___"></div>
            <div class="form"><label>Miejscowość</label><input type="text" name="uz_miejscowosc" value="<?=$formularz['uz_miejscowosc']?>"></div>
            <div class="form">
            	<label>Województwo</label>
            	<select name="uz_wojewodztwo">
                    <option value=""></option>
                    <? foreach($wojewodztwo->result() as $dane) { ?>
                    <option value="<?=$dane->id?>"<?=$this->selected($dane->id, $formularz['uz_wojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form"><label>&nbsp;</label></div>
        </div>
        
		<header><h4>Umowa o dzieło</h4></header>
		<p class="less"><input type="checkbox" id="uod" name="uod" class="forma_dochodu"<?=$this->checked($formularz['uod'])?>><label for="uod">Zaznacz jeśli uzyskujesz dochód z tytułu umowy o dzieło</label></p>
        <div class="hr"></div>
        <div class="uod">
            <div class="form"><label>Miesięczny dochód netto</label><input type="text" class="kwota" name="uod_dochod" value="<?=$formularz['uod_dochod']?>" placeholder="średnia z ostatnich 12 miesięcy"><span>PLN</span></div>
            <div class="form"><label>Zawód wykonywany</label><input type="text" name="uod_zawod" value="<?=$formularz['uod_zawod']?>"></div>
            <div class="form"><label>Data zatrudnienia</label><input class="data" type="text" name="uod_zatrudnienie" autocomplete="off" value="<?=$formularz['uod_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data końca zatrudnienia</label><input class="kdata" type="text" name="uod_kzatrudnienie" autocomplete="off" value="<?=$formularz['uod_kzatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Nazwa pracodawcy</label><input type="text" name="uod_pracodawca" class="pracodawca" value="<?=$formularz['uod_pracodawca']?>"></div>
            <div class="form"><label>NIP pracodawcy<a href="javascript:void(0);" onclick="findnip('uod_pracodawca')" class="findnip uod_pracodawca">Znajdź NIP</a></label><input type="text" name="uod_nip" value="<?=$formularz['uod_nip']?>"></div>
            <div class="form"><label>Telefon do pracodawcy</label><input type="text" name="uod_telefon" class="telefon" value="<?=$formularz['uod_telefon']?>"></div>
            <div class="form"><label>Ulica, numer budynku/lokalu</label><input type="text" name="uod_ulica" value="<?=$formularz['uod_ulica']?>"></div>
            <div class="form"><label>Kod pocztowy</label><input type="text" name="uod_kod_pocztowy" value="<?=$formularz['uod_kod_pocztowy']?>" placeholder="__-___"></div>
            <div class="form"><label>Miejscowość</label><input type="text" name="uod_miejscowosc" value="<?=$formularz['uod_miejscowosc']?>"></div>
            <div class="form">
            	<label>Województwo</label>
            	<select name="uod_wojewodztwo">
                    <option value=""></option>
                    <? foreach($wojewodztwo->result() as $dane) { ?>
                    <option value="<?=$dane->id?>"<?=$this->selected($dane->id, $formularz['uod_wojewodztwo'])?>><?=$dane->wojewodztwo?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form"><label>&nbsp;</label></div>
        </div>
        
		<header><h4>Gospodarstwo rolne</h4></header>
		<p class="less"><input type="checkbox" id="gr" name="gr" class="forma_dochodu"<?=$this->checked($formularz['gr'])?>><label for="gr">Zaznacz jeśli uzyskujesz dochód z tytułu gospodarstwa rolnego</label></p>
        <div class="hr"></div>
        <div class="gr">
            <div class="form"><label>Data rozpoczęcia uzyskiwania bieżącego dochodu</label><input class="data" type="text" name="gr_zatrudnienie" autocomplete="off" value="<?=$formularz['gr_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Forma władania</label><select name="gr_wladanie"><option value=""></option><option value="Własność"<?=$this->selected('Własność', $formularz['gr_wladanie'])?>>Własność</option><option value="Dzierżawa"<?=$this->selected('Dzierżawa', $formularz['gr_wladanie'])?>>Dzierżawa</option></select></div>
            <div class="form"><label>Ilość Właścicieli/Dzierżawców</label><input type="text" name="gr_ilosc" value="<?=$formularz['gr_ilosc']?>"></div>
            <div class="form"><label>Urzędy gmin w których zarejestrowane są Gospodarstwa</label><input type="text" name="gr_urzedy" value="<?=$formularz['gr_urzedy']?>"></div>
            <div class="form"><label>Roczny dochód netto (na podstawie faktur)</label><input class="kwota" type="text" name="gr_dochod" value="<?=$formularz['gr_dochod']?>"><span>PLN</span></div>
            <div class="form"><label>Ilość hektarów</label><input type="text" name="gr_hektary" value="<?=$formularz['gr_hektary']?>"><span>ha</span></div>
            <div class="form"><label>NIP</label><input type="text" name="gr_nip" value="<?=$formularz['gr_nip']?>"></div>
        </div>
        
		<header><h4>Umowa najmu</h4></header>
		<p class="less"><input type="checkbox" id="un" name="un" class="forma_dochodu"<?=$this->checked($formularz['un'])?>><label for="un">Zaznacz jeśli uzyskujesz dochód z tytułu umowy najmu</label></p>
        <div class="hr"></div>
        <div class="un">
            <div class="form"><label>Miesięczny dochód netto</label><input type="text" class="kwota" name="un_dochod" value="<?=$formularz['un_dochod']?>" placeholder="średnia z ostatnich 12 miesięcy"><span>PLN</span></div>
            <div class="form"><label>Data rozpoczęcia uzyskiwania dochodu</label><input class="data" type="text" name="un_zatrudnienie" autocomplete="off" value="<?=$formularz['un_zatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>Data zakończenia uzyskiwania dochodu</label><input class="kdata" type="text" name="un_kzatrudnienie" autocomplete="off" value="<?=$formularz['un_kzatrudnienie']?>" placeholder="RRRR-MM-DD"></div>
            <div class="form"><label>&nbsp;</label></div>
        </div>

        <input type="submit" value="Zapisz zmiany">
    </form>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>