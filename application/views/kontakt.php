<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section id="header" class="full">
	<div class="justify">
		<div class="left inline">
            <ul>
                <li><a href="/">Strona główna</a></li>
                <li>Kontakt</li>
            </ul>
            <header><h2>Masz pytania?<br />Skontaktuj się z nami</h2></header>
            <p>Cały proces zakupu na raty przebiega w 5 krokach, a decyzja o kredytowaniu pojawi się w ciągu kilku minut na Twoim ekranie.</p>
		</div>
        <div class="right inline">
            <div class="circle contact">
            	<img src="/assets/gfx/design/gfx-contact-1.png" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-1" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-2" />
			   	<img src="/assets/gfx/bg/orange-ball.png" class="ball-3" />
				<div class="item item-1">
                	<p><i class="fa fa-check"></i> Napisz do nas</p>
                </div>
            </div>
		</div>
    </div>
    <div class="bottom white"></div>
   	<img src="/assets/gfx/bg/orange-ball.png" class="orange-ball-2" />
</section>

<section id="content" class="full padding">
	<div class="justify">
    	<form class="form" action="" method="post">
        	<div class="box-3 inline">
	            <label>Imię i nazwisko *</label>
                <input type="text" name="nazwisko" placeholder="Wypełnij" required="required" />
			</div>
        	<div class="box-3 inline">
	            <label>Firma</label>
                <input type="text" name="firma" placeholder="Wypełnij" />
			</div>
        	<div class="box-3 inline">
	            <label>NIP *</label>
                <input type="text" name="nip" placeholder="Wypełnij" required="required" />
			</div>
        	<div class="box-3 inline">
	            <label>Telefon kontaktowy</label>
                <input type="text" name="telefon" placeholder="Wypełnij" />
			</div>
        	<div class="box-3 inline">
	            <label>E-mail kontaktowy *</label>
                <input type="email" name="email" placeholder="Wypełnij" required="required" />
			</div>
        	<div class="box-3 inline">
	            <label>Wybierz temat wiadomości</label>
				<select name="temat">
                	<option value="">- Wybierz temat wiadomości -</option>
                    <option value="Raty">Raty</option>
                </select>
			</div>
            <div class="full">
            	<label>Wiadomość *</label>
            	<textarea name="wiadomosc" required="required"></textarea>
            </div>
            <div class="full">
            	<label for="zgoda" class="checkbox">
                	Potwierdzam, że zapoznałem się z Klauzulą informacyjną dotyczącą przetwarzania danych osobowych przez Platforma sp. z o .o. [<a href="/assets/files/klauzule-informacyjne.pdf">klauzule informacyjne</a>] *
                	<input type="checkbox" id="zgoda" name="zgoda" required="required" /> 
                    <span class="checkmark"></span>
                </label>
            	<label for="zgoda2" class="checkbox">
	                Wyrażam zgodę na kontakt w celu poprawnej realizacji niniejszego żądania *
                	<input type="checkbox" id="zgoda2" name="zgoda2" required="required" />
                    <span class="checkmark"></span>
				</label>
                <label class="checkbox">* - pola obowiązkowe</label>
            </div>
            <div class="full center">
	            <a href="javascript:void(0)" class="button orange">Wyślij wiadomość <i class="fa fa-arrow-right"></i></a>
            </div>
        </form>
    </div>
</section>

<section id="contact" class="full padding">
	<div class="justify">
    	<div class="left inline">
        	<h3>Odpowiemy na Twoje pytania. Rozpocznijmy współpracę!</h3>
            <p class="big icon"><img src="/assets/gfx/icon/icon-contact-phone.png" /><strong>+48 508 770 470</strong><br /><span class="small">Infolinia</span></p>
            <p class="big icon"><img src="/assets/gfx/icon/icon-contact-email.png" /><strong>wnioski@ipay24.pl</strong><br /><span class="small">Napisz do nas</span></p>
        </div>
    	<div class="right inline">
        	<h3>Dane firmowe</h3>
            <p class="big"><strong>"Platforma" Sp. z o.o.</strong></p>
            <p class="big"><strong>0000386890</strong><br /><span class="small">KRS</span></p>
            <p class="big"><strong>8513147669</strong><br /><span class="small">NIP</span></p>
        </div>
    </div>
</section>

