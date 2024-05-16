<?php if (!defined('PmWiki')) exit();
/**
  Bootstrap icons extension for PmWiki
  Written by (c) Petko Yotov 2023-2024   www.pmwiki.org/Petko
  License: MIT, see file LICENSE
  
  This extension loads the Bootstrap Icons free font.
  
  The files in bi/ are those distributed at:
    https://github.com/twbs/icons/releases/
*/

$RecipeInfo['BootstrapIcons']['Version'] = '2024-05-16';

# used in the hub configuration form
$EnableBootstrapIcons = 1;

# custom tilde shortcut
Markup('bicons', 'inline', '/~((bi)-[0-9a-z-]+)/', 'FmtBiconInline');

$MarkupDirectiveFunctions['biconlist'] = "FmtBiconList";

function FmtBiconInline($m) {
  static $seen = 0;
  if(!$seen++) extAddResource('bi/bootstrap-icons.min.css');
  return "<i class='{$m[2]} {$m[1]}'></i>";
}

function FmtBiconList($pagename='', $d='', $args=[]) {
  static $injected = 0, $list = [];
  if(!$list) {
    $conf = extGetConfig();
    $css = file_get_contents("{$conf['=dir']}/bi/bootstrap-icons.min.css");
    
    preg_match_all('/\\.bi-(\\w[-\\w]*)::before/', $css, $m);
    $list = $m[1];
  }
  
  $pat = isset($args['name']) ? $args['name'] : '*';
  
  $filtered = $pat=='*' ? $list : MatchNames($list, $pat);
  
  $empty = Keep('');
  $style = '%list biconlist filterable frame%';
  
  $out = '';
  foreach($filtered as $icon) {
    $out .= "* ~bi-$icon  ~{$empty}bi-$icon $style\n";
    $style = '';
  }
  
  if($out && !$injected++) {
    extAddResource('copyicons.css copyicons.js');
  }
  return PRR($out);
}

