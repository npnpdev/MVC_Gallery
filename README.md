# PHP MVC Gallery

> Galeria zdjęć napisana w PHP w architekturze MVC. Zdjęcia przechowywane są w bazie danych mongoDB.

---

## Spis treści

* [Opis projektu](#opis-projektu)
* [Funkcjonalności](#funkcjonalno%C5%9Bci)
* [Architektura MVC](#architektura-mvc)
* [Struktura katalogów](#struktura-katalog%C3%B3w)
* [Wymagania](#wymagania)
* [Instalacja i uruchomienie](#instalacja-i-uruchomienie)
* [Konfiguracja](#konfiguracja)
* [Kontakt](#kontakt)
* [Licencja](#licencja)

---

## Opis projektu

PHP MVC Gallery to prosta aplikacja webowa pozwalająca użytkownikom na rejestrację, logowanie oraz zarządzanie kolekcją zdjęć. Użytkownicy mogą przesyłać zdjęcia, przeglądać galerię, wyszukiwać obrazy oraz zapisywać ulubione.

---

## Funkcjonalności

* Rejestracja i logowanie użytkowników
* Przesyłanie zdjęć (upload) wraz z podglądem
* Przeglądanie galerii wszystkich obrazów
* Wyszukiwanie po nazwie lub tagach
* Zapis ulubionych zdjęć
* Widok pojedynczego obrazu

---

## Architektura MVC

* **Model** (`src/business.php`): logika biznesowa, operacje na danych (upload, pobieranie, zapisywanie).
* **Widoki (View)** (`src/views/*.php`): szablony HTML/PHP generujące strony (np. `gallery_view.php`, `image_view.php`, `login_view.php`).
* **Kontrolery (Controller)** (`src/controllers.php`): obsługa żądań, wywoływanie odpowiednich modeli i widoków.
* **Front Controller** (`web/front_controller.php`): centralny punkt wejścia, ładuje autoloader, routing i dispatchera.

---

## Struktura katalogów

```
MVC_Gallery/
├── src/
│   ├── business.php         # logika aplikacji (Model)
│   ├── controller_utils.php # pomocnicze funkcje dla kontrolerów
│   ├── controllers.php      # definicje akcji MVC (Controller)
│   ├── dispatcher.php       # wywoływanie właściwej akcji na podstawie trasy
│   ├── routing.php          # mapowanie URL → kontroler/akcja
│   └── views/               # widoki (View)
│       ├── includes/        # wspólne fragmenty (nagłówek, stopka)
│       ├── partial/         # małe komponenty (np. powiadomienia)
│       ├── gallery_view.php
│       ├── image_view.php
│       ├── login_view.php
│       ├── register_view.php
│       ├── saved_view.php
│       ├── search_view.php
│       └── upload_view.php
├── vendor/                  # biblioteki zainstalowane przez Composer
├── composer.json            # definicja zależności Composer
├── composer.lock            # zablokowane wersje pakietów
└── web/                     # dokument root
    ├── static/              # zasoby statyczne (CSS, JS, obrazki)
    ├── .htaccess            # przekierowanie wszystkich żądań do front_controller.php
    └── front_controller.php # punkt wejścia aplikacji
```

---

## Wymagania

* PHP 7.4+ z rozszerzeniem PDO
* Serwer WWW (Apache/Nginx)
* Composer do instalacji zależności
* Ustawiony `DocumentRoot` na katalog `web/`

---

## Konfiguracja

* Plik `web/.htaccess` przekierowuje wszystkie adresy do `front_controller.php`.
* Trasy definiowane w `src/routing.php`.
* Dane połączenia z bazą (jeśli dotyczy) możesz skonfigurować w `src/business.php` lub dołączyć plik `.env`.

---

## Kontakt

* **Autor**: Igor Tomkowicz
* GitHub: [npnpdev](https://github.com/npnpdev)
* E-mail: [npnpdev@gmail.com](mailto:npnpdev@gmail.com)

---

## Licencja

Projekt udostępniony na licencji **MIT**.
