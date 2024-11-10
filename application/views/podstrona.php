<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header'); ?>

<?
if(modules::run('podstrona/url',$this->uri->segment(1))) {
	if (is_file(APPPATH.'views/' . $this->uri->segment(1) . '.php')) {
		@$this->load->view($this->uri->segment(1));
	}
}
?>

<? foreach($moduly->result() as $modul) { ?>

	<? if($modul->type=='txt') { ?>
    <section id="modules_<?=$modul->id?>" class="article full padding"<? if($modul->background_color) { ?> style="background-color:#<?=$modul->background_color?>"<? } ?>>
        <div class="justify wow fadeInUp">
			<?=$this->replace($modul->text)?>
        </div>
    </section>
    <? } ?>
    
    <? if($modul->type=='bg') { ?>
    <div id="modules_<?=$modul->id?>" class="full background padding<?=$modul->parallax?' parallax':NULL?>" style="background-image:url('<?=assets('img/background/'.$modul->background)?>');<? if($modul->background_color) { ?>background-color:#<?=$modul->background_color?><? } ?>">
        <? if($modul->text) { ?>
        <div class="justify middle  wow fadeInUp">
			<?=$this->replace($modul->text)?>
        </div>
        <? } else { ?>
        <img src="<?=assets('gfx/bg/rwdwrap.png')?>" class="rwdwrap">
        <? } ?>
    </div>
    <? } ?>
        
    <? if($modul->type=='map') { $latlng = explode(',',$modul->lat_lng); ?>
    <div id="map[<?=$modul->id?>]" data-lat="<?=trim($latlng[0])?>" data-lng="<?=trim($latlng[1])?>" class="full map">
    </div>
    <? } ?>
    
<? } ?>

<? $this->load->view('supplement/footer'); ?>