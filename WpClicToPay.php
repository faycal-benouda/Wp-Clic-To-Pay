<?php 
/*
Plugin Name: clicktopay-smt
Description: Plugin ClickToPay SMT Tunisie
Author: Fayçal ben ouda
Version: 1.1.0
*/
class load_language {
    public function __construct(){ add_action('init', array($this, 'load_fay_languages')); }
    public function load_fay_languages() { load_plugin_textdomain('clicktopay-smt', FALSE, dirname(plugin_basename(__FILE__)).'/languages/'); }
}
$load_language = new load_language;

define( 'ctpt_SOULADAPLUG_VERSION'       , '1.1.0');
define( 'ctpt_SOULADAPLUG_PLUGIN_FILE'   , __FILE__);
define( 'ctpt_SOULADAPLUG_PLUGIN_DIR'    , plugin_dir_path(__FILE__) );
define( 'ctpt_SOULADAPLUG_PLUGIN_URL'    , plugin_dir_url(__FILE__) );
define( 'ctpt_SOULADAPLUG_PLUGIN_HOOK'   , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

require_once plugin_dir_path( __FILE__ ) . 'includes/fct.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/CustomPostType.php';


