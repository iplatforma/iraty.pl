<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li><a href="<?=site_url('partner/prowizja')?>">Prowizja partnera</a></li><li>Zestawienie miesiąca <?=$this->uri->segment(3)?></li></ul></section>

<article id="content" class="admin">
    <header><h3>Zestawienie miesiąca <?=$this->uri->segment(3)?></h3></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
        	<th class="right">ID</th>
            <th class="right">Prowizja</th>
            <th class="right">Kwota</th>
            <th>Partner sprzedający</th>
            <th>Partner pośredniczący</th>
            <th class="center">Data</th>
        </tr>
    <? foreach($pobierz->result() as $dane) { ?>
		<tr>
        	<td class="right"><?=$dane->id?></td>
            <? if($dane->partner == $this->session->userdata('partner')) { ?>            
            <td class="right nowrap"><?=$dane->prowizja?>%</td>
            <td class="right nowrap"><?=$this->kwota($dane->kwota)?></td>
        	<td>---</td>
        	<td>---</td>
            <? } ?>
            <? if($dane->npartner == $this->session->userdata('partner')) { ?>            
            <td class="right nowrap"><?=$dane->nprowizja?>%</td>
            <td class="right nowrap"><?=$this->kwota($dane->nkwota)?></td>
        	<td><? if($dane->partner) { ?><strong><?=$this->partner($dane->partner)?></strong><? } else { ?>---<? } ?></td>
        	<td>---</td>
            <? } ?>
            <? if($dane->spartner == $this->session->userdata('partner')) { ?>            
            <td class="right nowrap"><?=$dane->sprowizja?>%</td>
            <td class="right nowrap"><?=$this->kwota($dane->skwota)?></td>
        	<td><? if($dane->partner) { ?><strong><?=$this->partner($dane->partner)?></strong><? } else { ?>---<? } ?></td>
        	<td><? if($dane->npartner) { ?><strong><?=$this->partner($dane->npartner)?></strong><? } else { ?>---<? } ?></td>
            <? } ?>
            <td class="center"><?=$dane->data?></td>
        </tr>
    <? } ?>
    </table>

</article>

<? $this->load->view('supplement/footer'); ?>