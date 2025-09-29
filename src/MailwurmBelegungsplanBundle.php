<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

namespace Mailwurm\BelegungsplanBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the Mailwurm Belegungsplan bundle.
 */
class MailwurmBelegungsplanBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
