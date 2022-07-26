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
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaFrei ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(76,174,76,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;76,174,76</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Freie-Tage-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_belegt' 			=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBelegt ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(212,63,58,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;212,63,58</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Belegte-Tage-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_text'				=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaText ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Text-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_rahmen'			=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaRahmen ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Tabellenrahmen-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_kategorie'		=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeKategorie ?&gt;</code>'),
													array('Output in the template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Hauptkategorie-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_kategorie'			=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorie ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/HG-Kategoriezeile-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_kategorietext'		=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorietext ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(0,0,0,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;0,0,0</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Text-Kategoriezeile-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_legende'			=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeLegende ?&gt;</code>'),
													array('Output in the template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Legende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_legende_frei'		=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeFrei ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Legende-Frei-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_legende_belegt'	=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeBelegt ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Legende-Belegt-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_anzeige_wochenende'		=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeWochenende ?&gt;</code>'),
													array('Output in the template:', '<code class="language-php">true</code> oder <code class="language-php">false</code>'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_bgcolor_wochenende'		=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBgWochenende ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_color_wochenendetext'	=> array(
													array('Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaWochenendetext ?&gt;</code>'),
													array('Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Textfarbe-Wochenende-Belegungsplan.gif" alt="">')
												),
	'feiertage_hintergrund'					=> array(
													array('Variable in the template:', 'No variable in the template'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Hintergrund-Belegungsplan.gif" alt="">')
												),
	'feiertage_textcolor'					=> array(
													array('Variable in the template:', 'No variable in the template'),
													array('You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Textfarbe-Belegungsplan.gif" alt="">')
												),
	'belegungsplan_showAusgabe'				=> array(
													array('Default by occupancy times:', 'The selected months are displayed for a whole year.<br>If bookings have been entered for the following years, then a selection box appears where the year can be selected.<br>With the end of the last selected month, the calendar for the next year displayed.'),
													array('Output by number of months:', 'The number of months entered is displayed, starting with the current month.<br>Past months are therefore not visible.<br>Bookings for the future are not visible if they are past the selected number of months.'),
													array('Output according to individual period:', 'Only the selected period is displayed. There is no automatic continuation as with the other two options.')
												)
);