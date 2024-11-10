<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="form">
	<form class="form" action="<?=site_url('kontakt/wyslij')?>" method="post">
    	<div class="input">
            <label>Imię i nazwisko/firma</label>
            <input type="text" class="full" name="nazwa" placeholder="Imię i nazwisko/firma" required>
        </div>
    	<div class="input half inline hleft">
            <label>Adres e-mail</label>
            <input type="email" class="full" name="email" placeholder="Adres e-mail" required>
        </div>
    	<div class="input half inline hright">
            <label>Numer telefonu</label>
            <input type="text" class="full" name="telefon" placeholder="Numer telefonu">
        </div>
    	<div class="input">
            <label>Treść wiadomości</label>
            <textarea name="wiadomosc" class="full" placeholder="Treść wiadomości" required></textarea>
        </div>
        <div class="input">
        	<label class="checkbox small"><input type="checkbox" name="agree" required> W związku z tym, że 25 maja 2018 roku weszło w życie Rozporządzenie Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (określane jako "RODO" lub "Ogólne Rozporządzenie o Ochronie Danych"), informujemy, że klauzula informacyjna dotycząca ochrony danych osobowych dostępna jest w dziale Polityka prywatności.</label>
        </div>
        <div class="input half">
			<!--<div class="g-recaptcha" data-sitekey="6LeG3DIUAAAAAHWeHinFLoUBiwpCDayPe0eQbipX"></div>-->
            <aside class="clear less"></aside>
        </div>
    	<div class="input half">
			<input type="submit" value="Wyślij wiadomość">
        </div>
    </form>
</div>
