<?php
/**
 * Directory Display
 * 
 * @package    	Joomla
 * @subpackage 	Modules
 * @author		Blake Kidney
 * @copyright	2015 Blake Kidney
 * @license     GNU/GPL 2, http://www.gnu.org/licenses/gpl-2.0.html
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the helper functions only once
require_once( dirname(__FILE__).'/helper.php' );

// Advanced
$moduleClassSuffix = $params->get('moduleclass_sfx', '');

//pull a list of the courses descriptions
$files = ModDirectoryDisplayHelper::getFileListing($params->get('directory'), $params->get('extensions'));

require( JModuleHelper::getLayoutPath('mod_directorydisplay', $params->get('layout', 'default')) );
