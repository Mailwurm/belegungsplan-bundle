<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\Belegung;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Patchwork\Utf8;


/**
* Class ModuleBelegungsplan
*
* @property array $belegungsplan_categories
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class ModuleBelegungsplan extends \Module
{
	/**
	* Template
	* @var string
	*/
	protected $strTemplate = 'mod_belegungsplan';
	
	/**
	* Display a wildcard in the back end
	*
	* @return string
	*/
	public function generate() 
	{
		if (TL_MODE == 'BE') 
		{
			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['belegungsplanlist'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			return $objTemplate->parse();
		}
		$this->belegungsplan_category = \StringUtil::deserialize($this->belegungsplan_categories);
		$this->belegungsplan_month = \StringUtil::deserialize($this->belegungsplan_month);
		// aktuelle Seiten URL
		$this->strUrl = preg_replace('/\?.*$/', '', \Environment::get('request'));
		
		// Return if there are no categories
		if (!is_array($this->belegungsplan_category) || empty($this->belegungsplan_category)) 
		{
			return '';
		}
		// Return if there are no month
		if (!is_array($this->belegungsplan_month) || empty($this->belegungsplan_month)) 
		{
			return '';
		}
		return parent::generate();
	}
	/**
	* Generate the module
	*/
	protected function compile() 
	{
		/** @var PageModel $objPage */
		global $objPage;
		
		$arrCategorieObjekte = array();
		$arrJahre = array();

		$blnClearInput = false;

		$intYear = \Input::get('year');
		$intMonth = \Input::get('month');
		
		// Aktuelle Periode bei Erstaufruf der Seite
		if (!isset($_GET['year']) && !isset($_GET['month']))
		{
			$intYear = date('Y');
			$blnClearInput = true;
		}
		
		
		// Hole alle aktiven Objekte
		$objCategoryObjekte = $this->Database->prepare("SELECT 	tbc.id as CategoryID,
									tbc.title as CategoryTitle,
									tbo.id as ObjektID,
									tbo.name as ObjektName,
									tbo.infotext as ObjektInfoText,
									tbo.sorting as ObjektSortierung
								FROM 	tl_belegungsplan_category tbc,
									tl_belegungsplan_objekte tbo
								WHERE	tbo.pid = tbc.id
								AND	tbo.published = 1")
								->execute();
		if($objCategoryObjekte->numRows > 0) {
			while($objCategoryObjekte->next()) {
				$arrHelper = array();
				$arrHelper['ObjektID'] = $objCategoryObjekte->ObjektID;
				$arrHelper['ObjektName'] = $objCategoryObjekte->ObjektName;
				$arrHelper['ObjektInfoText'] = $objCategoryObjekte->ObjektInfoText;
				if(array_key_exists($objCategoryObjekte->CategoryID, $arrCategorieObjekte)) {
					$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
				} else {
					$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['CategoryTitle'] = \StringUtil::specialchars($objCategoryObjekte->CategoryTitle);
					$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
				}
				unset($arrHelper);
			}
		}
		// Hole alle Jahre fuer die bereits Buchungen vorhanden sind ab dem aktuellen Jahr
		$objJahre = $this->Database->prepare("	SELECT YEAR(FROM_UNIXTIME(startDate)) as Start 
							FROM tl_belegungsplan_calender 
							WHERE YEAR(FROM_UNIXTIME(startDate)) >= ? 
							GROUP BY YEAR(FROM_UNIXTIME(startDate))
							ORDER BY YEAR(FROM_UNIXTIME(startDate)) ASC")
							->execute(date("Y"));
		if($objJahre->numRows > 0) {
			while($objJahre->next()) {
				$arrJahre[] = array('single_year' => $objJahre->Start, 'year_href' => $objJahre->Start == $intYear ? '' : $this->strUrl . '?year=' . $objJahre->Start, 'active' => $objJahre->Start == $intYear ? 1 : 0);
			}
		}
		
		$this->Template = new \FrontendTemplate($this->strTemplate);
		$this->Template->display_year = $intYear;
		$this->Template->month = $intMonth;
		$this->Template->number_objekte = $objCategoryObjekte->numRows;
		$this->Template->objekte = $arrCategorieObjekte;
		$this->Template->number_year = $objJahre->numRows;
		$this->Template->selectable_year = $arrJahre;
		
		
		$this->Template->belegungsplan_category = $this->belegungsplan_category;
		$this->Template->belegungsplan_month = $this->belegungsplan_month;
		
		
		
		
		
		if(!empty($arrCategorieObjekte)) {
			unset($arrCategorieObjekte);
		}
		// Clear the $_GET array (see #2445)
		if($blnClearInput) {
			\Input::setGet('year', null);
			\Input::setGet('month', null);
		}
	}
}
