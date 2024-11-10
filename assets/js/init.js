new WOW().init();

jQuery(document).ready(function($) {
		
	$('a[title], i[title]').qtip({
		position: {
			my: 'bottom left',
			at: 'center right'
		}
	});
	$('a[rel*=facebox]').facebox();
	$('a[rel*=galeria]').prettyPhoto();
		
	$('.accordion article h4 a').on('click', function() {
		$(this).parent('h4').toggleClass('active');
		$(this).parent('h4').find('i').toggleClass('fa-arrow-up').toggleClass('fa-arrow-down');
		$(this).parent('h4').next('div.content').slideToggle();
	});
	
	$('#popup').on('click', 'a#remove', function() {
		$('#popup').hide();
		$.ajax({
			async: false,
			type: 'POST',
			url: '/popup/hide',
			data: { }
		});
	});
	
	$('nav#rwdmenu').on('click', 'a.submenu', function() {
		$('ul.submenu').not(this).next('ul.submenu').removeClass('active');
		$('a.submenu').not(this).removeClass('active');
		$(this).next('ul.submenu').toggleClass('active');
		$(this).toggleClass('active');
	});

	$('#chooseMonths').on("click",function(){
		alert();
		$('#chooseMonths .dropdown').addClass('active');//slideDown('slow');
	});

	$('select[data-select="pmenu"]').on("change",function(){
		var option = $(this).val();
		if(option) {
			$('select[name="parent"]').prop('disabled',false);
		}
		$('select[name="parent"]').find('option[data-type="header"]').hide();
		$('select[name="parent"]').find('option[data-type="sheader"]').hide();
		$('select[name="parent"]').find('option[data-type="footer"]').hide();
		$('select[name="parent"]').find('option[data-type="'+option+'"]').show();
	});

	if($('input#background_color').val() != null) {
		$('iframe#mce_editor_0_ifr').contents().find('body.mceContentBody').css('background-color','#'+$('input#background_color').val());
	}
	
	$('form.form').on("change",'input#background_color',function(){
		var background_color = $(this).val();
		$('iframe#mce_editor_0_ifr').contents().find('body.mceContentBody').css('background-color','#'+background_color);
	});
	
	$('.header-box a.close').on('click', function() {
		$('.header-box').removeClass('active');
	});
	
	$('div.input a.toggle').on('click', function() {
		$(this).next('.relations').toggleClass('active');
	});
	
	$('a#openmenu').on("click",function(){
		$(this).find('i').toggleClass('fa-bars').toggleClass('fa-times');
		$(this).toggleClass('active');
		$('nav#rwdmenu').toggleClass('active');
	});
	
	$(window).mousemove(function(event) {
		//var left = event.pageX/40;
		//var top = event.pageY/40;
		var left2 = event.pageX/40;
		var top2 = event.pageY/40;
		//$(".da-img").css({"left" : left, "top" : top});
		$(".da-img2").css({"left" : left2, "top" : top2});
		//$(".da-img").css({"left" : left});
		//$(".da-img2").css({"left" : left2});
	});
	
	$(window).scroll(function() {
		if ($(document).scrollTop() > 500) {
			$('#tidio-chat').addClass('active');
		}
		else {
			$('#tidio-chat').removeClass('active');
		}
	});

});

jQuery(function($){
        $.datepicker.regional['pl'] = {
                closeText: 'Zamknij',
                prevText: '&#x3c;Poprzedni',
                nextText: 'Następny&#x3e;',
                currentText: 'Dziś',
                monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
                'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                monthNamesShort:  ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
                'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                dayNames: ['Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
                dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
                dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
                weekHeader: 'Tydz',
                dateFormat: 'yy-mm-dd',
				autoclose: true,
				changeYear: false,
				changeMonth: false,
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pl']);
});