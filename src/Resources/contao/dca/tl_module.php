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
$GLOBALS['TL_DCA']['tl_module']['palettes']['belegungsplanlist']   = '{title_legend},name,headline,type;{config_legend},belegungsplan_categories,belegungsplan_month;{template_legend:hide},belegungsplan_ctemplate,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
/**
* Add fields to tl_module
*/
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_categories'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_categories'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'foreignKey'              => 'tl_belegungsplan_category.title',
	'eval'                    => array('multiple'=>true, 'mandatory'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_month'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_month'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options'                 => $GLOBALS['TL_LANG']['tl_module']['belegungsplan_month']['month'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_ctemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_ctemplate'],
	'default'                 => 'belegungsplan_list',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_belegungsplan', 'getBelegungsplanTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$bundles = System::getContainer()->getParameter('kernel.bundles');

/**
* Provide miscellaneous methods that are used by the data configuration array.
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class tl_module_belegungsplan extends Backend {
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
	/**
	* Return all belegungsplan templates as array
	*
	* @return array
	*/
	public function getBelegungsplanTemplates()
	{
		return $this->getTemplateGroup('belegungsplan_');
	}
}
