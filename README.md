# ATM Project

Det här är ett enkelt ATM/bankomat-projekt gjort med PHP och MySQL.

Projektet har inloggning, konton, insättning, uttag, överföring och en enkel admin-sida.

## Tekniker

- PHP
- MySQL / MariaDB
- PDO
- HTML
- CSS
- XAMPP eller Laragon

## Starta projektet med XAMPP

1. Lägg projektmappen här:

   C:\xampp\htdocs\atm-project

2. Starta XAMPP.

3. Starta:

   - Apache
   - MySQL

4. Öppna phpMyAdmin:

   http://localhost/phpmyadmin

## Skapa databasen

1. Skapa en ny databas i phpMyAdmin med namnet:

   atm_project

2. Klicka på databasen `atm_project`.

3. Gå till fliken `SQL`.

4. Kör innehållet från filen `database.sql`.

Filen skapar tabellerna:

- users
- accounts
- transactions

## Skapa testdata

Efter att databasen och tabellerna är skapade, kör seed-filen en gång i webbläsaren:

http://localhost/atm-project/seed.php

Om det fungerar visas:

Seed data created successfully.

## Login

Öppna login-sidan här:

http://localhost/atm-project/pages/login.php

## Testkonton

### Admin

- Kortnummer: 405198286421
- PIN: 1234

Admin kan se användare, konton och transaktioner.

### Användare 1

- Namn: John Doe
- Kortnummer: 428613759204
- PIN: 1234

### Användare 2

- Namn: Emma Johnson
- Kortnummer: 436158613451
- PIN: 1234

## Funktioner

- Logga in med kortnummer och PIN
- PIN sparas hashad med `password_hash()`
- PIN kontrolleras med `password_verify()`
- Session används efter inloggning
- Användare kan se sina egna konton
- Användare kan sätta in pengar
- Användare kan ta ut pengar
- Användare kan inte ta ut mer pengar än saldot
- Användare kan överföra pengar mellan sina egna konton
- Admin kan se användare, konton och transaktioner
- Formulär använder CSRF-token
- Databasfrågor använder PDO och prepared statements
