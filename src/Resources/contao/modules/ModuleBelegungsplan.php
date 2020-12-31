<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0-or-later
*/
namespace Mailwurm\Belegung;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Patchwork\Utf8;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
/**
* Class ModuleBelegungsplan
*
* @property array $belegungsplan_categories
* @property array $belegungsplan_month
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
	 * @var array
	 */
	protected $belegungsplan_category = array();
	
	/**
	 * @var string
	 */
	protected $strUrl;
	
	/**
	 * @var integer
	 */
	protected $intStartAuswahl;
	
	/**
	 * @var integer
	 */
	protected $intEndeAuswahl;
	
	/**
	 * @var integer
	 */
	protected $intAnzahlJahre;
	
	/**
	 * Display a wildcard in the back end
	 *
	 * @return string
	 */
	public function generate() 
	{
		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) 
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
		
		// Rueckgabe, wenn keine Kategorien vorhanden sind
		if (empty($this->belegungsplan_category)) 
		{
			return '';
		}
		// Rueckgabe, wenn es keinen Monat gibt
		if (empty($this->belegungsplan_month)) 
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
		
		// Monate sortieren
		$arrBelegungsplanMonth = $this->belegungsplan_month;
		sort($arrBelegungsplanMonth, SORT_NUMERIC);
		$this->belegungsplan_month = $arrBelegungsplanMonth;
		
		$blnClearInput = false;
		
		// wenn der letzte anzuzeigende Monat verstrichen ist automatisch das nächste Jahr anzeigen
		$intMax = (int) max($this->belegungsplan_month);
		
		$intYear = \Input::get('belegyear');
		// interner Zaehler
		$i = 0;
		
		// Aktuelle Periode bei Erstaufruf der Seite
		if (!isset($_GET['belegyear'])) {	
			$intYear = $intMax < (int) date('n') ? (int) date('Y') + 1 : (int) date('Y');
			$blnClearInput = true;
		} else {
			if (!empty($intYear)) {
				is_numeric($intYear) && strlen($intYear) === 4 ? ($intYear >= (int) date('Y') ? $intYear = (int) $intYear : $arrInfo[] = '4. ' . $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][2]) : $arrInfo[] = '1. ' . $GLOBALS['TL_LANG']['mailwurm_belegung']['info'][1];
			}
		}
		$intMinYear = $intMax < (int) date('n') ? (int) date('Y') + 1 : (int) date('Y');
		
		// wenn $arrInfo hier schon belegt, dann nicht erst weiter machen
		if (empty($arrInfo)) {
			// Anfang und Ende des Anzeigezeitraumes je nach GET
			if (!empty($intYear)) {
				$this->intStartAuswahl = (int) mktime(0, 0, 0, 1, 1, $intYear);
				$this->intEndeAuswahl = (int) mktime(23, 59, 59, 12, 31, $intYear);
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
			if ($objCategoryObjekte->numRows > 0) {
				while ($objCategoryObjekte->next()) {
					// Nicht anzuzeigende Kategorien aussortieren
					if (in_array($objCategoryObjekte->CategoryID, $this->belegungsplan_category)) {
						$arrHelper = array();
						$arrHelper['ObjektID'] = (int) $objCategoryObjekte->ObjektID;
						$arrHelper['ObjektName'] = \StringUtil::specialchars($objCategoryObjekte->ObjektName);
						$arrHelper['ObjektInfoText'] = $objCategoryObjekte->ObjektInfoText;
						if (array_key_exists($objCategoryObjekte->CategoryID, $arrCategorieObjekte)) {
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
			
			// Hole alle Calenderdaten zur Auswahl
			$objObjekteCalender = $this->Database->prepare("SELECT tbo.id as ObjektID,
							tbo.sorting as ObjektSortierung,
							tbcat.id as CategoryID,
							(CASE
								WHEN tbc.startDate < " . $this->intStartAuswahl . " THEN DAY(FROM_UNIXTIME(" . $this->intStartAuswahl . "))
								ELSE DAY(FROM_UNIXTIME(tbc.startDate))
							 END) as StartTag,
							 (CASE
								WHEN tbc.startDate < " . $this->intStartAuswahl . " THEN MONTH(FROM_UNIXTIME(" . $this->intStartAuswahl . "))
								ELSE MONTH(FROM_UNIXTIME(tbc.startDate))
							 END) as StartMonat,
							 (CASE
								WHEN tbc.startDate < " . $this->intStartAuswahl . " THEN YEAR(FROM_UNIXTIME(" . $this->intStartAuswahl . "))
								ELSE YEAR(FROM_UNIXTIME(tbc.startDate))
							 END) as StartJahr,
							 YEAR(FROM_UNIXTIME(tbc.startDate)) as BuchungsStartJahr,
							 (CASE
								WHEN tbc.endDate > " . $this->intEndeAuswahl . " THEN DAY(FROM_UNIXTIME(" . $this->intEndeAuswahl . "))
								ELSE DAY(FROM_UNIXTIME(tbc.endDate))
							 END) as EndeTag,
							 (CASE
								WHEN tbc.endDate > " . $this->intEndeAuswahl . " THEN MONTH(FROM_UNIXTIME(" . $this->intEndeAuswahl . "))
								ELSE MONTH(FROM_UNIXTIME(tbc.endDate))
							 END) as EndeMonat,
							 (CASE
								WHEN tbc.endDate > " . $this->intEndeAuswahl . " THEN YEAR(FROM_UNIXTIME(" . $this->intEndeAuswahl . "))
								ELSE YEAR(FROM_UNIXTIME(tbc.endDate))
							 END) as EndeJahr,
							 YEAR(FROM_UNIXTIME(tbc.endDate)) as BuchungsEndeJahr
						FROM 	tl_belegungsplan_calender tbc,
							tl_belegungsplan_objekte tbo,
							tl_belegungsplan_category tbcat
						WHERE 	tbc.pid = tbo.id
						AND		tbo.pid = tbcat.id
						AND 	tbo.published = 1
						AND		tbc.startDate < tbc.endDate
						AND 	((tbc.startDate < ? AND tbc.endDate >= ?) OR (tbc.startDate >= ? AND tbc.endDate <= ?) OR (tbc.startDate < ? AND tbc.endDate > ?))")
						->execute($this->intStartAuswahl, $this->intStartAuswahl, $this->intStartAuswahl, $this->intEndeAuswahl, $this->intEndeAuswahl, $this->intEndeAuswahl);
						
			if ($objObjekteCalender->numRows > 0) {
				while ($objObjekteCalender->next()) {
					// Ermittlung Anzahl der Tage des angegebenen Monats (28 - 31)
					$intEndeMonat = (int) date('t', mktime(0, 0, 0, (int) $objObjekteCalender->StartMonat, (int) $objObjekteCalender->StartTag, (int) $objObjekteCalender->StartJahr));
					// d = 1, m = 1, e = 31, y = 2021, z = 0
					for ($d = (int) $objObjekteCalender->StartTag, $m = (int) $objObjekteCalender->StartMonat, $e = $intEndeMonat, $y = (int) $objObjekteCalender->StartJahr, $z = 0; ;) {
						// erster Tag der Buchung und weitere
						if ($z === 0) {
							// nur anzuzeigende Monate auswaehlen
							if (in_array($m, $this->belegungsplan_month)) {
								// Sonderfall letzter Buchungstag faellt auf Neujahr
								if ((int) $objObjekteCalender->BuchungsStartJahr < (int) $objObjekteCalender->BuchungsEndeJahr && (int) $objObjekteCalender->EndeTag === 1 && (int) $objObjekteCalender->EndeMonat === 1 && (int) $objObjekteCalender->StartTag === 1 && (int) $objObjekteCalender->StartMonat === 1)
								{
									if ($arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d])
									{
										$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = '1#1';
									} else {
										$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = '1#0';
									}
									break;
								}
								$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d], 0);
							}
							// Sonderfall Sylvester
							if ($d === 31 && $m === 12)
							{
								break;
							}
						} elseif ($y === (int) $objObjekteCalender->EndeJahr && $m === (int) $objObjekteCalender->EndeMonat && $d === (int) $objObjekteCalender->EndeTag) {
							// nur anzuzeigende Monate auswaehlen
							if (in_array($m, $this->belegungsplan_month)) {
								$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d], 1);
							}
							break;
						} else {
							// nur anzuzeigende Monate auswaehlen
							if (in_array($m, $this->belegungsplan_month)) {
								$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = '1#1';
							}
						}
						if ($d === $e) {
							if ((int) $objObjekteCalender->StartMonat === (int) $objObjekteCalender->EndeMonat) {
								// nur anzuzeigende Monate auswaehlen
								if (in_array($m, $this->belegungsplan_month)) {
									$arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$m][$d] = '1#0';
								}
								break;
							}
							$m++;
							$d = 0;
							$e = (int) date('t', mktime(0, 0, 0, $m, $d + 1, $y));
						}
						$d++;
						$z++;
					}
				}
			}
			
			// Hole alle Jahre fuer die bereits Buchungen vorhanden sind ab dem aktuellen Jahr
			$objJahre = $this->Database->prepare("	SELECT YEAR(FROM_UNIXTIME(tbc.startDate)) as Start 
								FROM tl_belegungsplan_calender tbc,
									tl_belegungsplan_objekte tbo
								WHERE YEAR(FROM_UNIXTIME(tbc.startDate)) >= ? 
								AND tbc.pid = tbo.id
								AND tbo.published = 1
								GROUP BY YEAR(FROM_UNIXTIME(tbc.startDate))
								ORDER BY YEAR(FROM_UNIXTIME(tbc.startDate)) ASC")
								->execute($intMinYear);
			$this->intAnzahlJahre = $objJahre->numRows;
			if ($this->intAnzahlJahre > 0) {
				while ($objJahre->next()) {
					$arrJahre[] = array('single_year' => $objJahre->Start, 'year_href' => $this->strUrl . '?belegyear=' . $objJahre->Start, 'active' => $objJahre->Start == $intYear ? 1 : 0);
				}
			}
		}
		// Templatewaehler
		if (($this->belegungsplan_template != $this->strTemplate) && ($this->belegungsplan_template != '')) 
		{
			$this->strTemplate = $this->belegungsplan_template;
			$this->Template = new \FrontendTemplate($this->strTemplate);
		}
		// Info-Array zur Ausgabe von Fehlern, Warnings und Defaults
		$this->Template->info = $arrInfo;
		// aktuell anzuzeigendes Jahr, wenn \Input::get('belegyear');
		$this->Template->display_year = $intYear;
		// Anzahl der anzuzeigenden Jahre fuer welche Reservierungen vorliegen
		$this->Template->number_year = $this->intAnzahlJahre;
		// Jahreszahlen fuer die Auswahlbox
		$this->Template->selectable_year = $arrJahre;
		// Anzahl anzuzeigender Objekte
		$this->Template->number_objekte = $i;
		// Kategorien sortieren wie im Checkboxwizard ausgewaehlt -> Elterntabelle
		$this->Template->CategorieObjekteCalender = $this->sortNachWizard($arrCategorieObjekte, $this->belegungsplan_category);
		// Array mit den Monatsdaten
		$this->Template->Month = $this->dataMonth($arrBelegungsplanMonth, $this->intStartAuswahl, $this->getFeiertage($this->intStartAuswahl,$this->intEndeAuswahl));
		// Text fuer Legende
		$this->Template->Frei = $GLOBALS['TL_LANG']['mailwurm_belegung']['legende']['frei'];
		$this->Template->Belegt = $GLOBALS['TL_LANG']['mailwurm_belegung']['legende']['belegt'];
		// Farben fuer Legende
		// RGBA
		$this->Template->RgbaFrei = 'rgba('.$this->belegungsplan_color_frei.','.$this->belegungsplan_opacity_frei.')';
		$this->Template->RgbaBelegt = 'rgba('.$this->belegungsplan_color_belegt.','.$this->belegungsplan_opacity_belegt.')';
		$this->Template->RgbaText = 'rgba('.$this->belegungsplan_color_text.','.$this->belegungsplan_opacity_text.')';
		$this->Template->RgbaRahmen = 'rgba('.$this->belegungsplan_color_rahmen.','.$this->belegungsplan_opacity_rahmen.')';
		$this->Template->AnzeigeKategorie = $this->belegungsplan_anzeige_kategorie;
		$this->Template->RgbaKategorie = 'rgba('.$this->belegungsplan_color_kategorie.','.$this->belegungsplan_opacity_kategorie.')';
		$this->Template->RgbaKategorietext = 'rgba('.$this->belegungsplan_color_kategorietext.','.$this->belegungsplan_opacity_kategorietext.')';
		$this->Template->AnzeigeLegende = $this->belegungsplan_anzeige_legende;
		$this->Template->RgbaTextLegendeFrei = 'rgba('.$this->belegungsplan_color_legende_frei.','.$this->belegungsplan_opacity_legende.')';
		$this->Template->RgbaTextLegendeBelegt = 'rgba('.$this->belegungsplan_color_legende_belegt.','.$this->belegungsplan_opacity_legende.')';
		$this->Template->AnzeigeWochenende = $this->belegungsplan_anzeige_wochenende;
		$this->Template->RgbaBgWochenende = 'rgba('.$this->belegungsplan_bgcolor_wochenende.','.$this->belegungsplan_opacity_bg_wochenende.')';
		$this->Template->RgbaWochenendetext = 'rgba('.$this->belegungsplan_color_wochenendetext.','.$this->belegungsplan_opacity_wochenendetext.')';
		// Opacitywerte
		$this->Template->OpacityFrei = $this->belegungsplan_opacity_frei;
		$this->Template->OpacityBelegt = $this->belegungsplan_opacity_belegt;
		$this->Template->OpacityText = $this->belegungsplan_opacity_text;
		$this->Template->OpacityRahmen = $this->belegungsplan_opacity_rahmen;
		$this->Template->OpacityKategorie = $this->belegungsplan_opacity_kategorie;
		$this->Template->OpacityKategorietext = $this->belegungsplan_opacity_kategorietext;
		$this->Template->OpacityLegende = $this->belegungsplan_opacity_legende;
		$this->Template->OpacityBgWochenende = $this->belegungsplan_opacity_bg_wochenende;
		$this->Template->OpacityWochenendetext = $this->belegungsplan_opacity_wochenendetext;
		
		if (!empty($arrCategorieObjekte)) {
			unset($arrCategorieObjekte);
		}
		if (!empty($arrInfo)) {
			unset($arrInfo);
		}
		if (!empty($arrFeiertage)) {
			unset($arrFeiertage);
		}
		// Clear the $_GET array (see #2445)
		if ($blnClearInput) {
			\Input::setGet('belegyear', null);
		}
	}
	
	/**
	 * Sortiert die Kategorien nach Auswahl im Checkbox-Wizard
	 *
	 * @param array $arrCategorieObjekte
	 * @param array $arrBelegungsplanCategory
	 *
	 * @return array
	 */
	protected function sortNachWizard($arrCategorieObjekte, $arrBelegungsplanCategory)
	{	
		// Schluessel und Werte tauschen
		$arrHelper = array_flip($arrBelegungsplanCategory);
		
		foreach ($arrHelper as $key => $value) {
			if (array_key_exists($key, $arrCategorieObjekte)) {
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
	 * @param array $arrMonth
	 * @param integer $intStartAuswahl
	 * @param array $arrFeiertage
	 *
	 * @return array
	 */
	protected function dataMonth($arrMonth, $intStartAuswahl, $arrFeiertage)
	{
		$arrHelper = array();
		$intJahr = date('Y', $intStartAuswahl);
		foreach ($arrMonth as $key => $value) {
			$arrHelper[$value]['Name'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['month'][$value];
			$arrHelper[$value]['TageMonat'] = (int) date('t', mktime(0, 0, 0, (int) $value, 1, (int) $intJahr));
			$arrHelper[$value]['ColSpan'] = $arrHelper[$value]['TageMonat'] + 1;
			$intFirstDayInMonth = (int) date('N', mktime(0, 0, 0, (int) $value, 1, (int) $intJahr));
			for ($f = 1, $i = $intFirstDayInMonth; $f <= $arrHelper[$value]['TageMonat']; $f++) {
				$strClass = '';
				$arrHelper[$value]['Days'][$f]['Day'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['day'][$i];
				$arrHelper[$value]['Days'][$f]['DayCut'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['short_cut_day'][$i];
				$arrHelper[$value]['Days'][$f]['DayWeekNum'] = $i;
				if ($arrFeiertage[$intJahr][$value][$f])
				{
					$strClass .= 'holiday';
					$arrHelper[$value]['Days'][$f]['Title'] = $arrFeiertage[$intJahr][$value][$f]['Title'];
					$arrHelper[$value]['Days'][$f]['Style'] = $arrFeiertage[$intJahr][$value][$f]['Style'];
				}
				if (empty($strClass))
				{
					$strClass .= $i === 6 ? 'saturday' : ($i === 7 ? 'sunday' : '');
				}
				$arrHelper[$value]['Days'][$f]['Class'] = trim($strClass);
				$i === 7 ? $i = 1 : $i++;
			}
		}
		unset($intJahr);
		unset($arrFeiertage);
		return $arrHelper;
	}
	
	/**
	 * Ausgabe fuer Kalender
	 *
	 * @param integer $intBuchungsStartJahr
	 * @param integer $intBuchungsEndeJahr
	 * @param integer $intY
	 * @param array $arrCategoriesObjekte
	 * @param integer $z
	 *
	 * @return string
	 */
	protected function includeCalender($intBuchungsStartJahr, $intBuchungsEndeJahr, $intY, $arrCategoriesObjekte, $z)
	{
		$strReturn = '';
		$intBuchungJahr = empty($z) ? (int) $intBuchungsStartJahr : (int) $intBuchungsEndeJahr;
		// bei Jahresuebergreifender Buchung
		if ((int) $intBuchungsStartJahr != (int) $intBuchungsEndeJahr) {
			// bei Jahresuebergreifender Buchung
			if ($intY === $intBuchungJahr)
			{
				$strReturn = empty($z) ? '0#1' : '1#0';
			} else {
				$strReturn = '1#1';
			}
		} else {
			// wenn letzter Tag einer Buchung gleich dem ersten Tag einer neuer Buchung
			if (isset($arrCategoriesObjekte))
			{
				$strReturn = '1#1';
			} else {
				$strReturn = empty($z) ? '0#1' : '1#0';
			}
		}
		return $strReturn;
	}
	/**
	 * Holt alle Feiertage
	 *
	 * @param integer $intStartAuswahl
	 * @param integer $intEndeAuswahl
	 *
	 * @return array
	 */
	protected function getFeiertage($intStartAuswahl, $intEndeAuswahl)
	{
		$arrFeiertage = array();
		$objFeiertage = $this->Database->prepare("SELECT DAY(FROM_UNIXTIME(startDate)) as Tag,
									MONTH(FROM_UNIXTIME(startDate)) as Monat,
									YEAR(FROM_UNIXTIME(startDate)) as Jahr,
									title, ausgabe, hintergrund, opacity, textcolor, textopacity
							FROM 	tl_belegungsplan_feiertage
							WHERE 	startDate >= " . $intStartAuswahl . "
							AND 	startDate <= " . $intEndeAuswahl . "
							AND		ausgabe = 1")
							->execute();
		if ($objFeiertage->numRows > 0)
		{
			while ($objFeiertage->next())
			{
				$arrFeiertage[$objFeiertage->Jahr][$objFeiertage->Monat][$objFeiertage->Tag] = array
				(
					'Title' => $objFeiertage->title,
					'Style' => " style='background-color:rgba(".$objFeiertage->hintergrund.",".$objFeiertage->opacity.");color:rgba(".$objFeiertage->textcolor.",".$objFeiertage->textopacity.");cursor:pointer;'"
				);
			}
		}
		return $arrFeiertage;
	}
}
