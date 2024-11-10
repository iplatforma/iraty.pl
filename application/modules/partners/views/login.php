<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? $this->load->view('supplement/header'); ?>

<?  ?>

<section id="front" class="wspolpraca">
	<div class="justify">
		<hgroup><h2>Partner</h2><h3>Logowanie dla partnerów serwisu</h3></hgroup>
    </div>
</section>

<section class="content center">
	<header>
    	<h3>Logowanie do panelu partnera</h3>
    </header>
    <div class="hr"></div>
	<form action="<?=site_url('partners/login')?>" enctype="multipart/form-data" method="post">
    	<input type="text" name="partner_login" placeholder="Twój ID">
    	<input type="password" name="partner_haslo" placeholder="Twoje hasło">
        <input type="submit" value="Zaloguj się">
    </form>
</section>

<? $this->load->view('supplement/footer'); ?>