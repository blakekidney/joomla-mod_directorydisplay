<?php
/**
 * Default view for Directory Display.
 * 
 * @package    	Joomla
 * @subpackage 	Modules
 * @author		Blake Kidney
 * @copyright	2015 Blake Kidney
 * @license     GNU/GPL 2, http://www.gnu.org/licenses/gpl-2.0.html
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

//echo '<pre>'.print_r($files, true).'</pre>';

function drawlist($files, $level) {
	if(empty($files)) return '';
	$html = '';
	$space = '  ';
	$tab = "\r\n".str_pad('', $level+2, $space);
	$html .= $tab.'<ul class="level-'.$level.'">';
	foreach($files as $file) {				
		if($file->isdir) {
			if(empty($file->files)) continue;
			$html .= $tab.$space.'<li class="folder">';
			$html .= $tab.$space.$space.'<div class="toggle icon-folder">'.$file->name.'</div>';
			$html .= drawlist($file->files, $level+1);
		} else {
			$html .= $tab.$space.'<li class="file">';
			$html .= $tab.$space.$space.'<a class="icon-file" href="'.$file->url.'" '.
					 'target="_blank" download="download">'.$file->name.'</a>';
		}
		$html .= $tab.$space.'  </li>';
	}
	$html .= $tab.'</ul>'.$tab;
	return $html;
}

echo '<div class="directorydisplay">'.drawlist($files, 1).'</div>';

