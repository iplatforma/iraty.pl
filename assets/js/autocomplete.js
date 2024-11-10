$("#spot").autocomplete({
	source: function (request, response) {
		 $.ajax({
			 url: "/dostepnosc/miasto/",
			 type: "GET",
			 dataType:'json',
			 data: request,
			 success: function (data) {
				 response($.map(data, function (el) {
					 return {
						 moja: el.name,
						 label: el.name +' ('+ el.spottype+')<br><aside class="small">woj. '+el.province_name+', pow. '+el.district_name+', gm.' +el.community_name+'</aside>',
						 value: el.spotid
					 };
				 }));
			 }
		 });
	},
	focus: function(event,ui) {
		this.value = ui.item.moja;
		$(this).next("input").val(ui.item.value);
		event.preventDefault();
	},
	select: function (event, ui) {
		this.value = ui.item.moja;
		$(this).next("input").val(ui.item.value);
		event.preventDefault();
	}
}).data("ui-autocomplete")._renderItem = function (ul, item) {
		return $("<li></li>")
		 .data("item.autocomplete", item)
		 .append(item.label)
		 .appendTo(ul);
};

$("#street").autocomplete({
	source: function (request, response) {
		 $.ajax({
			 url: "/dostepnosc/ulica/"+$('#spotid').val(),
			 type: "GET",
			 dataType:'json',
			 data: request,
			 success: function (data) {
				 response($.map(data, function (els) {
					 return {
						 moja: els.name,
						 label: els.name + '<br><aside class="small">'+els.street_fullname+' / '+els.spot_name+'</aside>',
						 value: els.streetid
					 };
				 }));
			 }
		 });
	},
	focus: function(event,ui) {
		this.value = ui.item.moja;
		$(this).next("input").val(ui.item.value);
		event.preventDefault();
	},
	select: function (event, uis) {
		// Prevent value from being put in the input:
		this.value = uis.item.moja;
		// Set the next input's value to the "value" of the item.
		$(this).next("input").val(uis.item.value);
		event.preventDefault();
	}
}).data("ui-autocomplete")._renderItem = function (ul, item) {
		return $("<li></li>")
		 .data("item.autocomplete", item)
		 .append(item.label)
		 .appendTo(ul);
};
/*
$('#number').on('click change',function() {
	$("#number").autocomplete({
		source: function (request, response) {
			 $.ajax({
				 url: "/dostepnosc/budynek/"+$('#spotid').val()+'/'+$('#streetid').val(),
				 type: "GET",
				 dataType:'json',
				 data: request,
				 success: function (data) {
					 response($.map(data, function (el) {
						 return {
							 label: el.streetno,
							 value: el.nobcid
						 };
					 }));
				 }
			 });
		},
		select: function (event, ui) {
			// Prevent value from being put in the input:
			this.value = ui.item.label;
			// Set the next input's value to the "value" of the item.
			$(this).next("input").val(ui.item.value);
			event.preventDefault();
		}
	}).data("ui-autocomplete")._renderItem = function (ul, item) {
			return $("<li></li>")
			 .data("item.autocomplete", item)
			 .append(item.label)
			 .appendTo(ul);
	};
});
*/