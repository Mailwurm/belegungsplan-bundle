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
* @property array $belegungsplan_month
* @property integer $intStartAuswahl
* @property integer $intEndeAuswahl
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
		$arrObjekteCalender = array();
		$intStartAuswahl = 0;
		$intEndeAuswahl = 0;
		// Monate sortieren
		$arrBelegungsplanMonth = $this->belegungsplan_month;
		sort($arrBelegungsplanMonth, SORT_NUMERIC);
		$this->belegungsplan_month = $arrBelegungsplanMonth;
		
		$blnClearInput = false;
		
		// wenn der letzte anzuzeigende Monat verstrichen ist automatisch das nächste Jahr anzeigen
		$intMax = (int)max($this->belegungsplan_month);
		
		$intYear = \Input::get('belegyear');
		// interner Zaehler
		$i = 0;
		
		// Aktuelle Periode bei Erstaufruf der Seite
		if (!isset($_GET['belegyear'])) {	
			$intYear = $intMax < (int)date('n') ? (int)date('Y') + 1 : (int)date('Y');
			$blnClearInput = true;
		} else {
			if(!empty($intYear)) {
				is_numeric($intYear) && strlen($intYear) === 4 ? ($intYear >= (int)date('Y') ? $intYear = (int)$intYear : $arrInfo[] = '4. ' . $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][2]) : $arrInfo[] = '1. ' . $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][1];
			}
		}
		
		// wenn $arrInfo hier schon belegt, dann nicht erst weiter machen
		if(empty($arrInfo)) {
			// Anfang und Ende des Anzeigezeitraumes je nach GET
			if(!empty($intYear)) {
				$intStartAuswahl = mktime(0, 0, 0, 1, 1, $intYear);
				$intEndeAuswahl = mktime(23, 59, 59, 12, 31, $intYear);
			}
			
			// Hole alle Calenderdaten zur Auswahl
			$objObjekteCalender = $this->Database->prepare("SELECT tbo.id as ObjektID,
										(CASE
											WHEN tbc.startDate < ".$intStartAuswahl." THEN DAY(FROM_UNIXTIME(".$intStartAuswahl."))
											ELSE DAY(FROM_UNIXTIME(tbc.startDate))
										 END) as StartTag,
										 (CASE
											WHEN tbc.startDate < ".$intStartAuswahl." THEN MONTH(FROM_UNIXTIME(".$intStartAuswahl."))
											ELSE MONTH(FROM_UNIXTIME(tbc.startDate))
										 END) as StartMonat,
										 (CASE
											WHEN tbc.startDate < ".$intStartAuswahl." THEN YEAR(FROM_UNIXTIME(".$intStartAuswahl."))
											ELSE YEAR(FROM_UNIXTIME(tbc.startDate))
										 END) as StartJahr,
										 (CASE
											WHEN tbc.endDate > ".$intEndeAuswahl." THEN DAY(FROM_UNIXTIME(".$intEndeAuswahl."))
											ELSE DAY(FROM_UNIXTIME(tbc.endDate))
										 END) as EndeTag,
										 (CASE
											WHEN tbc.endDate > ".$intEndeAuswahl." THEN MONTH(FROM_UNIXTIME(".$intEndeAuswahl."))
											ELSE MONTH(FROM_UNIXTIME(tbc.endDate))
										 END) as EndeMonat,
										 (CASE
											WHEN tbc.endDate > ".$intEndeAuswahl." THEN YEAR(FROM_UNIXTIME(".$intEndeAuswahl."))
											ELSE YEAR(FROM_UNIXTIME(tbc.endDate))
										 END) as EndeJahr
									FROM 	tl_belegungsplan_calender tbc,
											tl_belegungsplan_objekte tbo
									WHERE 	tbc.pid = tbo.id
									AND 	tbo.published = 1
									AND 	((startDate < ".$intStartAuswahl." AND endDate > ".$intStartAuswahl.") OR (startDate >= ".$intStartAuswahl." AND endDate <= ".$intEndeAuswahl.") OR (startDate < ".$intEndeAuswahl." AND endDate > ".$intEndeAuswahl."))")
									->execute();
			if($objObjekteCalender->numRows > 0) {
				while($objObjekteCalender->next()) {
					$arrHelper = array();
					$arrHelper['ObjektID'] = $objObjekteCalender->ObjektID;
					$arrHelper['StartTag'] = (int)$objObjekteCalender->StartTag;
					$arrHelper['StartMonat'] = (int)$objObjekteCalender->StartMonat;
					$arrHelper['StartJahr'] = (int)$objObjekteCalender->StartJahr;
					$arrHelper['EndeTag'] = (int)$objObjekteCalender->EndeTag;
					$arrHelper['EndeMonat'] = (int)$objObjekteCalender->EndeMonat;
					$arrHelper['EndeJahr'] = (int)$objObjekteCalender->EndeJahr;
					$intEndeMonat = (int)date('t', mktime(0, 0, 0, $arrHelper['StartMonat'], $arrHelper['StartTag'], $arrHelper['StartJahr']));
					for($d = $arrHelper['StartTag'], $m = $arrHelper['StartMonat'], $e = $intEndeMonat, $y = $arrHelper['StartJahr'], $z = 0; ; ) {
						// erster Tag der Buchung und weitere
						empty($z) ? $arrObjekteCalender[$objObjekteCalender->ObjektID][$m][$d] = '0#1' : $arrObjekteCalender[$objObjekteCalender->ObjektID][$m][$d] = '1#1';
						if($d === $e) {
							if($arrHelper['StartMonat'] === $arrHelper['EndeMonat']) {
								break;
							}
							$m++;
							$d = 0;
							$e = (int)date('t', mktime(0, 0, 0, $m, $d + 1, $y));
						}
						if($y === $arrHelper['EndeJahr'] && $m === $arrHelper['EndeMonat'] && $d === $arrHelper['EndeTag']) {
							// letzter Tag der Buchung
							$arrObjekteCalender[$objObjekteCalender->ObjektID][$m][$d] = '1#0';
							break;
						}
						$d++;
						$z++;
					}
					unset($arrHelper);
				}
			}
			
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
						$arrHelper['ObjektID'] = (int)$objCategoryObjekte->ObjektID;
						$arrHelper['ObjektName'] = $objCategoryObjekte->ObjektName;
						$arrHelper['ObjektInfoText'] = $objCategoryObjekte->ObjektInfoText;
						// Calender anfügen wenn vorhanden
						if(array_key_exists($arrHelper['ObjektID'], $arrObjekteCalender)) {
							$arrHelper['Calender'] = $arrObjekteCalender[$arrHelper['ObjektID']];
							unset($arrObjekteCalender[$arrHelper['ObjektID']]);
						}
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
				$arrInfo[] = '3. ' . $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][0];
			}
			
			// Hole alle Jahre fuer die bereits Buchungen vorhanden sind ab dem aktuellen Jahr
			$objJahre = $this->Database->prepare("	SELECT YEAR(FROM_UNIXTIME(startDate)) as Start 
								FROM tl_belegungsplan_calender tbc,
									tl_belegungsplan_objekte tbo
								WHERE YEAR(FROM_UNIXTIME(startDate)) >= ? 
								AND tbc.pid = tbo.id
								AND tbo.published = 1
								GROUP BY YEAR(FROM_UNIXTIME(startDate))
								ORDER BY YEAR(FROM_UNIXTIME(startDate)) ASC")
								->execute(date("Y"));
			if($objJahre->numRows > 0) {
				while($objJahre->next()) {
					$arrJahre[] = array('single_year' => $objJahre->Start, 'year_href' => $this->strUrl . '?belegyear=' . $objJahre->Start, 'active' => $objJahre->Start == $intYear ? 1 : 0);
				}
			}
		}
		
		$this->Template = new \FrontendTemplate($this->strTemplate);
		// Info-Array zur Ausgabe von Fehlern, Warnings und Defaults
		$this->Template->info = $arrInfo;
		// aktuell anzuzeigendes Jahr, wenn \Input::get('year');
		$this->Template->display_year = $intYear;
		// Anzahl der anzuzeigenden Jahre fuer welche Reservierungen vorliegen
		$this->Template->number_year = $objJahre->numRows;
		// Jahreszahlen fuer die Auswahlbox
		$this->Template->selectable_year = $arrJahre;
		// Anzahl anzuzeigender Objekte
		$this->Template->number_objekte = $i;
		// Kategorien sortieren wie im Checkboxwizard ausgewaehlt -> Elterntabelle
		$this->Template->CategorieObjekteCalender = $this->sortNachWizard($arrCategorieObjekte, $this->belegungsplan_category);
		// Array mit den Monatsdaten
		$this->Template->Month = $this->dataMonth($arrBelegungsplanMonth, $intStartAuswahl);
		#$this->Template->Start = $intStartAuswahl;
		#$this->Template->Ende = $intEndeAuswahl;
		#$this->Template->Monate = $arrBelegungsplanMonth;
		#$this->Template->MaxMonat = $intMax;
		
		if(!empty($arrCategorieObjekte)) {
			unset($arrCategorieObjekte);
		}
		if(!empty($arrInfo)) {
			unset($arrInfo);
		}
		// Clear the $_GET array (see #2445)
		if($blnClearInput) {
			\Input::setGet('belegyear', null);
		}
	}
	
	/**
	* Sortiert die Kategorien nach Auswahl im Checkbox-Wizard
	*
	* @return array
	*/
	protected function sortNachWizard($arrCategorieObjekte, $arrBelegungsplanCategory)
	{	
		// Schluessel und Werte tauschen
		$arrHelper = array_flip($arrBelegungsplanCategory);
		
		foreach($arrHelper as $key => $value) {
			if(array_key_exists($key, $arrCategorieObjekte)) {
				$arrHelper[$key] = $arrCategorieObjekte[$key];
				// Objekte in der Kategorie gleich mit nach DB sortieren
				ksort($arrHelper[$key]['Objekte']);
			} else {
				unset($arrHelper[$key]);
			}
		}
		// leere Einträge entfernen
		return $arrHelper;
	}
	
	/**
	* Fuegt den Monaten Daten hinzu
	*
	* @return array
	*/
	protected function dataMonth($arrMonth, $intStartAuswahl)
	{
		$arrHelper = array();
		$intJahr = date('Y', $intStartAuswahl);
		foreach($arrMonth as $key => $value) {
			$arrHelper[$value]['Name'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['month'][$value];
			$arrHelper[$value]['TageMonat'] = (int)date('t', mktime(0, 0, 0, (int)$value, 1, (int)$intJahr));
			$intFirstDayInMonth = (int)date('N', mktime(0, 0, 0, (int)$value, 1, (int)$intJahr));
			for($f = 1, $i = $intFirstDayInMonth; $f <= $arrHelper[$value]['TageMonat']; $f++) {
				$arrHelper[$value]['Days'][$f]['Day'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['day'][$i];
				$arrHelper[$value]['Days'][$f]['DayCut'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['short_cut_day'][$i];
				$arrHelper[$value]['Days'][$f]['DayWeekNum'] = $i;
				$i === 7 ? $i = 1 : $i++;
			}
		}
		unset($intJahr);
		return $arrHelper;
	}
}
