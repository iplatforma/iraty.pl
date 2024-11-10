<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('supplement/header');

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url()?>">Strona główna</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li><a href="<?=site_url('wniosek/'.$formularz['id'])?>">Wniosek</a></li><li>Parametry pożyczki</li></ul></section>


<article id="content" class="wniosek">
	<form id="wniosek" action="<?=site_url('wniosek/zapisz/parametry/'.$formularz['id'])?>" method="post">
		<header><h4>Parametry pożyczki</h4></header>
        <div class="hr less"></div>
        <div class="form"><label>Ilość rat</label><input type="text" name="raty" value="<?=$formularz['raty']?>"></div>
        <div class="form"><label>Kwota pożyczki</label><input type="text" name="kwota" class="kwota" value="<?=$formularz['kwota']?>"></div>
        <div class="form"><label>Wpłata własna</label><input type="text" name="wplata" class="wplata" value="<?=$formularz['wplata']?>"></div>
        <input type="submit" value="Zapisz zmiany">
    </form>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>