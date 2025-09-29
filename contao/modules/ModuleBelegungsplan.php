<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

namespace Mailwurm\Belegung;

use Contao\BackendTemplate;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;

/**
 * Class ModuleBelegungsplan.
 *
 * @property array $belegungsplan_categories
 * @property array $belegungsplan_month
 */
class ModuleBelegungsplan extends Module
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'mod_belegungsplan';

    /**
     * @var array
     */
    protected $belegungsplan_category = [];

    /**
     * @var string
     */
    protected $strUrl;

    /**
     * @var int
     */
    protected $intStartAuswahl;

    /**
     * @var int
     */
    protected $intEndeAuswahl;

    /**
     * @var int
     */
    protected $intAnzahlJahre;

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();
        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['belegungsplan'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }
        $this->belegungsplan_category = StringUtil::deserialize($this->belegungsplan_categories);
        $this->belegungsplan_month = StringUtil::deserialize($this->belegungsplan_month);
        $this->belegungsplan_showAusgabe = StringUtil::specialchars($this->belegungsplan_showAusgabe);
        $this->belegungsplan_anzahlMonate = (int) $this->belegungsplan_anzahlMonate;
        // aktuelle Seiten URL
        $this->strUrl = preg_replace('/\?.*$/', '', Environment::get('request'));

        // Rueckgabe, wenn keine Kategorien vorhanden sind
        if (empty($this->belegungsplan_category)) {
            return '';
        }
        // Rueckgabe, wenn es keinen Monat gibt
        if (empty($this->belegungsplan_month)) {
            return '';
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        $arrInfo = [];
        $arrCategorieObjekte = [];
        $arrCategorieObjekteCalender = [];
        $arrJahre = [];
        $intYear = '';

        // Auswahl nach Anzeige-Modus
        if ('standard' === $this->belegungsplan_showAusgabe) {
            // Monate sortieren
            $arrBelegungsplanMonth = $this->belegungsplan_month;
            sort($arrBelegungsplanMonth, SORT_NUMERIC);
            $this->belegungsplan_month = $arrBelegungsplanMonth;
            $blnClearInput = false;

            // wenn der letzte anzuzeigende Monat verstrichen ist automatisch das nächste
            // Jahr anzeigen
            $intMax = (int) max($this->belegungsplan_month);

            $intYear = Input::get('belegyear');

            // Aktuelle Periode bei Erstaufruf der Seite
            if (!isset($_GET['belegyear'])) {
                $intYear = $intMax < (int) date('n') ? (int) date('Y') + 1 : (int) date('Y');
                $blnClearInput = true;
            } else {
                if (!empty($intYear)) {
                    is_numeric($intYear) && 4 === \strlen($intYear) ? ($intYear >= (int) date('Y') ? $intYear = (int) $intYear : $arrInfo[] = '4. '.$GLOBALS['TL_LANG']['mailwurm_belegung']['info'][2]) : $arrInfo[] = '1. '.$GLOBALS['TL_LANG']['mailwurm_belegung']['info'][1];
                }
            }

            $intMinYear = $intMax < (int) date('n') ? (int) date('Y') + 1 : (int) date('Y');

            // Anfang und Ende des Anzeigezeitraumes je nach GET
            if (!empty($intYear)) {
                $this->intStartAuswahl = (int) mktime(0, 0, 0, 1, 1, $intYear);
                $this->intEndeAuswahl = (int) mktime(23, 59, 59, 12, 31, $intYear);
            }
        } elseif ('automatic' === $this->belegungsplan_showAusgabe) {
            // Anzahl Monate anzeigen ab aktuellem Datum
            $this->intStartAuswahl = (int) mktime(0, 0, 0, (int) date('m'), 1, (int) date('Y'));
            $this->intEndeAuswahl = (int) strtotime('+'.$this->belegungsplan_anzahlMonate.' Months', $this->intStartAuswahl) - 1;
        } elseif ('individuell' === $this->belegungsplan_showAusgabe) {
            if (empty($this->belegungsplan_individuellMonateStart) || empty($this->belegungsplan_individuellMonateEnde)) {
                $arrInfo[] = '6. '.$GLOBALS['TL_LANG']['mailwurm_belegung']['info'][4];
            } else {
                // selbst festgelegter Zeitraum
                $aStart = StringUtil::deserialize($this->belegungsplan_individuellMonateStart);
                $aEnde = StringUtil::deserialize($this->belegungsplan_individuellMonateEnde);
                $iAnzahlTageEndeMonat = (int) date('t', (int) mktime(0, 0, 0, (int) $aEnde['unit'], 1, (int) $aEnde['value']));
                $this->intStartAuswahl = (int) mktime(0, 0, 0, (int) $aStart['unit'], 1, (int) $aStart['value']);
                $this->intEndeAuswahl = (int) mktime(23, 59, 59, (int) $aEnde['unit'], $iAnzahlTageEndeMonat, (int) $aEnde['value']);
            }
        } else {
            $arrInfo[] = '5. '.$GLOBALS['TL_LANG']['mailwurm_belegung']['info'][3];
        }

        // wenn $arrInfo hier schon belegt, dann nicht erst weiter machen
        if (empty($arrInfo)) {
            // Hole alle aktiven Objekte inklusive dazugehoeriger aktiver Kategorien
            $arrCategorieObjekte = $this->getCategorieObjekte();
            // Wenn keine Kategorien oder Objekte verfügbar sind
            if (empty($arrCategorieObjekte)) {
                $arrInfo[] = '3. '.$GLOBALS['TL_LANG']['mailwurm_belegung']['info'][0];
            }
            // Hole alle Kalenderdaten zur Auswahl
            $arrCategorieObjekteCalender = $this->getObjekteCalender($this->intStartAuswahl, $this->intEndeAuswahl, $arrCategorieObjekte, $this->belegungsplan_showAusgabe);

            if ('standard' === $this->belegungsplan_showAusgabe) {
                $arrJahre = $this->getYears($intMinYear, $intYear);
                $this->intAnzahlJahre = \count($arrJahre);
            }
        }
        // Templatewaehler
        if (($this->belegungsplan_template !== $this->strTemplate) && ('' !== $this->belegungsplan_template)) {
            $this->strTemplate = $this->belegungsplan_template;
            $this->Template = new FrontendTemplate($this->strTemplate);
        }
        if (!empty($arrInfo)) {
            // Info-Array zur Ausgabe von Fehlern, Warnings und Defaults
            $this->Template->info = $arrInfo;
        } else {
            // aktuell anzuzeigendes Jahr, wenn Input::get('belegyear');
            $this->Template->display_year = $intYear;
            // Anzahl der anzuzeigenden Jahre fuer welche Reservierungen vorliegen
            $this->Template->number_year = $this->intAnzahlJahre;
            // Jahreszahlen fuer die Auswahlbox
            $this->Template->selectable_year = $arrJahre;
            // Kategorien sortieren wie im Checkboxwizard ausgewaehlt -> Elterntabelle
            $this->Template->CategorieObjekteCalender = $this->sortNachWizard($arrCategorieObjekteCalender, $this->belegungsplan_category);
            // Array mit den Monatsdaten
            if ('standard' === $this->belegungsplan_showAusgabe) {
                $this->Template->Month = $this->dataMonth($arrBelegungsplanMonth, $this->intStartAuswahl, $this->getFeiertage($this->intStartAuswahl, $this->intEndeAuswahl));
            } else {
                $this->Template->Month = $this->dataMonthIndividuell($this->intStartAuswahl, $this->intEndeAuswahl, $this->getFeiertage($this->intStartAuswahl, $this->intEndeAuswahl));
            }
            // Text fuer Legende
            $this->Template->Frei = $GLOBALS['TL_LANG']['mailwurm_belegung']['legende']['frei'];
            $this->Template->Belegt = $GLOBALS['TL_LANG']['mailwurm_belegung']['legende']['belegt'];
            // Farben fuer Legende RGBA
            $this->Template->RgbaFrei = 'rgba('.$this->belegungsplan_color_frei.','.$this->belegungsplan_opacity_frei.')';
            $this->Template->RgbaBelegt = 'rgba('.$this->belegungsplan_color_belegt.','.$this->belegungsplan_opacity_belegt.')';
            $this->Template->RgbaText = 'rgba('.$this->belegungsplan_color_text.','.$this->belegungsplan_opacity_text.')';
            $this->Template->LinkText = $this->belegungsplan_anzeige_linkText;
            $this->Template->LineNone = $this->belegungsplan_textDecorationLine;
            $this->Template->RgbaLinkText = 'rgba('.$this->belegungsplan_color_linkText.','.$this->belegungsplan_opacity_linkText.')';
            $this->Template->TextDecorationLine = 'text-decoration: '.$this->belegungsplan_textDecorationLine.';';
            $this->Template->TextDecorationStyle = 'text-decoration-style: '.$this->belegungsplan_textDecorationStyle.';';
            $this->Template->RgbaRahmen = 'rgba('.$this->belegungsplan_color_rahmen.','.$this->belegungsplan_opacity_rahmen.')';
            $this->Template->AnzeigeKategorie = $this->belegungsplan_anzeige_kategorie;
            $this->Template->RgbaKategorie = 'rgba('.$this->belegungsplan_color_kategorie.','.$this->belegungsplan_opacity_kategorie.')';
            $this->Template->RgbaKategorietext = 'rgba('.$this->belegungsplan_color_kategorietext.','.$this->belegungsplan_opacity_kategorietext.')';
            $this->Template->LinkKategorie = $this->belegungsplan_anzeige_linkKategorie;
            $this->Template->RgbaLinkKategorie = 'rgba('.$this->belegungsplan_color_linkKategorie.','.$this->belegungsplan_opacity_linkKategorie.')';
            $this->Template->KategorieDecorationLine = 'text-decoration: '.$this->belegungsplan_kategorieDecorationLine.';';
            $this->Template->KategorieDecorationStyle = 'text-decoration-style: '.$this->belegungsplan_kategorieDecorationStyle.';';
            $this->Template->LineKategorieNone = $this->belegungsplan_kategorieDecorationLine;
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
            if (!empty($arrCategorieObjekteCalender)) {
                unset($arrCategorieObjekteCalender);
            }
            if (!empty($arrInfo)) {
                unset($arrInfo);
            }
            if (!empty($arrFeiertage)) {
                unset($arrFeiertage);
            }
            // Clear the $_GET array (see #2445)
            if (isset($blnClearInput) && true === $blnClearInput) {
                Input::setGet('belegyear', null);
            }
        }
    }

    /**
     * Sortiert die Kategorien nach Auswahl im Checkbox-Wizard.
     *
     * @param array $arrCategorieObjekteCalender
     * @param array $arrBelegungsplanCategory
     *
     * @return array
     */
    protected function sortNachWizard($arrCategorieObjekteCalender, $arrBelegungsplanCategory)
    {
        // Schluessel und Werte tauschen
        $arrHelper = array_flip($arrBelegungsplanCategory);

        foreach ($arrHelper as $key => $value) {
            if (\array_key_exists($key, $arrCategorieObjekteCalender)) {
                $arrHelper[$key] = $arrCategorieObjekteCalender[$key];
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
     * Fuegt den Monaten Daten hinzu.
     *
     * @param array $arrMonth
     * @param int   $intStartAuswahl
     * @param array $arrFeiertage
     *
     * @return array
     */
    protected function dataMonth($arrMonth, $intStartAuswahl, $arrFeiertage)
    {
        $arrHelper = [];
        $intJahr = date('Y', $intStartAuswahl);

        foreach ($arrMonth as $value) {
            $iDayMonths = (int) date('t', mktime(0, 0, 0, (int) $value, 1, (int) $intJahr));
            $arrHelper[$intJahr][$value]['Name'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['month'][$value];
            $arrHelper[$intJahr][$value]['TageMonat'] = $iDayMonths;
            $arrHelper[$intJahr][$value]['ColSpan'] = $iDayMonths + 1;
            $intFirstDayInMonth = (int) date('N', mktime(0, 0, 0, (int) $value, 1, (int) $intJahr));

            for ($f = 1, $i = $intFirstDayInMonth; $f <= $iDayMonths; ++$f) {
                $strClass = '';
                $arrHelper[$intJahr][$value]['Days'][$f]['Day'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['day'][$i];
                $arrHelper[$intJahr][$value]['Days'][$f]['DayCut'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['short_cut_day'][$i];
                $arrHelper[$intJahr][$value]['Days'][$f]['DayWeekNum'] = $i;
                if (isset($arrFeiertage[$intJahr][$value][$f])) {
                    $strClass .= 'holiday';
                    $arrHelper[$intJahr][$value]['Days'][$f]['Title'] = $arrFeiertage[$intJahr][$value][$f]['Title'];
                    $arrHelper[$intJahr][$value]['Days'][$f]['Style'] = $arrFeiertage[$intJahr][$value][$f]['Style'];
                    $arrHelper[$intJahr][$value]['Days'][$f]['ShowTitleText'] = $arrFeiertage[$intJahr][$value][$f]['ShowTitleText'];
                }
                if (empty($strClass)) {
                    $strClass .= 6 === $i ? 'saturday' : (7 === $i ? 'sunday' : '');
                }
                $arrHelper[$intJahr][$value]['Days'][$f]['Class'] = trim($strClass);
                7 === $i ? $i = 1 : $i++;
            }
        }
        unset($intJahr, $arrFeiertage);

        return $arrHelper;
    }

    /**
     * Fuegt den Monaten Daten hinzu.
     *
     * @param int   $intStartAuswahl
     * @param int   $intEndeAuswahl
     * @param array $arrFeiertage
     *
     * @return array
     */
    protected function dataMonthIndividuell($intStartAuswahl, $intEndeAuswahl, $arrFeiertage)
    {
        $arrHelper = [];
        $intStartMonat = (int) date('n', $intStartAuswahl);
        $intStartJahr = (int) date('Y', $intStartAuswahl);
        $intEndeMonat = (int) date('n', $intEndeAuswahl);
        $intEndeJahr = (int) date('Y', $intEndeAuswahl);

        for ($y = $intStartJahr; $y <= $intEndeJahr; ++$y) {
            $y === $intStartJahr ? $m = $intStartMonat : $m = 1;

            for ($m;; ++$m) {
                $iDayMonths = (int) date('t', mktime(0, 0, 0, (int) $m, 1, (int) $y));
                $arrHelper[$y][$m]['Name'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['month'][$m];
                $arrHelper[$y][$m]['TageMonat'] = $iDayMonths;
                $arrHelper[$y][$m]['ColSpan'] = $iDayMonths + 1;
                $intFirstDayInMonth = (int) date('N', mktime(0, 0, 0, (int) $m, 1, (int) $y));

                for ($f = 1, $i = $intFirstDayInMonth; $f <= $iDayMonths; ++$f) {
                    $strClass = '';
                    $arrHelper[$y][$m]['Days'][$f]['Day'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['day'][$i];
                    $arrHelper[$y][$m]['Days'][$f]['DayCut'] = $GLOBALS['TL_LANG']['mailwurm_belegung']['short_cut_day'][$i];
                    $arrHelper[$y][$m]['Days'][$f]['DayWeekNum'] = $i;
                    if (!empty($arrFeiertage[$y][$m][$f])) {
                        $strClass .= 'holiday';
                        $arrHelper[$y][$m]['Days'][$f]['Title'] = $arrFeiertage[$y][$m][$f]['Title'];
                        $arrHelper[$y][$m]['Days'][$f]['Style'] = $arrFeiertage[$y][$m][$f]['Style'];
                        $arrHelper[$y][$m]['Days'][$f]['ShowTitleText'] = $arrFeiertage[$y][$m][$f]['ShowTitleText'];
                    }
                    if (empty($strClass)) {
                        $strClass .= 6 === $i ? 'saturday' : (7 === $i ? 'sunday' : '');
                    }
                    $arrHelper[$y][$m]['Days'][$f]['Class'] = trim($strClass);
                    7 === $i ? $i = 1 : $i++;
                }
                // Letzter Monat im Jahr oder Ende des Anzeigezeitraums
                if (12 === $m || ($y === $intEndeJahr && $m === $intEndeMonat)) {
                    break;
                }
            }
            if ($y === $intEndeJahr) {
                break;
            }
        }
        unset($intJahr, $arrFeiertage);

        return $arrHelper;
    }

    /**
     * Ausgabe fuer Kalender.
     *
     * @param int $intBuchungsStartJahr
     * @param int $intBuchungsEndeJahr
     * @param int $intY
     * @param int $z
     *
     * @return string
     */
    protected function includeCalender($intBuchungsStartJahr, $intBuchungsEndeJahr, $intY, $arrCategoriesObjekte, $z): string
    {
        $intBuchungJahr = empty($z) ? (int) $intBuchungsStartJahr : (int) $intBuchungsEndeJahr;
        // bei Jahresuebergreifender Buchung
        if ((int) $intBuchungsStartJahr !== (int) $intBuchungsEndeJahr) {
            // bei Jahresuebergreifender Buchung
            if ($intY === $intBuchungJahr) {
                $strReturn = empty($z) ? '0#1' : '1#0';
            } else {
                $strReturn = '1#1';
            }
        } else {
            // wenn letzter Tag einer Buchung gleich dem ersten Tag einer neuer Buchung
            if (isset($arrCategoriesObjekte)) {
                $strReturn = '1#1';
            } else {
                $strReturn = empty($z) ? '0#1' : '1#0';
            }
        }

        return $strReturn;
    }

    /**
     * Holt alle Feiertage.
     *
     * @param int $intStartAuswahl
     * @param int $intEndeAuswahl
     *
     * @return array
     */
    protected function getFeiertage($intStartAuswahl, $intEndeAuswahl)
    {
        $arrFeiertage = [];
        $objFeiertage = $this->Database->prepare('SELECT DAY(FROM_UNIXTIME(startDate)) as Tag,
									MONTH(FROM_UNIXTIME(startDate)) as Monat,
									YEAR(FROM_UNIXTIME(startDate)) as Jahr,
									title, ausgabe, hintergrund, opacity, textcolor, textopacity, showTitleText
							FROM 	tl_belegungsplan_feiertage
							WHERE 	startDate >= '.$intStartAuswahl.'
							AND 	startDate <= '.$intEndeAuswahl)
            ->execute()
        ;
        if ($objFeiertage->numRows > 0) {
            while ($objFeiertage->next()) {
                $arrHelper = [];
                if ($objFeiertage->ausgabe) {
                    $arrHelper =
                    [
                        'Title' => $objFeiertage->title,
                        'Style' => " style='background-color:rgba(".$objFeiertage->hintergrund.','.$objFeiertage->opacity.');color:rgba('.$objFeiertage->textcolor.','.$objFeiertage->textopacity.");cursor:pointer;'",
                        'ShowTitleText' => $objFeiertage->showTitleText,
                    ];
                } else {
                    $arrHelper =
                    [
                        'Title' => $objFeiertage->title,
                        'ShowTitleText' => $objFeiertage->showTitleText,
                    ];
                }
                $arrFeiertage[$objFeiertage->Jahr][$objFeiertage->Monat][$objFeiertage->Tag] = $arrHelper;
            }
        }

        return $arrFeiertage;
    }

    /**
     * Hole alle aktiven Objekte inklusive dazugehoeriger aktiver Kategorien.
     *
     * @return array
     */
    protected function getCategorieObjekte()
    {
        $arrCategorieObjekteHelper = [];
        $objCategoryObjekte = $this->Database->prepare('SELECT 	tbc.id as CategoryID,
										tbc.title as CategoryTitle,
										tbc.titlelink as CategoryTitleLink,
										tbc.target as CategoryTarget,
										tbc.linkTitle as CategoryLinkTitle,
										tbc.cssID as CategoryLinkCSS,
										tbo.id as ObjektID,
										tbo.name as ObjektName,
										tbo.infotext as ObjektInfoText,
										tbo.titlelink as ObjektTitleLink,
										tbo.target as ObjektTarget,
										tbo.linkTitle as ObjektLinkTitle,
										tbo.cssID as ObjektLinkCSS,
										tbo.showInfotext as ObjektShowInfotext,
										tbo.sorting as ObjektSortierung
									FROM 	tl_belegungsplan_category tbc,
										tl_belegungsplan_objekte tbo
									WHERE	tbo.pid = tbc.id
									AND	tbo.published = 1')
            ->execute()
        ;
        if ($objCategoryObjekte->numRows > 0) {
            while ($objCategoryObjekte->next()) {
                // Nicht anzuzeigende Kategorien aussortieren
                if (\in_array($objCategoryObjekte->CategoryID, array_map('intval', $this->belegungsplan_category), false)) {
                    $arrHelper = [];
                    $arrHelper['ObjektID'] = (int) $objCategoryObjekte->ObjektID;
                    $arrHelper['ObjektName'] = StringUtil::specialchars($objCategoryObjekte->ObjektName);
                    $arrHelper['ObjektInfoText'] = StringUtil::specialchars($objCategoryObjekte->ObjektInfoText);
                    $arrHelper['ObjektTitleLink'] = StringUtil::specialchars($objCategoryObjekte->ObjektTitleLink);
                    $arrHelper['ObjektTarget'] = StringUtil::specialchars($objCategoryObjekte->ObjektTarget);
                    $arrHelper['ObjektLinkTitle'] = StringUtil::specialchars($objCategoryObjekte->ObjektLinkTitle);
                    $arrHelper['ObjektLinkCSS'] = StringUtil::deserialize($objCategoryObjekte->ObjektLinkCSS);
                    $arrHelper['ObjektShowInfotext'] = StringUtil::specialchars($objCategoryObjekte->ObjektShowInfotext);
                    if (\array_key_exists($objCategoryObjekte->CategoryID, $arrCategorieObjekteHelper)) {
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
                    } else {
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['CategoryTitle'] = StringUtil::specialchars($objCategoryObjekte->CategoryTitle);
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['CategoryTitleLink'] = StringUtil::specialchars($objCategoryObjekte->CategoryTitleLink);
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['CategoryTarget'] = StringUtil::specialchars($objCategoryObjekte->CategoryTarget);
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['CategoryLinkTitle'] = StringUtil::specialchars($objCategoryObjekte->CategoryLinkTitle);
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['CategoryLinkCSS'] = StringUtil::deserialize($objCategoryObjekte->CategoryLinkCSS);
                        $arrCategorieObjekteHelper[$objCategoryObjekte->CategoryID]['Objekte'][$objCategoryObjekte->ObjektSortierung] = $arrHelper;
                    }
                    unset($arrHelper);
                }
            }
        }

        return $arrCategorieObjekteHelper;
    }

    /**
     * Hole alle Kalenderdaten zur Auswahl.
     *
     * @param int    $intStartAuswahl
     * @param int    $intEndeAuswahl
     * @param array  $arrCategorieObjekte
     * @param string $belegungsplan_showAusgabe
     *
     * @return array
     */
    protected function getObjekteCalender($intStartAuswahl, $intEndeAuswahl, $arrCategorieObjekte, $belegungsplan_showAusgabe)
    {
        $objObjekteCalender = $this->Database->prepare('SELECT tbo.id as ObjektID,
							tbo.sorting as ObjektSortierung,
							tbcat.id as CategoryID,
							(CASE
								WHEN tbc.startDate < '.$intStartAuswahl.' THEN DAY(FROM_UNIXTIME('.$intStartAuswahl.'))
								ELSE DAY(FROM_UNIXTIME(tbc.startDate))
							 END) as StartTag,
							 (CASE
								WHEN tbc.startDate < '.$intStartAuswahl.' THEN MONTH(FROM_UNIXTIME('.$intStartAuswahl.'))
								ELSE MONTH(FROM_UNIXTIME(tbc.startDate))
							 END) as StartMonat,
							 (CASE
								WHEN tbc.startDate < '.$intStartAuswahl.' THEN YEAR(FROM_UNIXTIME('.$intStartAuswahl.'))
								ELSE YEAR(FROM_UNIXTIME(tbc.startDate))
							 END) as StartJahr,
							 YEAR(FROM_UNIXTIME(tbc.startDate)) as BuchungsStartJahr,
							 (CASE
								WHEN tbc.endDate > '.$intEndeAuswahl.' THEN DAY(FROM_UNIXTIME('.$intEndeAuswahl.'))
								ELSE DAY(FROM_UNIXTIME(tbc.endDate))
							 END) as EndeTag,
							 (CASE
								WHEN tbc.endDate > '.$intEndeAuswahl.' THEN MONTH(FROM_UNIXTIME('.$intEndeAuswahl.'))
								ELSE MONTH(FROM_UNIXTIME(tbc.endDate))
							 END) as EndeMonat,
							 (CASE
								WHEN tbc.endDate > '.$intEndeAuswahl.' THEN YEAR(FROM_UNIXTIME('.$intEndeAuswahl.'))
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
						AND 	((tbc.startDate < ? AND tbc.endDate >= ?) OR (tbc.startDate >= ? AND tbc.endDate <= ?) OR (tbc.startDate < ? AND tbc.endDate > ?))')
            ->execute($intStartAuswahl, $intStartAuswahl, $intStartAuswahl, $intEndeAuswahl, $intEndeAuswahl, $intEndeAuswahl)
        ;

        if ($objObjekteCalender->numRows > 0) {
            if ('standard' === $belegungsplan_showAusgabe) {
                while ($objObjekteCalender->next()) {
                    // Ermittlung Anzahl der Tage des angegebenen Monats (28 - 31)
                    $intEndeMonat = (int) date('t', mktime(0, 0, 0, (int) $objObjekteCalender->StartMonat, (int) $objObjekteCalender->StartTag, (int) $objObjekteCalender->StartJahr));

                    // d = 1, m = 1, e = 31, y = 2021, z = 0
                    for ($d = (int) $objObjekteCalender->StartTag, $m = (int) $objObjekteCalender->StartMonat, $e = $intEndeMonat, $y = (int) $objObjekteCalender->StartJahr, $z = 0;;) {
                        // erster Tag der Buchung und weitere
                        if (0 === $z) {
                            // nur anzuzeigende Monate auswaehlen
                            if (\in_array($m, $this->belegungsplan_month, false)) {
                                // Sonderfall letzter Buchungstag faellt auf Neujahr
                                if ((int) $objObjekteCalender->BuchungsStartJahr < (int) $objObjekteCalender->BuchungsEndeJahr && 1 === (int) $objObjekteCalender->EndeTag && 1 === (int) $objObjekteCalender->EndeMonat && 1 === (int) $objObjekteCalender->StartTag && 1 === (int) $objObjekteCalender->StartMonat) {
                                    if ($arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d]) {
                                        $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#1';
                                    } else {
                                        $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#0';
                                    }
                                    break;
                                }
                                $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] ?? null, 0);
                            }
                            // Sonderfall Sylvester
                            if (31 === $d && 12 === $m) {
                                break;
                            }
                        } elseif ($y === (int) $objObjekteCalender->EndeJahr && $m === (int) $objObjekteCalender->EndeMonat && $d === (int) $objObjekteCalender->EndeTag) {
                            // nur anzuzeigende Monate auswaehlen
                            if (\in_array($m, $this->belegungsplan_month, false)) {
                                $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] ?? null, 1);
                            }
                            break;
                        } else {
                            // nur anzuzeigende Monate auswaehlen
                            if (\in_array($m, $this->belegungsplan_month, false)) {
                                $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#1';
                            }
                        }
                        if ($d === $e) {
                            if ((int) $objObjekteCalender->StartMonat === (int) $objObjekteCalender->EndeMonat) {
                                // nur anzuzeigende Monate auswaehlen
                                if (\in_array($m, $this->belegungsplan_month, false)) {
                                    $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#0';
                                }
                                break;
                            }
                            ++$m;
                            $d = 0;
                            $e = (int) date('t', mktime(0, 0, 0, $m, $d + 1, $y));
                        }
                        ++$d;
                        ++$z;
                    }
                }
            }

            if ('automatic' === $belegungsplan_showAusgabe || 'individuell' === $belegungsplan_showAusgabe) {
                while ($objObjekteCalender->next()) {
                    // Ermittlung Anzahl der Tage des angegebenen Monats (28 - 31)
                    $intEndeMonat = (int) date('t', mktime(0, 0, 0, (int) $objObjekteCalender->StartMonat, (int) $objObjekteCalender->StartTag, (int) $objObjekteCalender->StartJahr));

                    for ($d = (int) $objObjekteCalender->StartTag, $m = (int) $objObjekteCalender->StartMonat, $e = $intEndeMonat, $y = (int) $objObjekteCalender->StartJahr, $z = 0;;) {
                        // erster Tag der Buchung und weitere
                        if (0 === $z) {
                            $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] ?? null, 0);
                        } elseif ($y === (int) $objObjekteCalender->EndeJahr && $m === (int) $objObjekteCalender->EndeMonat && $d === (int) $objObjekteCalender->EndeTag) {
                            $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = $this->includeCalender($objObjekteCalender->BuchungsStartJahr, $objObjekteCalender->BuchungsEndeJahr, $y, $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] ?? null, 1);
                            break;
                        } else {
                            $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#1';
                        }
                        if ($d === $e) {
                            if ($m === (int) $objObjekteCalender->EndeMonat && $y === (int) $objObjekteCalender->EndeJahr) {
                                $arrCategorieObjekte[$objObjekteCalender->CategoryID]['Objekte'][$objObjekteCalender->ObjektSortierung]['Calender'][$y][$m][$d] = '1#0';
                                break;
                            }
                            if (31 === $d && 12 === $m) {
                                $m = 1;
                                ++$y;
                            } else {
                                ++$m;
                            }
                            $d = 0;
                            $e = (int) date('t', mktime(0, 0, 0, $m, $d + 1, $y));
                        }
                        ++$d;
                        ++$z;
                    }
                }
            }
        }

        return $arrCategorieObjekte;
    }

    /**
     * Hole alle Jahre fuer die bereits Buchungen vorhanden sind ab dem aktuellen Jahr.
     *
     * @param int $intMinYear
     *
     * @return array
     */
    protected function getYears($intMinYear, $intYear)
    {
        $aYears = [];
        // Hole alle Jahre fuer die bereits Buchungen vorhanden sind ab dem aktuellen Jahr
        $objJahre = $this->Database->prepare('	SELECT YEAR(FROM_UNIXTIME(tbc.startDate)) as Start
							FROM tl_belegungsplan_calender tbc,
								tl_belegungsplan_objekte tbo
							WHERE YEAR(FROM_UNIXTIME(tbc.startDate)) >= ?
							AND tbc.pid = tbo.id
							AND tbo.published = 1
							GROUP BY YEAR(FROM_UNIXTIME(tbc.startDate))
							ORDER BY YEAR(FROM_UNIXTIME(tbc.startDate)) ASC')
            ->execute($intMinYear)
        ;
        if ($objJahre->numRows > 0) {
            while ($objJahre->next()) {
                $aYears[] = ['single_year' => $objJahre->Start, 'year_href' => $this->strUrl.'?belegyear='.$objJahre->Start, 'active' => $objJahre->Start === $intYear ? 1 : 0];
            }
        }

        return $aYears;
    }
}
