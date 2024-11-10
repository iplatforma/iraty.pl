<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Dodaj wpis</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="full padding more">
	<div class="justify">
        <aside class="admin">
        	<a href="<?=site_url('zarzadzanie/faq')?>" class="button green icon" title="Wróc do listy"><i class="fa fa-arrow-left"></i> Cofnij</a>
        </aside>
        <div class="form admin">
        <form class="form" action="<?=site_url('faq/zapisz')?>" method="post">
            <div class="input">        
                <label>Nagłówek</label>
                <input type="text" name="title" placeholder="Nagłówek wpisu" required>
			</div>
            <div class="input">        
                <label>Kategoria</label>
				<select name="kategoria">
                	<? foreach(modules::run('faq/kategorie_limit','all')->result() as $kategoria) { ?>
                	<option value="<?=$kategoria->id?>"><?=$kategoria->kategoria?></option>
                    <? } ?>
                </select>
			</div>
            <div class="input">        
                <label>Treść</label>
                <textarea name="tresc" placeholder="Treść wpisu"></textarea>
			</div>
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Dodaj wpis">
        </form>
        </div>
	</div>
</section>

<? $this->load->view('supplement/footer'); ?>