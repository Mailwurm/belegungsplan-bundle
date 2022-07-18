<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */

/**
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');
 
/**
 * Table tl_belegungsplan_feiertage
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_feiertage'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'				=> 1,
			'fields'			=> array('startDate DESC'),
			'flag'				=> 9,
			'panelLayout'		=> 'search,limit'
		),
		'label' => array
		(
			'fields'			=> array('title'),
			'format'			=> '%s',
			'label_callback'	=> array('tl_belegungsplan_feiertage', 'listCalender')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'			=> 'act=select',
				'class'			=> 'header_edit_all',
				'attributes'	=> 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'	=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['edit'],
				'href'	=> 'act=edit',
				'icon'	=> 'edit.svg'
			),
			'delete' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['delete'],
				'href'			=> 'act=delete',
				'icon'			=> 'delete.svg',
				'attributes'	=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'			=> array('ausgabe'),
		'default'				=> '{title_legend},title,showTitleText,author;{date_legend},startDate;{color_legend},ausgabe'
	),
	// Subpalettes
	'subpalettes' => array
	(
		'ausgabe'				=> 'hintergrund,opacity,reset,textcolor,textopacity,textreset'
	),
	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'				=> "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'				=> "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['title'],
			'exclude'			=> true,
			'search'			=> true,
			'filter'			=> true,
			'inputType'			=> 'text',
			'eval'				=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'				=> "varchar(255) NOT NULL default ''"
		),
		'showTitleText' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['showTitleText'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'eval'				=> array('tl_class'=>'w50 m12'),
			'sql'				=> "char(1) COLLATE ascii_bin NOT NULL default '1'"
		),
		'author' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['author'],
			'default'			=> BackendUser::getInstance()->id,
			'exclude'			=> true,
			'search'			=> true,
			'filter'			=> true,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'select',
			'foreignKey'		=> 'tl_user.name',
			'eval'				=> array('doNotCopy'=>true, 'chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50 clr'),
			'sql'				=> "int(10) unsigned NOT NULL default '0'",
			'relation'			=> array('type'=>'belongsTo', 'load'=>'eager')
		),
		'startDate' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['startDate'],
			'exclude'			=> true,
			'search'			=> true,
			'filter'			=> true,
			'sorting'			=> true,
			'flag'				=> 8,
			'inputType'			=> 'text',
			'eval'				=> array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'save_callback'		=> array
			(
				array('tl_belegungsplan_feiertage','getVorhanden')
			),
			'sql'				=> "int(10) unsigned NULL"
		),
		'ausgabe' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['ausgabe'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'default'			=> '1',
			'eval'				=> array('submitOnChange'=>true, 'tl_class'=>'w50 m12 wizard', 'helpwizard'=>true),
			'sql'				=> "char(1) NOT NULL default ''"
		),
		'hintergrund' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['hintergrund'],
			'exclude'			=> true,
			'inputType'			=> 'text',
			'default'			=> '91,192,222',
			'explanation'		=> 'hintergrund',
			'load_callback'		=> array
			(
				array('tl_belegungsplan_feiertage','setRgbToHex')
			),
			'eval'				=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
			'save_callback'		=> array
			(
				array('tl_belegungsplan_feiertage','setHexToRgb')
			),
			'sql'				=> "varchar(20) NOT NULL default ''"
		),
		'opacity' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['opacity'],
			'exclude'			=> true,
			'inputType'			=> 'select',
			'default'			=> '1.0',
			'options'			=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
			'eval'				=> array('tl_class'=>'w25'),
			'sql'				=> "varchar(3) NOT NULL default ''"
		),
		'reset' => array
		(
			'eval'					=> array('submitOnChange'=>true),
			'input_field_callback'	=> array('tl_belegungsplan_feiertage', 'setResetButton')
		),
		'textcolor' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['textcolor'],
			'exclude'			=> true,
			'inputType'			=> 'text',
			'default'			=> '51,51,51',
			'explanation'		=> 'textcolor',
			'load_callback'		=> array
			(
				array('tl_belegungsplan_feiertage','setRgbToHex')
			),
			'eval'				=> array('maxlength'=>6, 'minlength'=>6, 'mandatory'=>true, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w33 wizard clr', 'helpwizard'=>true),
			'save_callback'		=> array
			(
				array('tl_belegungsplan_feiertage','setHexToRgb')
			),
			'sql'				=> "varchar(20) NOT NULL default ''"
		),
		'textopacity' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['opacity'],
			'exclude'			=> true,
			'inputType'			=> 'select',
			'default'			=> '1.0',
			'options'			=> array('1.0','0.9','0.8','0.7','0.6','0.5','0.4','0.3','0.2','0.1'),
			'eval'				=> array('tl_class'=>'w25'),
			'sql'				=> "varchar(3) NOT NULL default ''"
		),
		'textreset' => array
		(
			'eval'					=> array('submitOnChange'=>true),
			'input_field_callback'	=> array('tl_belegungsplan_feiertage', 'setResetButton')
		)
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class tl_belegungsplan_feiertage extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	/**
	 * Auflistung anpassen
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listCalender($arrRow)
	{
		return '<div class="tl_content_left">' . $arrRow['title'] . ' <span style="color:#999;padding-left:3px">[' . Date::parse(Config::get('dateFormat'), $arrRow['startDate']) . ']</span></div>';
	}
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
				throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['setHexToRgb']);
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
						$arrHelp[$arrSet[$i]] = strlen($arrSet[$i+1]) == 6 ? $this->setHexToRgb($arrSet[$i+1], $dc) : $arrSet[$i+1];
						$boolHelper = false;
					}
				}
			}
			if (!$boolHelper)
			{	
				$this->Database->prepare("UPDATE tl_belegungsplan_feiertage %s WHERE id=?")->set($arrHelp)->execute($dc->id);
			}
			// GET-Parameter wieder aus Url entfernen
			$this->redirect(str_replace('&bpb='.$dc->inputName, '', Environment::get('request')));
			$this->redirect($this->getReferer());
		}
		return '<div class="w15 widget">
					<h3>&nbsp;</h3>
					<a href="' . Backend::addToUrl('bpb=' . $dc->inputName) . '" class="tl_submit m-3-0">'.$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['reset'].'</a>
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
			'reset'		=> array('hintergrund', '5BC0DE', 'opacity', '1.0'),
			'textreset'	=> array('textcolor', '333333', 'textopacity', '1.0')
		);
		return $arrSet[$strInputName];
	}
	/**
	 * Prueft ob fuer einen Tag bereits ein Feiertag eingetragen wurde
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function getVorhanden($varValue, DataContainer $dc)
	{
		if (!$dc->activeRecord)
		{
			return;
		}
		$getStartDatum = new DateTime($dc->Input->post('startDate'));
		$objTag = $this->Database->prepare("SELECT id FROM tl_belegungsplan_feiertage WHERE startDate = ? AND id <> ?")
						->execute($getStartDatum->getTimestamp(), $dc->activeRecord->id);
		try
		{
			if ($objTag->numRows > 0)
			{
				throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['bereitsVorhanden']);
			} else {
				return $varValue;
			}
		}
		catch (\OutOfBoundsException $e)
		{
		}
	}
}