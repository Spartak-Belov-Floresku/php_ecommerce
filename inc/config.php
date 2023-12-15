<?php

if(!isset($_SESSION)){
	session_start();
}

// site domain name with http
defined("SITE_URL")
	|| define("SITE_URL","http://".$_SERVER['SERVER_NAME']);

//directory separator
defined("DS")
	|| define("DS",DIRECTORY_SEPARATOR);
	
//root path
defined("ROOT_PATH")
	|| define("ROOT_PATH",realpath(dirname(__FILE__) . DS."..".DS));
	
//classes folder
defined("CLASSES_DIR")
	|| define("CLASSES_DIR","classes");

//pages directory
defined("PAGES_DIR")
	|| define("PAGES_DIR","pages");
	
//modules folder
defined("MOD_DIR")
	|| define("MOD_DIR","mod");
	
//inc folder
defined("INC_DIR")
	|| define("INC_DIR","inc");

//templates folder
defined("TEMPLATE_DIR")
	|| define("TEMPLATE_DIR","template");
	
//emails path
defined("EMAILS_PATH")
	|| define("EMAILS_PATH",ROOT_PATH.DS."emails");
	
//catalogue images path
defined("CATALOGUE_PATH")
	|| define("CATALOGUE_PATH",ROOT_PATH.DS."media".DS."catalogue");

//catalogue images path
defined("SLIDESHOW_PATH")
	|| define("SLIDESHOW_PATH",ROOT_PATH.DS."media".DS."slideshow");

defined("MENU_PATH")
	|| define("MENU_PATH",ROOT_PATH.DS."template".DS);
	
defined("MENU_PATH_IMAGE")
	|| define("MENU_PATH_IMAGE",ROOT_PATH.DS."media".DS."menu");
	
//add all above directories to the include path
set_include_path(implode(PATH_SEPARATOR, array(
		realpath(ROOT_PATH.DS.CLASSES_DIR),
		realpath(ROOT_PATH.DS.PAGES_DIR),
		realpath(ROOT_PATH.DS.MOD_DIR),
		realpath(ROOT_PATH.DS.INC_DIR),
		realpath(ROOT_PATH.DS.TEMPLATE_DIR),
		get_include_path()
		
)));
/*print(set_include_path(implode(PATH_SEPARATOR, array(
		realpath(ROOT_PATH.DS.CLASSES_DIR),
		realpath(ROOT_PATH.DS.PAGES_DIR),
		realpath(ROOT_PATH.DS.MOD_DIR),
		realpath(ROOT_PATH.DS.INC_DIR),
		realpath(ROOT_PATH.DS.TEMPLATE_DIR),
		get_include_path()
		
))));*/
?>