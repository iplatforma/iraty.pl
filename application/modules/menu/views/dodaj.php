<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Dodaj wpis</h2></header>
		<? $this->load->view('supplement/admin'); ?>
    </div>
</section>

<section id="main" class="full padding more">
	<div class="justify">
        <aside class="admin">
        	<a href="<?=site_url('zarzadzanie/menu')?>" class="button green icon" title="Wróc do listy"><i class="fa fa-arrow-left"></i> Cofnij</a>
        </aside>
        <div class="form admin">
        <form class="form" action="<?=site_url('menu/zapisz')?>" method="post">
            <div class="input">        
                <label>Umiejscowienie</label>
                <select data-select="pmenu" name="typ" required>
                	<option value="">--- wybierz ---</option>
                	<option value="header">główne menu</option>
                	<option value="footer">stopka</option>
                </select>
			</div>
            <div class="input" data-typ="header">        
                <label>Link nadrzędny</label>
                <select name="parent" disabled>
                	<option value="0">brak</option>
                    <? foreach(modules::run('menu/pobierz_typ','header')->result() as $mheader) { ?>
                    <option value="<?=$mheader->id?>" data-type="header"><?=$mheader->nazwa?></option>
                    <? } ?>
                    <? foreach(modules::run('menu/pobierz_typ','footer')->result() as $mheader) { ?>
                    <option value="<?=$mheader->id?>" data-type="footer"><?=$mheader->nazwa?></option>
                    <? } ?>
                </select>
			</div>
            <div class="input">        
                <label>Nazwa</label>
                <input type="text" name="nazwa" placeholder="Nazwa" required>
			</div>
            <div class="input half">
            	<label class="checkbox"><input type="radio" name="link_type" id="bl" value="bl" checked>Bez linkowania</label>
            	<label class="checkbox"><input type="radio" name="link_type" id="lz" value="lz">Link zewnętrzny</label>
            	<label class="checkbox"><input type="radio" name="link_type" id="lp" value="lp">Link do podstrony</label>
            </div>
            <div data-type="lz" class="input half hide">
                <label>Link zewnętrzny</label>
                <input type="text" name="url" placeholder="Link zewnętrzny">
			</div>
            <div data-type="lp" class="input half hide">
                <label>Link do podstrony</label>
                <select name="site">
	                <? foreach(modules::run('podstrona/pobierz')->result() as $podstrona) { if($podstrona->parent == NULL) { ?>
                	<option value="<?=$podstrona->id?>"><?=$podstrona->header?></option>
                    <? if(modules::run('podstrona/parent',$podstrona->id)->num_rows() > 0) { foreach(modules::run('podstrona/parent',$podstrona->id)->result() as $ppodstrona) { ?>
                	<option value="<?=$ppodstrona->id?>"><?=$podstrona->header?> &raquo; <?=$ppodstrona->header?></option>						
					<? }} ?>
                    <? }} ?>
                </select>
			</div>
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Dodaj wpis">
        </form>
        </div>
	</div>
</section>

<? $this->load->view('supplement/footer'); ?>