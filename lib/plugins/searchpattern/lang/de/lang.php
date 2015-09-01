<?php

/*****************************************************************
* SearchPattern Langage file (de)
* Author : by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
* Creation : 2013-04-15
* - ver 2013-06-16       : Add new option 'dispheadl' (leo)
*****************************************************************/

$lang['admin_menu_text'] = 'SearchPattern Einstellungen';

$lang['main_admin_title'] = 'SearchPattern Plugin Einstellungen';
$lang['ndqerr_admin_title'] = 'Verhalten bei einem einzigen Einzelhochkoma :';
$lang['regerr_admin_title'] = 'Verhalten bei regex Syntax Fehler :';
$lang['badopt_admin_title'] = 'Verhalten bei Verwendung einer unbekannten Option :';
$lang['ignopt_admin_title'] = 'Verhalten falls eine Option ignoriert werden soll :';
$lang['option_admin_title'] = 'Verhalten falls Optionen verwendet werden :';
$lang['dispheadl_admin_title'] = 'Anzeigen des RegEx Codes in Ergebnistabelle :';

$lang['nocatch'] = 'Request nicht abfangen (Original Text anzeigen)';
$lang['error'] = 'Request abfangen und Fehler anzeigen';
$lang['warning'] = 'Request abfangen, Warnung anzeigen und weitermachen';
$lang['nowarn'] = 'Request abfangen und weitermachen (Fehler ignorieren)';
$lang['disp'] = 'In Ergebnis Tabelle anzeigen';
$lang['nodisp'] = 'In Ergebnis Tabelle nicht anzeigen';

$lang['save_conf_ok'] = 'Konfiguration gespeichert';
$lang['save_conf_warn'] = 'Konfiguration gespeichert, zum Teil Standardwerte verwendet';
$lang['save_conf_nowr'] = 'Konfiguration nicht gespeichert : Kann Konfigurationsdatei nicht schreiben';
$lang['save_conf_noop'] = 'Konfiguration nicht gespeichert : Kann Konfigurationsdatei nicht öffnen';
$lang['save_conf_ok_lvl'] = '1';	//message level : success
$lang['save_conf_warn_lvl'] = '2';	//message level : warning
$lang['save_conf_nowr_lvl'] = '-1';	//message level : error
$lang['save_conf_noop_lvl'] = '-1';	//message level : error

$lang['src_res'] = 'Suchergebnisse für Pattern';
$lang['csnormal'] = 'Unterscheidung zwischen Groß und Kleinschreibung für normale Suche';
$lang['not_csnormal'] = 'Keine Unterscheidung zwischen Groß und Kleinschreibung für normale Suche';
$lang['regex'] = 'Regular expression Suche';
$lang['page_name'] = 'Seitenname';
$lang['num_match'] = 'Ergebnis(se)';
$lang['ndq_err_warn'] = 'Mindestens ein einfaches Anführungszeichen gefunden.<br />Suche wird fortgesetzt mit möglicherweise inkorrekten Resultaten.';
$lang['no_res'] = 'Kein Ergebnis gefunden';
$lang['pat_err'] = 'Folgende Fehler wurden im Pattern gefunden';
$lang['ndq_err'] = 'Mindestens ein einfaches Anführungszeichen gefunden';
$lang['reg_err'] = 'Regex syntax ist nicht richtig';
$lang['unkw_err'] = 'Ein unerwarterter Fehler ist aufgetreten. Bitte konsultieren Sie die Plugin Homepage';
$lang['badopt_warn'] = 'Folgende unbekannte Optionen wurden verwendet (Trotzdem wird die Bearbeitung fortgesetzt) :';
$lang['ignopt_warn'] = 'Folgende Optionen wurden ignoriert, weil sie von anderen Optionen überschrieben wurden :';
$lang['badopt_err'] = 'Folgende unbekannte Optionen wurden gefunden :';
$lang['restriction'] = 'Suche wurde auf folgende Seiten/Namespaces eingeschränkt :';
$lang['exclusion'] = 'Folgende Seiten/Namespaces wurdne von der Suche ausgeschlossen :';

$lang['call_handler_invalid'] = 'Pluginname ist unbekannt';
$lang['call_handler_notsupported'] = 'Plugin wurde nicht gefunden oder Plugin unterstützt Searchpattern nicht (besitzt keine Searchpattern-Handler Methode)';
$lang['call_handler_disabled'] = 'Plugin nicht gefunden oder Plugin unterstützt Searchpattern nicht (besitzt keine Searchpattern-Handler Methode)';

$lang['dispheadl'] = 'Anzeige des RegEx Codes in der &Uuml;berschrift der Suchergebnistabelle';

?>