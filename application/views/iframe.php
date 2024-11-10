<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$meta['title']?></title>
<meta name="description" content="<?=$meta['description']?>">
<meta name="keywords" content="<?=$meta['keywords']?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
 <meta name="p:domain_verify" content="5f68c10e9acd87706582e775daffcd3e"/>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"  rel="stylesheet" type="text/css">
<link href="<?=assets('css/iframe.css')?>" rel="stylesheet" type="text/css">
<link rel="icon" href="<?=assets('gfx/favicon.ico')?>" type="image/x-icon">
<base href="<?=site_url()?>">
<meta name="robots" content="noindex, follow" />
<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-25449236-1', 'auto');
  ga('send', 'pageview');
</script>
</head>

<body id="calculator">

<header id="logo">
	<h1><a href="<?=site_url()?>" target="_blank"><img src="<?=assets('gfx/logo.png')?>" alt="Zakupy na raty"></a></h1>
</header>

<section class="content choice">
	<div class="justify">
		<div class="calculator">
    	<header><h2>Wniosek<br><span>Oblicz wysokość raty za towary i/lub usługi które chcesz sfinansować dzięki wygodnym ratom przez internet.</span></h2></header>
        <form target="_blank" id="kalkulator" action="<?=site_url('wniosek')?>" method="post">
            <div class="scontent pslider">
	            <h3>Kwota o jaką wnioskujesz</h3>
                <? if($this->uri->segment(3)) { ?>
                <input type="text" id="pieniadze" name="kwota" class="kwota" value="<?=$this->uri->segment(3)?>">
                <input type="hidden" id="pkwota" value="<?=$this->uri->segment(3)?>">
                <? } else { ?>
                <input type="text" id="pieniadze" name="kwota" class="kwota" value="2000">
                <input type="hidden" id="pkwota" value="2000">
                <? } ?>
            </div>
    
            <div class="scontent">
	            <h3>Na ile miesięcy?</h3>
                <select name="ilosc_rat" id="raty">
                	<? for($i=6;$i<=60;$i++) { ?> 
                	<option value="<?=$i?>"<?=$this->selected('18',$i)?>><?=$i?></option>
                	<? } ?>
                </select>
            </div>           
            <div class="checkbox">
            <input type="hidden" id="ubezpieczenie" name="ubezpieczenie" value="0">
            </div>
            <input type="hidden" name="partner" value="<?=$partner ? $partner['id'] : 0?>">
            <input type="hidden" class="ubezp" name="ubezp" value="<?=$this->load->ubezpieczenie()?>">
            <input type="hidden" id="rata" name="rata" value="0">
            <input type="hidden" class="oprocentowanie" name="oprocentowanie" value="<?=$partner?$this->load->oprocentowaniePartner($partner['id']):$this->load->oprocentowanie()?>">
            <input type="hidden" class="oprocentowanie_def" name="oprocentowanie_def" value="<?=$partner?$this->load->oprocentowaniePartner($partner['id']):$this->load->oprocentowanie()?>">
            <div class="result active">
                <div class="result-rata"><p><strong>Miesięczna rata:</strong> <span class="rata">0</span> zł</p></div>
                <div class="result-button"><a href="javascript:void(0)" id="start">Złóż wniosek przez internet<br><span>Bezpieczny, szyfrowany formularz SSL</span><i class="fa fa-arrow-right"></i></a></div>
            </div>
            <!--
            <div class="result active">
                <div class="result-rata"><i class="fa fa-mobile"></i><p class="txt">Możesz złożyć wniosek także telefonicznie!</p></div>
                <div class="result-button"><a href="javascript:void(0)" class="telefonicznie">Złóż wniosek telefonicznie<br><span>Wypełnij krótki formularz, oddzwonimy!</span><i class="fa fa-arrow-right"></i></a></div>
			</div>
            -->
        </form>
        </div>
    </div>
</section>

<script src="<?=assets('js/prefixfree.js')?>"></script>
<script src="<?=assets('js/wniosek.js')?>"></script>
<script src="<?=assets('js/validate.js')?>"></script>
<script src="<?=assets('js/vmethods.js')?>"></script>
<script src="<?=assets('js/iframe-init.js')?>"></script>
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