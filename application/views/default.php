<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
  
<? $this->load->view('supplement/header'); ?>

<section id="welcome" class="full padding">
	<div class="justify">
    	<div class="left minline">
            <h2>Swobodne,<br />bezpieczne i wygodne<br />zakupy na raty</h2>
            <a href="/zloz-wniosek" class="button orange inline">Złóż wniosek <i class="fa fa-arrow-right"></i></a>
            <a href="/procedura-zakupu" class="button transparent inline ">Jak to działa? <i class="fa fa-arrow-right"></i></a>
		</div>
        <div class="right minline">
        	<div class="circle">
            	<img src="/assets/gfx/bg/welcome-person.png" class="person" />
            	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball" />
            	<img src="/assets/gfx/bg/orange-ball.png" class="orange-small-ball" />
            	<img src="/assets/gfx/bg/orange-ball.png" class="orange-very-small-ball" />
                <div class="item item-1">
                	<p><i class="fa fa-check"></i> Kupujesz kiedy chcesz</p>
                </div>
                <div class="item item-3">
                	<p><i class="fa fa-check"></i> Ty wybierasz jaki sklep!</p>
                </div>
                <div class="item item-4">
                	<p><i class="fa fa-check"></i> Wybieraj co chcesz!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom"></div>
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-2" />
</section>

<section id="about" class="full padding">
	<div class="justify">
    	<div class="box-3 inline">
        	<h3>Swoboda<br />działania</h3>
            <p>Ty decydujesz, kiedy gdzie i co kupujesz: z dowolnego sklepu, w dogodnym momencie.</p>
        </div>
    	<div class="box-3 inline">
        	<h3>Bezpieczna<br />przestrzeń</h3>
            <p>100% ochrony. Przyjemność z zakupu bez ryzyka. Gwarancja bezpieczeństwa transakcji. </p>
        </div>
    	<div class="box-3 inline">
        	<h3>Wygoda<br />zakupu</h3>
            <p>Usiądź wygodnie, wybierz produkt, uzupełnij wniosek - decyzja w kilka minut na ekranie.</p>
        </div>
    </div>
</section>

<section id="products" class="full padding more">
	<div class="justify">
    	<div class="left inline">
        	<h4>Intuicyjna przestrzeń zakupowa 24/7</h4>
            <p>Nieograniczone możliwości</p>
            <a href="/faq" class="button white">Najczęściej zadawane pytania <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="right inline">
        	<div class="box-3 inline">
            	<img src="/assets/gfx/icon/our-products-1.png" style="max-height:36px;" />
                <p class="title">Dopasowane finansowanie dla firm i konsumentów</p>
            </div>
        	<div class="box-3 inline">
            	<img src="/assets/gfx/icon/our-products-2.png" />            
                <p class="title">Kredyt, leasing, odroczone płatności dla firm</p>
            </div>
        	<div class="box-3 inline">
            	<img src="/assets/gfx/icon/our-products-3.png" style="max-height:36px;" />
                <p class="title">Kompleksowe finansowanie zakupów online</p>
            </div>
		   	<img src="/assets/gfx/bg/arrow-top.png" class="arrow-top" />
		   	<img src="/assets/gfx/bg/arrow-bottom.png" class="arrow-bottom" />
        </div>
    </div>
    <div class="bottom"></div>
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-right" />
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-left" />
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

<? foreach($moduly->result() as $modul) { ?>

	<? if($modul->type=='txt' or $modul->type=='grey' or $modul->type=='news') { ?>
<section id="modules_<?=$modul->id?>" class="full padding<? if($modul->type=='grey') { ?> bggrey<? } ?>"<? if($modul->background_color) { ?> style="background-color:#<?=$modul->background_color?>"<? } ?>>
    <div class="justify wow fadeInUp">
        <?=$this->replace($modul->text)?>
    </div>
</section>
    <? } ?>
    
    <? if($modul->type=='bg') { ?>
    <div id="modules_<?=$modul->id?>" class="full background padding" style="background-image:url('<?=assets('img/background/'.$modul->background)?>');<? if($modul->background_color) { ?>background-color:#<?=$modul->background_color?><? } ?><? if($modul->parallax==1) { ?>background-size:cover;background-attachment:fixed;<? } ?>">
        <? if($modul->text) { ?>
        <div class="justify middle wow fadeInUp">
            <?=$modul->text?>
        </div>
        <? } else { ?>
        <img src="<?=assets('gfx/bg/rwdwrap.png')?>" class="rwdwrap">
        <? } ?>
    </div>
    <? } ?>

<? }?>

<? $this->load->view('supplement/footer'); ?>