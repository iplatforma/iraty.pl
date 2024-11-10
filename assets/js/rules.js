$(document).ready(function() {

	$("#szczegoly").validate({
		rules: {
		    info: {required:true},
            wplata: {required: true},
            wysylka: {required: true, number: true},
            wartosc: {required: true, number: true, min: 300}
		},
		messages: {
			wysylka: {number: 'Wpisz poprawną kwotę'}
		}
	});
	
	$("#dane").validate({
		rules: {
			imie: {required:true},
			nazwisko: {required:true},
			email: {required:true,email:true},
			telefonkom: {required:true,number:true,minlength:9},
			pesel: {required:true, pesel:true}
		},
		messages: {
            telefonkom: {number: "Proszę podać poprawny numer telefonu"}
		}
	});
	
});

