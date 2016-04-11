<?php

/**

 Template Name: Hotel Info

 * The template for displaying all pages.

 *

 * This is the template that displays all pages by default.

 * Please note that this is the WordPress construct of pages

 * and that other 'pages' on your WordPress site will use a

 * different template.

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */

 

 	$City_Names = $_SESSION['City_Names'];

	$date_from = $_SESSION['date_from'];

	$date_to = $_SESSION['date_to'];

		

 	$Get_Path = "SELECT option_value as siteurl FROM wp_options where option_name='siteurl'";			

	$Results = $wpdb->get_results($Get_Path);

	foreach ( $Results as $Result ){

	 $siteurl = $Result->siteurl;

	}

	$URL = "http://www.travelfaironline.com/includes/functions.php";

	//$vars = "action=Just_Get_Hotel_Info&hotel_id=".get_query_var("hotel_id");

	//$Hotel_Info = file_get_contents($URL."?".$vars);

	

	

	$vars = "action=GET_Hotel_Reservation&hotel_id=".get_query_var("hotel_id");

	$GET_Hotel_Info_Only = file_get_contents($URL."?".$vars);

	

	$vars = "action=Suggestions&hotel_id=".get_query_var("hotel_id");

	$Suggestions = file_get_contents($URL."?".$vars);

	

	$vars = "action=Hotel_Info_With_Price&hotel_id=".get_query_var("hotel_id")."&arrivalDate=".$date_from."&departureDate=".$date_to."&adults=1";

	$Hotel_Info = file_get_contents($URL."?".$vars);

	

	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html" />

<title></title>

<link href="<?php echo get_template_directory_uri(); ?>/css/main.css" rel="stylesheet" type="text/css" />

<link href="<?php echo get_template_directory_uri(); ?>/css/home-page.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />

<link type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/autocomplete.css" rel="stylesheet" media="all" />

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.6.2.min.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.mousewheel.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.jscrollpane.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/function.js" language="javascript" type="text/javascript"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/global-without-autoload.js" language="javascript" type="text/javascript"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/hotel-info.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/infobox.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/rating.js"></script>

</head>

<body>

<div id="site-body-container">

<div id="site-body-content">

  <!-- -->

  <div id="wrapper">

    <!-- -->

    <script language="javascript" type="text/javascript">

	var Site_URL = "<?php echo $siteurl; ?>";

</script>


    <?php include("includes/header.php"); ?>

    <!-- advanced-search start-->

    <input type="hidden" id="URLs" name="URLs" value="<?php echo get_template_directory_uri(); ?>/includes/functions.php" />

    <div id="fb_advansrch">

      <div id="advanced-search2" style="min-height: 125px;">

        <div class="search-adv2">

          <h1>Book Online (Make Reservation) : </h1>

        </div>

        <form method="post" id="HotelSearchForm" name="HotelSearchForm" action="<?php echo $siteurl; ?>/looking-for-availibility/">

          <div id="modify-search2" class="search-area2">

            

            <div class="search-fld2"  style="height:auto;">

              

        <div class="clr"></div> <div class="travel_call_us">

        <div class="call_us_box"><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/call_us_img.jpg" alt="" width="78" height="77" align="left" />

        <div class="call_us_text">

        <div class="call_us_text2">Need Help Booking</div>

            <div class="call_us_text3">Call 0124 487 3888</div>

                <div class="call_us_text4">See hours and details</div>

                    <div class="call_us_text5"><a href="#">Visit Customer Support >></a></div>

        </div>

        </div>

        <div class="steps_box"><img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/steps_img.png" alt="" width="78" height="77" align="left" />

        <div class="steps_text1">

        Start earning comissions in just 3 easy steps<br />

        1. Install plugin

        <br />

        2. Enter your customer id/secret key

        <br />

        3. Start earning comisions </div>

        

        </div>

        

        <div class="help_box">

        <img src="<?php echo site_url();?>/wp-content/themes/thewebconz/images/help_img.png" alt="" align="left" />

        

         <div class="help_text1">Need help ?<br />

           Need a customized solution ?<br />

           Email me at <a href="#">support@thewebconz.com</a></div>

        

        </div>

        <div class="clr"></div> 

        

        </div> 

        

        </div>

          </div>

        </form>

      <!--tab map result -->

      

          <script language="javascript">//$(document).ready(function(){Update_Results()});</script>

      <!-- -->

      <!-- -->

      <!-- footer start -->

      </div>

      <div class="clr">

        <div id="search_Results" style="width: 987px;margin: 0px auto;">

          <div class="data">

            <div id="search_Results" style="width: 987px;margin: 0px auto;">

              <div class="data">

                <div class="srch-result" id="serch_res_366072">

                 <?php echo $GET_Hotel_Info_Only; ?> <div style="clear:both"></div>

<div style="height:20px;"></div><?php echo $Hotel_Info; ?></div></div>

                      <?php echo $Suggestions; ?>

                  </div>

                </div>

                <div style="clear:both"></div>

                <div class="need-help"> <b>Need Help </b> Speak to our Tour Expert  :<span> +91 - 999985 4201 </span>or you may email our Tour Experts at <a href="mailto:infor@travelfairindia.com">infor@travelfairindia.com</a></div>

              </div>

            </div>

          </div>

          </div>

      <?php include("includes/footer.php"); ?>

      <!-- footer end -->

    </div>

  </div>

  

</div>

<!-- footer end -->

<div class="fixed-position loadings" id="loading"></div>

<div class="fixed-position background" id="background"></div>

<div class="fixed-position fixed-n-w">

  <div style="display:none">

    <input type="fhidden" id="location_name_search" name="location_name_search" value="<?php echo $location; ?>" />

    <input type="fhidden" id="checkin_name_search" name="checkin_name_search" value="26/02/2013" />

    <input type="fhidden" id="checkout_name_search" name="checkout_name_search" value="28/02/2013" />

    <input type="fhidden" id="rooms_name_search" name="rooms_name_search" value="2" />

    <input type="fhidden" id="CenterLatitude" name="CenterLatitude" value="28.61793800" />

    <input type="fhidden" id="CenterLongitude" name="CenterLongitude" value="77.19899000" />

    <input type="fhidden" id="hotel_name_search" name="hotel_name_search" value="" />

    <input type="fhidden" id="hotel_rating_search" name="hotel_rating_search" value="" />

    <input type="fhidden" id="price_min_search" name="price_min_search" value="<?php echo $Get_Global_Minimum_Maximum_Hotel_Price[0]; ?>" />

    <input type="fhidden" id="price_max_search" name="price_max_search" value="<?php echo $Get_Global_Minimum_Maximum_Hotel_Price[1]; ?>" />

    <input type="fhidden" id="location_near_by" name="location_near_by" value="" />

    <input type="fhidden" id="amenities_search" name="amenities_search" value="" />

    <input type="fhidden" id="sort_order_type_search" name="sort_order_type_search" value="recommended_order" />

    <input type="fhidden" id="sort_order_type_asc_desc" name="sort_order_type_asc_desc" value="asc" />

    <input type="fhidden" id="result_type_search" name="result_type_search" value="Display_Results" />

  </div>

</div>

</body>

</html>