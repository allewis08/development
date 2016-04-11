<?php 
	require_once("../src/FoursquareAPI.class.php");
	$location = array_key_exists("location",$_GET) ? $_GET['location'] : "Pune";
?>
<!doctype html>
<html>
<head>
		<title>Formal Builder: Foursquare API</title>
            
	<style>
	div.venue
	{   
		float: left;
		padding: 10px;
		background: #efefef;
		height: 90px;
		margin: 10px;
		width: 340px;
    }
    div.venue a
    {
    	color:#000;
    	text-decoration: none;

    }
    div.venue .icon
    {
    	background: #000;
		width: 88px;
		height: 88px;
		float: left;
		margin: 0px 10px 0px 0px;
    }
	</style>
</head>
<body>
<center><a href="http://www.formalbuilder.com/dev/"><button>Back to other APIs</button></a>
<h1>FourSquare: Local Venue Request</h1>
<p>
	Search for venues near...
	<form action="" method="GET">
		<input type="text" name="location" />
		<input type="submit" value="Search!" />
	</form></center>
<p>Searching for venues near <?php echo $location; ?></p>
<hr />
<?php 
	// Set your client key and secret
	$client_key = "HBWW1GRPAFWAEDQEUHSL3ALQOSKEQZUFCY5TVNWSJSAX0UDM";
	$client_secret = "DIKYKSWJ1PLF24MDH5WFQAXI3Y5CN3NTF5AOP25K4BGMT5UB";
	// Load the Foursquare API library
	$foursquare = new FoursquareAPI($client_key,$client_secret);
	
	// Generate a latitude/longitude pair using Google Maps API
	list($lat,$lng) = $foursquare->GeoLocate($location);
	
	
	// Prepare parameters
	$params = array("ll"=>"$lat,$lng");
        
	
	// Perform a request to a public resource
	$response = $foursquare->GetPublic("venues/search",$params);
	$venues = json_decode($response);
?>
	
		<?php 
				
		foreach($venues->response->venues as $venue): ?>
			<div class="venue">
				<?php 
					

					if(isset($venue->categories['0']))
					{
						echo '<image class="icon" src="'.$venue->categories['0']->icon->prefix.'88.png"/>';
					}
					else
						echo '<image class="icon" src="https://foursquare.com/img/categories/building/default_88.png"/>';
					
					if(isset($venue->url) && !empty($venue->url))
					{
					echo '<a href="'.$venue->url.'" target="_blank"/><b>';
					echo $venue->name;
					echo "</b></a><br/>";
					}else{
					echo $venue->name."<br>";	
					}
		
                    if(isset($venue->categories['0']))
                    {
						if(property_exists($venue->categories['0'],"name"))
						{
							echo ' <i> '.$venue->categories['0']->name.'</i><br/>';
						}
					}
					
					if(property_exists($venue->location,"address"))
					{
							echo ''.$venue->location->address ." <br/> ";
					}

					
				?>
			
			</div>
			
		<?php endforeach; ?>
	
</body>
</html>
