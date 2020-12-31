<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */
$GLOBALS['TL_LANG']['XPL'] = array(
	'belegungsplan_color_frei'				=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaFrei ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(76,174,76,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;76,174,76</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Freie-Tage-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_belegt' 			=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaBelegt ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(212,63,58,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;212,63,58</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Belegte-Tage-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_text'				=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaText ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(51,51,51,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Text-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_rahmen'			=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaRahmen ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(204,204,204,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Tabellenrahmen-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_anzeige_kategorie'		=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;AnzeigeKategorie ?&gt;</code></div>
												<div class="p-10">Output in the template: <code class="language-php">true</code> oder <code class="language-php">false</code></div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Anzeige-Hauptkategorie-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_kategorie'			=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaKategorie ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(204,204,204,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/HG-Kategoriezeile-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_kategorietext'		=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaKategorietext ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(0,0,0,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;0,0,0</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Text-Kategoriezeile-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_anzeige_legende'			=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;AnzeigeLegende ?&gt;</code></div>
												<div class="p-10">Output in the template: <code class="language-php">true</code> oder <code class="language-php">false</code></div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Anzeige-Legende-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_legende_frei'		=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeFrei ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(255,255,255,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Legende-Frei-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_legende_belegt'	=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeBelegt ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(255,255,255,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Legende-Belegt-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_anzeige_wochenende'		=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;AnzeigeWochenende ?&gt;</code></div>
												<div class="p-10">Output in the template: <code class="language-php">true</code> oder <code class="language-php">false</code></div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_bgcolor_wochenende'		=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaBgWochenende ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(204,204,204,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt=""></div>',
	'belegungsplan_color_wochenendetext'	=> '<div class="p-10">Variable in the template: <code class="language-php">&lt;?= $this-&gt;RgbaWochenendetext ?&gt;</code></div>
												<div class="p-10">Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>: <code class="language-php">rgba(51,51,51,1.0)</code></div>
												<div class="p-10">
													<span style="color:rgba(255,0,0,1.0);">*</span>
													<code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>
													These values can differ from the example shown here depending on the selected color and transparency.
												</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Textfarbe-Wochenende-Belegungsplan.gif" alt=""></div>',
	'hintergrund'							=> '<div class="p-10">No variable in the template.</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Feiertag-Hintergrund-Belegungsplan.gif" alt=""></div>',
	'textcolor'								=> '<div class="p-10">No variable in the template.</div>
												<div class="p-10"><img src="bundles/mailwurmbelegungsplan/Feiertag-Textfarbe-Belegungsplan.gif" alt=""></div>'
);