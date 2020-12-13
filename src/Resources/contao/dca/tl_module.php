<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/

/**
* Add palettes to tl_module
*/
$GLOBALS['TL_DCA']['tl_module']['palettes']['belegungsplan']   = '{title_legend},name,headline,type;{config_legend},belegungsplan_categories,belegungsplan_month;{color_legend_frei},belegungsplan_color_frei,belegungsplan_opacity_frei;{color_legend_belegt},belegungsplan_color_belegt,belegungsplan_opacity_belegt;{template_legend:hide},customTpl;{expert_legend:hide},cssID';
/**
* Add fields to tl_module
*/
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_categories'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_categories'],
	'exclude'				=> true,
	'inputType'				=> 'checkboxWizard',
	'foreignKey'			=> 'tl_belegungsplan_category.title',
	'eval'					=> array('multiple'=>true, 'mandatory'=>true),
	'sql'					=> "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_month'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_month'],
	'exclude'				=> true,
	'inputType'				=> 'checkboxWizard',
	'options'				=> $GLOBALS['TL_LANG']['tl_module']['belegungsplan_month']['month'],
	'eval'					=> array('multiple'=>true, 'mandatory'=>true),
	'sql'					=> "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_frei'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_frei'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '4CAE4C',
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 m12 wizard'),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_frei'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity_frei'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w50 m12'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_belegt'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_belegt'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> 'D43F3A',
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 m12 wizard'),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_belegt'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity_belegt'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w50 m12'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);
$bundles = System::getContainer()->getParameter('kernel.bundles');

/**
* Provide miscellaneous methods that are used by the data configuration array.
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class tl_module_belegungsplan extends Backend {

}
