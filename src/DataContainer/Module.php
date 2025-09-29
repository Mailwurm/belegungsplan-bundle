<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

namespace Mailwurm\BelegungsplanBundle\DataContainer;

use Contao\Backend;
use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Contao\Environment;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class Module
{
    /**
     * Wandelt Farbcode Hexadezimal nach RGB.
     */
    #[AsCallback('tl_module', 'fields.belegungsplan_color_frei.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_belegt.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_text.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_linkText.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_rahmen.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_kategorie.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_kategorietext.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_linkKategorie.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_legende_frei.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_legende_belegt.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_bgcolor_wochenende.save')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_wochenendetext.save')]
    public function setHexToRgb($varValue, DataContainer $dc)
    {
        // Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
        if (!$dc->activeRecord) {
            return;
        }
        $hex = str_replace(' ', '', $varValue);

        try {
            if (\strlen($hex) < 6) {
                throw new \Exception($GLOBALS['TL_LANG']['tl_module']['setHexToRgb']);
            }

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            return implode(',', [$r, $g, $b]);
        } catch (\OutOfBoundsException $e) {
        }
    }

    /**
     * Wandelt Farbcode RGB nach Hexadezimal.
     */
    #[AsCallback('tl_module', 'fields.belegungsplan_color_frei.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_belegt.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_text.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_linkText.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_rahmen.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_kategorie.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_kategorietext.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_linkKategorie.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_legende_frei.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_legende_belegt.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_bgcolor_wochenende.load')]
    #[AsCallback('tl_module', 'fields.belegungsplan_color_wochenendetext.load')]
    public function setRgbToHex($varValue, DataContainer $dc)
    {
        // Rueckgabe, wenn kein aktiver Datensatz vorhanden ist (alle ueberschreiben)
        if (!$dc->activeRecord) {
            return;
        }
        $hex = '';
        // Bei Neuanlegen eines Modul abfragen
        if (!str_contains($varValue, ',')) {
            $hex .= $varValue;
        } else {
            $varValue = explode(',', $varValue);
            $hex .= str_pad(dechex((int) $varValue[0]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex((int) $varValue[1]), 2, '0', STR_PAD_LEFT);
            $hex .= str_pad(dechex((int) $varValue[2]), 2, '0', STR_PAD_LEFT);
        }

        return strtoupper($hex);
    }

    /**
     * input_field_callback: Ermoeglicht das Erstellen individueller Formularfelder.
     */
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_frei.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_belegt.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_text.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_linkText.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_rahmen.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_kategorie.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_kategorietext.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_linkKategorie.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_legende.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_bg_wochenende.input_field')]
    #[AsCallback('tl_module', 'fields.belegungsplan_reset_wochenendetext.input_field')]
    public function setResetButton(DataContainer $dc, $varValue)
    {
        if (!empty(Input::get('bpb')) && Input::get('bpb') === $dc->inputName) {
            $boolHelper = true;
            $arrSet = $this->getReturnInfo($dc->inputName);

            if (!empty($arrSet)) {
                $arrHelp = [];

                for ($i = 0, $a = \count($arrSet); $i < $a; $i += 2) {
                    if ($dc->activeRecord->{$arrSet[$i]} !== $arrSet[$i + 1]) {
                        $arrHelp[$arrSet[$i]] = $arrSet[$i + 1];
                        $boolHelper = false;
                    }
                }
            }
            if (!$boolHelper) {
                Database::getInstance()->prepare('UPDATE tl_module %s WHERE id=?')->set($arrHelp)->execute($dc->id);
            }
            // GET-Parameter wieder aus Url entfernen
            Controller::redirect(str_replace('&bpb='.$dc->inputName, '', Environment::get('request')));
            Controller::redirect(System::getReferer());
        }

        return '<div class="w50 widget">
					<h3>&nbsp;</h3>
					<a href="'.Backend::addToUrl('bpb='.$dc->inputName).'" class="tl_submit m-3-0">'.$GLOBALS['TL_LANG']['tl_module']['reset'].'</a>
				</div>';
    }

    /**
     * onload_callback: Fuehrt eine Aktion bei der Initialisierung des
     * DataContainer-Objekts aus. Setzt das Auswahlfeld von text-decoration-style auf
     * disabled, wenn bei text-decoration-line none ausgewaehlt wurde.
     */
    #[AsCallback('tl_module', 'config.onload')]
    public function setDisabled(DataContainer $dc): void
    {
        $objDecorationLine = Database::getInstance()->prepare('SELECT belegungsplan_textDecorationLine, belegungsplan_kategorieDecorationLine
											FROM tl_module
											WHERE type = ?
											AND id = ?')
            ->execute('belegungsplan', $dc->id)
        ;

        Controller::loadDataContainer('tl_module');

        empty($objDecorationLine->belegungsplan_textDecorationLine) || 'none' === $objDecorationLine->belegungsplan_textDecorationLine ? $GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_textDecorationStyle']['eval']['disabled'] = true : $GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_textDecorationStyle']['eval']['disabled'] = false;
        empty($objDecorationLine->belegungsplan_kategorieDecorationLine) || 'none' === $objDecorationLine->belegungsplan_kategorieDecorationLine ? $GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_kategorieDecorationStyle']['eval']['disabled'] = true : $GLOBALS['TL_DCA']['tl_module']['fields']['belegungsplan_kategorieDecorationStyle']['eval']['disabled'] = false;
    }

    /**
     * Prueft ob Enddatum kleiner Startdatum.
     */
    #[AsCallback('tl_module', 'fields.belegungsplan_individuellMonateEnde.save')]
    public function verifyEndDate($varValue, DataContainer $dc)
    {
        $aMonatStart = StringUtil::deserialize(Input::post('belegungsplan_individuellMonateStart'));
        $aMonatEnde = StringUtil::deserialize(Input::post('belegungsplan_individuellMonateEnde'));
        $iStart = mktime(0, 0, 0, (int) $aMonatStart['unit'], 1, (int) $aMonatStart['value']);
        $iEnde = mktime(0, 0, 0, (int) $aMonatEnde['unit'], 1, (int) $aMonatEnde['value']);

        try {
            if ($iStart > $iEnde) {
                throw new \Exception($GLOBALS['TL_LANG']['tl_module']['sameDateError']);
            }

            return $varValue;
        } catch (\OutOfBoundsException $e) {
        }
    }

    /**
     * Array mit Standardwerten, wenn Reset-Button gedrueckt wird.
     */
    private function getReturnInfo(string $strInputName): array
    {
        $arrSet =
            [
                'belegungsplan_reset_frei' => ['belegungsplan_color_frei', '76,174,76', 'belegungsplan_opacity_frei', '1.0'],
                'belegungsplan_reset_belegt' => ['belegungsplan_color_belegt', '212,63,58', 'belegungsplan_opacity_belegt', '1.0'],
                'belegungsplan_reset_text' => ['belegungsplan_color_text', '51,51,51', 'belegungsplan_opacity_text', '1.0'],
                'belegungsplan_reset_linkText' => ['belegungsplan_color_linkText', '102,16,242', 'belegungsplan_opacity_linkText', '1.0', 'belegungsplan_textDecorationLine', 'none'],
                'belegungsplan_reset_linkKategorie' => ['belegungsplan_color_linkKategorie', '102,16,242', 'belegungsplan_opacity_linkKategorie', '1.0', 'belegungsplan_kategorieDecorationLine', 'none'],
                'belegungsplan_reset_rahmen' => ['belegungsplan_color_rahmen', '221,221,221', 'belegungsplan_opacity_rahmen', '1.0'],
                'belegungsplan_reset_kategorie' => ['belegungsplan_color_kategorie', '204,204,204', 'belegungsplan_opacity_kategorie', '1.0'],
                'belegungsplan_reset_kategorietext' => ['belegungsplan_color_kategorietext', '0,0,0', 'belegungsplan_opacity_kategorietext', '1.0'],
                'belegungsplan_reset_legende' => ['belegungsplan_color_legende_frei', '255,255,255', 'belegungsplan_color_legende_belegt', '255,255,255', 'belegungsplan_opacity_legende', '1.0'],
                'belegungsplan_reset_bg_wochenende' => ['belegungsplan_bgcolor_wochenende', '204,204,204', 'belegungsplan_opacity_bg_wochenende', '1.0'],
                'belegungsplan_reset_wochenendetext' => ['belegungsplan_color_wochenendetext', '51,51,51', 'belegungsplan_opacity_wochenendetext', '1.0'],
            ];

        return $arrSet[$strInputName];
    }
}
