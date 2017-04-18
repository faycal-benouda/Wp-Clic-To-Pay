<?php 
/**ctp_RegisterCustomPost**/
function ctp_RegisterCustomPost(){

	register_post_type( 'donateur',
		array(
				'labels' => array(
						'name' => __( 'Donateur' ),
						'singular_name' => __( 'Donateur' )
				),
		'supports'     => array( 'title', 'revisions' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_menu' => 'admin.php?page=ctpt',
		'register_meta_box_cb' => 'add_donateur_metaboxes'
		)
	);

	register_post_type( 'ctpt_log',
		array(
				'labels' => array(
						'name' => __( 'Log' ),
						'singular_name' => __( 'Log' )
				),
		'supports'     => array( 'title', 'editor', 'revisions' ),
		'public'       => true,
		'has_archive'  => true,
		'show_in_menu' => 'admin.php?page=ctpt'
		)
	);
}
add_action("init","ctp_RegisterCustomPost");
/**END ctp_RegisterCustomPost**/


/**List of fields Posttype**/
function ListFieldsDonation() {
	$arrayOuiNon=array(
		array("id"=>0,"value"=>"Non"),
		array("id"=>1,"value"=>"Oui")
		);
	$arraystatus=array(
		array("id"=>1,"value"=>"Terminé"),
		array("id"=>2,"value"=>"En cours"),
		array("id"=>3,"value"=>"Echoué")
		);

	$ListFieldsDonation=array(
		array(
			"title"=>"fay_donation_nomdonateur",
			"label"=>"Nom donateur",
			"type"=>"text"
			),
		array(
			"title"=>"fay_donation_numdonateur",
			"label"=>"Téléphone donateur",
			"type"=>"text"
			),
		array(
			"title"=>"fay_donation_emaildonateur",
			"label"=>"E-mail donateur",
			"type"=>"text"
			),
		array(
			"title"=>"fay_donation_montant",
			"label"=>"Montant",
			"type"=>"text"
			),
		array(
			"title"      => "fay_donation_status",
			"label"      => "Statut",
			"type"       => "select",
			"value"      => $arraystatus,
			"post_type"  => null
			),
		array(
			"title"      => "fay_donation_ref",
			"label"      => "Reference",
			"type"       => "text"
			),
		);
	return $ListFieldsDonation;
}
/**END List of fields Posttype**/


/*Meta Boxes PostType*/
    function add_donateur_metaboxes() {
        add_meta_box('wpt_donateur_metas', 'Caractéristiques de la Donation', 'wpt_donateur_metas', 'donateur', 'normal', 'high');
    }
    function wpt_donateur_metas() {
        global $post;
        $postid=$post->ID;
        echo '<input type="hidden" name="donationmeta_noncename" id="donationmeta_noncename" value="' . 
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
        ctp_ContentFields(ListFieldsDonation(),$post->ID);
    }

    function wpt_save_donateur_meta($post_id, $post) {
        if ( !wp_verify_nonce( $_POST['donationmeta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
        }
        ctp_coreSave(ListFieldsDonation(),$_POST,$post->ID);
    }
    add_action('save_post', 'wpt_save_donateur_meta', 1, 2);
/*END Meta Boxes PostType*/



/*Manage Columns PostType*/
function my_edit_donateur_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'N°' ),
        'donateur' => __( 'donateur' ),
        'montant' => __( 'Montant' ),
        'etat'   => __("Etat"),
        'date' => __( 'Date' )
    );

    return $columns;
}
add_filter( 'manage_edit-donateur_columns', 'my_edit_donateur_columns' ) ;



function my_manage_donateur_columns( $column, $post_id ) {
    global $post;
    switch( $column ) {
        case 'title' :
        printf( "# %s",$post_id );
        break;

        case 'donateur' :
            $donateurref = get_post_meta( $post_id, 'fay_donation_ref', true );
			$donateurnom = get_post_meta( $post_id, 'fay_donation_nomdonateur', true );
            $donateurnum = get_post_meta( $post_id, 'fay_donation_numdonateur', true );
            $donateuremail = get_post_meta( $post_id, 'fay_donation_emaildonateur', true );
            if ( empty( $donateurnom ) ) echo __( 'inconnu' ); else{
                printf("<p><b>Ref :</b> %s</p><p><b>Nom :</b> %s</p><p><b>Num :</b> %s</p><p><b>E-mail :</b> %s</p>",$donateurref, $donateurnom,$donateurnum,$donateuremail );
            }
        break;

        case 'montant' :
            $montant = get_post_meta( $post_id, 'fay_donation_montant', true );
            if ( empty( $montant ) ) echo __( '-' ); else printf("%s TND", $montant );
        break;

        case 'etat' :
            $etat = get_post_meta( $post_id, 'fay_donation_status', true );
            if ( empty( $etat ) ) echo __( 'inconnu' ); else printf("<span class='Status".$etat."'>%s</span>", GetStatus($etat) );
        break;

        default :
        
        break;
    }
}
add_action( 'manage_donateur_posts_custom_column', 'my_manage_donateur_columns', 10, 2 );
/*END Manage Columns PostType*/
    