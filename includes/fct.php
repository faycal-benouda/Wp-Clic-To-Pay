<?php 

function GetStatus($id=null) {
	$array=array(1=>"Terminé",2=>"En cours",3 => "Echoué");
	if($id==null):
		return $array;
	else:
		return $array[$id];
	endif;
}

function ctp_ContentFields($ListFields,$postid){
	$ctp_ContentFields="";
	foreach ($ListFields as $key => $value):
		$vafield = get_post_meta($postid, $value["title"], true);
		switch($value["type"]){
			case "select":
			$ctp_ContentFields .= '<div class="BcField">
							<label>'.$value["label"].' :</label><br>
							<select  name="'.$value["title"].'"  class="form-control" >';

			        if($value["post_type"]!="" && $value["post_type"]!=null ) : //Post type values
			    	$args_select = array('post_type'=>$value["post_type"],'order' =>'ASC');
						$query_select = new WP_Query( $args_select  );
						if( $query_select->have_posts() ):
							
							$ctp_ContentFields .='<option value="" '.$selected.' >Choisissez</option>';
							 while ($query_select->have_posts()) : $query_select->the_post();
								if($vafield==get_the_ID()): $selected='selected="selected"'; else: $selected=""; endif;
								$ctp_ContentFields .='<option value="'.get_the_ID().'" '.$selected.' >'.get_the_title(get_the_ID()).'</option>';
							endwhile;

						endif;
						wp_reset_postdata();

					else: //Static array

						foreach ($value["value"] as $value) :
							if($vafield==$value["id"]): $selected='selected="selected"'; else: $selected=""; endif;
							$ctp_ContentFields .= '<option value="'.$value["id"].'" '.$selected.' >'.$value["value"].'</option>';
						endforeach;

					endif;

					$ctp_ContentFields .= '</select></div>';
			break;

			default:
	          $ctp_ContentFields .= '<div class="BcField">
						<label>'.$value["label"].' :</label><br>
						<input type="text" name="'.$value["title"].'" value="' . $vafield. '" class="widefat form-control" />
					</div>';
		}

	endforeach;
	echo $ctp_ContentFields;
}

function ctp_coreSave($ListFields,$post,$postid){

	if ( !current_user_can( 'edit_post', $postid ))

		return $postid;

	foreach ($ListFields as $key => $value) :

		$vehicules_meta[$value["title"]] = $post[$value["title"]];

	endforeach;

	

	foreach ($vehicules_meta as $key => $value) { 

		if( $post->post_type == 'revision' ) return; 

		$value = implode(',', (array)$value); 

		if(get_post_meta($postid, $key, FALSE)) { 

			update_post_meta($postid, $key, $value);

		} else { 

			add_post_meta($postid, $key, $value);

		}

		if(!$value) delete_post_meta($postid, $key);

	}

}


function FormClickToPay_shortcode(){
	global $ParamClickToPay;

	$OptionsSetting=get_option( 'settingctpt_settings' );

	$DATE_TIME =date('dmYHis');
	$SESSION_ID="wc_order_58e3a4db624gg";
	$AMOUNT="";
	$MERCHANT_ID=$OptionsSetting["fay_clicktopay_merchantid"];
	$PAYMENT_REFERENCE="ref_".$DATE_TIME;
	
	$MECHANT_KEY=$OptionsSetting["fay_clicktopay_merchantkey"];
	$CURRENCY=$OptionsSetting["fay_clicktopay_currency"];
	$VERIFICATION_CODE="";

	$CONFIRM_PAGE=get_permalink($OptionsSetting["fay_clicktopay_pageconfirmation"]);
	$CANCEL_PAGE=get_permalink($OptionsSetting["fay_clicktopay_pagecancel"]);

	$ParamClickToPay=array(
		"FormAction"=>GetUrlSandbox(),
		"CONFIRMATION_URL"=>$CONFIRM_PAGE,
		"CANCELLATION_URL"=>$CANCEL_PAGE,
		"PAYMENT_REFERENCE"=>$PAYMENT_REFERENCE,
		"ACTION"=>"PAYMENT",
		"DATE_TIME"=>$DATE_TIME,
		"MERCHANT_ID"=>$MERCHANT_ID,
		"AMOUNT"=>$AMOUNT,
		"CURRENCY"=>$CURRENCY,
		"SESSION_ID"=>$SESSION_ID,
		"VERIFICATION_CODE"=>$VERIFICATION_CODE
	);
?>
<div class="container">
	<div class="row">
			<div class="col-xs-12 col-md-10 col-lg-8">
	<form action="<?php echo $ParamClickToPay["FormAction"];?>" method="post" id="smt_payment_form" accept-charset="UTF-8">

		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-6">
			    <div><label><?php echo __("Last name", 'clicktopay-smt');?> *:<label></div>
				<input type="text" name="name" value="" size="40" required="required">
			</div>
			<div class="col-xs-12 col-md-6 col-lg-6">
			   <div><label><?php echo __("First name", 'clicktopay-smt');?> *:</label></div>
				<input type="text" name="firstname" value="" size="40" required="required" >
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-6">
			    <div><label><?php echo __("E-mail", 'clicktopay-smt');?> :</label></div>
				<input type="email" name="email" value="" size="40" class="">
			</div>
			<div class="col-xs-12 col-md-6 col-lg-6">
			    <div><label><?php echo __("Phone", 'clicktopay-smt');?> :</label></div>
				<input type="tel" name="telephone" value="" size="40" class="" aria-invalid="false">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<label for="field-amount-getway" class="form-label"><?php echo __("Amount", 'clicktopay-smt');?> * :</label>
			</div>
			<div class="col-xs-12 col-md-4 col-lg-3">
				<div class="fs-number  ">
					<input type="number" class="field fs-number-element" name="AMOUNT"  required="required" id="field-amount-getway" value="300.000">
				</div>
			</div>
			<div class="col-xs-12 col-md-8 col-lg-9">
				<ul class="list-radios-amount">
					<li>
						<div class="radio">
							<input type="radio" name="radioamount" id="field-10-getway" value="10">
							<label for="field-10-getway">10 TND</label>
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="radioamount" id="field-50-getway" value="50">
							<label for="field-50-getway">50 TND</label>
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="radioamount" id="field-150-getway" value="150">
							<label for="field-150-getway">150 TND</label>
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="radioamount" id="field-500-getway" value="500">
							<label for="field-500-getway">500 TND</label>
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="radioamount" id="field-1000-getway" value="1000">
							<label for="field-1000-getway">1000 TND</label>
						</div>
					</li>
				</ul>
			</div>
	    </div>

		<input type="hidden" name="CONFIRMATION_URL" value="<?php echo $ParamClickToPay["CONFIRMATION_URL"];?>">
		<input type="hidden" name="CANCELLATION_URL" value="<?php echo $ParamClickToPay["CANCELLATION_URL"];?>">
		<input type="hidden" name="PAYMENT_REFERENCE" value="<?php echo $ParamClickToPay["PAYMENT_REFERENCE"];?>">
		<input type="hidden" name="ACTION" value="<?php echo $ParamClickToPay["ACTION"];?>">
		<input type="hidden" name="DATE_TIME" value="<?php echo $ParamClickToPay["DATE_TIME"];?>">
		<input type="hidden" name="MERCHANT_ID" value="<?php echo $ParamClickToPay["MERCHANT_ID"];?>">
		<input type="hidden" name="CURRENCY" value="<?php echo $ParamClickToPay["CURRENCY"];?>">
		<input type="hidden" name="SESSION_ID" value="<?php echo $ParamClickToPay["SESSION_ID"];?>">
		<input type="hidden" name="VERIFICATION_CODE" value="<?php echo $ParamClickToPay["VERIFICATION_CODE"];?>" >
		<input type="submit" class="button alt" id="submit_smt_payment_form" value="<?php echo _e("Donate now","clicktopay-smt");?>">
	</form>
</div>
</div>
</div>
<?php	
}
add_shortcode("FormClickToPay","FormClickToPay_shortcode");

function Savedonation() {
	parse_str($_POST["data"],$CUSTOMPOST);
	$OptionsSetting      = get_option( 'settingctpt_settings' );
	$response            = array();

	$contentmail         = "";
	$Texto               = "";
	$fay_donation_status = 2;
	
	$name                = $CUSTOMPOST["name"];
	$firstname           = $CUSTOMPOST["firstname"];
	$email               = $CUSTOMPOST["email"];
	$telephone           = $CUSTOMPOST["telephone"];

	//SMT VARIABLES
	$SESSION_ID          = $CUSTOMPOST["SESSION_ID"];
	$AMOUNT              = number_format($CUSTOMPOST["AMOUNT"],3,'.','');
	$MERCHANT_ID         = $CUSTOMPOST["MERCHANT_ID"];
	$PAYMENT_REFERENCE   = $CUSTOMPOST["PAYMENT_REFERENCE"];
	$DATE_TIME           = $CUSTOMPOST["DATE_TIME"];	
	$MECHANT_KEY         = $OptionsSetting["fay_clicktopay_merchantkey"];
	$VERIFICATION_CODE   = md5($SESSION_ID.$AMOUNT.$MERCHANT_ID.$PAYMENT_REFERENCE.$DATE_TIME.$MECHANT_KEY);

	$titlepost="Donation ".$name." ".$firstname. "(".$PAYMENT_REFERENCE.")";

	$CheckOpiration=false;
	if(isset($AMOUNT) && $AMOUNT!="" && $AMOUNT!=null && $AMOUNT!=0):
	    $CheckOpiration=true;
	else:
	    $CheckOpiration=false;
	endif;

	$donation_post = array(
	  'post_title'    => wp_strip_all_tags( $titlepost),
	  'post_status'   => 'publish',
	  'post_type'     => 'donateur'
	);

	$Texto .=$titlepost;

	if($CheckOpiration): // Ok Save it
		if($post_id = wp_insert_post( $donation_post  )):
			$CUSTOMPOST["id_donate"]=$post_id;

			add_post_meta($post_id, 'fay_donation_ref', $PAYMENT_REFERENCE, true);
			add_post_meta($post_id, 'fay_donation_nomdonateur', $name." ".$firstname, true);
			add_post_meta($post_id, 'fay_donation_numdonateur', $telephone, true);
			add_post_meta($post_id, 'fay_donation_emaildonateur', $email, true);
			add_post_meta($post_id, 'fay_donation_montant', $AMOUNT, true);
			add_post_meta($post_id, 'fay_donation_status', $fay_donation_status, true);

			ctp_NotificationOperation( $titlepost,$CUSTOMPOST); //Confirmation par email

			$response["status"]="Success";
			$response["ID"]=$post_id;
			$response["VERIFICATION_CODE"]=$VERIFICATION_CODE;
			$response["AMOUNT"]=$AMOUNT;
		else:

			$response["status"]="Echec";
			$response["ID"]=0;
			$response["VERIFICATION_CODE"]="";
			$response["AMOUNT"]="";
		endif;
	else: //NO (Don't save it)

		$response["status"]="Echec";
		$response["ID"]=-1;
		$response["VERIFICATION_CODE"]="";
		$response["AMOUNT"]="";
	endif;
	
	echo json_encode($response);
	die();
}

add_action('wp_ajax_Savedonation', 'Savedonation' );
add_action('wp_ajax_nopriv_Savedonation', 'Savedonation' );

function ctp_NotificationOperation( $titlepost,$CUSTOMPOST){
	global $current_user;
	$options = get_option( 'settingctpt_settings' );

		$headers[] = 'From:'.$CUSTOMPOST["NomdonateurPrincipal"].' <'.$CUSTOMPOST["EmaildonateurPrincipal"].'>';

		$headersadmin[] = 'From: '.$options["fay_custom_nom"].' <'.$options["fay_custom_email"].'>';


	 $fay_donation_status=2;

	$typeoffreID=$CUSTOMPOST["typeoffre"];
	$typeoffreNAME=GetTypeOffre( $typeoffreID);
	$mode=$CUSTOMPOST["mode"];

	if($mode==2): $fay_donation_status=3;	endif;

	$contentmail="
	<style>
	p,h2,h3,h4 {
		color:#000 !important;
	}

	.InvoiceIcon,
	#InvoiceIcon {
		display: inline-block;
		text-align: center;
		color: #878787;
		font-weight: bold;
		text-transform: uppercase;
		width: 110px;
		line-height: 1.2;
		border: 1px solid #e4e4e4;
		padding: 5px 15px;
	}
	.InvoiceIcon img,
	#InvoiceIcon img {
		width:110px;
		height:auto;
	}
	</style>";
/*
      if(isset($CUSTOMPOST["date"]) && $CUSTOMPOST["date"]!=""):
	      $contentmail.="<p>Date :" .$CUSTOMPOST["date"]."</p>";
	      $Texto .="Date :" .$CUSTOMPOST["date"]." ".$CUSTOMPOST["heure"];
	  endif;*/

	  if(isset($CUSTOMPOST["NomdonateurPrincipal"]) && $CUSTOMPOST["NomdonateurPrincipal"]!=""):
	      $contentmail.="<p>Nom de donateur :" .$CUSTOMPOST["NomdonateurPrincipal"]."</p>";
	  endif;

	  if(isset($CUSTOMPOST["NumdonateurPrincipal"]) && $CUSTOMPOST["NumdonateurPrincipal"]!=""):
	      $contentmail.="<p>Numéro donateur :" .$CUSTOMPOST["NumdonateurPrincipal"]."</p>";
	  endif;

	  if(isset($CUSTOMPOST["EmaildonateurPrincipal"]) && $CUSTOMPOST["EmaildonateurPrincipal"]!=""):
	      $contentmail.="<p>Email donateur :" .$CUSTOMPOST["EmaildonateurPrincipal"]."</p>";
	  endif;

	  if(isset($CUSTOMPOST["AMOUNT"]) && $CUSTOMPOST["AMOUNT"]!=""):
	      $contentmail.="<p>Montant :" .$CUSTOMPOST["AMOUNT"]." TND</p>";
	      $Texto .="Montant :" .$CUSTOMPOST["AMOUNT"]." TND";
	  endif;

	  if(isset($fay_donation_status) && $fay_donation_status!=""):
	      $contentmail.="<p>Statut :" .GetStatus($fay_donation_status)."</p>";
	      $Texto .="Statut :" .GetStatus($fay_donation_status);
	  endif;

		$content_email="<p><h2>Votre donation a été effectuée avec succès.</h2></p>". $contentmail."";
		$content_email_Admin="<p><h2>Vous venez de recevoir une nouvelle donation.</h2></p>". $contentmail."";         

          if($current_user->user_email!=null && $current_user->user_email!=""):
              wp_mail($current_user->user_email ,$titlepost, $content_email,$headersadmin) ;
          endif;

          if($CUSTOMPOST["EmaildonateurPrincipal"]!=$current_user->user_email && $CUSTOMPOST["EmaildonateurPrincipal"]!=null && $CUSTOMPOST["EmaildonateurPrincipal"]!=""):
              wp_mail($CUSTOMPOST["EmaildonateurPrincipal"] ,$titlepost, $content_email,$headersadmin) ;
          endif;

          if($options["fay_custom_email"]!=null && $options["fay_custom_email"]!=""):
              wp_mail($options["fay_custom_email"] ,$titlepost, $content_email_Admin,$headers) ;
              
          endif;

          if($CUSTOMPOST["NumdonateurPrincipal"]!="" && $CUSTOMPOST["NumdonateurPrincipal"]!=null):
          	 $Texto .="Numéro donateur :" .$CUSTOMPOST["NumdonateurPrincipal"];
          endif;
			
			if($options["fay_custom_phone"]!=null && $options["fay_custom_phone"]!=""):
				$Texto .="Téléphone :" .$options["fay_custom_phone"];
			endif;
}

function file_get_contents_curl( $url ) {

  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

  $data = curl_exec( $ch );
  curl_close( $ch );

  return $data;

}
function confirmationDonate_shortcode(){
	ob_start();
	echo "---------------------------------------------------------------------";
	echo ("\n");
	fputs($fp, "\n");
	echo "date : ".date('Y-d-m h:i:s')."\n";
	print_r($_GET);
	$ret = ob_get_contents();
	ob_end_clean();
	
	$fp = fopen(plugins_url( '../log.txt', __FILE__ ),"a");
	fputs($fp, "\n");
	fputs($fp, "$ret");
	fclose($fp);
	$order_id = $_GET['PAYMENT_REFERENCE'];		
	/*echo ('paiement succes : ' . $order_id );*/
	/*var_dump($_GET);*/
	UpdateDonate($_GET);				
}
add_shortcode("maram_confirm","confirmationDonate_shortcode");

function cancelDonate_shortcode(){
	ob_start();
	echo "---------------------------------------------------------------------";
	echo ("\n");
	fputs($fp, "\n");
	echo "date : ".date('Y-d-m h:i:s')."\n";
	print_r($_GET);
	$ret = ob_get_contents();
	ob_end_clean();
	$fp = fopen(plugins_url( '../log.txt', __FILE__ ),"a");
	fputs($fp, "\n");
	fputs($fp, "$ret");
	fclose($fp);
	$order_id = $_GET['PAYMENT_REFERENCE'];
	/*echo ('paiement echec : ' . $order_id );*/
	UpdateDonate($_GET);
}
add_shortcode("maram_cancel","cancelDonate_shortcode");

function UpdateDonate($content){
	$OptionsSetting=get_option( 'settingctpt_settings' );
	$MECHANT_KEY=$OptionsSetting["fay_clicktopay_merchantkey"];

	$ctpt_log = array(
	'post_title'    => wp_strip_all_tags( "Log Return Page "),
	'post_content'  => json_encode($content),
	'post_status'   => 'publish',
	'post_type' => "ctpt_log"

	);
	$ctpt_logid=wp_insert_post( $ctpt_log );

 $checkACK= file_get_content_bypass_https($content["ACKNOLEDGEMENT_URL"]);
	if($checkACK=="VERIFIED")://CHECK VERIFIED URL

		$_GET_VERIFICATION_CODE=$content["VERIFICATION_CODE"];
		$_CHECK_VERIFICATION_CODE=md5($content["SESSION_ID"].$content["MERCHANT_ID"].$content["PAYMENT_REFERENCE"].$content["DATE_TIME"].$MECHANT_KEY.$content["PAYMENT_AUTHORIZATION"]);

		if($_GET_VERIFICATION_CODE==$_CHECK_VERIFICATION_CODE): //CHECK VERIFICATION_CODE
			UpdateStatusOfDonate($content, 1);  // update the status to Completed
		else: //ELSE CHECK VERIFICATION_CODE
			UpdateStatusOfDonate($content, 3);// update the status to Failed
		endif; //END VERIFICATION_CODE

	else: //ELSE CHECK VERIFIED URL
	  UpdateStatusOfDonate($content, 3);// update the status to Failed
	endif; //END CHECK VERIFIED URL
}

function file_get_content_bypass_https($url) {  
	$arrContextOptions = array( "ssl" => array("allow_self_signed" => true,  "verify_peer" => false, ) ); 
	return file_get_contents($url, false, stream_context_create($arrContextOptions));
}


function UpdateStatusOfDonate($data, $status){
	global $donation; // required
	$MessageContent="";
	$MessageContent.="<div class='container BcMessage'>";
	$MessageContent.="<div class='row'>";
	$MessageContent.="<div class='col-lg-6 col-lg-offset-3'>";

	$args = array(
			'post_type'              => 'donateur',
			'post_status'            => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'fay_donation_ref',
					'value'   => $data["PAYMENT_REFERENCE"],
					'compare' => '=',
				),
			),
		);

		$the_query = get_posts( $args ); 
		if(count($the_query)>0):

			foreach($the_query as $donation) : setup_postdata($donation);
		    	if(update_post_meta($donation->ID, 'fay_donation_status', $status)){// update the status to Completed or Failed
			    	$MessageContent.="<h4>"._("Votre donation Réf : ".$donation->ID." a été effectuée avec succès! Merci")."</h4>";
				} else{
					$MessageContent.="<h4>"._("Votre donation Réf : ".$donation->ID."  n'a pas été effectuée correctement!")."</h4>";
				}
			endforeach;

		endif;

	$MessageContent.="</div>";
	$MessageContent.="</div>";
	$MessageContent.="</div>";

	echo $MessageContent;
    wp_reset_query();
}