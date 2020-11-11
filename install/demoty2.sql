
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin_logs`
--

CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin_session`
--

CREATE TABLE IF NOT EXISTS `admin_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text COLLATE utf8_polish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `page` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `content` text NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `info`
--

INSERT INTO `info` (`id`, `name`, `slug`, `page`, `content`, `keywords`, `description`) VALUES
(1, 'Polityka prywatności', 'polityka-prywatnosci', 'privacy_policy', '<p>Oto nasze stanowisko w sprawie gromadzenia, przetwarzania i wykorzystywania danych, wprowadzonych przez użytkownik&oacute;w serwisu.</p>\r\n\r\n<p>Jaka jest polityka serwisu dotycząca adres&oacute;w e-mail?<br />\r\nPodany podczas dodawania rejestracji adres e-mail służy do weryfikacji osoby zamieszczającej pliki.</p>\r\n\r\n<p>Czy adresy e-mail są udostępniane innym osobom, lub firmom?<br />\r\nNie udostępniamy takich danych&nbsp;osobom trzecim lub firmom. Jednak należy mieć na uwadze, że podane w treści opisu dane mogą zostać &quot;zapamiętane&quot; przez inne osoby lub firmy.&nbsp;Administrator serwisu dołożył należytej staranności w celu odpowiedniego zabezpieczenia przekazanych danych osobowych, a w szczeg&oacute;lności przed ich udostępnieniem osobom nieupoważnionym.</p>\r\n\r\n<p>Ciasteczka (pliki cookie) i sygnalizatory WWW (web beacon)</p>\r\n\r\n<p>Zastrzegamy sobie możliwość do wykorzystania plik&oacute;w cookie (ciasteczek) oraz tzw session storage. Pliki te są zapisywane na Twoim komputerze. Służą one do:</p>\r\n\r\n<p>a) dostosowania zawartości serwisu&nbsp;do preferencji użytkownika oraz optymalizacji korzystania ze stron internetowych;,</p>\r\n\r\n<p>b) utrzymania sesji użytkownika serwisu internetowego (po zalogowaniu), dzięki kt&oacute;rej użytkownik nie musi na każdej podstronie serwisu ponownie wpisywać loginu i hasła,</p>\r\n\r\n<p>c) dostarczania użytkownikom treści reklamowych bardziej dostosowanych do ich zainteresowań.</p>\r\n\r\n<p>Serwis wyświetla reklamy pochodzące od zewnętrznych dostawc&oacute;w. Dostawcy reklam (np. Google) mogą używać ciasteczek i sygnalizator&oacute;w WWW, mogą uzyskać informację o Twoim adresie IP i typie używanej przeglądarki, sprawdzić czy zainstalowany jest dodatek Flash itp. Dzięki ciasteczkom, sygnalizatorom i znajomości adresu IP dostawcy reklam mogą decydować o treści reklam.&nbsp;</p>\r\n\r\n<p>Przeglądarki internetowe, oraz niekt&oacute;re Firewalle, umożliwiają wyłączenie obsługi ciasteczek i sygnalizator&oacute;w, lub jej ograniczenie dla wszystkich lub tylko dla wybranych stron WWW. Jednak wyłączenie obsługi ciasteczek i sygnalizator&oacute;w może uniemożliwić poprawne działanie naszego serwisu.&nbsp;</p>\r\n\r\n<p>Wsp&oacute;łczesne przeglądarki umożliwiają przeglądanie stron www tzw. &quot;trybie prywatnym (incognito)&quot; co zazwyczaj oznacza, że wszystkie odwiedzone strony www nie zostaną zapamiętane w lokalnej historii przeglądarki, a pobrane ciasteczka zostaną skasowane po zakończeniu pracy z przeglądarką. Szczeg&oacute;łowy opis &quot;trybu prywatnego&quot; jest dostępny w pomocy przeglądarki.</p>\r\n\r\n<p>Wyłączenie &quot;ciasteczek&quot; w najbardziej popularnych przeglądarkach:</p>\r\n\r\n<p><strong>Google Chrome</strong></p>\r\n\r\n<p>Należy kliknąć na menu (w prawym g&oacute;rnym rogu), zakładka Ustawienia &gt; Pokaż ustawienia zaawansowane. W sekcji &bdquo;Prywatność&rdquo; trzeba kliknąć przycisk Ustawienia treści. W sekcji &bdquo;Pliki cookie&rdquo; można zmienić następujące ustawienia plik&oacute;w Cookie:</p>\r\n\r\n<ul>\r\n	<li>Usuwanie plik&oacute;w Cookie,</li>\r\n	<li>Domyślne blokowanie plik&oacute;w Cookie,</li>\r\n	<li>Domyślne zezwalanie na pliki Cookie,</li>\r\n	<li>Domyślne zachowywanie plik&oacute;w Cookie i danych stron do zamknięcia przeglądarki</li>\r\n	<li>Określanie wyjątk&oacute;w dla plik&oacute;w Cookie z konkretnych witryn lub domen</li>\r\n</ul>\r\n\r\n<p><strong>Mozilla Firefox</strong></p>\r\n\r\n<p>Z menu przeglądarki: Narzędzia &gt; Opcje &gt; Prywatność. Uaktywnić pole Program Firefox: &bdquo;będzie używał ustawień użytkownika&rdquo;. O ciasteczkach (cookies) decyduje zaznaczenie &ndash; bądź nie &ndash; pozycji Akceptuj ciasteczka.</p>\r\n\r\n<p><strong>Opera</strong></p>\r\n\r\n<p>Z menu przeglądarki: Narzędzie &gt; Preferencje &gt; Zaawansowane. O ciasteczkach decyduje zaznaczenie &ndash; bądź nie &ndash; pozycji Ciasteczka.</p>\r\n\r\n<p><strong>Safari</strong></p>\r\n\r\n<p>W menu rozwijanym Safari trzeba wybrać Preferencje i kliknąć ikonę Bezpieczeństwo.<br />\r\nW tym miejscu wybiera się poziom bezpieczeństwa w obszarze ,,Akceptuj pliki cookie&rdquo;.</p>\r\n', '', ''),
(2, 'Regulamin', 'regulamin', 'rules', '', '', ''),
(3, 'Kontakt', 'kontakt', 'contact', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_mail`
--

CREATE TABLE IF NOT EXISTS `logs_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(64) NOT NULL,
  `action` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_picture`
--

CREATE TABLE IF NOT EXISTS `logs_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_user`
--

CREATE TABLE IF NOT EXISTS `logs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `name` varchar(64) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `mail`
--

INSERT INTO `mail` (`name`, `full_name`, `subject`, `message`) VALUES
('contact_form', 'Contact form', 'Wiadomość z formularza kontaktowego strony {title}', '<p>Witaj!</p>\r\n\r\n<p>Została do Ciebie wysłana wiadomość z formularza kontaktowego ze strony {base_url}</p>\r\n\r\n<p>Nadawca: {name}</p>\r\n\r\n<p>Adres email: {email}</p>\r\n\r\n<p>Wiadomość: {message}</p>\r\n'),
('profile', 'Profile', 'Wiadomość do profilu {username}', '<p>Witaj!</p>\r\n\r\n<p>Została do Ciebie wysłana wiadomość ze strony&nbsp;<a href=\"{base_url}\">{base_url}</a>&nbsp;ze strony Twojego profilu {username}</p>\r\n\r\n<p>Nadawca: {name}</p>\r\n\r\n<p>Adres email: {email}</p>\r\n\r\n<p>Wiadomość: {message}</p>\r\n'),
('register', 'Register', 'Witamy na stronie {title}', '<p>Witaj na stronie <a href=\"{base_url}\">{title}</a>!<br />\r\n<br />\r\nDziękujemy za rejestrację.<br />\r\n<br />\r\nŻeby ją dokończyć kliknij w link: <a href=\"{activation_link}\">{activation_link}</a><br />\r\n<br />\r\nInformujemy że link aktywacyjny jest ważny 24 godziny, po tym czasie nieaktywowane konta zostają usuwane.<br />\r\nJeśli to nie Ty się rejestrowałeś to zignoruj tą wiadomość<br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href=\"{base_url}\">{link_logo}</a></p>\r\n'),
('register_fb', 'Register by Facebook', 'Witamy na stronie {title}', '<p>Witaj na stronie <a href=\"{base_url}\">{title}</a>!<br />\r\n<br />\r\nDziękujemy za rejestrację poprzez konto Facebook.</p>\r\n\r\n<p>Twoje losowo wygenerowane hasło to: {password}<br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href=\"{base_url}\">{link_logo}</a></p>\r\n'),
('register_google', 'Register by Google', 'Witamy na stronie {title}', '<p>Witaj na stronie <a href=\"{base_url}\">{title}</a>!<br />\r\n<br />\r\nDziękujemy za rejestrację poprzez konto Google.</p>\r\n\r\n<p>Twoje losowo wygenerowane hasło to: {password}<br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href=\"{base_url}\">{link_logo}</a></p>\r\n'),
('reset_password', 'Reset password', 'Reset hasła - {title}', '<p>Witaj {username}!<br />\r\n<br />\r\nAby zresetować swoje hasło do serwisu <a href=\"{base_url}\">{title}</a> kliknij w następujący link: <a href=\"{reset_password_link}\">{reset_password_link}</a><br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}</p>\r\n');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mail_queue`
--

CREATE TABLE IF NOT EXISTS `mail_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(64) NOT NULL,
  `action` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `priority` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mem_pattern`
--

CREATE TABLE IF NOT EXISTS `mem_pattern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) NOT NULL,
  `thumb` varchar(256) NOT NULL,
  `position` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(512) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `slug` varchar(512) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `waiting_room` int(1) NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `type` varchar(16) COLLATE utf8_polish_ci DEFAULT NULL,
  `filename` varchar(16) COLLATE utf8_polish_ci DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_polish_ci,
  `main_page_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title_size` int(11) NOT NULL DEFAULT '0',
  `title_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `title_border_size` int(11) NOT NULL DEFAULT '0',
  `title_border_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `description_size` int(11) NOT NULL DEFAULT '0',
  `description_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `description_border_size` int(11) NOT NULL DEFAULT '0',
  `description_border_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `background_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `border_color` varchar(7) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `ip` varchar(40) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `picture_tmp`
--

CREATE TABLE IF NOT EXISTS `picture_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reset_password`
--

CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `used` int(1) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `code` varchar(32) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `session_user`
--

CREATE TABLE IF NOT EXISTS `session_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(64) NOT NULL,
  `value` text COLLATE utf8_polish_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('add_picture_not_logged', '1'),
('ads_amount_pictures', '5'),
('ads_between_pictures', ''),
('ads_bottom', ''),
('ads_side_left', ''),
('ads_side_right', ''),
('ads_top', ''),
('allow_comments_fb_picture', '1'),
('allow_comments_fb_profile', '1'),
('analytics', ''),
('automation_added', '0'),
('automation_added_days', '10'),
('automation_added_pictures', '1'),
('automation_randomly', '0'),
('automation_randomly_pictures', '1'),
('automation_votes_minus', '0'),
('automation_votes_minus_pictures', '1'),
('automation_votes_minus_votes', '10'),
('automation_votes_plus', '0'),
('automation_votes_plus_pictures', '1'),
('automation_votes_plus_votes', '10'),
('base_url', ''),
('black_list_email', ''),
('black_list_ip', ''),
('black_list_words', ''),
('check_ip_user', '1'),
('code_body', ''),
('code_head', ''),
('code_style', ''),
('description', 'Skrypt Demoty2, umożliwia stworzenie własnej strony z demotywatorami oraz memami.'),
('email', ''),
('facebook_api', ''),
('facebook_lang', 'pl_PL'),
('facebook_login', ''),
('facebook_secret', ''),
('facebook_side_panel', ''),
('favicon', '/upload/images/favicon.png'),
('footer_bottom', '<p style=\"text-align: center;\">Wszelkie obrazki i filmy na stronie są dodawane przez użytkownik&oacute;w serwisu i jego właściciel nie bierze za nie odpowiedzialności.</p>\r\n'),
('footer_text', 'Web script Demoty2.6 &copy; Project 2018 - 2020 by <a href=\"https://itworksbetter.net\" target=\"_blank\" title=\"Creating websites\">IT Works Better</a>'),
('footer_top', '<p>DEMOTY2 to nowoczesny skrypt dla stron internetowych z demotywatorami. Umożliwia tworzenie i edycję własnych demotywator&oacute;w, głosowanie na nie oraz dodawanie komentarzy.</p>\r\n\r\n<p>Do skryptu dołączony jest Panel Administratora umożliwiający łatwą edycję ustawień strony.&nbsp;<br />\r\nPanel jest dostępny pod adresem: <a href=\"http://demoty2.itworksbetter.net/admin\" target=\"_blank\">http://itworksbetter.net/admin</a><br />\r\nLogin: test<br />\r\nHasło: 1234</p>\r\n'),
('generate_sitemap', '1'),
('google_id', ''),
('google_login', ''),
('google_secret', ''),
('header', 'DEMOTY2'),
('keywords', 'demoty, skrypt typu demoty, skrypt typu demotywatory, demoty2'),
('lang', 'pl'),
('limit_page', '10'),
('limit_page_profile', '20'),
('lk', ''),
('ln', ''),
('logo', '/upload/images/logo.png'),
('logo_facebook', '/upload/images/logo.png'),
('mail_attachment', '1'),
('number_char_description', '1024'),
('number_char_title', '256'),
('rss', '1'),
('rodo_alert', ''),
('rodo_alert_text', '<p>Szanowny użytkowniku,<br />\r\npragniemy Cię poinformować, że nasz serwis internetowy może personalizować treści marketingowe do Twoich potrzeb. W związku z tym danymi osobowymi, kt&oacute;re przetwarzamy są np. Tw&oacute;j adres IP, dane pozyskiwane na podstawie plik&oacute;w cookies lub podobnych mechanizm&oacute;w na Twoim urządzeniu o ile pozwolą one na zidentyfikowanie Ciebie.&nbsp;<br />\r\nJeżeli klikniesz przycisk &bdquo;Wyrażam zgodę na przetwarzanie moich danych osobowych&rdquo; lub zamkniesz to okno, to wyrazisz zgodę na przetwarzanie Twoich danych przez właściciela witryny i jego zaufanych partner&oacute;w.<br />\r\nWyrażenie zgody jest dobrowolne. Masz prawo do: dostępu do Twoich danych, ich sprostowania oraz usunięcia. Więcej informacji odnośnie przetwarzania danych osobowych znajdziesz w naszej <a href=\"/info/1,polityka-prywatnosci\">Polityce Prywatności.</a></p>\r\n\r\n<p>Lista zaufanych partner&oacute;w:<br />\r\nGoogle - na stronie są zamieszczone kody reklam Adsense oraz Google Analytics, kt&oacute;re mają na celu wyświetlanie spersonalizowanych treści oraz zbieranie informacji o zachowaniu użytkownika w celu poprawy strony.<br />\r\nFacebook - na stronie zamieszczony jest kod Facebook mający na celu wyświetlanie boksu z komentarzami oraz panelu bocznego.</p>\r\n'),
('show_contact_form_profile', '1'),
('show_title_desc', ''),
('smtp', ''),
('smtp_host', ''),
('smtp_mail', ''),
('smtp_password', ''),
('smtp_port', '465'),
('smtp_secure', 'ssl'),
('smtp_user', ''),
('social_facebook', '1'),
('social_pinterest', '1'),
('social_twitter', '1'),
('social_wykop', '1'),
('template', 'default'),
('title', 'Demoty2 - skrypt strony z demotywatorami'),
('url_facebook', ''),
('url_privacy_policy', 'polityka-prywatnosci'),
('url_rules', 'regulamin'),
('voice_only_logged', '0'),
('watermark', '/upload/images/watermark.png'),
('watermark_add', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tag_picture`
--

CREATE TABLE IF NOT EXISTS `tag_picture` (
  `tag_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL,
  KEY `tag_id` (`tag_id`),
  KEY `file_id` (`picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `active` int(1) NOT NULL,
  `moderator` int(1) DEFAULT NULL,
  `description` text COLLATE utf8_polish_ci,
  `activation_code` varchar(32) NOT NULL,
  `register_fb` int(1) DEFAULT NULL,
  `register_google` int(1) DEFAULT NULL,
  `register_ip` varchar(40) NOT NULL,
  `activation_date` datetime DEFAULT NULL,
  `activation_ip` varchar(40) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `voice`
--

CREATE TABLE IF NOT EXISTS `voice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `voice` int(1) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Ograniczenia dla zrzutów tabel
--

-- Ograniczenia dla tabeli `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `reset_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `tag_picture`
--
ALTER TABLE `tag_picture`
  ADD CONSTRAINT `tag_picture_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`),
  ADD CONSTRAINT `tag_picture_ibfk_2` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`);

--
-- Ograniczenia dla tabeli `voice`
--
ALTER TABLE `voice`
  ADD CONSTRAINT `voice_ibfk_1` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
