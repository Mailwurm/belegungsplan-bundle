<?php
 /**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */

/**
 * Table tl_belegungsplan_objekte
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_objekte'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_belegungsplan_category',
		'ctable'                      => array('tl_belegungsplan_calender'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_belegungsplan_objekte', 'checkPermission')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid,published,sorting' => 'index'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'panelLayout'             => 'filter;sort,search,limit',
			'headerFields'            => array('title', 'tstamp'),
			'child_record_callback'   => array('tl_belegungsplan_objekte', 'listQuestions')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['edit'],
				'href'                => 'table=tl_belegungsplan_calender',
				'icon'                => 'edit.svg'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.svg',
				'button_callback'     => array('tl_belegungsplan_objekte', 'editHeader')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['toggle'],
				'icon'                => 'visible.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_belegungsplan_objekte', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},name,author,infotext;{publish_legend},published'
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
			'foreignKey'              => 'tl_belegungsplan_category.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['sorting'],
			'sorting'                 => true,
			'flag'                    => 11,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['author'],
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
		'infotext' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['infotext'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);
/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class tl_belegungsplan_objekte extends Backend
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
	* Check permissions to edit table tl_belegungsplan_objekte
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
		return $this->User->canEditFieldsOf('tl_belegungsplan_objekte') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
	}
	/**
	* Add the type of input field
	*
	* @param array $arrRow
	*
	* @return string
	*/
	public function listQuestions($arrRow)
	{
		$key = $arrRow['published'] ? 'published' : 'unpublished';
		$date = Date::parse(Config::get('datimFormat'), $arrRow['tstamp']);
		return '
<div class="cte_type ' . $key . '"><strong>' . $arrRow['question'] . '</strong> - ' . $date . '</div>
<div class="limit_height' . (!Config::get('doNotCollapse') ? ' h40' : '') . '">
' . StringUtil::insertTagToSrc($arrRow['answer']) . '
</div>' . "\n";
	}
	/**
	* Return the "toggle visibility" button
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
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}
		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->hasAccess('tl_belegungsplan_objekte::published', 'alexf'))
		{
			return '';
		}
		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);
		if (!$row['published'])
		{
			$icon = 'invisible.svg';
		}
		return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
	}
	/**
	 * Disable/enable a user group
	 *
	 * @param integer       $intId
	 * @param boolean       $blnVisible
	 * @param DataContainer $dc
	 *
	 * @throws Contao\CoreBundle\Exception\AccessDeniedException
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null) {
		// Set the ID and action
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');
		if($dc) {
			$dc->id = $intId; // see #8043
		}
		// Trigger the onload_callback
		if(is_array($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onload_callback'])) {
			foreach ($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onload_callback'] as $callback) {
				if(is_array($callback)) {
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif(is_callable($callback)) {
					$callback($dc);
				}
			}
		}
		// Check the field access
		if(!$this->User->hasAccess('tl_belegungsplan_objekte::published', 'alexf')) {
			throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish Object ID ' . $intId . '.');
		}
		// Set the current record
		if($dc) {
			$objRow = $this->Database->prepare("SELECT * FROM tl_belegungsplan_objekte WHERE id=?")
									 ->limit(1)
									 ->execute($intId);
			if($objRow->numRows) {
				$dc->activeRecord = $objRow;
			}
		}
		$objVersions = new Versions('tl_belegungsplan_objekte', $intId);
		$objVersions->initialize();
		// Trigger the save_callback
		if(is_array($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['fields']['published']['save_callback'])) {
			foreach($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['fields']['published']['save_callback'] as $callback) {
				if(is_array($callback)) {
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
				}
				elseif(is_callable($callback)) {
					$blnVisible = $callback($blnVisible, $dc);
				}
			}
		}
		$time = time();
		// Update the database
		$this->Database->prepare("UPDATE tl_belegungsplan_objekte SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
					   ->execute($intId);
		if($dc) {
			$dc->activeRecord->tstamp = $time;
			$dc->activeRecord->published = ($blnVisible ? '1' : '');
		}
		// Trigger the onsubmit_callback
		if(is_array($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onsubmit_callback'])) {
			foreach ($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onsubmit_callback'] as $callback) {
				if(is_array($callback)) {
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif(is_callable($callback)) {
					$callback($dc);
				}
			}
		}
		$objVersions->create();
	}
}
