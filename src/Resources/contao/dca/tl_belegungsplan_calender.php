<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

/**
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');
 
/**
 * Table tl_belegungsplan_calender
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_calender'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'			=> 'Table',
		'ptable'				=> 'tl_belegungsplan_objekte',
		'ctable'				=> array('tl_content'),
		'switchToEdit'			=> true,
		'enableVersioning'		=> true,
		'onsubmit_callback'		=> array(array('tl_belegungsplan_calender','loadUeberschneidung')),
		'ondelete_callback'		=> array(array('tl_belegungsplan_calender', 'calenderOndeleteCallback')),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('startDate DESC'),
			'headerFields'            => array('name'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_belegungsplan_calender', 'listCalender')
		),
		'label' => array
		(
			'fields'                  => array('gast', 'startDate', 'endDate'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'				=> array('dauer'),
		'default'					=> '{title_legend},gast,author;{day_legend},dauer',
		'oneday'					=> '{title_legend},gast,author;{day_legend},dauer;{date_legend},startDate',
		'moreday'					=> '{title_legend},gast,author;{day_legend},dauer;{date_legend},startDate,endDate'
	),
	// Subpalettes
	'subpalettes' => array(
	),
	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_belegungsplan_objekte.name',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'gast' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['gast'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['author'],
			'default'                 => BackendUser::getInstance()->id,
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'startDate' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['startDate'],
			'exclude'		=> true,
			'search'		=> true,
			'filter'		=> true,
			'sorting'		=> true,
			'flag'			=> 8,
			'inputType'		=> 'text',
			'eval'			=> array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'save_callback'	=> array
			(
				array('tl_belegungsplan_calender','setEndDate')
			),
			'sql'			=> "int(10) unsigned NULL"
		),
		'endDate' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDate'],
			'exclude'		=> true,
			'search'		=> true,
			'filter'		=> true,
			'sorting'		=> true,
			'flag'			=> 8,
			'inputType'		=> 'text',
			'eval'			=> array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'save_callback'	=> array
			(
				array('tl_belegungsplan_calender','loadEndDate')
			),
			'sql'			=> "int(10) unsigned NULL"
		),
		'ueberschneidung' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'sql'			=> "text NULL"
		),
		'dauer' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['dauer'],
			'inputType'		=> 'radio',
			'options'		=> array('oneday', 'moreday'),
			'default'		=> 'moreday',
			'reference'		=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender'],
			'explanation'	=> &$GLOBALS['TL_LANG']['tl_belegungsplan_calender'],
			'eval'			=> array('mandatory'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50', 'style'=>'margin:10px'),
			'sql'			=> "varchar(8) NOT NULL default ''"
		)
	)
);

 /**
  * Provide miscellaneous methods that are used by the data configuration array.
  *
  * @author Jan Karai <https://www.sachsen-it.de>
  */
class tl_belegungsplan_calender extends Backend
{
	 /**
	  * Import the back end user object
	  */
	public function __construct() {
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	/**
	 * Add the type of input field
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listCalender($arrRow)
	{
		return '<div class="tl_content_left">' . $arrRow['gast'] . 
		' <span style="color:#999;padding-left:3px">[' . Date::parse(Config::get('dateFormat'), $arrRow['startDate']) .($arrRow['dauer'] == 'moreday' ? $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse(Config::get('dateFormat'), $arrRow['endDate']) : '') . ']</span>' . 
		($arrRow['endDate'] < $arrRow['startDate'] ? ' ' . Image::getHtml('error.svg', $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateListError'], 'title="' . $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateListError'] . '"') : '') . 
		($arrRow['ueberschneidung'] ? ' ' . Image::getHtml('error_404.svg', $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'][0], 'title="' . $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'][0] . '"') : '') . 
		'</div>';
	}
	/**
	 * Prueft ob Enddatum kleiner Startdatum
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 * @return mixed
	 */
	public function loadEndDate($varValue, DataContainer $dc)
	{
		$dateOne = new DateTime($this->Input->post('startDate'));
		$dateTwo = new DateTime($this->Input->post('endDate'));
		
		try
		{
			if ($dateTwo->getTimestamp() <= $dateOne->getTimestamp())
			{	
				if ($dateTwo->getTimestamp() < $dateOne->getTimestamp())
				{
					throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateError']); 
				} else {
					throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_calender']['sameDateError']); 
				}
			} else {
				return $varValue;
			}
		}
		catch (\OutOfBoundsException $e)
		{
		}
	}
	/**
	 * Setzt das Enddatum bei eintaegigem Besuch
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setEndDate($varValue, DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}
		if ($dc->Input->post('dauer') === 'oneday')
		{
			$arrSet = array();
			$getStartDatum = new DateTime($dc->Input->post('startDate'));
			$sNextDay = $getStartDatum->add(new DateInterval('P1D'));
			$arrSet['startDate'] = (int) $getStartDatum->getTimestamp();
			$arrSet['endDate'] = (int) $sNextDay->getTimestamp();
			
			$this->Database->prepare("UPDATE tl_belegungsplan_calender %s WHERE id=?")->set($arrSet)->execute($dc->id);
		}
		return $varValue;
	}
	/**
	 * Prueft auf Terminueberschneidungen
	 *
	 * @param DataContainer $dc
	 */
	public function loadUeberschneidung(DataContainer $dc)
	{
		$intId = (int) $dc->activeRecord->id;
		$intPid = (int) $dc->activeRecord->pid;
		$intStart = (int) $dc->activeRecord->startDate;
		$intEnde = (int) $dc->activeRecord->endDate;
		// Hole alle Calenderdaten zur Auswahl
		$objCal = $this->Database->prepare("SELECT id, ueberschneidung
											FROM tl_belegungsplan_calender
											WHERE id <> ?
											AND pid = ?
											AND ((startDate < ? AND endDate > ?) OR (startDate >= ? AND endDate <= ?) OR (startDate < ? AND endDate > ?))")
						->execute($intId, $intPid, $intStart, $intStart, $intStart, $intEnde, $intEnde, $intEnde);
		if ($objCal->numRows > 0) {
			$strHelper = '';
			while ($objCal->next()) {
				$strHelper .= ',' . $objCal->id;
				if (empty($objCal->ueberschneidung)) {
					$this->updateDatabase($intId, $objCal->id);
				} else {
					$arrHelper = explode(',', $objCal->ueberschneidung);
					if (!in_array($intId, $arrHelper)) {
						$this->updateDatabase($objCal->ueberschneidung . ',' . $intId, $objCal->id);
					}
					unset($arrHelper);
				}
			}
			// Update am aktuellen Termin
			$this->updateDatabase(substr($strHelper, 1), $intId);
			unset($strHelper);
		} else {
			$this->updateCalenders($intId, $intPid);
		}		
	}
	/**
	 * ondelete_callback: Wird ausgefuehrt bevor ein Datensatz aus der Datenbank entfernt wird.
	 *
	 * @param DataContainer $dc
	 */
	public function calenderOndeleteCallback(DataContainer $dc)
	{
		$intId = (int) $dc->activeRecord->id;
		$intPid = (int) $dc->activeRecord->pid;
		$this->updateCalenders($intId, $intPid);
	}
	/**
	 * Update Datenbank
	 *
	 * @param integer $intId
	 * @param integer $intPid
	 */
	 public function updateCalenders($intId, $intPid)
	{
		$objCalDelete = $this->Database->prepare("SELECT id, ueberschneidung
											FROM tl_belegungsplan_calender
											WHERE id <> ?
											AND pid = ?
											AND ueberschneidung <> ''")
						->execute($intId, $intPid);
		if ($objCalDelete->numRows > 0) {
			$arrDelete = array($intId);
			$strHelper = '';
			while ($objCalDelete->next()) {
				$strHelper .= ',' . $objCalDelete->id;
				$arrHelper = explode(',', $objCalDelete->ueberschneidung);
				$arrReturn = array_diff($arrHelper, $arrDelete);
				$strInsert = '';
				if (!empty($arrReturn)) {
					$strInsert = implode(',', $arrReturn);
				} 
				$this->updateDatabase($strInsert, $objCalDelete->id);
				unset($arrHelper, $arrReturn);
			}
			// Update am aktuellen Termin
			$this->updateDatabase('', $intId);
			unset($arrHelper, $arrReturn);
		}
	}
	/**
	 * Update Datenbank
	 *
	 * @param string $strInput
	 * @param integer $intInput
	 */
	public function updateDatabase($strInput, $intInput)
	{
		$this->Database->prepare("UPDATE tl_belegungsplan_calender SET ueberschneidung = ? WHERE id = ?")
						->execute($strInput, $intInput);
	}
}
