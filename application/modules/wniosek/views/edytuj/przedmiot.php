<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('supplement/header');

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url()?>">Strona główna</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li><a href="<?=site_url('wniosek/'.$formularz['id'])?>">Wniosek</a></li><li>Szczegóły zakupu</li></ul></section>


<article id="content" class="wniosek">
	<form id="wniosek" action="<?=site_url('wniosek/zapisz/zakup/'.$formularz['id'])?>" method="post">
	<header><h4>Szczegóły zakupu</h4></header>
    <div class="hr less"></div>
        <div class="form">
            <label>Koszt wysyłki</label>
            <input type="text" name="wysylka" class="less kwota" value="<?=$formularz['wysylka']?>"><span>PLN</span>
        </div>
		<div id="produkt" class="internet">
        <? $i = 1; foreach($produkty->result() as $produkt) {?>
            <div class="produkt">
                <div class="form">
                    <label>Link do produktu</label>
                    <input type="text" name="produktlink_<?=$i?>" value="<?=$produkt->produkt?>">
                </div>
                <div class="form">
                    <label>Cena produktu</label>
                    <input type="text" name="cenalink_<?=$i?>" class="less kwota" value="<?=$produkt->cena?>"><span>PLN</span>
                    <? if($i > 1) {?><a href="javascript:void(0);" id="usun">Usuń ten produkt</a><? } ?>
                </div>       
            </div>
		<? $i++; } ?>       
        </div>
        <a href="javascript:void(0);" class="button produkt">Dodaj kolejny produkt</a>
        <input type="submit" value="Zapisz zmiany">
    </form>

</article>

<div class="bottomline"></div>

<? $this->load->view('supplement/footer'); ?>