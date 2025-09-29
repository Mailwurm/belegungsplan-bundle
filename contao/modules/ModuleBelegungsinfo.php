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

use Contao\BackendModule;
use Contao\StringUtil;
use Contao\System;

/**
 * Class ModuleBelegungsinfo.
 */
class ModuleBelegungsinfo extends BackendModule
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'be_belegungsinfo';

    /**
     * Generate the module.
     *
     * @throws \Exception
     */
    protected function compile(): void
    {
        System::loadLanguageFile('tl_beleginfo');

        $this->Template->content = '';
        $this->Template->href = $this->getReferer(true);
        $this->Template->title = StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
        $this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];

        foreach ($GLOBALS['TL_BELEGUNGSINFO'] as $callback) {
            $this->import($callback);

            $buffer = $this->$callback->run();

            if ($this->$callback->isActive()) {
                $this->Template->content = $buffer;
                break;
            }

            $this->Template->content .= $buffer;
        }
    }
}
