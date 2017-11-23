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
* Reads and writes Belegungsplan calender
*
* @property integer $id
* @property integer $pid
* @property integer $tstamp
* @property string  $gast
* @property integer $startDate
* @property integer $endDate
* @property integer $published
* @property integer $author
* @property integer $perPage
* @property string  $sortOrder

* @method static BelegungsplanCalenderModel|null findById($id, array $opt=array())
* @method static BelegungsplanCalenderModel|null findByPk($id, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneBy($col, $val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByPid($val, $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByTstamp($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByGast($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByStartDate($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByEndDate($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByPublished($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByAuthor($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneByPerPage($val, array $opt=array())
* @method static BelegungsplanCalenderModel|null findOneBySortOrder($val, array $opt=array())

* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByPid($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByTstamp($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByGast($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByStartDate($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByEndDate($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByPublished($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByPerPage($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findByAuthor($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findBySortOrder($val, array $opt=array()) 
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findMultipleByIds($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findBy($col, $val, array $opt=array())
* @method static Model\Collection|BelegungsplanCalenderModel[]|BelegungsplanCalenderModel|null findAll(array $opt=array())

* @method static integer countById($id, array $opt=array())
* @method static integer countByPid($val, $opt=array())
* @method static integer countByTstamp($val, array $opt=array())
* @method static integer countByGast($val, array $opt=array())
* @method static integer countByStartDate($val, array $opt=array())
* @method static integer countByEndDate($val, array $opt=array())
* @method static integer countByPublished($val, array $opt=array())
* @method static integer countByAuthor($val, array $opt=array())
* @method static integer countBySortOrder($val, array $opt=array())
* @method static integer countByPerPage($val, array $opt=array())

*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class BelegungsplanCalenderModel extends \Model {
	/**
	* Table name
	* @var string
	*/
	protected static $strTable = 'tl_belegungsplan_calender';
}