<!DOCTYPE html>
<html lang="en">
  <?php 
  header("Location: http://cloud1.thinkwebstore.com/~delter/confirmPurchase.php");
    
    $Destination =""; $departingLocation =""; $TicketID=""; $Price=""; 
    $email=NULL; ;$fName=NULL; $lName=Null; $address= Null; $SeatNumber = Null; $url = "http:/35.193.165.105/api/v1.1/purchases/order?";

function httpPost($url,$params){
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
    
    curl_close($ch);
    return $output;
  }

    function getImage($location){
      if ($location == "Atlanta%2C%20GA"){
          echo  "<img src='https://maps.googleapis.com/maps/api/staticmap?center=Hartsfield+Jackson+Atlanta+International,Atlanta,GA&zoom=12&size=400x400&key=AIzaSyDhR32QX2WI2aym_eQNTWvb7urWIVjWqxM' alt='Atlanta Airport'>" ;
      }
      if ($location == "Starkville%2C%20MS"){
          echo  "<img src='https://maps.googleapis.com/maps/api/staticmap?center=Golden+Triangle+Airport,Starkville,MS&zoom=12&size=400x400&key=AIzaSyDhR32QX2WI2aym_eQNTWvb7urWIVjWqxM' alt='Atlanta Airport'>" ;
      }
    } 

  ?>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Locate A Airport</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/history.css" rel="stylesheet">

  </head>

  <body>
     <?php 
        if (isset($_POST['submit'])){
          $username = $_POST['username'];
          $fName = $_POST['fName'];
          $email = $_POST['email'];
          $address = $_POST['address'];
          $dob = $_POST['dob'];
          $ticketID = $_POST['ticket'];
           $post = array('ticketID' => $ticketID);
           $post['username'] = $username;
           $post['name']   = $fName;
           $post['email'] = $email;
           $post['address'] =$address;
           $post['dob'] = $dob;
        }
          ?>
    <?php
      

      ?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Delter Airlines</a>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="http://cloud1.thinkwebstore.com/~delter/index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://cloud1.thinkwebstore.com/~delter/pickaflight.php">Search for Flight</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://cloud1.thinkwebstore.com/~delter/purchaseHistory.php">Purchase History</a>
            </li>
            <li class="nav-item">
              <p class ="nav-link" href="http://cloud1.thinkwebstore.com/~delter/mapPage.php"> Closest Airport </p>
            </li>
          </ul>

        </div>
      </div>
    </nav>
    <!-- Page Content purchases/order-->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Closest Airport</h1>
        </div>
        <div class=" col-offset-4">
           <form name="search" action="http://cloud1.thinkwebstore.com/~delter/mapPage.php" method="POST" class="form-inline well">
              <div class="form-group ">
              <label for="location">Select A Location:</label>
              <select class="form-control" id="location" name="location" style = 'text-align:center'; >
                <option disabled selected value>select an option</option>
                <option value="Starkville%2C%20MS">Starkville</option>
                <option value="Atlanta%2C%20GA">Atlanta</option>
              </select>
              </div>
              <div>
              <button id="submit" type="submit" name="submit"  class="btn btn-default" >Submit</button>
              </div>
          </form>
          <?php 
            if (isset($_POST['submit'])){
              $location = $_POST['location'];
            } 
          ?>
          <?php 
            getimage($location)
          ?>
        </div>
        </div>
      </div>
    </div>
    <div class="container">
      
      
     
      
     
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>