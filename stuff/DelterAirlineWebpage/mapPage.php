<!DOCTYPE html>
<html lang="en">
  <?php 
    session_start();
    $Destination =""; $departingLocation =""; $TicketID=""; $Price=""; $TotalIncome= $_SESSION['TotalIncome'];; 
    $email=NULL; ;$fName=NULL; $lName=Null; $address= Null; $SeatNumber = Null;
    

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
      $TicketID =  $_GET['id'];
      $SeatNumber =  $_GET['seat'];

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
    <!-- Page Content purchases/order-->
    <div class="container">
      <h1 class="mt-5">Confirm Purchase</h1>
      
      <form name="search" action="purchasehistory.php" method="POST" class="form">
      <div class="form-group">
      <label for="fname">First Name:</label>
      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" >Confirm Purchase</button>
      </div>
      </form>
      <?php 
        if (isset($_POST['submit'])){
          $TicketID = $_POST['TicketID'];
        } 
      ?>
    
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>