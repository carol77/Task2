1. Zainstaluj projekt -> composer install
2. Utwórz bazę danych i uzupełnij plik /env.php danymi do połączenia z bazą danych
3. Wygeneruj plik migracji i wykonaj migrację, aby utworzyć tabelę w bazie danych
    - php bin/console make:migration
    - php bin/console doctrine:migration:migrate
4. Formularz rejestracji znajduje się na podstronie /register
5. Formularz logowania znajduje się na podstronie /login