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
	* Current date object
	* @var Date
	*/
	protected $Date;
	
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
			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['belegungsplan'][0]) . ' ###';
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
		$arrInfo = array();
		
		$arrCategorieObjekte = array();
		$arrJahre = array();

		$blnClearInput = false;
		
		$intYear = \Input::get('belegyear');
		$intMonth = \Input::get('belegmonth');
		// interner Zaehler
		$i = 0;
		
		// Aktuelle Periode bei Erstaufruf der Seite
		if (!isset($_GET['belegyear']) && !isset($_GET['belegmonth']))
		{
			$intYear = date('Y');
			$blnClearInput = true;
		} else {
			if($intYear) {
				is_numeric($intYear) && strlen($intYear) === 4 ? ($intYear >= date('Y') ? $intYear = intval($intYear) : $arrInfo[] = $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][2]) : $arrInfo[] = $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][1];
			}
			if($intMonth) {
				is_numeric($intMonth) && strlen($intMonth) === 6 ? (substr($intMonth, 4) >= date('Y') ? $intMonth = intval($intMonth) : $arrInfo[] = $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][2]) : $arrInfo[] = $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][1];
			}
		}
		
		// wenn $arrInfo hier schon belegt, dann nicht erst weiter machen
		if(empty($arrInfo)) {
			// Hole alle aktiven Objekte inklusive dazugehoeriger Kategorie
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
					// Nicht anzuzeigende Kategorien aussortieren
					if(in_array($objCategoryObjekte->CategoryID, $this->belegungsplan_category)) {
						$arrHelper = array();
						$arrHelper['ObjektID'] = $objCategoryObjekte->ObjektID;
						$arrHelper['ObjektName'] = $objCategoryObjekte->ObjektName;
						$arrHelper['ObjektInfoText'] = $objCategoryObjekte->ObjektInfoText;
						if(array_key_exists($objCategoryObjekte->CategoryID, $arrCategorieObjekte)) {
							$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
							$i++;
						} else {
							$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['CategoryTitle'] = \StringUtil::specialchars($objCategoryObjekte->CategoryTitle);
							$arrCategorieObjekte[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
							$i++;
						}
						unset($arrHelper);
					}
				}
			} else {
				$arrInfo[] = $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][0];
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
					$arrJahre[] = array('single_year' => $objJahre->Start, 'year_href' => $objJahre->Start == $intYear ? '' : $this->strUrl . '?belegyear=' . $objJahre->Start, 'active' => $objJahre->Start == $intYear ? 1 : 0);
				}
			}
		}
		
		$this->Template = new \FrontendTemplate($this->strTemplate);
		// Info-Array zur Ausgabe von Fehlern, Warnings und Defaults
		$this->Template->info = $arrInfo;
		// aktuell anzuzeigendes Jahr, wenn \Input::get('year');
		$this->Template->display_year = $intYear;
		// aktuell anzuzeigender Monat, wenn \Input::get('month');
		$this->Template->display_month = $intMonth;
		// Anzahl der anzuzeigenden Jahre fuer welche Reservierungen vorliegen
		$this->Template->number_year = $objJahre->numRows;
		// Jahreszahlen fuer die Auswahlbox
		$this->Template->selectable_year = $arrJahre;
		// Anzahl anzuzeigender Objekte
		$this->Template->number_objekte = $i;
		$this->Template->CategorieObjekteCalender = $arrCategorieObjekte;
		
		
		
		$this->Template->belegungsplan_category = $this->belegungsplan_category;
		$this->Template->belegungsplan_month = $this->belegungsplan_month;
		
		
		
		
		
		if(!empty($arrCategorieObjekte)) {
			unset($arrCategorieObjekte);
		}
		if(!empty($arrInfo)) {
			unset($arrInfo);
		}
		// Clear the $_GET array (see #2445)
		if($blnClearInput) {
			\Input::setGet('belegyear', null);
			\Input::setGet('belegmonth', null);
		}
	}
}
