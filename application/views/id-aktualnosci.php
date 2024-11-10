<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section class="article full padding">
    <div class="justify wow fadeInUp">
    	<p>&nbsp;</p>
    	<p>&nbsp;</p>
        <header><h2 class="bigger white">Aktualności</h2></header>
    </div>
</section>

<article id="content" class="full padding less">
<div id="onenews" class="justify">
	<? if($dane->src) { ?>
            <a href="<?=assets('img/aktualnosci/'.$dane->src)?>" rel="galeria"><img src="<?=assets('img/aktualnosci/semi/'.$dane->src)?>"></a>
    <? } ?>
    <header><h3 class="small"><?=$dane->title?></h3></header>
    <?=$dane->tresc?>
    <div class="hr"></div>
    <aside class="clear"></aside>
    <p class="header bigger">Zobacz również</p>
    <? foreach($pozostale->result() as $wpis) { ?>
    <p><a href="<?=$this->news_link($wpis->id)?>"><?=$wpis->title?></a></p>
    <? } ?>
</div>
</article>

<? $this->load->view('supplement/footer'); ?>