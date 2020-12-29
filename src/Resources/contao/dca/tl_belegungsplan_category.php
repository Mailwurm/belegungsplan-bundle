<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0-or-later
*/
/**
* Table tl_belegungsplan_category
*/
$GLOBALS['TL_DCA']['tl_belegungsplan_category'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_belegungsplan_objekte'),
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
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['edit'],
				'href'                => 'table=tl_belegungsplan_objekte',
				'icon'                => 'cssimport.svg'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg',
				'button_callback'     => array('tl_belegungsplan_category', 'editHeader')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg',
				'button_callback'     => array('tl_belegungsplan_category', 'copyCategory')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_belegungsplan_category']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_belegungsplan_category', 'deleteCategory')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},title'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_category']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		)
	)
);
 /**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class tl_belegungsplan_category extends Backend {
	/**
	* Import the back end user object
	*/
	public function __construct() {
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	/**
	* Return the edit header button
	*
	* @param array  $row
	* @param string $href
	* @param string $label
	* @param string $title
	* @param string $icon
	* @param string $attributes
	*
	* @return string
	*/
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
	/**
	* Return the copy category button
	*
	* @param array  $row
	* @param string $href
	* @param string $label
	* @param string $title
	* @param string $icon
	* @param string $attributes
	*
	* @return string
	*/
	public function copyCategory($row, $href, $label, $title, $icon, $attributes)
	{
		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
	/**
	* Return the delete category button
	*
	* @param array  $row
	* @param string $href
	* @param string $label
	* @param string $title
	* @param string $icon
	* @param string $attributes
	*
	* @return string
	*/
	public function deleteCategory($row, $href, $label, $title, $icon, $attributes)
	{
		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
}
