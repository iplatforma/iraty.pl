<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section id="header" class="full">
	<div class="justify">
		<div class="left inline">
            <ul>
                <li><a href="/">Strona główna</a></li>
                <li>Blog</li>
            </ul>
            <header><h2>Blog</h2></header>
            <p>Cały proces zakupu na raty przebiega w 5 krokach, a decyzja o kredytowaniu pojawi się w ciągu kilku minut na Twoim ekranie.</p>
		</div>
        <div class="right inline">
            <div class="circle blog">
            	<img src="/assets/gfx/design/gfx-blog-1.png" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-1" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-2" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-3" />
            </div>
		</div>
    </div>
    <div class="bottom white"></div>
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-2" />
</section>

<section id="content" class="full padding">
	<div class="justify">
    	<? foreach(modules::run('blog/pobierz_limit',12)->result() as $dane) { ?>
        <div class="box-3 box-news inline">
        	<div class="thumb">
        	<? if($dane->src) { ?>
            	<a href="<?=$this->blog_link($dane->id)?>"><img src="/assets/img/blog/thumb/<?=$dane->src?>" /></a>
            <? } ?>
            </div>
            <div class="description">
            	<h4><a href="<?=$this->blog_link($dane->id)?>"><?=$dane->title?></a></h4>
                <p class="lead"><?=word_limiter(strip_tags($dane->tresc),30)?></p>
                <p><a href="<?=$this->blog_link($dane->id)?>" class="read-more">Czytaj więcej <i class="fa fa-arrow-right"></i></a></p>
            </div>
        </div>
		<? } ?>
    </div>
</section>
