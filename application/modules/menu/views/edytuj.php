<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<section id="banner" class="full normal">
	<div class="justify">
    	<header><h2 class="less">Edytuj wpis</h2></header>
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
                	<option value="header"<?=$this->selected('header',$wpis->typ)?>>główne menu</option>
                	<option value="footer"<?=$this->selected('footer',$wpis->typ)?>>stopka</option>
                </select>
			</div>
            <div class="input" data-typ="header">        
                <label>Link nadrzędny</label>
                <select name="parent">
                	<option value="0">brak</option>
                    <? foreach(modules::run('menu/pobierz_typ','header')->result() as $mheader) { ?>
                    <option value="<?=$mheader->id?>" data-type="header"<?=$this->selected($mheader->id,$wpis->parent)?><?=($wpis->typ!='header'?' style="display:none;"':NULL)?>><?=$mheader->nazwa?></option>
                    <? } ?>
                    <? foreach(modules::run('menu/pobierz_typ','footer')->result() as $mheader) { ?>
                    <option value="<?=$mheader->id?>" data-type="footer"<?=$this->selected($mheader->id,$wpis->parent)?><?=($wpis->typ!='footer'?' style="display:none;"':NULL)?>><?=$mheader->nazwa?></option>
                    <? } ?>
                </select>
			</div>
            <div class="input">        
                <label>Nazwa</label>
                <input type="text" name="nazwa" placeholder="Nazwa" value="<?=$wpis->nazwa?>" required>
			</div>
            <div class="input half">
            	<label class="checkbox"><input type="radio" name="link_type" id="bl" value="bl"<?=$this->checked('bl',$wpis->link_type)?>>Bez linkowania</label>
            	<label class="checkbox"><input type="radio" name="link_type" id="lz" value="lz"<?=$this->checked('lz',$wpis->link_type)?>>Link zewnętrzny</label>
            	<label class="checkbox"><input type="radio" name="link_type" id="lp" value="lp"<?=$this->checked('lp',$wpis->link_type)?>>Link do podstrony</label>
            </div>
            <div data-type="lz" class="input half<?=$wpis->link_type=='lz'?NULL:' hide'?>">
                <label>Link zewnętrzny</label>
                <input type="text" name="url" placeholder="Link zewnętrzny" value="<?=$wpis->url?>">
			</div>
            <div data-type="lp" class="input half<?=$wpis->link_type=='lp'?NULL:' hide'?>">
                <label>Link do podstrony</label>
                <select name="site">
	                <? foreach(modules::run('podstrona/pobierz')->result() as $podstrona) { if($podstrona->parent == NULL) { ?>
                	<option value="<?=$podstrona->id?>"<?=$this->selected($podstrona->id,$wpis->site)?>><?=$podstrona->header?></option>
                    <? if(modules::run('podstrona/parent',$podstrona->id)->num_rows() > 0) { foreach(modules::run('podstrona/parent',$podstrona->id)->result() as $ppodstrona) { ?>
                	<option value="<?=$ppodstrona->id?>"<?=$this->selected($ppodstrona->id,$wpis->site)?>><?=$podstrona->header?> &raquo; <?=$ppodstrona->header?></option>						
					<? }} ?>
                    <? }} ?>
                </select>
			</div>
            <input type="hidden" name="wpis" value="<?=$wpis->id?>">
            <div class="clear less"></div>
            <input type="submit" class="margin" value="Zapisz zmiany">
        </form>
	</div>
	</div>
</section>

<? $this->load->view('supplement/footer'); ?>