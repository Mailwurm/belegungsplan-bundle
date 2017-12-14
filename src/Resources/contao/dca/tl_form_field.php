<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai <https://www.sachsen-it.de>
*
* @license LGPL-3.0+
*/

/**
* Add palettes to tl_form_field
*/
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['belegungsplancategoryselect'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,multiple;{options_legend},belegungsplancategorycheck;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{submit_legend},addSubmit';

/**
* Add fields to tl_form_field
*/
$GLOBALS['TL_DCA']['tl_form_field']['fields']['belegungsplancategorycheck'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['belegungsplancategorycheck'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'foreignKey'              => 'tl_belegungsplan_category.title',
	'save_callback'           => array(array('tl_form_field_belegungsplancategorycheck','setBelegungsplancategorycheck')),
	'eval'                    => array('multiple'=>true, 'mandatory'=>true),
	'sql'                     => "blob NULL"
);
$bundles = System::getContainer()->getParameter('kernel.bundles');

/**
* Provide miscellaneous methods that are used by the data configuration array.
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class tl_form_field_belegungsplancategorycheck extends Backend {
	
	/**
	* save_callback: Wird beim Abschicken eines Feldes ausgeführt.
	* @param $varValue
	* @param $dc
	* @return var
	*/
	public function setBelegungsplancategorycheck($varValue, DataContainer $dc) {
	        
			$sHelper = implode(',', $varValue);
			
			
			die($sHelper);
	        return $varValue;
	} 
}
