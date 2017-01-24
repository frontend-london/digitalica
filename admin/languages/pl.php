<?php

/*
 * templates:
 *   top.phtml
 *   threads.phtml
 *   sound-stuff.phtml
 *   remind.phtml
 *   recover.phtml
 *   pop-stuff.phtml
 *   logout.phtml
 *   login.phtml
 *   linki.phtml
 *   limit.phtml
 *   konta.phtml
 *   komentarze.phtml
 *   good-events.phtml
 *   forum.phtml
 *   design-stuff.phtml
 *   design-shock.phtml
 *   bottom.phtml
 *   banery.phtml
 *
 * controllers:
 *   banery
 *   cms
 *   design-shock
 *   design-stuff
 *   forum
 *   good-events
 *   komentarze
 *   konta
 *   limit
 *   linki
 *   pop-stuff
 *   sound-stuff
 *   threads
 *
 *
 */
    define('LANG', 'pl');


    define('LANG_ADRES_EMAIL', 'Adres e-mail');
    define('LANG_ADRES_EMAIL_TEKST', 'Dalsze instrukcje zostaną wysłane na adres <br>email, którego użyłeś(aś) do rejestracji.');
    define('LANG_BANERY', 'Banery');
    define('LANG_BANERY_DODAJ', 'Dodaj baner');
    define('LANG_BANERY_KOMUNIKAT', 'Czy na pewno chcesz usunąć ten baner?');
    define('LANG_BANERY_USUN', 'Usuń baner');
    define('LANG_BANERY_USUN_OK', 'Baner został poprawnie usunięty.');
    define('LANG_BANERY_USUN_ERR', 'Wystąpił błąd przy usuwaniu banera.');
    define('LANG_BRAK_UPRAWNIEN', 'Brak uprawnień');
    define('LANG_BRAK_UPRAWNIEN_KOMUNIKAT', 'Nie masz uprawnień do przeglądania tej kategorii.');
    define('LANG_DATA', 'Data');
    define('LANG_DODAJ_PYTANIE', 'Dodaj pytanie:&nbsp; &nbsp; (aby usunąć istniejące pytanie i odpowiedź pozostaw je puste)');
    define('LANG_DODAJ_WPIS', '+ Dodaj Wpis');
    define('LANG_DODAJ_WYWIAD', '+ Dodaj Wywiad');
    define('LANG_DODAL', 'dodał');
    define('LANG_EDYTUJ', 'Edytuj');
    define('LANG_HASLO', 'Hasło');
    define('LANG_KATEGORIE', 'Kategorie');
    define('LANG_KONTYNUUJ', 'Kontynuuj');
    define('LANG_KOMENTARZE_KOMUNIKAT', 'Czy na pewno chcesz usunąć ten komentarz?');
    define('LANG_KOMENTARZE_KOMUNIKAT2', 'Komentarz został poprawnie zmieniony');
    define('LANG_KOMENTARZE_KOMUNIKAT3', 'Wystąpił błąd przy zmianie komentarza.');
    define('LANG_KOMENTARZE_KOMUNIKAT4', 'Komentarz został poprawnie dodany');
    define('LANG_KOMENTARZE_KOMUNIKAT5', 'Wystąpił błąd przy dodawaniu komentarza.');
    define('LANG_KOMENTARZE_KOMUNIKAT6', 'Komentarz został poprawnie usunięty.');
    define('LANG_KOMENTARZE_KOMUNIKAT7', 'Wystąpił błąd przy usuwaniu komentarza.');
    define('LANG_KOMENTARZE_KOMUNIKAT8', 'Nie ma nowych komentarzy do wybranego wpisu');
    define('LANG_KOMENTARZE_KOMUNIKAT9', 'Nie ma nowych komentarzy');
    define('LANG_KOMENTARZE_KOMUNIKAT10', 'Nie ma komentarzy do wybranego wpisu');
    define('LANG_KOMENTARZE_KOMUNIKAT11', 'Nie ma komentarzy');
    define('LANG_KONTA_WLACZ_KOMUNIKAT', 'Czy na pewno chcesz włączyć to konto?');
    define('LANG_KONTA_WYLACZ_KOMUNIKAT', 'Czy na pewno chcesz wyłączyć to konto?');
    define('LANG_KONTA_WYLACZ_KOMUNIKAT2', 'PRÓBUJESZ WYŁĄCZYĆ WŁASNE KONTO\n\nTwoje konto zostanie zablokowane do momenu odblokowania go przez innego administratora (nie będziesz mógł go sam włączyć).\n Czy na pewno chcesz wyłączyć to konto?');
    define('LANG_KONTO_KOMUNIKAT', 'Konto zostało poprawnie zmienione');
    define('LANG_KONTO_KOMUNIKAT2', 'Wystąpił błąd przy zmianie konta.');
    define('LANG_KONTO_KOMUNIKAT3', 'Konto zostało poprawnie dodane');
    define('LANG_KONTO_KOMUNIKAT4', 'Wystąpił błąd przy dodawaniu konta.');
    define('LANG_KONTO_KOMUNIKAT5', 'Konto zostało poprawnie usunięte.');
    define('LANG_KONTO_KOMUNIKAT6', 'Wystąpił błąd przy usuwaniu konta.');
    define('LANG_KONTO_KOMUNIKAT7', 'Konto zostało włączone.');
    define('LANG_KONTO_KOMUNIKAT8', 'Wystąpił błąd przy włączaniu konta.');
    define('LANG_KONTO_KOMUNIKAT9', 'Konto zostało wyłączone.');
    define('LANG_KONTO_KOMUNIKAT10', 'Wystąpił błąd przy wyłączaniu konta.');
    define('LANG_KONTO_KOMUNIKAT11', 'Czy na pewno chcesz usunąć to konto?');
    define('LANG_KROTKI_OPIS', 'Krótki opis');
    define('LANG_LINKI_HISTORIA_WSZYSTKICH', 'Historia wszystkich linków:');
    define('LANG_LINKI_HISTORIA_LINKA', 'Historia linka: ');
    define('LANG_LINKI_SPRAWDZ_HISTORIE', 'Sprawdź Historię');
    define('LANG_LINKI_SZUKAJ_W_HISTORII', 'Szukaj w historii');
    define('LANG_LINKI_KOMUNIKAT', 'Czy na pewno chcesz usunąć ten link?');
    define('LANG_LINKI_KOMUNIKAT2', 'Link został poprawnie usunięty.');
    define('LANG_LINKI_KOMUNIKAT3', 'Wystąpił błąd przy usuwaniu linka.');
    define('LANG_LOGIN', 'Login');
    define('LANG_LOGIN_ERR', 'Nieprawidłowy login lub hasło.');
    define('LANG_LOGIN_ERR2', 'Ten link do zmiany hasła do profilu jest nieaktualny.');
    define('LANG_LOGIN_ERR3', 'Wypełnij wszystkie pola');
    define('LANG_LOGIN_ERR4', 'Podane hasła muszą być identyczne');
    define('LANG_LOGIN_OK', 'Twoje hasło zostało poprawnie zmienione.');
    define('LANG_LOGIN_OK2', 'Na podany email została wysłana wiadomość o zmianie hasła.');
    define('LANG_MAIL_CONTENT1', 'Aby odzyskać hasło kliknij:');
    define('LANG_MAIL_CONTENT2', 'Jeśli nie prosiłeś o odzyskanie hasła po prostu zignoruj tę wiadomość.');
    define('LANG_MAIL_ERR', 'Błąd - Podany adres email nie jest przypisany do żadnego konta.');
    define('LANG_MAIL_TITLE', 'Odzyskiwanie hasła na digitalica.pl');
    define('LANG_NAZWA', 'Nazwa');
    define('LANG_NOWE_HASLO', 'Nowe Hasło');
    define('LANG_NOWE_KOMENTARZE', 'Nowe komentarze');
    define('LANG_ODPOWIEDZ', 'Odpowiedź');
    define('LANG_OPIS', 'Opis');
    define('LANG_PODGLAD_STRONY', 'Podgląd strony');
    define('LANG_POKAZ_NOWE_KOMENTARZE', 'Pokaż nowe komentarze');
    define('LANG_POKAZ_WSZYSTKIE_KOMENTARZE', 'Pokaż wszystkie komentarze');
    define('LANG_POWROT_DO_OKNA_LOGOWANIA', 'Powrót do okna logowania');
    define('LANG_POWROT_NA_STRONE', 'Powrót na stronę');
    define('LANG_POWTORZ_HASLO', 'Powtórz Hasło');
    define('LANG_PYTANIE', 'Pytanie');
    define('LANG_TYTUL', 'Tytuł');
    define('LANG_USUN', 'Usuń');
    define('LANG_USUN_KOMUNIKAT', 'Czy na pewno chcesz usunąć ten wątek?');
    define('LANG_UTWORZ_KONTO', 'Utwórz Konto');
    define('LANG_UZYTKOWNIK', 'Użytkownik');
    define('LANG_WLACZONY', 'Włączony');
    define('LANG_WPIS_KOMUNIKAT', 'Wpis został poprawnie zmieniony');
    define('LANG_WPIS_KOMUNIKAT2', 'Wystąpił błąd przy zmianie wpisu.');
    define('LANG_WPIS_KOMUNIKAT3', 'Wpis został poprawnie dodany');
    define('LANG_WPIS_KOMUNIKAT4', 'Wystąpił błąd przy dodawaniu wpisu.');
    define('LANG_WPIS_KOMUNIKAT5', 'Wpis został poprawnie usunięty.');
    define('LANG_WPIS_KOMUNIKAT6', 'Wystąpił błąd przy usuwaniu wpisu.');
    define('LANG_WPIS_KOMUNIKAT7', 'Zdjęcie zostało poprawnie usunięte.');
    define('LANG_WPIS_KOMUNIKAT8', 'Wystąpił błąd przy usuwaniu zdjęcia.');
    define('LANG_WPIS_KOMUNIKAT9', 'Zdjęcie zostało poprawnie usunięte.');
    define('LANG_WPIS_KOMUNIKAT10', 'Wystąpił błąd przy usuwaniu zdjęcia.');
    define('LANG_WPIS_KOMUNIKAT11', 'Wpis został włączony.');
    define('LANG_WPIS_KOMUNIKAT12', 'Wystąpił błąd przy włączaniu wpisu.');
    define('LANG_WPIS_KOMUNIKAT13', 'Wpis został wyłączony.');
    define('LANG_WPIS_KOMUNIKAT14', 'Wystąpił błąd przy wyłączaniu wpisu.');
    define('LANG_WSTEP', 'Wstęp');
    define('LANG_WSZYSTKIE_KOMENTARZE', 'Wszystkie komentarze');
    define('LANG_WYLACZONY', 'Wyłączony');
    define('LANG_WYLOGUJ', 'Wyloguj');
    define('LANG_WYSTAPIL_BLAD', 'Wystąpił błąd:');
    define('LANG_ZAAKCEPTUJ', 'Zaakceptuj');
    define('LANG_ZAKONCZENIE', 'Zakończenie');
    define('LANG_ZALOGUJ_PONOWNIE', 'Zaloguj ponownie');
    define('LANG_ZALOGUJ_SIE', 'Zaloguj się');
    define('LANG_ZALOGOWANY_JAKO', 'Zalogowany jako');
    define('LANG_ZAPOMNIALEM_HASLO', 'Zapomniałem hasło');
    define('LANG_ZDJECIE_GLOWNE', 'Zdjęcie główne');
    define('LANG_ZDJECIE_KOMUNIKAT', 'Czy na pewno chcesz usunąć to zdjęcie?');
    define('LANG_ZDJECIE_PODSTRONA', 'Zdjęcie podstrona');
    define('LANG_ZMIANA_HASLA', 'Zmiana hasła');
    define('LANG_ZMIEN_HASLO', 'Zmień hasło');
    define('LANG_ZMIEN_JEZYK', 'Switch to English');
    define('LANG_ZOSTALES_WYLOGOWANY', 'Zostałeś poprawnie wylogowany');








?>