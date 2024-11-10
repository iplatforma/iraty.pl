	$('a[rel*=facebox]').facebox();
	
	$('section.konfigurator div.additional').on("click",'a.toggle',function(event){
		$(this).parent('.icon').parent('.additional').find(' > .description .content').slideToggle('slowest');
		if($(this).find('i').hasClass('fa-chevron-up')) {
			$(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		} else {
			$(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
		}
	});
	
	$('section.konfigurator div.additional div.additional').on("click",'a.stoggle',function(event){
		$(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
		$(this).parent('.icon').parent('.additional').find('.description .content').slideToggle('slowest');
	});
	
	$('section.konfigurator div.additional').on("click",'a.DescToggle',function(event){
		var supp = $(this).attr('data-toggle');
		var additional = 'section.konfigurator div.additional[data-supplement='+supp+'] a.toggle i';
		$(this).parent('p').next('.content').slideToggle('slowest');
		if($(additional).hasClass('fa-chevron-down')) {
			$(additional).removeClass('fa-chevron-down').addClass('fa-chevron-up');
		} else {
			$(additional).addClass('fa-chevron-down').removeClass('fa-chevron-up');
		}
	});
	
	$('section.konfigurator div.additional div.additional').on("click",'a.sDescToggle',function(event){
		var supp = $(this).attr('data-toggle');
		var additional = 'section.konfigurator div.additional[data-supplement='+supp+'] a.stoggle';
		$(additional).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
		$(this).parent('p').next('.content').slideToggle('slowest');
	});
	
	$('div.group a.toggle, div.group p.title').on("click",function(){
		var parent = $(this).parent();
		if(parent.hasClass('active')) {
			$(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			parent.removeClass('active');
			parent.next('div.supplement').slideUp("slow");
		} else {
			$(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
			parent.addClass('active');
			parent.next('div.supplement').slideDown("slow");
		}
	});

	$('section.konfigurator div.supplement').on("click",'a.button[data-type=addon]',function(event){
		var konfigurator = '#'+$(this).parents('section.konfigurator').attr('id');
		var supplementId = $(this).data('id');
		var exception = $(this).data('exception');
		var checked = $(this).parents('.supplement');
		//checked.css('background-color','#ff0');
		if(checked.hasClass('active')) {
			checked.removeClass('active');
			if(exception) {
				var arrException = exception.split(',');
				$.each(arrException, function(index, value) { 
					$(konfigurator+' .supplement[data-supplement="'+value+'"] a.button').text('Dodaj');
					$(konfigurator+' .supplement[data-supplement="'+value+'"]').removeClass('disabled');
					$(konfigurator+' #summary_supplement .supplement[data-id="'+value+'"]').attr('data-active','0');
				});
			}
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] input').prop('disabled',true);
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"]').addClass('hide');
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"]').attr('data-active','0');
			$(konfigurator+' .supplement[data-supplement="'+supplementId+'"] .subsupplement a.button').text('Dodaj');
			$(konfigurator+' .supplement[data-supplement="'+supplementId+'"] .subsupplement[data-mandatory=0]').removeClass('hide').removeClass('disabled').removeClass('active');
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] .subsupplement').attr('data-active','0');
		} else {
			checked.addClass('active');
			if(exception) {
				var arrException = exception.split(',');
				$.each(arrException, function(index, value) { 
					$(konfigurator+' .supplement[data-supplement="'+value+'"] a.button').text('Usuń');
					$(konfigurator+' #summary_supplement .supplement[data-id="'+value+'"]').addClass('hide');
					$(konfigurator+' .supplement[data-supplement="'+value+'"]').addClass('disabled').removeClass('active').attr('data-active','0');
				});
			}
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"]').removeClass('hide');
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] input.first').prop('disabled',false);
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"]').attr('data-active','1');
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] .subsupplement[data-mandatory="1"]').removeClass('hide');
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] .subsupplement[data-mandatory="1"] input').prop('disabled',false);
			$(konfigurator+' #summary_supplement .supplement[data-id="'+supplementId+'"] .subsupplement[data-mandatory="1"]').attr('data-active','1');
		}
		var text = $(this).text();
		$(this).text(text == 'Usuń' ? 'Dodaj' : 'Usuń');
		setSummary(konfigurator);
	});
	
	$('section.konfigurator div.subsupplement').on("click",'a.button[data-type=subaddon]',function(event){
		var konfigurator = '#'+$(this).parents('section.konfigurator').attr('id');
		var supplementId = $(this).data('id');
		var exception = $(this).data('exception');
		var checked = $(this).parents('.subsupplement');
		var arrException = [];
		//checked.css('background-color','#ff0');
		if(checked.hasClass('active')) {
			checked.removeClass('active');
			if(exception) {
				var arrException = exception.split(',');
				$.each(arrException, function(index, value) { 
					//$(konfigurator+' .subsupplement[data-supplement="'+value+'"] a.button').text('Dodaj');
					$(konfigurator+' .subsupplement[data-supplement="'+value+'"]').removeClass('disabled');
					$(konfigurator+' #summary_supplement .subsupplement[data-id="'+value+'"]').attr('data-active','0');
				});
			}
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"] input').prop('disabled',true);
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"]').addClass('hide');
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"]').attr('data-active','0');
		} else {
			checked.addClass('active');
			if(!$(this).parents('.supplement').hasClass('active')) {
				$(this).parents('.supplement').find('a[data-type="addon"]').trigger('click');
			}
			if(exception) {
				var arrException = exception.split(',');
				$.each(arrException, function(index, value) { 
					//$(konfigurator+' .subsupplement[data-supplement="'+value+'"] a.button').text('Usuń');
					$(konfigurator+' #summary_supplement .subsupplement[data-id="'+value+'"]').addClass('hide');
					$(konfigurator+' .subsupplement[data-supplement="'+value+'"]').addClass('disabled').removeClass('active').attr('data-active','0');
				});
			}
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"]').removeClass('hide');
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"] input').prop('disabled',false);
			$(konfigurator+' #summary_supplement .subsupplement[data-id="'+supplementId+'"]').attr('data-active','1');
		}
		var text = $(this).text();
		//$(this).text(text == 'Usuń' ? 'Dodaj' : 'Usuń');
		setSummary(konfigurator);
	});
	
	$('section.konfigurator #supplement h3').on('click', function() {
		var konfigurator = '#'+$(this).parents('section.konfigurator').attr('id');
		setSummary(konfigurator);
	});
	
	$( 'section.konfigurator #supplement h3' ).trigger('click');	
		
	$('section.konfigurator div.subsupplement, section.konfigurator div.supplement').on("click",'a.button[data-type=addon],a.button[data-type=subaddon]',function(event){
		var supplement = $(this).attr('data-id');
		var package = $(this).parents('.group').attr('data-package');
		var konfigurator = $(this).parents('.group').attr('data-konfigurator');
	});
	
	function setSummary(konfigurator) {
		var check = $(konfigurator+' .box.active').length;
		var packageSlot = konfigurator+' .box.active a.button[data-package]';
		var packageId = $(packageSlot).data('id');
		var packageName = $(packageSlot).data('package');
		var packagePrice = parseFloat($(packageSlot).data('price'));
		var opcja = 0;
		$(konfigurator+' #summary_option .option[data-active="1"][data-type="miesiąc"] input[name="opcja_price[]"]').each(function() {
			opcja = parseFloat($(this).val()) + opcja;
		});
		var opcja_once = 0;
		$(konfigurator+' #summary_option .option[data-active="1"][data-type="jednorazowo"] input[name="opcja_j_price[]"]').each(function() {
			opcja_once = parseFloat($(this).val()) + opcja_once;
		});
		var dodatek = 0;
		$(konfigurator+' #summary_supplement .supplement[data-active="1"][data-type="miesiąc"] input[name="dodatek_price[]"]').each(function() {
			dodatek = parseFloat($(this).val()) + dodatek;
		});
		$(konfigurator+' #summary_supplement .subsupplement[data-active="1"][data-type="miesiąc"] input[name="subdodatek_price[]"]').each(function() {
			dodatek = parseFloat($(this).val()) + dodatek;
		});
		var dodatek_once = 0;
		$(konfigurator+' #summary_supplement .supplement[data-active="1"][data-type="jednorazowo"] input[name="dodatek_j_price[]"],'+konfigurator+' #summary_charge .supplement[data-active="1"][data-type="jednorazowo"] input[name="charge_price[]"]').each(function() {
			dodatek_once = parseFloat($(this).val()) + dodatek_once;
		});
		$(konfigurator+' #summary_supplement .subsupplement[data-active="1"][data-type="jednorazowo"] input[name="subdodatek_j_price[]"]').each(function() {
			dodatek_once = parseFloat($(this).val()) + dodatek_once;
		});
		var ulga = 0;
		$(konfigurator+' #summary_discount .discount[data-active="1"] input[name="ulga_price[]"]').each(function() {
			ulga = parseFloat($(this).val()) + ulga;
		});

		var rabat = 0;
		$(konfigurator+' #summary_discount div.rabat').addClass('hide').attr('data-active','1');
		$(konfigurator+' #summary_discount div.rabat').find('p.rabat').text(rabat.toFixed(2) + ' zł / miesiąc');
		$(konfigurator+' #summary_discount').find('input[name="rabat_price"]').val(rabat.toFixed(2));
		$('#orderWidget').find('p.discount').text('');
		var rabatTxt = 0;
		$(konfigurator+' div[data-relations="1"].active').each(function() {
			var supp = $(this).attr('data-supplement');
			var konf = $(konfigurator).attr('data-konfigurator');
//			alert(konf+' '+packageId+' '+supp);
			$.get("konfigurator/jquery_pakiet/"+konf+'/'+packageId+'/'+supp, function(data) {
				if(data != 'null') {
					if(data) {
						rabat = parseFloat(data) + parseFloat(rabat);
						$(konfigurator+' #summary_discount div.rabat').find('p.rabat').text('-'+rabat.toFixed(2) + ' zł / miesiąc');
						$(konfigurator+' #summary_discount').find('input[name="rabat_price"]').val(rabat.toFixed(2));
						$('#orderWidget').find('p.discount').text('Rabat: '+ rabat.toFixed(2) + ' zł / miesiąc');
						if(rabat > 0) {
							$(konfigurator+' #summary_discount div.rabat').removeClass('hide').attr('data-active','0');
						}
					}
				}
			});
			$.get("konfigurator/jquery_relacje/"+konf+'/'+packageId+'/'+supp, function(data) {
				var array = $.parseJSON(data);
				$.each(array, function(key,value) {
					if($(konfigurator+' div[data-supplement="'+value+'"]').hasClass('active')) {
						$.get( "konfigurator/jquery_relacje/"+konf+'/'+packageId+'/'+supp+'/'+value, function(data) {
							rabat = parseFloat(data) + parseFloat(rabat);
							$(konfigurator+' #summary_discount div.rabat').find('p.rabat').text('-'+rabat.toFixed(2) + ' zł / miesiąc');
							$(konfigurator+' #summary_discount').find('input[name="rabat_price"]').val(rabat.toFixed(2));
							$('#orderWidget').find('p.discount').text('Rabat: '+ rabat.toFixed(2) + ' zł / miesiąc');
							if(rabat > 0) {
								$(konfigurator+' #summary_discount div.rabat').removeClass('hide').attr('data-active','0');
							}
						});
					}
				});
			});
		});
		
		setTimeout(function(){
			rabatTxt = $(konfigurator+' #summary_discount').find('input[name="rabat_price"]').val();      		
			summary = packagePrice + opcja + dodatek - ulga - rabatTxt;
			summary_once = dodatek_once + opcja_once;
			if(check > 0) {
				$(konfigurator+' #summary_charge,'+konfigurator+' #summary_supplement,'+konfigurator+' #summary_discount,'+konfigurator+' #summary').removeClass('hide');
				$(konfigurator+' #summary_package').find('.left p').text(packageName);
				$(konfigurator+' #summary_package').find('.right p').text(packagePrice.toFixed(2) + ' zł / miesiąc');
				$(konfigurator+' #summary').find('.right p.monthly').text(summary.toFixed(2) + ' zł / miesiąc');
				$('#orderWidget').find('p.price').text(summary.toFixed(2) + ' zł / miesiąc');
				if(summary_once > 0) { $(konfigurator+' #summary').find('.right p.once').text('+ ' + summary_once.toFixed(2) + ' zł / jednorazowo'); }
			} else {
				$(konfigurator+' #summary_charge,'+konfigurator+' #summary_supplement,'+konfigurator+' #summary_discount,'+konfigurator+' #summary').addClass('hide');
			}
		}, 500);
		
	}
