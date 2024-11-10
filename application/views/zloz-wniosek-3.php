<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="crumbs" class="full">
	<div class="justify">
    	<ul>
        	<li><span>Krok 1</span><br /><span class="about">Parametry kredytu</span></li>
        	<li class="active"><span>Krok 2</span><br /><span class="about">Dane kredytobiorcy</span></li>
        	<li><span>Krok 3</span><br /><span class="about">Faktura</span></li>
        	<li><span>Krok 4</span><br /><span class="about">Podsumowanie</span></li>
        </ul>
    </div>
</section>

<section id="content" class="full padding more">
	<div class="justify">
    
		<form id="dane" class="form" action="<?=site_url('wniosek/dane/zapisz')?>" method="post" enctype="multipart/form-data">

	        <h3 class="center">Dane osobowe</h3>
			<div class="box-3 inline">
            	<label>Imię</label>
                <input type="text" name="imie" placeholder="Wypełnij" required>
            </div>
			<div class="box-3 inline">
            	<label>Nazwisko</label>
                <input type="text" name="nazwisko" placeholder="Wypełnij" required>
            </div>
			<div class="box-3 inline">
            	<label>PESEL</label>
                <input type="text" name="pesel" placeholder="Wypełnij" required>
            </div>
            
			<div class="left inline">
                <label>Numer telefonu</label>
                <input type="text" name="telefonkom" placeholder="Wypełnij" required>
            </div>
			<div class="right inline">
                <label>Adres e-mail</label>
                <input type="email" name="email" placeholder="Wypełnij" required>
            </div>

			<aside class="clear more"></aside>
            
            <div class="hr"></div>      

			<aside class="clear more"></aside>
            
            <div class="left inline"></div>
            <div class="right inline align-right">
            	<a href="javascript:void(0)" id="dalej" class="button blue">Przejdź do następnego kroku <i class="fa fa-arrow-right"></i></a>
            </div>

        </form>  
        
    </div>
</section>


<? $this->load->view('supplement/footer-app'); ?>