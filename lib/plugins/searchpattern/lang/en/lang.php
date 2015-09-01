<?php

/*****************************************************************
* SearchPattern Langage file (en)
* Author : Matthieu Rioteau (matthieu<dot>rioteau<at>skf<dot>com)
* Creation : 2009-12-16
* Releases list :
* - ver 0.1 : 2009-12-22 : Initial release
* - ver 0.2 : 2010-07-05 : Restriction/exclusion capability
* - ver 2013-06-16       : Add new option 'dispheadl' (leo)
*****************************************************************/

$lang['admin_menu_text'] = 'SearchPattern settings';

$lang['main_admin_title'] = 'SearchPattern plugin behavior settings';
$lang['ndqerr_admin_title'] = 'In case of non-doubled single quote :';
$lang['regerr_admin_title'] = 'In case of regex syntax error :';
$lang['badopt_admin_title'] = 'In case a bad option is used :';
$lang['ignopt_admin_title'] = 'In case an option shall be ignored :';
$lang['option_admin_title'] = 'In case options are used :';
$lang['dispheadl_admin_title'] = 'Show regex code in result table :';

$lang['nocatch'] = 'Do not catch the request (original text is displayed)';
$lang['error'] = 'Catch the request and display an error message';
$lang['warning'] = 'Catch the request, display a warning message and proceed';
$lang['nowarn'] = 'Catch the request and proceed (ignore fault)';
$lang['disp'] = 'Display in the result table';
$lang['nodisp'] = 'Don\'t display in the result table';

$lang['save_conf_ok'] = 'Configuration saved';
$lang['save_conf_warn'] = 'Configuration saved but default values set for some parameters';
$lang['save_conf_nowr'] = 'Configuration not saved : not able to write conf file';
$lang['save_conf_noop'] = 'Configuration not saved : not able to open conf file';
$lang['save_conf_ok_lvl'] = '1';	//message level : success
$lang['save_conf_warn_lvl'] = '2';	//message level : warning
$lang['save_conf_nowr_lvl'] = '-1';	//message level : error
$lang['save_conf_noop_lvl'] = '-1';	//message level : error

$lang['src_res'] = 'Search result for pattern';
$lang['csnormal'] = 'Case sensitive normal search';
$lang['not_csnormal'] = 'Not case-sensitive normal search';
$lang['regex'] = 'Regular expression search';
$lang['page_name'] = 'Page name';
$lang['num_match'] = 'Match(es)';
$lang['ndq_err_warn'] = 'At least one non-doubled single quote has been found.<br />Search processed anyway but unexpected results can appear.';
$lang['no_res'] = 'No result has been found';
$lang['pat_err'] = 'Following error(s) was(were) found processing the pattern';
$lang['ndq_err'] = 'At least one non-doubled single quote has been found';
$lang['reg_err'] = 'Regex syntax was not correct';
$lang['unkw_err'] = 'An unexpected error has occured, please go to plugin web page for more help';
$lang['badopt_warn'] = 'Following unknown options have been used (process will continue anyway) :';
$lang['ignopt_warn'] = 'Following options have been ignored because overwritten by others :';
$lang['badopt_err'] = 'Following unknown options are used :';
$lang['restriction'] = 'Search has been restricted to following pages/namespaces :';
$lang['exclusion'] = 'Following pages/namespaces have been excluded from search :';

$lang['call_handler_invalid'] = 'Plugin name is invalid';
$lang['call_handler_notsupported'] = 'Plugin not found or plugin doesn\'t have searchpattern handler method (doesn\'t support searchpattern)';
$lang['call_handler_disabled'] = 'Plugin not found or plugin doesn\'t have searchpattern handler method (doesn\'t support searchpattern)';

$lang['dispheadl'] = 'Display headline with regex code in result table';

?>
