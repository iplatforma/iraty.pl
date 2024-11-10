<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$meta['title']?></title>
<meta name="Description" content="<?=$meta['description']?>" />
<meta name="Keywords" content="<?=$meta['keywords']?>" />
<meta name="author" content="www.iraty.pl">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<base href="<?=site_url()?>">
<link rel="canonical" href="<?=current_url()?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"  rel="stylesheet" type="text/css">
<link href="<?=assets('css/arkusz.css?v='.time())?>" rel="stylesheet" type="text/css">
<link href="<?=assets('css/responsive.css?v=1.5')?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>

<p class="back"><a href="<?=site_url()?>" target="_blank">Przejdź na <img src="/assets/gfx/logo.svg"></a></p>

<section id="content" class="full padding more">
	<div class="justify application">
    	<p>Jednym wnioskiem możesz sfinansować zakupy na raty dowolnej ilości produktów, wystarczy że w kolejnym kroku podasz nazwę towaru/usługi i cenę.</p>
        <aside class="clear"></aside>
		<form action="/wniosek/rozpocznij" method="post">
        	<h3>Wybierz kwotę o jaką wnioskujesz</h3>
			<div class="field">
            	<img src="/assets/gfx/icon/calculator-value.png">
                <input type="text" name="kwota" value="2000" autocomplete="off" required>
                <span class="suffix">zł</span>
            </div>        

        	<h3>Na ile miesięcy</h3>
            <div class="field" id="chooseMonths">
            	<img src="/assets/gfx/icon/calculator-installment.png">
            	<input type="text" name="ilosc" value="6" autocomplete="off" readonly required>
                <i class="fa fa-chevron-down"></i>
                <div class="dropdown">
                    <div class="scrollbar-inner">
                        <div class="scroll-inside">
                            <ul class="subvalue">
                                <? for($c=$min;$c<=$max;$c++) { ?>
                                <li data-value="<?=$c?>"><?=$c?></li>
                                <? } ?>
                            </ul>
						</div>
					</div>
                </div>
            </div>
        
        	<div class="slider-wrapper">
	            <div id="slider"></div>
                <div class="scale">
					<span class="value" style="left:1.4%"><?=$min?></span>
                <? 
					$c2 = 1; $step = round($max/10); for($c=($min+$step);$c<$max;$c+=$step) {
                ?>
					<span class="value" style="display:none;left:<?=$c?>%"><?=$c?></span>
				<? $c2++; } ?>
					<span class="value" style="left:99.7%"><?=$max?></span>
				</div>
            </div>
            
        	<aside class="clear"></aside>
        
        	<aside class="clear"></aside>
        	<div class="left inline">
                <div class="installment">
                    <span>100.00 zł</span>
                    <p>Miesięczna rata</p>
                </div>
			</div>
            <div id="navigator" class="right inline align-right">
            	<a href="javascript:void(0)" class="button orange">Złóż wniosek przez internet <i class="fa fa-arrow-right"></i></a>
                <img src="/assets/gfx/bg/santander.png">
                <span>Wniosek jest bezpieczny, szyfrowany formularz SSL</span>
            </div>
            <input type="hidden" name="rodzaj" value="1">
            <? if(1==2) { ?>
            <? if($formularz['info']) { ?>
            <input type="hidden" name="info" value="<?= $formularz['info'] ? $formularz['info'] : '' ?>">
            <? } ?>
            <input type="hidden" name="sklep" value="<?= $formularz['sklep'] ? $formularz['sklep'] : '' ?>">
            <input type="hidden" name="partner" value="<?= $formularz['partner'] ? $formularz['partner'] : 0 ?>">
            <input type="hidden" name="ubezpieczenie" id="ubezpieczenie" value="0">
            <input type="hidden" class="ubezp" name="ubezp" value="<?= $this->load->ubezpieczenie() ?>">
            <input type="hidden" class="oprocentowanie" name="oprocentowanie"
                   value="<?= $formularz['partner'] ? $this->load->oprocentowaniePartner($formularz['partner']) : $this->load->oprocentowanie() ?>">
            <input type="hidden" class="oprocentowanie_def" name="oprocentowanie_def"
                   value="<?= $formularz['partner'] ? $this->load->oprocentowaniePartner($formularz['partner']) : $this->load->oprocentowanie() ?>">
            <input type="hidden" class="oprocentowanie_zero" name="oprocentowanie_zero"
                   value="<?= $formularz['oprocentowanie_zero'] ?>">
            <input type="hidden" class="rabat_10p" name="rabat_10p" value="<?= $formularz['rabat_10p'] ?>">
            <input type="hidden" class="raty_oze" name="raty_oze" value="<?= $formularz['raty_oze'] ?>">
            <input type="hidden" class="partner_10p" name="partner_10p" value="<?= $formularz['partner_10p'] ?>">
            <input type="hidden" class="raty_10" name="raty_10" value="<?= $formularz['raty_10'] ?>">
            <input type="hidden" class="raty_1060" name="raty_1060" value="<?= $formularz['raty_1060'] ?>">
            <input type="hidden" name="rata" id="rata">
            <? } ?>
        </form>
        
        <div class="hr"></div>
        
        <p class="info">Obliczenia przeprowadzone za pomocą kalkulatora mają charakter orientacyjny i nie stanowią oferty w rozumieniu art.66 §1kc.</p>
        <p class="info">Kalkulator rat na naszej stronie pozwoli Ci sprawnie wyliczyć wysokość comiesięcznej składki w zależności od wybranej kwoty oraz okresu finansowania.<br>Jedyne co musisz zrobić to uzupełnić dwa pola. Pamiętaj, żeby podliczyć sumę wszystkich produktów, które chcesz wziąć na raty – nie zapomnij o desce elektrycznej dla syna, gitarze dla córki, a już na pewno o tej turbo lokówce dla żony lub dronie dla męża.</p>        
        
    </div>
</section>

<script type="text/javascript" src="<?=assets('js/mousewheel.min.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/scrollbox.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/pips.js')?>"></script>
<script type="text/javascript" src="<?=assets('js/w-init.js?v='.time())?>"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {

		rata();
		var mySelect = $('input[name="ilosc"]');
	
		var slider = $('#slider').slider({
		  min: <?=$min?>,
		  max: <?=$max?>,		  
		  value: mySelect.val(),
		  slide: function( event, ui ) {
			mySelect.val(ui.value);
			$('#chooseMonths ul li').removeClass('active');
			$('#chooseMonths ul li[data-value="'+ui.value+'"]').addClass('active');
			rata();
		  }
		}).slider('float');
	
		$('#chooseMonths ul li[data-value]').on( "click", function() {
			slider.slider( "value", parseInt($(this).data('value')));
			rata();
		});
		
});
</script>

</body>
</html>