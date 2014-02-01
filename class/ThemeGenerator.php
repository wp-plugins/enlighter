<?php
/**
	Enlighter Class
	Version: 1.0
	Author: Andi Dittrich
	Author URI: http://andidittrich.de
	Plugin URI: http://www.a3non.org/go/enlighterjs
	License: MIT X11-License
	
	Copyright (c) 2013, Andi Dittrich

	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class ThemeGenerator{
	
	// update cache/generate dynamic css
	public static function generateCSS($settingsUtil, $styleKeys){
		// custom theme selected ?
		if ($settingsUtil->getOption('defaultTheme') != 'wpcustom'){
			return;
		}
		
		// load css template
		$cssTPL = new SimpleTemplate(ENLIGHTER_PLUGIN_PATH.'/views/css/'.$settingsUtil->getOption('customThemeBase').'.css');
		
		// generate token styles
		foreach ($styleKeys as $key=>$tokenname){
			$styles = '';
			
			// text color overwrite available ?
			if (($o = $settingsUtil->getOption('custom-color-'.$tokenname)) != false){
				$styles .= 'color: '.$o.';';
			}
			
			// bg color overwrite available ?
			if (($o = $settingsUtil->getOption('custom-bgcolor-'.$tokenname)) != false){
				$styles .= 'background-color: '.$o.';';
			}
			
			// style overwrite available ?
			if (($o = $settingsUtil->getOption('custom-fontstyle-'.$tokenname)) != false){
				switch ($o){
					case 'bold':
						$styles .= 'font-weight: bold;';
						break;
					case 'italic':
						$styles .= 'font-style: italic;';
						break;
					case 'bolditalic':
						$styles .= 'font-weight: bold;font-style: italic;';
						break;
				}
			}
			
			// decoration overwrite available ?
			if (($o = $settingsUtil->getOption('custom-decoration-'.$tokenname)) != false){
				switch ($o){
					case 'overline':
						$styles .= 'text-decoration: overline;';
						break;
					case 'underline':
						$styles .= 'text-decoration: underline';
						break;
					case 'through':
						$styles .= 'text-decoration: line-through;';
						break;
				}
			}
						
			// assign token style
			$cssTPL->assign(strtoupper($tokenname), $styles);
		}
		
		// generate font styles
		$fontstyles = '';
		if (($o = $settingsUtil->getOption('customFontFamily')) != false){
			$fontstyles .= 'font-family: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customFontSize')) != false){
			$fontstyles .= 'font-size: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customLineHeight')) != false){
			$fontstyles .= 'line-height: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customFontColor')) != false){
			$fontstyles .= 'color: '.$o.';';
		}
		
		// assign font styles
		$cssTPL->assign('FONTSTYLE', $fontstyles);
		
		// generate line styles
		$linestyles = '';
		if (($o = $settingsUtil->getOption('customLinenumberFontFamily')) != false){
			$linestyles .= 'font-family: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customLinenumberFontSize')) != false){
			$linestyles .= 'font-size: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customLinenumberLineHeight')) != false){
			$linestyles .= 'line-height: '.$o.';';
		}
		if (($o = $settingsUtil->getOption('customLinenumberFontColor')) != false){
			$linestyles .= 'color: '.$o.';';
		}		
		
		$cssTPL->assign('LINESTYLE', $linestyles);
		
		// special styles
		if (($o = $settingsUtil->getOption('customLineHighlightColor')) != false){
			$cssTPL->assign('HIGHLIGHT_BG_COLOR', $o);
		}
		if (($o = $settingsUtil->getOption('customLineHoverColor')) != false){
			$cssTPL->assign('HOVER_BG_COLOR', $o);
		}
		
		// store file
		$cssTPL->store(ENLIGHTER_PLUGIN_PATH.'/cache/EnlighterJS.custom.css');
	}
	
}