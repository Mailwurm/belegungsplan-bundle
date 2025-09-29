<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_LANG']['XPL'] = [
    'belegungsplan_color_frei' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaFrei ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(76,174,76,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;76,174,76</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Freie-Tage-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_belegt' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBelegt ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(212,63,58,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> <code class="language-php">&nbsp;212,63,58</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Belegte-Tage-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_text' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaText ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Text-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_linkText' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaLinkText ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(102,16,242,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;102,16,242</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
    ],
    'belegungsplan_anzeige_linkText' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;LinkText ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'],
    ],
    'belegungsplan_textDecorationLine' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;TextDecorationLine ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">text-decoration: none;</code> <br> <code class="language-php">text-decoration: underline;</code> <br> <code class="language-php">text-decoration: overline;</code> <br> <code class="language-php">text-decoration: line-through;</code> <br> <code class="language-php">text-decoration: underline overline;</code> <br> <code class="language-php">text-decoration: underline overline line-through;</code>'],
        ['none', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-None.jpg" alt="">'],
        ['underline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline.jpg" alt="">'],
        ['overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Overline.jpg" alt="">'],
        ['line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Line-Through.jpg" alt="">'],
        ['underline overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline.jpg" alt="">'],
        ['underline overline line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline-Line-Through.jpg" alt="">'],
    ],
    'belegungsplan_textDecorationStyle' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;TextDecorationStyle ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">text-decoration-style: solid;</code> <br> <code class="language-php">text-decoration-style: double;</code> <br> <code class="language-php">text-decoration-style: dotted;</code> <br> <code class="language-php">text-decoration-style: dashed;</code> <br> <code class="language-php">text-decoration-style: wavy;</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> Wird nur ausgegeben, wenn <code>text-decoration</code> nicht auf <code>none</code> eingestellt ist.'],
        ['solid', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Solid.jpg" alt="">'],
        ['double', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Double.jpg" alt="">'],
        ['dotted', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dotted.jpg" alt="">'],
        ['dashed', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dashed.jpg" alt="">'],
        ['wavy', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Wavy.jpg" alt="">'],
    ],
    'belegungsplan_color_rahmen' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaRahmen ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Tabellenrahmen-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_kategorie' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeKategorie ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Hauptkategorie-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_kategorie' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorie ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/HG-Kategoriezeile-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_kategorietext' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorietext ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(0,0,0,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;0,0,0</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Text-Kategoriezeile-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_linkKategorie' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;LinkKategorie ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'],
    ],
    'belegungsplan_color_linkKategorie' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaLinkKategorie ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(102,16,242,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;102,16,242</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
    ],
    'belegungsplan_kategorieDecorationLine' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;KategorieDecorationLine ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">text-decoration: none;</code> <br> <code class="language-php">text-decoration: underline;</code> <br> <code class="language-php">text-decoration: overline;</code> <br> <code class="language-php">text-decoration: line-through;</code> <br> <code class="language-php">text-decoration: underline overline;</code> <br> <code class="language-php">text-decoration: underline overline line-through;</code>'],
        ['none', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-None.jpg" alt="">'],
        ['underline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline.jpg" alt="">'],
        ['overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Overline.jpg" alt="">'],
        ['line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Line-Through.jpg" alt="">'],
        ['underline overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline.jpg" alt="">'],
        ['underline overline line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline-Line-Through.jpg" alt="">'],
    ],
    'belegungsplan_kategorieDecorationStyle' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;KategorieDecorationStyle ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">text-decoration-style: solid;</code> <br> <code class="language-php">text-decoration-style: double;</code> <br> <code class="language-php">text-decoration-style: dotted;</code> <br> <code class="language-php">text-decoration-style: dashed;</code> <br> <code class="language-php">text-decoration-style: wavy;</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> Wird nur ausgegeben, wenn <code>text-decoration</code> nicht auf <code>none</code> eingestellt ist.'],
        ['solid', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Solid.jpg" alt="">'],
        ['double', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Double.jpg" alt="">'],
        ['dotted', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dotted.jpg" alt="">'],
        ['dashed', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dashed.jpg" alt="">'],
        ['wavy', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Wavy.jpg" alt="">'],
    ],
    'belegungsplan_anzeige_legende' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeLegende ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Legende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_legende_frei' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeFrei ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Legende-Frei-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_legende_belegt' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeBelegt ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Legende-Belegt-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_wochenende' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeWochenende ?&gt;</code>'],
        ['Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_bgcolor_wochenende' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBgWochenende ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_wochenendetext' => [
        ['Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaWochenendetext ?&gt;</code>'],
        ['Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Textfarbe-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'feiertage_hintergrund' => [
        ['Variable im Template:', 'Keine Variable im Template'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Hintergrund-Belegungsplan.gif" alt="">'],
    ],
    'feiertage_textcolor' => [
        ['Variable im Template:', 'Keine Variable im Template'],
        ['Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Textfarbe-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_showAusgabe' => [
        ['Standard nach Belegzeiten:', 'Es werden die ausgewählten Monate für ein ganzes Jahr angezeigt.<br>Sollten Buchungen für folgende Jahre eingetragen worden sein, dann erscheint eine Auswahlbox wo das Jahr ausgewählt werden kann.<br>Mit dem Ende des letzten ausgewählten Monat wird der Kalender für das nächste Jahr angezeigt.'],
        ['Ausgabe nach Anzahl von Monaten:', 'Es wird die eingegebene Anzahl Monate beginnend ab dem aktuellen Monat angezeigt. Vergangene Monate sind somit nicht sichtbar. Buchungen für die Zukunft sind nicht sichtbar, wenn sie hinter der ausgewählten Anzahl Monate liegen.'],
        ['Ausgabe nach individuellem Zeitraum:', 'Es wird nur der ausgewählte Zeitraum angezeigt. Es erfolgt keine automatische Fortführung wie bei den anderen beiden Auswahlmöglichkeiten.'],
    ],
];
