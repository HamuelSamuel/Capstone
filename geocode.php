<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <title>Geodud</title>
</head>
<body>
  <div class="container" >
    <h2 id="text-center"> Location: </h2>
  </div>
  <form action="" method="post">
    <input type='text' name='address'/>
    <input type='submit' value='submit' />
</form>
  <input type = "button" onclick = "location.href='localCins.php'" value = "cinima" />
  <?php 
  $address = $_POST['address'];
function geocode($address){
  
    $address = urlencode($address);
      
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyBWrn0_cBtbWJ35omI8UcYPD5cj7QfQyiQ";
  
    $resp_json = file_get_contents($url);
      

    $resp = json_decode($resp_json, true);
  
    if($resp['status']=='OK'){
  
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
          
        if($lati && $longi && $formatted_address){
          
            $data_arr = array();            
              
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
              
            return $data_arr;
              
        }else{
            return false;
        }
          
    }
  
    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}
?>

<?php
if($_POST){
  

    $data_arr = geocode($_POST['address']);
  

    if($data_arr){
          
        $lati = $data_arr[0];
        $long = $data_arr[1];
        $formatted_address = $data_arr[2];
         echo "<strong>Geocode:</strong> " . $lati . ";". $long; 
         echo "<br> ". $formatted_address;
         $geo =   $lati . ";". $long;           
    ?>
  

    
    <?php
  

    }else{
        echo "No map found.";
    }

}
require_once('dbConnect.php');
            
$conn = db_connect();
 

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }
 
 

 
 $sql = "INSERT INTO geocode (geocode, address)";
 $sql .= " VALUES   ( ";  
 $sql .= "'" . $geo . "','". $formatted_address."'); "; 

 $result1 = mysqli_query($conn,$sql);



     mysqli_free_result($result1,$result3);
 


 db_close($conn);  
 

?>


</body>

</html>
