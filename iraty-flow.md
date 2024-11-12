### Wniosek przez stronę
1. Kalkulator

Pola:
- kwota - kwota kredytu
- ilosc - ilosc rat
- rata - rata miesieczna =

Rata miesięczna jest obliczna na podstawie wzoru:
```
oprocentowanie = pobierz z:
curl --location 'https://www.platformafinansowa.pl/oprocentowanie/pokaz' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cbf295b297585747e1ef35743daed1dd' \
--data-urlencode 'klucz=abc',
i wez oprocentowanie dla wybranego przedzialu miesiecy. np. dla raty na 60 miesiec oprocentowanie = 1.2
{
"6_12": "1.72",
"13_18": "1.41",
"19_24": "1.2",
"25_30": "1.2",
"31_48": "1.1",
"49_60": "1.2"
}
prowizja = oprocentowanie * ilosc / 100 * kwota
brutto = prowizja * kwota
rata = brutto / ilosc
```

2. Krok 1 Szczegóły zakupu

Pola:
- numer_zamowienia = numer zamowienia w sklepie
- produkty = lista produktów:
  - nazwa_prod
  - link_prod
  - cena_prod
  - ilosc_prod
- koszt_wysylki
- kwota = suma (cen produktów * ilosc) + koszt wysyłki
- wartosc = kwota
- ilosc - ilosc rat
- odroczenie - flaga odroczenie pierwszej raty o 4 miesiące
- rata - rata miesieczna =
  Rata miesięczna jest obliczna na podstawie wzoru na ratę punktu 1:
- oprocentowanie =
```shell
pobierz z:
curl --location 'https://www.platformafinansowa.pl/oprocentowanie/pokaz' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cbf295b297585747e1ef35743daed1dd' \
--data-urlencode 'klucz=abc'
```
- inne_raty = oprocentowanie

Do tabeli `wniosek` w bazie irat dodajemy rekord:
```json
partner = "0"
wplata = "0"
wartosc = kwota
gotowka = "0"
oprocentowanie = oprocentowanie
ubezpieczenie = "0"
rabat_10p = {int} 0
ubezpieczenie_zakupu = "0"
kwota = {float} wartosc
odroczenie = odroczenie
raty = ilosc
wRata = rata
rodzaj = "1"
backurl = ""
info = numer_zamowienia
sklep = ""
data = now()
ip = request_ip
browser = przeglądrka + versia + agent
zgoda = "0"
test = "0"
disable_auto_export = "1"
inne_raty = inne_raty
netto_partner = {float} wartosc
```
Następnie dodajemy do tabel `dane` i `dochod` takie same dane i dodatkowo w id rekordu id wniosku

ustawić w sesji `wniosek` = id oddanego rekordu w tabeli wniosek

Do tabeli `zakup` w bazie irat dodajemy rekord:
```json
tryb = "internetowo"
wysylka = koszt_wysylki
wniosek = {int} wniosek_id
```

Do tabeli `produkt` w bazie irat dodajemy rekordy:
Dla kazdego produktu
```json
nazwa = nazwa_prod
produkt = link_prod
ilosc = ilosc_prod
cena = cena_prod
wysylka = "0.00"
rabat_10p = {int} 0
zakup = zakup_id
wniosek = wniosek_id
```

Do tabeli `produkt` w bazie irat dodajemy rekord wysyłki:
```json
nazwa = "Łączny koszt wysyłki"
produkt = "---"
cena = koszt_wysylki
wysylka = "0.00"
ilosc = "1"
rabat_10p = {int} 0
```

3. Krok 2 Dane osobowe

Pola:
- imie
- nazwisko
- pesel
- nr_telefonu
- email

Do tabeli `dane` w bazie irat aktualizujemy rekord z id = {id wniosku z sesji}:
```json
imie = imie
nazwisko = nazwisko
pesel = pesel
telefonkom = nr_telefonu
email = email
zmiana = now()
```


4. Krok 3 Faktura

Pola - osoba fizyczna:
- imie_i_nazwisko
Pola - firma:
- nazwa_firmy
- nip

Pola - wspolne:
- typ_faktury - typ faktury ('fizyczna'/'firma')
- ulica
- nr_domu
- nr_lokalu
- kod_pocztowy
- miejscowosc
- zgoda1 - klauzula informacyjna
- zgoda2 - kontatk
- zgoda3 - upowazdnienie do odpytania
- zgoda4 - regulamin sklepu dostawcy
- zgoda5 - marketing
- zgoda6 - oswiadczenie na uzytek własny

Do tabeli wniosek w bazie irat aktualizujemy rekord z id = {id wniosku z sesji}:
```json
active = "1"
status = "1"
data = now()
zgoda = zgoda1
marketing = zgoda5
agree2 = zgoda2
agree3 = "0"
agree4 = zgoda6
agree5 = zgoda4
agree6 = zgoda3
agree7 = "0"
agree8 = "0"
agree9 = "0"
agree10 = "0"
agree11 = "0"
agree12 = "0"
agree13 = "0"
agree14 = "0"
agree15 = "0"
agree16 = "0"
```

Do tabeli dane w bazie irat aktualizujemy rekord z id = {id wniosku z sesji}:
```json
faktura = typ_faktury
faktura_odbiorca = imie_i_nazwisko / nazwa_firmy
faktura_nip = nip
faktura_ulica = ulica
faktura_nrdom = nr_domu
faktura_nrlokal = nr_lokalu
faktura_kod_pocztowy = kod_pocztowy
faktura_miejscowosc = miejscowosc
```

5. Krok 4 Podsumowanie
Po kliknięciu wybierz warunki spłaty:
pobieramy
wniosek = select * -{poza id z tabeli} from wniosek where id = {id wniosku z sesji}
dane = select * -{poza id z tabeli} from dane where id = {id wniosku z sesji}
dochod = select * -{poza id z tabeli} from dochod where id = {id wniosku z sesji}
zakup = select tryb,wysylka from zakup where wniosek = {id wniosku z sesji}
produkt = select id,nazwa,produkt,ilosc,wysylka,cena from zakup where wniosek = {id wniosku z sesji}

Wysyłamy POST pod adres: https://www.platformafinansowa.pl/import-ratalna
payload multipart/form-data:
serializacja(
wniosek = [
  dane,
  dochod,
  zakup,
  produkt
])
w kodzie jest użyta do tegeo funkcja: https://www.php.net/manual/en/function.serialize.php
nr_wniosku = nr_wniosku z odpowiedzi na poprzedni POST

Następnie strzelamy POST opd adres banku https://wniosek.eraty.pl/formularz:
formularz w kodzie wyglda następuąco na pewno da się to spryniej, ale dla jasności zostawiłem tak:
```html
{sum = 0}
<form action="https://wniosek.eraty.pl/formularz" name="auto_send" method="post" accept-charset="utf-8">
  {foreach k, p from produkt}
    {wartosc_prod = p.cena * p.ilosc + p.wysylka}
    {sum += wartosc_prod}
    <input type="hidden" name="idTowaru{k}" value="37751" />
    <input type="hidden" name="nazwaTowaru{k}" value="{p.ilosc} x {p.nazwa}" />
    <input type="hidden" name="wartoscTowaru{k}" value="{wartosc_prod}" />
    <input type="hidden" name="liczbaSztukTowaru{k}" value="{p.ilosc}" />
    <input type="hidden" name="jednostkaTowaru{k}" value="szt" />
  {/foreach}
<input type="hidden" name="wartoscTowarow" value="{sum}" />
<input type="hidden" name="liczbaSztukTowarow" value="{count(produkt)}" />
<input type="hidden" name="numerSklepu" value="{split(nr_wniosku, '|')[0]}" />
<input type="hidden" name="typProduktu" value="0" />
<input type="hidden" name="sposobDostarczeniaTowaru" value="kurier" />
<input type="hidden" name="nrZamowieniaSklep" value="{split(nr_wniosku, '|')[0]}" />
<input type="hidden" name="pesel" value="{dane.pesel}" />
<input type="hidden" name="imie" value="{dane.imie}" />
<input type="hidden" name="nazwisko" value="{dane.nazwisko}" />
<input type="hidden" name="email" value="{dane.email}" />
<input type="hidden" name="telKontakt" value="{dane.nr_telefonu}" />
<input type="hidden" name="blokadaWplaty" value="1" />
<input type="hidden" name="char" value="ISO" />
```
