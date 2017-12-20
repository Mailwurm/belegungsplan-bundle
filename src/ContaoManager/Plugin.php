<?php
/*
 * This file is part of Contao.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */
namespace Mailwurm\BelegungsplanBundle\ContaoManager;

#use Contao\CoreBundle\ContaoCoreBundle;
#use Mailwurm\BelegungsplanBundle\MailwurmBelegungsplanBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
* Plugin for the Contao Manager.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class Plugin implements BundlePluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getBundles(ParserInterface $parser)
	{
		return [
			BundleConfig::create('Mailwurm\BelegungsplanBundle\MailwurmBelegungsplanBundle')
				->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
				->setReplace(['belegung']),
		];
	}
}
