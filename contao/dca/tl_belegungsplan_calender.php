<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

use Contao\Backend;
use Contao\BackendUser;
use Contao\Config;
use Contao\DataContainer;
use Contao\Date;
use Contao\DC_Table;
use Contao\Image;
use Contao\Input;
use Contao\System;
use Contao\User;

/*
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');

/*
 * Table tl_belegungsplan_calender
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_calender'] =
[
    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_belegungsplan_objekte',
        'ctable' => ['tl_content'],
        'switchToEdit' => true,
        'enableVersioning' => true,
        'onsubmit_callback' => [['tl_belegungsplan_calender', 'loadUeberschneidung']],
        'ondelete_callback' => [['tl_belegungsplan_calender', 'calenderOndeleteCallback']],
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
            ],
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 4,
            'fields' => ['startDate DESC'],
            'headerFields' => ['name'],
            'panelLayout' => 'filter;sort,search,limit',
            'child_record_callback' => ['tl_belegungsplan_calender', 'listCalender'],
        ],
        'label' => [
            'fields' => ['gast', 'startDate', 'endDate'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null).'\'))return false;Backend.getScrollOffset()"',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['dauer'],
        'default' => '{title_legend},gast,author;{day_legend},dauer',
        'oneday' => '{title_legend},gast,author;{day_legend},dauer;{date_legend},startDate',
        'moreday' => '{title_legend},gast,author;{day_legend},dauer;{date_legend},startDate,endDate',
    ],
    // Subpalettes
    'subpalettes' => [
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid' => [
            'foreignKey' => 'tl_belegungsplan_objekte.name',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'gast' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['gast'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'author' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['author'],
            'default' => BackendUser::getInstance()->id,
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 11,
            'inputType' => 'select',
            'foreignKey' => 'tl_user.name',
            'eval' => ['doNotCopy' => true, 'chosen' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'startDate' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['startDate'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 8,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'date', 'mandatory' => true, 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'save_callback' => [
                ['tl_belegungsplan_calender', 'setEndDate'],
            ],
            'sql' => 'int(10) unsigned NULL',
        ],
        'endDate' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDate'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 8,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'date', 'mandatory' => true, 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'save_callback' => [
                ['tl_belegungsplan_calender', 'loadEndDate'],
            ],
            'sql' => 'int(10) unsigned NULL',
        ],
        'ueberschneidung' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'],
            'exclude' => true,
            'inputType' => 'text',
            'sql' => 'text NULL',
        ],
        'dauer' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['dauer'],
            'inputType' => 'radio',
            'options' => ['oneday', 'moreday'],
            'default' => 'moreday',
            'reference' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender'],
            'explanation' => &$GLOBALS['TL_LANG']['tl_belegungsplan_calender'],
            'eval' => ['mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'w50', 'style' => 'margin:10px'],
            'sql' => "varchar(8) NOT NULL default ''",
        ],
    ],
];

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_belegungsplan_calender extends Backend
{
    /**
     * Import the back end user object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import(BackendUser::class, User::class);
    }

    /**
     * Add the type of input field.
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listCalender($arrRow)
    {
        return '<div class="tl_content_left">'.$arrRow['gast'].
        ' <span style="color:#999;padding-left:3px">['.Date::parse(Config::get('dateFormat'), $arrRow['startDate']).('moreday' === $arrRow['dauer'] ? $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'].Date::parse(Config::get('dateFormat'), $arrRow['endDate']) : '').']</span>'.
        ($arrRow['endDate'] < $arrRow['startDate'] ? ' '.Image::getHtml('error.svg', $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateListError'], 'title="'.$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateListError'].'"') : '').
        ($arrRow['ueberschneidung'] ? ' '.Image::getHtml('error_404.svg', $GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'][0], 'title="'.$GLOBALS['TL_LANG']['tl_belegungsplan_calender']['ueberschneidung'][0].'"') : '').
        '</div>';
    }

    /**
     * Prueft ob Enddatum kleiner Startdatum.
     */
    public function loadEndDate($varValue, DataContainer $dc)
    {
        $dateOne = new DateTime(Input::post('startDate'));
        $dateTwo = new DateTime(Input::post('endDate'));

        try {
            if ($dateTwo->getTimestamp() <= $dateOne->getTimestamp()) {
                if ($dateTwo->getTimestamp() < $dateOne->getTimestamp()) {
                    throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_calender']['endDateError']);
                }

                throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_calender']['sameDateError']);
            } else {
                return $varValue;
            }
        } catch (OutOfBoundsException $e) {
        }
    }

    /**
     * Setzt das Enddatum bei eintaegigem Besuch.
     */
    public function setEndDate($varValue, DataContainer $dc)
    {
        // Return if there is no active record (override all)
        if (!$dc->activeRecord) {
            return;
        }
        if ('oneday' === Input::post('dauer')) {
            $arrSet = [];
            $getStartDatum = new DateTime(Input::post('startDate'));
            $sNextDay = $getStartDatum->add(new DateInterval('P1D'));
            $arrSet['startDate'] = (int) $getStartDatum->getTimestamp();
            $arrSet['endDate'] = (int) $sNextDay->getTimestamp();

            $this->Database->prepare('UPDATE tl_belegungsplan_calender %s WHERE id=?')->set($arrSet)->execute($dc->id);
        }

        return $varValue;
    }

    /**
     * Prueft auf Terminueberschneidungen.
     */
    public function loadUeberschneidung(DataContainer $dc): void
    {
        $intId = (int) $dc->activeRecord->id;
        $intPid = (int) $dc->activeRecord->pid;
        $intStart = (int) $dc->activeRecord->startDate;
        $intEnde = (int) $dc->activeRecord->endDate;
        // Hole alle Calenderdaten zur Auswahl
        $objCal = $this->Database->prepare('SELECT id, ueberschneidung
											FROM tl_belegungsplan_calender
											WHERE id <> ?
											AND pid = ?
											AND ((startDate < ? AND endDate > ?) OR (startDate >= ? AND endDate <= ?) OR (startDate < ? AND endDate > ?))')
            ->execute($intId, $intPid, $intStart, $intStart, $intStart, $intEnde, $intEnde, $intEnde)
        ;
        if ($objCal->numRows > 0) {
            $strHelper = '';

            while ($objCal->next()) {
                $strHelper .= ','.$objCal->id;
                if (empty($objCal->ueberschneidung)) {
                    $this->updateDatabase($intId, $objCal->id);
                } else {
                    $arrHelper = explode(',', $objCal->ueberschneidung);
                    if (!in_array($intId, $arrHelper, false)) {
                        $this->updateDatabase($objCal->ueberschneidung.','.$intId, $objCal->id);
                    }
                    unset($arrHelper);
                }
            }
            // Update am aktuellen Termin
            $this->updateDatabase(substr($strHelper, 1), $intId);
            unset($strHelper);
        } else {
            $this->updateCalenders($intId, $intPid);
        }
    }

    /**
     * ondelete_callback: Wird ausgefuehrt bevor ein Datensatz aus der Datenbank
     * entfernt wird.
     */
    public function calenderOndeleteCallback(DataContainer $dc): void
    {
        $intId = (int) $dc->activeRecord->id;
        $intPid = (int) $dc->activeRecord->pid;
        $this->updateCalenders($intId, $intPid);
    }

    /**
     * Update Datenbank.
     *
     * @param int $intId
     * @param int $intPid
     */
    public function updateCalenders($intId, $intPid): void
    {
        $objCalDelete = $this->Database->prepare("SELECT id, ueberschneidung
											FROM tl_belegungsplan_calender
											WHERE id <> ?
											AND pid = ?
											AND ueberschneidung <> ''")
            ->execute($intId, $intPid)
        ;
        if ($objCalDelete->numRows > 0) {
            $arrDelete = [$intId];

            while ($objCalDelete->next()) {
                $arrHelper = explode(',', $objCalDelete->ueberschneidung);
                $arrReturn = array_diff($arrHelper, $arrDelete);
                $strInsert = '';
                if (!empty($arrReturn)) {
                    $strInsert = implode(',', $arrReturn);
                }
                $this->updateDatabase($strInsert, $objCalDelete->id);
                unset($arrHelper, $arrReturn);
            }
            // Update am aktuellen Termin
            $this->updateDatabase('', $intId);
            unset($arrHelper, $arrReturn);
        }
    }

    /**
     * Update Datenbank.
     *
     * @param string $strInput
     * @param int    $intInput
     */
    public function updateDatabase($strInput, $intInput): void
    {
        $this->Database->prepare('UPDATE tl_belegungsplan_calender SET ueberschneidung = ? WHERE id = ?')
            ->execute($strInput, $intInput)
        ;
    }
}
