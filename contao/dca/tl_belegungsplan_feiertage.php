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
use Contao\Environment;
use Contao\Input;
use Contao\System;
use Contao\User;

/*
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');

/*
  * Table tl_belegungsplan_feiertage
  */
$GLOBALS['TL_DCA']['tl_belegungsplan_feiertage'] =
[
    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['startDate DESC'],
            'flag' => 9,
            'panelLayout' => 'search,limit',
        ],
        'label' => [
            'fields' => ['title'],
            'format' => '%s',
            'label_callback' => ['tl_belegungsplan_feiertage', 'listCalender'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null).'\'))return false"',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['ausgabe'],
        'default' => '{title_legend},title,showTitleText,author;{date_legend},startDate;{color_legend},ausgabe',
    ],
    // Subpalettes
    'subpalettes' => [
        'ausgabe' => 'hintergrund,opacity,reset,textcolor,textopacity,textreset',
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['title'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'showTitleText' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['showTitleText'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) COLLATE ascii_bin NOT NULL default '1'",
        ],
        'author' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['author'],
            'default' => BackendUser::getInstance()->id,
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 11,
            'inputType' => 'select',
            'foreignKey' => 'tl_user.name',
            'eval' => ['doNotCopy' => true, 'chosen' => true, 'includeBlankOption' => true, 'tl_class' => 'w50 clr'],
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'startDate' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['startDate'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 8,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'date', 'mandatory' => true, 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'save_callback' => [
                ['tl_belegungsplan_feiertage', 'getVorhanden'],
            ],
            'sql' => 'int(10) unsigned NULL',
        ],
        'ausgabe' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['ausgabe'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'default' => '1',
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 m12 wizard', 'helpwizard' => true],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'hintergrund' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['hintergrund'],
            'exclude' => true,
            'inputType' => 'text',
            'default' => '91,192,222',
            'explanation' => 'feiertage_hintergrund',
            'load_callback' => [
                ['tl_belegungsplan_feiertage', 'setRgbToHex'],
            ],
            'eval' => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
            'save_callback' => [
                ['tl_belegungsplan_feiertage', 'setHexToRgb'],
            ],
            'sql' => "varchar(20) NOT NULL default ''",
        ],
        'opacity' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['opacity'],
            'exclude' => true,
            'inputType' => 'select',
            'default' => '1.0',
            'options' => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(3) NOT NULL default ''",
        ],
        'reset' => [
            'eval' => ['submitOnChange' => true],
            'input_field_callback' => ['tl_belegungsplan_feiertage', 'setResetButton'],
        ],
        'textcolor' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['textcolor'],
            'exclude' => true,
            'inputType' => 'text',
            'default' => '51,51,51',
            'explanation' => 'feiertage_textcolor',
            'load_callback' => [
                ['tl_belegungsplan_feiertage', 'setRgbToHex'],
            ],
            'eval' => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
            'save_callback' => [
                ['tl_belegungsplan_feiertage', 'setHexToRgb'],
            ],
            'sql' => "varchar(20) NOT NULL default ''",
        ],
        'textopacity' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['opacity'],
            'exclude' => true,
            'inputType' => 'select',
            'default' => '1.0',
            'options' => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(3) NOT NULL default ''",
        ],
        'textreset' => [
            'eval' => ['submitOnChange' => true],
            'input_field_callback' => ['tl_belegungsplan_feiertage', 'setResetButton'],
        ],
    ],
];

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_belegungsplan_feiertage extends Backend
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
     * Auflistung anpassen.
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listCalender($arrRow)
    {
        return '<div class="tl_content_left">'.$arrRow['title'].' <span style="color:#999;padding-left:3px">['.Date::parse(Config::get('dateFormat'), $arrRow['startDate']).']</span></div>';
    }

    /**
     * Wandelt Farbcode Hexadezimal nach RGB.
     */
    public function setHexToRgb($varValue, DataContainer $dc)
    {
        // Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
        if (!$dc->activeRecord) {
            return;
        }
        $hex = str_replace(' ', '', $varValue);

        try {
            if (strlen($hex) < 6) {
                throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['setHexToRgb']);
            }

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            return implode(',', [$r, $g, $b]);
        } catch (OutOfBoundsException $e) {
        }
    }

    /**
     * Wandelt Farbcode RGB nach Hexadezimal.
     */
    public function setRgbToHex($varValue, DataContainer $dc)
    {
        // Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
        if (!$dc->activeRecord) {
            return;
        }
        $hex = '';
        // Bei neuanlegen eines Modul abfragen
        if (!str_contains($varValue, ',')) {
            $hex .= $varValue;
        } else {
            $varValue = explode(',', $varValue);
            $hex .= str_pad(dechex((int) $varValue[0]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex((int) $varValue[1]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex((int) $varValue[2]), 2, '0', STR_PAD_LEFT);
        }

        return strtoupper($hex);
    }

    /**
     * input_field_callback: Ermoeglicht das Erstellen individueller Formularfelder.
     */
    public function setResetButton(DataContainer $dc, $varValue)
    {
        if (!empty(Input::get('bpb')) && Input::get('bpb') === $dc->inputName) {
            $boolHelper = true;
            $arrSet = [];
            $arrSet = $this->getReturnInfo($dc->inputName);

            if (!empty($arrSet)) {
                $arrHelp = [];

                for ($i = 0, $a = count($arrSet); $i < $a; $i += 2) {
                    if ($dc->activeRecord->{$arrSet[$i]} !== $arrSet[$i + 1]) {
                        $arrHelp[$arrSet[$i]] = 6 === strlen($arrSet[$i + 1]) ? $this->setHexToRgb($arrSet[$i + 1], $dc) : $arrSet[$i + 1];
                        $boolHelper = false;
                    }
                }
            }
            if (!$boolHelper) {
                $this->Database->prepare('UPDATE tl_belegungsplan_feiertage %s WHERE id=?')->set($arrHelp)->execute($dc->id);
            }
            // GET-Parameter wieder aus Url entfernen
            $this->redirect(str_replace('&bpb='.$dc->inputName, '', Environment::get('request')));
        }

        return '<div class="w50 widget">
					<h3>&nbsp;</h3>
					<a href="'.Backend::addToUrl('bpb='.$dc->inputName).'" class="tl_submit m-3-0">'.$GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['reset'].'</a>
				</div>';
    }

    /**
     * @param string $strInputName
     *
     * @return array
     */
    public function getReturnInfo($strInputName)
    {
        $arrSet =
        [
            'reset' => ['hintergrund', '5BC0DE', 'opacity', '1.0'],
            'textreset' => ['textcolor', '333333', 'textopacity', '1.0'],
        ];

        return $arrSet[$strInputName];
    }

    /**
     * Prueft ob fuer einen Tag bereits ein Feiertag eingetragen wurde.
     */
    public function getVorhanden($varValue, DataContainer $dc)
    {
        if (!$dc->activeRecord) {
            return;
        }

        $objTag = $this->Database->prepare('SELECT id FROM tl_belegungsplan_feiertage WHERE startDate = ? AND id <> ?')
            ->execute($varValue, $dc->activeRecord->id)
        ;

        try {
            if ($objTag->numRows > 0) {
                throw new Exception($GLOBALS['TL_LANG']['tl_belegungsplan_feiertage']['bereitsVorhanden']);
            }

            return $varValue;
        } catch (OutOfBoundsException $e) {
        }
    }
}
