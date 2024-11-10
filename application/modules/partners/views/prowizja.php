<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li>Prowizja partnera</li></ul></section>

<article id="content" class="admin">
    <header><h3>Prowizja partnera</h3></header>
    <div class="hr less"></div>
    <table class="dane">
    	<tr>
            <th class="center">Miesiąc</th>
            <th class="right">Kwota</th>
            <th>Szczegóły</th>
        </tr>
    <? foreach($zestawienie->result() as $dane) { ?>    
		<tr>
            <td class="center"><?=date("Y-m",strtotime($dane->miesiac))?></td>
        	<td class="right"><?=$this->kwota($dane->kwota)?></td>
            <td><a href="<?=site_url('partner/zestawienie/'.date("Y-m",strtotime($dane->miesiac)).'')?>" title="Szczegółowe zestawienie"><i class="fa fa-eye "></i></a></td>
        </tr>
    <? } ?>
    </table>

</article>

<? $this->load->view('supplement/footer'); ?>