<?php
 /**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
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
			'mode'                    => 4,
			'fields'                  => array('startDate DESC'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_belegungsplan_feiertage', 'listFeiertage')
		),
		'label' => array
		(
			'fields'                  => array('title', 'startDate', 'endDate'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},title,author;{date_legend},startDate,endDate'
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
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['author'],
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['startDate'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NULL"
		),
		'endDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['endDate'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NULL"
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
	public function listFeiertage($arrRow)
	{
		return '<div class="tl_content_left">' . $arrRow['title'] . ' <span style="color:#999;padding-left:3px">[' . Date::parse(Config::get('dateFormat'), $arrRow['startDate']) . ($arrRow['endDate'] ? $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse(Config::get('dateFormat'), $arrRow['endDate']) : '') . ']</span></div>';
	}
}
