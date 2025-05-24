# PHP MVC Gallery

[English](#english-version) | [Polski](#wersja-polska)

---

## English Version

### Project Description

**PHP MVC Gallery** is a simple web application built with PHP following the MVC pattern and using MongoDB to store photos. Users can register, log in, upload images, browse the gallery, search by name or tags, and save favorites.

### Features

* **User Management**: registration and login
* **Image Upload**: file upload with preview
* **Gallery Browsing**: view all stored images
* **Search**: filter by name or tags
* **Favorites**: save and view favorite photos
* **Detail View**: inspect a single image with metadata

### MVC Architecture

* **Model** (`src/business.php`): business logic and data operations (upload, retrieval, favorites)
* **View** (`src/views/*.php`): HTML/PHP templates (e.g., `gallery_view.php`, `image_view.php`, `login_view.php`)
* **Controller** (`src/controllers.php`): request handling, invoking models and rendering views
* **Front Controller** (`web/front_controller.php`): entry point, autoloader, routing and dispatch logic

### Directory Structure

```text
MVC_Gallery/
├── src/
│   ├── business.php         # application logic (Model)
│   ├── controller_utils.php # helper functions for controllers
│   ├── controllers.php      # action definitions (Controller)
│   ├── dispatcher.php       # executes correct action based on route
│   ├── routing.php          # URL → controller/action mapping
│   └── views/               # templates (View)
│       ├── includes/        # shared partials (header, footer)
│       ├── partial/         # small components (e.g., notifications)
│       ├── gallery_view.php
│       ├── image_view.php
│       ├── login_view.php
│       ├── register_view.php
│       ├── saved_view.php
│       ├── search_view.php
│       └── upload_view.php
├── vendor/                  # Composer dependencies
├── composer.json            # dependency definitions
├── composer.lock            # locked package versions
└── web/                     # document root
    ├── static/              # CSS, JS, images
    ├── .htaccess            # rewrites all requests to front_controller.php
    └── front_controller.php # application entry point
```

### Requirements

* **PHP** 7.4+ with MongoDB extension
* **Web Server**: Apache or Nginx
* **Composer** for dependency management
* Document root set to the `web/` directory

### Configuration

* The file `web/.htaccess` routes requests to `front_controller.php`.
* Define routes in `src/routing.php`.
* Configure database connection parameters in `src/business.php` or via a `.env` file.

---

## Wersja polska

### Opis projektu

**PHP MVC Gallery** to prosta aplikacja webowa w PHP w architekturze MVC, przechowująca zdjęcia w bazie MongoDB. Użytkownicy mogą się rejestrować, logować, przesyłać zdjęcia, przeglądać galerię, wyszukiwać i zapisywać ulubione.

### Funkcjonalności

* **Zarządzanie użytkownikami**: rejestracja i logowanie
* **Przesyłanie zdjęć**: upload plików z podglądem
* **Przeglądanie galerii**: oglądanie wszystkich zdjęć
* **Wyszukiwanie**: filtrowanie po nazwie lub tagach
* **Ulubione**: zapis i przegląd ulubionych zdjęć
* **Widok szczegółowy**: podgląd pojedynczego obrazu z metadanymi

### Architektura MVC

* **Model** (`src/business.php`): logika biznesowa i operacje na danych (upload, pobieranie, ulubione)
* **Widoki (View)** (`src/views/*.php`): szablony HTML/PHP (np. `gallery_view.php`, `image_view.php`, `login_view.php`)
* **Kontrolery (Controller)** (`src/controllers.php`): obsługa żądań, wywoływanie modeli i renderowanie widoków
* **Front Controller** (`web/front_controller.php`): punkt wejścia, autoloader, routing i dispatcher

### Struktura katalogów

```text
MVC_Gallery/
├── src/
│   ├── business.php
│   ├── controller_utils.php
│   ├── controllers.php
│   ├── dispatcher.php
│   ├── routing.php
│   └── views/
│       ├── includes/
│       ├── partial/
│       ├── gallery_view.php
│       ├── image_view.php
│       ├── login_view.php
│       ├── register_view.php
│       ├── saved_view.php
│       ├── search_view.php
│       └── upload_view.php
├── vendor/
├── composer.json
├── composer.lock
└── web/
    ├── static/
    ├── .htaccess
    └── front_controller.php
```

### Wymagania

* **PHP** 7.4+ z rozszerzeniem MongoDB
* **Serwer WWW**: Apache lub Nginx
* **Composer** do zarządzania zależnościami
* Document root ustawiony na katalog `web/`

### Konfiguracja

* Plik `web/.htaccess` przekierowuje wszystkie żądania do `front_controller.php`.
* Trasy definiowane w `src/routing.php`.
* Parametry połączenia z bazą konfiguruje się w `src/business.php` lub w `.env`.

---

## Kontakt / Contact

* **Igor Tomkowicz**
* GitHub: [npnpdev](https://github.com/npnpdev)
* LinkedIn: [Igor Tomkowicz](https://www.linkedin.com/in/igor-tomkowicz-a5760b358/)
* E-mail: [npnpdev@gmail.com](mailto:npnpdev@gmail.com)

---

## Licencja / License

Project available under the **MIT** license. See [LICENSE](LICENSE) for details.
