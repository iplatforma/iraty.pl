<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section id="header" class="full">
	<div class="justify">
		<div class="left inline">
            <ul>
                <li><a href="/">Strona główna</a></li>
                <li>FAQ</li>
            </ul>
            <header><h2>FAQ</h2></header>
            <p>Chcesz dowiedzieć się więcej? Przeczytaj odpowiedzi na najczęściej zadawane pytania związane z procedurą zakupu na raty.<br />Nie ma tu odpowiedzi na Twoje pytanie? <strong><a href="/kontakt">Skontaktuj się z nami.</a></strong></p>
		</div>
        <div class="right inline">
            <div class="circle faq">
            	<img src="/assets/gfx/design/gfx-faq-1.png" />
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
	<div class="justify small">
    
    	<? foreach(modules::run('faq/kategoria')->result() as $kategoria) { ?>
        
    	<h3><?=$kategoria->kategoria?></h3>
        
        <section class="accordion">
	    	<? foreach(modules::run('faq/pobierz_kategoria',$kategoria->id)->result() as $dane) { ?>
        	<article>
            	<h4><a href="javascript:void(0)"><?=$dane->title?><i class="fa fa-arrow-down"></i></a></h4>
                <div class="content">
					<?=$dane->tresc?>
                </div>
            </article>
			<? } ?>
        </section>

        <aside class="clear"></aside>
        
        <? } ?>
        
    </div>
</section>

<section id="certificates" class="full center padding">
	<div class="justify">
    	<h3>Nasze certyfikaty</h3>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-1.png" />
        </div>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-2.png" />
        </div>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-3.png" />
        </div>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-4.png" />
        </div>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-5.png" />
        </div>
        <div class="box-6 inline">
        	<img src="/assets/gfx/icon/certificate-6.png" />
        </div>
    </div>
</section>
