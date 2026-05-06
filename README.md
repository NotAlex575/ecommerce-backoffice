# Ecommercione - Backoffice WooCommerce

Applicazione web sviluppata in Laravel per la gestione degli ordini e dei clienti di un e-commerce basato su WooCommerce.

---

## Descrizione

Il progetto consente di:

- autenticare utenti autorizzati;
- gestire ruoli utente (operatore / amministratore);
- sincronizzare gli ordini WooCommerce in stato `processing`;
- salvare ordini, clienti e righe ordine in un database locale;
- visualizzare il dettaglio di ordini e clienti;
- gestire gli utenti (solo amministratore).

---

## Requisiti

Prima di avviare il progetto è necessario avere installato:

- PHP 8+
- Composer
- Node.js e npm
- MySQL o MariaDB
- WooCommerce con API attive

---

## Installazione

Clonare il progetto:

```bash
git clone https://github.com/NotAlex575/ecommerce-backoffice
cd nome-progetto

Installare le dipendenze PHP:

composer install

Installare le dipendenze frontend:

npm install

Creare il file .env:

cp .env.example .env

Configurare il file .env con il seguente:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:zT6FaH2AS88+yHYFD9hpARZyf06HCCEm5lGRYQRXZWw=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=laravel_gestionale
DB_USERNAME=root
DB_PASSWORD=
DB_COLLATION = utf8mb4_unicode_ci

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"


WC_CONSUMER_KEY=ck_3e02102b4e08f0d34d074d7b982477de9b7621c3
WC_CONSUMER_SECRET=cs_93e35c78ed252c732c89da30215e8e7a42aeba60
WC_BASE_URL=http://localhost/wordpress-ecommerce


Eseguire le migration:

php artisan migrate

Popolare il database con utenti di test:

php artisan db:seed

Utenti disponibili:

Admin:
email: admin@test.com
password: password

Operatore:
email: operatore@test.com
password: password
Avvio progetto

Avviare Laravel:

php artisan serve

Avviare il frontend:

npm run dev

Aprire nel browser:

http://127.0.0.1:8000


FUNZIONALITA DELL'ESERCIZIO IN BASE ALLA CHALLENGE:

Il progetto consiste nella realizzazione di una web application PHP sviluppata con Laravel per la gestione degli ordini WooCommerce e dell’anagrafica clienti.

L’applicazione comunica con WooCommerce tramite REST API e mantiene una copia locale dei dati all’interno del database Laravel.

---

# Gestione autenticazione e ruoli

L’accesso all’applicazione è consentito esclusivamente ad utenti autenticati.

Sono stati implementati due ruoli:

## Operatore

L’utente operatore può:

- accedere alla gestione ordini;
- accedere all’anagrafica clienti;
- visualizzare il dettaglio ordini;
- modificare lo stato degli ordini.

## Amministratore

L’utente amministratore può:

- accedere alla gestione utenti dell’applicazione;
- visualizzare l’elenco utenti;
- visualizzare il dettaglio utenti.

La separazione dei ruoli è gestita tramite middleware Laravel.

---

# Integrazione con WooCommerce

L’integrazione con WooCommerce è stata sviluppata tramite il service:

```text
app/Services/WooCommerceService.php
S
Il service gestisce:

autenticazione API WooCommerce;
recupero ordini;
recupero singolo ordine;
aggiornamento stato ordine.

Le richieste API vengono effettuate tramite REST API WooCommerce usando OAuth 1.0.

Download ordini WooCommerce

L’applicazione scarica gli ordini da WooCommerce tramite una rotta dedicata:

/sync-ordini

La sincronizzazione:

recupera gli ordini WooCommerce;
salva gli ordini nel database locale;
crea o aggiorna i clienti;
salva le righe ordine;
mantiene le relazioni tra cliente e ordini.

Per evitare duplicazioni è stato utilizzato:

updateOrCreate()
Gestione clienti

Durante la sincronizzazione:

se il cliente non esiste viene creato;
se il cliente esiste viene aggiornato.

Il cliente viene identificato tramite email.

Per ogni cliente vengono salvati:

nome;
cognome;
email;
indirizzo di fatturazione;
indirizzo di spedizione.
Relazione cliente - ordini

È stata implementata la relazione:

1 cliente → molti ordini

tramite chiave esterna:

ordini.cliente_id

In questo modo uno stesso cliente può avere più ordini associati.

Gestione ordini

La web application permette di visualizzare:

elenco ordini;
dettaglio ordine;
righe ordine;
dati cliente;
stato ordine;
totale ordine;
data ordine;
indirizzi di fatturazione e spedizione.

È stata inoltre implementata una sezione filtri per:

nome cliente;
stato ordine.
Gestione righe ordine

Per ogni ordine vengono salvati:

prodotto;
quantità;
prezzo.

Le righe ordine vengono memorizzate nella tabella:

righe_ordini

collegate all’ordine tramite:

ordine_id
Gestione stato ordine (Opzionale A)

È stata implementata anche la funzionalità opzionale di aggiornamento stato ordine.

L’utente operatore può modificare lo stato di un ordine scegliendo tra:

completed
cancelled
refunded

Quando lo stato viene aggiornato:

il database Laravel viene aggiornato;
viene inviata una richiesta API PUT a WooCommerce;
lo stato viene aggiornato anche lato WordPress/WooCommerce.

In questo modo il database locale e WooCommerce restano sincronizzati.

Framework MVC scelto

Per il progetto è stato utilizzato Laravel.

La struttura segue il pattern MVC:

Models

Gestiscono:

dati database;
relazioni Eloquent.
Controllers

Gestiscono:

logica applicativa;
sincronizzazione;
filtri;
aggiornamento stato ordini.
Views Blade

Gestiscono:

dashboard;
lista ordini;
dettaglio ordini;
gestione clienti;
gestione utenti.
Architettura generale

Il flusso principale dell’applicazione è:

WooCommerce API
        ↓
WooCommerceService
        ↓
WooCommerceOrderController
        ↓
Database Laravel
        ↓
OrdineController / ClienteController
        ↓
View Blade

WooCommerce rappresenta la sorgente dati esterna.

Laravel mantiene una copia locale sincronizzata e fornisce il backoffice gestionale.