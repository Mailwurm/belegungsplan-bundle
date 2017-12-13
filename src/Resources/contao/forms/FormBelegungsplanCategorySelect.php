<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\Belegung;

/**
 * Class FormBelegungsplanCategorySelect
 *
 * @property integer $mSize
 * @property boolean $mandatory
 * @property boolean $multiple
 * @property array   $options
 * @property boolean $chosen
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
class FormBelegungsplanCategorySelect extends \Widget
{
	/**
	* Template
	*
	* @var string
	*/
	protected $strTemplate = 'form_belegungsplancategoryselect';
  
	/**
	* The CSS class prefix
	*
	* @var string
	*/
  	protected $strPrefix = 'widget widget-select';

	/**
	* Add specific attributes
	*
	* @param string $strKey   The attribute name
	* @param mixed  $varValue The attribute value
	*/
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'mandatory':
				if ($varValue)
				{
					$this->arrAttributes['required'] = 'required';
				}
				else
				{
					unset($this->arrAttributes['required']);
				}
				parent::__set($strKey, $varValue);
				break;
			case 'mSize':
				if ($this->multiple)
				{
					$this->arrAttributes['size'] = $varValue;
				}
				break;
			case 'multiple':
				if ($varValue != '')
				{
					$this->arrAttributes['multiple'] = 'multiple';
				}
				break;
			case 'options':
				$this->arrOptions = \StringUtil::deserialize($varValue);
				break;
			case 'rgxp':
			case 'minlength':
			case 'maxlength':
				// Ignore
				break;
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}
  
	/**
	* Check options if the field is mandatory
	*/
	public function validate()
	{
		$mandatory = $this->mandatory;
		$options = $this->getPost($this->strName);
		// Check if there is at least one value
		if ($mandatory && is_array($options))
		{
			foreach ($options as $option)
			{
				if (strlen($option))
				{
					$this->mandatory = false;
					break;
				}
			}
		}
		$varInput = $this->validator($options);
		// Check for a valid option (see #4383)
		if (!empty($varInput) && !$this->isValidOption($varInput))
		{
			$this->addError($GLOBALS['TL_LANG']['ERR']['invalid']);
		}
		// Add class "error"
		if ($this->hasErrors())
		{
			$this->class = 'error';
		}
		else
		{
			$this->varValue = $varInput;
		}
		// Reset the property
		if ($mandatory)
		{
			$this->mandatory = true;
		}
	}
  
	/**
	* Return a parameter
	*
	* @param string $strKey The parameter name
	*
	* @return mixed The parameter value
	*/
	public function __get($strKey)
	{
		if ($strKey == 'options')
		{
			return $this->arrOptions;
		}
		return parent::__get($strKey);
	}
  
	/**
	* Parse the template file and return it as string
	*
	* @param array $arrAttributes An optional attributes array
	*
	* @return string The template markup
	*/
	public function parse($arrAttributes=null)
	{
		$strClass = 'select';
		if ($this->multiple)
		{
			$this->strName .= '[]';
			$strClass = 'multiselect';
		}
		// Make sure there are no multiple options in single mode
		elseif (is_array($this->varValue))
		{
			$this->varValue = $this->varValue[0];
		}
		// Chosen
		if ($this->chosen)
		{
			$strClass .= ' tl_chosen';
		}
		// Custom class
		if ($this->strClass != '')
		{
			$strClass .= ' ' . $this->strClass;
		}
		$this->strClass = $strClass;
		return parent::parse($arrAttributes);
	}
  
	/**
	* Generate the options
	*
	* @return array The options array
	*/
	protected function getOptions()
	{
		$arrOptions = array();
		// Add empty option if there are none
		if (empty($this->arrOptions) || !is_array($this->arrOptions))
		{
			$this->arrOptions = array(array('value' => '', 'label' => '-'));
		}
		// Generate options
		foreach ($this->arrOptions as $arrOption)
		{
			  $arrOptions[] = array_replace
				(
					$arrOption,
					array
					(
						'type'     => 'option',
						'value'    => $arrOption['value'],
						'selected' => $this->isSelected($arrOption),
						'label'    => $arrOption['label'],
					)
				);
		}
		return $arrOptions;
	}
  
	/**
	* Generate the widget and return it as string
	*
	* @return string The widget markup
	*/
	public function generate()
	{
		$strOptions = '';
		
		if ($this->multiple)
		{
			$this->strName .= '[]';
		}
		// Make sure there are no multiple options in single mode
		elseif (is_array($this->varValue))
		{
			$this->varValue = $this->varValue[0];
		}
		// Add empty option if there are none
		if (empty($this->arrOptions) || !is_array($this->arrOptions))
		{
			$this->arrOptions = array(array('value'=>'', 'label'=>'-'));
		}
		foreach ($this->arrOptions as $arrOption)
		{
			$strOptions .= sprintf('<option value="%s"%s>%s</option>',
									$arrOption['value'],
									$this->isSelected($arrOption),
									$arrOption['label']);
		}
		
		return sprintf('<select name="%s" id="ctrl_%s" class="%s"%s>%s</select>',
						$this->strName,
						$this->strId,
						$this->class,
						$this->getAttributes(),
						$strOptions);
	}
}
