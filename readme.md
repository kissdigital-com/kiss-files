KISSfiles
==============
Fileuploader do udostępniania dużych plików na zewnątrz.

## Reason ##
Realizuję projekt gdyż:
* cel edukacyjny - zapoznać się lepiej z Laravel, PHP7
* cel marketingowy - korzystając z własnego narzędzia zamiast z sendspace i innych pokazujemy klientom naszą markę
* cel inny - zrobić z tego potem projekt opensource

## Requirements ##

1. PHP7

## How to install ##

1. `composer install`
2. `cp .env.example .env`
3. `vi .env` i podać dane dostępowe do bazy
4. `php artisan migrate` - tworzy tabele w bazie
5. `php artisan key:generate` - wygenerowanie klucza do szyfrowania
6. `chmod -R g+w storage` - innymi słowy dać apachowi prawo do zapisu do katalogu storage i tego co jest w nim

Konfiguracja google API:

1. W konsoli google utwórz `Oauth2 client ID` w `Create credentials` i ustaw odpowiedni adres dla callback
2. W konsoli google włącz Google+ API i Google People API?

W pliku `config/services.php` ustaw client id i secret:

    'google' => [
        'client_id' => 'SOMESOMESOME.apps.googleusercontent.com',
        'client_secret' => 'SOMESECRET',
        'redirect' => 'http://files.kissdigital.com/login/google/callback',
    ],

## Scripts / helpers

* ```php artisan ide-helper:generate``` (tworzy podpowiedzi klas i metod dla edytora)
* ```php artisan ide-helper:models``` (tworzy podpowiedzi pól modeli)

## Running tests ##

1. `phpunit` starts tests in `./tests`

## Files structure ##
No non-common file structure

## Most vital files ##

## Libraries used ##
1. Projekt używa https://github.com/23/resumable.js do uploadowania dużych plików w kawałkach

## Links ##
No links

## API ##

## Test data ##
No test data

## Tips and tricks ##

1. Jeżeli uruchamiasz serwis lokalnie to aby działało uwierzytelnianie z google, postaw go pod nie-lokalną domeną, a w swoim /etc/hosts podaje tylko lokalne IP. Rzecz w tym, że po uwierzytelnieniu google przekierowuje użytkownika na wskazany adres - ale nie może on być lokalny.
2. Na 'producio' korzystam z tego tak, że pliki zapisują się na dysku sieciowym (NFS). Montowanie: `sudo mount 192.168.1.5:/volume1/Files /var/www/files.kissdigital.com/web/storage/app` 

## Contributors ##
Adam Kubiczek