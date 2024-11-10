<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Dodaj podstronę</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('zarzadzanie/podstrona')?>" class="button green icon" title="Wróc do listy"><i class="fa fa-arrow-left"></i> Cofnij</a>
        </aside>      
        <div class="form admin">
		<form class="form" action="<?=site_url('modul/zapisz')?>" method="post">
        	<div class="input">
                <label>Robocza nazwa /nie wyświetlana/</label>
                <input type="text" name="header" required>
            </div>
        	<div class="input">
                <label>Typ modułu</label>
                <select name="typ" required>
                	<option value="txt">Treść</option>
                	<option value="bg">Z tłem obrazkowym</option>
                	<option value="news">Aktualności</option>
                	<option value="map">Mapa</option>
                </select>
            </div>
			<div id="map" class="input hide">
                <label>Współrzędne</label>
                <input type="text" id="lat_lng" name="lat_lng">
            </div>
        	<div class="input">
                <label>Kolor tła (HEX)</label>
                <input type="text" id="background_color" name="background_color">
            </div>
            <label>Treść modułu</label>
            <textarea class="tresc" name="tresc"></textarea>
        	<div class="input inline">
            	<label></label>
                <input type="hidden" name="site" value="<?=$this->uri->segment(2)?>">
	            <input type="submit" value="Zapisz moduł">
            </div>
        </form>
        </div>

    </div>        
</section>

<? $this->load->view('supplement/footer'); ?>