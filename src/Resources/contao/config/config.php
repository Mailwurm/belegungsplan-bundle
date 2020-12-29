<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0-or-later
*/
/**
* Add back end modules
*/
$arrBeleg1 = array(
	'beleg' => array
	(
		'belegung' => array
		(
			'tables'      => array('tl_belegungsplan_category', 'tl_belegungsplan_objekte', 'tl_belegungsplan_calender')
		),
		'feiertage' => array
		(
			'tables'      => array('tl_belegungsplan_feiertage')
		)
	)
);
$arrBeleg2 = $GLOBALS['BE_MOD'];
$GLOBALS['BE_MOD'] = array_merge($arrBeleg1, $arrBeleg2);

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
