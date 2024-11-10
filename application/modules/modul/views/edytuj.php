<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Edytuj moduł</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding more">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('modul/'.$wpis->site)?>" class="button green icon" title="Wróc do listy"><i class="fa fa-arrow-left"></i> Cofnij</a>
        </aside>
        
        <div class="form admin">
		<form class="form" action="<?=site_url('modul/zapisz')?>" method="post">
        	<div class="input">
                <label>Robocza nazwa /nie wyświetlana/</label>
                <input type="text" name="header" value="<?=htmlspecialchars($wpis->header)?>" required>
            </div>
        	<div class="input">
                <label>Typ modułu</label>
                <select name="typ" required>
                	<option value="txt"<?=$this->selected('txt',$wpis->type)?>>Treść</option>
                	<option value="bg"<?=$this->selected('bg',$wpis->type)?>>Z tłem obrazkowym</option>
                	<option value="news"<?=$this->selected('news',$wpis->type)?>>Aktualności</option>
                	<option value="map"<?=$this->selected('map',$wpis->type)?>>Mapa</option>
                </select>
            </div>
			<div id="map" class="input<?=$wpis->type!='map'?' hide':NULL?>">
                <label>Współrzędne</label>
                <input type="text" id="lat_lng" name="lat_lng" value="<?=$wpis->lat_lng?>">
            </div>
        	<div class="input">
                <label>Kolor tła (HEX)</label>
                <input type="text" id="background_color" name="background_color" value="<?=$wpis->background_color?>">
            </div>
            <label>Treść modułu</label>
            <textarea class="tresc" name="tresc"><?=$wpis->text?></textarea>
        	<div class="input inline">
            	<label></label>
                <input type="hidden" name="site" value="<?=$wpis->site?>">
                <input type="hidden" name="wpis" value="<?=$this->uri->segment(3)?>">
	            <input type="submit" value="Zapisz moduł">
            </div>
        </form>
        </div>

    </div>        
</section>

<? $this->load->view('supplement/footer'); ?>