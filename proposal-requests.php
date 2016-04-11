<?php

session_start();

/*

 * Template Name: Proposal Request

 * Description: A Page Template with a darker design.

 */

 

?>



<?php 

require('lib/Zoho.php' );



$sResults =$wpdb->get_results("select paypal_email from twc_settings where id='TWCZ1373834004TWC51e30b14872a7'");

$sResult =$sResults[0];

$paypal_email =$sResult->paypal_email;

//print_r($_POST);





if(isset($_POST['submit_request'])){ 

 $select_hotel_arr = $_POST['select_hotel'];

 $select_price_arr = $_POST['select_price'];

 $select_name_arr =$_POST['select_name'];

 $select_img_arr =$_POST['select_img'];	

 $destination_id = $_POST["dest_id"];

 $zoho_notes ='';

 for($i=0;$i<count($select_hotel_arr);$i++){

  $hotel_id =$select_hotel_arr[$i];

  $hotel_price =$select_price_arr[$i];

  $hotel_name =$select_name_arr[$i];

  $hotel_img =$select_img_arr[$i];

  $Results =$wpdb->get_results("select user_id from twc_trips where id='".$_REQUEST['tripID']."' and published='Yes'");

  $Result =$Results[0];

  $user_id =$Result->user_id;

  

  $ch_Results =$wpdb->get_results("select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and hotel_id='".$hotel_id."'");

  if(count($ch_Results)==0){
//echo "insert into twc_hotel_request SET user_id='".$user_id."', destination_id = '".$destination_id."', trip_id='".$_REQUEST['tripID']."',hotel_id='".$hotel_id."',hotel_name='".$hotel_name."',hotel_price='".$hotel_price."',hotel_image='".$hotel_img."',currency='USD',published='Yes',date_time='".date('Y-m-d H:i:s')."'"; exit;
$hSql =$wpdb->query("insert into twc_hotel_request SET user_id='".$user_id."', destination_id = '".$destination_id."', trip_id='".$_REQUEST['tripID']."',hotel_id='".$hotel_id."',hotel_name='".$hotel_name."',hotel_price='".$hotel_price."',hotel_image='".$hotel_img."',currency='USD',published='Yes',date_time='".date('Y-m-d H:i:s')."'");

    $zoho_notes.='Hotel:'.$hotel_name.' Price:$'.$hotel_price.',';

  }

  else{

    $zoho_notes.='Hotel:'.$hotel_name.' Price:$'.$hotel_price.',';

   }

  }



 $zoho_content =substr($zoho_notes, 0, -1);



//==== Zoho code ====//

	$ZOHO_USER="mike@teamexp.com";
//
//	$ZOHO_USER="info@greeks365.com";

//
//$ZOHO_USER="mike@teamexp.com";

	$ZOHO_PASSWORD="Exactly5";
//
//	$ZOHO_PASSWORD="Teamexp123";

//	$ZOHO_API_KEY='4d886ef9dd91ca123036f58842b27321';

//
//	$ZOHO_API_KEY='c8520524769cc0a569faff7895cf1ed9';
$ZOHO_API_KEY='cdd1023ec2193355fd8972c7114715b5';

	$z = new Zoho($ZOHO_USER, $ZOHO_PASSWORD, $ZOHO_API_KEY);

	 try {

        $z->open();

		try {



			  $results =$wpdb->get_results("select zoho_entryid from twc_trips where id='".$_REQUEST['tripID']."'");

			  $result =$results[0];

			  $entityId =$result->zoho_entryid;

			  $NoteTitle='List of hotels';

			   $NoteContent =$zoho_content;

			   $Notes = array(

						'entityId' => $entityId,

						'Note Title' => $NoteTitle,

						'Note Content' =>str_replace('&','-',$zoho_content)

					);

			  //Hotel:Courtyard by Marriott Miami Downtown Price:$49,Hotel:DoubleTree by Hilton Miami Airport 


			   $response = $z->insertRecordsNotes(array($Notes));

		}

		catch (ZohoException $e) {

            //echo '<span>Error inserting data: ' . $e->getMessage() . '</span>';

			$return_flag=0;

        } 

	 }

	 catch (ZohoException $e) {

        //echo '<span>Can\'t connect to Zoho: ' . $e->getMessage() . '</span>';

		$return_flag=0;

    }

   //==== End Zoho code ====//

}





if(isset($_POST['makepayment'])){

//echo "<pre>";

//print_r($_POST);die;



$flag=0;

if($_REQUEST["payby"]!='facebook')

{

		$Results =$wpdb->get_results("select * from twc_trip_booked where trip_id='".$_POST['trip_id']."' and user_id='".$_POST['user_id']."'");

		$Result =$Results[0];

		$err_msg='';

		/*if(count($Results)>0)

		{

		 $payment_status =$Result->payment_status;

		 if($payment_status=='pending'){

			 $wpdb->query("update twc_trip_booked SET booked_amount='".$_POST['payamount']."',booked_date='".date('Y-m-d H:i:s')."' where trip_id='".$_POST['trip_id']."' and user_id='".$_POST['user_id']."'");

			  $insert_id =$wpdb->insert_id;

			 $flag=1;

		 }

		 else{

		   $err_msg ='You are already paid user';	 

		   $flag=0;

		 }

		}

		else{

		 $Results =$wpdb->get_results("select * from wp_users where ID='".$_POST['user_id']."'");

		 $Result =$Results[0];

		 

		$wpdb->query("insert into twc_trip_booked set trip_id='".$_REQUEST['tripID']."',user_id='".$_POST['user_id']."',user_name='".$Result->display_name."',email='".$Result->user_email."',contact_no='',img_path='',booked_amount='".$_POST['payamount']."',paytype='".$_REQUEST["paytype"]."',user_type='".$_REQUEST["payby"]."',booked_date='".date('Y-m-d H:i:s')."',payment_status='pending', pay_for='".$_REQUEST["pay_for"]."'");

		  

		   $insert_id =$wpdb->insert_id;

		   $flag=1;

		}*/

		

		 $Results =$wpdb->get_results("select * from wp_users where ID='".$_POST['user_id']."'");

		 $Result =$Results[0];

		 

		$wpdb->query("insert into twc_trip_booked set trip_id='".$_REQUEST['tripID']."',user_id='".$_POST['user_id']."',user_name='".$Result->display_name."',email='".$Result->user_email."',contact_no='',img_path='',booked_amount='".$_POST['payamount']."',paytype='".$_REQUEST["paytype"]."',user_type='".$_REQUEST["payby"]."',booked_date='".date('Y-m-d H:i:s')."',payment_status='pending', pay_for='".$_REQUEST["pay_for"]."'");

		  

		   $insert_id =$wpdb->insert_id;

		   $flag=1;

		

}



else

{

   $cResults =$wpdb->get_results("select * from twc_trips where id='".$_REQUEST['tripID']."'");	

   $cResult =$cResults[0];

   if($cResult->trip_status=='Yes')

   {

   $hp_results =$wpdb->get_results("select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and confirm_hotel='Yes'");

   $hp_result =$hp_results[0];

   $hotel_price =$hp_result->hotel_price;

   $pay_amount =($hotel_price*2);

   

    $FB_Name = $_SESSION["FB_DETAILS"]['F_NAME'];

	$FB_Email = $_SESSION["FB_DETAILS"]['FB_EMAIL'];

	$fb_img = $_SESSION["FB_DETAILS"]['FB_IMG'];

   $wpdb->query("insert into twc_trip_booked set trip_id='".$_REQUEST['tripID']."',user_id='',user_name='".$FB_Name ."',email='".$FB_Email."',contact_no='',img_path='".$fb_img."',booked_amount='".$_POST['payamount']."',paytype='".$_REQUEST["paytype"]."',user_type='".$_REQUEST["payby"]."',booked_date='".date('Y-m-d H:i:s')."',payment_status='pending', pay_for='".$_REQUEST["pay_for"]."'");

   $insert_id =$wpdb->insert_id;

   $flag=1;

   }

}

	 

 if($flag==1){

	

	 if($_POST['modeType']=='Test'){

		 echo '<script>window.location.href="'.site_url().'/thanks/?action=paymentNotification&tripid='.$_REQUEST['tripID'].'&hotelid='.$_REQUEST['hotelid'].'&payid='.$insert_id.'"</script>';

	 }

	 else{

		 $Results8 =$wpdb->get_results("select * from twc_trips where id='".$_POST['trip_id']."'");

 		$Result8 =$Results8[0];  

		$tripname8 =$Result8->trip_name;

	 ?>

	  <?php if($_REQUEST["pay_for"]=='paypal'){  ?>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="pforms" id="pform">

        <input type="hidden" name="cmd" value="_xclick">

        <input type="hidden" name="business" value="<?php echo $paypal_email;?>">

        <input type="hidden" name="item_name" value="<?php echo $tripname8;?>">

        <input type="hidden" name="currency_code" value="USD">

        <input type="hidden" name="amount" id="amount" value="<?php echo $_POST['payamount'];?>">

        <input type="hidden" name="tax" id="tax" value="0.00">

        <input type="hidden" name="return" value="<?php echo site_url(); ?>/thanks/?action=paymentNotification&tripid=<?php echo $_REQUEST['tripID'];?>&hotelid=<?php echo $_REQUEST['hotelid'];?>&&payid=<?php echo $insert_id;?>">
        
        <?php /*?>  <input type="hidden" name="cancel_return" id="cancel_return" value="<?php echo site_url(); ?>/thanks/?action=paymentNotification&tripid=<?php echo $_REQUEST['tripID'];?>&hotelid=<?php echo $_REQUEST['hotelid'];?>&&payid=<?php echo $insert_id;?>"><?php */?>

        <input type="hidden" name="submits" value="Submit"/>

        </form>

        <script language="javascript">

        document.pforms.submit();

        </script>

 		<?php } else {

			

			

		

			// This sample code requires the mhash library for PHP versions older than

			// 5.1.2 - http://hmhash.sourceforge.net/

			

			// the parameters for the payment can be configured here

			// the API Login ID and Transaction Key must be replaced with valid values

			$loginID		= "6REy57mSh";

			$transactionKey 	= "2JHeA696x3y8TYXk";

			$amount 		= $_POST['payamount'];

			$description 		= $tripname8;

			$label 			= "Submit Payment"; // The is the label on the 'submit' button

			$testMode		= "false";

			// By default, this sample code is designed to post to our test server for

			// developer accounts: https://test.authorize.net/gateway/transact.dll

			// for real accounts (even in test mode), please make sure that you are

			// posting to: https://secure.authorize.net/gateway/transact.dll

			$url = "https://secure.authorize.net/gateway/transact.dll";

			

			// If an amount or description were posted to this page, the defaults are overidden

			if (array_key_exists("amount",$_REQUEST))

			{ $amount = $_REQUEST["amount"]; }

			if (array_key_exists("description",$_REQUEST))

			{ $description = $_REQUEST["description"]; }

			

			// an invoice is generated using the date and time

			$invoice	= date('YmdHis');

			// a sequence number is randomly generated

			$sequence	= rand(1, 1000);

			// a timestamp is generated

			$timeStamp	= time();

			

			// The following lines generate the SIM fingerprint.  PHP versions 5.1.2 and

			// newer have the necessary hmac function built in.  For older versions, it

			// will try to use the mhash library.

			if( phpversion() >= '5.1.2' )

			{ $fingerprint = hash_hmac("md5", $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey); }

			else 

			{ $fingerprint = bin2hex(mhash(MHASH_MD5, $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey)); }

			?>

			

			<!-- Print the Amount and Description to the screen. -->

			<?php /*?>Amount: <?php echo $amount; ?> <br />

			Description: <?php echo $description; ?> <br /><?php */?>

			

			<!-- Create the HTML form containing necessary SIM post values -->

			<form method='post' name="aforms" action='<?php echo $url; ?>' >

			<!--  Additional fields can be added here as outlined in the SIM integration

			guide at: http://developer.authorize.net -->

			<input type='hidden' name='x_login' value='<?php echo $loginID; ?>' />

			<input type='hidden' name='x_amount' value='<?php echo $amount; ?>' />

			<input type='hidden' name='x_description' value='<?php echo $description; ?>' />

			<input type='hidden' name='x_invoice_num' value='<?php echo $invoice; ?>' />

			<input type='hidden' name='x_fp_sequence' value='<?php echo $sequence; ?>' />

			<input type='hidden' name='x_fp_timestamp' value='<?php echo $timeStamp; ?>' />

			<input type='hidden' name='x_fp_hash' value='<?php echo $fingerprint; ?>' />

			<input type='hidden' name='x_test_request' value='<?php echo $testMode; ?>' />

			<input type='hidden' name='x_show_form' value='PAYMENT_FORM' />

            <input type="hidden" name="x_receipt_link_method" value="LINK" >

            <input type='hidden' name='x_receipt_link_url' value='<?php echo site_url(); ?>/thanks/?action=paymentNotification&tripid=<?php echo $_REQUEST['tripID'];?>&hotelid=<?php echo $_REQUEST['hotelid'];?>&&payid=<?php echo $insert_id;?>' />

            <!--<input type="hidden" name="x_relay_response" value="TRUE" >

    <input type="hidden" name="x_relay_url" value="<?php echo site_url(); ?>/thanks/?action=paymentNotification&tripid=<?php echo $_REQUEST['tripID'];?>&hotelid=<?php echo $_REQUEST['hotelid'];?>&&payid=<?php echo $insert_id;?>" >-->

			<input type='hidden' value='<?php echo $label; ?>' />

			</form>

			<script language="javascript">

       		 document.aforms.submit();

        	</script>

			

	<?php	}?>

 

 

<?php

	 }

  }

}





 $trip_Results  =$wpdb->get_results("select * from twc_trips where id='".$_REQUEST['tripID']."'");

 $trip_Result =$trip_Results[0];

 //print_r($trip_Result);

 

 include(TEMPLATEPATH."/includes/header_inner.php"); 

?>

<link href="<?php echo get_template_directory_uri(); ?>/css/main.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main_style.css" type="text/css">

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/calender.css" />

<script language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/calender-custom.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/core.js"></script>

<style>


#overlay {

background-color: #000000;

display: none;

height: 100%;

left: 0;

opacity: 0.7;

position: fixed;

top: 0;

width: 100%;

z-index: 100;

}

.main_pay_div {

padding:20px;	

}

.pay_content

{

color:#FFF; 

font-size:16px;

}

.pay_option{ margin-top:15px;}

.pay_option span{ color:#FFF; }

.pay_option input[type="radio"]{ padding-top:5px;}



.ui-menu-item a{ padding: 9px 20px !important; font-size:16px;}

.pop_search_p {text-align:center;}

.pop_search_p a{color:#FFF;}

.pop_search_p a:hover{ text-decoration:underline; } 

.flt_none {float:none; margin:0; margin-top:20px;}

</style>

<div id="overlay"></div>

<div class="popup popup-requiest">

<div class="popup_container">

<h1 class="pop_search_h1">Search for Hotels</h1>

<div class="close close-favorites"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" onclick="closePopup();" /></div>

<form name="Another_destination" id="Another_destination" method="post" enctype="multipart/form-data" action="<?php echo site_url();?>/looking-for-hotels/" onsubmit="return Check_Destination();">

<input name="Cri_locations" id="Cri_locations" type="text" placeholder="City, address or landmark of stay" value=""  class="search-bx change-search-bx">

<input type="submit" name="src_desti" value="GO" class="go-btn" />

<input type="hidden" id="what_to_search_id" name="what_to_search_id" value="" />

<input type="hidden" id="what_to_search" name="what_to_search" value="<?php echo $_SESSION["what_to_search"]; ?>" />

<input type="hidden" name="tripID" value="<?php echo $_REQUEST['tripID'];?>" />

 <input class="field_home field_s allrounded6" name="Cri_DateFrom" id="Cri_DateFrom" type="hidden" value="<?php echo $_SESSION['Cri_DateFrom'] ; ?>" />

 <input class="field_home field_s allrounded6" name="Cri_DateTo" id="Cri_DateTo" type="hidden" value="<?php echo $_SESSION['Cri_DateTo'] ; ?>" /> 

 <input type="hidden" name="Cri_noofRooms" id="Cri_noofRooms" value="<?php echo $_SESSION['Cri_noofRooms'] ;?>" />

 <input type="hidden" name="Cri_Amenity" id="Cri_Amenity" value="<?php echo $_SESSION['Cri_Amenity'];?>" />

 <input type="hidden"  name="adults-r1" id="adults-r1" value="<?php echo $_SESSION['Cri_Adults'];?>"  >

 <input type="hidden" name="isfromsearchpage" value="1" />
</form>

</div>

</div>



<div class="choose_payment_option">

<h1 class="pop_search_h1">Please choose a option for payment.</h1>

<img src="<?php echo get_template_directory_uri(); ?>/images/cc.png" class="img_cc" />

<div class="close close-favorites"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" onclick="closePaymentPopup();" /></div>

<div class="main_pay_div">

<div class="pay_option">

<form name="makepayment_frm" id="makepayment_frm" method="post" onsubmit="return Validate_Payment_Option();">

<table border="0" cellspacing="0" cellpadding="0" align="center" class="py_tbl">

  <tr>

    <td align="center"><input type="radio" name="pay_for" class="cls_pay" value="paypal" /></td>

    <td align="center"><input type="radio" checked="checked" class="cls_pay" name="pay_for" value="authorize" /></td>

  </tr>

  <tr>

    <td align="center" style="color:#FFF; font-size:13px;">Paypal</td>

    <td align="center" style="color:#FFF; font-size:13px;">Credit Card</td>

  </tr>

  <tr>

    <td align="center" style="color:#FFF; font-size:13px;">&nbsp;</td>

    <td align="center" style="color:#FFF; font-size:13px;">&nbsp;</td>

  </tr>

</table>



<p class="pop_search_p"><input type="checkbox" id="terms_condition" value="Yes" /> <a href="<?php echo site_url();?>/?page_id=131" target="_blank">

Accept terms and conditions - Formal deposit goes towards cost of formal

</a></p>

<p class="pop_search_p"><input type="submit" name="makepayment" class="add_btn flt_none" value="Checkout" style="border:0px;" /></p>

  <input type="hidden" name="user_id" id="puserid" value="" />

  <input type="hidden" name="trip_id" id="ptripid" value="" />

  <input type="hidden" name="paytype" id="paytype" value="" />

  <input type="hidden" name="payamount" id="payamount" value="" />

  <input type="hidden" name="modeType" id="modeType" value="" />

  <input type="hidden" name="hotelid" id="hotelid" value="" />

  <input type="hidden" name="payby" id="payby" value="" />

  <br/><br/>

</form>

</div> 

</div>

</div>



<div class="container grid_999 mtm-30">

<div class="info-bar">

  <ul>

    <li><?php echo $trip_Result->location;?></li>

    <li><?php echo date("M d",strtotime($trip_Result->checkin));?> - <?php echo date("M d",strtotime($trip_Result->checkout));?></li>

    <li><?php echo $trip_Result->people;?><br />

      PEOPLE</li>

    <li><?php echo $trip_Result->noofRooms;?><br />

      ROOMS</li>

  </ul>

</div>

<form name="makegroupfrm" id="makegroupfrm"  method="post" action="">

<!--  <div class="event-profile-form" id="step_1">



  </div>-->

      <?php

   $user_id =$trip_Result->user_id;

   $user_details =get_user_by('id', $user_id);

   $user_email =$user_details->user_email;

   

   $first_name = get_usermeta($user_id,'first_name');

   $last_name = get_usermeta($user_id,'last_name');

   $phone_no = get_usermeta($user_id,'phone_no');

   $university = get_usermeta($user_id,'university');

   $organization_name = get_usermeta($user_id,'organization_name');

   $state = get_usermeta($user_id,'state');

   ?>

  <div class="payment_container">

    <?php if($err_msg!='') {

       echo '<div class="error">'.$err_msg.'</div>';

	  }

	?>

    <div class="other_details_h1 hdng_profile"><?php echo $trip_Result->trip_name;?></div>

   

     <div class="clr"></div>

    <div class="payment_box payment_box_first">

					<script>
						$(function(){
							
							$('#phone_number_add').click(function(){

								$('#phone_number_add').hide();
								$('.phone_number_box').show();
							});
							$('#phon_add').click(function(){
								$.ajax({
									url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
									type: "post",
									data: { action : 'addNumber' , number : $('#phonenumber_changed').val()},
									success: function(msg) { 
									  $('#phonenumber_changed').fadeOut();
									  $('#detailsparagraph').html($('#phonenumber_changed').val());
									  $('#phon_add').hide();
									}
								
								});	
							});
							$('#removenumber').click(function(){
								$.ajax({
									url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
									type: "post",
									data: { action : 'removenumber' , number : $(this).parent().find('#phonenumber_changed').val()},
									success: function(msg) { 
									  $(this).parent().find('#phonenumber_changed').fadeOut();
									  $(this).parent().parent().html($(this).parent().parent().html+$(this).parent().find('text').val());
									  $(this).hide();
									}
								
								});	
							});
						});
                        </script>
      <p class="payment-det"><span class="fulwidth-span"><?php echo $first_name.' '.$last_name;?> <?php if(($first_name!='' || $last_name!='') && $state!='') echo ','; ?> <?php echo $state;?></span>

        <span><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/email.jpg" alt="" align="left" /></span>
		<label><?php echo $user_email;?></label><br />

        <span><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/call2.png" alt="" align="left" /></span>
        <label id="detailsparagraph">

			<?php
				
				if($phone_no)
				{
					 echo $phone_no;
					 //echo '<a href="#" id="removenumber">Remove Number</a>';
				}
				else
				{
					?>
                    	
                    	<a href="#" id="phone_number_add">Add Phone Number</a>
                    	<div class="phone_number_box" style="display:none;">
                    	<input type="text"  id="phonenumber_changed" class="add_phonetext" value=""/>
                        <input id="phon_add" type="button" class="add_btn add_phone" value="Add"/>
                        </div>
                    <?php
				}
			?>
            </label>
        </p>

    </div>

    <div class="payment_box">

      <p>Total attendees in Trip</p>

     <div class="payment_box_price"><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/mens.png" alt="" align="left" /><?php echo $trip_Result->people;?></div>

      <div class="clr"></div>

    </div>

    <?php 

$tResults =$wpdb->get_results("select * from twc_trips where id='".$_REQUEST['tripID']."' and trip_status='Yes'");

//print_r($tResults);

$tResult =$tResults[0];

$trip_status =$tResult->trip_status;

$trip_name =$tResult->trip_name;

if($trip_status=='Yes'){ 

	
       // echo "select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and confirm_hotel='Yes'";
   		$hotel_A_results =$wpdb->get_results("select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and confirm_hotel='Yes'");	

 		foreach($hotel_A_results as $hotel_A_results){

		$hotel_A_price =  $hotel_A_results ->hotel_price;

		$hotel_A_id =  $hotel_A_results ->id;

   		$pay_amount =($hotel_A_price*2);		

		

	 }

 ?>

    <div class="payment_box">

      <p>This Trip has been confirmed.</p>
	
      <?php 

	  if($User_login_id==$user_id){?>

	 <p style="margin-right:-60px"><a href="javascript:void(0);" class="add_button2  add_btn" onClick="paymentOptions('Totalpay','Live','<?php echo $hotel_A_id;?>','<?php echo $User_login_id;?>','<?php echo ($hotel_A_results->hotel_price * $tResult->people );?>','<?php echo $_REQUEST['tripID'];?>','site');">Make Full Payment</a></p>

	 <?php }?>

     

      <?php if( ($User_login_id!=$user_id) && ($fbID=='') )

		{

			if($User_login_id!=''){

		?>

			<p><a href="javascript:void(0);" class="add_button2" onClick="paymentOptions('partial','Live','<?php echo $hotel_A_id;?>','<?php echo $User_login_id;?>','<?php echo $pay_amount;?>','<?php echo $_REQUEST['tripID'];?>','site');">Make Payment</a></p>

	  <?php }else{

			echo '<p><a href="'.$loginUrl_payment.'" class="add_button2">Login to facebook</a></p>';

			}

		}

		elseif($fbID!=''){

			?>

			<p><a href="javascript:void(0);" class="add_button2" id="2" onClick="paymentOptions('partial','Live','<?php echo $hotel_A_id;?>','<?php echo $User_login_id;?>','<?php echo $pay_amount;?>','<?php echo $_REQUEST['tripID'];?>','facebook');">Make your deposit</a></p>

		<?php }else{

			//echo '<p><a href="'.$loginUrl_payment.'" class="add_button2">Login and Make Payment</a></p>';

		}

		

	 ?>

    </div>

    <?php

}

else{  

	if($User_login_id==$user_id){?>

    <div class="payment_box payment_box_last">

     <p class="social_text">Share with Chapter & Vote</p>

      <ul class="social_icons_new">

        <!--<li><span class='st_sharethis_large' displayText='ShareThis'></span></li>-->

        <li><span class='st_email_large' displayText='Email'></span></li>

        <li><span class='st_facebook_large' displayText='Facebook'></span></li>

        <li><span class='st_twitter_large' displayText='Tweet'></span></li>

        <li><span class='st_linkedin_large' displayText='LinkedIn'></span></li>

        <script type="text/javascript">var switchTo5x=true;</script>

        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

        <script type="text/javascript">stLight.options({publisher: "8ecff575-ad5b-400f-b822-3a009872425b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

      </ul>

       <p><a href="javascript:void(0);" class="add_button2 add_new_btn" onclick="showPopup();">Add New Destination</a></p>

    </div>

    <?php } else{?>

    <div class="payment_box">

      <?php if( ($FB_email!='') || ($User_login_id!='')){

		  //echo $User_login_id.'----'.$user_id;

		  ?>

      <p><a href="javascript:void(0);" class="add_button2 fblogin" onclick="makeVote_user();">Vote now for trip</a></p>

      <?php } else{?>

      <p><a href="<?php echo $loginUrl; ?>" class="add_button2 fblogin">Login with Facebook to Vote</a></p>

      <?php }?>

    </div>

    <?php }

}

?>

<style type="text/css">

.box3, .box6, .box9, .box12, .box15, .box18, .box21{ margin-right: 0px; border-right: 0px; width:26%; padding-right: 0px;}

.box1, .box4, .box7, .box10, .box13, .box16, .box19{ margin-left: 10px; }

.Loading_Input {  background: url(<?php echo get_template_directory_uri(); ?>/images/loading.gif) 479px 10px #FFF no-repeat !important; padding-left:10px; }

</style>

  </div>

  <div class="clr"></div>

  <div class="three_hotels" style="width:100%;clear: both;color:#000 !important;">

    <!--three_hotels_one-->
	
    <?php 
//echo 'abc'.$trip_status.'1';
if($trip_status=='Yes'){

 $hotel_results =$wpdb->get_results("select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and confirm_hotel='Yes'");	
 //echo "select * from twc_hotel_request where trip_id='".$_REQUEST['tripID']."' and confirm_hotel='Yes'";

 foreach($hotel_results as $hotel_result){
 
 ?>

    <div style="background-color: #f9f9f9;

    border: 1px solid #eaeaea;

    padding: 15px;

    width: 249px;">

      <div class="f_list">

        <div class="f_list_left">

          <div class="list_title"><a href="javascript:void(0)"><?php echo $hotel_result->hotel_name;?></a></div>

          <div class="f_list_right">

            <div style="background:url(http://images.travelnow.com/<?php echo $hotel_result->hotel_image;?>)" class="list_img"></div>

          </div>

        </div>

      </div>

      <div class="s_list" style="border:none">
		<?php if($_SESSION['TRIP_ID']!='')
		{?>
        <div class="list_price">

          <ul>

            <li><span class="list_price_new">$<?php echo $hotel_result->hotel_price;?></span></li>

            <li>Per person cost</li>

          </ul>

        </div>
        <?php
		} ?>

        <div class="votediv">

          <div style="padding:8px 0px 8px 0px;">Total Votes: <?php echo $hotel_result->user_vote;?> </div>

        </div>

      </div>

    </div>

    <?php
	
	 }

}else{

	$Cl_End = 0;
	
	$tripID=$_SESSION['TRIP_ID'];
	if($_REQUEST['tripID'])
	$tripID=$_REQUEST['tripID'];
	
 $hotel_results =$wpdb->get_results("select * from twc_hotel_request where trip_id='".$tripID."'");	
		
		$ch_trip_results =$wpdb->get_results("select * from twc_trips where id='".$tripID."'");
		$ch_trip_result =$ch_trip_results[0];
		$ch_dj =$ch_trip_result->dj;
		$ch_photographer =$ch_trip_result->photographer;
		$ch_food=$ch_trip_result->food;
		$food_charge = 0;
		if($ch_food=='Pasta Buffet') { $food_charge = 35;}
		if($ch_food=='3 Course Chicken Dinner') { $food_charge = 45;}
		if($ch_food=='3 Course Steak Dinner') { $food_charge = 55;}
		if($ch_food=='Gourmet Appetizers') { $food_charge = 25;}
 $counter_se = 0;
 if($_SESSION['TRIP_ID']!='') $trip_Results_se = $wpdb->get_results("select * from twc_trips where id='".$_SESSION['TRIP_ID']."'");
 $trip_Result_se =$trip_Results_se[0];
 foreach($hotel_results as $hotel_result){

	 $Cl_End++;
	 
     $ts=$wpdb->get_results("select * from search_results where EANHotelID='".$hotel_result->hotel_id."'");	
	$ts=$ts[0];
	
		$hotelRating=$ts->StarRating;
		$lowRate=$ts->LowRate;
		
		
		
		
		$results =$wpdb->get_results("select * from twc_settings where id='TWCZ1373834004TWC51e30b14872a7'");
		$result =$results[0];
		$pstar_arr =array('10'=>'one',
						  '15'=>'two',
						  '20'=>'two',
						  '25'=>'three',
						  '30'=>'three',
						  '35'=>'four',
						  '40'=>'four',
						  '45'=>'five',
						  '50'=>'five');
		$findStar =$pstar_arr[$hotelRating];
		$formula_field =$findStar.'_star_mark';
		$add_starprice_field =$findStar.'_starprice';
		 $star_mark =$result->$formula_field;
		$add_starprice =$result->$add_starprice_field;
		/// add star price
		
		$per_head_dj_rate=0;
		$per_head_photographer_rate =0;
		$dj_rate=0;
		$photographer_rate=0;
		if($ch_dj=='True'){
		 $dj_rate =$result->dj_rate;
		if($_SESSION['Cri_Adults']!=0) $per_head_dj_rate =($dj_rate/$_SESSION['Cri_Adults']);
		else $per_head_dj_rate =0;
		}
		if($ch_photographer =='True'){
		$photographer_rate =$result->photographer_rate;
		if($_SESSION['Cri_Adults']!=0) $per_head_photographer_rate =($photographer_rate/$_SESSION['Cri_Adults']);
		else $per_head_photographer_rate = 0; 
		}
		
	    $nights =(strtotime($_SESSION["Cri_DateTo"])-strtotime($_SESSION["Cri_DateFrom"]))/(60*60*24);
		$per_head_hotel_rate = ($lowRate*$star_mark*$nights)/4;
		$calculate_price =($per_head_hotel_rate+$per_head_dj_rate+$per_head_photographer_rate)+($add_starprice);
	   
		 $ant=$ch_trip_result->amenity_type;
	  
	   
		
		if($ant=="Hotel_Rooms_Only")
		{
		  $calculate_price =  round((($lowRate*$nights*1.25)/4+25));
			
		}else if($ant=='Banquet_Only')
		{
			$calculate_price = round(($add_starprice+$per_head_dj_rate+$per_head_photographer_rate+$food_charge+27));
			
		}else
		{
			$calculate_price = round((number_format($per_head_hotel_rate,2)+$add_starprice+$per_head_dj_rate+$per_head_photographer_rate+$food_charge+27));	
		  	
		}
		
		$calculate_price = round($calculate_price);
		
		$results =$wpdb->get_results("update twc_hotel_request set hotel_price='".$calculate_price."' where trip_id='".$_SESSION['TRIP_ID']."' and hotel_id='".$hotel_result->hotel_id."'");
		$cols_se = 3;
		if($counter_se%$cols_se == 0 && $counter_se!=0) echo '<hr/>';
		if($counter_se%$cols_se == 0) echo '<h2>'.$trip_Result_se->location.'</h2>';
		//echo '123';
	 ?>


	
    <div class="three_hotels_one box<?php echo $Cl_End; ?>">
	  
      
      <div class="f_list">

        <div class="f_list_left">

          <div class="list_title"><a href="javascript:void(0)"><?php echo $hotel_result->hotel_name;?></a></div>

          <div class="f_list_right">

            <div style="background:url(http://images.travelnow.com/<?php echo $hotel_result->hotel_image;?>)" class="list_img"></div>

          </div>

        </div>

      </div>

      <div class="s_list" style="border:none">
		<?php if($_SESSION['TRIP_ID']!='')
		{?>
        <div class="list_price">

          <ul>

            <li><span class="list_price_new">$<?php echo $calculate_price;//$hotel_result->hotel_price;?></span></li>

            <li>Per person cost</li>

          </ul>

        </div>
        <?php
		}
		?>

        <div class="votediv">

          <div style="padding:8px 0px 8px 0px;">Votes: <?php echo $hotel_result->user_vote;?> </div>

          <?php if($FB_email!='') {$vote_email =$FB_email;}

       elseif($User_email!='') {$vote_email =$User_email;}

	   else{$vote_email='';}	

	   

	  if($vote_email!=''){

	  ?>

          <div>
			<!--<div class="squaredFour">-->
            <input type="checkbox" value="<?php echo $hotel_result->id;?>" name="hotelvote" checked="checked" id="checkbox19" class="hotelvotecls css-checkbox" onclick="makeVote(this.value);"/>
            <label for="checkbox19" name="checkbox19_lbl" class="css-label dark-check-green">Vote Now</label>
			<!--<label for="squaredFour"></label>
            </div>-->

	          </div>

          <?php if( ($User_login_id==$user_id) ){?>

          <a href="javascript:void(0);" class="add_btn" onClick="paymentOptions('token1500','Live','<?php echo $hotel_result->id;?>','<?php echo $User_login_id;?>','1500','<?php echo $_REQUEST['tripID'];?>','site');">Request Availability</a>

          <?php } ?>

          <?php } else{?>

          <div><a href="javascript:void(0)" onclick="alert('Err  : You must be logged in to vote.');">Vote Now</a></div>

          <?php }?>

        </div>

        <div style="clear:both"></div>

      </div>

    </div>

    <?php $counter_se++; }

}

 

 ?>

  </div>

  <!---->

  <div class="other_details_outer">

    <div class="other_details_content">

      <div class="other_details_h1">Pricing Includes</div>

      <ul>

        <li class="active">Food Details: 
        <select name="food" id="food" onchange="updateAtLast(this,'food')">
            <option value="Gourmet Appetizers" <?php if($trip_Result->food=='Gourmet Appetizers') echo 'selected'; ?> >Gourmet Appetizers</option>
            <option value="Pasta Buffet" <?php if($trip_Result->food=='Pasta Buffet') echo 'selected';?>>Pasta Buffet</option>
            <option value="3 Course Chicken Dinner" <?php if($trip_Result->food=='3 Course Chicken Dinner') echo 'selected';?>>3 Course Chicken Dinner</option>
            <option value="3 Course Steak Dinner" <?php if($trip_Result->food=='3 Course Steak Dinner') echo 'selected';?>>3 Course Steak Dinner</option>
	   	</select>
   
        </li>

        <li class="active">Per Table: 
    <select name="per_table" id="per_table" onchange="updateAtLast(this,'per_table')">
    <option value="8" <?php if($trip_Result->per_table==8) echo 'selected';?>>8</option>
    <option value="10" <?php if($trip_Result->per_table==10) echo 'selected';?> >10</option>
    <option value="0" <?php if($trip_Result->per_table==0) echo 'selected';?> >N/A</option>
  </select> People</li>
   

        <li class="active">Date of event: : <?php echo date('d M, Y',strtotime($trip_Result->checkin));  if($trip_Result->amenity_type!='Banquet_Only') {echo ' To '.date('d M, Y',strtotime($trip_Result->checkout));}?></li>
        <li style="cursor:pointer;" class=" <?php if($trip_Result->dj=='True') echo "active"; else echo 'deactive';?>" name="inc_dj" value="1"> Include DJ</li>
        <li style="cursor:pointer;" class=" <?php if($trip_Result->photographer=='True') echo "active";else echo 'deactive';?>" name="inc_ph" value="1"> Include Photographer</li>
        <li style="cursor:pointer;" class=" <?php if($trip_Result->charter_bus=='True') echo "active";else echo 'deactive';?>" name="inc_cb" value="1"> We need a Charter Bus (not included in price)</li>
        
        

      </ul>

    </div>

    <div class="dj_buttons">

      <div class="dj_box2 dj_box_margin">

        <div class="dj_img"><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/dj.png" alt=""></div>

        <div class="clr"></div>

        <label class="dj">Include DJ</label>

        <div class="line_divider"></div>

        <div class="ticks">

          <?php if($trip_Result->dj=='True'){?>

          <a href="javascript:void(0)" data-event="on" data-field="dj" data-val="false" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" title="CLICK REMOVE DJ" data-title="DJ" data-ref="inc_dj" ><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" alt="" /></a>

          <?php } else{?>

     	 <a href="javascript:void(0)" data-event="on" data-field="dj" data-val="true" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" title="CLICK TO ADD DJ" data-title="DJ" data-ref="inc_dj">     <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" alt="" /></a>

          <?php }?>

        </div>

      </div>

      <div class="dj_box2 dj_box_margin">

        <div class="dj_img"> <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/Photographer.png" alt="" style="margin-top:15px;"></div>

        <div class="clr"></div>

        <label class="dj">Photographer</label>

        <div class="line_divider"></div>

        <div class="ticks">

          <?php if($trip_Result->photographer=='True'){?>

      <a href="javascript:void(0)" data-event="on" data-field="photographer" data-val="false" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" title="CLICK TO REMOVE PHOTOGRAPHER" data-title="PHOTOGRAPHER"  data-ref="inc_ph">    <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" alt="" /></a>

          <?php } else{?>

<a href="javascript:void(0)" data-event="on" data-field="photographer" data-val="true" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" title="CLICK TO ADD PHOTOGRAPHER" data-title="PHOTOGRAPHER" data-ref="inc_ph"> <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" alt="" /></a>

          <?php }?>

        </div>

      </div>

      <div class="dj_box2">

        <div class="dj_img"><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/charter_bus.png" alt="" style="margin-top:30px;"></div>

        <div class="clr"></div>

        <label class="dj">Charter bus</label>

        <div class="line_divider"></div>



        <div class="ticks">

          <?php if($trip_Result->charter_bus=='True'){?>
<a href="javascript:void(0)" data-event="on" data-field="charter_bus" data-val="false" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" title="CLICK TO REMOVE CHARTER BUS" data-title="CHARTER BUS" >
          <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" alt="" /></a>

          <?php } else{?>
<a href="javascript:void(0)" data-event="on" data-field="charter_bus" data-val="true" data-resp="<?php echo site_url();?>/wp-content/themes/thewebconz/images/right_tick_large.jpg" title="CLICK TO ADD CHARTER BUS" data-title="CHARTER BUS">
          <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/crose_tick_large.jpg" alt="" />
          </a>

          <?php }?>

        </div>

      </div>

    </div>
  
	<div style="clear:both"></div>
	<?php 
		$Resultr =$wpdb->get_results("select * from twc_trips where id='".$_REQUEST['tripID']."'");	
		//print_r($Resultr);
		//echo $Resultr[0]->checkin;
		if($Resultr[0]->comment_sent!=1)
		{
	?>
	<div class="comment_box mt-30">
        	 <div class="other_details_h1">Send comment to formal builder about your event</div>
				<textarea id="comment_text" class="comment_input" onchange="saveComment(this)"><?php echo $Resultr[0]->comment;?></textarea>
                <a href="javascript:void(0);" class="add_btn" onclick="sendComment(this)">Send Comment</a>
			<label id="sendComment"></label>
    		<?php /*?><a href="javascript:void(0);" class="add_btn" onclick="sendComment(this)">Send Comment</a><?php */?>
    </div>
    <?php
		}
		
	?>

  </div>
    
  <div style="clear:both"></div>

 

 <div class="download_user_outer"> 

  <div class="other_details_h1 other_details_margin">List of paid users <span style="float:right; font-size:13px; padding:5px; margin-top: -29px;"><a href="<?php echo site_url();?>/wp-content/themes/thewebconz/download_paid_user.php?tripID=<?php echo $_REQUEST['tripID'];?>" class="add_button2 add_new_btn">Download All Users</a></span></div>

  </div>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="user_table">

  <tr>

    <td width="6%" class="font_bold">&nbsp;</td>

    <td width="82%" class="font_bold">User</td>

    <td width="12%" class="font_bold2">Amount</td>

   </tr>

   <?php

  $Results =$wpdb->get_results("select * from twc_trip_booked where trip_id='".$_REQUEST['tripID']."' and payment_status='success' order by booked_date DESC");

  $paid_users='';

  if(count($Results) >0){

	$i=1;

	$total_payamount =0;

	foreach($Results as $Result){

		if($Result->img_path!=''){

		 $img_path =$Result->img_path;	

		}else{

		  $img_path =site_url().'/wp-content/themes/thewebconz/images/user_blank.jpg';	

		}

		$total_payamount =$total_payamount+	$Result->booked_amount;	

		?>

        <tr>

        <td><img src="<?php echo $img_path;?>" width="50"></td>

        <td><?php echo $Result->user_name;?></td>

        <td class="font_bold3">$<?php echo $Result->booked_amount;?></td>

        </tr>

	<?php

     $i++;

	}	

  }

  ?>

 

  <tr>

    <td>&nbsp;</td>

    <td align="right"><span class="font_bold3 font_bold">Total Amount:</span></td>

    <td class="font_bold3 font_bold">$<?php echo $total_payamount;?></td>

  </tr>

  </table>



  <?php if($total_payamount==0){ ?>

  <style type="text/css">.download_user_outer, .user_table { display:none; }</style>

  <?php } ?>

  </div>

</form>



</div>

<?php include(TEMPLATEPATH."/includes/footer.php");?>

<script language="javascript">



function makeVote(id){

  if($('#paytype').val()=='')  // check for payment

  {

	$.ajax({ 

	      type: 'Post',

		  data: 'action=makeVote&email=<?php echo $vote_email;?>&tripId=<?php echo $_REQUEST['tripID']?>&id='+id,

		  url: '<?php echo get_template_directory_uri(); ?>/custom_ajax.php',

		  success:function(msg){

			 if(msg==0){

				 alert('You have already voted on a formal package.');

			 }

			 else{

				  window.location.reload();

			 }

		  }

	 })

  }

}



/*$('#makePartialPayment').click(function(){

       



	   

 });*/    



function makeVote_user(){

 if(!$('.hotelvotecls').is(':checked')){

	  alert('Please select hotel');

	  return false;

  }

}





function showPopup()

{

$('.popup').fadeIn();	

$('#overlay').fadeIn();	

}

function closePopup(){

 $('.popup').fadeOut();	

 $('#overlay').fadeOut();	

}

function Check_Destination()

{

	if($('#Cri_locations').val()=='')

	{

		alert('Please select a destination first');	

		$('#Cri_locations').focus();

		return false;

	}



	return true;

}



function paymentOptions(paytype,test,hotelid,userid,price,tripid,payby)

{

	

	  $('#paytype').val(paytype);

	  $('#modeType').val(test);	

	  $('#hotelid').val(hotelid);

	  $('#payamount').val(price);	  

	  $('#puserid').val(userid);	

	  $('#ptripid').val(tripid);

	  $('#payby').val(payby);

  

	$('.choose_payment_option').fadeIn();	

	$('#overlay').fadeIn();

}

function closePaymentPopup(){

 	$('.choose_payment_option').fadeOut();	

	$('#overlay').fadeOut();



}



function Validate_Payment_Option()

{

	 if(!$('.cls_pay').is(':checked')){

	  alert('Please choose a payment option');

	  return false;

  	}

 	 if (!$("#terms_condition").is(":checked")) {

        alert("Please checked terms and condition.");

        return false;

    }

}

function saveComment(dis)
{
		  $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'sendComment' , text : $(dis).val(), type:'save'},
			success: function(msg) { 
			
			  //$(dis).fadeOut();
			  //$(dis).parent().find('.other_details_h1').html("You comment hasbeen sent");
			  //$(dis).parent().find('.other_details_h1').css("color","yellowgreen");
			  //$(dis).hide();
			  //localStorage["comment_data"] = '';
			  //localStorage["comment_sent"] = 'sent';
			}
		
		});	


}

function sendComment(dis)
{
		  $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'sendComment' , text : $(dis).parent().find('textarea').val()},
			success: function(msg) { 
			
			  //$(dis).parent().find('textarea').fadeOut();
			  $('#sendComment').html("You comment hasbeen sent");
			  //$(dis).parent().find('.other_details_h1').css("color","yellowgreen");
			  //$(dis).hide();
			  //localStorage["comment_data"] = '';
			  localStorage["comment_sent"] = 'sent';
			}
		
		});	


}
$(function(){
	if(localStorage['comment_sent'] == 'sent')
	{
		$('#sendComment').html("You comment hasbeen sent");
	}

	$('[data-event="on"]').click(function(){
		  dis=$(this);
		  
		  $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'UpdateAtLast' , field : $(this).attr("data-field") , value : $(this).attr("data-val") },
			success: function(msg) { 
			
				if(msg=='1')
				{
					window.location.href=window.location;
					img=dis.attr('data-resp');
					data=dis.attr('data-val');
				     
					 dis.attr('data-resp',$(dis).find('img').attr('src'));
					 
					 $(dis).find('img').attr('src',img);
					 if(data=='false')
					 {
					 	dis.attr('data-val','true');
						dis.attr('title',' CLICK TO ADD '+dis.attr('data-title'));
					 }
					 else
					 {
					 	dis.attr('data-val','false');
						dis.attr('title',' CLICK TO REMOVE '+dis.attr('data-title'));
					 }
					
					
				}
			
			
			}
		});
	
	});
	
	$('[name="inc_dj"]').click(function(){
	
		//localStorage["comment_data"] = $('#comment_text').val();
		
	var val="false";
		if($(this).hasClass("active"))
		{
			val="false";
			$(this).removeClass('active').addClass('deactive');
		}
		else
		{
			val ="true";
			$(this).addClass('active').removeClass('deactive');
		}
		
		 $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'UpdateAtLast' , field : "dj"  , value : val },
			success: function(msg) {
				
				if(msg=='1')
				{
					window.location.href=window.location;
			    }					
				 
			}
			});
	
	
	});
	$('[name="inc_ph"]').click(function(){
		//localStorage["comment_data"] = $('#comment_text').val();
		var val="false";
		if($(this).hasClass("active"))
		{
			val="false";
			$(this).removeClass('active').addClass('deactive');
		}
		else
		{
			val ="true";
			$(this).addClass('active').removeClass('deactive');
		}		
		 $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'UpdateAtLast' , field : "photographer"  , value : val },
			success: function(msg) {
				
				if(msg=='1')
				{
					window.location.href=window.location;
			    }					
				 
			}
			});
	
	
	});
	$('[name="inc_cb"]').click(function(){
		//localStorage["comment_data"] = $('#comment_text').val();
		var val="false";
		if($(this).hasClass("active"))
		{
			val="false";
			$(this).removeClass('active').addClass('deactive');
		}
		else
		{
			val ="true";
			$(this).addClass('active').removeClass('deactive');
		}
		
		 $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'UpdateAtLast' , field : "charter_bus"  , value : val },
			success: function(msg) {
				
				if(msg=='1')
				{
					window.location.href=window.location;
			    }					
				 
			}
			});

		
	});
	

});

function updateAtLast(dis,field){

	 $.ajax({
			url: "<?php echo get_template_directory_uri(); ?>/custom_ajax.php",
			type: "post",
			data: { action : 'UpdateAtLast' , field : field , value : $(dis).val() },
			success: function(msg) { 
			
				window.location.href=window.location;			
			}
		});

}
/*$(function(){
	 $('#comment_text').val(localStorage["comment_data"]); 
	 
	 if(localStorage['comment_sent'] == 'sent')
	 {
	 	$('.comment_box').hide();
	 }
	 $('[name="makepayment"]').click(function(){
	 		localStorage['comment_sent'] = '';
			localStorage['comment_data'] = '';
	 });
});*/


</script>