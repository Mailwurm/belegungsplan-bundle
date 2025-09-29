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
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaFrei ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(76,174,76,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;76,174,76</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Freie-Tage-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_belegt' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBelegt ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(212,63,58,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;212,63,58</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Belegte-Tage-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_text' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaText ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Text-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_linkText' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaLinkText ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(102,16,242,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;102,16,242</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
    ],
    'belegungsplan_anzeige_linkText' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;LinkText ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">true</code> or <code class="language-php">false</code>'],
    ],
    'belegungsplan_textDecorationLine' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;TextDecorationLine ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">text-decoration: none;</code> <br> <code class="language-php">text-decoration: underline;</code> <br> <code class="language-php">text-decoration: overline;</code> <br> <code class="language-php">text-decoration: line-through;</code> <br> <code class="language-php">text-decoration: underline overline;</code> <br> <code class="language-php">text-decoration: underline overline line-through;</code>'],
        ['none', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-None.jpg" alt="">'],
        ['underline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline.jpg" alt="">'],
        ['overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Overline.jpg" alt="">'],
        ['line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Line-Through.jpg" alt="">'],
        ['underline overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline.jpg" alt="">'],
        ['underline overline line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline-Line-Through.jpg" alt="">'],
    ],
    'belegungsplan_textDecorationStyle' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;TextDecorationStyle ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">text-decoration-style: solid;</code> <br> <code class="language-php">text-decoration-style: double;</code> <br> <code class="language-php">text-decoration-style: dotted;</code> <br> <code class="language-php">text-decoration-style: dashed;</code> <br> <code class="language-php">text-decoration-style: wavy;</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> Only printed if <code>text-decoration</code> is not set to <code>none</code>.'],
        ['solid', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Solid.jpg" alt="">'],
        ['double', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Double.jpg" alt="">'],
        ['dotted', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dotted.jpg" alt="">'],
        ['dashed', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dashed.jpg" alt="">'],
        ['wavy', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Wavy.jpg" alt="">'],
    ],
    'belegungsplan_color_rahmen' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaRahmen ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Tabellenrahmen-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_kategorie' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeKategorie ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">true</code> or <code class="language-php">false</code>'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Hauptkategorie-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_kategorie' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorie ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/HG-Kategoriezeile-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_kategorietext' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaKategorietext ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(0,0,0,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;0,0,0</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Text-Kategoriezeile-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_linkKategorie' => [
        ['Variable in the template::', '<code class="language-php">&lt;?= $this-&gt;LinkKategorie ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">true</code> or <code class="language-php">false</code>'],
    ],
    'belegungsplan_color_linkKategorie' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaLinkKategorie ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(102,16,242,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;102,16,242</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
    ],
    'belegungsplan_kategorieDecorationLine' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;KategorieDecorationLine ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">text-decoration: none;</code> <br> <code class="language-php">text-decoration: underline;</code> <br> <code class="language-php">text-decoration: overline;</code> <br> <code class="language-php">text-decoration: line-through;</code> <br> <code class="language-php">text-decoration: underline overline;</code> <br> <code class="language-php">text-decoration: underline overline line-through;</code>'],
        ['none', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-None.jpg" alt="">'],
        ['underline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline.jpg" alt="">'],
        ['overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Overline.jpg" alt="">'],
        ['line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Line-Through.jpg" alt="">'],
        ['underline overline', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline.jpg" alt="">'],
        ['underline overline line-through', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Line-Underline-Overline-Line-Through.jpg" alt="">'],
    ],
    'belegungsplan_kategorieDecorationStyle' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;KategorieDecorationStyle ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">text-decoration-style: solid;</code> <br> <code class="language-php">text-decoration-style: double;</code> <br> <code class="language-php">text-decoration-style: dotted;</code> <br> <code class="language-php">text-decoration-style: dashed;</code> <br> <code class="language-php">text-decoration-style: wavy;</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span> Only printed if <code>text-decoration</code> is not set to <code>none</code>.'],
        ['solid', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Solid.jpg" alt="">'],
        ['double', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Double.jpg" alt="">'],
        ['dotted', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dotted.jpg" alt="">'],
        ['dashed', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Dashed.jpg" alt="">'],
        ['wavy', '<img src="bundles/mailwurmbelegungsplan/Text-Decoration-Style-Wavy.jpg" alt="">'],
    ],
    'belegungsplan_anzeige_legende' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeLegende ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">true</code> or <code class="language-php">false</code>'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Anzeige-Legende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_legende_frei' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeFrei ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Legende-Frei-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_legende_belegt' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaTextLegendeBelegt ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(255,255,255,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;255,255,255</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Legende-Belegt-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_anzeige_wochenende' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;AnzeigeWochenende ?&gt;</code>'],
        ['Output in the template:', '<code class="language-php">true</code> or <code class="language-php">false</code>'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_bgcolor_wochenende' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaBgWochenende ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(204,204,204,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;204,204,204</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Hintergrund-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_color_wochenendetext' => [
        ['Variable in the template:', '<code class="language-php">&lt;?= $this-&gt;RgbaWochenendetext ?&gt;</code>'],
        ['Output in the template<span style="color:rgba(255,0,0,1.0);">*</span>:', '<code class="language-php">rgba(51,51,51,1.0)</code><br><br><span style="color:rgba(255,0,0,1.0);">*</span><code class="language-php">&nbsp;51,51,51</code> stands for the color and <code class="language-php">1.0</code> for the transparency of the color.<br>These values can differ from the example shown here depending on the selected color and transparency.'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Textfarbe-Wochenende-Belegungsplan.gif" alt="">'],
    ],
    'feiertage_hintergrund' => [
        ['Variable in the template:', 'No variable in the template'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Hintergrund-Belegungsplan.gif" alt="">'],
    ],
    'feiertage_textcolor' => [
        ['Variable in the template:', 'No variable in the template'],
        ['You can change that with this setting:', '<img src="bundles/mailwurmbelegungsplan/Feiertag-Textfarbe-Belegungsplan.gif" alt="">'],
    ],
    'belegungsplan_showAusgabe' => [
        ['Default by occupancy times:', 'The selected months are displayed for a whole year.<br>If bookings have been entered for the following years, then a selection box appears where the year can be selected.<br>With the end of the last selected month, the calendar for the next year displayed.'],
        ['Output by number of months:', 'The number of months entered is displayed, starting with the current month.<br>Past months are therefore not visible.<br>Bookings for the future are not visible if they are past the selected number of months.'],
        ['Output according to individual period:', 'Only the selected period is displayed. There is no automatic continuation as with the other two options.'],
    ],
];
