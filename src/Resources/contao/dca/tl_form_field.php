<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/

/**
* Add palettes to tl_form_field
*/
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['belegungsplancategoryselect'] = '{type_legend},type,name,label;{options_legend},belegungsplancategorycheck;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl';

/**
* Add fields to tl_form_field
*/
$GLOBALS['TL_DCA']['tl_form_field']['fields']['belegungsplancategorycheck'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['belegungsplancategorycheck'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'foreignKey'              => 'tl_belegungsplan_category.title',
	'eval'                    => array('multiple'=>true, 'mandatory'=>true),
	'sql'                     => "blob NULL"
);

$bundles = System::getContainer()->getParameter('kernel.bundles');

/**
* Provide miscellaneous methods that are used by the data configuration array.
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class tl_form_field_belegungsplancategoryselect extends Backend {

}
