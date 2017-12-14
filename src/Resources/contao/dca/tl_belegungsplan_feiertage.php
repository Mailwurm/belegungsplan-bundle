<?php
 /**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */

/**
* Load tl_content language file
*/
System::loadLanguageFile('tl_content');
 
/**
 * Table tl_belegungsplan_feiertage
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_feiertage'] = array
(

);

 /**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class tl_belegungsplan_feiertage extends Backend
{
	 /**
	 * Import the back end user object
	 */
	public function __construct() {
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
}
