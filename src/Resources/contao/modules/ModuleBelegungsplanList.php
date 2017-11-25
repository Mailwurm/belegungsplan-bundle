<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm;
use Patchwork\Utf8;

/**
* Class ModuleBelegungsplanList
*
* @property array $belegungsplan_categories
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class ModuleBelegungsplanList extends \Module
{
	/**
	* Template
	* @var string
	*/
	protected $strTemplate = 'mod_belegungsplanlist';
	/**
	* Target pages
	* @var array
	*/
	protected $arrTargets = array();
	/**
	* Display a wildcard in the back end
	*
	* @return string
	*/
	public function generate() {
		if (TL_MODE == 'BE') {
			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['belegungsplanlist'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			return $objTemplate->parse();
		}
		$this->belegungsplan_categories = \StringUtil::deserialize($this->belegungsplan_categories);
		// Return if there are no categories
		if (!is_array($this->belegungsplan_categories) || empty($this->belegungsplan_categories)) {
			return '';
		}
		return parent::generate();
	}
	/**
	* Generate the module
	*/
	protected function compile() {
		$objBelegungsplan = \BelegungsplanObjektModel::findPublishedByPids($this->belegungsplan_categories);
		if ($objBelegungsplan === null) {
			$this->Template->belegungsplan = array();
			return;
		}
		$arrBelegungsplan = array_fill_keys($this->belegungsplan_categories, array());
		// Add 
		while ($objBelegungsplan->next()) {
			$arrTemp = $objBelegungsplan->row();
			$arrTemp['title'] = \StringUtil::specialchars($objBelegungsplan->question, true);
			
			/** @var BelegungsplanCategoryModel $objPid */
			$objPid = $objBelegungsplan->getRelated('pid');
			$arrBelegungsplan[$objBelegungsplan->pid]['items'][] = $arrTemp;
			$arrBelegungsplan[$objBelegungsplan->pid]['title'] = $objPid->title;
		}
		$arrBelegungsplan = array_values(array_filter($arrBelegungsplan));
		$cat_count = 0;
		$cat_limit = count($arrBelegungsplan);
		// Add classes
		foreach ($arrBelegungsplan as $k=>$v) {
			$count = 0;
			$limit = count($v['items']);
			for ($i=0; $i<$limit; $i++) {
				$arrBelegungsplan[$k]['items'][$i]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count >= $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
			}
			$arrBelegungsplan[$k]['class'] = trim(((++$cat_count == 1) ? ' first' : '') . (($cat_count >= $cat_limit) ? ' last' : '') . ((($cat_count % 2) == 0) ? ' odd' : ' even'));
		}
		$this->Template->belegungsplan = $arrBelegungsplan;
	}
}
