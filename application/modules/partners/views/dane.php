<?
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('supplement/header'); 

$this->load->view('partners/settings');
?>

<section id="crumbs"><ul><li>Tu jesteś:</li><li><a href="<?=site_url('partner')?>">Panel partnera</a></li><li>Dane partnera</li></ul></section>

<article id="content" class="admin">
	<header>
    	<h3>Dane partnera</h3>
    </header>   
    <div class="hr less"></div>
    <table class="wniosek dane">
    	<tr>
        	<td class="header">Nazwa partnera</td>
            <td><?=$dane->nazwa?></td>
        	<td class="header">Skrócona nazwa partnera</td>
            <td><?=$dane->partner?></td>
        </tr>
    	<tr>
        	<td class="header">NIP</td>
            <td><?=$dane->nip?></td>
        	<td class="header"></td>
            <td></td>
        </tr>
        <tr>
        	<td class="header">Opiekun</td>
            <td><?=$dane->opiekun?></td>
        	<td class="header">Osoba kontaktowa</td>
            <td><?=$dane->osoba?></td>
        </tr>
    	<tr>
        	<td class="header">Telefon</td>
            <td><?=$dane->telefon?></td>
        	<td class="header">Adres e-mail</td>
            <td><?=$dane->email?></td>
        </tr>
    	<tr>
        	<td class="header">Numer konta bankowego</td>
            <td colspan="3"><?=$dane->konto?></td>
        </tr>
    </table>

</article>

<? $this->load->view('supplement/footer'); ?>