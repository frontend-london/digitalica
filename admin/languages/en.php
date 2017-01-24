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
    define('LANG', 'en');
    
    
    define('LANG_ADRES_EMAIL', 'E-mail address');
    define('LANG_ADRES_EMAIL_TEKST', 'You\'ll receive e-mail with instructions shortly');
    define('LANG_BANERY', 'Banners');
    define('LANG_BANERY_DODAJ', 'Add banner');
    define('LANG_BANERY_KOMUNIKAT', 'Are you sure you want to remove this banner?');
    define('LANG_BANERY_USUN', 'Delete banner');
    define('LANG_BANERY_USUN_OK', 'Banner has been removed successfully.');
    define('LANG_BANERY_USUN_ERR', 'An error occur while removing banner.');
    define('LANG_BRAK_UPRAWNIEN', 'You don\'t have privileges');
    define('LANG_BRAK_UPRAWNIEN_KOMUNIKAT', 'You don\'t have privileges to view this category.');
    define('LANG_DATA', 'Date');
    define('LANG_DODAJ_PYTANIE', 'Add question:&nbsp; &nbsp; (to delete existing question and answer leave it blank)');
    define('LANG_DODAJ_WPIS', '+ Add entry');
    define('LANG_DODAJ_WYWIAD', '+ Add Interview');
    define('LANG_DODAL', 'added by');
    define('LANG_EDYTUJ', 'Edit');
    define('LANG_HASLO', 'Password');
    define('LANG_KATEGORIE', 'Categories');
    define('LANG_KONTYNUUJ', 'Continue');
    define('LANG_KOMENTARZE_KOMUNIKAT', 'Are you sure you want to remove this comment?');
    define('LANG_KOMENTARZE_KOMUNIKAT2', 'Comment has been changed');
    define('LANG_KOMENTARZE_KOMUNIKAT3', 'An error occur while changing comment.');
    define('LANG_KOMENTARZE_KOMUNIKAT4', 'Comment has been added.');
    define('LANG_KOMENTARZE_KOMUNIKAT5', 'An error occur while adding comment.');
    define('LANG_KOMENTARZE_KOMUNIKAT6', 'Comment has been removed successfully.');
    define('LANG_KOMENTARZE_KOMUNIKAT7', 'An error occur while removing comment.');
    define('LANG_KOMENTARZE_KOMUNIKAT8', 'No new comments');
    define('LANG_KOMENTARZE_KOMUNIKAT9', 'No new comments');
    define('LANG_KOMENTARZE_KOMUNIKAT10', 'No comments');
    define('LANG_KOMENTARZE_KOMUNIKAT11', 'No comments');
    define('LANG_KONTA_WLACZ_KOMUNIKAT', 'Are you sure you want to enable this account?');
    define('LANG_KONTA_WYLACZ_KOMUNIKAT', 'Are you sure you want to disable this account?');
    define('LANG_KONTA_WYLACZ_KOMUNIKAT2', 'YOU\'RE TRYING TO DISABLE YOUR OWN ACCOUNT.\n\nYour account will be blocked till oder admin will re-enable it. ( You won\'t be able to re-enable it).\N Are you sure you want to disable this account?');
    define('LANG_KONTO_KOMUNIKAT', 'Account has been changed');
    define('LANG_KONTO_KOMUNIKAT2', 'An error occur while changing account.');
    define('LANG_KONTO_KOMUNIKAT3', 'Account has been added successful');
    define('LANG_KONTO_KOMUNIKAT4', 'An error occur while adding account.');
    define('LANG_KONTO_KOMUNIKAT5', 'Account has been removed successfully.');
    define('LANG_KONTO_KOMUNIKAT6', 'An error occur while deleting account.');
    define('LANG_KONTO_KOMUNIKAT7', 'Account has been enabled.');
    define('LANG_KONTO_KOMUNIKAT8', 'There was an error while enabling account.');
    define('LANG_KONTO_KOMUNIKAT9', 'Account has been disabled.');
    define('LANG_KONTO_KOMUNIKAT10', 'There was an error while disableing account.');
    define('LANG_KONTO_KOMUNIKAT11', 'Are you sure you want to delete this account?');
    define('LANG_KROTKI_OPIS', 'Short description');
    define('LANG_LINKI_HISTORIA_WSZYSTKICH', 'History of all links:');
    define('LANG_LINKI_HISTORIA_LINKA', 'Historia of link: ');
    define('LANG_LINKI_SPRAWDZ_HISTORIE', 'Check history');
    define('LANG_LINKI_SZUKAJ_W_HISTORII', 'Search in history');
    define('LANG_LINKI_KOMUNIKAT', 'Are you sure you want to remove this link?');
    define('LANG_LINKI_KOMUNIKAT2', 'Link has been removed successfully.');
    define('LANG_LINKI_KOMUNIKAT3', 'An error occur while removing link.');
    define('LANG_LOGIN', 'Login');
    define('LANG_LOGIN_ERR', 'Invalid login or password.');
    define('LANG_LOGIN_ERR2', 'This link to change password in profile is invalid.');
    define('LANG_LOGIN_ERR3', 'Please enter details in all fields');
    define('LANG_LOGIN_ERR4', 'New passwords don\'t match');
    define('LANG_LOGIN_OK', 'Your password has been changed.');
    define('LANG_LOGIN_OK2', 'We have sent you instructions on provided email.');
    define('LANG_MAIL_CONTENT1', 'To recover password click:');
    define('LANG_MAIL_CONTENT2', 'If you didn\'t ask for password recovery please ignore this message.');
    define('LANG_MAIL_ERR', 'Error: Invalid e-mail address');
    define('LANG_MAIL_TITLE', 'Pasword reminder on digitalica.pl');
    define('LANG_NAZWA', 'Name');
    define('LANG_NOWE_HASLO', 'New password');
    define('LANG_NOWE_KOMENTARZE', 'New comments');
    define('LANG_ODPOWIEDZ', 'Answer');
    define('LANG_OPIS', 'Description');
    define('LANG_PODGLAD_STRONY', 'Page preview');
    define('LANG_POKAZ_NOWE_KOMENTARZE', 'Show new comments');
    define('LANG_POKAZ_WSZYSTKIE_KOMENTARZE', 'Show all comments');
    define('LANG_POWROT_DO_OKNA_LOGOWANIA', 'Return to login page');
    define('LANG_POWROT_NA_STRONE', 'Back to page');
    define('LANG_POWTORZ_HASLO', 'Confirm password');
    define('LANG_PYTANIE', 'Question');
    define('LANG_TYTUL', 'Title');
    define('LANG_USUN', 'Delete');
    define('LANG_USUN_KOMUNIKAT', 'Are you sure you want to remove this treat?');
    define('LANG_UTWORZ_KONTO', 'Create account');
    define('LANG_UZYTKOWNIK', 'User');
    define('LANG_WLACZONY', 'Enabled');
    define('LANG_WPIS_KOMUNIKAT', 'Entry has been changed correctly ');
    define('LANG_WPIS_KOMUNIKAT2', 'An error occur while editing entry.');
    define('LANG_WPIS_KOMUNIKAT3', 'Entry has been added successfully');
    define('LANG_WPIS_KOMUNIKAT4', 'An error occur while adding entry.');
    define('LANG_WPIS_KOMUNIKAT5', 'Entry has been removed successfully.');
    define('LANG_WPIS_KOMUNIKAT6', 'An error occur while removing entry.');
    define('LANG_WPIS_KOMUNIKAT7', 'Photo has been removed successfully.');
    define('LANG_WPIS_KOMUNIKAT8', 'An error occur while removing photo.');
    define('LANG_WPIS_KOMUNIKAT9', 'Photo has been removed successfully.');
    define('LANG_WPIS_KOMUNIKAT10', 'An error occur while removing photo.');
    define('LANG_WPIS_KOMUNIKAT11', 'Entry has been enabled.');
    define('LANG_WPIS_KOMUNIKAT12', 'There was an error while enabling entry.');
    define('LANG_WPIS_KOMUNIKAT13', 'Entry has been disabled.');
    define('LANG_WPIS_KOMUNIKAT14', 'There was an error while disableing entry.');
    define('LANG_WSTEP', 'Beginning');
    define('LANG_WSZYSTKIE_KOMENTARZE', 'All comments');
    define('LANG_WYLACZONY', 'Disabled');
    define('LANG_WYLOGUJ', 'Logout');
    define('LANG_WYSTAPIL_BLAD', 'An error occurred:');
    define('LANG_ZAAKCEPTUJ', 'Accept');
    define('LANG_ZALOGUJ_PONOWNIE', 'Login again');
    define('LANG_ZALOGUJ_SIE', 'Login');
    define('LANG_ZAKONCZENIE', 'Ending');
    define('LANG_ZALOGOWANY_JAKO', 'Logged in as');
    define('LANG_ZAPOMNIALEM_HASLO', 'Forgot my password');
    define('LANG_ZDJECIE_GLOWNE', 'Main photo');
    define('LANG_ZDJECIE_KOMUNIKAT', 'Are you sure you want to delete this photo?');
    define('LANG_ZDJECIE_PODSTRONA', 'Subpage photo');
    define('LANG_ZMIANA_HASLA', 'Password change');
    define('LANG_ZMIEN_HASLO', 'Change password');
    define('LANG_ZMIEN_JEZYK', 'Switch to Polish');
    define('LANG_ZOSTALES_WYLOGOWANY', 'You have been logout successful');

?>