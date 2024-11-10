<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full">
	<div class="justify">
    	<header><h2 class="less">Panel administracyjny</h2></header>
    </div>
</section>

<section id="main" class="full padding">
<div class="justify narrow">
	<header><h3>Zaloguj się</h3></header>    
    <? if($this->admin) { ?>
    <p>Jesteś zalogowany do panelu administracyjnego.</p>
    <? } else { ?>
    <form class="form" method="post" action="<?=site_url('loguj')?>">
        <div class="input">
            <label>Login</label>
            <input type="text" name="login" placeholder="Login administratora" required>
        </div>
        <div class="admin">
            <label>Hasło dostępu</label>
            <input type="password" name="haslo" placeholder="Hasło dostępu" required>
        </div>
        <input type="submit" class="margin" value="Zaloguj się">
    </form>
    <? } ?>
    
</div>
</section>

<? $this->load->view('supplement/footer'); ?>