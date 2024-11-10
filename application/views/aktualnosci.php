<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section class="article full padding">
    <div class="justify wow fadeInUp">
    	<p>&nbsp;</p>
    	<p>&nbsp;</p>
        <header><h2 class="bigger white">Aktualności</h2></header>
    </div>
</section>

<article id="content" class="full padding less bggrey">
<div class="justify">
	<? foreach($aktualnosci->result() as $news) { ?>
    <div class="box box-3 inline box-news">
        <div class="thumb">
        <? if($news->src) { ?>
            <a href="<?=$this->news_link($news->id)?>"><img src="<?=assets('img/aktualnosci/semi/'.$news->src)?>"></a>
        <? } ?>
        </div>
        <div class="description">
            <p class="title"><a href="<?=$this->news_link($news->id)?>"><?=$news->title?></a></p>
            <p><?=word_limiter(strip_tags($news->tresc),25,'&nbsp;(...)')?></p>
        </div>
    </div>
    <? } ?>
</div>
</article>

<? $this->load->view('supplement/footer'); ?>