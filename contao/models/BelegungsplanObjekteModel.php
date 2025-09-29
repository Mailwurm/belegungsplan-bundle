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

use Contao\BackendUser;
use Contao\Model;
use Contao\Model\Collection;
use Contao\System;

/**
 * Lesen und Schreiben Belegungsplan Objekte.
 *
 * @property int    $id
 * @property int    $pid
 * @property int    $sorting
 * @property int    $tstamp
 * @property string $name
 * @property string $infotext
 * @property int    $author
 * @property bool   $published
 *
 * @method static BelegungsplanObjekteModel|null                                             findById($id, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findByPk($id, array $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findByIdOrName($val, array $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneBy($col, $val, array $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByPid($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneBySorting($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByTstamp($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByName($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByInfotext($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByAuthor($val, $opt=array())
 * @method static BelegungsplanObjekteModel|null                                             findOneByPublished($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByPid($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findBySorting($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByTstamp($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByName($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByInfotext($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByAuthor($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findByPublished($val, $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findMultipleByIds($val, array $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null findAll(array $opt=array())
 * @method static integer                                                                    countById($id, $opt=array())
 * @method static integer                                                                    countByPid($val, $opt=array())
 * @method static integer                                                                    countBySorting($val, $opt=array())
 * @method static integer                                                                    countByTstamp($val, $opt=array())
 * @method static integer                                                                    countByName($val, $opt=array())
 * @method static integer                                                                    countByInfotext($val, $opt=array())
 * @method static integer                                                                    countByAuthor($val, $opt=array())
 * @method static integer                                                                    countByPublished($val, $opt=array())
 */
class BelegungsplanObjekteModel extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_belegungsplan_objekte';

    /**
     * Find a published Belegungsplanobjekt from one or more categories by its ID or name.
     *
     * @param mixed $varId      The numeric ID or name
     * @param array $arrPids    An array of parent IDs
     * @param array $arrOptions An optional options array
     *
     * @return BelegungsplanObjekteModel|null The model or null if there is no Belegungsplanobjekt
     */
    public static function findPublishedByParentAndIdOrName($varId, $arrPids, array $arrOptions = [])
    {
        $user = System::getContainer()->get('security.helper')->getUser();

        if (empty($arrPids)) {
            return null;
        }
        $t = static::$strTable;
        $arrColumns = !is_numeric($varId) ? ["$t.name=?"] : ["$t.id=?"];
        $arrColumns[] = "$t.pid IN(".implode(',', array_map('intval', $arrPids)).')';
        if (isset($arrOptions['ignoreFePreview']) || !$user instanceof BackendUser) {
            $arrColumns[] = "$t.published='1'";
        }

        return static::findOneBy($arrColumns, $varId, $arrOptions);
    }

    /**
     * Find all published Belegungsplanobjekte by their parent ID.
     *
     * @param int   $intPid     The parent ID
     * @param array $arrOptions An optional options array
     *
     * @return Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null A collection of models or null if there are no Belegungsplanobjekte
     */
    public static function findPublishedByPid($intPid, array $arrOptions = [])
    {
        $user = System::getContainer()->get('security.helper')->getUser();

        $t = static::$strTable;
        $arrColumns = ["$t.pid=?"];
        if (isset($arrOptions['ignoreFePreview']) || !$user instanceof BackendUser) {
            $arrColumns[] = "$t.published='1'";
        }
        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.sorting";
        }

        return static::findBy($arrColumns, $intPid, $arrOptions);
    }

    /**
     * Find all published Belegungsplanobjekte by their parent IDs.
     *
     * @param array $arrPids    An array of Belegungsplan category IDs
     * @param array $arrOptions An optional options array
     *
     * @return Collection|array<BelegungsplanObjekteModel>|BelegungsplanObjekteModel|null A collection of models or null if there are no Belegungsplanobjekte
     */
    public static function findPublishedByPids($arrPids, array $arrOptions = [])
    {
        $user = System::getContainer()->get('security.helper')->getUser();

        if (empty($arrPids)) {
            return null;
        }
        $t = static::$strTable;
        $arrColumns = ["$t.pid IN(".implode(',', array_map('intval', $arrPids)).')'];
        if (isset($arrOptions['ignoreFePreview']) || !$user instanceof BackendUser) {
            $arrColumns[] = "$t.published='1'";
        }
        if (!isset($arrOptions['order'])) {
            $arrOptions['order'] = "$t.pid, $t.sorting";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }
}
