<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 *
 * @author Jan Karai <https://www.sachsen-it.de>
 */
$GLOBALS['TL_LANG']['XPL'] = array(
	'belegungsplan_color_frei'				=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaFrei ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(76,174,76,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;76,174,76</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Freie-Tage-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_belegt' 			=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBelegt ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(212,63,58,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> <code class="language-php">&nbsp;212,63,58</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Belegte-Tage-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_text'				=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaText ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Text-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_rahmen'			=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaRahmen ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Tabellenrahmen-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_kategorie'		=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeKategorie ?&gt;</code>'),
													array('Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Hauptkategorie-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_kategorie'			=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorie ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/HG-Kategoriezeile-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_kategorietext'		=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorietext ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(0,0,0,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;0,0,0</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Text-Kategoriezeile-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_legende'			=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeLegende ?&gt;</code>'),
													array('Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Legende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_legende_frei'		=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeFrei ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Legende-Frei-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_legende_belegt'	=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeBelegt ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Legende-Belegt-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_wochenende'		=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeWochenende ?&gt;</code>'),
													array('Ausgabe im Template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_bgcolor_wochenende'		=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBgWochenende ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_wochenendetext'	=> array(
													array('Variable im Template:', '<code class="language-php">&lt;?= $this-&gt;RgbaWochenendetext ?&gt;</code>'),
													array('Ausgabe im Template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> steht in diesem Fall für die Farbe und <code class="language-php">1.0</code> für die Transparenz der Farbe.<br>Diese Werte können je nach gewählter Farbe und Transparenz von dem hier gezeigten Beispiel abweichen.'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Textfarbe-Wochenende-Belegungsplan.gif" alt="">')
												),
	'feiertage_hintergrund'					=> array(
													array('Variable im Template:', 'Keine Variable im Template'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Hintergrund-Belegungsplan.gif" alt="">')
												),
	'feiertage_textcolor'					=> array(
													array('Variable im Template:', 'Keine Variable im Template'),
													array('Das ändern Sie mit dieser Einstellung:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Textfarbe-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_showAusgabe'				=> array(
													array('Standard nach Belegzeiten:', 'Es werden die ausgewählten Monate für ein ganzes Jahr angezeigt.<br>Sollten Buchungen für folgende Jahre eingetragen worden sein, dann erscheint eine Auswahlbox wo das Jahr ausgewählt werden kann.<br>Mit dem Ende des letzten ausgewählten Monat wird der Kalender für das nächste Jahr angezeigt.'),
													array('Ausgabe nach Anzahl von Monaten:', 'Es wird die eingegebene Anzahl Monate beginnend ab dem aktuellen Monat angezeigt. Vergangene Monate sind somit nicht sichtbar. Buchungen für die Zukunft sind nicht sichtbar, wenn sie hinter der ausgewählten Anzahl Monate liegen.'),
													array('Ausgabe nach individuellem Zeitraum:', 'Es wird nur der ausgewählte Zeitraum angezeigt. Es erfolgt keine automatische Fortführung wie bei den anderen beiden Auswahlmöglichkeiten.')
												)
);