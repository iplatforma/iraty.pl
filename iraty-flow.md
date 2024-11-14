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
<input type="hidden" name="numerSklepu" value="{split(nr_wniosku, '|')[1]}" />
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

### Wniosek przez stronę partnera - produkt
### Kalkulator

1. Po kliknięciu w przycisk iraty z strony produktu partnera musi nastąpić przekierowanie na edpoint:
`kalkulator/{id_partnera}/{cena_produktu}`

2. Pobieramy info partnera z platformy finansowej przez: https://www.platformafinansowa.pl/partner/pokaz/{id_partnera}
przykład dla partnera 3567:
```shell
curl --location 'https://www.platformafinansowa.pl/partner/pokaz/3567' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cd2411fa87a5e3646625713b52dd5f57' \
--data-urlencode 'klucz=abc'
```
Dane zwracane przez ten edpoint są serializowane w php, więc odbiorca będzie musiał je odkodować. Przykładowa biblioteka w javie:
https://code.google.com/archive/p/serialized-php-parser/

Dodatkowo niektórzy partnerzy mają własny ustawiony własny zakres oprocentowania w kolumnie `oprocentowanie_raty`

3. Ustalmy zakres rat i oprocentowanie:
Tablea pratner w platformie finansowej posiada kilka flag kontrolujących opcje kalkulatora:

`raty_oze`:
- zakres rat: 40-120
- domyślna ilość rat: 60
- oprocentowanie: 0.63

`oprocentowanie_zero`:
- zakres rat: 6-60
- domyślna ilość rat: 10 
- oprocentowanie: 0 jeśli wybrano dokładnie 10 rat dla innej warości jest domyśłna oprocentowanie lub dla danego partnera

`rabat_10p`:
- zakres rat: 6-60
- domyślna ilość rat: 60
- oprocentowanie: domyślne dla wybrange zakresu rat
- rabat 10% od wartości produktu

`raty_10`:
- zakres rat: 6-60
- domyślna ilość rat: 10
- oprocentowanie: 0.5

`raty_1060`:
- zakres rat: 6-60
- domyślna ilość rat: 60
- oprocentowanie: 0.5 dla zakresu 10-60, dla zekrau 6-60 -> domyśłna wartość / wartość ustawiona dla partnera

`parnter.id = 3167`
- zakres rat: 10-10
- domyślna ilość rat: 10
- oprocentowanie: oprocentowanie według flagi oprocentowanie_zero

`domyślne`
- zakres rat: 6-60
- domyślna ilość rat: 60
- oprocentowanie:
```shell
curl --location 'https://www.platformafinansowa.pl/oprocentowanie/pokaz' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cbf295b297585747e1ef35743daed1dd' \
--data-urlencode 'klucz=abc'
```

4. Obliczamy ratę:
prowizja = oprocentowanie * ilosc / 100 * kwota
brutto = prowizja + kwota
rata = brutto / ilosc

### Krok 1 Szczegóły zakupu 
1. Obliczamy raty na podstawie danych z kalkulatora dla poszczególnych produktów
2. Jeśli partner ma ustawioną jedną z wyżej wymienionych flag chowamy przycisk z odroczeniem spłat o 4 miesiące.

Po przejści dalej zapisujemy dane tak jak poprzednio dodatkowo:
Jeśli partner w kolumnie stantader posiada wartosć 3:
Przy zapisawaniu danych do wniosku dla każdego porduktu ustawiamy w nazwie 'Zamówinie'
i w linku podruktu '---'

Kolejne kroki są takie same jak w przypadku `Wniosek przez stronę`

### Wniosek przez stronę partnera - koszyk
### Krok 1 Szczegóły zakupu
1. W przypadku przekierowania z koszyka do platoformy iraty, rozpoczynamy od wypelnionego formularza w korku 1 
Sklep partnera wysyła request POST pod endpoint https://iraty.pl/integracja/
z następujacymi parametrami:
- nazwa - nazwa towaru
- link - link do towaru
- cena
- kwota
- wysyłka
- partner - id partnera
- info - numer zamowineia w sklepie
- sklep

2. Pobieramy info partnera z platformy finansowej przez: https://www.platformafinansowa.pl/partner/pokaz/{id_partnera}
   przykład dla partnera 3567:
```shell
curl --location 'https://www.platformafinansowa.pl/partner/pokaz/3567' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cd2411fa87a5e3646625713b52dd5f57' \
--data-urlencode 'klucz=abc'
```

3. Wypełniamy formularz w korku 1 następującymi danymi:
- nazwa towaru - przesłana nazwa lub link do towaru
- link - link do towaru
- cena - cena towaru
- ilosc - ilosc towaru
- koszt_wysylki - koszt wysyłki

Sumujemy ceny towarów i dodajemy kosz wysyłki

4. Stosujemy zniżki i rabaty dla partnera takie same w przypadku punktu `Wniosek przez stronę partnera - produkt`

Jeśli partner w kolumnie stantader posiada wartosć 3:
Przy zapisawaniu danych do wniosku dla każdego porduktu ustawiamy w nazwie 'Zamówinie'
i w linku podruktu '---'


Krok 2 Jest taki sam jak w przypadku `Wniosek przez stronę`
### Krok 3 Faktura
1. Jeśli partner w kolumnie stantader posiada wartosć 4:
Zapisujemy dane z faktury tak jak w `Wniosek przez stronę partnera - produkt` i
  Tak jak wcześniej wchodzimy na
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
nr_wniosku_z_pf = nr_wniosku z odpowiedzi na poprzedni POST
nr_sklepi_z_pf = split(nr_wniosku_z_pf, '|')[0]
id_wniosku_z_pf = split(nr_wniosku_z_pf, '|')[1]
Gernaujemy link z przekierowaniem w mailu: www.iraty.pl/wniosek/finalizacja/{id_wniosku}/{id_wniosku_z_pf}/{nr_sklepi_z_pf}'

Następnie wsyłamy email do klienta z linkiem do finalizacji wniosku
+ wysyłamy sms z powiadomieniem na podany numer telefonu
  I pokazuemy ekran z końcowy

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
<input type="hidden" name="numerSklepu" value="{split(nr_wniosku, '|')[1]}" />
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

2. Jeśli partner w kolumnie stantader posiada wartosć inną niż 4 flow jest taki sam jak i innych przypadkach
