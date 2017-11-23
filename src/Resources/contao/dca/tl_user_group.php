<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/

/**
* Extend the default palette
*/
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('belegungsplan_legend', 'amg_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('belegungsplans', 'belegungsplanp'), 'belegungsplan_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_user_group')
;
/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['belegungsplans'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['belegungsplans'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_belegungsplan_category.title',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_user_group']['fields']['belegungsplanp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['belegungsplanp'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);