<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "formalbu_allewis", "teamexp", "formalbu_dev");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$name = mysqli_real_escape_string($link, $_POST['name']);
$amount = mysqli_real_escape_string($link, $_POST['amount']);
 
// attempt insert query execution
$sql = "INSERT INTO splitpayment (name, amount) VALUES ('$name', '$amount')";
if(mysqli_query($link, $sql)){
    echo "<center>Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>
<br /><br />

<a href="http://www.formalbuilder.com/dev/chart"><button>Go Back To My Chart</button></a>