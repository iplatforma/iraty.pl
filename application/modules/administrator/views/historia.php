<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="header">
	<div class="justify">
		<ul class="crumbs">
        	<li><a href="<?=site_url()?>">Strona główna</a></li>
        	<li><a href="<?=site_url('zarzadzanie/administratorzy')?>">Zarządzanie administratorami</a></li>
            <li>Historia działań administratora</li>
        </ul>
    	<header><h2 class="less">Historia działań administratora</h2></header>
        <? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="padding">
	<div class="justify">
    	<aside class="admin">
        	<a href="<?=site_url('zarzadzanie/administratorzy')?>" class="button green icon"><i class="fa fa-lock"></i> Administratorzy</a>
        </aside>
    	<header class="heading"><h3><?=modules::run('administrator/pobierz',$this->uri->segment(3))->login?></h3></header>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
        <table class="dane">
        	<tr>
                <th>Działanie</th>
                <th>Data</th>
            </tr>
			<? foreach($pobierz->result() as $dane) { ?>
            <tr>
            	<td><?=$dane->dzialanie?></td>
            	<td><?=$dane->data?></td>
            </tr>
            <? } ?>
        </table>
		<? if($paginate) { ?><div class="pagination justify"><?=$paginate?></div><? } ?>
    </div>
</section>

<? $this->load->view('supplement/footer'); ?>