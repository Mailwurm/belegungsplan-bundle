<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

use Contao\Controller;
use Contao\System;

System::loadLanguageFile('tl_module');

/*
 * Add palettes to tl_module
 */
// Add a palette selector
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_kategorie';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_legende';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_wochenende';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_showAusgabe';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_linkText';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'belegungsplan_anzeige_linkKategorie';

$GLOBALS['TL_DCA']['tl_module']['palettes']['belegungsplan'] = '
	{title_legend},name,headline,type;{config_legend},belegungsplan_categories;
	{anzeige_legend},belegungsplan_showAusgabe;
	{color_legend_frei:hide},belegungsplan_color_frei,belegungsplan_opacity_frei,belegungsplan_reset_frei;
	{color_legend_belegt:hide},belegungsplan_color_belegt,belegungsplan_opacity_belegt,belegungsplan_reset_belegt;
	{text_legend:hide},belegungsplan_color_text,belegungsplan_opacity_text,belegungsplan_reset_text,belegungsplan_anzeige_linkText;
	{rahmen_legend:hide},belegungsplan_color_rahmen,belegungsplan_opacity_rahmen,belegungsplan_reset_rahmen;
	{kategorie_legend:hide},belegungsplan_anzeige_kategorie,belegungsplan_anzeige_linkKategorie;
	{legende_legend:hide},belegungsplan_anzeige_legende;
	{wochenende_legend:hide},belegungsplan_anzeige_wochenende;
	{template_legend},belegungsplan_template;
	{expert_legend:hide},cssID
	';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_showAusgabe_standard'] = 'belegungsplan_month';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_showAusgabe_automatic'] = 'belegungsplan_anzahlMonate';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_showAusgabe_individuell'] = 'belegungsplan_individuellMonateStart,belegungsplan_individuellMonateEnde';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_linkText'] = 'belegungsplan_color_linkText,belegungsplan_opacity_linkText,belegungsplan_textDecorationLine,belegungsplan_textDecorationStyle,belegungsplan_reset_linkText';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_linkKategorie'] = 'belegungsplan_color_linkKategorie,belegungsplan_opacity_linkKategorie,belegungsplan_kategorieDecorationLine,belegungsplan_kategorieDecorationStyle,belegungsplan_reset_linkKategorie';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_kategorie'] = 'belegungsplan_color_kategorie,belegungsplan_opacity_kategorie,belegungsplan_reset_kategorie,belegungsplan_color_kategorietext,belegungsplan_opacity_kategorietext,belegungsplan_reset_kategorietext';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_legende'] = 'belegungsplan_color_legende_frei,belegungsplan_color_legende_belegt,belegungsplan_opacity_legende,belegungsplan_reset_legende';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['belegungsplan_anzeige_wochenende'] = 'belegungsplan_bgcolor_wochenende,belegungsplan_opacity_bg_wochenende,belegungsplan_reset_bg_wochenende,belegungsplan_color_wochenendetext,belegungsplan_opacity_wochenendetext,belegungsplan_reset_wochenendetext';

/*
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_categories'] = [
	'exclude'    => true,
	// 'inputType' => 'checkBoxWithDragAndDropWizard',
	'inputType'  => 'checkboxWizard',
	'foreignKey' => 'tl_belegungsplan_category.title',
	'eval'       => ['multiple' => true, 'mandatory' => true],
	'sql'        => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_showAusgabe'] = [
	'inputType'   => 'radio',
	'options'     => ['standard', 'automatic', 'individuell'],
	'default'     => 'standard',
	'reference'   => &$GLOBALS['TL_LANG']['tl_module'],
	'explanation' => 'belegungsplan_showAusgabe',
	'eval'        => ['mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'w50', 'style' => 'margin:10px', 'helpwizard' => true],
	'sql'         => "varchar(11) NOT NULL default 'standard'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_month'] = [
	'exclude'   => true,
	// 'inputType' => 'checkBoxWithoutDragAndDropWizard',
	'inputType' => 'checkbox',
	'options'   => $GLOBALS['TL_LANG']['tl_module']['belegungsplan_month']['month'],
	'eval'      => ['multiple' => true, 'mandatory' => true, 'tl_class' => 'm12'],
	'sql'       => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzahlMonate'] = [
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => ['size' => 1, 'rgxp' => 'natural', 'mandatory' => true, 'maxval' => 100, 'minval' => 1, 'tl_class' => 'w50 m12'],
	'sql'       => 'smallint(5) unsigned NOT NULL default 1',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_individuellMonateStart'] = [
	'exclude'   => true,
	'inputType' => 'MonthYearWizard',
	'options'   => $GLOBALS['TL_LANG']['tl_module']['belegungsplan_month']['month'],
	'eval'      => ['rgxp' => 'natural', 'mandatory' => true, 'maxlength' => 4, 'tl_class' => 'w50 m12', 'style' => 'width:120px;margin-left:15px', 'placeholder' => $GLOBALS['TL_LANG']['tl_module']['jahr']],
	'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_individuellMonateEnde'] = [
	'exclude'   => true,
	'inputType' => 'MonthYearWizard',
	'options'   => $GLOBALS['TL_LANG']['tl_module']['belegungsplan_month']['month'],
	'eval'      => ['rgxp' => 'natural', 'mandatory' => true, 'maxlength' => 4, 'tl_class' => 'w50 m12', 'style' => 'width:120px;margin-left:15px', 'placeholder' => $GLOBALS['TL_LANG']['tl_module']['jahr']],
	'sql'       => "varchar(255) NOT NULL default ''",
];

// ------------------------- Farbauswahl freie Tage
// -------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_frei'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '76,174,76',
	'explanation' => 'belegungsplan_color_frei',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_frei'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_frei'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// ------------------------- Farbauswahl belegte Tage
// -------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_belegt'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '212,63,58',
	'explanation' => 'belegungsplan_color_belegt',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_belegt'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_belegt'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// -------------------------- Eigener Text
// ------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_text'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '51,51,51',
	'explanation' => 'belegungsplan_color_text',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_text'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_text'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_linkText'] = [
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'explanation' => 'belegungsplan_anzeige_linkText',
	'eval'        => ['submitOnChange' => true, 'tl_class' => 'w50 m12 wizard clr', 'helpwizard' => true],
	'sql'         => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_linkText'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '102,16,242',
	'explanation' => 'belegungsplan_color_linkText',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_linkText'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_textDecorationLine'] = [
	'exclude'     => true,
	'inputType'   => 'select',
	'default'     => 'none',
	'explanation' => 'belegungsplan_textDecorationLine',
	'options'     => ['none', 'underline', 'overline', 'line-through', 'underline overline', 'underline overline line-through'],
	'eval'        => ['tl_class' => 'w50', 'helpwizard' => true, 'submitOnChange' => true],
	'sql'         => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_textDecorationStyle'] = [
	'exclude'     => true,
	'inputType'   => 'select',
	'default'     => 'solid',
	'explanation' => 'belegungsplan_textDecorationStyle',
	'options'     => ['solid', 'double', 'dotted', 'dashed', 'wavy'],
	'eval'        => ['tl_class' => 'w50', 'helpwizard' => true],
	'sql'         => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_linkText'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// -------------------------- Rahmen Einstellungen
// ------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_rahmen'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '221,221,221',
	'explanation' => 'belegungsplan_color_rahmen',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_rahmen'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_rahmen'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// ------------------------- Kategorie Einstellungen
// -------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_kategorie'] = [
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'default'     => '1',
	'explanation' => 'belegungsplan_anzeige_kategorie',
	'eval'        => ['submitOnChange' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_kategorie'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '204,204,204',
	'explanation' => 'belegungsplan_color_kategorie',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_kategorie'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_kategorie'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_kategorietext'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '0,0,0',
	'explanation' => 'belegungsplan_color_kategorietext',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_kategorietext'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_kategorietext'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_linkKategorie'] = [
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'explanation' => 'belegungsplan_anzeige_linkKategorie',
	'eval'        => ['submitOnChange' => true, 'tl_class' => 'w50 m12 wizard clr', 'helpwizard' => true],
	'sql'         => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_linkKategorie'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '102,16,242',
	'explanation' => 'belegungsplan_color_linkKategorie',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_linkKategorie'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_kategorieDecorationLine'] = [
	'exclude'     => true,
	'inputType'   => 'select',
	'default'     => 'none',
	'explanation' => 'belegungsplan_kategorieDecorationLine',
	'options'     => ['none', 'underline', 'overline', 'line-through', 'underline overline', 'underline overline line-through'],
	'eval'        => ['tl_class' => 'w50', 'helpwizard' => true, 'submitOnChange' => true],
	'sql'         => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_kategorieDecorationStyle'] = [
	'exclude'     => true,
	'inputType'   => 'select',
	'default'     => 'solid',
	'explanation' => 'belegungsplan_kategorieDecorationStyle',
	'options'     => ['solid', 'double', 'dotted', 'dashed', 'wavy'],
	'eval'        => ['tl_class' => 'w50', 'helpwizard' => true],
	'sql'         => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_linkKategorie'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// ------------------------- Legende Einstellungen
// -------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_legende'] = [
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'default'     => '1',
	'explanation' => 'belegungsplan_anzeige_legende',
	'eval'        => ['submitOnChange' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_legende_frei'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '255,255,255',
	'explanation' => 'belegungsplan_color_legende_frei',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_legende_belegt'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '255,255,255',
	'explanation' => 'belegungsplan_color_legende_belegt',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_legende'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50 wizard'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_legende'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// ------------------------- Wochenende Einstellungen
// ---------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_anzeige_wochenende'] = [
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'default'     => '1',
	'explanation' => 'belegungsplan_anzeige_wochenende',
	'eval'        => ['submitOnChange' => true, 'tl_class' => 'w50 wizard', 'helpwizard' => true],
	'sql'         => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_bgcolor_wochenende'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '204,204,204',
	'explanation' => 'belegungsplan_bgcolor_wochenende',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_bg_wochenende'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_bg_wochenende'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_color_wochenendetext'] = [
	'exclude'     => true,
	'inputType'   => 'text',
	'default'     => '51,51,51',
	'explanation' => 'belegungsplan_color_wochenendetext',
	'eval'        => ['maxlength' => 6, 'minlength' => 6, 'mandatory' => true, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard clr', 'helpwizard' => true],
	'sql'         => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_opacity_wochenendetext'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['belegungsplan_opacity'],
	'exclude'   => true,
	'inputType' => 'select',
	'default'   => '1.0',
	'options'   => ['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'],
	'eval'      => ['tl_class' => 'w50'],
	'sql'       => "varchar(3) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_reset_wochenendetext'] = [
	'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
];

// ------------------------- Template-Einstellungen
// -------------------------------------------------------------------
$GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_template'] = [
	'exclude'          => true,
	'inputType'        => 'select',
	'options_callback' => static fn() => Controller::getTemplateGroup('mod_belegungsplan_'),
	'eval'             => ['mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'],
	'sql'              => "varchar(64) NOT NULL default ''",
];
