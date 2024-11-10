<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body class="<?=$this->session->userdata('contrast')=='1'?' contrast':NULL?><?=$this->session->userdata('font')=='1'?' font':NULL?>">

<div style="text-align:center;margin:10% auto;">
	<img src="<?=assets('gfx/logo.png')?>">
    <p class="header">Przerwa techniczna</p>
</div>

</body>
</html>

<? die; ?>