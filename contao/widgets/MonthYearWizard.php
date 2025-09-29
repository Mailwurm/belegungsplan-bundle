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

use Contao\StringUtil;
use Contao\Widget;

/**
 * Provide methods to handle text fields with unit drop down menu.
 *
 * @property int    $maxlength
 * @property bool   $mandatory
 * @property string $placeholder
 * @property array  $options
 */
class MonthYearWizard extends Widget
{
    /**
     * Submit user input.
     *
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Units.
     *
     * @var array
     */
    protected $arrUnits = [];

    /**
     * Add specific attributes.
     *
     * @param string $strKey
     */
    public function __set($strKey, $varValue): void
    {
        switch ($strKey) {
            case 'maxlength':
                if ($varValue > 0) {
                    $this->arrAttributes['maxlength'] = $varValue;
                }
                break;

            case 'mandatory':
                if ($varValue) {
                    $this->arrAttributes['required'] = 'required';
                } else {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            case 'placeholder':
                $this->arrAttributes['placeholder'] = $varValue;
                break;

            case 'options':
                $this->arrUnits = StringUtil::deserialize($varValue);
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        $arrUnits = [];

        foreach ($this->arrUnits as $arrUnit) {
            $arrUnits[] = \sprintf(
                '<option value="%s"%s>%s</option>',
                StringUtil::specialchars($arrUnit['value']),
                $this->isSelected($arrUnit),
                $arrUnit['label'],
            );
        }

        if (!\is_array($this->varValue)) {
            $this->varValue = ['value' => $this->varValue];
        }

        return \sprintf(
            '<select style="width:120px;" name="%s[unit]" class="tl_select_unit" onfocus="Backend.getScrollOffset()"%s>%s</select>%s <input type="text" name="%s[value]" id="ctrl_%s" class="tl_text_unit%s" value="%s"%s onfocus="Backend.getScrollOffset()">',
            $this->strName,
            $this->getAttribute('disabled'),
            implode('', $arrUnits),
            $this->wizard,
            $this->strName,
            $this->strId,
            $this->strClass ? ' '.$this->strClass : '',
            StringUtil::specialchars($this->varValue['value']),
            $this->getAttributes(),
        );
    }

    /**
     * Do not validate unit fields.
     */
    protected function validator($varInput)
    {
        foreach ($varInput as $k => $v) {
            if ('unit' !== $k) {
                $varInput[$k] = parent::validator($v);
            }
        }

        return $varInput;
    }

    /**
     * Only check against the unit values (see #7246).
     *
     * @param array $arrOption The options array
     *
     * @return string The "selected" attribute or an empty string
     */
    protected function isSelected($arrOption)
    {
        if (empty($this->varValue) && empty($_POST) && (!empty($arrOption['default']))) {
            return $this->optionSelected(1, 1);
        }

        if (empty($this->varValue) || !\is_array($this->varValue)) {
            return '';
        }

        return $this->optionSelected($arrOption['value'], $this->varValue['unit']);
    }
}
