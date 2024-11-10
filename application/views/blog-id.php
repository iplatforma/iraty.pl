<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="header" class="full center">
	<div class="justify narrow">
    	<ul>
        	<li><a href="/">Strona główna</a></li>
        	<li><a href="/blog">Blog</a></li>
        </ul>
        <header><h2><?=$dane->title?></h2></header>
        <a href="/blog" class="button orange"><i class="fa fa-arrow-left"></i> Wróć do listy bloga</a>
    </div>
    <div class="bottom white"></div>
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-2" />
</section>

<section id="content" class="full padding">
	<div class="justify narrow">
		<? if($dane->src) { ?>
            <img src="/assets/img/blog/semi/<?=$dane->src?>" />
	        <aside class="clear"></aside>
        <? } ?>
        <article class="article-content">
        <?=$dane->tresc?>
        </article>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>
