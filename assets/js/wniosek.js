$().ready(function () {
    $("#test").validate({
        rules: {
            test: {
                required: true
            }
        }
    });

    $("[name=dowod_bezterminowy]").change(function (e) {
        let $date_box = $('.dowod_kdata_box');

        $date_box.show();
        if ($(e.target).is(':checked')) {
            $date_box.hide();
        }
    });

    $("#dane").validate({
        rules: {
            imie: "required",
            nazwisko: "required",
            pesel: {
                required: true,
                pesel: true,
                minlength: 11,
                maxlength: 11
            },
            dowod_seria: {
                required: true,
                minlength: 3,
                maxlength: 3,
                lettersonly: true
            },
            dowod_numer: {
                required: true,
                minlength: 6,
                maxlength: 6,
                number: true
            },
            karta_seria: {
                required: true,
                lettersonly: true
            },
            karta: {
                required: true,
                number: true
            },
            dowod_data: "required",
            dowod_kdata: {
                required: function (element) {
                    return !$("[name=dowod_bezterminowy]").is(':checked');
                }
            },
            ulica: {
                required: true,
                minlength: 2
            },
            nrdom: "required",
            kod_pocztowy: "required",
            miejscowosc: "required",
            korulica: "required",
            kornrdom: "required",
            korkod_pocztowy: "required",
            kormiejscowosc: "required",
            wyksztalcenie: "required",
            dzieci: "required",
            stan: "required",
            mieszkanie: "required",
            email: {required: true, email: true},
            telefonkom: {required: true, number: true, minlength: 9, maxlength: 9},
            konto: "required"
        },
        groups: {
            telefon: "telefonkom telefonstac telefonsluzb"
        },
        messages: {
            dowod_numer: {number: "Proszę wpisać tylko cyfry"},
            telefonkom: {number: "Proszę podać poprawny numer telefonu"}
        }
    });

    $("#dochod").validate({
        onkeyup: false,
        rules: {
            uop: {require_from_group: [1, '.forma_dochodu']},
            sm: {require_from_group: [1, '.forma_dochodu']},
            emer: {require_from_group: [1, '.forma_dochodu']},
            renta: {require_from_group: [1, '.forma_dochodu']},
            dg_kpr: {require_from_group: [1, '.forma_dochodu']},
            dg_r: {require_from_group: [1, '.forma_dochodu']},
            dg_kp: {require_from_group: [1, '.forma_dochodu']},
            uz: {require_from_group: [1, '.forma_dochodu']},
            uod: {require_from_group: [1, '.forma_dochodu']},
            gr: {require_from_group: [1, '.forma_dochodu']},
            un: {require_from_group: [1, '.forma_dochodu']},
            uop_dochod: {required: true, number: true},
            uop_nip: {required: true, nip: true},
            uop_zawod: {required: true},
            uop_pracodawca: {required: true},
            uop_telefon: {required: true, number: true},
            uop_ulica: {
                required: true,
                minlength: 2
            },
            uop_nrdom: {required: true},
            uop_kod_pocztowy: {required: true},
            uop_miejscowosc: {required: true},
            uop_wojewodztwo: {required: true},
            uop_zatrudnienie: {required: true},
            uop_kzatrudnienie: {require_from_group: [1, '.uop_kzatrudnienia']},
            uop_nieokreslony: {require_from_group: [1, '.uop_kzatrudnienia']},
            sm_dochod: {required: true, number: true},
            sm_nip: {required: true, nip: true},
            sm_stanowisko: {required: true},
            sm_legitymacja: {required: true},
            sm_pracodawca: {required: true},
            sm_telefon: {required: true, number: true},
            sm_ulica: {
                required: true,
                minlength: 2
            },
            sm_kod_pocztowy: {required: true},
            sm_miejscowosc: {required: true},
            sm_wojewodztwo: {required: true},
            sm_zatrudnienie: {required: true},
            sm_kzatrudnienie: {require_from_group: [1, '.sm_kzatrudnienia']},
            sm_nieokreslony: {require_from_group: [1, '.sm_kzatrudnienia']},
            emer_dochod: {required: true, number: true},
            emer_legitymacja: {required: true},
            emer_swiadczenie: {required: true},
            renta_dochod: {required: true, number: true},
            renta_legitymacja: {required: true},
            renta_swiadczenie: {required: true},
            renta_zatrudnienie: {required: true},
            renta_kzatrudnienie: {require_from_group: [1, '.renta_kzatrudnienia']},
            renta_nieokreslony: {require_from_group: [1, '.renta_kzatrudnienia']},
            dg_zatrudnienie: {required: true},
            dg_nazwa: {required: true},
            dg_dochod: {required: true, number: true},
            dg_nip: {required: true, nip: true},
            dg_ulica: {
                required: true,
                minlength: 2
            },
            dg_nrdom: {required: true},
            dg_kod_pocztowy: {required: true},
            dg_miejscowosc: {required: true},
            dg_kpr_dochod: {required: true, number: true},
            dg_kpr_nip: {required: true, nip: true},
            dg_r_przychod: {required: true, number: true},
            dg_r_nip: {required: true, nip: true},
            dg_kp_podatek: {required: true, number: true},
            dg_kp_nip: {required: true, nip: true},
            uz_dochod: {required: true, number: true},
            uz_nip: {required: true, nip: true},
            uz_zawod: {required: true},
            uz_pracodawca: {required: true},
            uz_telefon: {required: true, number: true},
            uz_ulica: {
                required: true,
                minlength: 2
            },
            uz_kod_pocztowy: {required: true},
            uz_miejscowosc: {required: true},
            uz_wojewodztwo: {required: true},
            uz_zatrudnienie: {required: true},
            uz_kzatrudnienie: {required: true},
            uod_dochod: {required: true, number: true},
            uod_nip: {required: true, nip: true},
            uod_zawod: {required: true},
            uod_pracodawca: {required: true},
            uod_telefon: {required: true, number: true},
            uod_ulica: {
                required: true,
                minlength: 2
            },
            uod_kod_pocztowy: {required: true},
            uod_miejscowosc: {required: true},
            uod_wojewodztwo: {required: true},
            uod_zatrudnienie: {required: true},
            uod_kzatrudnienie: {required: true},
            inne_dochod: {required: true, number: true},
            inne_nip: {required: true, nip: true},
            inne_zawod: {required: true},
            inne_pracodawca: {required: true},
            inne_telefon: {required: true, number: true},
            inne_ulica: {
                required: true,
                minlength: 2
            },
            inne_nrdom: {required: true},
            inne_kod_pocztowy: {required: true},
            inne_miejscowosc: {required: true},
            inne_wojewodztwo: {required: true},
            inne_zatrudnienie: {required: true},
            inne_kzatrudnienie: {required: true},
            gr_urzedy: {required: true},
            gr_dochod: {required: true, number: true},
        },
        groups: {
            forma_dochodu: "uop sm emer renta dg inne gr",
            uop_kzatrudnienia: "uop_kzatrudnienie uop_nieokreslony",
            sm_kzatrudnienia: "sm_kzatrudnienie sm_nieokreslony",
            renta_kzatrudnienia: "renta_kzatrudnienie renta_nieokreslony"
        },
        messages: {
            uop_telefon: {number: "Proszę podać poprawny numer telefonu"},
            sm_telefon: {number: "Proszę podać poprawny numer telefonu"},
            uz_telefon: {number: "Proszę podać poprawny numer telefonu"},
            uod_telefon: {number: "Proszę podać poprawny numer telefonu"},
            inne_telefon: {number: "Proszę podać poprawny numer telefonu"}
        }
    });
    $("#wniosek").validate({
        rules: {
            tryb: {required: true},
            wplata: {required: true},
            produktlink_1: {required: true, url: true},
            produktlink_2: {required: true, url: true},
            produktlink_3: {required: true, url: true},
            produktlink_4: {required: true, url: true},
            produktlink_5: {required: true, url: true},
            produkt_1: {required: true},
            produkt_2: {required: true},
            produkt_3: {required: true},
            produkt_4: {required: true},
            produkt_5: {required: true},
            cenalink_1: {required: true, number: true},
            cenalink_2: {required: true, number: true},
            cenalink_3: {required: true, number: true},
            cenalink_4: {required: true, number: true},
            cenalink_5: {required: true, number: true},
            cena_1: {required: true, number: true},
            cena_2: {required: true, number: true},
            cena_3: {required: true, number: true},
            cena_4: {required: true, number: true},
            cena_5: {required: true, number: true},
            wysylka: {required: true, number: true},
            wartosc: {required: true, number: true, min: 300}
        },
        messages: {
            wartosc: {min: "Minimalna wartość towarów to 300.00 zł"}
        }
    });
    $("#procedura").validate({
        rules: {
            tytul: "required",
            tresc: "required",
            autoryzacja: {
                required: true,
                equalTo: "#auth"
            },
        },
        messages: {
            autoryzacja: {equalTo: "Hasło autoryzacyjne jest błędne"}
        }
    });
    $("#kontakt").validate({
        rules: {
            nazwisko: "required",
            wiadomosc: "required",
            email: {
                required: true,
                email: true
            },
            captcha: "required"
        }
    });
    $("#telefonicznie").validate({
        rules: {
            nazwisko: "required",
            telefon: "required",
            email: {
                email: true
            }
        }
    });
    $("#ubezpieczenie").validate(
        {
            onkeyup: false,
            rules: {
                imie: "required",
                nazwisko: "required",
                pesel: {
                    required: true,
                    pesel: true
                },
                nazwa: "required",
                regon: "required",
                nip: {
                    required: true,
                    nip: true
                },
                ulica: "required",
                dom: "required",
                miejscowosc: "required",
                kod_pocztowy: {
                    required: true,
                    maxlength: 6
                }
            },
            messages: {
                telefonkom: {
                    minlength: "Podaj numer bez prefiksu 48",
                    maxlength: "Podaj numer bez prefiksu 48"
                }
            }
        });

    $("#prosty").validate({
        rules: {
            nazwisko: "required",
            kwota: {
                required: true
            },
            pesel: {
                required: true,
                pesel: true,
                minlength: 11,
                maxlength: 11
            },
            telefon: {required: true, number: true, minlength: 9, maxlength: 9},
            email: {required: true, email: true},
            osoba: "required",
            firma: "required",
            nip: {
                required: true,
                nip: true
            },
            'przedmiot[]': "required",
            'stan[]': "required",
            'dostawca[]': "required",
            'cena[]': "required"
        },
        messages: {
            telefon: {number: "Proszę podać poprawny numer telefonu"}
        }
    });

    $("#ileasing_wniosek").validate({
        rules: {
            nazwa: "required",
            adres: "required",
            data: "required",
            nip: {
                required: true,
                nip: true
            },
            telefon: {required: true},
            email: {required: true, email: true},
            forma: "required",
            pracownicy: "required",
            pkd: "required",
            'nazwisko[]': "required",
            'dowod[]': {
                required: true,
                dowod: true
            },
            'pesel[]': {
                required: true,
                pesel: true
            },
        },
        messages: {
            telefon: {number: "Proszę podać poprawny numer telefonu"}
        }
    });

    $("#ileasing_oferta").validate({
        rules: {
            typ_leasing: "required",
            nazwa: "required",
            nip: {
                required: true,
                nip: true
            },
            oplata: "required",
            dlugosc: "required",
            wykup: "required",
            prowizja: "required",
            'przedmiot[]': "required",
            'nazwa_przedmiot[]': "required",
            'rok[]': "required",
            'vat[]': "required",
            'cena[]': "required",
            dostawca: {
                required: true,
                nip: true
            }
        }
    });

    $("input#korespondencyjny").on('click', function () {
        $('div.korespondencyjny').toggle("slide", {direction: "up"}, 300);
    });

    $("input#uop").on('click', function () {
        $('div.uop').toggle("slide", {direction: "up"}, 300);
    });
    $("input#sm").on('click', function () {
        $('div.sm').toggle("slide", {direction: "up"}, 300);
    });
    $("input#emer").on('click', function () {
        $('div.emer').toggle("slide", {direction: "up"}, 300);
    });
    $("input#renta").on('click', function () {
        $('div.renta').toggle("slide", {direction: "up"}, 300);
    });
    $("input#dg").on('click', function () {
        $('div.dg').toggle("slide", {direction: "up"}, 300);
    });
    $("input#dg_r").on('click', function () {
        $('div.dg_r').toggle("slide", {direction: "up"}, 300);
    });
    $("input#dg_kp").on('click', function () {
        $('div.dg_kp').toggle("slide", {direction: "up"}, 300);
    });
    $("input#uz").on('click', function () {
        $('div.uz').toggle("slide", {direction: "up"}, 300);
    });
    $("input#uod").on('click', function () {
        $('div.uod').toggle("slide", {direction: "up"}, 300);
    });
    $("input#inne").on('click', function () {
        $('div.inne').toggle("slide", {direction: "up"}, 300);
    });
    $("input#gr").on('click', function () {
        $('div.gr').toggle("slide", {direction: "up"}, 300);
    });

    uop();
    uop_zatrudnienie();
    sm();
    sm_zatrudnienie();
    emer();
    renta();
    renta_zatrudnienie();
    dg();
    dg_kpr();
    dg_r();
    dg_kp();
    uz();
    uod();
    inne();
    gr();
    korespondencyjny();

    internet();
    stacjonarnie();

    $('select[name=tryb]').bind('change', function (e) {
        internet();
    });

    $('input[name=uop_nieokreslony]').on('click change', function (e) {
        uop_zatrudnienie();
    });

    $('input[name=sm_nieokreslony]').on('click change', function (e) {
        sm_zatrudnienie();
    });
    $('input[name=renta_nieokreslony]').on('click change', function (e) {
        renta_zatrudnienie();
    });

    $('input[type=radio][name=wysylka]').on('click', function () {
        var wniosek = $(this).attr('data-wniosek');
        $.get("wniosek/faktura_wysylka/" + wniosek, function (data) {
            //alert(data.ulica);
        }, 'json');
    });

    $('input[type=radio][name=faktura]').on('click', function () {
        var wniosek = $(this).attr('data-wniosek');
        $.get("wniosek/faktura_wysylka/" + wniosek, function (data) {
            //alert(data.miejscowosc);
        }, 'json');
    });

});

function internet() {
    if ($('select[name=tryb]').val() == 'internetowo') {
        $('div#produkt.internet').css('display', 'block');
        $('div#produkt.stacjonarnie').css('display', 'none');
    } else {
        $('div#produkt.internet').css('display', 'none');
        $('div#produkt.stacjonarnie').css('display', 'block');
    }
}

function stacjonarnie() {
    if ($('select[name=tryb]').val() == 'stacjonarnie') {
        $('div#produkt.stacjonarnie').css('display', 'block');
        $('div#produkt.internet').css('display', 'none');
    } else {
        $('div#produkt.stacjonarnie').css('display', 'none');
        $('div#produkt.internet').css('display', 'block');
    }
}

function uop() {
    if ($('input#uop').is(':checked')) {
        $('div.uop').css('display', 'block');
    } else {
        $('div.uop').css('display', 'none');
    }
}

function sm() {
    if ($('input#sm').is(':checked')) {
        $('div.sm').css('display', 'block');
    } else {
        $('div.sm').css('display', 'none');
    }
}

function emer() {
    if ($('input#emer').is(':checked')) {
        $('div.emer').css('display', 'block');
    } else {
        $('div.emer').css('display', 'none');
    }
}

function renta() {
    if ($('input#renta').is(':checked')) {
        $('div.renta').css('display', 'block');
    } else {
        $('div.renta').css('display', 'none');
    }
}

function dg() {
    if ($('input#dg').is(':checked')) {
        $('div.dg').css('display', 'block');
    } else {
        $('div.dg').css('display', 'none');
    }
}

function dg_kpr() {
    if ($('input#dg_kpr').is(':checked')) {
        $('div.dg_kpr').css('display', 'block');
    } else {
        $('div.dg_kpr').css('display', 'none');
    }
}

function dg_r() {
    if ($('input#dg_r').is(':checked')) {
        $('div.dg_r').css('display', 'block');
    } else {
        $('div.dg_r').css('display', 'none');
    }
}

function dg_kp() {
    if ($('input#dg_kp').is(':checked')) {
        $('div.dg_kp').css('display', 'block');
    } else {
        $('div.dg_kp').css('display', 'none');
    }
}

function uz() {
    if ($('input#uz').is(':checked')) {
        $('div.uz').css('display', 'block');
    } else {
        $('div.uz').css('display', 'none');
    }
}

function uod() {
    if ($('input#uod').is(':checked')) {
        $('div.uod').css('display', 'block');
    } else {
        $('div.uod').css('display', 'none');
    }
}

function inne() {
    if ($('input#inne').is(':checked')) {
        $('div.inne').css('display', 'block');
    } else {
        $('div.inne').css('display', 'none');
    }
}

function gr() {
    if ($('input#gr').is(':checked')) {
        $('div.gr').css('display', 'block');
    } else {
        $('div.gr').css('display', 'none');
    }
}


function uop_zatrudnienie() {
    if ($('input[name=uop_nieokreslony]').is(':checked')) {
        $('input[name=uop_kzatrudnienie]').prop('disabled', true);
        $('input[name=uop_kzatrudnienie]').val('');
    } else {
        $('input[name=uop_kzatrudnienie]').prop('disabled', false);
    }
}

function sm_zatrudnienie() {
    if ($('input[name=sm_nieokreslony]').is(':checked')) {
        $('input[name=sm_kzatrudnienie]').prop('disabled', true);
        $('input[name=sm_kzatrudnienie]').val('');
    } else {
        $('input[name=sm_kzatrudnienie]').prop('disabled', false);
    }
}

function renta_zatrudnienie() {
    if ($('input[name=renta_nieokreslony]').is(':checked')) {
        $('input[name=renta_kzatrudnienie]').prop('disabled', true);
        $('input[name=renta_kzatrudnienie]').val('');
    } else {
        $('input[name=renta_kzatrudnienie]').prop('disabled', false);
    }
}

function korespondencyjny() {
    if ($('input#korespondencyjny').is(':checked')) {
        $('div.korespondencyjny').css('display', 'block');
    } else {
        $('div.korespondencyjny').css('display', 'none');
    }
}

$(function () {
    var scntDiv = $('div#produkt.internet');
    var i = $('div#produkt.internet div.produkt').size() + 1;
    $('div#produkt.internet a.button.produkt').on('click', function () {
        if (i < 41) {
            $('<div class="produkt"><div class="form"><label>Nazwa towaru</label><input type="text" name="produktnazwa[]"></div><div class="form"><label>Link do towaru lub nazwa sklepu</label><input type="text" name="produktlink[]"></div><div class="form"><label>Cena produktu</label><input type="text" name="cenalink[]" class="less kwota"><span>PLN</span></div><div class="form"><label>Kwota wysyłki</label><input type="text" name="wysylkalink[]" value="0" class="less kwota"><span>PLN</span><a href="javascript:void(0);" id="usun">Usuń ten produkt</a></div><div class="hr less"></div></div>').appendTo(scntDiv);
            i++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.internet').on('click', 'a#usun', function () {
        $('div.internet a.button.produkt').show();
        if (i > 2) {
            $(this).parents('div.produkt').remove();
            i--;
        }
        return false;
    });

    var scntDiv2 = $('div#produkt.stacjonarnie');
    var c = $('div#produkt.stacjonarnie div.produkt').size() + 1;
    $('div#produkt.stacjonarnie a.button.produkt').on('click', function () {
        if (c < 41) {
            $('<div class="produkt"><div class="form"><label>Nazwa towaru</label><input type="text" name="nazwa[]"></div><div class="form"><label>Nazwa sklepu</label><input type="text" name="produkt[]"></div><div class="form"><label>Cena produktu</label><input type="text" name="cena[]" class="less kwota"><span>PLN</span><a href="javascript:void(0);" id="usun">Usuń ten produkt</a></div><div class="hr less"></div></div>').appendTo(scntDiv2);
            c++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.stacjonarnie').on('click', 'a#usun', function () {
        $('div.stacjonarnie a.button.produkt').show();
        if (c > 2) {
            $(this).parents('div.produkt').remove();
            c--;
        }
        return false;
    });

    var scntDiv3 = $('div.przedmiot');
    var b = $('div.przedmiot div.produkt').size() + 1;
    $('div.przedmiot a.button.produkt').on('click', function () {
        if (b < 15) {
            $('<div class="produkt"><div class="form"><label class="nomargin">Przedmiot leasingu - link do strony z przedmiotem</label><input type="text" name="przedmiot[]"></div><div class="form"><label>Stan przedmiotu</label><select name="stan[]"><option value="">-- wybierz --</option><option value="Nowy">Nowy</option><option value="Używany">Używany</option></select></div><div class="form"><label>Nazwa dostawcy</label><input type="text" name="dostawca[]"></div><div class="form"><label>Cena netto (bez VAT)</label><input type="text" class="kwota" name="cena[]"><span>PLN</span><a href="javascript:void(0);" id="usun">Usuń ten przedmiot</a></div><div class="hr less"></div></div>').appendTo(scntDiv3);
            b++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.przedmiot').on('click', 'a#usun', function () {
        $('div.przedmiot a.button.produkt').show();
        if (b > 2) {
            $(this).parents('div.produkt').remove();
            b--;
        }
        return false;
    });

    var scntDiv4 = $('div.leasing.finansowy');
    var x = $('div.leasing.finansowy div.produkt').size() + 1;
    $('div.leasing.finansowy a.button.produkt').on('click', function () {
        if (x < 15) {
            $('<div class="produkt"><div class="form"><label>Przedmiot leasingu</label><input type="text" name="przedmiot[]"></div><div class="form"><label>Nazwa</label><input type="text" name="nazwa_przedmiot[]"></div><div class="form"><label>Rok produkcji</label><input type="text" name="rok[]" required></div><div class="form"><label>Cena netto (bez VAT)</label><input type="text" class="kwota" name="cena[]" required><span>PLN</span></div><div class="form"><label>Wartość VAT</label><select name="vat[]" required><option value="">-- wybierz --</option><option value="0">0%</option><option value="8">8%</option><option value="23">23%</option><option value="zw">ZW</option></select><a href="javascript:void(0);" id="usun">Usuń ten przedmiot</a></div><div class="hr less"></div></div>').appendTo(scntDiv4);
            x++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.leasing.finansowy').on('click', 'a#usun', function () {
        $('div.leasing.finansowy a.button.produkt').show();
        if (x > 2) {
            $(this).parents('div.produkt').remove();
            x--;
        }
        return false;
    });

    var scntDiv5 = $('div.leasing.operacyjny');
    var y = $('div.leasing.operacyjny div.produkt').size() + 1;
    $('div.leasing.operacyjny a.button.produkt').on('click', function () {
        if (y < 15) {
            $('<div class="produkt"><div class="form"><label>Przedmiot leasingu</label><input type="text" name="przedmiot[]"></div><div class="form"><label>Nazwa</label><input type="text" name="nazwa_przedmiot[]"></div><div class="form"><label>Rok produkcji</label><input type="text" name="rok[]" required></div><div class="form"><label>Cena netto (bez VAT)</label><input type="text" class="kwota" name="cena[]" required><span>PLN</span><input name="vat[]" type="hidden" value="23"><a href="javascript:void(0);" id="usun">Usuń ten przedmiot</a></div><div class="hr less"></div></div>').appendTo(scntDiv5);
            y++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.leasing.operacyjny').on('click', 'a#usun', function () {
        $('div.leasing.operacyjny a.button.produkt').show();
        if (y > 2) {
            $(this).parents('div.produkt').remove();
            y--;
        }
        return false;
    });

    var scntDiv6 = $('div.reprezentant');
    var z = $('div.reprezentant div.osoba').size() + 1;
    $('div.reprezentant a.button.produkt').on('click', function () {
        if (z < 4) {
            $('<div class="osoba"><div class="form"><label>Imię i nazwisko</label><input type="text" name="nazwisko[]"></div><div class="form"><label>Seria i nr D.O.</label><input type="text" name="dowod[]"></div><div class="form"><label>PESEL</label><input type="text" name="pesel[]"><a href="javascript:void(0);" id="usun">Usuń tę osobę</a></div><div class="hr less"></div></div>').appendTo(scntDiv6);
            z++;
        } else {
            $('a.button.produkt').fadeOut();
        }
        return false;
    });

    $('body div.reprezentant').on('click', 'a#usun', function () {
        $('div.reprezentant a.button.produkt').show();
        if (z > 2) {
            $(this).parents('div.osoba').remove();
            z--;
        }
        return false;
    });
});