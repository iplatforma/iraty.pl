jQuery(document).ready(function($) {

	$('a[title], i[title]').qtip({
		position: {
			my: 'bottom left',
			at: 'center right'
		}
	});

	$('#chooseMonths').on("click",function(){
		$('#chooseMonths').toggleClass('active');
		$('#chooseMonths i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
	});
	
	$('#chooseMonths ul li').on("click",function(){
		$('#chooseMonths ul li').removeClass('active');
		var months = $(this).data('value');
		$('input[name="ilosc_rat"]').val(months);
		$(this).addClass('active');
	});
	
	$('a#openmenu').on("click",function(){
		$(this).find('i').toggleClass('fa-bars').toggleClass('fa-times');
		$(this).toggleClass('active');
		$('nav#rwdmenu').toggleClass('active');
	});
	
	jQuery('.scrollbar-inner').scrollbox({
		buffer: 150 // position from bottom when reach.scrollbox will be triggered
	});
	
	$('input.nip').on('change keyup keydown', function () {
        this.value = this.value.toLocaleUpperCase();
        this.value = this.value.replace("-", "");
        this.value = this.value.replace(" ", "");
    });
    $('input.kwota').on('change keyup keydown', function () {
        this.value = this.value.toLocaleUpperCase();
		this.value = this.value.replace(/[^0-9.,]/, '');
        this.value = this.value.replace(",", ".");
        this.value = this.value.replace("ZŁ", "");
        this.value = this.value.replace("PLN", "");
        this.value = this.value.replace(" ", "");
    });
    $('input.telefon').on('change keyup keydown', function () {
        this.value = this.value.replace("+48", "");
        this.value = this.value.replace("-", "");
        this.value = this.value.replace(" ", "");
        this.value = this.value.replace("+", "");
    });
	
	$('label.checkbox a[data-href="biginfo"]').on('click', function () {
		$('div.agree6').slideDown();
		$(this).remove();
	});
	
	$('input[name="switch"]').on('click', function () {
		$('label.checkbox input[type="checkbox"]').prop('checked',true);
		$('label.switch').remove();
	});
	
    $('input[name=faktura]').on('click', function () {
        var id = $(this).attr('id');
        var wniosek = $(this).attr('data-wniosek');
        $.get("wniosek/jquery/" + wniosek, function (data) {
            if (id == 'fizyczna') {
                $('div.firma').addClass('hide');
                $('div.fizyczna').removeClass('hide');
                $('input[name=faktura_fizyczna_odbiorca]').val(data.imie + ' ' + data.nazwisko);
            } else if (id == 'firma') {
                $('div.fizyczna').addClass('hide');
                $('div.firma').removeClass('hide');
            }
        }, 'json');
    });
	
    let pathname = window.location.pathname;
	
    if (pathname == '/wysylka-faktura') {
		var faktura = $('input[name=faktura]').val();
		if(faktura == 'fizyczna') {
			var wniosek = $('input[name=faktura]').attr('data-wniosek');
			$.get("wniosek/jquery/" + wniosek, function (data) {
				$('input[name=faktura_fizyczna_odbiorca]').val(data.imie + ' ' + data.nazwisko);
			}, 'json');
		}
	}
		
    if (pathname != '/wniosek' && pathname != '/integracja') {
        $(document).on("load click slidechange keyup keydown mousemove mouseenter", "document html, body, a.obliczjs,#rslider, #ubezpieczenie,#pieniadze,#raty", function () {
            var partner = parseFloat($("input[name=partner]").val());
            var wartosc = parseFloat($("input#pieniadze").val());
            var ilosc = parseInt($("input#raty").val());
            var oprocentowanie = parseFloat($('input.oprocentowanie').val());
            var def_oprocentowanie = parseFloat($('input.oprocentowanie_def').val());
            var oprocentowanie_zero = parseFloat($('input.oprocentowanie_zero').val());
            var oprocentowanie_normal = parseFloat($('input#inne_raty').val());
            var raty_oze = parseFloat($('input.raty_oze').val());
            var raty_10 = parseFloat($('input.raty_10').val());
            var raty_1060 = parseFloat($('input.raty_1060').val());
            var inne_raty = $('#inne_raty');
			
			var type = $('input[name="promotype"]').val();
			if(type == 'zero') {
				if(ilosc != 10) { $('p[data-type="zero"]').hide(); } else { $('p[data-type="zero"]').show(); }
			} else if(type == 'half-10') {
				if(ilosc != 10) { $('p[data-type="half-10"]').hide(); } else { $('p[data-type="half-10"]').show(); }
			} else if(type == 'half-1060') {
				if(ilosc < 10) { $('p[data-type="half-1060"]').hide(); } else { $('p[data-type="half-1060"]').show(); }
			}
			
			if(oprocentowanie_zero == 1) {
				if(ilosc != 10) {
					//$('p[data-type="zero"]').text('Uwaga! Raty 0% są możliwe tylko dla 10 rat');
				} else {
					$('p[data-type="zero"]').text('10 rat 0%');
				}
			}

            if (typeof inne_raty !== 'undefined') {
                var pobierz_oprocentowanie = pobierz_procent_dla_rat(ilosc);
                if (null !== pobierz_oprocentowanie) {
                    oprocentowanie = pobierz_oprocentowanie;

                    $(inne_raty).val(oprocentowanie);
                }
            }

            if (oprocentowanie_zero == 1 && ilosc == 10) {
                oprocentowanie = 0;
            }

            if (raty_oze === 1) {
                oprocentowanie = 0.63;
            }
			
            if (raty_10 == 1 && ilosc == 10) {
                oprocentowanie = 0.50;
            }
			
            if (raty_1060 == 1 && (ilosc >= 10 && ilosc <= 60)) {
                oprocentowanie = 0.5;
            }			
			
            $('input.oprocentowanie').val(oprocentowanie);
            var ubezp = parseFloat($('input.ubezp').val());
            if ($('input#ubezpieczenie').prop('checked')) {
                var ubezpieczenie = 1;
            } else {
                var ubezpieczenie = 0;
            }
            if (ubezpieczenie == 1) {
                oprocentowanie = oprocentowanie + parseFloat(ubezp);
            }

            var prowizja = ((oprocentowanie.toFixed(2) * ilosc) / 100) * wartosc;
            var brutto = parseFloat(prowizja + wartosc);
            var wynik = brutto / ilosc;
            setWartosc();


            if (wartosc) {
                $('span.rata').text(wynik.toFixed(2)+' zł');
                //$("div.result").addClass("active");
                $('input#rata').val(wynik.toFixed(2));
            }
        });
		
		$("a#start").on("click", function () {
            $("form#kalkulator").submit();
        });
				
    }
        
    if (pathname == '/wniosek' || pathname == '/integracja') {
        $(document).on("change click keyup keydown mouseenter mousemove", "body, input#wartosc, input[data-type='cena'], input[name=ilosc], input#wysylka, #ilosc_rat,input#wplata, #ubezpieczenie", function () {
            let $rabat_p10 = $('.rabat_10p');
            let $partner_p10 = $('.partner_10p');
            let $rabat_info_row = $('.rabat-row');
            let raty_oze = parseFloat($('input.raty_oze').val());
            let raty_10 = parseFloat($('input.raty_10').val());
            let raty_1060 = parseFloat($('input.raty_1060').val());

            let wplata = $('input#wplata').val();
            let wysylka = $('input#wysylka').val();

            /*
			if (wysylka && wysylka % 1 === 0) {
                wysylka = parseFloat(wysylka);
            } else {
                wysylka = parseFloat(0);
            }
			*/

            let wartosc = parseFloat($("input#wartosc").val());
            let netto = (wartosc) - wplata;
            let ilosc = parseInt($("#ilosc_rat").val());
            let inne_raty = $('#inne_raty');

            $rabat_p10.val(0);
            $rabat_info_row.hide();
            if (ilosc >= 38 && parseInt($partner_p10.val()) == 1) {
                $rabat_p10.val(1);
                $rabat_info_row.show();
            }

            let oprocentowanie = parseFloat($('input.oprocentowanie').val());
            let oprocentowanie_zero = parseFloat($('input.oprocentowanie_zero').val());
            let oprocentowanie_def = parseFloat($('input.oprocentowanie_def').val());
            let oprocentowanie_1060 = parseFloat($('input.oprocentowanie').val());

			if(oprocentowanie_zero == 1) {
				if(ilosc != 10) {
					//$('p[data-type="zero"]').text('Uwaga! Raty 0% są możliwe tylko dla 10 rat');
				} else {
					$('p[data-type="zero"]').text('10 rat 0%');
				}
			}

            if (typeof inne_raty !== 'undefined') {
                let pobierz_oprocentowanie = pobierz_procent_dla_rat(ilosc);
                if (null !== pobierz_oprocentowanie) {
                    oprocentowanie = pobierz_oprocentowanie;
                    $(inne_raty).val(oprocentowanie);
                }
            }

            if (oprocentowanie_zero == 1 && ilosc == 10) {
                oprocentowanie = 0;
            }			

            if (raty_oze === 1) {
                oprocentowanie = 0.63;
                $(inne_raty).val(oprocentowanie);
            }
			
            if (raty_10 === 1 && ilosc === 10) {
                oprocentowanie = 0.5;
            }
			
			
            if (raty_1060 == 1 && (ilosc >= 10 && ilosc <= 60)) {
                oprocentowanie = 0.5;
            }	
			

            $('input.oprocentowanie').val(oprocentowanie);
            let ubezp = parseFloat($('input.ubezp').val());
            let ubezpieczenie = parseInt($('#ubezpieczenie').val());
            if (ubezpieczenie == 1) {
                oprocentowanie = oprocentowanie + parseFloat(ubezp);
            }

            let prowizja = ((oprocentowanie.toFixed(2) * ilosc) / 100) * netto;
			/*
            console.log('---------');
            console.log(prowizja);
            console.log(netto);
            console.log('---------');
			*/
            let brutto = parseFloat(prowizja + netto);
            let wynik = brutto / ilosc;

            let is_rabat_10p = parseInt($(".rabat_10p").val()) == 1;

            wartosc = parseFloat(0.00);
            wysylka = parseFloat(0.00);

            $('input[name="cenalink[]"]').each(function () {
                let product_price = parseFloat($(this).val());
                let product_quantity = 1;
				product_quantity = parseFloat($(this).parents('.produkt').find('input.ilosc').val());
                if(is_rabat_10p) {
                    product_price = product_price * 0.9;
                }

                wartosc = wartosc + (product_price * product_quantity);
            });

            $('input[name="wysylka"]').each(function () {
                wartosc = wartosc + parseFloat($(this).val());
                wysylka = wysylka + parseFloat($(this).val());
            });

            setWartosc();
            if (wartosc > 0) {
                /*
				if (wysylka > 0) {
                    $('input[name=wysylka]').val(wysylka.toFixed(2));
                }
				*/

                $('input[name=wartosc]').val(wartosc.toFixed(2));
                $('span.rata').text(wynik.toFixed(2)+' zł');
                $('span.kwota').text(netto.toFixed(2)+' zł');
                $('input[name=kwota]').val(wartosc.toFixed(2));
                $('input#rata').val(wynik.toFixed(2));
            }
        });
		
		$("a#rozpocznij").on("click", function () {
            $("form#szczegoly").submit();
        });

    }
	
	$("a#dalej").on("click", function () {
		$("form#dane").submit();
	});
	
    let pobierz_procent_dla_rat = function(raty) {
        //console.log(inne_raty);

        // inne_raty
        let out = null;
        if (typeof inne_raty !== "undefined") {
            $.each(inne_raty, function(k, v) {
                let przedzial = k.split('_');
                if (raty >= przedzial[0] && raty <= przedzial[1]) {
                    out = parseFloat(v);
                }
            });
        }

        return out;
    };
	
	$('a#addproduct').on('click', function() {
		$('.otherproducts').append('<div class="produkt"><div class="box-4 inline"><label>Nazwa towaru</label><input type="text" name="produktnazwa[]" required /></div><div class="box-4 inline"><label>Link do towaru lub nazwa sklepu</label><input type="text" name="produktlink[]" required /></div><div class="box-4 inline"><label>Cena produktu</label><input type="text" name="cenalink[]" data-type="cena" class="less kwota" required /><span class="suffix">PLN</span></div><div class="box-4 inline"><label>Ilość</label><input type="number" min="1" name="ilosc[]" class="ilosc" required value="1" /><span class="info">Jeżeli finansujesz towary od kilku sprzedawców, zamówienie złóż u każdego z nich, a ich numery wpisz oddzielając przecinkami.</span></div><a href="javascript:void(0)" class="remove">usuń</a><div class="hr less"></div></div>');
	});
	
	$('body').on('click', 'a.remove', function() {
		$(this).parents('.produkt').remove();
	});

    setWartosc();
	
    $('body').on('change', 'input[name=wartosc],input[name="cenalink[]"],input[name="ilosc[]"], input[name="wysylka"]', function () {
        setWartosc();
    });
	
});

function kredyt() {
	
}

function setWartosc() {
    if ($('input[name=wartosc]').val() > 20000) {
        $('#odroczenie').hide();
        $('input[name=odroczenie]').prop('disabled', true);
    } else {
        $('#odroczenie').show();
        $('input[name=odroczenie]').prop('disabled', false);
    }
}