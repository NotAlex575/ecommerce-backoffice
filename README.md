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
git clone <repository-url>
cd nome-progetto

Installare le dipendenze PHP:

composer install

Installare le dipendenze frontend:

npm install

Creare il file .env:

cp .env.example .env

Generare la chiave applicativa:

php artisan key:generate
Configurazione

Configurare il database nel file .env:

DB_DATABASE=nome_database
DB_USERNAME=root
DB_PASSWORD=

Configurare le API WooCommerce:

WC_CONSUMER_KEY=ck_xxxxxxxxx
WC_CONSUMER_SECRET=cs_xxxxxxxxx
WC_BASE_URL=http://localhost/wordpress
Database

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
Funzionalità
Autenticazione e ruoli
accesso riservato agli utenti autenticati;
operatore: gestione ordini e clienti;
amministratore: gestione utenti.
Ordini
sincronizzazione da WooCommerce;
lista ordini;
dettaglio ordine con:
cliente
prodotti
totale
stato
data
Clienti
lista clienti;
dettaglio cliente;
indirizzo di fatturazione e spedizione;
visualizzazione ordini collegati.
Utenti
visibili solo all’amministratore;
lista utenti;
dettaglio utente con ruolo.
Sincronizzazione WooCommerce

Gli ordini vengono sincronizzati tramite:

/sync-ordini

La sincronizzazione:

recupera ordini in stato processing;
crea o aggiorna il cliente;
salva l’ordine;
salva le righe ordine;
evita duplicazioni.
Struttura database
clienti
id
nome
cognome
email
indirizzo_fatturazione
indirizzo_spedizione
ordini
id (uguale a WooCommerce)
cliente_id
totale
stato
data_ordine
righe_ordine
id
ordine_id
prodotto
quantita
prezzo
Note

Il progetto utilizza:

architettura MVC (Laravel);
Eloquent ORM per le relazioni;
un service dedicato per l’integrazione WooCommerce;
sincronizzazione idempotente per evitare duplicati.
Autore

Alessandro Agnello