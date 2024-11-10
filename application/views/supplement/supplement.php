<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    	<div class="supp-category boxes">
        	<header><h4>Kategorie</h4></header>
            <ul class="category">
            	<? foreach(modules::run('wiedza_kategoria/pobierz')->result() as $kategoria) { ?>
                <li><a href="<?=$this->knowledge_category_link($kategoria->id)?>"<?=$this->active($this->uri->rsegment(3),$kategoria->id)?>><?=$kategoria->nazwa?></a></li>
                <? } ?>
                <li><a href="<?=site_url('wiedza-i-pomoc')?>">wszystkie</a></li>
            </ul>
        </div>
    	<div class="boxes">
        	<header><h4>Popularne tematy</h4></header>
            <div class="tags">
           	<? foreach(modules::run('wiedza/distinct_tag')->result() as $tag) { ?>
	             <span><a href="<?=site_url('wiedza-i-pomoc/tag/'.$tag->url)?>"><?=$tag->tag?></a></span>
             <? } ?>
             </div>
        </div>
    	<div id="knewsletter" class="boxes center bggrey">
			<p class="title">Bądź na bieżąco</p>
            <p>Zapisz się do naszego newslettera i nie przegap naszych porad:</p>
            <form action="<?=site_url('newsletter/dodaj')?>" method="post">
            	<input type="email" name="email" placeholder="Podaj adres e-mail" required>
                <input type="submit" value="Zapisz się">
            </form>
        </div>
