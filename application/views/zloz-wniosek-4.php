<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="crumbs" class="full">
	<div class="justify">
    	<ul>
        	<li><span>Krok 1</span><br /><span class="about">Parametry kredytu</span></li>
        	<li><span>Krok 2</span><br /><span class="about">Dane kredytobiorcy</span></li>
        	<li class="active"><span>Krok 3</span><br /><span class="about">Faktura</span></li>
        	<li><span>Krok 4</span><br /><span class="about">Podsumowanie</span></li>
        </ul>
    </div>
</section>

<section id="content" class="full padding more">
	<div class="justify">
    	<? 
		if($typ == 4) { ?>
		<form id="dane" class="form" action="<?=site_url('wniosek/uslugowy/zapisz')?>" method="post" enctype="multipart/form-data">	
        <? } else { ?>
		<form id="dane" class="form" action="<?=site_url('wniosek/faktura/zapisz')?>" method="post" enctype="multipart/form-data">
		<? } ?>

	        <h3 class="center">Dane do faktury VAT</h3>
			<div class="full center inline">
            	<label class="radio inline"> Osoba fizyczna
                	<input type="radio" data-wniosek="<?=$wniosek?>" name="faktura" value="fizyczna" checked="checked" id="fizyczna" required="required" />
                    <span class="checkmark"></span>
                </label>
            	<label class="radio inline"> Firma
                	<input type="radio" data-wniosek="<?=$wniosek?>" name="faktura" value="firma" id="firma" required="required" />
                    <span class="checkmark"></span>
                </label>
            </div>
            <aside class="clear"></aside>
            <div class="fizyczna">
                <div class="box-3 inline">
                    <label>Imię i nazwisko</label>
                    <input type="text" name="faktura_fizyczna_odbiorca" placeholder="Wypełnij" required>
                </div>
			</div>
            <div class="firma hide">
                <div class="box-3 inline">
                    <label>Nazwa firmy</label>
                    <input type="text" name="faktura_firma_odbiorca" placeholder="Wypełnij" required>
                </div>
                <div class="box-3 inline">
                    <label>NIP</label>
                    <input type="text" name="faktura_nip" placeholder="Wypełnij" required>
                </div>
			</div>
			<div class="box-3 inline">
            	<label>Ulica</label>
                <input type="text" name="faktura_ulica" placeholder="Wypełnij" required>
            </div>
			<div class="box-3 inline">
            	<label>Numer budynku (domu)</label>
                <input type="text" name="faktura_nrdom" placeholder="Wypełnij" required>
            </div>
			<div class="box-3 inline">
                <label>Numer lokalu</label>
                <input type="text" name="faktura_nrlokal" placeholder="Wypełnij">
            </div>
			<div class="box-3 inline">
                <label>Kod pocztowy</label>
                <input type="text" name="faktura_kod_pocztowy" placeholder="__-___" required>
            </div>
			<div class="box-3 inline">
                <label>Miejscowość</label>
                <input type="text" name="faktura_miejscowosc" placeholder="Wypełnij" required>
            </div>

			<aside class="clear more"></aside>
            
            <div class="hr"></div>

            <label class="checkbox strong switch">
            	Zaznacz wszystkie zgody
                <input type="checkbox" name="switch" />
                <span class="checkmark"></span>
            </label>
            
            <label class="checkbox">
            	Potwierdzam, że zapoznałem się z Klauzulą informacyjną dotyczącą przetwarzania danych osobowych przez Platforma sp. z o .o. <a href="/assets/files/klauzule-informacyjne.pdf" target="_blank">[ klauzule informacyjne ]</a>
                <input type="checkbox" name="zgoda" value="1" required="required" />
                <span class="checkmark"></span>
            </label>
            <label class="checkbox">			
            	Wyrażam zgodę na kontakt w celu poprawnej realizacji niniejszego żądania.
            	<input type="checkbox" name="agree2" value="1" required="required" />
                <span class="checkmark"></span>
            </label>
            <label class="checkbox">
            	Upoważnienie do odpytania w biurach informacji gospodarczej <a href="javascript:void()" data-href="biginfo">rozwiń</a>
            	<input type="checkbox" name="agree6" value="1" required="required" />
                <span class="checkmark"></span>
            </label>
            <div class="agree6 hide">
                <p>Na podstawie art. 24 ust. 1 ustawy z dnia 9 kwietnia 2010 roku o udostępnianiu informacji gospodarczych i wymianie danych gospodarczych (tj. Dz.U.2014 poz. 1015 ze. zm.) oraz na podstawie art. 105 ust. 4a i 4a1 ustawy z dnia 29 sierpnia 1997 roku - Prawo bankowe (tj. Dz.U.2017 poz. 1876 ze zm.) w związku z art. 13 ustawy o udostępnianiu informacji gospodarczych i wymianie danych gospodarczych niniejszym upoważniam: Platforma sp. z o.o. do pozyskania z Biura Informacji Gospodarczej InfoMonitor S.A. z siedzibą w Warszawie przy ul. Jacka Kaczmarskiego 77 (BIG InfoMonitor) dotyczących mnie informacji gospodarczych oraz do pozyskania za pośrednictwem BIG InfoMonitor danych gospodarczych z Biura Informacji Kredytowej S.A. (BIK) i Związku Banków Polskich (ZBP) dotyczących mojego wymagalnego od co najmniej 60 dni zadłużenia wobec banków lub instytucji upoważnionych do udzielania kredytów, przekraczającego 200 złotych (dwieście złotych) lub braku danych o takim zadłużeniu.</p>
				<p>Jednocześnie upoważniam ww. przedsiębiorcę do pozyskania z BIG InfoMonitor informacji dotyczących składanych zapytań na mój temat do Rejestru BIG InfoMonitor w ciągu ostatnich 12 miesięcy. <a href="/assets/files/informacja-przeznaczona-dla-konsumenta.pdf" target="_blank">[ Informacja przeznaczona dla konsumenta ]</a></p>
            </div>
            <label class="checkbox">
            	Oświadczam, że zapoznałem się z regulaminem sklepu(dostawcy) wybranego przeze mnie produktu finansowanego za pośrednictwem Platformy lub podmiotów powiązanych
            	<input type="checkbox" name="agree5" value="1" required="required" />
                <span class="checkmark"></span>
            </label>
            <label class="checkbox">
				Wyrażam zgodę na przedstawianie przez Platforma sp. z o.o. drogą telefoniczną informacji dotyczących ofert produktów i usług oferowanych przez Platforma sp. z o.o.
            	<input type="checkbox" name="marketing" value="1" />
				<span class="checkmark"></span>
            </label>
            <label class="checkbox">
                Oświadczam, że dokonuję zakupu towarów i/lub usług w systemie sprzedaży ratalnej jako Klient(Konsument) na użytek własny. 
                <input type="checkbox" name="agree4" value="1" required="required" />
                <span class="checkmark"></span>
            </label>

			<aside class="clear more"></aside>
            
            <div class="left inline"></div>
            <div class="right inline align-right">
            	<a href="javascript:void(0)" id="dalej" class="button blue">Przejdź do podsumowania <i class="fa fa-arrow-right"></i></a>
            </div>
            
            <p><?=$title?$title:NULL?></p>

        </form>  
        
    </div>
</section>


<? $this->load->view('supplement/footer-app'); ?>