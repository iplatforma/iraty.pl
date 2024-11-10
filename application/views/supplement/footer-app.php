<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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

<a href="//ilease24.pl/kalkulator/pozyczka-leasingowa" target="_blank" class="ilease-button rwd-hide">Raty dla firm</a>

<footer id="bottom" class="full">
	<div class="justify">
    	<div class="box-3 inline">
        	<a href="https://ipay24.pl" target="_blank"><img src="/assets/gfx/icon/ipay24.png" alt="iPay24" /></a>
        </div>
    	<div class="box-3 inline">
        	<img src="/assets/gfx/icon/iplatnosci-brand.png?v=1.1" />        
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
            	<li><a href="tel://48508770470">+48 508 770 470</a></li>
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

<script type="text/javascript" src="<?=assets('js/mousewheel.min.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/growl.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/qtip.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/scrollbox.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/rules.js?v='.time())?>"></script>
<script type="text/javascript" src="<?=assets('js/validate.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/vmethods.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/pips.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/w-init.js?v='.time())?>"></script>
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