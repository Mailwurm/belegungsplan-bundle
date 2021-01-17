<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */
/**
 * Add palettes to tl_module
 */
// Add a palette selector
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_kategorie';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_legende';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_wochenende';
$GLOBALS['TL_DCA']['tl_module']['palettes']['default'] = '	{title_legend},name,headline,type;{config_legend},belegungsplan_categories,belegungsplan_month;
															{color_legend_frei:hide},belegungsplan_color_frei,belegungsplan_opacity_frei,belegungsplan_reset_frei;
															{color_legend_belegt:hide},belegungsplan_color_belegt,belegungsplan_opacity_belegt,belegungsplan_reset_belegt;
															{text_legend:hide},belegungsplan_color_text,belegungsplan_opacity_text,belegungsplan_reset_text;
															{rahmen_legend:hide},belegungsplan_color_rahmen,belegungsplan_opacity_rahmen,belegungsplan_reset_rahmen;
															{kategorie_legend:hide},belegungsplan_anzeige_kategorie;
															{legende_legend:hide},belegungsplan_anzeige_legende;
															{wochenende_legend:hide},belegungsplan_anzeige_wochenende;
															{template_legend},belegungsplan_template;
															{expert_legend:hide},cssID';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_kategorie'] = 'belegungsplan_color_kategorie,belegungsplan_opacity_kategorie,belegungsplan_reset_kategorie,belegungsplan_color_kategorietext,belegungsplan_opacity_kategorietext,belegungsplan_reset_kategorietext';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_legende'] = 'belegungsplan_color_legende_frei,belegungsplan_color_legende_belegt,belegungsplan_opacity_legende,belegungsplan_reset_legende';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_wochenende'] = 'belegungsplan_bgcolor_wochenende,belegungsplan_opacity_bg_wochenende,belegungsplan_reset_bg_wochenende,belegungsplan_color_wochenendetext,belegungsplan_opacity_wochenendetext,belegungsplan_reset_wochenendetext';
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
// --------------------------------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_frei'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_frei'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '76,174,76',
	'explanation'			=> 'belegungsplan_color_frei',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_frei'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_frei'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// --------------------------------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_belegt'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_belegt'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '212,63,58',
	'explanation'			=> 'belegungsplan_color_belegt',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_belegt'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_belegt'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// --------------------------------------------------------------------------------------------

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_text'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_text'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '51,51,51',
	'explanation'			=> 'belegungsplan_color_text',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_text'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_text'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);

// --------------------------------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_rahmen'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_rahmen'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '221,221,221',
	'explanation'			=> 'belegungsplan_color_rahmen',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_rahmen'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_rahmen'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// --------------------------------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_kategorie'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_anzeige_kategorie'],
	'exclude'				=> true,
	'inputType'				=> 'checkbox',
	'default'				=> '1',
	'explanation'			=> 'belegungsplan_anzeige_kategorie',
	'eval'					=> array('submitOnChange'=>true, 'tl_class'=>'w50 wizard', 'helpwizard'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_kategorie'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_kategorie'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '204,204,204',
	'explanation'			=> 'belegungsplan_color_kategorie',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_kategorie'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_kategorie'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_kategorietext'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_kategorietext'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '0,0,0',
	'explanation'			=> 'belegungsplan_color_kategorietext',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_kategorietext'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_kategorietext'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// --------------------------------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_legende'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_anzeige_legende'],
	'exclude'				=> true,
	'inputType'				=> 'checkbox',
	'default'				=> '1',
	'explanation'			=> 'belegungsplan_anzeige_legende',
	'eval'					=> array('submitOnChange'=>true, 'tl_class'=>'w50 wizard', 'helpwizard'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_legende_frei'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_legende_frei'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '255,255,255',
	'explanation'			=> 'belegungsplan_color_legende_frei',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w25 wizard clr', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_legende_belegt'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_legende_belegt'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '255,255,255',
	'explanation'			=> 'belegungsplan_color_legende_belegt',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w25 wizard', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_legende'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25 wizard'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_legende'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// ----------WOCHENENDE------------------------------------------------------------------------

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_wochenende'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_anzeige_wochenende'],
	'exclude'				=> true,
	'inputType'				=> 'checkbox',
	'default'				=> '1',
	'explanation'			=> 'belegungsplan_anzeige_wochenende',
	'eval'					=> array('submitOnChange'=>true, 'tl_class'=>'w50 wizard', 'helpwizard'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_bgcolor_wochenende'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_bgcolor_wochenende'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '204,204,204',
	'explanation'			=> 'belegungsplan_bgcolor_wochenende',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_bg_wochenende'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_bg_wochenende'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_wochenendetext'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_color_wochenendetext'],
	'exclude'				=> true,
	'inputType'				=> 'text',
	'default'				=> '51,51,51',
	'explanation'			=> 'belegungsplan_color_wochenendetext',
	'load_callback'			=> array
	(
		array('tl_module_belegungsplan','setRgbToHex')
	),
	'eval'					=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
	'save_callback'			=> array
	(
		array('tl_module_belegungsplan','setHexToRgb')
	),
	'sql'					=> "varchar(20) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_wochenendetext'] = array(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'default'				=> '1.0',
	'options'				=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
	'eval'					=> array('tl_class'=>'w25'),
	'sql'					=> "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_wochenendetext'] = array(
	'eval'					=> array('submitOnChange'=>true),
	'input_field_callback'	=> array('tl_module_belegungsplan', 'setResetButton')
);
// --------------------------------------------------------------------------------------------
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
		// Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
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
		// Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
		if (!$dc->activeRecord)
		{
			return;
		}
		$hex = "";
		// Bei neuanlegen eines Modul abfragen
		if (strpos($varValue, ",") === false)
		{
			$hex .= $varValue;
		} else {
			$varValue = explode(",",$varValue);
			$hex .= str_pad(dechex($varValue[0]), 2, "0", STR_PAD_LEFT);
			$hex .= str_pad(dechex($varValue[1]), 2, "0", STR_PAD_LEFT);
			$hex .= str_pad(dechex($varValue[2]), 2, "0", STR_PAD_LEFT);
		}
		return strtoupper($hex);
	}
	/**
	 * input_field_callback: Ermoeglicht das Erstellen individueller Formularfelder.
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setResetButton(DataContainer $dc, $varValue)
	{	
		if (!empty(\Input::get('bpb')) && \Input::get('bpb') === $dc->inputName)
		{
			$boolHelper = true;
			$arrSet = array();
			$arrSet = $this->getReturnInfo($dc->inputName);
			
			if (!empty($arrSet))
			{
				$arrHelp = array();
				for ($i = 0, $a = count($arrSet); $i < $a; $i+=2)
				{
					if ($dc->activeRecord->{$arrSet[$i]} != $arrSet[$i+1])
					{
						$arrHelp[$arrSet[$i]] = $arrSet[$i+1];
						$boolHelper = false;
					}
				}
			}
			if (!$boolHelper)
			{	
				$this->Database->prepare("UPDATE tl_module %s WHERE id=?")->set($arrHelp)->execute($dc->id);
			}
			// GET-Parameter wieder aus Url entfernen
			$this->redirect(str_replace('&bpb='.$dc->inputName, '', Environment::get('request')));
			$this->redirect($this->getReferer());
		}
		return '<div class="w15 widget">
					<h3>&nbsp;</h3>
					<a href="' . Backend::addToUrl('bpb=' . $dc->inputName) . '" class="tl_submit m-3-0">'.$GLOBALS['TL_LANG']['tl_module']['reset'].'</a>
				</div>';
	}
	/**
	 *
	 * @param string $strInputName
	 *
	 * @return array
	 */
	 public function getReturnInfo($strInputName)
	 {
		$arrSet = array
		(
			'belegungsplan_reset_frei'				=> array('belegungsplan_color_frei', '76,174,76', 'belegungsplan_opacity_frei', '1.0'),
			'belegungsplan_reset_belegt'			=> array('belegungsplan_color_belegt', '212,63,58', 'belegungsplan_opacity_belegt', '1.0'),
			'belegungsplan_reset_text'				=> array('belegungsplan_color_text', '51,51,51', 'belegungsplan_opacity_text', '1.0'),
			'belegungsplan_reset_rahmen'			=> array('belegungsplan_color_rahmen', '221,221,221', 'belegungsplan_opacity_rahmen', '1.0'),
			'belegungsplan_reset_kategorie'			=> array('belegungsplan_color_kategorie', '204,204,204', 'belegungsplan_opacity_kategorie', '1.0'),
			'belegungsplan_reset_kategorietext'		=> array('belegungsplan_color_kategorietext', '0,0,0', 'belegungsplan_opacity_kategorietext', '1.0'),
			'belegungsplan_reset_legende'			=> array('belegungsplan_color_legende_frei', '255,255,255', 'belegungsplan_color_legende_belegt', '255,255,255', 'belegungsplan_opacity_legende', '1.0'),
			'belegungsplan_reset_bg_wochenende'		=> array('belegungsplan_bgcolor_wochenende', '204,204,204', 'belegungsplan_opacity_bg_wochenende', '1.0'),
			'belegungsplan_reset_wochenendetext'	=> array('belegungsplan_color_wochenendetext', '51,51,51', 'belegungsplan_opacity_wochenendetext', '1.0')
		);
		return $arrSet[$strInputName];
	 }
	
}
