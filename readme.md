KISS-files
==============
The script for sharing files.
This tool is intended for companies who wants share their files between employees, customers, partners etc.

Most important features:

1. To share a file an user must be authenticated.
2. Anyone with a link can download a file.
3. No file size limits even on 32 bit systems.

## Requirements ##

1. PHP7 or newer
2. Apache server with mod_xsendfile installed.
3. A database engine (tested with MySQL)

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

Konfiguracja modułu mod_xsendfile
Do konfiguracji vhosta należy dopisać dyrektywy (podać odpowiednią ściężkę do folderu z plikami):

```
   XSendFile On
   XSendFilePath /Users/kubik/Work/web-kissfiles/storage/app/uploads/
  ```

## Scripts / helpers

* ```php artisan ide-helper:generate``` (tworzy podpowiedzi klas i metod dla edytora)
* ```php artisan ide-helper:models``` (tworzy podpowiedzi pól modeli)

## Running tests ##

1. `phpunit` starts tests in `./tests`

## Files structure ##
No non-common file structure

## Most vital files ##

## Extra libraries used ##
1. https://github.com/23/resumable.js for uploading files

## Links ##
No links

## API ##

## Test data ##
No test data

## Tips and tricks ##

1. Jeżeli uruchamiasz serwis lokalnie to aby działało uwierzytelnianie z google, postaw go pod nie-lokalną domeną, a w swoim /etc/hosts podaje tylko lokalne IP. Rzecz w tym, że po uwierzytelnieniu google przekierowuje użytkownika na wskazany adres - ale nie może on być lokalny.
2. Na 'producio' korzystam z tego tak, że pliki zapisują się na dysku sieciowym (NFS). Montowanie: `sudo mount 192.168.1.5:/volume1/Files /var/www/files.kissdigital.com/web/storage/app`
3. Podłączenie dysku w trakcie uruchamiania serwera - w pliku /etc/fstab dodaj coś jak to:
`192.168.1.5:/volume1/Files /var/www/files.kissdigital.com/web/storage/app nfs rw,hard,intr,rsize=8192,wsize=8192,timeo=14 0 0`

## License ##
MIT