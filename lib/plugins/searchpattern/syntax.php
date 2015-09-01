<?php

/*****************************************************************
 * SearchPattern plugin for dokuwiki / Syntax plugin
 *
 * Syntax :
 *   ~~SEARCHPATTERN(:|;|#)\'[pattern or regexp to search]\'~~
 *   ~~SEARCHPATTERN:\'myString\'~~ -> search "myString" - case sensitive
 *   ~~SEARCHPATTERN;\'myString\'~~ -> search "myString" - case insensitive
 *   ~~SEARCHPATTERN#\'myRegex\'~~ -> search myRegex
 *   ~~SEARCHPATTERN#'/======([^=]+)======/'~~ -> search all headlines and output the headlines
 *
 * In combination with dokuwiki todo plugin version (at least v20130408),
 * it is a lightweight solution for a task management system based on dokuwiki.
 * use this searchpattern expression for open todos: 
 *     ~~SEARCHPATTERN#'/<todo[^#>]*>.*?<\/todo[\W]*?>/'?? _ToDo ??~~
 * use this searchpattern expression for completed todos: 
 *     ~~SEARCHPATTERN#'/<todo[^#>]*#[^>]*>.*?<\/todo[\W]*?>/'?? _ToDo ??~~
 * do not forget the no-cache option
 *     ~~NOCACHE~~ 
 *
 * Options are passed by adding them between two times '??' after last single quote and before double tilde.
 * Regex syntax is strictly the same as the one used with PHP "preg_match" function.
 * !!! In all cases, every single quote inside the string/regex shall be doubled. !!!
 *
 * Valid Options (between the double ?? questionmarks):
 *     -  restricting option (page or namespace exclude)
 *     +  limit option (only page or namespace included)
 *     $  output all regex matches
 *     $<Matches>  output given comma separated regex matches e.g. $3,1 will output match 3 and 1
 *     _  call a other dokuwiki syntax plugin to format the matching/output
 *
 * Example:
 *     ~~SEARCHPATTERN#'/<todo[^#>]*#[^>]*>.*?<\/todo[\W]*?>/'?? _ToDo ??~~
 *         this will search all <todo #>Some Todo</todo> tags and call the todo plugin (option _ToDo) for outputting
 *     ~~SEARCHPATTERN#'/([\W]+)[\W]+([\W]+)[\W]+([\W]+)[\W]+/'?? $1,3 ??~~
 *         this will only output the 1st and the 3rd regex match
 *     ~~SEARCHPATTERN#'/<todo[^@>]*@([^\W]+)[^#>]*(#)?[^>]*>(.*?)<\/todo[\W]*?>/'?? $2,1,3 ??~~
 *         the matches will displayed in the following order: 2nd match, 1st match, 3rd match
 *         this will output all assigned todos: the # Flag (todo completed), the username and the todo text
 *         as example input: <todo @leo #>Finished task for leo</todo> <todo>Some task</todo> <todo @leo>Uncompleted task for leo</todo>
 *                   output:   | # | leo | Finished task for leo    |
 *                             |   | leo | Uncompleted task for leo |
 *     ~~SEARCHPATTERN#'/FIXME[ \t]+([^ \t\n\r]+)([ \t]*)?([^ \t\n\r]+)?/i'?? $3,1 ??~~ 
 *         will display one or two words after the word FIXME in reverse direction
 *         as example input:  FIXME firstWord secondWord
 *                   output:  | secondWord | firstWord |
 *
 *
 * Compatibility:
 *     Release 2013-03-06 "Weatherwax RC1"
 *     Release 2012-10-13 "Adora Belle"
 *
 * @author     Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com>; Leo Eibler <dokuwiki@sprossenwanne.at>  
 *
 */
  
/**
 * ChangeLog:
 *
 * [06/16/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               bugfix: implement suggestions from Matthieu and use correct 'badopt' configuration from admin panel
 *               implement new admin option 'dispheadl' to show or hide regex code in result table
 * [06/16/2013]: by Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com> / http://wiki.splitbrain.org/plugin:searchpattern
 *               bugfix: incorrect XHTML or PHP warnings in log
 *               include a better default.php configuration file
 * [04/15/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               translation of language file to german
 * [04/15/2013]: by Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com> / http://wiki.splitbrain.org/plugin:searchpattern
 *               bugfix: incorrect XHTML or PHP warnings in log
 *               bugfix: quickaclcheck only handles pages (not namespaces) 
 * [04/12/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               bugfix: incorrect if statement using $ syntax
 *               example using FIXME and $3,1 
 *               bugfix: use parameter call_plugin_handler and fallback to lowercase if plugin not found
 * [04/11/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               change description / comments and syntax howto about integration with dokuwiki plugin 'todo'
 *               bugfix: encoding html code (security risk <script>alert('hi')</script>) when using regex and match output $ (dollar) option.
 *               bugfix: default behavior (output only count) if no $ (dollar) is used
 * [04/08/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               add description / comments and syntax howto about integration with dokuwiki plugin 'todo'
 *               check compatibility with dokuwiki release 2012-10-13 "Adora Belle"  and 2013-03-06 "Weatherwax RC1"
 *               reformat inline documentation of syntax.php file
 *               remove getInfo() call because it's done by plugin.info.txt (since dokuwiki 2009-12-25 "Lemming") 
 * [04/07/2013]: by Leo Eibler <dokuwiki@sprossenwanne.at> / http://www.eibler.at
 *               add regex match output with new option $ (dollar)
 *               add callback handler method to call other plugin for formatting the output with new option _ (underscore)
 * [07/05/2010]: by Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com> / http://wiki.splitbrain.org/plugin:searchpattern
 *               Add capability to exclude pages/namespaces from search, or to restrict it to certain pages/namespaces
 * [01/05/2010]: by Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com> / http://wiki.splitbrain.org/plugin:searchpattern
 *               Initial release
 * [12/10/2009]: by Matthieu Rioteau <matthieu<dot>rioteau<at>skf<dot>com> / http://wiki.splitbrain.org/plugin:searchpattern
 *               Creation
 */ 

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/search.php');	//needed for use of the "search" function to list pages
require_once(DOKU_INC.'inc/common.php');	//needed for use of "wl' function

/**
* Convert a string to a regex so it can be used in PHP "preg_match" function
*/
function str2regex($str){
	$regex = '';	//init
	for($i = 0; $i < strlen($str); $i++){	//for each char in the string
		if(!ctype_alnum($str[$i])){	//if char is not alpha-numeric
			$regex = $regex.'\\';	//escape it with a backslash
		}
		$regex = $regex.$str[$i];	//compose regex
	}
	return $regex;	//return
}

/**
* Callback function for "search" function
* Look for matches in wiki files and store them
*/
function search_pattern(&$data, $base, $file, $type, $lvl, $opts) {
	global $INFO;
	$id = pathID($file);	//get current file ID
	if($type == 'd'){	//if type is directory
		return true; //recurse but don't process
	}
	if(auth_quickaclcheck($id) < AUTH_READ) {	//if user don't have enough rights
		return false;	//don't processa and don't recurse
	}
	if(!preg_match("/.*\.txt$/", $file)) {  //if file is not a true wiki file (.txt)
		return true;	//don't process
	}
	if(isset($opts['page_limit']) || isset($opts['nmsp_limit'])){	//if limiting options have been used
		$process = false;	//page is not processed by default : will be true if page shall be processed
		if(isset($opts['page_limit']))
		{
			foreach($opts['page_limit'] as $page){	//going through limiting page list
				if($id == $page){	//if the analyzed page is in the list
					$process = true;	//process it
					break;
				}
			}
		}
		if(!$process){	//if analyzed page wasn't in the page list
			if(isset($opts['nmsp_limit']))
			{
				foreach($opts['nmsp_limit'] as $nmsp){	//going through the limiting namespace list
					if(substr($id,0,strlen($nmsp)) == $nmsp){	//if analyzed page is in the list
						$process = true;	// process it
						break;
					}
				}
			}
		}
		if(!$process){	//if page shall not be processed
			return true;	//recurse but don't process
		}
	}
	if(isset($opts['page_exclude']) || isset($opts['nmsp_exclude'])){	//if restricting option have been used
		if(isset($opts['page_exclude'])) {
			foreach($opts['page_exclude'] as $page){	//going through the restricting page list
				if($id == $page){	//if analyzed page is in the exclusion list
					return true;	//recurse but don't process
				}
			}
		}
		if(isset($opts['nmsp_exclude'])) {
			foreach($opts['nmsp_exclude'] as $nmsp){	//going through the restricting namespace list
			  if(substr($id,0,strlen($nmsp)) == $nmsp){	//if analyzed page is in the exclusion list
				return true;	//recurse but don't process
			  }
			}
		}
	}
	$filebody = file_get_contents($base.$file);	//get file content
	if($INFO['id'] == $id){	//if we are processing the page in which plugin has been called
		$filebody = str_replace($opts['match'], '', $filebody, $count);	//remove the call to avoid counting it
		$count--;	//hold number of extra pattern occurences that should have been unvolunteerly removed
	}
	else{
		$count = 0;	//for correct calculation
	}
	$nboccur = preg_match_all($opts['pattern'], $filebody, $matches) + $count;	//count how many times appears the pattern
	if($nboccur != 0){	//if it appears at least once
		$data[$id] = $nboccur;	//store it in data
		if( count($matches) > 0 ) {
			// if at least 1 match () is found
			$data['{'.$id.'}'] = $matches;
		}
	}
	return true;	//return and continue processing
}

/**
* All DokuWiki plugins to extend the parser/rendering mechanism
* Need to inherit from this class
*/
class syntax_plugin_searchpattern extends DokuWiki_Syntax_Plugin {
	/**
	* Return some info
	*/
	/*
	function getInfo(){
		// replaced by plugin.info.txt file
		return array(
				'author' => 'Matthieu Rioteau',
				'email'  => 'matthieu<dot>rioteau<at>skf<dot>com',
				'date'   => '2010-07-05',
				'name'   => 'SearchPattern plugin ver. 0.2',
				'desc'   => 'Find a specified pattern inside wiki pages.
				syntax : ~~SEARCHPATTERN(:|;|#)\'[pattern or regexp to search]\'~~
				~~SEARCHPATTERN:\'myString\'~~ -> search "myString" - case sensitive
				~~SEARCHPATTERN;\'myString\'~~ -> search "myString" - case insensitive
				~~SEARCHPATTERN#\'myRegex\'~~ -> search myRegex
				Regex syntax is strictly the same as the one used with PHP "preg_match" function.
				In all cases, every single quote inside the string/regex shall be doubled.
				Options can be passed to limit pages/namespaces search. See website.',
				'url'    => 'http://wiki.splitbrain.org/plugin:searchpattern',
		);
	}
	*/

	/**
	* Plugin is a substitution one : typo is volunteer
	*/
	function getType(){
		return 'substition';
	}

	/**
	* Paragraph type is "normal"
	*/
	function getPType(){
		return 'normal';
	}

	/**
	* Sort order (don't know where it is used)
	*/
	function getSort(){
		return 250;     //randon number, don't know what to put
	}


	/**
	* Register the ID pattern to the lexer
	*/
	function connectTo($mode) {
		$this->Lexer->addSpecialPattern('~~SEARCHPATTERN[\;\:\#]\'(?:\'\')*[^\r\v\t\r\n]*[^\']\'(?:\'\')*(?:\?\?[^\r\v\t\r\n\?]+\?\?)?~~', $mode, 'plugin_searchpattern');
	}

	/**
	* Handle the match
	*/
	function handle($match, $state, $pos, &$handler){
	global $INFO;

		$params = array();	//store all parameters needed for the render computing
		$params['match'] = $match;	//store the original matching string
		$params['reg_err'] = false;  //init needed for future comparison
		$params['regex_output_matches'] = false; // default behavior if no $ (dollar) is used
		$params['call_plugin_handler'] = false;
		if(substr($match,-4,2) == '??'){	//if options are passed
			$options = substr($match, 0, -4);	//extract options ...
			$match = substr($options, 0, strrpos($options,'??')).'~~';	//...
			$options = substr($options, strrpos($options,'??')+2);	//...
			if($options != ""){
				$options_list = explode(' ', $options);	//explode options in an array
				$limit = false;	//init : $limit will be true if a limiting option is passed
				foreach($options_list as $optid => $option){	//going through the options to clean and pretreat
					if($option == ""){	//remove empty ones...
						unset($options_list[$optid]);	//...
					}
					if($option[0] == "+"){	//if a limiting option is used
						$limit = true;	//update flag
					}
				}
				foreach($options_list as $option){	//going through the options to treat them
					$optact = $option[0];	//action is defined by first character
					switch($optact){
						// @date 20130407 by Leo Eibler <dokuwiki@sprossenwanne.at> extend output of matches with $
						case '$':	//if it is a regex with displaying option of matches
							if(substr($option,1) == ""){	//if nothing more, we will output all matches
								$params['regex_output_matches'] = array();
							} else {
								// take match numbers as comma separated list
								$params['regex_output_matches'] = explode( ',', substr($option,1) );
							}
							break;
						case '_':	//call the _searchpatternHandler() method from the given plugin
							if(substr($option,1) == ""){	//no plugin defined
								// we cannot call a handler if the plugin name is not defined
							} else {
								$params['call_plugin_handler'] = substr($option,1);
							}
							break;
						case '+':	//if it is a limiting option
							if(substr($option,1) == ""){	//if nothing more
								$params['page_limit'][] = $INFO['id'];	//add current page to limiting
							}
							elseif(substr($option,1) == ":"){	//if ':'
								$params['nmsp_limit'][] = substr($INFO['id'],0,strrpos($INFO['id'],":")+1);	//add current namespace to limiting
							}
							elseif($option[strlen($option)-1] == ":"){	//if parameter is a namespace
								$params['nmsp_limit'][] = substr($option,1);	//add to limiting namespace list
							}
							else{
								$params['page_limit'][] = substr($option,1);	//add to limiting page list
							}
							break;
						case '-':	//if it is a restricting option
							if($limit){	//if a limiting option is also used
								$params['ignored_options'][] = $option;	//restricting options will be ignored -> store them
							}
							else{
								if(substr($option,1) == ""){	// if nothing more
									$params['page_exclude'][] = $INFO['id'];	//add current page to restricting
								}
								elseif(substr($option,1) == ":"){	//if ':'
									$params['nmsp_exclude'][] = substr($INFO['id'],0,strrpos($INFO['id'],":")+1);	//add current namespace to restricting
								}
								elseif($option[strlen($option)-1] == ":"){	//if parameter is a namespace
									$params['nmsp_exclude'][] = substr($option,1);	//add to restricting namespace list
								}
								else{
									$params['page_exclude'][] = substr($option,1);	//add to page restricting list
								}
							}
							break;
						default:
							$params['bad_options'][] = $option;	//store unknown options
					}
				}
			}
		}
		$pattern = substr($match, 17, -3);	//extract the pattern we are searching
		if(preg_match('/[^\']\'(\'\')*[^\']/', $pattern, $matches)){	//if there is at least one non-doubled single quote in the pattern
			$params['ndq_err'] = true;	//store error
		}
		else{
			$params['ndq_err'] = false;	//or correctness
		}
		$pattern=str_replace('\'\'', '\'', $pattern);	//remove doubled quote from pattern
		$params['or_pattern'] = $pattern;	//and store it as original one
		switch($match[15]){	//determine the type of search and subsequent treatment
			case ':':	//this a normal case-sensitive search
				$params['type'] = 'normal';	//type is normal
				$params['cs'] = 'cs';	//case-sensitive
				$pattern = '/'.str2regex($pattern).'/';	//convert pattern to regex
				break;
			case ';':	//this a normal not case-sensitive search
				$params['type'] = 'normal'; //type is normal
				$params['cs'] = 'not_cs';  //not case-sensitive
				$pattern = '/'.str2regex($pattern).'/i';	//convert pattern to regex
				break;
			case '#':	//this a regex search
				$params['type'] = 'regex';	//type is regex
				$params['cs'] = ''; //no case sensitivity for regex
				if(!preg_match('/^\/.*\/[msixg]*$/', $pattern)){	//if regex is not correctly syntaxed
					$params['reg_err'] = true;	//store regex error
				}
				break;
			default:	//normally not reachable but we never know
				$params['type'] = 'undef';
		}
		$params['pattern'] = $pattern;	//store the final pattern that we use for searching
		return $params;	//return with parameters
	}

	/**
	* Create output render
	*/
	function render($format, &$renderer, $data) {
		global $conf;
		if($format == 'xhtml'){
			if(($data['type'] != 'undef') && ($data['ndq_err'] == false || $this->getConf('ndqerr') == 'warning' || $this->getConf('ndqerr') == 'nowarn') && ($data['type'] != 'regex' || $data['reg_err'] == false) && (!isset($data['bad_options']) || $this->getConf('badopt') == 'warning' || $this->getConf('badopt') == 'nowarn') && (!isset($data['ignored_options']) || $this->getConf('ignopt') == 'warning' || $this->getConf('ignopt') == 'nowarn')){	//if all conditions are ok
				$data['cond_ok'] = true;
				//definition : function search(&$data,$base,$func,$opts,$dir='',$lvl=1)
				search($wikidata, $conf['datadir'], search_pattern, $data);	//browse wiki pages with callback to search_pattern
			}
			else{
				$data['cond_ok'] = false;
			}
			$this->report($wikidata, $renderer, $data);
			return true;	//return
		}
		return false;	//return
	}

	/**
	* Create the report table
	*/
	function report($data, &$renderer, $params){
		if( $params['cond_ok'] ) {	//if the search has been done
			// if call_plugin_handler is active 
			$xPlugin = null;
			if( !empty($params['call_plugin_handler']) ) {
				// try to load the plugin and check if it is enabled for searchpattern callback handler
				// therefor a method '_searchpatternHandler' in syntax plugin must exist
				$badoptWarnErrorCssClass = '';
				if( $this->getConf('badopt') == 'error' ) {
					$badoptWarnErrorCssClass = 'sp_error';
				} else
				if( $this->getConf('badopt') == 'warning' ) {
					$badoptWarnErrorCssClass = 'sp_warning';
				}
				$callPluginHandlerError = false;
				if( preg_match( '/[^a-zA-Z0-9]+/i', $params['call_plugin_handler'], $temp ) > 0 ) {
					//$renderer->doc .= '<div class="sp_main">';
					if( !empty($badoptWarnErrorCssClass) ) {
						$renderer->doc .= '<div class="'.$badoptWarnErrorCssClass.'"><span class="'.$badoptWarnErrorCssClass.'_pat">'.htmlspecialchars($params['call_plugin_handler']).'</span> :: '.$this->getLang('call_handler_invalid').'<br /></div>';	//write error message
					}
					$callPluginHandlerError = true;
					//$renderer->doc .= '</div>';	//close error
				} else {
					if( plugin_isdisabled( $params['call_plugin_handler'] ) ) {
						// @date 20130411 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: fallback to lowercase
						// plugin_isdisabled will return true if plugin not exists - so try with lowercase
						$params['call_plugin_handler'] = strtolower($params['call_plugin_handler']);
					}
					if( !plugin_isdisabled( $params['call_plugin_handler'] ) ) {
						// @date 20130411 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: use the paramter call_plugin_handler
						$xPlugin =& plugin_load('syntax', $params['call_plugin_handler'] );
						if( $xPlugin && method_exists( $xPlugin, '_searchpatternHandler' ) ) {
							//$renderer->doc .= $xPlugin && $xPlugin->_searchpatternHandler();
						} else {
							//$renderer->doc .= '<div class="sp_main">';
							if( !empty($badoptWarnErrorCssClass) ) {
								$renderer->doc .= '<div class="'.$badoptWarnErrorCssClass.'"><span class="'.$badoptWarnErrorCssClass.'_pat">'.htmlspecialchars($params['call_plugin_handler']).'</span> :: '.$this->getLang('call_handler_notsupported').'<br /></div>';	//write error message
							}
							$callPluginHandlerError = true;
							//$renderer->doc .= '</div>';	//close error
						}
					} else {
						//$renderer->doc .= '<div class="sp_main">';
						if( !empty($badoptWarnErrorCssClass) ) {
							$renderer->doc .= '<div class="'.$badoptWarnErrorCssClass.'"><span class="'.$badoptWarnErrorCssClass.'_pat">'.htmlspecialchars($params['call_plugin_handler']).'</span> :: '.$this->getLang('call_handler_disabled').'<br /></div>';	//write error message
						}
						$callPluginHandlerError = true;
						//$renderer->doc .= '</div>';	//close error
					}
				}
			}
			if( $callPluginHandlerError && $this->getConf('badopt') == 'nocatch' ) {
				// there was something wrong to call the plugin handler (maybe not implemented or plugin is disabled).
				// but the user has configured to ignore this and output the original text
				$renderer->doc .= htmlspecialchars($params['match']);	//in all remaining cases, display the original text
				return;
			}
			if( $callPluginHandlerError && $this->getConf('badopt') == 'error' ) {
				return;
			}
			
			// now process the data
			// after processing: 
			//   data should hold array( $page => count of matches ); regex matches are stripped
			//   matches should hold array( $page => matches from regex );
			$matches = array();
			if( $data ) {	//if there are search results
				// @date 20130407 by Leo Eibler <dokuwiki@sprossenwanne.at> extend output of regex matches () with command $
				// @date 20130411 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: default behavior (output only count) if no $ (dollar) is used
				if( is_array($params['regex_output_matches']) && count($params['regex_output_matches']) == 0 ) {
					$params['regex_output_matches'] = array(); // as default we will use all matches
				}
				foreach( $data as $page => $count ) {	//for each result
					// @date 20130407 by Leo Eibler <dokuwiki@sprossenwanne.at> extend output of regex matches () with command $
					if( substr( $page, 0, 1 ) == '{' && substr( $page, -1 ) == '}' ) {
						// skip this one - it's for the regex matching result
					} else {
						if( isset( $data['{'.$page.'}'] ) ) {
							$matches[$page] = $data['{'.$page.'}'];
							unset($data['{'.$page.'}']);
						}
					}
				}
			}
			// now check if the partner plugin handles all of the output itself
			if( $xPlugin && $xPlugin->_searchpatternHandler( 'wholeoutput', $renderer, $data, $matches, $params ) ) {
				return;
			}
			//
			
			$renderer->doc .= '<div class="sp_main">';
			$renderer->doc .= '<table class="inline sp_main_table">';	//create table
			if( $this->getConf('dispheadl') == 'nodisp' ) {
			} else {
				$renderer->doc .= '<tr class="sp_title"><th colspan="2" class="sp_title">'.$this->getLang('src_res').' : <span class="sp_src">'.htmlspecialchars($params['or_pattern']).'</span><br /><span class="sp_src_params">'.$this->getLang($params['cs'].$params['type']).'</span></th></tr>';	//write table title
			}
			if($this->getConf('option') == 'disp' && (isset($params['page_limit']) || isset($params['nmsp_limit']) || isset($params['page_exclude']) || isset($params['nmsp_exclude']))){	//if limiting/restricting options are used and we shall display them
				$renderer->doc .= '<tr class="sp_options"><td colspan="2" class="sp_options">';
				if(isset($params['page_limit']) || isset($params['nmsp_limit'])){	//if limiting type
					$renderer->doc .= $this->getLang('restriction').'<ul>';
					if(isset($params['page_limit'])) {
						foreach($params['page_limit'] as $page){
							$renderer->doc .= '<li>'.$page.'</li>';
						}
					}
					if(isset($params['page_limit'])) {
						foreach($params['nmsp_limit'] as $nmsp){
							$renderer->doc .= '<li>'.$nmsp.'</li>';
						}
					}
					$renderer->doc .= '</ul>';
				}
				if(isset($params['page_exclude']) || $params['nmsp_exclude']){	//if excluding type
					$renderer->doc .= $this->getLang('exclusion').'<ul>';
					if(isset($params['page_exclude']))
					{
						foreach($params['page_exclude'] as $page){
							$renderer->doc .= '<li>'.$page.'</li>';
						}
					}
					if(isset($params['nmsp_exclude']))
					{
						foreach($params['nmsp_exclude'] as $nmsp){
							$renderer->doc .= '<li>'.$nmsp.'</li>';
						}
					}
					$renderer->doc .= '</ul>';
				}
				$renderer->doc .= '</td></tr>';
			}
			if($params['ndq_err'] == true && $this->getConf('ndqerr') == 'warning'){	//if there is a ndq error and we shall warn
				$renderer->doc .= '<tr class="sp_warning"><td colspan="2" class="sp_warning">'.$this->getLang('ndq_err_warn').'</td></tr>';	//so warn
			}
			if(isset($params['bad_options']) && $this->getConf('badopt') == 'warning'){	//if an unknown option is used and we shall warn
				$renderer->doc .= '<tr class="sp_warning"><td colspan="2" class="sp_warning">'.$this->getLang('badopt_warn').'<br><ul>'; //warn and
				foreach($params['bad_options'] as $badopt){
					$renderer->doc .= '<li>'.$badopt.'</li>';	//display the bad options list
				}
				$renderer->doc .= '</td></tr>';
			}
			if(isset($params['ignored_options']) && $this->getConf('ignopt') == 'warning'){ //if an option has been ignored
				$renderer->doc .= '<tr class="sp_warning"><td colspan="2" class="sp_warning">'.$this->getLang('ignopt_warn').'<br><ul>'; //warn and
				foreach($params['ignored_options'] as $ignopt){
				  $renderer->doc .= '<li>'.$ignopt.'</li>'; //display the ignored options list
				}
				$renderer->doc .= '</td></tr>';
			}
			if( $data ) {	//if there are search results
				// @date 20130407 by Leo Eibler <dokuwiki@sprossenwanne.at> extend output of regex matches () with command $
				// @date 20130411 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: default behavior (output only count) if no $ (dollar) is used
				if( is_array($params['regex_output_matches']) && count($params['regex_output_matches']) == 0 ) {
					$params['regex_output_matches'] = array(); // as default we will use all matches
				}
				$renderer->doc .= '<tr class="sp_col_head"><th class="sp_col_head">'.$this->getLang('page_name').'</th><th class="sp_col_head">'.$this->getLang('num_match').'</th></tr>';	//write column headers
				foreach($data as $page => $count){	//for each result
					$renderer->doc .= '<tr class="sp_result"><td class="sp_page"><a href="'.wl($page).'">'.$page.'</a></td><td class="sp_count">';
					
					if( $xPlugin && $xPlugin->_searchpatternHandler( 'intable:whole', $renderer, $data, $matches, $params, $page ) ) {
						// the partner plugin handles all the inner table output itself - skip searchpattern output
					} else {
						if( $xPlugin ) {
							$xPlugin->_searchpatternHandler( 'intable:prefix', $renderer, $data, $matches, $params, $page );
						}
						// @date 20130411 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: default behavior (output only count) if no $ (dollar) is used
						// @date 20130412 by Leo Eibler <dokuwiki@sprossenwanne.at> bugfix: incorrect if statement
						if( isset( $matches[$page] ) && is_array($params['regex_output_matches']) && count($params['regex_output_matches']) >= 0 ) {
							$match = $matches[$page];
							if( count($match) > 1 ) {
								$renderer->doc .= '<table>';
								$regex_output_matches = $params['regex_output_matches'];
								if( count($regex_output_matches) == 0 ) {
									// no match numbers given, use all existing, but strip 0 
									$regex_output_matches = array_keys( $match );
									array_shift($regex_output_matches);
								}
								for( $i=0; $i<count($match[0]); $i++ ) {
									if( !isset( $match[0][$i] ) ) {
										continue;
									}
									$renderer->doc .= '<tr class="sp_result">';
									foreach( $regex_output_matches as $j ) {
										$renderer->doc .= '<td class="'.( isset($match[$j][$i] ) ? 'sp_count' : 'sp_nores' ).'">';
										// does the partner plugin handle the inner table output itself?
										if( $xPlugin ) {
											if( !$xPlugin->_searchpatternHandler( 'intable:match', $renderer, $data, $matches, $params, $page, $match[$j][$i] ) ) {
												$renderer->doc .= ( isset($match[$j][$i] ) ? htmlspecialchars($match[$j][$i]) : '' );
											}
										} else {
											$renderer->doc .= ( isset($match[$j][$i] ) ? htmlspecialchars($match[$j][$i]) : '' );
										}
										$renderer->doc .= '</td>';
									}
									$renderer->doc .= '</tr>';
								}
								$renderer->doc .= '</table>';
							} else {
								if( $xPlugin ) {
									if( !$xPlugin->_searchpatternHandler( 'intable:count', $renderer, $data, $matches, $params, $page, $count ) ) {
										$renderer->doc .= $count;
									}
								} else {
									$renderer->doc .= $count;
								}
							}
						} else {
							if( $xPlugin ) {
								if( !$xPlugin->_searchpatternHandler( 'intable:count', $renderer, $data, $matches, $params, $page, $count ) ) {
									$renderer->doc .= $count;
								}
							} else {
								$renderer->doc .= $count;
							}
						}
						if( $xPlugin ) {
							$xPlugin->_searchpatternHandler( 'intable:suffix', $renderer, $data, $matches, $params, $page );
						}
					} // END the partner plugin handles all the inner table output itself - skip searchpattern output
					$renderer->doc .= '</td></tr>';	// display it
				}
			} else {
				// no result
				$renderer->doc .= '<tr class="sp_result"><td colspan="2" class="sp_nores">';
				if( $xPlugin ) {
					$xPlugin->_searchpatternHandler( 'intable:prefix', $renderer, $data, $matches, $params, $page );
				}
				if( $xPlugin && $xPlugin->_searchpatternHandler( 'intable:noresult', $renderer, $data, $matches, $params, $page ) ) {
					$renderer->doc .= $this->getLang('no_res');
				}
				if( $xPlugin ) {
					$xPlugin->_searchpatternHandler( 'intable:suffix', $renderer, $data, $matches, $params, $page );
				}
				$renderer->doc .= '</td></tr>';	// write there is not any result
			}
			$renderer->doc .= '</table></div>';	//close table
		} else {
			// error
			if(($this->getConf('ndqerr') == 'error' && $params['ndq_err'] == true) || ($this->getConf('regerr') == 'error' && $params['reg_err'] == true) || ($this->getConf('badopt') == 'error' && isset($params['bad_options']))){	//if there is an error that shall be displayed
				$renderer->doc .= '<div class="sp_error"><span class="sp_error_pat">'.htmlspecialchars($params['match']).'</span> :: '.$this->getLang('pat_err').' :<br /><ul class="sp_error">';	//write error message
				$err_found = false;	//true if the error is known
				if($params['ndq_err'] == true && $this->getConf('ndqerr') == 'error'){	//if the error is ndq type
					$renderer->doc .= '<li class="sp_error">'.$this->getLang('ndq_err').'</li>';	//display error
					$err_found = true;	//we know the error
				}
				if($params['type'] == 'regex' && $params['reg_err'] == true && $this->getConf('regerr') == 'error'){	//if the error is reg type
					$renderer->doc .= '<li class="sp_error">'.$this->getLang('reg_err').'</li>';	//display error
					$err_found = true;	//we know the error
				}
				if(isset($params['bad_options']) && $this->getConf('badopt') == 'error'){	//if the error is a ba doption
					$renderer->doc .= '<li class="sp_error">'.$this->getLang('badopt_err');	//display error
					foreach($params['bad_options'] as $badopt){
						$renderer->doc .= ' '.$badopt;	//display the bad option(s)
					}
					$renderer->doc .= '</li>';
					$err_found = true; //we know the error
				}
				if($err_found == false){	//if the error is unknown type
					$renderer->doc .= '<li class="sp_error">'.$this->getLang('unkw_err').'</li>';	//display a message
				}
				$renderer->doc .= '</ul></div>';	//close error
			}
			else
			{
				$renderer->doc .= htmlspecialchars($params['match']);	//in all remaining cases, display the original text
			}
		}
	}


}

?>