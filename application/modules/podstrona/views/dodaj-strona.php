<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
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
        <form class="form" action="<?=site_url('podstrona/zapisz')?>" method="post">
            <div class="input">
                <label>Nazwa strony</label>
                <input type="text" name="header" placeholder="Nazwa strony" required>
            </div>
            <div class="input">
                <label>META Title</label>
                <input type="text" name="title" placeholder="Meta Title">
            </div>
			<div class="input">
                <label>META Keywords</label>
                <input type="text" name="keywords" placeholder="Meta Keywords">
            </div>
			<div class="input">
                <label>META Description</label>
                <input type="text" name="description" maxlength="150" placeholder="Meta Description">
            </div>
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Zapisz stronę">
        </form>
        </div>

    </div>        
</section>

<? $this->load->view('supplement/footer'); ?>