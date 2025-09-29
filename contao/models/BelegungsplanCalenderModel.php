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

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes Belegungsplan calender.
 *
 * @property int    $id
 * @property int    $pid
 * @property int    $tstamp
 * @property string $gast
 * @property int    $startDate
 * @property int    $endDate
 * @property int    $author
 *
 * @method static BelegungsplanCalenderModel|null                                              findById($id, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findByPk($id, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneBy($col, $val, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByPid($val, $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByTstamp($val, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByGast($val, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByStartDate($val, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByEndDate($val, array $opt=array())
 * @method static BelegungsplanCalenderModel|null                                              findOneByAuthor($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByPid($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByGast($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByStartDate($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByEndDate($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findByAuthor($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findMultipleByIds($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|array<BelegungsplanCalenderModel>|BelegungsplanCalenderModel|null findAll(array $opt=array())
 * @method static integer                                                                      countById($id, array $opt=array())
 * @method static integer                                                                      countByPid($val, $opt=array())
 * @method static integer                                                                      countByTstamp($val, array $opt=array())
 * @method static integer                                                                      countByGast($val, array $opt=array())
 * @method static integer                                                                      countByStartDate($val, array $opt=array())
 * @method static integer                                                                      countByEndDate($val, array $opt=array())
 * @method static integer                                                                      countByAuthor($val, array $opt=array())
 */
class BelegungsplanCalenderModel extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_belegungsplan_calender';
}
