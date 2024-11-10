<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Edytuj wpis</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>


<section id="main" class="full padding more">
	<div class="justify">
        <aside class="admin">
        	<a href="<?=site_url('zarzadzanie/blog')?>" class="button green icon" title="Wróc do listy"><i class="fa fa-arrow-left"></i> Cofnij</a>
        </aside>
        <div class="form admin">
        <form class="form" action="<?=site_url('blog/zapisz')?>" method="post">
            <div class="input">        
                <label>Nagłówek</label>
                <input type="text" name="title" placeholder="Nagłówek wpisu" value="<?=htmlspecialchars($wpis->title)?>" required>
			</div>
            <div class="input">        
                <label>Treść</label>
                <textarea name="tresc" placeholder="Treść wpisu"><?=$wpis->tresc?></textarea>
			</div>
            <input type="hidden" name="wpis" value="<?=$wpis->id?>">
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Zapisz zmiany">
        </form>
	</div>
	</div>
</section>

<? $this->load->view('supplement/footer'); ?>