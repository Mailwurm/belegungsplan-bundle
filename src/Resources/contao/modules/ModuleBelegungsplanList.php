<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Patchwork\Utf8;
use Contao\CoreBundle\Exception\PageNotFoundException;

/**
* Class ModuleBelegungsplan
*
* @property array $belegungsplan_categories
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
class ModuleBelegungsplanList extends \Belegungsplan
{
	/**
	* Template
	* @var string
	*/
	protected $strTemplate = 'mod_belegungsplanlist';
	/**
	* Target pages
	* @var array
	*/
	protected $arrTargets = array();
	
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
		/** @var PageModel $objPage */
		global $objPage;
		
		$blnClearInput = false;
		
		$intYear = \Input::get('year');
		$intMonth = \Input::get('month');
		
		//Springe zur aktuellen Periode
		if (!isset($_GET['year']) && !isset($_GET['month']))
		{
			switch ($this->cal_format)
			{
				case 'cal_year':
					$intYear = date('Y');
					break;
				case 'cal_month':
					$intMonth = date('Ym');
					break;
			}
			$blnClearInput = true;
		}
		
		$strEvents = '';
		
		/** @var FrontendTemplate|object $objTemplate */
		$objTemplate = new \FrontendTemplate($this->belegungsplan_ctemplate);
		$objTemplate->year = $intYear;
		$objTemplate->month = $intMonth;
		
		$strEvents .= $objTemplate->parse();
		
		// Keine Reservierungen gefunden
		if ($strEvents == '')
		{
			$strEvents = "\n" . '<div class="empty">Keine Reservierungen</div>' . "\n";
		}
		
		$this->Template->content = $strEvents;
		
	}
}
