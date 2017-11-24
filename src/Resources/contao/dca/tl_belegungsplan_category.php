<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
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
		'onload_callback' => array
		(
			array('tl_belegungsplan_category', 'checkPermission')
		),
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
	* Check permissions to edit table tl_belegungsplan_category
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
		return $this->User->canEditFieldsOf('tl_belegungsplan_category') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
		return $this->User->hasAccess('create', 'belegungsplanp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
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
		return $this->User->hasAccess('delete', 'belegungsplanp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
	}
}
