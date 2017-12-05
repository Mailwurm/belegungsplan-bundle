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
* Style sheet
*/
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/mailwurmbelegungsplan/style.css|static';
}
/**
* Add permissions
*/
$GLOBALS['TL_PERMISSIONS'][] = 'belegungsplans';
$GLOBALS['TL_PERMISSIONS'][] = 'belegungsplanp';
