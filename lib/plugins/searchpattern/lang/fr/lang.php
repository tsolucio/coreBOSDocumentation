<?php

/*****************************************************************
* SearchPattern Langage file (fr)
* Author : Matthieu Rioteau (matthieu<dot>rioteau<at>skf<dot>com)
* Creation : 2009-12-22
* Releases list :
* - ver 0.1 : 2009-12-22 : Initial release
* - ver 0.2 : 2010-07-05 : Restriction/exclusion capability
* - ver 2013-06-16: Bugfix ndqerr_admin_title invalid php syntax (by Frédéric)
* - ver 2013-06-16c: translate dispheadl and call_handler to french (by Frédéric)
*****************************************************************/

$lang['admin_menu_text'] = 'R&eacute;glages du plugin SearchPattern';

$lang['main_admin_title'] = 'Param&eacute;trage du comportement du plugin SearchPattern';
$lang['ndqerr_admin_title'] = 'En cas d\'erreur sur des apostrophes non doubl&eacute;es : ';
$lang['regerr_admin_title'] = 'En cas d\'erreur sur une regexp mal format&eacute;e :';
$lang['badopt_admin_title'] = 'En cas d\'utilisation d\'une mauvaise option :';
$lang['ignopt_admin_title'] = 'Dans le cas o&ugrave; une option doit &ecirc;tre ignor&eacute;e :';
$lang['option_admin_title'] = 'Dans le cas o&ugrave; des options sont utilis&eacute;es :';
$lang['dispheadl_admin_title'] = 'Afficher l\'expression r&eacute;guli&egrave;re dans le r&eacute;sultat :';

$lang['nocatch'] = 'Ne pas proc&eacute;der &agrave; la requ&ecirc;te (le texte original est affich&eacute;)';
$lang['error'] = 'Ne pas proc&eacute;der &agrave; la requ&ecirc;te mais afficher un message d\'erreur';
$lang['warning'] = 'Proc&eacute;der &agrave; la requ&ecirc;te mais afficher un message d\'avertissement';
$lang['nowarn'] = 'Proc&eacute;der simplement &agrave; la requ&ecirc;te (ignorer l\'erreur)';
$lang['disp'] = 'Afficher dans le tableau de r&eacute;sultats';
$lang['nodisp'] = 'Ne pas afficher dans le tableau de r&eacute;sultats';

$lang['save_conf_ok'] = 'Configuration sauv&eacute;e';
$lang['save_conf_warn'] = 'Configuration sauv&eacute;e mais certains param&ecirc;tres ont une valeur par d&eacute;faut';
$lang['save_conf_nowr'] = 'Configuration non sauv&eacute;e : impossible d\'&eacute;crire le fichier';
$lang['save_conf_noop'] = 'Configuration non sauv&eacute;e : impossible d\'ouvrir le fichier';
$lang['save_conf_ok_lvl'] = '1';	//message level : success
$lang['save_conf_warn_lvl'] = '2';	//message level : warning
$lang['save_conf_nowr_lvl'] = '-1';	//message level : error
$lang['save_conf_noop_lvl'] = '-1';	//message level : error

$lang['src_res'] = 'R&eacute;sultat de la recherche de';
$lang['csnormal'] = 'Recherche normale sensible &agrave; la casse';
$lang['not_csnormal'] = 'Recherche normale insensible &agrave; la casse';
$lang['regex'] = 'Recherche d\'une expression r&eacute;guli&egrave;re';
$lang['page_name'] = 'Nom de la page';
$lang['num_match'] = 'Correspondance(s)';
$lang['ndq_err_warn'] = 'Au moins une apostrophe non-doubl&eacute;e a &eacute;t&eacute; trouv&eacute;e.<br />Le recherche est fa&icirc;te tout de m&ecirc;me mais des r&eacute;sultats inattendus peuvent survenir.';
$lang['no_res'] = 'Aucun r&eacute;sultat n\'a &eacute;t&eacute; trouv&eacute;';
$lang['pat_err'] = 'Les erreurs suivantes sont survenues';
$lang['ndq_err'] = 'Au moins une apostrophe non-doubl&eacute;e a &eacute;t&eacute; trouv&eacute;e';
$lang['reg_err'] = 'La syntaxe de la regexp n\'&eacute;tait pas correcte';
$lang['unkw_err'] = 'Une erreur inattendue est survenue, vous pouvez vous rendre sur la page web du plugin pour plus d\'aide';
$lang['badopt_warn'] = 'Les options utilis&eacute;es suivantes ne sont pas valides :';
$lang['ignopt_warn'] = 'Les options suivantes sont ignor&eacutes;es car d\'autres sont plus importantes :';
$lang['badopt_err'] = 'Les options suivantes ne sont pas valides :';
$lang['restriction'] = 'La recherche a &eacute;t&eacute; restrainte aux pages/namespaces suivants :';
$lang['exclusion'] = 'Les pages/namespaces suivants ont &eacute;t&eacute; exclus de la recherche :';

$lang['call_handler_invalid'] = 'Nom de plugin invalide';
$lang['call_handler_notsupported'] = 'Plugin non trouv&eacute; ou plugin sans m&eacute;thode searchpattern (ne supporte pas searchpattern)';
$lang['call_handler_disabled'] = 'Plugin non trouv&eacute; ou plugin sans m&eacute;thode searchpattern (ne supporte pas searchpattern)';

$lang['dispheadl'] = 'Afficher un entete de tableau avec l\'expression r&eacute;guli&egrave;re dans le r&eacute;sultat.';

?>