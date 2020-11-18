# Spis treści:
* Uruchomienie:
  * [Instalacja paczki](#instalacja-paczki)
  * [Inicjalizacja klasy](#inicjalizacja-klasy)
* Typy postów i taksomonie:
  * [Rejestracja własnego typu postu **_(post-types.php)_**](#rejestracja-w%C5%82asnego-typu-postu)
  * [Rejestracja taksonomii **_(taxonomies.php)_**](#rejestracja-taksonomii)
  * [Przyjazne linki](#przyjazne-linki)
* Tłumaczenia **_(translate.php)_**:
  * [Typów postów](#informacje-o-t%C5%82umaczeniu)
  * [Taksonomii](#informacje-o-t%C5%82umaczeniu-1)
  * [JS](#t%C5%82umaczenie-js)
  * [Options Pages](#usprawnienia-dla-pluginu-polylang)
* Includowanie plików **_(include.php)_**:
  * [CSS](#includowanie-plik%C3%B3w-css)
  * [JS](#includowanie-plik%C3%B3w-js)
  * [PHP](#includowanie-plik%C3%B3w-php)
* ACF **_(acf.php)_**:
  * [Ikony](#wybieranie-ikon)
  * [Options Pages](#options-pages)
* Panel administracyjny **_(admin.php)_**:
  * [Menu](#menu-w-panelu-administracyjnym)
  * [TinyMCE](#konfiguracja-tinymce)
  * [Wyłączanie Gutenberga](#wy%C5%82%C4%85czanie-gutenberga)
* Ustawienia **_(settings.php)_**:
  * [Rozmiary obrazków](#rozmiary-obrazk%C3%B3w)
  * [Rejestracja menu](#rejestracja-menu)
  * [Blokada aktualizacji pluginów](#blokada-aktualizacji-plugin%C3%B3w)
  * [Konfiguracja bezpieczeństwa](#konfiguracja-bezpiecze%C5%84stwa)
  * [Dozwolone typy plików przy uploadzie](#dozwolone-typy-plik%C3%B3w-przy-uploadzie)
* Cache strony **_(cache.php)_**:
  * [Konfiguracja](#cache-strony)
* Formularze **_(forms.php)_**:
  * [Wywołanie](#formularze-kontaktowe)
  * [Zasada działania](#zasada-dzia%C5%82ania)
  * [Lista wspieranych pól](#lista-wspieranych-p%C3%B3l)
  * [Walidacja](#walidacja)
  * [Wysyłanie formularza](#wysy%C5%82anie-formularza)
  * [Dane formularza](#dane-formularza)
  * [Eventy w JS](#eventy-w-js)
  * [Obsługa pól dla plików](#obs%C5%82uga-p%C3%B3l-dla-plik%C3%B3w)
* Narzędzia **_(tools.php)_**:
  * [Czyszczenie strony](#czyszczenie-strony)
  * [Statystyki odwiedzin](#statystyki-odwiedzin)
  * [Walidator kategorii](#walidator-kategorii)
* Moduły wbudowane:
  * [Udostępnianie w social media](#udost%C4%99pnianie-w-social-media)
  * [Integracje](#integracje)
  * [Generowanie sitemap](#generowanie-sitemap)
  * [Konfiguracja wysyłki e-maili](#konfiguracja-wysy%C5%82ki-e-maili)
* Funkcje pomocnicze:
  * [Lista breadcrumbs](#pobieranie-breadcrumbs)
  * [Wyświetlanie favicons](#wy%C5%9Bwietlanie-favicons)
  * [Pobieranie z Instagrama](#pobieranie-z-instagrama)
  * [Lista języków](#pobieranie-listy-j%C4%99zyk%C3%B3w)
  * [Pobieranie menu](#pobieranie-menu)
  * [Lista kategorii](#pobieranie-listy-kategorii)
* Dodatkowe hooki:
  * [Przekształcanie tekstu (Ajax)](#przekszta%C5%82canie-tekstu-przy-zapytaniach-ajax)
* SEO:
  * [Wsparcie SEO](#wsparcie-seo)
* Użyteczności:
  * [Ogólne](#u%C5%BCyteczno%C5%9Bci-og%C3%B3lne)
  * [Panel administracyjny](#u%C5%BCyteczno%C5%9Bci-w-panelu-administracyjnym)
  * [Tłumaczenie](#u%C5%BCyteczno%C5%9Bci-dla-t%C5%82umaczenia)
  * [ACF](#u%C5%BCyteczno%C5%9Bci-dla-acf)
  * [Yoast SEO](#u%C5%BCyteczno%C5%9Bci-dla-yoast-seo)

##### `!` Pamiętaj o pełnym uruchomieniu [funkcji zabezpieczających WordPressa](#-uruchomienie-wszystkich-funkcjonalno%C5%9Bci).

&nbsp;

&nbsp;

# Instalacja paczki

#### Composer.json:

Plik **composer.json** należy umieścić w głównym katalogu motywu.

W pliku `.gitignore` znajdującym się w głównym katalogu projektu należy dodać linię wykluczającą katalog **/vendor**: `**/themes/**/vendor/`.

```
{
  "name": "wordpress-starter-theme",
  "description": "WordPress Starter Theme",
  "authors": [
    {
      "name": "Mateusz Gbiorczyk",
      "email": "mateusz.gbiorczyk@crafton.pl",
      "homepage": "https://crafton.pl/",
      "role": "Web Developer"
    }
  ],
  "repositories": [
    {
      "type": "vcs",
      "url": "git@gitlab.com:gbiorczyk/wordpress-framework.git"
    }
  ],
  "require": {
    "gbiorczyk/wordpress-framework": "1.2.*"
  },
  "prefer-stable": true
}
```

Po dodaniu tego pliku należy otworzyć konsolę w katalogu motywu oraz uruchomić polecenie `composer install`. 

Jeżeli wystąpi problem z pobraniem paczki przy użyciu polecenia `composer install` _(w sytuacji, gdy Composer jest już używany)_ należy usunąć plik **composer.lock** oraz katalog **/vendor**.

#### Aktualizacje:

Istnieje możliwość aktualizowania Frameworka do nowszej wersji. Aby tego dokonać trzeba otworzyć konsolę w katalogu motywu oraz uruchomić polecenie `composer update`. Maksymalna obsługiwana wersja jest ograniczona w pliku **composer.json**.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Inicjalizacja klasy

#### Wywołanie:

```
<?php

  /* ---
    Name: WordPress Framework
    Author: Mateusz Gbiorczyk
    Docs: https://gitlab.com/gbiorczyk/wordpress-framework/
    License: All rights reserved
  --- */

  require_once 'vendor/autoload.php';
  $framework = new Framework\Framework();

  $path = 'functions/framework/';
  require_once $path . 'post-types.php';
  require_once $path . 'taxonomies.php';
  require_once $path . 'translate.php';
  require_once $path . 'include.php';
  require_once $path . 'acf.php';
  require_once $path . 'admin.php';
  require_once $path . 'settings.php';
  require_once $path . 'cache.php';
  require_once $path . 'forms.php';
  require_once $path . 'tools.php';
```

#### Konfiguracja:

Pamiętaj, aby utworzyć odpowiednie pliki w katalogu **/functions/framework/** _(wg wzorca powyżej)_ - odpowiednie pogrupowanie funkcji pozwoli na łatwiejsze zarządzanie nimi. Należy `trzymać się zalecanej struktury`, a sam plik **functions.php** poza inicjacją Frameworka nie powinien zawierać żadnych innych kodów.

Lista plików w katalogu `/functions/framework/` jest spójna z głównymi kategoriami _(obok nich podane są również nazwy plików)_ w [spisie treści](#spis-tre%C5%9Bci) tej dokumentacji, dzięki czemu bez problemu można odpowiednio umieścić daną funkcję we właściwym miejscu.

Komentarz na początku pliku jest istotny, ponieważ informuje o tym, na czym oparty jest motyw i gdzie można uzyskać szczegółowe informacje.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Rejestracja własnego typu postu

#### Wywołanie:

###### *(powtórz dla każdego kolejnego typu postu)*

```
$framework->posttype->action('register', ${args});
```

#### Przykład użycia:

```
$framework->posttype->action('register', [
  'slug'    => 'events',
  'rewrite' => 'pokoje',
  'icon'    => 'dashicons-admin-home',
  'labels'  => [
    'name'     => __('Pokoje', 'lang'),
    'menu'     => 'Pokoje',
    'singular' => 'Pokój',
    'add'      => 'Dodaj nowy pokój'
  ],
  'langs'   => [
    'pl' => 'pokoje',
    'en' => 'rooms'
  ],
  'args'    => []
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | ... | Wartość | Opis |
|:--|:--|:--|:--|
| slug    |          | string  | unikalny slug dla typu postu |
| rewrite |          | string  | slug występujący w adresie URL |
| icon    |          | boolean | slug ikony ([lista](https://developer.wordpress.org/resource/dashicons/))
| labels  |          | array   | ↴ |
|         | name     | string  | nazwa w liczbie mnogiej _(np. Książki czy Listy spraw)_ |
|         | menu     | string  | nazwa opcji w menu _(wartość opcjonalna; jeżeli nie jest dostępna to zostanie użyta wartość `name`)_ |
|         | singular | string  | mianownik _(np. Książka czy Lista spraw)_ |
|         | add      | string  | fraza dodawania nowego elementu _(np. Dodaj nową książkę lub Dodaj nową listę spraw)_; istotne jest zachowanie dwóch pierwszych wyrazów _(Dodaj nowy(ą) lub Add new)_ |
| langs   |          | array   | wartość opcjonalna; lista tłumaczeń slugu dla innych języków niż domyślny _(nazwa klucza to slug języka, a wartością jest przetłumaczony slug typu postu)_ |
| args    |          | array   | wartość opcjonalna; lista parametrów w formie tablicy, która nadpisuje domyślne argumenty ([źródło](https://codex.wordpress.org/Function_Reference/register_post_type#Arguments)) |

#### Dodatkowe informacje:

* domyślnie Custom Post Types dodają się w menu na pozycji `30` ([struktura menu](https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure))
* zachowując domyślne ustawienia pozycji, nad listą typów postów dodany zostaje separator, który oddziela te sekcje od pozostałych _(jest to bardziej przejrzyste dla administratora)_
* domyślna rejestracja Custom Post Type obsługuje jedynie pole tytułu _(pole typu content nie jest potrzebne, ponieważ edycja treści tworzy się się za pomocą pól z pluginu Advanced Custom Fields)_
* dodatkowo obsługiwane są rewizje
* jeżeli chcesz dodać typ postu, który nie ma swojego archiwum ani pojedynczej strony to należy do tablicy argumentów dodać klucz `publicly_queryable` z wartością `false`

#### Informacje o tłumaczeniu:

* Framework jest kompatybilny z pluginem `Polylang` do tłumaczeń _(dodaje do wersji darmowej część opcji zawartych w wersji PRO)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Rejestracja taksonomii

#### Wywołanie:

###### _(powtórz dla każdej kolejnej taksonomii)_

```
$framework->taxonomy->action('register', ${args});
```

#### Przykład użycia:

```
$framework->taxonomy->action('register', [
  'slug'        => 'types',
  'rewrite'     => 'typy',
  'posttypes'   => ['rooms'],
  'is_category' => true,
  'labels'      => [
    'name'     => __('Typy', 'lang'),
    'menu'     => 'Typy',
    'singular' => 'Typ',
    'add'      => 'Dodaj nowy typ'
  ],
  'langs'       => [
    'pl' => 'typy',
    'en' => 'types'
  ],
  'args'        => []
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | ... | Wartość | Opis |
|:--|:--|:--|:--|
| slug        |          | string  | unikalny slug dla taksonomii _(zalecany wzór: `{posttype}-category`)_ |
| rewrite     |          | string  | slug występujący w adresie URL |
| posttypes   |          | array   | lista slugów Post Types, dla których ma być przypięta ta taksonomia
| is_category |          | boolean | true oznacza użycie taksonomii jako kategorii, a false jako tagów
| labels      |          | array   | ↴ |
|             | name     | string  | nazwa w liczbie mnogiej _(np. Sektory czy Kolory aut)_ |
|             | menu     | string  | nazwa opcji w menu _(wartość opcjonalna, jeżeli nie jest dostępna to zostanie użyta wartość `name`)_ |
|             | singular | string  | mianownik _(np. Sektor czy Kolor auta)_ |
|             | add      | string  | fraza dodawania nowego elementu _(np. Dodaj nowy sektor lub Dodaj nowy kolor auta)_; istotne jest zachowanie dwóch pierwszych wyrazów _(Dodaj nowy(ą) lub Add new)_ |
| langs       |          | array   | wartość opcjonalna; lista tłumaczeń slugu dla innych języków niż domyślny _(nazwa klucza to slug języka, a wartością jest przetłumaczony slug typu postu)_ |
| args        |          | array   | wartość opcjonalna; lista parametrów w formie tablicy, która nadpisuje domyślne argumenty ([źródło](https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments)) |

#### Informacje o tłumaczeniu:

* Framework jest kompatybilny z pluginem `Polylang` do tłumaczeń _(dodaje do wersji darmowej opcje zawarte z wersji PRO)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)
* jeżeli korzystasz z pluginu [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/) do tworzenia przyjaznych linków, pamiętaj aby tłumacząc taksonomię podawać przetłumaczony slug odpowiadającego typu postu, a nie taksonomii _(w innym przypadku tłumaczenie przywróci domyślną strukturę dla linków do archiwum kategorii)_
* jeżeli chcesz dodać taksonomię, który nie ma swojego archiwum to należy do tablicy argumentów dodać klucz `publicly_queryable` z wartością `false`

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Przyjazne linki

Domyślna struktura linków w WordPressie wygląda następująco:
* Custom Post Type > Post
* Taxonomy > Single Term

Struktura ta nie jest w pełni przyjazna pod kątem zarówno SEO, jak i użyteczna dla samych użytkowników, którzy mogą próbować skrócić link, aby przejść wyżej w hierarchi strony. Do tworzenia lepszej struktury zaleca się skorzystanie z pluginu [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/).

Korzystając z niego mamy możliwość utworzenia poniższej struktury linków:
* Custom Post Type > Single Term > Post
* Custom Post Type > Post _(jeżeli nie ma zaznaczonej żadnej kategorii)_
* Custom Post Type > Single Term

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Tłumaczenie JS

#### Wywołanie:

```
$framework->translate->action('js', ${args});
```

#### Przykład użycia:

```
$framework->translate->action('js', [
  'example' => __('Przykład', 'lang')
]);
```

#### Dodatkowe informacje:

* jako argumenty podajemy tablicę z frazami, które używane są w plikach JS
* klucze elementów tabeli to `slugi`, do których potem odwołujemy się w plikach skryptów
* wartość powinna być tekstem zawartym w [funkcji i18n](https://codex.wordpress.org/I18n_for_WordPress_Developers#Translatable_strings)
* w pliku JS nie wpisujemy wtedy tekstu, tylko nazwę zmiennej _(np. `translate.text`)_
* `wpF.translate` jest stałą nazwą tablicy

`!` Nie należy wpisywać fraz tekstowych w plikach JS. Wszystkie one powinny być dodane w kodzie PHP i przekazywane do JS w formie tablicy.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Includowanie plików CSS

##### Wywołanie:

```
$framework->loader->action({tryb}, ${args});
```

###### Przykład użycia:

```
$framework->loader->action('css',
  ['public/build/css/styles.css']
);
```

##### Informacje dodatkowe:

* dostępne tryby:
  * `css` - standardowe ładowanie plików CSS
  * `inline-css` - wyświetlanie zawartości plików CSS w sekcji head _(wyłączone dla localhost)_
  * `admin-css` - ładowanie plików CSS w panelu administracyjnym
* jako argumenty podajemy ścieżkę do pliku lub listę ścieżek w formie tablicy:
  * dla plików lokalnych adres względny _(względem katalogu głównego motywu)_
  * dla plików zewnętrznych adres bezwzględny _(z użyciem http lub https)_
* do adresu pliku dodawana jest wersja zawierająca datę ostatniej modyfikacji pliku _(rozwiązuje to problem cache przeglądarki)_

`!` W przypadku wyświetlania zawartości plików CSS w sekcji head, adresy URL dla obrazków oraz fontów _(`../`, `../../` lub `../../../`)_ zamieniane są na poprawne. Więcej informacji w sekcji [Wsparcie SEO](#wsparcie-seo).

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Includowanie plików JS

##### Wywołanie:

```
$framework->loader->action({tryb}, ${args});
```

###### Przykład użycia:

```
$framework->loader->action('js',
  ['public/build/js/scripts.js']
);
```

##### Informacje dodatkowe:

* dostępne tryby:
  * `js` - standardowe ładowanie plików JS
  * `admin-js` - ładowanie plików JS w panelu administracyjnym
* jako argumenty podajemy ścieżkę do pliku lub listę ścieżek w formie tablicy:
  * dla plików lokalnych adres względny _(względem katalogu głównego motywu)_
  * dla plików zewnętrznych adres bezwzględny _(z użyciem http lub https)_
* do adresu pliku dodawana jest wersja zawierająca datę ostatniej modyfikacji pliku _(rozwiązuje to problem cache przeglądarki)_
* na front-edzie funkcja ta automatycznie `przenosi jQuery do stopki` _(jeżeli jest włączone)_, w celu uzyskania lepszych wyników w testach szybkości strony

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Includowanie plików PHP

##### Wywołanie:

```
$framework->loader->action('php', ${args});
```

###### Przykład użycia:

```
$framework->loader->action('php',
  ['functions/directory']
);
```

#### Informacje dodatkowe:

* jako argumenty przekazujemy adres względny do folderu _(względem katalogu głównego motywu)_ lub listę adresów w formie tablicy
* w danych folderze zostaną zaincludowane wszystkie pliki PHP

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Wybieranie ikon

#### Wywołanie:

```
$framework->acf->action('icons', ${args});
```

#### Przykład użycia:

```
$framework->acf->action('icons', [
  'icon-example-1',
  'icon-example-2',
  'icon-example-3'
]);
```

##### Informacje dodatkowe:

* jako argumenty przekazujemy tablicę z nazwami klas od ikon _(takie, jak są wygenerowane przez `Icomoon`)_
* funkcja zamienia wszystkie pola typu Select _(muszą posiadać slug `icon` oraz mieć zaznaczoną opcję pokazania `ostylowanego interfejsu`)_ na wizualną listę wyboru ikon _(ułatwia to wybór ikon przy ich większej liczbie)_
* lista opcji do wyboru jest uzupełniana automatycznie
* dodatkowo do pliku CSS dla panelu administracyjnego należy dodać kod z ikonami _(oryginalny wygenerowany przez `Icomoon`)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Options Pages

#### Wywołanie:

```
$framework->acf->action('optionspage', ${args});
```

#### Przykład użycia:

```
$framework->acf->action('optionspage', [
  'title'       => 'Zarządzanie',
  'slug'        => 'options',
  'icon'        => 'dashicons-admin-tools',
  'pages'       => [
    'header' => 'Nagłówek',
    'footer' => 'Stopka'
  ],
  'notranslate' => []
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| title       | string | tytuł strony opcji |
| slug        | string | unikalny slug strony w menu |
| icon        | string | slug ikony ([lista](https://developer.wordpress.org/resource/dashicons/)) |
| pages       | array  | lista podstron _(klucz tablicy odpowiada za slug, a wartość za tytuł)_ |
| notranslate | array  | slugi podstron, w których pola będą posiadały jedną wartość dla wszystkich języków _(dotyczy pluginu Polylang)_ |

#### Usprawnienia dla pluginu Polylang:

Domyślnie Polylang nie wspiera tłumaczenia Options Pages. Framework daje możliwość tłumaczenia tych wartości. Dzięki temu dla każdego języka można przypisać inną wartość. Zmiana aktualnego języka odbywa się za pomocą przycisku na górnym pasku w panelu administracyjnym. Dodając Options Page nie trzeba robić żadnych dodatkowych rzeczy. Wartości na front-endzie wyświetlają się automatycznie dla aktywnego języka.

Jeżeli nie chcesz tłumaczyć wartości pól w wybranej Options Page, wystarczy dodać jej slug do tablicy `notranslate`. W sytuacji, gdy wypełniłeś już treści dla danych języków **musisz je usunąć**. Można to zrobić poleceniem w bazie danych:

```
DELETE FROM wp_options WHERE option_name LIKE '%{field_key}%' AND option_name NOT LIKE '%options_{field_key}%'
```

Frazę `{field_key}` podmień na klucz danego pola _(pamiętaj o zmianie prefixu tabeli)_ i powtórz tą operację dla wszystkich pól, których to dotyczy.

#### Dodatkowe użyteczności:

* dodanie do menu Options Pages linku do edycji strony głównej
* dodanie do menu Options Pages linku do zarządzania Menu

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Menu w panelu administracyjnym

#### Wywołanie:

```
$framework->admin->action('menu', ${args});
```

#### Przykład użycia:

```
$framework->admin->action('menu', [
  'posts'     => true,
  'pages'     => true,
  'comments'  => false,
  'customize' => false,
  'wp_tools'  => false
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| posts     | boolean | widoczność sekcji `Wpisy` w menu panelu administracyjnego |
| pages     | boolean | widoczność sekcji `Strony` w menu panelu administracyjnego |
| comments  | boolean | widoczność sekcji `Komentarze` w menu panelu administracyjnego |
| customize | boolean | widoczność sekcji `Wygląd -> Personalizacja` w menu panelu administracyjnego |
| wp_tools  | boolean | widoczność sekcji `Narzędzia -> Dostępne narzędzia, Import oraz Eksport` w menu panelu administracyjnego |

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Konfiguracja TinyMCE

#### Wywołanie:

```
$framework->admin->action('tinymce', ${args});
```

#### Przykład użycia:

```
$framework->admin->action('tinymce', [
  'pages_editor' => false,
  'buttons_1'    => [
    'formatselect',
    'bold',
    'italic',
    'bullist',
    'numlist',
    'blockquote',
    'alignleft',
    'aligncenter',
    'alignright',
    'link',
    'wp_more',
    'spellchecker',
    'dfw',
    'wp_adv'
  ],
  'buttons_2'    => [
    'strikethrough',
    'hr',
    'forecolor',
    'pastetext',
    'removeformat',
    'charmap',
    'outdent',
    'indent',
    'undo',
    'redo',
    'wp_help'
  ],
  'formats'      => [
    'h1' => 'Nagłówek 1',
    'h2' => 'Nagłówek 2',
    'h3' => 'Nagłówek 3',
    'h4' => 'Nagłówek 4',
    'h5' => 'Nagłówek 5',
    'h6' => 'Nagłówek 6',
    'p'  => 'Paragraf'
  ]
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| pages_editor | boolean | widoczność pola typu `content` podczas edycji podstron |
| buttons_1    | array   | lista przycisków w pierwszej linii w edytorze TinyMCE _(wg wybranej kolejności)_ |
| buttons_2    | array   | lista przycisków w drugiej linii w edytorze TinyMCE _(wg wybranej kolejności)_ |
| formats      | array   | lista dostępnych typów formatów |

#### Dodatkowe informacje:

* jako klucze w tablicy `formats` przekazujemy tag HTML _(`h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `p`)_
* wartości to nazwy formatów widoczne dla administratora w edytorze
* `!` użycie poszczególnych argumentów funkcji jest opcjonalne _(jeżeli nie ma potrzeby zmiany danych parametrów, nie trzeba ich podawać)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Wyłączanie Gutenberga

#### Wywołanie:

```
$framework->admin->action('gutenberg', ${arg});
```

#### Przykład użycia:

```
$framework->admin->action('gutenberg', false);
```

#### Dodatkowe informacje:

* jako argument przekazujemy wartość boolean, która oznacza, czy chcemy włączyć bądź wyłączyć globalnie edytor Gutenberg
* domyślnie Gutenberg jest wyłączony _(nie ma potrzeby używania akcji, aby przekazać wartość `false`)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Rozmiary obrazków

#### Wywołanie:

```
$framework->settings->action('images', ${args});
```

#### Przykład użycia:

```
$framework->settings->action('images', [
  'image-full'   => [
    'width'  => 1920,
    'height' => 1080,
    'crop'   => true,
    'editor' => false
  ],
  'image-medium' => [
    'width'  => 1000,
    'height' => 1000,
    'crop'   => true,
    'editor' => 'Duże zdjęcie'
  ],
  'image-small'  => [
    'width'  => 500,
    'height' => 500,
    'crop'   => true,
    'editor' => 'Małe zdjęcie'
  ]
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| width  | integer          | szerokość w px |
| height | integer          | wysokość w px |
| crop   | boolean          | true oznacza włączenie kadrowania zdjęć do danego rozmiaru |
| editor | string / boolean | nazwa rozmiaru obrazka w edytorze przy dodawaniu zdjęcia _(w przypadku wartości false dany rozmiar nie będzie dostępny)_ |

#### Informacje:

* jako argumenty przekazujemy tablicę z listą rozmiarów
* jako klucze przekazujemy `slugi` używane potem do pobierania adresu obrazka w danym rozmiarze
* wartości to tablice z argumentami
* domyślne rozmiary obrazków `medium` i `large` są usuwane, dostępny jest tylko rozmiar `thumbnail` oraz własne

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Rejestracja menu

#### Wywołanie:

```
$framework->settings->action('nav', ${args});
```

#### Przykład użycia:

```
$framework->settings->action('nav', [
  'top_nav'  => 'Nawigacja górna',
  'main_nav' => 'Nawigacja główna'
]);
```

#### Informacje:

* jako argumenty przekazujemy tablicę z listą lokalizacji menu
* jako klucze przekazujemy `slugi` używane potem do wyświetlania menu
* wartości to nazwy menu widoczne w panelu administracyjnym

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Blokada aktualizacji pluginów

#### Wywołanie:

```
$framework->settings->action('plugins-update', ${args});
```

#### Przykład użycia:

```
$framework->settings->action('plugins-update', [
  'contact-form-7' => 'wp-contact-form-7.php'
]);
```

#### Informacje:

* jako argumenty przekazujemy tablicę z listą pluginów
* jako klucze przekazujemy nazwę folderu, w którym znajduje się plugin
* wartości to nazwy głównych plików pluginów
* dodatkowo poza blokadą aktualizacji ukrywane są wszystkie notyfikacje wyświetlane przez dany plugin

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Konfiguracja bezpieczeństwa

#### Wywołanie:

```
$framework->settings->action('security', ${args});
```

#### Przykład użycia:

```
$framework->settings->action('security', [
  'wpc_path_allow' => [
    'wp-content/example.php'
  ],
  'login_url'      => 'my-login'
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| wpc_path_allow | array  | lista ścieżek do plików PHP w katalogu `/wp-content`, do których dostęp powinien być aktywny _(np. wp-content/example.php)_ |
| login_url      | string | nowy adres logowania _(nie należy używać symbolu `/` oraz podawać adresu url na front-endzie)_ |

#### `!` Uruchomienie wszystkich funkcjonalności:
* podepnij wszystkie pliki i dodaj konfigurację dla sekcji [Konfiguracja bezpieczeństwa](#konfiguracja-bezpiecze%C5%84stwa)
* zaloguj się do panelu administracyjnego
* przejdź do _Ustawienia_ > _Bezpośrednie odnośniki_
* kliknij przycisk _Zapisz zmiany_
* kroki `należy powtórzyć` po wgraniu gotowej strony na serwer klienta

#### Lista funkcji zabezpieczających:
* reguły w pliku .htaccess:
  * wyłączenie wyświetlania błędów dla wszystkich plików PHP _(dotyczy bezpośredniego wejścia na plik .php)_
  * zabezpieczenie pliku `wp-config.php`
  * blokada możliwości przeglądania listy katalogów
  * zabezpieczenie katalogów:
    * zabezpieczenie katalogu `/wp-admin` oraz `/wp-includes`
    * `*` blokada wykonywania plików PHP w katalogu `/wp-content`
    * blokada dostępu do katalogów przez roboty
  * blokada dostępu do plików _(bez rozróżnienia wielkości znaków)_:
      * serwerowych w formacie: `.htaccess`, `.htpasswd`, `.ini`, `.phps`, `.fla`, `.log` lub `.sh`
      * z błędami serwera: `error_log`
      * `changelog.txt`, `license.html`, `license.txt`, `license.commercial.txt`, `readme.html`, `readme.md` oraz `readme.txt`
      * `install.php` oraz `upgrade.php`
      * z rozszerzeniami: `.bak`, `.git`, `.svn`, `.sql`, `.tar` lub `.tar.gz`
  * blokada adresu zdalnej naprawy bazy danych
  * uniemożliwienie ataku typu URL Haking przy zastosowaniu metod HEAD, TRACE, DELETE lub TRACK
  * modyfikacja nagłówków:
      * zabezpieczenie przed atakiem typu Clickjacking
      * zmniejszenie ryzyka ataku typu XSS
      * wyłączanie zgadywania typu MIME strony przez przeglądarki
  * blokada dostępu do pliku xmlrpc.php
  * blokada enumeracji użytkowników
* zabezpieczanie samego WordPressa:
  * wyłączenie wyświetlania błędów w PHP podczas korzystania z CMS _(przy wyłączonym trybie debugowania)_
  * automatyczna aktualizacja WordPressa
  * ukrycie wersji WordPressa
  * ukrycie nagłówków WordPressa
  * zmiana domyślnego adresu logowania do panelu administracyjnego
  * limit ilości prób logowania
  * ustawienie własnego komunikatu podczas błędu logowania
  * `*` wyłączenie XML-RPC
  * blokada edycji plików motywu i pluginów
  * blokada nieautoryzowanego dostępu do plików load-scripts.php oraz load-styles.php
  * ukrywanie informacji pozwalających poznać login użytkownika w REST API
  * zabezpieczenie wyszukiwarki WordPressa przed wysyłaniem zapytań z innej domeny
  * zabezpieczenie przed nieautoryzowanym dodawaniem komentarzy
  * zablokowanie Trackbacks
  * ukrywanie wersji wtyczki Yoast SEO z sekcji head
* tworzenie logów monitorujących wejścia na stronę

`*` - w specyficznych przypadkach może to powodować problemy z działaniem własnych funkcji, jeżeli zostaną zablokowane ze względów bezpieczeństwa

#### Dodatkowe informacje:

* http://slides.com/mateusz-gbiorczyk/wordpress-bezpieczenstwo/
* http://in.crafton.pl/index.php/212-bezpieczenstwo-w-wordpressie-mateusz-gbiorczyk-10032017/

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Dozwolone typy plików przy uploadzie

#### Wywołanie:

```
$framework->settings->action('upload', ${args});
```

#### Przykład użycia:

```
$framework->settings->action('upload', [
  'svg' => 'image/svg+xml'
]);
```

#### Informacje:

* jako argumenty przekazujemy tablicę z listą typów plików
* jako klucze przekazujemy rozszerzenie plików
* wartości to typy plików
* listę dostępnych typów można znaleźć [tutaj](https://paulund.co.uk/change-wordpress-upload-mime-types)

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Cache strony

#### Wywołanie:

```
$framework->cache->action('config', ${args});
```

#### Przykład użycia:

```
$framework->cache->action('config', [
  'timeout'       => 3600,
  'clear_actions' => [
    'save_post',
    'acf/save_post',
    'created_term',
    'edited_terms',
    'delete_term'
  ]
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| timeout       | integer | wartość wyrażona w sekundach, oznaczająca co jaki czas powinien się odświeżać cache _(ustaw `0`, aby odświeżać cache przy każdym wejściu na stronę lub `-1`, aby wyłączyć całkiem cache)_ |
| clear_actions | array   | lista [akcji WordPressa](https://codex.wordpress.org/Plugin_API/Action_Reference), przy których będzie wykonywane czyszczenie pamięci cache |

#### Informacje:

* `!` pamiętaj używając `$_COOKIE` system zrobi kopię strony nie biorąc pod uwagę wartości z tej tablicy, dlatego w kodzie nie powinno być warunków sprawdzających ciasteczko i generujących kod HTML na jej podstawie _(dla tych operacji należy użyć JS lub całkiem wyłączyć cache)_
* system edytuje plik `wp-config.php` dodając do niego wartości `define('WP_CACHE', true);` oraz `define('CACHE_TIMEOUT', ?);` _(tych wartości nie wolno edytować - system generuje je automatycznie na podstawie ustawień z pliku `functions.php`)_
* dodatkowo tworzony jest plik `/wp-content/advanced-cache.php` odpowiadający za inicjację cache przed ładowaniem się WordPressa

#### Reguły cache:

* serwer inny niż `localhost`
* aktualna strona nie należy do panelu administracyjnego oraz spełnia jeden z warunków: `is_front_page()`, `is_home()`, `is_archive()` lub `is_single()`
* brak elementów w tablicy `$_POST` oraz `$_GET`
* strona odwiedzana przez użytkownika niezalogowanego

#### Zasada działania:

* brak danej strony w pamięci cache lub wygasły czas ważności:
  * strona jest w całości renderowana
  * kopia kodu HTML zostaje zapisana w ścieżce `/wp-content/cache/`
  * kod HTML strony jest kompresowany _(usuwane są znaki nowej linii, tabulatory oraz wielokrotne spacje)_
* ładowanie strony z pamięci cache:
  * użytkownik błyskawicznie otrzymuje kod HTML
  * następnie PHP kończy połączenie z przeglądarką _(dzięki temu w JS szybciej włączą się funkcje, które potrzebują pełnego załadowania strony)_
  * WordPress zostaje załadowany w tle, co daje możliwość korzystania ze wszystkich funkcji _(np. WP-Cron lub licznik odwiedzin)_
  * czas życia WordPressa zostaje zakończony podczas akcji `get_header` z priorytetem `0`

#### Korzyści:

* użytkownik otrzymuje kod HTML bez potrzeby oczekiwania na zakończenie renderowania strony
* błąd dotyczący czasu odpowiedzi serwera w narzędzia Google PageSpeed Insights zostaje wyeliminowany _(więcej informacji w sekcji [Wsparcie SEO](#wsparcie-seo))_
* serwer jest mniej obciążany, ponieważ połowa czasu ładowania strony to ładowanie wszystkich elementów silnika WP, pluginów i motywów, a druga połowa to renderowanie samej strony, która w przypadku korzystania z cache się nie wykonuje

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Formularze kontaktowe

#### Wywołanie:

```
$framework->forms->action('load', {$arg});
```

Jako `{$arg}` podajemy wartość boolean _(domyślnie false)_, która oznacza, czy chcemy ładować skrypty Vue.js na każdej podstronie - również tam, gdzie nie ma formularzy. Jest to przydatne w sytuacji, gdy wykorzystujemy Vue.js również do innych celów.

&nbsp;

#### Zasada działania:

System automatycznie tworzy nowy typ postu o slugu `wpf-contact-forms` dla tworzenia własnych formularzy kontaktowych. Dodając go można utworzyć listę pól, a następnie wkleić kod HTML samego formularza. Działa to na podobnej zasadzie, jak w pluginie Contact Form 7 z tą różnicą, że tutaj listę pól dodajemy przy użyciu **ACF Repeater Field**. Również wszystkie pozostałe ustawienia są obsłużone przez plugin **Advanced Custom Fields**.

Domyślnie frazy widoczne w panelu są napisane w języku angielskim, ale przygotowane jest również tłumaczenie na język polski. Dotyczy to jednak tylko panelu administracyjnego, ponieważ wszystkie komunikaty widoczne dla użytkownika na stronie są edytowalne - można bez problemu nadpisać domyślną wartość, tłumacząc ją na nowy język.

Kod HTML formularza zawiera całą jego strukturę. W miejsach, gdzie mają się znajdować pola należy wkleić shortocodes _(wybrane z listy utworzonych pól)_. Treść komunikatu o błędzie walidacji danego pola jest wyświetlana bezpośrednio pod nim - można dodać własną klasę dla tych elementów. Podobnie jest z komunikatami o pomyślnym wysłaniu formularza lub błędzie przy jego wysyłaniu - z tym wyjątkiem, że miejsce ich lokalizacji wybieramy poprzez wklejenie w wybranym miejscu odpowiednich shortocodes. Wewnątrz kodu HTML można korzystać z warunków i innych kodów Vue.js, ponieważ cały formularz jest komponentem Vue.js.

Sam formularz możemy dodać na stronie wklejając kod implementacji _(podając jako `${arg}` ID formularza - należy pamiętać, że nie wolno podawać w kodzie PHP na sztywno wartości ID)_:

```
<?= apply_filters('wpf_contact_form', ${arg}); ?>
```

Obsługą formularzy od strony front-endu zajmuje się `Vue.js`, co pozwala na dynamiczną walidację i wysyłanie wiadomości przy użyciu Ajaxa. Narzędzie do poprawnego działania wykorzystuje następujące pluginy:
* Vue.js
* VeeValidate
* VueRecaptcha
* Axios

`[!]` - należy pominąć ładowanie powyższych skryptów we własnym zakresie

Korzystając z własnych skryptów nadpisujących kod formularza _(np. plugin do modyfikacji pól typu Select czy Datapicker)_ należy pamiętać, aby **zainicjować je dopiero po uruchomieniu się instancji Vue.js**. Kody formularzy są ładowane jako ostatnie, więc do inicjacji skryptów modyfikujących DOM formularza należy użyć eventu `load` lub innego, podobnego. Vue.js jest uruchamiany od razu po załadowaniu, bez oczekiwania na załadowanie się całego DOM.

Istnieje również możliwość rozszerzenia komponentu Vue.js swoim, zawierającym własne metody zgodnie z działaniem mixinów. Aby to zrobić należy utworzyć obiekt zawierający [mixin Vue.js](https://vuejs.org/v2/guide/mixins.html), a nazwę jego zmiennej podać w konfiguracji formularza w panelu administracyjnym. Należy pamiętać, aby była to `zmienna globalna` _(podana nazwa nie może być obiektem - musi być pojedynczą zmienną)_.

&nbsp;

#### Lista wspieranych pól:

* Text
* E-mail
* Url
* Telephone
* Number
* Date
* Time
* Datetime
* Textarea
* Select
* Multiselect
* Checkbox
* Radio
* File
* reCAPTCHA

&nbsp;

#### Walidacja:

| Reguła | Wspierane typy pól | Uwagi |
|:--|:--|:--|
| Required        | -                                           | obowiązkowe dla reCAPTCHA |
| Minimum value   | Number                                      | - |
| Maximum value   | Number                                      | - |
| Step value      | Number                                      | - |
| Date before     | Date, Time, Datetime                        | - |
| Date after      | Date, Time, Datetime                        | - |
| Minimum length  | Text, Textarea                              | - |
| Maximum length  | Text, Textarea                              | - |
| File max size   | File                                        | - |
| File extensions | File                                        | możliwość zaznaczenia wybranych rozszerzeń z puli ponad 30 opcji |
| E-mail          | E-mail                                      | automatyczna walidacja |
| Url             | Url                                         | automatyczna walidacja |
| Date            | Date                                        | dozwolony format: `YYYY-MM-DD` |
|                 | Time                                        | dozwolony format: `HH:ss` |
|                 | Datetime                                    | dozwolony format: `YYYY-MM-DD HH:ss` |

Walidacja jest realizowana na front-endzie oraz na back-endzie.

Dla każdej z opcji można ustawić własny komunikat o błędzie. Domyślne komunikaty są napisane w języku angielskim oraz polskim, ale na ich bazie można stworzyć własny w innym języku. Dodatkowo należy podać również treści ogólnych komunikatów:
* pomyślne wysłanie formularza
* błąd przy wysyłaniu formularza
* błąd walidacji
* błąd walidacji wybranego pola na back-endzie

&nbsp;

#### Wysyłanie formularza:

Domyślnym sposobem wysyłki formularzy są wiadomości e-mail. Ich zawartość _(adresata, nadawcę, temat, dodatkowe nagłówki, treść wiadomości)_ można skonfigurować w panelu administracyjnym. W tych polach istnieje możliwość korzystania z shortcode, aby wartości były dynamicznie pobierane z formularza. 

`[?]` Nie zawsze trzeba wysyłać wiadomości e-mail. Framework daje możliwość **wysyłki formularzy również przy użyciu własnej funkcji PHP**. Można to używać zamiennie z e-mailem lub skorzystać z obu opcji dla danego formularza. Funkcja PHP jest wykonywana przed wysłaniem wiadomości e-mail, więc w sytuacji zwrócenia błędu przez tą funkcję, dalsze działania zostaną przerwane.

Dla wysyłki formularzy dostępnych jest kilka filtrów, które umożliwiają spersonalizowanie ich działania:

* filtr `wpf_forms_values` umożliwia modyfikację wartości przesyłanych przez formularz _(pozwala to nie tylko na ich edycję, ale również na dodawanie własnych informacji, jak np. adres IP)_

  > W funkcji dostępne jest ID formularza, lista pól wraz z konfiguracją oraz lista wartości. Filtr można uruchomić dla wybranego formularza _(podając jego ID w nazwie hooka)_ lub dla wszystkich.

  ```
  add_filter('wpf_forms_values_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_values', 'example_callback', 10, 3);

  function example_callback($formID, $fields, $values) {

    // $values array modifications
    return $values;

  }
  ```

* filtr `wpf_forms_validation` umożliwia dodatkową walidację przesyłanych wartości _(pozwala to na tworzenie zaawansowanych typów walidacji takich, jak np. weryfikacja unikalności podanego adresu e-mail - hook uruchamiany jest po przejściu standardowej walidacji)_
    
  > W funkcji dostępne jest ID formularza, lista pól wraz z konfiguracją oraz lista wartości. Filtr można uruchomić dla wybranego formularza _(podając jego ID w nazwie hooka)_ lub dla wszystkich.

  ```
  add_filter('wpf_forms_validation_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_validation', 'example_callback', 10, 3);

  function example_callback($formID, $fields, $values) {

    // $values array validation
    return true/false/string;

  }
  ```

  Dostępne opcje zwracanych wartości:
  * `true` _(pomyślna walidacja)_
  * `false` _(nieudana walidacja, ogólny komunikat o błędzie)_
  * `string` _(nieudana walidacja, spersonalizowany komunikat o błędzie)_

* filtr `wpf_forms_send` umożliwia integrację formularza z zewnętrznymi systemami oraz przetwarzanie ich w inny niż wysyłanie wiadomości e-mail

  > W funkcji dostępne jest ID formularza, lista pól wraz z konfiguracją oraz lista wartości. Filtr można uruchomić dla wybranego formularza _(podając jego ID w nazwie hooka)_ lub dla wszystkich.

  ```
  add_filter('wpf_forms_send_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_send', 'example_callback', 10, 3);

  function example_callback($formID, $fields, $values) {

    // integration codes
    return true/false/string;

  }
  ```

  Dostępne opcje zwracanych wartości:
  * `true` _(pomyślne wysłanie)_
  * `false` _(nieudana próba wysłania, ogólny komunikat o błędzie)_
  * `string` _(nieudana próba wysłania, spersonalizowany komunikat o błędzie)_

* filtr `wpf_forms_email` umożliwia modyfikację danych używanych do wysyłania wiadomości e-mail _(pozwala to np. na dodanie dodatkowych informacji do treści e-maila, jak adres IP czy modyfikacja adresata wiadomości w zależności od wybranych opcji)_

  > W funkcji dostępne jest ID formularza, lista pól wraz z konfiguracją oraz dane do wysyłania e-maili _(adresat, nadawca, temat, dodatkowe nagłówki, treść wiadomości, załączniki)_. Filtr można uruchomić dla wybranego formularza _(podając jego ID w nazwie hooka)_ lub dla wszystkich.

  ```
  add_filter('wpf_forms_email_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_email', 'example_callback', 10, 3);

  function example_callback($formID, $fields, $data) {

    // data array modifications
    return data;

  }
  ```

&nbsp;

#### Dane formularza:

Vue.js w zmiennej `$data` przechowuje informacje dotyczące danego formularza:

| Klucz główny | Klucz podrzędny | Informacje |
|:--|:--|:--|
| form     | -                 | _(lista pól formularza wraz z zawartością)_ |
| response | -                 | - |
| -        | submit_error      | zawartość komunikatu o błędzie |
| -        | submit_success    | zawartość komunikatu o pomyślnym wysłaniu formularza |
| status   | -                 | _(zbiór wartości **boolean**)_ |
| -        | errors            | istnieje błąd formularza _(dotyczy błędu walidacji oraz błędu pochodzącego z back-endu)_ |
| -        | errors_validation | istnieje błąd walidacji |
| -        | errors_response   | istnieje błąd pochodzący z back-endu |
| -        | sending           | wysyłanie formularza w trakcie |
| -        | sent              | formularz pomyślnie wysłany |

&nbsp;

#### Eventy w JS:

W celu lepszej komunikacji z formularzem przygotowane są eventy pozwalające wywołać wybrane akcji przy danych zdarzeniach:

* event `wpfFormSendBefore` wywoływany jest przed wysłaniem formularza _(umożliwia np. uruchomienie animacji ładowania na przycisku submit)_

  > W funkcji dostępna jest zmienna `e.detail.form` zawierająca formularz jako element DOM.

  ```
  window.addEventListener('wpfFormSendBefore', (e) => {
    // ...
  })
  ```

  Istnieje możliwość zablokowania akcji wysyłania poprzez dodanie kodu `e.preventDefault();`

* event `wpfFormSendAfter` wywoływany jest przed wysłaniem formularza _(umożliwia np. zatrzymanie animacji ładowania na przycisku submit lub ukrycie formularza po poprawnym jego wysłaniu)_

  > W funkcji dostępna jest zmienna `e.detail.form` zawierająca formularz jako element DOM oraz `e.detail.success` ze statusem _(boolean)_.

  ```
  window.addEventListener('wpfFormSendAfter', (e) => {
    // ...
  })
  ```

&nbsp;

#### Obsługa pól dla plików:

Narzędzie wspiera pola typu `file` - również z opcją wyboru wielu plików. Pliki przechowywane są w formie tablicy, więc istnieje możliwość dodania nowych bez usuwania starych oraz usuwanie wybranych z nich. Aby spersonalizować wygląd pola najlepszym rozwiązaniem jest stworzenie kontenera, w którym znajdzie się pole typu file, a następnie ustawić następujące style dla pola:

```
.wrapper {
  position: relative;
  
  input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
  }
}
```

Dzięki temu otrzymamy dropzone w bardzo prosty sposób. Po przesunięciu pliku na ten obszar lub jego kliknięciu i wybraniu z dysku, dany plik zostanie załączony do formularza. Aby móc wykryć tą akcję należy wykorzystać następujący event:

```
window.addEventListener('wpfFormUploadFiles', (e) => {
  // ...
})
```

W funkcji dostępne są zmienne:
* `e.detail.form_id` _(ID formularza)_
* `e.detail.handle` _(uchwyt instancji Vue.js)_
* `e.detail.input` _(pole input jako element DOM)_
* `e.detail.list` _(lista plików)_

Po podpięciu akcji do odpowiednich przycisków można wywołać funkcję usuwającą wybrane pliki:

```
${handle}.$emit('removeFile', ${inputName}, ${index})
```

Lista argumentów:

| Klucz&nbsp;zmiennej | Opis |
|:--|:--|
| ${handle}    | instancja Vue.js _(uchwyt do niej jest zwracany przez event `wpfFormUploadFiles`)_ |
| ${inputName} | artybut `name` danego pola typu file |
| ${index}     | indeks pliku do usunięcia _(licząc od 0)_ |

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Czyszczenie strony

#### Wywołanie:

```
$framework->tools->action('cleaner');
```

#### Informacje:

* narzędzie tworzy widget zawierający przyciski umożliwiające zarządzanie rewizjami oraz automatycznymi szkicami, dając informację o ich ilości oraz możliwość usunięcia ich w dowolnym momencie
* automatyczne usuwane są wszystkie rewizje starsze niż 7 dni _(operacja uruchamiana jest raz dziennie)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Statystyki odwiedzin

#### Wywołanie:

```
$framework->tools->action('stats', ${args});
```

#### Przykład użycia:

```
$framework->tools->action('stats', [
  'limit_daily'   => 8,
  'limit_monthly' => 12,
  'limit_yearly'  => 10
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| limit_daily   | integer | limit ostatnich dni do wyświetlania |
| limit_monthly | integer | limit ostatnich miesięcy do wyświetlania |
| limit_yearly  | integer | limit ostatnich lat do wyświetlania |

#### Informacje:

* system zlicza unikalne wejścia na stronę na podstawie zapisywanych w przeglądarkach użytkownika `cookies` oraz każdorazowe wejścia na stronę
* statystyki są liczone również wtedy, kiedy widget nie jest skonfigurowany
* do zapisywania statystyk system tworzy własną tabelę w bazie danych o nazwie `..._wpf_stats`
* dodatkowo dla każdego pojedynczego postu i strony zapisywana jest wartość postmeta o kluczu `views_count` zawierająca ilość odsłon

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Walidator kategorii

#### Wywołanie:

```
$framework->tools->action('validate-categories', ${args});
```

#### Przykład użycia:

```
$framework->tools->action('validate-categories', [
  [
    'slug'        => 'category',
    'post_types'  => ['post'],
    'min_checked' => 1,
    'max_checked' => 1
  ]
]);
```

#### Lista argumentów:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| slug        | string  | slug taksonomii |
| post_types  | string  | slugi typów postów |
| min_checked | integer | minimalna ilość wybranych kategorii _(ustaw `-1`, aby wyłączyć)_ |
| max_checked | integer | maksymalna ilość wybranych kategorii _(ustaw `-1`, aby wyłączyć)_ |

#### Informacje:

* jako argumenty przekazujemy tablicę z listą taksonomii
* każda tablica danej taksomonii musi zawierać dane wymienione w tabeli powyżej
* jako slug możemy podawać domyślne `category` oraz wszystkie własne taksonomie hierarchiczne _(tagi nie są obsługiwane)_
* walidator w razie wystąpienia błędu wyświetla specjalny pasek z alertem, uniemożliwiając zapisanie niepoprawnego postu

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Udostępnianie w social media

#### Zarządzanie:

```
Panel administracyjny -> WP Framework -> Social media share
```

#### Opis działania:

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji tytułu, opisu oraz obrazka widocznego przy udostępnianiu strony na portalach społecznościowych.

Poziomy ustawień:
* każdy post, strona oraz post z własnych Post Types lub kategoria postu oraz kategoria z własnych Taxonomies
* konfiguracja zdefiniowana dla danego Post Type lub Taxonomy
* konfiguracja domyślna

System szuka informacji możliwie najbardziej szczegółowych - kiedy ich nie ma to dodaje brakujące informacje z niższych poziomów. Wyjątkiem jest `tytuł` i `description`, które nie może być dziedziczony z niższego poziomu. Wynika to z tego, że każda podstrona ma swój własny i unikalny tytuł oraz opisu.

Podawanie informacji jest opcjonalne. Warto jednak uzupełnić przynajmniej ustawienia globalne dla całej strony w postaci obrazka.

Lista generowanych tagów w sekcji head:
* og:title
* description
* og:description
* og:image
* og:image:width
* og:image:height

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Integracje

#### Zarządzanie:

```
Panel administracyjny -> WP Framework -> Integrations
```

#### Opis działania:

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji każdego z dostępnych systemów.

Narzędzie umożliwia integrację z następującymi systemami:
* Google Analytics
* Google Tag Manager
* Facebook Pixel
* Hotjar
* LiveChat
* Facebook Customer Chat

Integracja polega na umieszczeniu w odpowiednim miejscu kodów instalacyjnych.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Generowanie sitemap

#### Zarządzanie:

```
Panel administracyjny -> WP Framework -> Sitemap
```

#### Opis działania:

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do wyboru typów postów i taksonomii, które mają się znajdować w mapie witryny.

Główna mapa znajduje się pod adresem: `/sitemap.xml`. Znajdują się w niej linki do mniejszych map, gdzie są wyświetlane elementy z danego typu postu lub taksonomii. Zawartość map nie jest zapisywana, przez co narzędzie nie spowalnia działania serwisu oraz zawsze mamy dostęp do aktualnej wersji. Podział mapy na mniejsze elementy przyspiesza ich generowanie oraz pozwoli łatwiej dotrzeć do interesującej nas treści.

Nie musisz ręcznie zgłaszać mapy do Google, ponieważ system zrobi to automatycznie po zmianie konfiguracji Sitemap.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Konfiguracja wysyłki e-maili

#### Zarządzanie:

```
Panel administracyjny -> WP Framework -> PHPMailer
```

#### Opis działania:

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji danych w PHPMailer.

Domyślnie wysyłka wiadomości e-mail jest zablokowana na hostingu - konfigurując własną skrzynkę wysyłającą jesteśmy w stanie rozwiązać ten problem. Poza samym podaniem potrzebnych danych można również sprawdzić ich poprawność za pomocą testera. Wpisując adres e-mail system wyśle testową wiadomość, wyświetlając przy tym log wykonywanych operacji.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Pobieranie breadcrumbs

#### Wywołanie:

```
$items = apply_filters('wpf_helper_breadcrumbs', null);
```

#### Zasada działania:

* funkcja wyświetla breadcrumbsy w formie tablicy
* w każdym elemencie zamieszczony jest adres URL oraz tytuł strony
* pobierana jest zawsze pełna ścieżka do postu lub taksomonii, zawierająca wszystkie kategorie rodziców
* narzędzie jest kompatybilne z pluginem Yoast SEO _(funkcjonalność `primary category`)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)

`[!]` Rejestrując taksomonię pamiętaj, żeby slug ustawić wg wzoru `{posttype}-category`, aby narzędzie mogło pobrać ścieżkę taksomonii prowadzącą do danego postu.

`[?]` Dla strony wyszukiwarki narzędzie automatycznie jako tytuł strony na liście wyświetla `Search Results` - można to przetłumaczyć na inny język używając pluginu Loco Translate lub zmodyfikować tytuł edytując ostatnią pozycję w pobranej liście na stronie `search.php`.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Wyświetlanie favicons

#### Wywołanie:

```
echo apply_filters('wpf_helper_favicons', ${arg});
```

#### Lista argumentów:

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | ścieżka do folderu z plikami favicon _(przykład: `/assets/img/favicons/`)_ |

#### Zasada działania:

* funkcja wyświetla listę tagów HTML odpowiedzialnych za favicons
* lista pobieranych plików jest kompatybilna z generatorem [favicon-generator.org](https://www.favicon-generator.org/)
* dodatkowo narzędzie pobiera wykorzystywaną ścieżkę i dodaje do pliku .htaccess przekierowanie na odpowiedni plik z adresu `/favicon.ico`, dzięki czemu po wejściu np. do panelu administracyjnego będziemy mieli odpowiednią ikonę na karcie

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Pobieranie z Instagrama

#### Wywołanie:

```
echo apply_filters('wpf_helper_instagram', {arg1}, {arg2});
```

#### Lista argumentów:

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg1 | string | token do autoryzacji _(pobrany np. ze strony: [instagram.pixelunion.net](http://instagram.pixelunion.net/))_ |
| arg2 | string | limit zdjęć do pobranych |

#### Zasada działania:

* funkcja pobierana żądaną ilość ostatnich zdjęć z konta Instagram
* tablica z wynikami zawiera komplet informacji o każdym ze zdjęć
* zalecane jest cache'owanie pobranych wyników w celu optymalizacji czasu ładowania strony

#### Dostępne filtry:

Filtr `wpf_helpers_instagram_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym zdjęciu. W funkcji dostępna pod zmienną **$image** jest również oryginalna tablica zwracana przez API Instagrama.

```
add_filter('wpf_helpers_instagram_item', 'example_callback', 10, 2);

function example_callback($data, $image) {

  // $data array modifications
  return $data;

}
```

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Pobieranie listy języków

#### Wywołanie:

```
$items = apply_filters('wpf_helper_langs', ${arg});
```

#### Lista argumentów:

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | kolumna, wg której ma być posortowana tablica z językami _(do wyboru `slug` lub `title`)_ |

#### Zasada działania:

* funkcja pobiera listę dostępnych języków w formie tablicy
* tablica dostępna pod kluczem `current` zawiera aktualny język
* w elemencie z kluczem `others` znajduje się lista pozostałych języków, posortowana alfabetycznie

#### Dostępne filtry:

Filtr `wpf_helpers_langs_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym języku. W funkcji dostępna pod zmienną **$lang** jest również oryginalna tablica zwracana przez plugin Polylang.

```
add_filter('wpf_helpers_langs_item', 'example_callback', 10, 2);

function example_callback($data, $lang) {

  // $data array modifications
  return $data;

}
```

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Pobieranie menu

#### Wywołanie:

```
$items = apply_filters('wpf_helper_menu', ${arg});
```

#### Lista argumentów:

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | `theme_location` wybranego menu |

#### Zasada działania:

* funkcja pobiera menu w formie tablicy
* tablice są w sobie zagnieżdżone tworząc schemat drzewa _(zgodnie z tym, jak jest to ułożone w panelu administracyjnym)_
* w każdym elemencie istnieje wartość o kluczu `active`, który informuje czy dany element menu jest aktywny _(zaznacza również wszystkich rodziców)_
* przekazywany obiekt, dostępny pod kluczem `object`, umożliwia pobieranie wartości z ACF _(podajemy go jako drugi argument w funkcji `get_field`)_

#### Dostępne filtry:

Filtr `wpf_helpers_menu_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym elemencie menu. W funkcji dostępny pod zmienną **$item** jest również oryginalny obiekt menu generowany przez WordPressa.

```
add_filter('wpf_helpers_menu_item', 'example_callback', 10, 2);

function example_callback($data, $item) {

  // $data array modifications
  return $data;

}
```

Filtr `wpf_helpers_menu` umożliwia modyfikację danych zawartych w tablicy `$items`, w której znajdują się wszystkie elementy menu.

```
add_filter('wpf_helpers_menu', 'example_callback', 10, 1);

function example_callback($items) {

  // $items array modifications
  return $items;

}
```

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Pobieranie listy kategorii

#### Wywołanie:

```
$items = apply_filters('wpf_helper_terms', {arg1}, {arg2});
```

#### Lista argumentów:

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg1 | string | slug wybranej taksonomii |
| arg2 | string | slug pola z pluginu ACF wg którego mają być posortowane kategorie _(np. priorytet)_ |

#### Zasada działania:

* funkcja wyświetla kategorie z danej taksonomii w formie tablicy
* tablice są w sobie zagnieżdżone tworząc schemat drzewa _(zgodnie z tym, jak jest to ułożone w panelu administracyjnym)_
* w każdym elemencie istnieje wartość o kluczu `active`, który informuje czy obecnie znajdujemy się na stronie danej kategorii _(zaznacza również wszystkich rodziców)_
* lista pobranych kategorii może być opcjonalnie posortowana wg wartości z pola ACF, a w drugiej kolejności alfabetycznie

#### Dostępne filtry:

Filtr `wpf_helpers_terms_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczej kategorii.

```
add_filter('wpf_helpers_terms_item', 'example_callback', 10, 1);

function example_callback($data) {

  // $data array modifications
  return $data;

}
```

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Dodatkowe hooki

#### Przekształcanie tekstu przy zapytaniach Ajax:

Korzystając z zapytań Ajax, WordPress automatycznie konwertuje znaki występujące w polach title, content, excerpt oraz wszystkich innych z edytorem TinyMCE przy użyciu funkcji [wptexturize](https://codex.wordpress.org/Function_Reference/wptexturize). Aby wyłączyć to dla wybranej akcji WP Ajax należy dodać następujący kod:

```
add_filter('wpf_ajax_noparse_{action}', '__return_true');
```

`{action}` należy zastąpić wartością `action` przesyłaną metodą GET lub POST.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Wsparcie SEO:

* przekierowanie na prawidłowy adres hosta _(zawierający https lub http oraz z prefixem www. lub bez - zapobiega to duplikowaniu adresów strony)_
* przekierowanie z `index.php` oraz `index.html` na adres zakończony `/`
* dodawanie symbolu `/` na końcu adresu URL _(z wyjątkiem adresów ze zmienną $_GET)_
* automatyczne przekierowanie ze strony załącznika na stronę postu
* blokada indeksacji stron wyników wyszukiwania dla robotów
* ustawieniu odpowiednich nagłówków HTTP dla plików w pliku `.htaccess` _(działa również na home.pl, wyłączone dla serwera localhost)_
* przeniesienie ładowania pliku CSS dla Contact Form 7 z sekcji head na dół strony
* wklejenie zawartości lokalnych plików CSS bezpośrednio w sekcji head _(opcjonalnie; zastępuje ładowanie plików CSS opóźniających renderowanie strony)_

`!` Dzięki powyższym funkcjonalnością oraz włączaniu korzystania z pamięci cache _(zakładając, że nie korzystamy z zewnętrznych plików JS, które nie są ładowane asynchronicznie)_, jesteśmy w stanie `osiągnąć wynik 100/100` w Google PageSpeed Insights.

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

# Użyteczności ogólne:

* dodawanie zmiennej `wpF.ajaxurl` w JS z adresem URL dla [WP AJAX](https://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action))
* blokada domyślnego przekierowania na port 80, umożliwiająca działanie BrowserSync _(jeżeli zmienna `WP_DEBUG` w pliku wp-config.php ustawiona jest na true)_
* usuwanie parametru `doing_wp_cron` z adresu URL przy włączonym alternatywnym cronie
* automatyczne przekierowanie na protokół HTTPS, jeżeli w adresie strony jest on wykorzystywany
* automatyczne wyświetlanie tagu `<title>` w sekcji head
* wyświetlenie błędu 404 w sytuacji, gdy plik nie istnieje na serwerze
* przesunięcie `admin bar` na dolną krawędź okna oraz możliwość rozwijania/ukrywania jego zawartości _(domyślnie widoczna jest tylko ikona WP umożliwiająca rozwinięcie paska)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Użyteczności w panelu administracyjnym:

* blokada modyfikacji drzewa kategorii po wybieraniu elementów podczas edycji postów _(dzięki temu zawsze zachowujemy formę drzewa kategorii)_
* wyłączenie obsługi komentarzy dla stron
* automatyczne przekierowanie na domyślny język w sytuacji braku aktywnego języka _(dotyczy pluginu `Polylang`; zablokowane na stronach z listą postów)_
* pływający boks umożliwiający zapis postu bez przewijania na początek strony _(wraz z automatycznym przescrollowaniem do poprzedniej pozycji po zapisaniu postu)_

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Użyteczności dla tłumaczenia:

* ustawianie katalogu `/langs` dla plików językowych _(utworzenie go, jeśli nie istnieje)_
* ustawienie slugu `lang` dla wszystkich funkcji językowych i18n

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Użyteczności dla ACF:

* dodanie do wyników pobieranych przez Ajax w polu typu `Link` adresów URL archiwów typów postów oraz kategorii
* automatyczne zwijanie wewnętrznych pól w polach Flexible Content
* uruchomienie `Local JSON` i zapisywanie grup z polami w katalogu `acf-json`, w celu przyspieszenia działania strony oraz możliwości wersjonowania listy pól w repozytorium
* wsparcie `Location rule` dla strony głównej _(**Page Type** is equal to **Front Page**)_ tłumaczonej przy użyciu pluginu Polylang

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

# Użyteczności dla Yoast SEO:

* zmiana priorytetu widgetu Yoast SEO na `low`, aby zawsze znajdował się na dole strony edycji
* usunięcie kolumn z informacjami Yoast SEO na liście postów
* ukrycie rozwijanych list do filtrowania postów na podstawie informacji Yoast SEO
* usunięcie ról użytkowników generowanych przez plugin
* usunięcie z mapy witryny załączników

[▲ Spis treści](#spis-tre%C5%9Bci)

&nbsp;

&nbsp;

> © 2018 Mateusz Gbiorczyk. `All rights reserved.`