<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<? $this->load->view('supplement/header-app'); ?>

<section id="crumbs" class="full">
	<div class="justify">
    	<ul>
        	<li class="active"><span>Krok 1</span><br /><span class="about">Parametry kredytu</span></li>
        	<li><span>Krok 2</span><br /><span class="about">Dane kredytobiorcy</span></li>
        	<li><span>Krok 3</span><br /><span class="about">Faktura</span></li>
        	<li><span>Krok 4</span><br /><span class="about">Podsumowanie</span></li>
        </ul>
    </div>
</section>

<section id="content" class="full padding">
	<div class="justify">
    
		<form id="szczegoly" class="form" action="<?=site_url('wniosek/rozpocznij')?>" method="post" enctype="multipart/form-data">
           
	        <h2 class="center">Szczegóły zakupu <span class="linia">linia kredytowa</span></h2>
			<div class="left inline">
            	<label>Numer zamówienia w sklepie (u dostawcy) <? if(!$integracja) { ?><a href="javascript:void(0);" title='Niezbędne jest złożenie zamówienia u wybranego sprzedawcy. Jako metodę płatności w koszyku wybierz iRaty lub zwykły przelew.'><i class="fa fa-info-circle"></i></a><? } ?></label>
                <input type="text" name="info" value="<?= (null !== $formularz['info'] ? $formularz['info'] : '') ?>"<?=$integracja?' readonly':NULL?> required>
            </div>        
			<div class="right inline">
            </div>
            
			<?php if($produkt and sizeof($produkt) > 0) { foreach ($produkt as $item) { $ilosc = ($item['ilosc']?$item['ilosc']:1); ?>
                <div class="produkt">
                    <div class="box-4 inline">
                        <label>Nazwa towaru</label>
                        <input type="text" name="produktnazwa[]" required value="<?= (null !== $item['nazwa'] ? $item['nazwa'] : '') ?>"<?=$integracja?' readonly':NULL?> />
                    </div>
                    <div class="box-4 inline">
                        <label>Link do towaru lub nazwa sklepu</label>
                        <input type="text" name="produktlink[]" required value="<?= (null !== $item['link'] ? $item['link'] : '') ?>"<?=$integracja?' readonly':NULL?> />
                    </div>
                    <?
					if($formularz['sklep'] and (strpos($formularz['sklep'],'module/platformafinansowa') or strpos($formularz['sklep'],'wc_gateway_raty'))) {
						$cena = number_format(($item['cena']/$ilosc),2,'.','');	
					} else {
						$cena = number_format($item['cena'],'2','.','');
					}
					?>
                    <div class="box-4 inline">
                        <label>Cena produktu</label>
                        <input type="text" name="cenalink[]" class="kwota" required value="<?= (null !== $item['cena'] ? $cena : '') ?>"<?=$integracja?' readonly':NULL?> /><span class="suffix">PLN</span>
                    </div>
                    <div class="box-4 inline">
                        <label>Ilość</label>
                        <input type="number" min="1" name="ilosc[]" class="ilosc" required value="<?= (null !== $item['ilosc'] ? $ilosc : '1') ?>"<?=$integracja?' readonly':NULL?> />
                    </div>
                </div>
                <? } ?>
                <div class="hr less"></div>
            <? } else { ?>
                <div class="produkt">
                    <div class="box-4 inline">
                        <label>Nazwa towaru</label>
                        <input type="text" name="produktnazwa[]" required value="" />
                    </div>
                    <div class="box-4 inline">
                        <label>Link do towaru lub nazwa sklepu</label>
                        <input type="text" name="produktlink[]" required value="" />
                    </div>
                    <div class="box-4 inline">
                        <label>Cena produktu</label>
                        <input type="text" name="cenalink[]" class="kwota" required value="" /><span class="suffix">PLN</span>
                    </div>
                    <div class="box-4 inline">
                        <label>Ilość</label>
                        <input type="number" min="1" name="ilosc[]" class="ilosc" required value="1" />
                    </div>
                </div>
            <? } ?>
            <? if(!$integracja) { ?>
            <div class="otherproducts">
            
            </div>            
            <div class="button center">
            	<a href="javascript:void(0)" id="addproduct" class="button blue border">Dodaj kolejny produkt <i class="fa fa-plus-circle"></i></a>
            </div>
            <? } ?>

			<div class="full">
                <div class="box-3 inline">
                    <label>Łączny koszt wysyłki</label>
                    <input type="text" id="wysylka" name="wysylka" class="kwota" required value="<?= (null !== $formularz['wysylka'] ? $formularz['wysylka'] : '0') ?>"<?=$integracja?' readonly':NULL?>><span class="suffix">PLN</span>
                </div>
            </div>

			<aside class="clear more"></aside>
			<aside class="clear more"></aside>

	        <h3 class="center">Podsumowanie</h3>
            <div class="full">
        	<div class="box-3 inline">
	            <label>Wartość towarów i wysyłki</label>
                <input type="text" required="required" name="wartosc" class="kwota" id="wartosc" readonly="readonly" value="<?= $formularz['kwota'] ?>" />
                <span class="suffix">PLN</span>
			</div>
        	<div class="box-3 inline">
	            <label>Ilość rat</label>
                <select name="ilosc_rat" id="ilosc_rat" required>
                    <? for ($i = $min; $i <= $max; $i++) { ?>
                        <option value="<?= $i ?>"<?= $this->load->selected($i, $formularz['ilosc_rat']) ?><? if(($partner['oprocentowanie_zero'] and $i == 10)) { ?> selected<? } ?>><?= $i ?></option>
                    <? } ?>
                </select>
			</div>
        	<div class="box-3 inline"></div>
            </div>
            
            <? if($partner['raty_oze'] or $partner['oprocentowanie_zero'] or $partner['rabat_10p'] or $partner['raty_10'] or $partner['raty_1060']) { ?>
            <? } else { ?>
            <div class="full">
            	<label for="odroczenie" class="checkbox">
	                Chcę odłożyć płatność pierwszej raty o 4 miesiące
                	<input type="checkbox" id="odroczenie" name="odroczenie" />
                    <span class="checkmark"></span>
                </label>
            </div>
            <? } ?> 
        	<aside class="clear"></aside>
        	<div class="box-3 minline">
                <div class="installment">
                    <span class="rata">0,00 zł</span>
                    <p>Wysokość miesięcznej raty</p>
					<? if($partner['raty_oze']) { ?>
                        <p class="header orange">Partner OZE</p>
                    <? } else if($partner['oprocentowanie_zero']) { ?>
                        <p class="header orange" data-type="zero">10 rat 0%</p>
                    <? } else if($partner['rabat_10p']) { ?>
                        <p class="header orange rabat_10p">Rabat 10%</p>
                    <? } else if($partner['raty_10']) { ?>
                        <p class="header orange ">Stałe raty 0,5% miesięcznie na 10 miesięcy</p>
                    <? } else if($partner['raty_1060']) { ?>
                        <p class="header orange ">Stałe raty 0,5% miesięcznie od 10 do 60 miesięcy</p>
                    <? } ?>
                </div>
			</div>
        	<div class="box-3 minline">
                <div class="installment">
                    <span class="kwota">0,00 zł</span>
                    <p>Kwota kredytu</p>
                </div>
			</div>
            
            <input type="hidden" name="ubezpieczenie_zakupu" id="ubzakup" value="0">
            <input type="hidden" name="kwota">
            <input type="hidden" name="rodzaj" value="1">
            <input type="hidden" name="wplata" id="wplata" value="0" />
            <input type="hidden" name="sklep" value="<?= $formularz['sklep'] ? $formularz['sklep'] : '' ?>">
            <? if($formularz['info']) { ?>
            <input type="hidden" name="info" value="<?= $formularz['info'] ? $formularz['info'] : '' ?>">
            <? } ?>
			<input type="hidden" name="backurl" value="<?=$formularz['backurl'] ? $formularz['backurl'] : ''?>">
            <input type="hidden" name="partner" value="<?= $formularz['partner'] ? $formularz['partner'] : 0 ?>">
            <input type="hidden" class="oprocentowanie" name="oprocentowanie"
                   value="<?= $formularz['partner'] ? $this->load->oprocentowaniePartner($formularz['partner']) : $this->load->oprocentowanie() ?>">
            <input type="hidden" class="oprocentowanie_def" name="oprocentowanie_def"
                   value="<?= $formularz['partner'] ? $this->load->oprocentowaniePartner($formularz['partner']) : $this->load->oprocentowanie() ?>">
            <input type="hidden" class="oprocentowanie_zero" name="oprocentowanie_zero" value="<?=$partner['oprocentowanie_zero']=='1'?'1':'0'?>">
            <input type="hidden" class="rabat_10p" name="rabat_10p" value="<?=$partner['rabat_10p']=='1'?'1':'0'?>">
            <input type="hidden" class="raty_oze" name="raty_oze" value="<?=$partner['raty_oze']=='1'?'1':'0'?>">
            <input type="hidden" class="partner_10p" name="partner_10p" value="<?= $partner['partner_10p']=='1'?'1':'0'?>">
            <input type="hidden" class="raty_10" name="raty_10" value="<?=$partner['raty_10']=='1'?'1':'0'?>">
            <input type="hidden" class="raty_1060" name="raty_1060" value="<?=$partner['raty_1060']=='1'?'1':'0'?>">
            <input type="hidden" name="rata" id="rata">
            <input type="hidden" id="inne_raty" name="inne_raty" value="1" />
			<input type="hidden" name="test" value="<?=$formularz['test']=='1'?'1':'0'?>" />
            
            <?php if (is_array($partner['oprocentowanie_raty']) && count($partner['oprocentowanie_raty']) > 0): ?>
                <script>
                    let inne_raty = <?= json_encode($partner['oprocentowanie_raty']) ?>;
                </script>
            <?php else: ?>
                <script>
                    let inne_raty = <?= json_encode($this->load->oprocentowanie_przedzialy()) ?>;
                </script>
            <?php endif ?>            
            
            <div class="box-3 minline align-right">
            	<a href="javascript:void(0)" id="rozpocznij" class="button blue">Rozpocznij składanie wniosku <i class="fa fa-arrow-right"></i></a>
            </div>
            
        	<aside class="clear"></aside>
            
            <p class="info">Obliczenia przeprowadzone za pomocą kalkulatora mają charakter orientacyjny i nie stanowią oferty w rozumieniu art.66 §1kc.</p>        	

        </form>  
        
    </div>
</section>


<? $this->load->view('supplement/footer-app'); ?>