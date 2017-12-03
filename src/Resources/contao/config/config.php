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
$GLOBALS['BE_MOD']['content']['belegungsplan']['tables'] = array('tl_belegungsplan_category', 'tl_belegungsplan_objekte', 'tl_belegungsplan_calender');
/**
* Front end modules
*/
array_insert($GLOBALS['FE_MOD'], 1, array
(
	'belegungsplan' => array
	(
		'belegungsplanlist'   => 'Mailwurm\Belegungsplan\ModuleBelegungsplanList'
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
* Register models
*/
$GLOBALS['TL_MODELS']['tl_belegungsplan_category'] = 'Mailwurm\Belegungsplan\BelegungsplanCalenderModel';
$GLOBALS['TL_MODELS']['tl_belegungsplan_objekte'] = 'Mailwurm\Belegungsplan\BelegungsplanObjektModel';
$GLOBALS['TL_MODELS']['tl_belegungsplan_calender'] = 'Mailwurm\Belegungsplan\BelegungsplanCalenderModel';
/**
* Register hooks
*/
# $GLOBALS['TL_HOOKS']['getSearchablePages'][] = array('ModuleBelegungsplan', 'getSearchablePages');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('mailwurm_belegungsplan.listener.insert_tags', 'onReplaceInsertTags');
/**
* Add permissions
*/
$GLOBALS['TL_PERMISSIONS'][] = 'belegungsplans';
$GLOBALS['TL_PERMISSIONS'][] = 'belegungsplanp';
