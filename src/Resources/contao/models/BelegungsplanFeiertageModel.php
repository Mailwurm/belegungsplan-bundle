<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */
namespace Mailwurm\Feiertage;
/**
* Reads and writes Belegungsplan feiertage
*
* @property integer $id
* @property integer $tstamp
* @property string  $title
* @property integer $startDate
* @property integer $endDate
* @property integer $author
*
* @method static BelegungsplanFeiertageModel|null findById($id, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findByPk($id, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneBy($col, $val, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneByTstamp($val, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneByTitle($val, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneByStartDate($val, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneByEndDate($val, array $opt=array())
* @method static BelegungsplanFeiertageModel|null findOneByAuthor($val, array $opt=array())
*
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByPid($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByTstamp($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByTitle($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByStartDate($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByEndDate($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findByAuthor($val, array $opt=array()) 
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findMultipleByIds($val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findBy($col, $val, array $opt=array())
* @method static Model\Collection|BelegungsplanFeiertageModel[]|BelegungsplanFeiertageModel|null findAll(array $opt=array())
*
* @method static integer countById($id, array $opt=array())
* @method static integer countByPid($val, $opt=array())
* @method static integer countByTstamp($val, array $opt=array())
* @method static integer countByTitle($val, array $opt=array())
* @method static integer countByStartDate($val, array $opt=array())
* @method static integer countByEndDate($val, array $opt=array())
* @method static integer countByAuthor($val, array $opt=array())
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class BelegungsplanFeiertageModel extends \Model {
	/**
	* Table name
	* @var string
	*/
	protected static $strTable = 'tl_belegungsplan_feiertage';
}
