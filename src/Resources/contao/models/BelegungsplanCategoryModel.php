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
* Reads and writes Belegungsplan categories
*
* @property integer $id
* @property integer $tstamp
* @property string  $title

* @method static BelegungsplanCategoryModel|null findById($id, array $opt=array())
* @method static BelegungsplanCategoryModel|null findByPk($id, array $opt=array())
* @method static BelegungsplanCategoryModel|null findOneBy($col, $val, array $opt=array())
* @method static BelegungsplanCategoryModel|null findOneByTstamp($val, array $opt=array())
* @method static BelegungsplanCategoryModel|null findOneByTitle($val, array $opt=array())

* @method static Model\Collection|BelegungsplanCategoryModel[]|BelegungsplanCategoryModel|null findByTstamp($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCategoryModel[]|BelegungsplanCategoryModel|null findByTitle($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCategoryModel[]|BelegungsplanCategoryModel|null findMultipleByIds($val, array $opt=array())
* @method static Model\Collection|BelegungsplanCategoryModel[]|BelegungsplanCategoryModel|null findBy($col, $val, array $opt=array())
* @method static Model\Collection|BelegungsplanCategoryModel[]|BelegungsplanCategoryModel|null findAll(array $opt=array())
*
* @method static integer countById($id, array $opt=array())
* @method static integer countByTstamp($val, array $opt=array())
* @method static integer countByTitle($val, array $opt=array())

*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class BelegungsplanCategoryModel extends \Model {
	/**
	* Table name
	* @var string
	*/
	protected static $strTable = 'tl_belegungsplan_category';
}