<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
/**
* Add back end modules
*/
array_insert($GLOBALS['BE_MOD']['content'], 99, array
(
	'belegung' => array
	(
		'tables'      => array('tl_belegungsplan_category', 'tl_belegungsplan_objekte', 'tl_belegungsplan_calender')
	)
));
/**
* Front end modules
*/
array_insert($GLOBALS['FE_MOD'], 99, array
(
	'belegung' => array
	(
		'belegungsplan'   => 'Mailwurm\Belegung\ModuleBelegungsplan'
	)
));
/**
* Style sheet Backend
*/
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/mailwurmbelegungsplan/style.css|static';
}
/**
* Style sheet Frontend
*/
if (TL_MODE == 'FE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/mailwurmbelegungsplan/belegungsplan.css|static';
}
/**
 * Front end form fields
 */
$GLOBALS['TL_FFL'] = array
(
	'belegungsplancategoryselect' => 'FormBelegungsplanCategorySelect'
);
