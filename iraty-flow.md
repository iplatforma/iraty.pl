## Dokumentcja procesu wnioskowania o raty
Proces wnioskowania o raty na stronie www.iraty.pl może być realizowany na 3 sposoby:
1. [Wniosek przez stronę](#wniosek-przez-stronę):  
   Wnioskodawca rozpoczyna od wypełnienia formularzu na stronie irat
2. [Wniosek przez stronę partnera - produkt](#wniosek-przez-stronę-partnera---produkt):  
   Wnioskodawca rozpoczyna poprzez kliknięcie w link z przekierowaniem z strony produktu partnera
3. [Wniosek przez stronę partnera - koszyk](#wniosek-przez-stronę-partnera---koszyk):  
   Wnioskodawca rozpoczyna poprzez kliknięcie w link z przekierowaniem z strony koszyka partnera


## Wniosek przez stronę
### Kalkulator - http://iraty.pl/kalkulator
W tym kroku obliczamy przewidywalną ratę na podstawie kwoty kredytu jaką chce
wziąć wnioskodawca.

Wzór na ratę:
```text
prowizja = oprocentowanie * ilosc / 100 * kwota
brutto = prowizja * kwota
rata = brutto / ilosc
```
licze na przykładzie kwota = 1000, ilosc rat 10, oprocentowanie 1(%)
prowizja = 1*10/100*1000 = 1/10*1000 = 100 - ta wartość jest ok
brutto = 100 * 1000 = 10 000 czyli źle a powinno być brutto = prowizja + kwota czyli 1100
i wówczas rata = brutto/ilosc czyli 1100/10 = 110 

Oprocentowanie uzyte w wzorze pobieramy z https://www.platformafinansowa.pl/oprocentowanie/pokaz
```shell
curl --location 'https://www.platformafinansowa.pl/oprocentowanie/pokaz' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cbf295b297585747e1ef35743daed1dd' \
--data-urlencode 'klucz=abc'
````
Zwraca on obiekt json z oprocentowaniem dla różnych przedziałów rat:
```json
{
  "6_12": "1.72",
  "13_18": "1.41",
  "19_24": "1.2",
  "25_30": "1.2",
  "31_48": "1.1",
  "49_60": "1.2"
}
```

### Krok 1 Szczegóły zakupu - https://iraty.pl/wniosek
W tym kroku wnioskodawca wypełnia formularz z danymi produktów na które, zamierza wziąć raty

Do tabeli `wniosek` w bazie irat dodajemy rekord:
```text
partner = "0"
wplata = "0"
wartosc = kwota
gotowka = "0"
oprocentowanie = oprocentowanie
ubezpieczenie = "0"
rabat_10p = 0
ubezpieczenie_zakupu = "0"
kwota = kwota pożyczki
odroczenie = czy odroczeyć spłate o 4 miesiące
raty = ilosc
wRata = rata
rodzaj = "1"
backurl = ""
info = numer zamowienia
sklep = ""
data = aktualna data i czas
ip = ip klienta
browser = przeglądrka + versia + agent
zgoda = "0"
test = "0"
disable_auto_export = "1"
inne_raty = oprocentowanie
netto_partner = kwota pożyczki
```
Zapisujemy id dodanego wniosku bo będzie potrzebny nam w kolejnych krokach

Następnie dodajemy do tabel `dane` i `dochod` takie same dane i dodatkowo w id rekordu id dodanego wniosku

Do tabeli `zakup` w bazie irat dodajemy rekord:
```text
tryb = "internetowo"
wysylka = koszt wysylki
wniosek = wniosek_id
```

Do tabeli `produkt` w bazie irat dodajemy rekordy:
Dla kazdego produktu
```text
nazwa = nazwa produktu
produkt = link do produktu
ilosc = ilosść produktu
cena = cena produktu
wysylka = "0.00"
rabat_10p = 0
zakup = zakup_id
wniosek = wniosek_id
```

Do tabeli `produkt` w bazie irat dodajemy rekord wysyłki:
```text
nazwa = "Łączny koszt wysyłki"
produkt = "---"
cena = koszt wysylki
wysylka = "0.00"
ilosc = "1"
rabat_10p = 0
```

### Krok 2 Dane osobowe - http://iraty.pl/dane-osobowe
W tym kroku wnioskodawca podaje swoje dane osobowe

Do tabeli `dane` w bazie irat aktualizujemy rekord z id = {id wniosku}:
```text
imie = imie
nazwisko = nazwisko
pesel = pesel
telefonkom = nr_telefonu
email = email
zmiana = aktualna data i czas
```

### Krok 3 Faktura - http://iraty.pl/wysylka-faktura
W tym kroku wnioskodawca podaje dane do faktury i zaznacza zgody

Do tabeli wniosek w bazie irat aktualizujemy rekord z id = {id wniosku z sesji}:
```text
active = "1"
status = "1"
data = aktualna data i czas
zgoda = - Klauzula informacyjna
marketing = Zgoda na marketing
agree2 = Zgoda na kontakt
agree3 = "0"
agree4 = Oświadczenie o zakupie na użytek własny
agree5 = Oświadczenie o zapoznaniu się z regulaminem sklepu(dostawcy)
agree6 = Upoważnienie do odpytania w biurach informacji gospodarczej
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

Do tabeli dane w bazie irat aktualizujemy rekord z id = {id wniosku}:
```text
faktura = typ faktury ('fizyczna'/'firma')
faktura_odbiorca = imie i nazwisko / nazwa firmy
faktura_nip = nip
faktura_ulica = ulica
faktura_nrdom = nr domu
faktura_nrlokal = nr lokalu
faktura_kod_pocztowy = kod pocztowy
faktura_miejscowosc = miejscowosc
```

### Krok 4 Podsumowanie - http://iraty.pl/podsumowanie
W tym kroku po akceptacji wnioskodawcy. Wniosek zostanie przesłany do platformy finansowej, a wnioskodawca zostanie
przekierowany do banku santander

Informacje o wniosku wysyłamy do platformy finansowej, żadaniem POST pod adres:  
https://www.platformafinansowa.pl/import-ratalna

Payload przygotowujemy w następujacy sposób:

```text
wniosek = select * -{poza id z tabeli} from wniosek where id = {id wniosku z sesji}
dane = select * -{poza id z tabeli} from dane where id = {id wniosku z sesji}
dochod = select * -{poza id z tabeli} from dochod where id = {id wniosku z sesji}
zakup = select tryb,wysylka from zakup where wniosek = {id wniosku z sesji}
produkt = select id,nazwa,produkt,ilosc,wysylka,cena from zakup where wniosek = {id wniosku z sesji}


parametry = 
[
  wniosek,
  dane,
  dochod,
  zakup,
  produkt
];
parametry = serialize(parametry);
```

Dane są serializowane w php za pomocą funkcji serialize, przykładowa biblioteka w javie, która zrobi to samo:
https://code.google.com/archive/p/serialized-php-parser/
Przesyłamy parametry w kluczu 'wniosek' w ciele żądania, z nagłówkiem `Content-type: multipart/form-data`

Po otrzymaniu odpowiedzi z platformy finansowej w postaci numeru wniosku z platformy finansowej wysyłamy wniosek do banku santander.
Obecnie to jest zrobione tak, że serwer w odpowiedzi na generuje następujący formularz który jest automatycznie wysyłany:

```html
{sum = 0}
<form action="https://wniosek.eraty.pl/formularz" name="auto_send" method="post" accept-charset="utf-8">
  {foreach k, p from produkt}
    {wartosc_prod = p.cena * p.ilosc + p.wysylka}
    {sum += wartosc_prod}
    <input type="hidden" name="idTowaru{k}" value="{p.id}" />
    <input type="hidden" name="nazwaTowaru{k}" value="{p.ilosc} x {p.nazwa}" />
    <input type="hidden" name="wartoscTowaru{k}" value="{wartosc_prod}" />
    <input type="hidden" name="liczbaSztukTowaru{k}" value="{p.ilosc}" />
    <input type="hidden" name="jednostkaTowaru{k}" value="szt" />
  {/foreach}
<input type="hidden" name="wartoscTowarow" value="{sum}" />
<input type="hidden" name="liczbaSztukTowarow" value="{count(produkt)}" />
<input type="hidden" name="numerSklepu" value="{split(nr_wniosku_z_paltofrmy_finansowej, '|')[1]}" />
<input type="hidden" name="typProduktu" value="0" />
<input type="hidden" name="sposobDostarczeniaTowaru" value="kurier" />
<input type="hidden" name="nrZamowieniaSklep" value="{split(nr_wniosku_z_paltformy_finansowej, '|')[0]}" />
<input type="hidden" name="pesel" value="{dane.pesel}" />
<input type="hidden" name="imie" value="{dane.imie}" />
<input type="hidden" name="nazwisko" value="{dane.nazwisko}" />
<input type="hidden" name="email" value="{dane.email}" />
<input type="hidden" name="telKontakt" value="{dane.nr_telefonu}" />
<input type="hidden" name="blokadaWplaty" value="1" />
<input type="hidden" name="char" value="ISO" />
<script>document.auto_send.submit();</script>
```

## Wniosek przez stronę partnera - produkt
### Kalkulator - http://iraty.pl/kalkulator/{id_partnera}/{cena_produktu}/{flaga}/{nr_zamowienia}
Po kliknięciu w przycisk iraty z strony produktu partnera musi nastąpić przekierowanie na edpoint
Jeśli flaga jest równa 0 to wyświetalmy komunikat, że aby kupić wybrany produkt na raty trzeba dodać go z poziomu koszyka.
Tylko id_partnera jest wymagane do uruchomienia tego procesu reszta parametrów jest opcjonalna.

Pobieramy info partnera z platformy finansowej przez: https://www.platformafinansowa.pl/partner/pokaz/{id_partnera}
przykład dla partnera 3567:
```shell
curl --location 'https://www.platformafinansowa.pl/partner/pokaz/3567' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Cookie: pf_session=cd2411fa87a5e3646625713b52dd5f57' \
--data-urlencode 'klucz=abc'
```
Dane zwracane przez ten edpoint są serializowane w php, więc odbiorca będzie musiał je odkodować. Przykładowa biblioteka w javie:
https://code.google.com/archive/p/serialized-php-parser/

Niektórzy partnerzy mają własny ustawiony własny zakres oprocentowania w kolumnie `oprocentowanie_raty`

Ustalmy zakres rat i oprocentowanie:
Tablea partner w platformie finansowej posiada kilka flag kontrolujących opcje kalkulatora:

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

Wzór na ratę:
```text
prowizja = oprocentowanie * ilosc / 100 * kwota
brutto = prowizja * kwota
rata = brutto / ilosc
```

### Krok 1 Szczegóły zakupu - https://iraty.pl/wniosek
W tym kroku wnioskodawca wypełnia formularz z danymi produktów na które, zamierza wziąć raty

Ten krok działa podobie jak w przypadku [kroku 1](#krok-1-szczegóły-zakupu---httpsiratyplwniosek) w Wniosku przez stronę
Zmieniają się tylko 2 rzeczy:

1. Jeśli partner ma ustawioną jedną z wyżej wymienionych flag do oprocentowania chowamy przycisk z odroczeniem spłat o 4 miesiące.
2. Po przejści dalej zapisujemy dane tak jak poprzednio dodatkowo:
   Jeśli partner w kolumnie `stantader` posiada wartosć `3`:
   Przy zapisawaniu danych do wniosku dla każdego porduktu ustawiamy:  
   nazwie = 'Zamówinie'  
   linku produktu = '---'

Kolejne kroki są takie same jak w przypadku [Wniosek przez stronę](#wniosek-przez-stronę)

## Wniosek przez stronę partnera - koszyk
### Krok 1 Szczegóły zakupu - https://iraty.pl/wniosek
W przypadku przekierowania z koszyka do platoformy iraty, rozpoczynamy od wypelnionego formularza w korku 1
Sklep partnera wysyła request POST pod endpoint https://iraty.pl/integracja/
z następujacymi parametrami:
- nazwa[] - nazwa towaru / towarów
- link[] - link do towaru / towarów
- cena[] - cena towaru / towarów
- kwota - kwota zaówienia
- wysyłka - kwota wyłki
- partner - id partnera
- info - numer zamowineia w sklepie
- sklep - nazwa sklepu / link do sklepu
  I wypełniamy formularz w korku 1 następującymi danymi przesłanymi przez partnera.

Następne wykonujemy te same czynność co wprzypadku [kroku 1](#krok-1-szczegóły-zakupu---httpsiratyplwniosek-1) w wniosku przez produkt

### Krok 2 Dane osobowe - http://iraty.pl/dane-osobowe
Ten krok jest taki sam jak [krok 2] w wniosku prze stronę

### Krok 3 Faktura - http://iraty.pl/wysylka-faktura
Jeśli partner w kolumnie `santander` posiada wartość inną niż `4`
Ten i kolejne kroki wykonujemy tak jak w przypadku [Wniosek przez stronę](#wniosek-przez-stronę)


Jeśli partner w kolumnie `santander` posiada wartosć równą `4`:

Do tabeli wniosek w bazie irat aktualizujemy rekord z id = {id wniosku z sesji}:
```text
active = "1"
status = "1"
data = aktualna data i czas
zgoda = - Klauzula informacyjna
marketing = Zgoda na marketing
agree2 = Zgoda na kontakt
agree3 = "0"
agree4 = Oświadczenie o zakupie na użytek własny
agree5 = Oświadczenie o zapoznaniu się z regulaminem sklepu(dostawcy)
agree6 = Upoważnienie do odpytania w biurach informacji gospodarczej
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

Informacje o wniosku wysyłamy do platformy finansowej, żadaniem POST pod adres:  
https://www.platformafinansowa.pl/import-ratalna

Payload przygotowujemy w następujacy sposób:

```text
wniosek = select * -{poza id z tabeli} from wniosek where id = {id wniosku z sesji}
dane = select * -{poza id z tabeli} from dane where id = {id wniosku z sesji}
dochod = select * -{poza id z tabeli} from dochod where id = {id wniosku z sesji}
zakup = select tryb,wysylka from zakup where wniosek = {id wniosku z sesji}
produkt = select id,nazwa,produkt,ilosc,wysylka,cena from zakup where wniosek = {id wniosku z sesji}


parametry = 
[
  wniosek,
  dane,
  dochod,
  zakup,
  produkt
];
parametry = serialize(parametry);
```

Dane są serializowane w php za pomocą funkcji serialize, przykładowa biblioteka w javie, która zrobi to samo:
https://code.google.com/archive/p/serialized-php-parser/
Przesyłamy parametry w kluczu 'wniosek' w ciele żądania, z nagłówkiem `Content-type: multipart/form-data`

Po otrzymaniu odpowiedzi z platformy finansowej w postaci numeru wniosku z platformy finansowej wysyłamy generujemy link
z przekierowaniem do dokończenia wniosku.
nr_wniosku_z_pf = nr_wniosku z odpowiedzi na poprzedni POST  
id_wniosku_z_pf = `split(nr_wniosku_z_pf, '|')[0]`  
nr_sklepi_z_pf = `split(nr_wniosku_z_pf, '|')[1]`  
Generujemy link z przekierowaniem w mailu do wnioskodawcy: www.iraty.pl/wniosek/finalizacja/{id_wniosku}/{id_wniosku_z_pf}/{nr_sklepi_z_pf}'

Następnie wysyłamy email do klienta z linkiem do finalizacji wniosku +  
wysyłamy sms z powiadomieniem na podany numer telefonu i przechodzimy do ekranu końcowego. Też z informacją, że link został
wysłany mailowo.

Kiedy wnioskodawca kliknie link na mailu strzelamy POST wysyłamy formularz do banku santander. Tak jak w [korku 4](#krok-4-podsumowanie---httpiratyplpodsumowanie) w przypadku wniosku przez stronę
Tylko z tą różnicą, że id_wniosku_z_pf i nr_sklepi_z_pf pobieramy z linku, a nie z odpowiedzi z platformy finansowej.
