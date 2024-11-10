$(function() {
	var pkwota = parseFloat($( "input#pkwota" ).val());
	$( "#pieniadze" ).val(parseFloat($( "input#pkwota" ).val()));
	$( "#raty" ).val(parseFloat($( "select#raty" ).val()));
	$( "#pieniadze" ).change(function() {
      if ($(this).val() > 80000)
      {
          $(this).val(80000);
      }
      else if ($(this).val() < 300)
      {
          $(this).val(300);
      }       
    }); 
	
	$("a.telefonicznie").on("click",function(){
		$("form#kalkulator").attr("action", "wniosek/telefonicznie").trigger('submit');
	});	
		
	$('input.kwota').keyup(function() {
        this.value = this.value.toLocaleUpperCase();	
		this.value = this.value.replace(",",".");
		this.value = this.value.replace("ZŁ", "");
		this.value = this.value.replace("PLN", "");
		this.value = this.value.replace(" ","");
	});
		
	$(document).on("click slidechange keyup mousemove", "body,#pieniadze,#raty",function(){
		var wartosc = parseFloat($( "input#pieniadze" ).val());
		var ilosc = parseInt($( "select#raty" ).val());
		var oprocentowanie = parseFloat($('input.oprocentowanie').val());
		var def_oprocentowanie = parseFloat($('input.oprocentowanie_def').val());
		if(ilosc > 5 && ilosc < 13) {
			//oprocentowanie = def_oprocentowanie + 0.35;
			oprocentowanie = def_oprocentowanie;
		} else {
			oprocentowanie = def_oprocentowanie;
		}
		var ubezp = parseFloat($('input.ubezp').val());
//		var ubezpieczenie = parseInt($('input#ubezpieczenie').val());
		if($('input#ubezpieczenie').prop('checked')) { var ubezpieczenie = 1; } else { var ubezpieczenie = 0; }
		if(ubezpieczenie == 1) { oprocentowanie = oprocentowanie + parseFloat(ubezp); }
		var prowizja = ((oprocentowanie.toFixed(2)*ilosc)/100) * wartosc;
		var brutto = parseFloat(prowizja + wartosc);
		var wynik= brutto / ilosc;	
		if(wartosc) {
			$('span.rata').text(wynik.toFixed(2));
			//$("div.result").addClass("active");
			$('input#rata').val(wynik.toFixed(2));
		}
	});

	$("a#start").on("click",function(){
		$("form#kalkulator").attr("action", "wniosek").trigger('submit');
	});

});