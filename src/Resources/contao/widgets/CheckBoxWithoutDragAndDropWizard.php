<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0-or-later
*/
namespace Mailwurm\Belegung;

/**
 * Provide methods to handle sortable checkboxes without drag and drop.
 *
 * @property array   $options
 * @property boolean $multiple
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class CheckBoxWithoutDragAndDropWizard extends \Widget
{
	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget_chk';

	/**
	 * Add specific attributes
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'options':
				$this->arrOptions = \StringUtil::deserialize($varValue);
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	/**
	 * Check for a valid option (see #4383)
	 */
	public function validate()
	{
		$varValue = $this->getPost($this->strName);

		if (!empty($varValue) && !$this->isValidOption($varValue))
		{
			$this->addError($GLOBALS['TL_LANG']['ERR']['invalid']);
		}

		parent::validate();
	}

	/**
	 * Generate the widget and return it as string
	 *
	 * @return string
	 */
	public function generate()
	{
		if (!\is_array($this->varValue))
		{
			$this->varValue = array($this->varValue);
		}

		// Sort options
		if ($this->varValue)
		{
			$arrOptions = array();
			$arrTemp = $this->arrOptions;

			// Move selected and sorted options to the top
			foreach ($this->arrOptions as $i=>$arrOption)
			{
				if (($intPos = array_search($arrOption['value'], $this->varValue)) !== false)
				{
					$arrOptions[$intPos] = $arrOption;
					unset($arrTemp[$i]);
				}
			}

			ksort($arrOptions);
			$this->arrOptions = array_merge($arrOptions, $arrTemp);
		}

		$blnCheckAll = true;
		$arrOptions = array();

		// Generate options
		foreach ($this->arrOptions as $i=>$arrOption)
		{
			$arrOptions[(int) $arrOption['value']] = $this->generateCheckbox($arrOption, (int) $arrOption['value']);
		}

		// Add a "no entries found" message if there are no options
		if (empty($arrOptions))
		{
			$arrOptions[] = '<p class="tl_noopt">'.$GLOBALS['TL_LANG']['MSC']['noResult'].'</p>';
			$blnCheckAll = false;
		} else {
			ksort($arrOptions);
		}

		return sprintf('<fieldset id="ctrl_%s" class="tl_checkbox_container tl_checkbox_wizard%s"><legend>%s%s%s%s</legend><input type="hidden" name="%s" value="">%s<div class="sortable">%s</div></fieldset>%s<script>Backend.checkboxWizard("ctrl_%s")</script>',
						$this->strId,
						(($this->strClass != '') ? ' ' . $this->strClass : ''),
						($this->mandatory ? '<span class="invisible">'.$GLOBALS['TL_LANG']['MSC']['mandatory'].' </span>' : ''),
						$this->strLabel,
						($this->mandatory ? '<span class="mandatory">*</span>' : ''),
						$this->xlabel,
						$this->strName,
						($blnCheckAll ? '<span class="fixed"><input type="checkbox" id="check_all_' . $this->strId . '" class="tl_checkbox" onclick="Backend.toggleCheckboxGroup(this,\'ctrl_' . $this->strId . '\')"> <label for="check_all_' . $this->strId . '" style="color:#a6a6a6"><em>' . $GLOBALS['TL_LANG']['MSC']['selectAll'] . '</em></label></span>' : ''),
						implode('', $arrOptions),
						$this->wizard,
						$this->strId);
	}

	/**
	 * Generate a checkbox and return it as string
	 *
	 * @param array   $arrOption
	 * @param integer $i
	 *
	 * @return string
	 */
	protected function generateCheckbox($arrOption, $i)
	{
		return sprintf('<span style="padding:5px 0 2px 0;"><input type="checkbox" name="%s" id="opt_%s" class="tl_checkbox" value="%s"%s%s onfocus="Backend.getScrollOffset()" style="margin:0 10px 3px 0;"><label for="opt_%s">%s</label></span>',
						$this->strName . ($this->multiple ? '[]' : ''),
						$this->strId.'_'.$i,
						($this->multiple ? \StringUtil::specialchars($arrOption['value']) : 1),
						(((\is_array($this->varValue) && \in_array($arrOption['value'], $this->varValue)) || $this->varValue == $arrOption['value']) ? ' checked="checked"' : ''),
						$this->getAttributes(),
						$this->strId.'_'.$i,
						$arrOption['label']);
	}
}

class_alias(CheckBoxWithoutDragAndDropWizard::class, 'CheckBoxWithoutDragAndDropWizard');