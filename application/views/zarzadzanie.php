<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Zarządzanie</h2></header>
    </div>
</section>

<section id="main" class="managment full padding center">
<div class="justify">
    <a href="<?=site_url('zarzadzanie/podstrona')?>" class="button icon"><i class="fa fa-sitemap"></i> Zarządzaj podstronami</a>
    <a href="<?=site_url('zarzadzanie/blog')?>" class="button icon"><i class="fa fa-rss"></i> Zarządzaj blogiem</a>
    <a href="<?=site_url('zarzadzanie/faq')?>" class="button icon"><i class="fa fa-info-circle"></i> Zarządzaj FAQ</a>
    <a href="<?=site_url('zarzadzanie/menu')?>" class="button icon"><i class="fa fa-bars"></i> Zarządzaj menu</a>
</div>
</section>

<? $this->load->view('supplement/footer'); ?>