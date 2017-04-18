<?php 
add_action( 'admin_menu', 'settingctpt_add_admin_menu' );
add_action( 'admin_init', 'settingctpt_settings_init' );
add_action( 'admin_enqueue_scripts', 'ctp_wptuts_add_color_picker' );


function ctp_wptuts_add_color_picker( $hook ) {
    if( is_admin() ) {    
        wp_enqueue_style( 'wp-color-picker' ); 
        wp_enqueue_script( 'custom-script-handle', plugins_url( '..js/fay-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}

function settingctpt_add_admin_menu(  ) { 
	add_menu_page('ClickToPay SMT', 'ClickToPay SMT', 'manage_options', 'ctpt', 'settingctpt_options_page','dashicons-cart');
	add_submenu_page( 'ctpt', 'Donateur', 'Donateur','manage_options', 'edit.php?post_type=donateur');
	add_submenu_page( 'ctpt', 'Log', 'Log','manage_options', 'edit.php?post_type=ctpt_log');
}

function settingctpt_settings_init(  ) { 
	register_setting( 'cpt_section_general', 'settingctpt_settings' );
	add_settings_section(
		'settingctpt_general_section', 
		__( 'Général', 'FayCustomPlug' ), 
		'settingctpt_general_section_callback', 
		'cpt_section_general'
	);

	add_settings_field( 
		'fay_custom_email', 
		__( 'Email :', 'FayCustomPlug' ), 
		'fay_custom_email_render', 
		'cpt_section_general', 
		'settingctpt_general_section' 
	);

	add_settings_field( 
		'fay_custom_phone', 
		__( 'Phone :', 'FayCustomPlug' ), 
		'fay_custom_phone_render', 
		'cpt_section_general', 
		'settingctpt_general_section' 
	);

	add_settings_field( 
		'fay_custom_nom', 
		__( 'Nom responsable :', 'FayCustomPlug' ), 
		'fay_custom_nom_render', 
		'cpt_section_general', 
		'settingctpt_general_section' 
	);

	add_settings_field( 
		'fay_custom_societe', 
		__( 'Société :', 'FayCustomPlug' ), 
		'fay_custom_societe_render', 
		'cpt_section_general', 
		'settingctpt_general_section' 
	);

	register_setting( 'section_clicktopay', 'settingctpt_settings' );
	add_settings_section(
		'settingctpt_clicktopay_section', 
		__( 'Click To Pay', 'FayCustomPlug' ), 
		'settingctpt_clicktopay_section_callback', 
		'section_clicktopay'
	);

	add_settings_field( 
		'fay_clicktopay_merchantid', 
		__( 'Merchant ID :', 'FayCustomPlug' ), 
		'fay_clicktopay_merchantid_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);

	add_settings_field( 
		'fay_clicktopay_merchantkey', 
		__( 'Merchant key :', 'FayCustomPlug' ), 
		'fay_clicktopay_merchantkey_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);

	add_settings_field( 
		'fay_clicktopay_currency', 
		__( 'Currency :', 'FayCustomPlug' ), 
		'fay_clicktopay_currency_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);

	add_settings_field( 
		'fay_clicktopay_sandbox', 
		__( 'Sandbox :', 'FayCustomPlug' ), 
		'fay_clicktopay_sandbox_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);

	add_settings_field( 
		'fay_clicktopay_pageconfirmation', 
		__( 'Page (confirmation) :', 'FayCustomPlug' ), 
		'fay_clicktopay_pageconfirmation_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);

	add_settings_field( 
		'fay_clicktopay_pagecancel', 
		__( 'Page (cancel) :', 'FayCustomPlug' ), 
		'fay_clicktopay_pagecancel_render', 
		'section_clicktopay', 
		'settingctpt_clicktopay_section' 
	);
}

function fay_custom_email_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_custom_email]' value='<?php echo $options['fay_custom_email']; ?>' class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
     </div>
	<?php
}

function fay_custom_phone_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='tel' name='settingctpt_settings[fay_custom_phone]' value='<?php echo $options['fay_custom_phone']; ?>' required="required" class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
     </div>
	<?php
}


function fay_custom_nom_render(  ) { 

	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_custom_nom]' value='<?php echo $options['fay_custom_nom']; ?>' class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
     </div>
	<?php

}

function fay_custom_societe_render(  ) { 

	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_custom_societe]' value='<?php echo $options['fay_custom_societe']; ?>' class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-building" aria-hidden="true"></i></span>
     </div>
	<?php

}

function fay_clicktopay_merchantid_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_clicktopay_merchantid]' value='<?php echo $options['fay_clicktopay_merchantid']; ?>' class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
     </div>
	<?php
}

function fay_clicktopay_merchantkey_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_clicktopay_merchantkey]' value='<?php echo $options['fay_clicktopay_merchantkey']; ?>' required="required" class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
     </div>
	<?php
}
function fay_clicktopay_currency_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
	<div class="input-group">
    	<input type='text' name='settingctpt_settings[fay_clicktopay_currency]' value='<?php echo $options['fay_clicktopay_currency']; ?>' placeholder="For example : TND" required="required" class="form-control" />
    	<span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
     </div>
	<?php
}


function GetUrlSandbox(){
	$options = get_option( 'settingctpt_settings' );
	$sandbox=$options['fay_clicktopay_sandbox'];
	if(isset($sandbox) && $sandbox=="1"):
	   $urlsandbox="https://clictopay.monetiquetunisie.com/clicktopay/getpurchase.aspx";
	else:
	   $urlsandbox="https://www.smt-sps.com.tn/clicktopay/getpurchase.aspx";
	endif;
	return $urlsandbox;

}

function fay_clicktopay_sandbox_render(  ) { 
	$options = get_option( 'settingctpt_settings' );	?>
    	<div class="input-group">
			<select name='settingctpt_settings[fay_clicktopay_sandbox]' class="form-control">
				<option value='0' <?php if( $options['fay_clicktopay_sandbox']== 0 ): ?> selected="selected" <?php endif;?> >Non</option>
				<option value='1' <?php if( $options['fay_clicktopay_sandbox']== 1 ): ?> selected="selected" <?php endif;?> >Oui</option>
			</select>
			<span class="input-group-addon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
        </div>	
	<?php
}

function fay_clicktopay_pageconfirmation_render(  ) { 
	$options = get_option( 'settingctpt_settings' );
	$args = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => $options['fay_clicktopay_pageconfirmation'],
    'echo'                  => 1,
    'name'                  => 'settingctpt_settings[fay_clicktopay_pageconfirmation]',
    'id'                    => null, // string
    'class'                 => "form-control", // string
    'show_option_none'      => null, // string
    'show_option_no_change' => null, // string
    'option_none_value'     => null, // string
);
	?>
	<div class="input-group">
		<?php wp_dropdown_pages( $args );?>
     </div>
	<?php
}

function fay_clicktopay_pagecancel_render(  ) { 
	$options = get_option( 'settingctpt_settings' );
	$args = array(
    'depth'                 => 0,
    'child_of'              => 0,
    'selected'              => $options['fay_clicktopay_pagecancel'],
    'echo'                  => 1,
    'name'                  => 'settingctpt_settings[fay_clicktopay_pagecancel]',
    'id'                    => null, // string
    'class'                 => "form-control", // string
    'show_option_none'      => null, // string
    'show_option_no_change' => null, // string
    'option_none_value'     => null, // string
);
	?>
	<div class="input-group">
		<?php wp_dropdown_pages( $args );?>
     </div>
	<?php
}

function settingctpt_general_section_callback(  ) { echo __( '<p>Configuration Générale</p>', 'FayCustomPlug' );}
function settingctpt_clicktopay_section_callback(  ) { echo __( '<p>Configuration ClickToPay</p>', 'FayCustomPlug' );}

function settingctpt_options_page(  ) { 	?>
	<form action='options.php' method='post' class="BcOptionsFayc">
		<h2>Configuration Clicktopay</h2>
			<?php settings_fields( 'cpt_section_general' );	?>

	        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 BcSectionSetting">
	           <div class="BcContentSectionSetting">
	              <?php do_settings_sections( 'cpt_section_general' );?>
	           </div>
	        </div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 BcSectionSetting">
	           <div class="BcContentSectionSetting">
	              <?php do_settings_sections( 'section_clicktopay' );?>
	           </div>
	        </div>

	        <div class="clear"></div>
			<?php submit_button(_('Mettre à jour'));?>
	</form>
<?php
}

function Get_settingctpt_options(  ) { 
	$option_configuration= get_option( 'settingctpt_settings' );
	return $option_configuration;
}

function wpctpt_scripts_fay() {
	$options = get_option( 'settingctpt_settings' );
	wp_register_script( 'ctptfay-jquery1', plugins_url( '../vendor/jquery/jquery.min.js', __FILE__ ),array(), '', true );
	wp_enqueue_script( 'ctptfay-jquery1' );

	wp_register_script( 'ctptfay-bootstrap1', plugins_url( '../vendor/bootstrap/js/bootstrap.min.js', __FILE__ ),array(), '', true );
    wp_enqueue_script( 'ctptfay-bootstrap1' );

    wp_register_script( 'ctptfay-script1', plugins_url( '../js/script.js?cache='.time(), __FILE__ ),array(), '', true );
	wp_enqueue_script( 'ctptfay-script1' );
	
	wp_register_script( 'ctptfay-sweetalert', plugins_url( '../vendor/sweetalert/sweetalert.min.js', __FILE__ ),array(), '', true );
	wp_enqueue_script( 'ctptfay-sweetalert' );

}
add_action( 'wp_enqueue_scripts', 'wpctpt_scripts_fay' );

function wpctpt_styles_fay(){
	wp_register_style( 'ctptfayCSS-sweetalert', plugins_url( '../vendor/sweetalert/sweetalert.css?cache='.time(), __FILE__ ), array(), '', 'all' );
	wp_enqueue_style( 'ctptfayCSS-sweetalert' );

	wp_register_style( 'ctptfay-style1', plugins_url( '../css/styles.css?cache='.time(), __FILE__ ), array(), '', 'all' );
    wp_enqueue_style( 'ctptfay-style1' );

    wp_register_style( 'ctptfay-bootstrap', plugins_url( '../vendor/bootstrap/css/bootstrap.min.css', __FILE__ ), array(), '', 'all' );
	wp_enqueue_style( 'ctptfay-bootstrap' );

    wp_register_style( 'ctptfay-fontawesome', plugins_url( '../vendor/font-awesome/css/font-awesome.min.css', __FILE__ ), array(), '', 'all' );
    wp_enqueue_style( 'ctptfay-fontawesome' );
}
add_action( 'wp_enqueue_scripts', 'wpctpt_styles_fay' );

function cpt_admin_style() {
	wp_register_style('admin-styles1', plugins_url('../vendor/bootstrap/css/bootstrap.min.css', __FILE__ ), false, '1.0.0', 'all');
	wp_enqueue_style( 'admin-styles1' );

	wp_register_style( 'admin-styles2', plugins_url( '../vendor/font-awesome/css/font-awesome.min.css', __FILE__ ), array(), '', 'all' );
	wp_enqueue_style( 'admin-styles2' );

	wp_register_style('admin-styles3', plugins_url('../css/admin.css',__FILE__), false, '1.0.0', 'all');
	wp_enqueue_style( 'admin-styles3' );

	//wp_register_script( 'ctptfay-jquery1', plugins_url( '/vendor/jquery/jquery.min.js', __FILE__ ),array(), '', true );
	//wp_enqueue_script( 'ctptfay-jquery1' );

	wp_register_script( 'ctptfay-bootstrap1', plugins_url( '../vendor/bootstrap/js/bootstrap.min.js', __FILE__ ),array(), '', true );
	wp_enqueue_script( 'ctptfay-bootstrap1' );
}
add_action('admin_enqueue_scripts', 'cpt_admin_style');


function cpt_add_js_scripts() {
	wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . '../js/ajax.js', array('jquery'), '1.0', true );
	wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action('wp_enqueue_scripts', 'cpt_add_js_scripts');
