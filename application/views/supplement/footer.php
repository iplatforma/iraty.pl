<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? if($this->admin) { ?>
<aside class="settings">
	<a href="<?=site_url('zarzadzanie')?>" title="Zarządzanie"><i class="fa fa-cogs"></i></a>
</aside>
<? } ?>

<nav id="rwdmenu">
    <a id="openmenu" href="javascript:void(0);"><i class="fas fa-bars"></i></a>
    <ul>
		<li><a href="<?=site_url()?>">Strona główna</a></li>
		<? foreach(modules::run('menu/pobierz_typ','footer')->result() as $dane) { ?>
        <li>
            <? if($dane->url) { ?><a href="<?=$dane->url?>"><?=$dane->nazwa?></a>
            <? } else if($dane->site) { ?><a href="<?=$this->subsite_link($dane->site)?>"><?=$dane->nazwa?></a>
            <? } else if(!$dane->url and !$dane->site) { ?><a href="javascript:void(0)"><?=$dane->nazwa?></a><? } ?>
        </li>
        <? } ?>
    </ul>
</nav>

<? if(get_cookie('popup') != '1') { ?>
<section id="popup" class="full">
<div class="justify">
	<p>Ta strona używa plików cookies. <a href="<?=site_url('Polityka-prywatnosci')?>">Dowiedz się więcej</a> o celu ich używania i możliwości zmiany ustawień cookies w przeglądarce.</p>
    <a href="javascript:void(0)" id="remove"><i class="fa fa-times"></i></a>
</div>
</section>
<? } ?>

<footer id="bottom" class="full">
	<div class="justify">
    	<div class="box-3 inline">
        	<a href="https://ipay24.pl" target="_blank"><img src="/assets/gfx/icon/ipay24.png?v=1.1" alt="iPay24" /></a>
        </div>
    	<div class="box-3 inline">
        	<img src="/assets/gfx/icon/iplatnosci-brand.png?v=1.2" />        
        </div>
    	<div class="box-3 inline">
        	<ul class="social">
            	<!--
            	<li><a href=""><i class="fab fa-facebook"></i></a></li>
            	<li><a href=""><i class="fab fa-linkedin"></i></a></li>
            	<li><a href=""><i class="fab fa-youtube"></i></a></li>
                -->
            </ul>
        </div>
        <div class="footer-menu">
        	<ul>
            	<li><a href="tel://0048508770470">+48 508 770 470</a></li>
            	<li><a href="mailto://wnioski@ipay24.pl">wnioski@ipay24.pl</a></li>
				<? foreach(modules::run('menu/pobierz_typ','footer')->result() as $dane) { ?>
                <li>
                    <? if($dane->site == 1) { ?><a href="<?=site_url()?>"><?=$dane->nazwa?></a>
                    <? } else if($dane->url) { ?><a href="<?=$dane->url?>"><?=$dane->nazwa?></a>
                    <? } else if($dane->site) { ?><a href="<?=$this->subsite_link($dane->site)?>"><?=$dane->nazwa?></a>
                    <? } else if(!$dane->url and !$dane->site) { ?><a href="javascript:void(0)"><?=$dane->nazwa?></a><? } ?>
				</li>
				<? } ?>
            </ul>
        </div>
    </div>
</footer>

<script type="text/javascript" src="<?=assets('js/tinymce_3/tiny_mce.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/tiny-init.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/highlight.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/galeria.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/facebox.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/growl.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/qtip.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/wow.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/owl.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/modernizr.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/select.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/init.js?v='.time())?>"></script>
<?=$this->potwierdzenie()?>
<? $this->czysc(); ?>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 995221274;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/995221274/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

</body>
</html>
