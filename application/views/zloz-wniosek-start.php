<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="content" class="full padding">
	<div class="justify application"<?=($oneMonth==1?' data-one-moth="1"':NULL)?>>
    
    	<div class="app-header">
	    	<h2>Wniosek ratalny <span class="linia l-start">linia kredytowa</span></h2>
        </div>
                
        <aside class="clear"></aside>
		<form id="kalkulator" action="<?=site_url('wniosek')?>" method="post">
        	<h3>Wybierz kwotę o jaką wnioskujesz</h3>
			<div class="field">
            	<img src="/assets/gfx/icon/calculator-value.png">
                <input type="text" id="pieniadze" name="kwota" value="<?=$this->uri->segment(3)?$this->uri->segment(3):'2000'?>" autocomplete="off" required>
                <span class="suffix">zł</span>
            </div>        

        	<h3>Na ile miesięcy</h3>
            <div class="field" id="chooseMonths">
            	<img src="/assets/gfx/icon/calculator-installment.png">
            	<input type="text" id="raty" name="ilosc_rat" value="<?=($selected?$selected:$min)?>" autocomplete="off" readonly required>
                <i class="fa fa-chevron-down"></i>
                <div class="dropdown">
                    <div class="scrollbar-inner">
                        <div class="scroll-inside">
                            <ul class="subvalue">
                                <? for($c=$min;$c<=$max;$c++) { ?>
                                <li data-value="<?=$c?>"><?=$c?></li>
                                <? } ?>
                            </ul>
						</div>
					</div>
                </div>
            </div>
        
        	<div class="slider-wrapper">
	            <div id="slider"></div>
                <div class="scale">
					<span class="value" style="left:1.4%"><?=$min?></span>
                <? 
					$c2 = 1; $step = round($max/10); for($c=($min+$step);$c<$max;$c+=$step) {
                ?>
					<span class="value" style="display:none;left:<?=$c?>%"><?=$c?></span>
				<? $c2++; } ?>
					<span class="value" style="left:99.7%"><?=$max?></span>
				</div>
            </div>
            
        	<aside class="clear"></aside>
			
			<? if($selected == 120) { ?>
            <div class="info-border">
                <p>Symulacja na 120 miesięcy: Niska rata - większa zdolność kredytowa. Masz możliwość skrócenia okresu kredytowania w dowolnym momencie - otrzymasz zwrot kosztów kredytu.</p>
            </div>
            <? } ?>
        
        	<aside class="clear"></aside>
        	<div class="left inline">
                <div class="installment">
                    <span class="rata">57.33 zł</span>
                    <p>Miesięczna rata</p>
                </div>
			</div>
            <div id="navigator" class="right inline align-right">
            	<? if($this->uri->segment(4) == '0') { ?>
                <h3>Aby kupić ten produkt na raty, wybierz iRaty w koszyku</h3>
                <? } else { ?>
            	<a href="javascript:void(0)" id="start" class="button blue">Złóż wniosek przez internet <i class="fa fa-arrow-right"></i></a>
                <? } ?>
            </div>
                <input type="hidden" id="ubezpieczenie" name="ubezpieczenie" value="0">
				<? if(isset($_REQUEST['partner'])) { ?><input type="hidden" name="partner" value="<?=$_REQUEST['partner']?>"><? } else { ?><input type="hidden" name="partner" value="<?=$partner ? $partner['id'] : 0?>"><? } ?>
                <input type="hidden" class="ubezp" name="ubezp" value="<?=$this->load->ubezpieczenie()?>">
                <input type="hidden" id="rata" name="rata" value="0">
                <input type="hidden" class="oprocentowanie" name="oprocentowanie" value="<?=$partner?$this->load->oprocentowaniePartner($partner['id']):$this->load->oprocentowanie()?>">
                <input type="hidden" class="oprocentowanie_def" name="oprocentowanie_def" value="<?=$partner?$this->load->oprocentowaniePartner($partner['id']):$this->load->oprocentowanie()?>">
                <input type="hidden" class="oprocentowanie_zero" name="oprocentowanie_zero" value="<?=$partner['oprocentowanie_zero']=='1'?'1':'0'?>">
                <input type="hidden" class="rabat_10p" name="rabat_10p" value="<?=$partner['rabat_10p']=='1'?'1':'0'?>">
                <input type="hidden" class="raty_oze" name="raty_oze" value="<?=$partner['raty_oze']=='1'?'1':'0'?>">
                <input type="hidden" class="raty_10" name="raty_10" value="<?=$partner['raty_10']=='1'?'1':'0'?>">
                <input type="hidden" class="raty_1060" name="raty_1060" value="<?=$partner['raty_1060']=='1'?'1':'0'?>">

                <input type="hidden" id="inne_raty" name="inne_raty" value="1" />
                <?php if (is_array($partner['oprocentowanie_raty']) && count($partner['oprocentowanie_raty']) > 0): ?>
                    <script>
                        let inne_raty = <?= json_encode($partner['oprocentowanie_raty']) ?>;
                    </script>
                <?php else: ?>
                    <input type="hidden" id="inne_raty" name="inne_raty" value="1" />
                    <script>
                        let inne_raty = <?= json_encode($this->load->oprocentowanie_przedzialy()) ?>;
                    </script>
                <?php endif ?>

                <? if(isset($_REQUEST['info'])) { ?><input type="hidden" name="info" value ="<?=$_REQUEST['info']?>"><? } ?>
                <? if(isset($_REQUEST['sklep'])) { ?><input type="hidden" name="sklep" value ="<?=$_REQUEST['sklep']?>"><? } ?>

				<? if($partner['oprocentowanie_zero']) { ?>
					<input type="hidden" name="promotype" value="zero">
				<? } else if($partner['raty_10']) { ?>
                    <input type="hidden" name="promotype" value="half-10">
                <? } else if($partner['raty_1060']) { ?>
                    <input type="hidden" name="promotype" value="half-1060">
                <? } ?>
				
			
                <? if($partner['raty_oze']) { ?>
                    <p class="header orange">Partner OZE</p>
                <? } else if($partner['oprocentowanie_zero']) { ?>
                    <p class="header orange" data-type="zero">10 rat 0%</p>
                <? } else if($partner['rabat_10p']) { ?>
                    <p class="header orange rabat_10p">Rabat 10%</p>
                <? } else if($partner['raty_10']) { ?>
                    <p class="header orange" data-type="half-10">Stałe raty 0,5% miesięcznie na 10 miesięcy</p>
                <? } else if($partner['raty_1060']) { ?>
                    <p class="header orange" data-type="half-1060">Stałe raty 0,5% miesięcznie od 10 do 60 miesięcy</p>
                <? } ?>

        </form>
        
        <div class="hr"></div>
        
        <p class="info">Obliczenia przeprowadzone za pomocą kalkulatora mają charakter orientacyjny i nie stanowią oferty w rozumieniu art.66 §1kc.</p>
        <p class="info">Kalkulator rat na naszej stronie pozwoli Ci sprawnie wyliczyć wysokość comiesięcznej składki w zależności od wybranej kwoty oraz okresu finansowania.
Uzupełnij dwa pola i dostosuj raty do swoich potrzeb.<br />Pamiętaj, żeby podliczyć sumę wszystkich produktów, które chcesz wziąć na raty . Jednym wnioskiem sfinansuj wszystkie zakupy.</p>        
        
    </div>
</section>

<script type="text/javascript">
jQuery(document).ready(function($) {

		var mySelect = $('input[name="ilosc_rat"]');
	
		<? if($min and $max) { ?>
		var slider = $('#slider').slider({
		  min: <?=$min?>,
		  max: <?=$max?>,		  
		  value: mySelect.val(),
		  slide: function( event, ui ) {
			mySelect.val(ui.value);
			$('#chooseMonths ul li').removeClass('active');
			$('#chooseMonths ul li[data-value="'+ui.value+'"]').addClass('active');
		  }
		}).slider('float');
	
		$('#chooseMonths ul li[data-value]').on( "click", function() {
			slider.slider( "value", parseInt($(this).data('value')));
		});
		<? } ?>
		
});
</script>

<? $this->load->view('supplement/footer-app'); ?>