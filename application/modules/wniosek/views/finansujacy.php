<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 
$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li><a href="<?=site_url('zarzadzanie/wnioski')?>">Lista wniosków</a></li><li>Lista finansujących</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Lista finansujących</h3>
    </header>
    <div class="hr"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="<?=current_url()?>#dodaj" rel="facebox" title="Dodaj finansującego"><i class="fa fa-plus"></i></a></li>
        </ul>
	</aside>
    	<div id="dodaj" class="hide">
        	<header><h3>Dodaj finansującego</h3></header>
            <form action="<?=site_url('wniosek/finansujacy/zapisz')?>" enctype="multipart/form-data" method="post">
				<input type="text" name="nazwa" placeholder="Nazwa finansującego">
                <input type="submit" value="Dodaj">
            </form>
        </div>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Nazwa</th>
            <th class="center">Narzędzia</th>
        </tr>
    <? foreach($finansujacy->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
            <td class="center"><?=$dane->nazwa?></td>
            <td class="center nowrap">
            	<a href="<?=current_url()?>#edytuj-<?=$dane->id?>" rel="facebox" title="Zmień status wniosku"><i class="fa fa-pencil"></i></a>
                <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń finansującego"><i class="fa  fa-close"></i></a>
			</td>
        </tr>
    <? } ?>
    </table>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

<div class="bottomline"></div>

    <? foreach($finansujacy->result() as $dane) { ?>
    	<div id="edytuj-<?=$dane->id?>" class="hide">
        	<header><h3>Edytuj dane finansującego</h3></header>
            <form action="<?=site_url('wniosek/finansujacy/zapisz')?>" enctype="multipart/form-data" method="post">
                <input type="text" name="nazwa" value="<?=$dane->nazwa?>">
                <input type="hidden" name="wpis" value="<?=$dane->id?>">
                <input type="submit" value="Zapisz zmianę">
            </form>
        </div>
    	<div id="usun-<?=$dane->id?>" class="hide">
        	<header><h3>Usuń finansującego</h3></header>
            <i class="fa  fa-close"></i>
            <p>Czy jesteś pewien, że chcesz usunąć finansującego <strong><?=$dane->nazwa?></strong>?</p>
            <p><a href="<?=site_url('wniosek/finansujacy/usun/'.$dane->id)?>">Tak, usuń finansującego!</a></p>
        </div>
    <? } ?>

<? $this->load->view('supplement/footer'); ?>