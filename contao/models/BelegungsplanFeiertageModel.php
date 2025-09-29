<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

namespace Mailwurm\Feiertage;

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes Belegungsplan feiertage.
 *
 * @property int    $id
 * @property int    $tstamp
 * @property string $title
 * @property int    $startDate
 * @property int    $endDate
 * @property int    $author
 *
 * @method static BelegungsplanFeiertageModel|null                                               findById($id, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneBy($col, $val, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneByTstamp($val, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneByTitle($val, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneByStartDate($val, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneByEndDate($val, array $opt=array())
 * @method static BelegungsplanFeiertageModel|null                                               findOneByAuthor($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findByTitle($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findByStartDate($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findByEndDate($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findByAuthor($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findMultipleByIds($val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|array<BelegungsplanFeiertageModel>|BelegungsplanFeiertageModel|null findAll(array $opt=array())
 * @method static integer                                                                        countByTstamp($val, array $opt=array())
 * @method static integer                                                                        countByTitle($val, array $opt=array())
 * @method static integer                                                                        countByStartDate($val, array $opt=array())
 * @method static integer                                                                        countByEndDate($val, array $opt=array())
 * @method static integer                                                                        countByAuthor($val, array $opt=array())
 */
class BelegungsplanFeiertageModel extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_belegungsplan_feiertage';
}
