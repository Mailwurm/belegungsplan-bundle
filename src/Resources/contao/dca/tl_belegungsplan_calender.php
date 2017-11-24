<?php
 /**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */

/**
 * Table tl_belegungsplan_calender
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_calender'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_belegungsplan_objekte',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_belegungsplan_calender', 'checkPermission')
		),
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
			'mode'                    => 2,
			'fields'                  => array('startDate DESC'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;sort,search,limit',
			'headerFields'            => array('name', 'tstamp'),
			'child_record_callback'   => array('tl_belegungsplan_calender', 'listCalender')
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
				'href'                => 'table=tl_belegungplan_calender',
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
		'__selector__'                => array(),
		'default'                     => '{title_legend},gast,author;{date_legend},startDate,endDate;reserviert'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['startDate'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NULL"
		),
		'endDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDate'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NULL"
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
	* Check permissions to edit table tl_belegungsplan_calender
	*
	* @throws Contao\CoreBundle\Exception\AccessDeniedException
	*/
	public function checkPermission() {
		$bundles = System::getContainer()->getParameter('kernel.bundles');
		if($this->User->isAdmin) {
			return;
		}
		// Set root IDs
		if(!is_array($this->User->belegungsplans) || empty($this->User->belegungsplans)) {
			$root = array(0);
		} else {
			$root = $this->User->belegungsplans;
		}
		$GLOBALS['TL_DCA']['tl_belegungsplan_category']['list']['sorting']['root'] = $root;
		// Check permissions to add Belegungsplan categories
		if (!$this->User->hasAccess('create', 'belegungsplanp')) {
			$GLOBALS['TL_DCA']['tl_belegungsplan_category']['config']['closed'] = true;
		}
		/** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
		$objSession = System::getContainer()->get('session');
		// Check current action
		switch (Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;
			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root))
				{
					/** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
					$objSessionBag = $objSession->getBag('contao_backend');
					$arrNew = $objSessionBag->get('new_records');
					if(is_array($arrNew['tl_belegungsplan_category']) && in_array(Input::get('id'), $arrNew['tl_belegungsplan_category'])) {
						// Add the permissions on group level
						if($this->User->inherit != 'custom') {
							$objGroup = $this->Database->execute("SELECT id, belegungsplans, belegungsplanp FROM tl_user_group WHERE id IN(" . implode(',', array_map('intval', $this->User->groups)) . ")");
							while($objGroup->next()) {
								$arrBelegungsplanp = StringUtil::deserialize($objGroup->belegungsplanp);
								if (is_array($arrBelegungsplanp) && in_array('create', $arrBelegungsplanp)) {
									$arrBelegungsplans = StringUtil::deserialize($objGroup->belegungsplans, true);
									$arrBelegungsplans[] = Input::get('id');
									$this->Database->prepare("UPDATE tl_user_group SET belegungsplans=? WHERE id=?")
												   ->execute(serialize($arrBelegungsplans), $objGroup->id);
								}
							}
						}
						// Add the permissions on user level
						if ($this->User->inherit != 'group') {
							$objUser = $this->Database->prepare("SELECT belegungsplans, belegungsplanp FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);
							$arrBelegungsplanp = StringUtil::deserialize($objUser->belegungsplanp);
							if (is_array($arrBelegungsplanp) && in_array('create', $arrBelegungsplanp))
							{
								$arrBelegungsplans = StringUtil::deserialize($objUser->belegungsplans, true);
								$arrBelegungsplans[] = Input::get('id');
								$this->Database->prepare("UPDATE tl_user SET belegungsplans=? WHERE id=?")
											   ->execute(serialize($arrBelegungsplans), $this->User->id);
							}
						}
						// Add the new element to the user object
						$root[] = Input::get('id');
						$this->User->belegungsplans = $root;
					}
				}
				// No break;
			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'belegungsplanp')))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' Belegungsplan category ID ' . Input::get('id') . '.');
				}
				break;
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $objSession->all();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'belegungsplanp'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$objSession->replace($session);
				break;
			default:
				if (strlen(Input::get('act')))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' Belegungsplan categories.');
				}
				break;
		}
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
		return '<div class="tl_content_left">' . ($arrRow['reserviert'] == 1 ? Image::getHtml('user.svg') : ($arrRow['gebucht'] == 1 ? Image::getHtml('member.svg') : Image::getHtml('admin.svg'))) . $arrRow['gast'] . ' <span style="color:#999;padding-left:3px">[' . Date::parse(Config::get('timeFormat'), $arrRow['startDate']) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse(Config::get('timeFormat'), $arrRow['endDate']) . ']</span></div>';
	}
	
	

	
	
	
	
}
