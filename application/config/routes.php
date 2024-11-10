<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin'] = 'main/administrator';
$route['zarzadzanie'] = 'main/zarzadzanie';
$route['loguj'] = 'main/loguj';
$route['wyloguj'] = 'main/wyloguj';
$route['popup/hide'] = 'main/popup_hide';

$route['przywroc'] = 'main/przywroc';
$route['kontakt/wyslij'] = 'main/wyslij';

$route['fintest'] = 'main/fintest';

$route['wniosek'] = 'main/wniosek';
$route['zloz-wniosek'] = 'main/wniosek_start';
$route['integracja'] = 'main/wniosek';
$route['zloz-wniosek/2'] = 'main/wniosek';
$route['zloz-wniosek/(:num)'] = 'main/wniosek_start/$1';
$route['dane-osobowe'] = 'main/wniosek_3';
$route['zloz-wniosek/3'] = 'main/wniosek_3';
$route['wysylka-faktura'] = 'main/wniosek_4';
$route['podsumowanie'] = 'main/wniosek_5';
$route['podsumowanie-alt'] = 'main/wniosek_6';
$route['podsumowanie/test'] = 'main/wniosek_7';
$route['wniosek/finalizacja/(:num)/(:num)/(:num)'] = 'main/finalizuj/$1/$2/$3';

$route['kalkulator,(:num),(:any)'] = 'main/kalkulator_move/$1/$2';
$route['kalkulator,(:num)'] = 'main/kalkulator_move/$1';

$route['kalkulator'] = 'main/wniosek_start';
$route['kalkulator/(:num)'] = 'main/wniosek_start/$1';
$route['kalkulator/(:num)/(:any)'] = 'main/wniosek_start/$1/$2';
$route['kalkulator/(:num)/(:any)/(:any)'] = 'main/wniosek_start/$1/$2/$3';
$route['kalkulator/(:num)/(:any)/(:any)/(:any)'] = 'main/wniosek_start/$1/$2/$3/$4';

#$route['wniosek/dane/nowe_zapisz'] = 'main/nowe_zapisz_dane';
#$route['wniosek/dane/nowe_zapisz/wysylka'] = 'main/zapisz_wysylka';
#$route['wniosek/dane/nowe_zapisz/faktura'] = 'main/zapisz_faktura';

$route['kalkulacja'] = 'main/iframe';
$route['kalkulacja/(:num)'] = 'main/iframe/$1';
$route['kalkulacja/(:num)/(:any)'] = 'main/iframe/$1/$2';

$route['wniosek/rozpocznij'] = 'main/rozpocznij_wniosek';
$route['wniosek/dane/zapisz'] = 'main/zapisz_dane';
$route['wniosek/faktura/zapisz'] = 'main/zapisz_faktura';
$route['wniosek/uslugowy/zapisz'] = 'main/zapisz_uslugowy';
$route['wniosek/zapisz'] = 'main/zapisz';

$route['blog/(:num)-(:any)'] = 'main/blog/$1/$2';

$route['zarzadzanie/menu'] = 'menu/index';
$route['zarzadzanie/menu/(:num)'] = 'menu/index/$1';
$route['menu/edytuj/(:num)'] = 'menu/edytuj/$1';
$route['menu/dodaj'] = 'menu/dodaj';
$route['menu/zapisz'] = 'menu/zapisz';
$route['menu/kolejnosc/zapisz'] = 'menu/kolejnosc';
$route['menu/status/(:num)/(:num)'] = 'menu/status/$1/$2';

$route['zarzadzanie/blog'] = 'blog/index';
$route['zarzadzanie/blog/(:num)'] = 'blog/index/$1';
$route['blog/edytuj/(:num)'] = 'blog/edytuj/$1';
$route['blog/dodaj'] = 'blog/dodaj';
$route['blog/zapisz'] = 'blog/zapisz';
$route['blog/kolejnosc/zapisz'] = 'blog/kolejnosc';
$route['blog/status/(:num)/(:num)'] = 'blog/status/$1/$2';
$route['blog/src/dodaj'] = 'blog/glowne_dodaj';
$route['blog/src/usun/(:num)'] = 'blog/glowne_usun/$1';

$route['zarzadzanie/faq'] = 'faq/index';
$route['zarzadzanie/faq/(:num)'] = 'faq/index/$1';
$route['faq/edytuj/(:num)'] = 'faq/edytuj/$1';
$route['faq/dodaj'] = 'faq/dodaj';
$route['faq/zapisz'] = 'faq/zapisz';
$route['faq/kolejnosc/zapisz'] = 'faq/kolejnosc';
$route['faq/status/(:num)/(:num)'] = 'faq/status/$1/$2';
$route['faq/src/dodaj'] = 'faq/glowne_dodaj';
$route['faq/src/usun/(:num)'] = 'faq/glowne_usun/$1';

$route['faq/kategorie'] = 'faq/kategorie';
$route['faq/kategorie/zapisz'] = 'faq/kategorie_zapisz';
$route['faq/kategorie/kolejnosc/zapisz'] = 'faq/kategorie_kolejnosc';
$route['faq/kategorie/usun/(:num)'] = 'faq/kategorie_usun/$1';

$route['zarzadzanie/podstrona'] = 'podstrona/index';
$route['zarzadzanie/podstrona/(:num)'] = 'podstrona/index/$1';
$route['podstrona/edytuj/(:num)'] = 'podstrona/edytuj/$1';
$route['podstrona/dodaj'] = 'podstrona/dodaj';
$route['podstrona/zapisz'] = 'podstrona/zapisz';
$route['podstrona/status/(:num)/(:num)'] = 'podstrona/status/$1/$2';
$route['podstrona/kolejnosc/zapisz'] = 'podstrona/kolejnosc';

$route['modul/(:num)'] = 'modul/index';
$route['modul/(:num)/(:num)'] = 'modul/index/$1';
$route['modul/edytuj/(:num)'] = 'modul/edytuj/$1';
$route['modul/(:num)/dodaj'] = 'modul/dodaj/$1';
$route['modul/zapisz'] = 'modul/zapisz';
$route['modul/status/(:num)/(:num)'] = 'modul/status/$1/$2';
$route['modul/kolejnosc/zapisz'] = 'modul/kolejnosc';
$route['modul/tlo/dodaj'] = 'modul/tlo_dodaj';
$route['modul/tlo/usun/(:num)'] = 'modul/tlo_usun/$1';

$route['zarzadzanie/komunikaty'] = 'komunikaty/index';
$route['zarzadzanie/komunikaty/(:num)'] = 'komunikaty/index/$1';
$route['komunikaty/zapisz'] = 'komunikaty/zapisz';
$route['komunikaty/status/(:num)/(:num)'] = 'komunikaty/status/$1/$2';

$route['cron'] = 'cron/index';

$route['(:any)'] = 'main/podstrona/$1/$2';

$route['default_controller'] = 'main';
$route['404_override'] = 'main/error404';
$route['translate_uri_dashes'] = FALSE;
