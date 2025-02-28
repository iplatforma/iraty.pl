<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Edytuj podstronę</h2></header>
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
                <label>Nazwa podstrony</label>
                <input type="text" name="header" placeholder="Nazwa podstrony" value="<?=$wpis->header?>" required>
            </div>
            <div class="input">
                <label>META Title</label>
                <input type="text" name="title" placeholder="Meta Title" value="<?=$wpis->title?>">
            </div>
			<div class="input">
                <label>META Keywords</label>
                <input type="text" name="keywords" placeholder="Meta Keywords" value="<?=$wpis->keywords?>">
            </div>
			<div class="input">
                <label>META Description</label>
                <input type="text" name="description" maxlength="150" placeholder="Meta Description" value="<?=$wpis->description?>">
            </div>
            <input type="hidden" name="wpis" value="<?=$wpis->id?>">
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Zapisz zmianę">
        </form>
        </div>

    </div>        
</section>

<? $this->load->view('supplement/footer'); ?>