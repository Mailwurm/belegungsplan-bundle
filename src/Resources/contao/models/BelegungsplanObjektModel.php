<?php
/**
* Contao Open Source CMS
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle;
/**
* Lesen und Schreiben Belegungsplan Objekte
*
* @property integer $id
* @property integer $pid
* @property integer $sorting
* @property integer $tstamp
* @property string  $name
* @property string  $infotext
* @property integer $author
* @property boolean $published
*
* @method static BelegungsplanObjektModel|null findById($id, $opt=array())
* @method static BelegungsplanObjektModel|null findByPk($id, array $opt=array())
* @method static BelegungsplanObjektModel|null findByIdOrName($val, array $opt=array())
* @method static BelegungsplanObjektModel|null findOneBy($col, $val, array $opt=array())
* @method static BelegungsplanObjektModel|null findOneByPid($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneBySorting($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneByTstamp($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneByName($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneByInfotext($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneByAuthor($val, $opt=array())
* @method static BelegungsplanObjektModel|null findOneByPublished($val, $opt=array())
*
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByPid($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findBySorting($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByTstamp($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByName($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByInfotext($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByAuthor($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findByPublished($val, $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findMultipleByIds($val, array $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findBy($col, $val, array $opt=array())
* @method static Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null findAll(array $opt=array())
*
* @method static integer countById($id, $opt=array())
* @method static integer countByPid($val, $opt=array())
* @method static integer countBySorting($val, $opt=array())
* @method static integer countByTstamp($val, $opt=array())
* @method static integer countByName($val, $opt=array())
* @method static integer countByInfotext($val, $opt=array())
* @method static integer countByAuthor($val, $opt=array())
* @method static integer countByPublished($val, $opt=array())
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class BelegungsplanObjektModel extends \Model {
	/**
	* Table name
	* @var string
	*/
	protected static $strTable = 'tl_belegungsplan_objekte';
	/**
	* Find a published Belegungsplanobjekt from one or more categories by its ID or name
	*
	* @param mixed $varId      The numeric ID or name
	* @param array $arrPids    An array of parent IDs
	* @param array $arrOptions An optional options array
	*
	* @return BelegungsplanObjektModel|null The model or null if there is no Belegungsplanobjekt
	*/
	public static function findPublishedByParentAndIdOrName($varId, $arrPids, array $arrOptions=array()) {
		if(!is_array($arrPids) || empty($arrPids)) {
			return null;
		}
		$t = static::$strTable;
		$arrColumns = !is_numeric($varId) ? array("$t.name=?") : array("$t.id=?");
		$arrColumns[] = "$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")";
		if(isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
			$arrColumns[] = "$t.published='1'";
		}
		return static::findOneBy($arrColumns, $varId, $arrOptions);
	}
	/**
	 * Find all published Belegungsplanobjekte by their parent ID
	 *
	 * @param int   $intPid     The parent ID
	 * @param array $arrOptions An optional options array
	 *
	 * @return Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null A collection of models or null if there are no Belegungsplanobjekte
	 */
	public static function findPublishedByPid($intPid, array $arrOptions=array()) {
		$t = static::$strTable;
		$arrColumns = array("$t.pid=?");
		if(isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
			$arrColumns[] = "$t.published='1'";
		}
		if(!isset($arrOptions['order'])) {
			$arrOptions['order'] = "$t.sorting";
		}
		return static::findBy($arrColumns, $intPid, $arrOptions);
	}
	/**
	 * Find all published Belegungsplanobjekte by their parent IDs
	 *
	 * @param array $arrPids    An array of Belegungsplan category IDs
	 * @param array $arrOptions An optional options array
	 *
	 * @return Model\Collection|BelegungsplanObjektModel[]|BelegungsplanObjektModel|null A collection of models or null if there are no Belegungsplanobjekte
	 */
	public static function findPublishedByPids($arrPids, array $arrOptions=array()) {
		if(!is_array($arrPids) || empty($arrPids)) {
			return null;
		}
		$t = static::$strTable;
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
			$arrColumns[] = "$t.published='1'";
		}
		if (!isset($arrOptions['order'])) {
			$arrOptions['order'] = "$t.pid, $t.sorting";
		}
		return static::findBy($arrColumns, null, $arrOptions);
	}
}
