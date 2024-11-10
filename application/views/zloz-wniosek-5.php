<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="crumbs" class="full">
	<div class="justify rwd-hide">
    	<ul>
        	<li><span>Krok 1</span><br /><span class="about">Parametry kredytu</span></li>
        	<li><span>Krok 2</span><br /><span class="about">Dane kredytobiorcy</span></li>
        	<li><span>Krok 3</span><br /><span class="about">Faktura</span></li>
        	<li class="active"><span>Krok 4</span><br /><span class="about">Podsumowanie</span></li>
        </ul>
    </div>
</section>

<section id="content" class="full padding center more rwd-padding-small">
	<div class="justify">
    
		<form id="dane" class="form" action="<?=site_url('wniosek/zapisz')?>" method="post" enctype="multipart/form-data">
        
        	<img src="/assets/gfx/icon/almost-done.png" />
            <p>&nbsp;</p>
        	<h2>No i prawie gotowe...</h2>
            
            <div id="navigator" class="full center">
            	<a href="javascript:void(0)" id="dalej" class="button blue bigger">Ok, teraz wybierz warunki spłaty <i class="fa fa-arrow-right"></i></a>
                <br />
                <img src="/assets/gfx/bg/santander.png">
                <p><span class="thin">Wniosek jest bezpieczny,<br />szyfrowany formularz SSL</span></p>
            </div>
			
            <div class="warning">
	            <h3>PAMIĘTAJ!</h3>
				<p>Złożenie wniosku jest równoznaczne z rezerwacją towaru przez sprzedającego. Po uruchomieniu wniosku otrzymasz towar z wybranego sklepu na podany w zamówieniu adres.</p>
            </div>
            
            <div class="tip">
				<h3>Warto wiedzieć:</h3>
				<ul>
                    <li>Wraz ze wzrostem ilości rat maleje koszt kredytu w ujęciu miesięcznym, a dodatkowo wydłużenie okresu kredytowania wpływa pozytywnie na zwiększenie zdolności kredytowej.</li>
                    <li>Klienci którzy deklarują koszty utrzymania nie wyższe niż 500 zł i nie posiadają dzieci w 90% przypadków otrzymują pozytywną decyzję kredytową.</li>
                    <li>W kolejnych krokach uzupełnisz dane i otrzymasz decyzję kredytową błyskawicznie na ekranie</li>
                </ul>
			</div>
                        
            <div id="navigator" class="full center">
            	<a href="javascript:void(0)" id="dalej" class="button blue bigger">Ok, teraz wybierz warunki spłaty <i class="fa fa-arrow-right"></i></a>
                <br />
                <img src="/assets/gfx/bg/santander.png">
                <p><span class="thin">Wniosek jest bezpieczny,<br />szyfrowany formularz SSL</span></p>
            </div>

        </form>  
        
    </div>
</section>


<? $this->load->view('supplement/footer-app'); ?>