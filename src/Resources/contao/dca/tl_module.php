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
$GLOBALS['TL_DCA']['tl_module']['palettes']['belegungsplan']   = '{title_legend},name,headline,type;{config_legend},belegungsplan_categories,belegungsplan_month;{color_legend_frei},belegungsplan_color_frei,belegungsplan_opacity_frei;{color_legend_belegt},belegungsplan_color_belegt,belegungsplan_opacity_belegt;{template_legend},belegungsplan_template;{expert_legend:hide},cssID';
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
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 m12 wizard'),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
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
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 m12 wizard'),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
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

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_template'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_template'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> static function ()
	{
		return \Controller::getTemplateGroup('mod_belegungsplan_');
	},
	'eval'					=> array('mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'					=> "varchar(64) NOT NULL default ''"
);

$bundles = System::getContainer()->getParameter('kernel.bundles');

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class tl_module_belegungsplan extends Backend {
	/**
	 * Wandelt Farbcode Hexadezimal nach RGB
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setHexToRgb($varValue, DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}
		$hex = str_replace(" ","",$varValue);
		try
		{
			if (strlen($hex) < 6)
			{	
				throw new Exception($GLOBALS['TL_LANG']['tl_module']['setHexToRgb']);
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
				$rgb = implode(",",array($r, $g, $b));
				return $rgb;
			}
		}
		catch (\OutOfBoundsException $e)
		{
		}
	}
	/**
	 * Wandelt Farbcode RGB nach Hexadezimal
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setRgbToHex($varValue, DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}
		$varValue = explode(",",$varValue);
		$hex = "";
		$hex .= str_pad(dechex($varValue[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($varValue[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($varValue[2]), 2, "0", STR_PAD_LEFT);
		return $hex;
	}
}
