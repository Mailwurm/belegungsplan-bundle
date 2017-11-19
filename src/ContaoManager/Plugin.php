<?php

declare(strict_types = 1);

/*
* This file is part of Contao.
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\ContaoManager;
use Mailwurm\BelegungsplanBundle\BelegungsplanBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
/**
 * Plugin for the Contao Manager.
 *
 * @author Jan Karai
 */
class Plugin implements BundlePluginInterface {
	/**
	* {@inheritdoc}
	*/
	public function getBundles(ParserInterface $parser) {
		return [
			BundleConfig::create(MailwurmBelegungsplanBundle::class)
			->setLoadAfter([ContaoCoreBundle::class])
			->setReplace(['belegungsplan']),
		];
	}
}
