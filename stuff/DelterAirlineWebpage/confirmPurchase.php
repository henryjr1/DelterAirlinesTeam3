<!DOCTYPE html>
<html lang="en">
  <?php 
    session_start();
    $Destination =""; $departingLocation =""; $_SESSION["TicketID"]; $Price=""; $TotalIncome= $_SESSION['TotalIncome']; $fields_string= '';
    $email=NULL; $fName=NULL; $username=Null; $address= Null;  $_SESSION["seat"]; $url = "http:/35.193.165.105/api/v1.1/purchases/order?";
    $dob=NULL;

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

  ?>
 

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Confirm Purchase</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/history.css" rel="stylesheet">

  </head>

  <body>
    <?php
      $departingLocation = $_SESSION['departingLocation'];
      $Destination = $_SESSION['Destination'];
      if ( $_SESSION["TicketID"] == NULL){ 
       $_SESSION["TicketID"] =  $_GET['id'];
      }
      if ( $_SESSION["seat"] == NULL){ 
       $_SESSION["seat"] =  $_GET['seat'];
      }

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
              <a class="nav-link" href="mainpage.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pickaflight.php">Search for Flight</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="purchasehistory.php">Purchase History</a>
            </li>
            <li class="nav-item">
              <p class ="nav-link"> Total income <?php echo "$" . $TotalIncome?> </p>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Info about Your Flight </h1>
          <ul class="list-unstyled">
            <li style = 'font-size: 25px'>Flight Destination: <?php echo  urldecode ( $Destination);?></li>
            <li style = 'font-size: 25px'>Flight Departure Location: <?php echo  urldecode ( $departingLocation);?></li>
            <li style = 'font-size: 25px'>Seat Number: <?php echo   $_SESSION["seat"];?></li>
            <li style = 'font-size: 25px'>TicketID: <?php echo $_SESSION["TicketID"];?></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page Content purchases/order-->
    <div class="container">
      <h1 class="mt-5">Confirm Purchase</h1>
      
      <form name="search" action="confirmpurchase.php" method="POST" class="form">
      <div class="form-group">
      <label for="fname">Name:</label>
      <input type="text" class="form-control"  id="fName" name="fName">
      <label for="username">username:</label>
      <input type="text" class="form-control"  id="username" name="username">
      <label for="email">Email:</label>
      <input type="text" class="form-control"  id="email" name="email">
      <label for="address">Address:</label>
      <input type="text" class="form-control" id="address" name="address">
      <label for="dob">Expected DOB</label>
      <input type="date" class="form-control" id="dob" name="dob"
        placeholder="Pick DOB date">       
      </div>
         <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
 
      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" >Confirm Purchase</button>
      </div>
      </form>
      <?php 
        if (isset($_POST['submit'])){
          $username = $_POST['username'];
          $fName = $_POST['fName'];
          $email = $_POST['email'];
          $address = $_POST['address'];
          $dob = $_POST['dob'];
           $post =array(
          'ticketID' => $_SESSION["TicketID"],
          'username' => $username,
          'name'   => $fName,
          'email' => $email,
          'address' =>$address,
          'dob' => $dob 
          );
         }
          httpPost($url, $post);
          ?>
    
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>