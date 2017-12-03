<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm;

/**
* Stellt Methoden bereit, um alle Reservierungsergebnisse eines bestimmten Zeitraums aus der Datenbank abzurufen.
*
* @author Jan Karai <https://www.sachsen-it.de>
*/
abstract class Belegungsplaene extends \Module
{
	/**
	* Aktuelle URL
	* @var string
	*/
	protected $strUrl;
	
	/**
	* Aktuelles Jahr Beginn 01.01.???? 00:00:00
	* @var int
	*/
	protected $intActYearBegin;
	
	/**
	* Aktuelles Jahr Ende 31.12.???? 23:59:59
	* @var int
	*/
	protected $intActYearEnd;
	
	/**
	* Aktuelle Reservierungen
	* @var array
	*/
	protected $arrReservierungen = array();
	
	/**
	* URL cache array
	* @var array
	*/
	private static $arrUrlCache = array();
	
	/**
	* Holt alle Reservierungen ab eines bestimmten Zeitraums
	*
	* @param array   $arrCalender
	* @param integer $intStart
	*
	* @return array
	*/
	protected function getAllReservierungen($arrCalender, $intStart)
	{
		$this->arrReservierungen = $arrCalender;
		
		return $this->arrReservierungen;
	}
	
	
}
