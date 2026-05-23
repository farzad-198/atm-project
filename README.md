ATM Project
# ATM Project

Det här är ett enkelt ATM/bankomat-projekt gjort med PHP och MySQL.

Projektet har inloggning, konton, insättning, uttag, överföring och en enkel admin-sida.

## Starta projektet

1. Lägg projektmappen i Laragon:

   C:\laragon\www\atm-project

2. Starta Laragon.

3. Kör `database.sql` i databasen.

4. Kör seed-filen i webbläsaren:

   http://localhost/atm-project/seed.php

5. Öppna login-sidan:

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

## Tekniker

- PHP
- MySQL
- PDO
- HTML
- CSS
- Laragon


## Repository-klasser

Jag använder enkla repository-klasser för databaslogiken.

- `UserRepository.php` används för användare
- `AccountRepository.php` används för konton
- `TransactionRepository.php` används för transaktioner

På så sätt ligger SQL-frågorna mest i `src` och inte direkt i sidfilerna.

## Kommentar

Jag har fokuserat på att få de grundläggande funktionerna att fungera och hålla koden enkel.Sattsar G_nivå