KISSfiles
==============
Fileuploader do udostępniania dużych plików na zewnątrz.

## Reason ##
Realizuję projekt gdyż:
* cel edukacyjny - zapoznać się lepiej z Laravel, PHP7
* cel marketingowy - korzystając z własnego narzędzia zamiast z sendspace i innych pokazujemy klientom naszą markę
* cel inny - zrobić z tego potem projekt opensource

## Requirements ##
1. Projekt używa https://github.com/23/resumable.js do uploadowania dużych plików w kawałkach

## How to install ##

Konfiguracja google API:

1. W konsoli google utwórz `Oauth2 client ID` w `Create credentials` i ustaw odpowiedni adres dla callback
2. W konsoli google włącz Google+ API i Google People API?

## Scripts / helpers

* ```php artisan ide-helper:generate``` (tworzy podpowiedzi klas i metod dla edytora)
* ```php artisan ide-helper:models``` (tworzy podpowiedzi pól modeli)

## Running tests ##
No tests

## Files structure ##
No non-common file structure

## Most vital files ##
## Links ##
No links

## API ##

## Test data ##
No test data

## Tips and tricks ##

1. Jeżeli uruchamiasz serwis lokalnie to aby działało uwierzytelnianie z google, postaw go pod nie-lokalną domeną, a w swoim /etc/hosts podaje tylko lokalne IP. Rzecz w tym, że po uwierzytelnieniu google przekierowuje użytkownika na wskazany adres - ale nie może on być lokalny.

## Contributors ##
Adam Kubiczek