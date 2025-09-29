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
 * Reads and writes Belegungsplan categories.
 *
 * @property int    $id
 * @property int    $tstamp
 * @property string $title
 *
 * @method static BelegungsplanCategoryModel|null                                              findById($id, array $opt=array())
 * @method static BelegungsplanCategoryModel|null                                              findByPk($id, array $opt=array())
 * @method static BelegungsplanCategoryModel|null                                              findOneBy($col, $val, array $opt=array())
 * @method static BelegungsplanCategoryModel|null                                              findOneByTstamp($val, array $opt=array())
 * @method static BelegungsplanCategoryModel|null                                              findOneByTitle($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCategoryModel>|BelegungsplanCategoryModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCategoryModel>|BelegungsplanCategoryModel|null findByTitle($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCategoryModel>|BelegungsplanCategoryModel|null findMultipleByIds($val, array $opt=array())
 * @method static Collection|array<BelegungsplanCategoryModel>|BelegungsplanCategoryModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|array<BelegungsplanCategoryModel>|BelegungsplanCategoryModel|null findAll(array $opt=array())
 * @method static integer                                                                      countById($id, array $opt=array())
 * @method static integer                                                                      countByTstamp($val, array $opt=array())
 * @method static integer                                                                      countByTitle($val, array $opt=array())
 */
class BelegungsplanCategoryModel extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_belegungsplan_category';
}
