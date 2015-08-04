<?php
/**
 * Helper Class for Directory Display
 * 
 * @package    	Joomla
 * @subpackage 	Modules
 * @author		Blake Kidney
 * @copyright	2015 Blake Kidney
 * @license     GNU/GPL 2, http://www.gnu.org/licenses/gpl-2.0.html
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class ModDirectoryDisplayHelper {
    
	/**
     * Constructs an array of all the files and folders in the folder and subfolders.
     *
     * @param string $directory The directory of which to search and list. 
	 * @param string $allowedExtensions A comma separated list of allowed extensions.
	 * 
	 * @return array The array of file objects.
     */    
    public static function getFileListing($directory, $allowedExtensions) {
		$listing = array();
		
		//find the correct path
		$path = is_dir($directory) ? $directory : JPATH_ROOT.'/'.trim($path, '/');
		
		//check if it exists
		if(!is_dir($path)) return $listing;
		
		//convert the path into the full real path
		$path = realpath($path);
		
		//obtain the url for the path
		$url = self::getUrlFromPath($path);
		
		//convert the allowed extensions into an array
		$exts = explode(',', preg_replace('/[^a-z0-9,]/', '', strtolower($allowedExtensions)));
		if(empty($exts)) array();		
		
		$listing = self::getFiles($path, $url, $exts); 		
		
		return $listing;
    }
	
	/**
     * Constructs an array of all the files and folders in the folder.
     *
     * @param string $path The path to the directory to scan. 
	 * @param array $exts An array of allowed extensions.
	 * 
	 * @return array The array of file objects.
     */    
    private static function getFiles($path, $url, $exts) {
		$files = array();
		
		//http://php.net/manual/en/class.directoryiterator.php
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $fileinfo) {
			//skip file if dot notation
			if($fileinfo->isDot()) continue;
			
			//pull the extension
			$ext = $fileinfo->getExtension();
			$name = $fileinfo->getFilename();
			
			//skip the file if not in the allowed extension list
			if($fileinfo->isFile() && !in_array(strtolower($ext), $exts)) continue;
			
			//create the new object to store the data about the file
			$obj = new StdClass;
			$obj->isdir = $fileinfo->isDir();
			$obj->name = htmlentities(str_replace('_', ' ', $name)); 
			$obj->path = $path.'/'.$name;
			$obj->url = $url.'/'.$name;
			$obj->size = $fileinfo->getSize();
			$obj->ext = $ext;
			
			//if this is a directory, pull the files inside
			if($fileinfo->isDir()) {
				$obj->files = self::getFiles($obj->path, $obj->url, $exts);
			}
			
			//add to the list of objects
			$files[] = $obj;
		}	
		
		//sort by directory first then file name
		usort($files, function($a, $b) {
			if($a->isdir === $b->isdir) {
				return strcasecmp($a->name, $b->name);
			}
			return ($a->isdir) ? -1 : 1;
			
		});
		
		return $files;
    }
	/**
     * Creates the http url based upon the path of the file.
     *
     * @param string $path The system path to the file or directory. 
	 * 
	 * @return string The url.
     */    
    private static function getUrlFromPath($path) {
		if(!strpos($path, $_SERVER['DOCUMENT_ROOT'])) $path = realpath($path);
		return 'http'.(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 's' : '').'://'.
				$_SERVER['HTTP_HOST'].'/'.trim(str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $path)), '/');
	}
}