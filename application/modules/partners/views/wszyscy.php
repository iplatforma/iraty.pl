<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('admin/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('admin')?>">Panel administracyjny</a></li><li>Lista partnerów</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Lista partnerów</h3>
    </header>
    <div class="hr"></div>
    <aside class="admin">
    	<ul>
        	<li><a href="javascript:void(0);" id="filtrbox" title="Filtruj partnerów"><i class="fa fa-search"></i></a></li>
        	<li><a href="<?=site_url('partner/dodaj')?>" title="Dodaj nowego partnera"><i class="fa fa-cart-plus"></i></a></li>
        </ul>
	</aside>
	<? $this->load->view('filters'); ?>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th>Nazwa</th>
            <th class="right">NIP</th>
            <th>Telefon/e-mail</th>
            <th>Status</th>
            <th class="center">Narzędzia</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
        	<td><strong><a href="<?=site_url('partner/'.$dane->id)?>"><?=$dane->nazwa?></a></strong></td>
        	<td class="right"><?=$dane->nip?></td>
            <td><?=$dane->telefon?> / <?=$dane->email?></td>
            <td><?=$this->partner_status($dane->status)?></td>
            <td class="center nowrap">
            	<a href="<?=current_url()?>#status-<?=$dane->id?>" rel="facebox" title="Zmień status partnera"><i class="fa fa-external-link "></i></a>
                <a href="<?=site_url('partner/'.$dane->id)?>" title="Szczegóły partnera"><i class="fa fa-eye "></i></a>
                <a href="<?=current_url()?>#usun-<?=$dane->id?>" rel="facebox" title="Usuń partnera"><i class="fa  fa-close"></i></a>
			</td>
        </tr>
    <? } ?>
    </table>
    <div class="pagination"><?=$this->pagination->create_links()?></div>
</article>

    <? foreach($pobierz->result() as $dane) { ?>
    	<div id="status-<?=$dane->id?>" class="hide">
        	<header><h3>Zmień status partnera</h3></header>
            <form action="<?=site_url('partner/set_status')?>" enctype="multipart/form-data" method="post">
                <select name="status">
                    <option value="1"<?=$this->selected('1',$dane->status)?>>zablokowany</option>
                    <option value="2"<?=$this->selected('2',$dane->status)?>>aktywny</option>
                </select>
                <input type="hidden" name="wpis" value="<?=$dane->id?>">
                <input type="submit" value="Zapisz zmianę">
            </form>
        </div>
    	<div id="usun-<?=$dane->id?>" class="hide">
        	<header><h3>Usuń partnera</h3></header>
            <i class="fa  fa-close"></i>
            <p>Czy jesteś pewien, że chcesz usunąć partnera <strong><?=$dane->nazwa?></strong>?</p>
            <p><a href="<?=site_url('partner/usun/'.$dane->id)?>">Tak, usuń partnera!</a></p>
        </div>
    <? } ?>

<? $this->load->view('supplement/footer'); ?>