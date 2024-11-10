<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="content" class="full padding">
	<div class="justify application">
    
    	<div class="app-header">
	    	<h2>Wniosek ratalny</h2>
    	    <p>Interesuje Cię nowy telewizor? Możesz wybrać wniosek ratalny.  Chcesz w tym roku pojechać na wakacje do Azji?  Potrzebna Ci będzie gotówka, więc wiesz już co kliknąć.</p>
        </div>
        
        <div class="hr more"></div>
        
    	<p>Jednym wnioskiem możesz sfinansować zakupy na raty dowolnej ilości produktów, wystarczy że w kolejnym kroku podasz nazwę towaru/usługi i cenę.</p>
        <aside class="clear"></aside>
		<form action="/wniosek/rozpocznij" method="post">
        	<h3>Wybierz kwotę o jaką wnioskujesz</h3>
			<div class="field">
            	<img src="/assets/gfx/icon/calculator-value.png">
                <input type="text" name="kwota" value="2000" autocomplete="off" required>
                <span class="suffix">zł</span>
            </div>        

        	<h3>Na ile miesięcy</h3>
            <div class="field" id="chooseMonths">
            	<img src="/assets/gfx/icon/calculator-installment.png">
            	<input type="text" name="ilosc" value="6" autocomplete="off" readonly required>
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
        
        	<aside class="clear"></aside>
        	<div class="left inline">
                <div class="installment">
                    <span>100.00 zł</span>
                    <p>Miesięczna rata</p>
                </div>
			</div>
            <div id="navigator" class="right inline align-right">
            	<a href="javascript:void(0)" class="button blue">Złóż wniosek przez internet <i class="fa fa-arrow-right"></i></a>
                <img src="/assets/gfx/bg/santander.png">
                <span>Wniosek jest bezpieczny, szyfrowany formularz SSL</span>
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

                <? if($partner['raty_oze']) { ?>
                    <p class="header green">Partner OZE</p>
                <? } else if($partner['oprocentowanie_zero']) { ?>
                    <p class="header green">10 rat 0%</p>
                <? } else if($partner['rabat_10p']) { ?>
                    <p class="header green rabat_10p">Rabat 10%</p>
                <? } ?>

        </form>
        
        <div class="hr"></div>
        
        <p class="info">Obliczenia przeprowadzone za pomocą kalkulatora mają charakter orientacyjny i nie stanowią oferty w rozumieniu art.66 §1kc.</p>
        <p class="info">Kalkulator rat na naszej stronie pozwoli Ci sprawnie wyliczyć wysokość comiesięcznej składki w zależności od wybranej kwoty oraz okresu finansowania.<br>Jedyne co musisz zrobić to uzupełnić dwa pola. Pamiętaj, żeby podliczyć sumę wszystkich produktów, które chcesz wziąć na raty – nie zapomnij o desce elektrycznej dla syna, gitarze dla córki, a już na pewno o tej turbo lokówce dla żony lub dronie dla męża.</p>        
        
    </div>
</section>

<? $this->load->view('supplement/footer-app'); ?>