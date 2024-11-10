<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="crumbs" class="full">
	<div class="justify">
    	<ul>
        	<li><span>Krok 1</span><br /><span class="about">Parametry kredytu</span></li>
        	<li><span>Krok 2</span><br /><span class="about">Dane kredytobiorcy</span></li>
        	<li><span>Krok 3</span><br /><span class="about">Faktura</span></li>
        	<li class="active"><span>Krok 4</span><br /><span class="about">Podsumowanie</span></li>
        </ul>
    </div>
</section>

<section id="content" class="full padding center more">
	<div class="justify">
    
		<form id="dane" class="form" action="<?=site_url('wniosek/zapisz')?>" method="post" enctype="multipart/form-data">
        
        	<img src="/assets/gfx/icon/almost-done.png" />
            <p>&nbsp;</p>
        	<h2>Wniosek został zapisany</h2>
            
            <p>Dalsze informacje dotyczące dokończenia wniosku i zawarcia umowy zostaną przesłane na e-mail podany we wniosku.</p>
                        
            <div class="warning">
	            <h3>PAMIĘTAJ!</h3>
				<p>Złożenie wniosku jest równoznaczne z rezerwacją towaru przez sprzedającego. Po uruchomieniu wniosku otrzymasz towar z wybranego sklepu na podany w zamówieniu adres.</p>
            </div>
            
            <aside class="clear more"></aside>
            
        </form>  
        
    </div>
</section>


<? $this->load->view('supplement/footer-app'); ?>