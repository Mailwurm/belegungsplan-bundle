<?php

declare(strict_types=1);

/**
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

use Contao\Backend;
use Contao\BackendUser;
use Contao\Config;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\DataContainer;
use Contao\Date;
use Contao\DC_Table;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\User;
use Contao\Versions;

/*
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');

/*
 * Table tl_belegungsplan_objekte
 */
$GLOBALS['TL_DCA']['tl_belegungsplan_objekte'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_belegungsplan_category',
        'ctable' => ['tl_belegungsplan_calender'],
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid,published,sorting' => 'index',
            ],
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 4,
            'fields' => ['sorting'],
            'panelLayout' => 'filter;sort,search,limit',
            'headerFields' => ['title'],
            'child_record_callback' => ['tl_belegungsplan_objekte', 'listQuestions'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['edit'],
                'href' => 'table=tl_belegungsplan_calender',
                'icon' => 'cssimport.svg',
            ],
            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['editheader'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
                'button_callback' => ['tl_belegungsplan_objekte', 'editHeader'],
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null).'\'))return false;Backend.getScrollOffset()"',
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['toggle'],
                'icon' => 'visible.svg',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['tl_belegungsplan_objekte', 'toggleIcon'],
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => [],
        'default' => '{title_legend},name,author,infotext,showInfotext;{hyperlink_legend:hide},titlelink,target,linkTitle,cssID;{publish_legend},published',
    ],
    // Subpalettes
    'subpalettes' => [],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid' => [
            'foreignKey' => 'tl_belegungsplan_category.title',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'sorting' => [
            'label' => &$GLOBALS['TL_LANG']['MSC']['sorting'],
            'sorting' => true,
            'flag' => 11,
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'name' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['name'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
            'sql' => "varchar(128) NOT NULL default ''",
        ],
        'author' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['author'],
            'default' => BackendUser::getInstance()->id,
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 11,
            'inputType' => 'select',
            'foreignKey' => 'tl_user.name',
            'eval' => ['doNotCopy' => true, 'chosen' => true, 'mandatory' => false, 'includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'infotext' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['infotext'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'showInfotext' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['showInfotext'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) COLLATE ascii_bin NOT NULL default '1'",
        ],
        'titlelink' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['titlelink'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'rgxp' => 'url', 'maxlength' => 255, 'decodeEntities' => true, 'dcaPicker' => true, 'addWizardClass' => false, 'tl_class' => 'w50'],
            'sql' => 'text NULL',
        ],
        'target' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['target'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) COLLATE ascii_bin NOT NULL default ''",
        ],
        'linkTitle' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['linkTitle'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'cssID' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['cssID'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['multiple' => true, 'size' => 2, 'tl_class' => 'w50 clr'],
            'save_callback' => [
                ['tl_belegungsplan_objekte', 'setEmptyCssID'],
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'published' => [
            'label' => &$GLOBALS['TL_LANG']['tl_belegungsplan_objekte']['published'],
            'exclude' => true,
            'filter' => true,
            'flag' => 2,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy' => true],
            'sql' => "char(1) COLLATE ascii_bin NOT NULL default ''",
        ],
    ],
];
/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_belegungsplan_objekte extends Backend
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
     * Return the edit header button.
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
        return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }

    /**
     * Add the type of input field.
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
<div class="cte_type '.$key.'">'.$date.'</div>
<div class="limit_height'.(!Config::get('doNotCollapse') ? ' h40' : '').'">
'.StringUtil::insertTagToSrc($arrRow['name']).
(!empty($arrRow['infotext']) ? '<span style="color:#b3b3b3;padding-left:3px">['.StringUtil::insertTagToSrc($arrRow['infotext']).']</span>' : '').'
</div>'."\n";
    }

    /**
     * Return the "toggle visibility" button.
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
        if (strlen((string) Input::get('tid'))) {
            $this->toggleVisibility(Input::get('tid'), 1 === Input::get('state'), @func_get_arg(12) ?: null);
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);
        if (!$row['published']) {
            $icon = 'invisible.svg';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="'.($row['published'] ? 1 : 0).'"').'</a> ';
    }

    /**
     * Disable/enable a user group.
     *
     * @param int  $intId
     * @param bool $blnVisible
     *
     * @throws AccessDeniedException
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer|null $dc = null): void
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');
        if ($dc) {
            $dc->id = $intId; // see #8043
        }

        // Set the current record
        if ($dc) {
            $objRow = $this->Database->prepare('SELECT * FROM tl_belegungsplan_objekte WHERE id=?')
                ->limit(1)
                ->execute($intId)
            ;
            if ($objRow->numRows) {
                $dc->activeRecord = $objRow;
            }
        }
        $objVersions = new Versions('tl_belegungsplan_objekte', $intId);
        $objVersions->initialize();
        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['fields']['published']['save_callback'] as $callback) {
                if (is_array($callback)) {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                } elseif (is_callable($callback)) {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }
        $time = time();
        // Update the database
        $this->Database->prepare("UPDATE tl_belegungsplan_objekte SET tstamp=$time, published='".($blnVisible ? '1' : '')."' WHERE id=?")
            ->execute($intId)
        ;
        if ($dc) {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }
        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onsubmit_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_belegungsplan_objekte']['config']['onsubmit_callback'] as $callback) {
                if (is_array($callback)) {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                } elseif (is_callable($callback)) {
                    $callback($dc);
                }
            }
        }
        $objVersions->create();
    }

    /**
     * Leert das Feld cssID in der Datenbank, wenn keine Angaben enthalten sind.
     */
    public function setEmptyCssID($varValue, DataContainer $dc)
    {
        // Return if there is no active record (override all)
        if (!$dc->activeRecord) {
            return;
        }

        $arrSet = StringUtil::deserialize((string) $varValue, true);

        if (empty($arrSet[0]) && empty($arrSet[1])) {
            $varValue = '';
        }

        return $varValue;
    }
}
