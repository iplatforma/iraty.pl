<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$meta['title']?></title>
<meta name="Description" content="<?=$meta['description']?>" />
<meta name="Keywords" content="<?=$meta['keywords']?>" />
<script src="//code.tidio.co/fyjljyf5tsw9zcx1xaraznvzezc4hihx.js"></script>
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
<link href="<?=assets('css/responsive.css?v='.time())?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1YWPE1C5MY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1YWPE1C5MY');
</script>
</head>

<body>

<div id="header" class="full">
<div class="justify">

	<div class="left inline">
		<header id="logo"><h1><a href="<?=site_url()?>"><img src="<?=assets('gfx/logo.svg')?>"></a></h1></header>
    </div>
    
	<div class="right inline">
        <nav id="menu" class="full wow fadeInLeft">
            <ul>
                <? foreach(modules::run('menu/pobierz_typ','header')->result() as $dane) { ?>
                <li>
                    <? if($dane->site == 1) { ?><a href="<?=site_url()?>"><?=$dane->nazwa?></a>
					<? } else if($dane->url) { ?><a href="<?=$dane->url?>"><?=$dane->nazwa?></a>
                    <? } else if($dane->site) { ?><a href="<?=$this->subsite_link($dane->site)?>"><?=$dane->nazwa?></a>
                    <? } else if(!$dane->url and !$dane->site) { ?><a href="javascript:void(0)"><?=$dane->nazwa?></a><? } ?>
                    
					<? if(modules::run('menu/parent',$dane->id)->num_rows() > 0) { ?>
                    <div class="submenu">
                        <ul>
                            <? foreach(modules::run('menu/parent',$dane->id)->result() as $child) { ?>
                                <li>
                                <? if($child->url) { ?><a href="<?=$dane->url?>"><?=$child->nazwa?></a>
                                <? } else if($child->site) { ?><a href="<?=$this->subsite_link($child->site)?>"><?=$child->nazwa?></a>
                                <? } else if(!$child->url and !$child->site) { ?><a href="javascript:void(0)"><?=$child->nazwa?></a><? } ?>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                    <? } ?>
                    
                </li>
                <? } ?>
            </ul>
        </nav>
	</div>
        
</div>
<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-1">
</div>
