<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

use Contao\ArrayUtil;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Add back end modules.
 */
$arrBeleg1 = [
	'beleg' => [
		'belegung'      => [
			'tables' => ['tl_belegungsplan_category', 'tl_belegungsplan_objekte', 'tl_belegungsplan_calender'],
		],
		'feiertage'     => [
			'tables' => ['tl_belegungsplan_feiertage'],
		],
		'belegungsinfo' => [
			'callback' => 'Mailwurm\Belegung\ModuleBelegungsinfo',
		],
	],
];
$arrBeleg2 = $GLOBALS['BE_MOD'];
$GLOBALS['BE_MOD'] = array_merge($arrBeleg1, $arrBeleg2);

// Belegungsinfo
$GLOBALS['TL_BELEGUNGSINFO'] =
	[
		'Mailwurm\Belegung\Belegungsinfo',
	];

/*
 * Front end modules
 */
ArrayUtil::arrayInsert(
	$GLOBALS['FE_MOD'],
	99,
	[
		'belegung' => [
			'belegungsplan' => 'Mailwurm\Belegung\ModuleBelegungsplan',
		],
	],
);
/** @var ScopeMatcher $scopeMatcher */
$scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');
/** @var Request|null $request */
$request = System::getContainer()->get('request_stack')?->getCurrentRequest();

/*
 * Style sheet Backend
 */
if (!empty($request) && $scopeMatcher->isBackendRequest($request)) {
	$GLOBALS['TL_CSS'][] = 'bundles/mailwurmbelegungsplan/style.css|static';
}

/*
 * Style sheet Frontend
 */
if (!empty($request) && $scopeMatcher->isFrontendRequest($request)) {
	$GLOBALS['TL_CSS'][] = 'bundles/mailwurmbelegungsplan/belegungsplan.css|static';
}
/*
 * Backend form fields
 */
$GLOBALS['BE_FFL']['MonthYearWizard'] = 'Mailwurm\Belegung\MonthYearWizard';
