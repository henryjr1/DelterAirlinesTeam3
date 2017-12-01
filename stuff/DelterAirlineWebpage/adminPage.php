<!DOCTYPE html>
<html lang="en">
  <?php 
    $Destination =""; $departingLocation =""; $Price=""; $TotalIncome= $_SESSION['TotalIncome']; $fields_string= '';
    $email=NULL; $fName=NULL; $username=Null; $address= Null;  $_SESSION["seat"]; 
    $dob=NULL;

  
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
      if(isset($_GET['id'])){
        $ticket = $_GET['id'];
       
      }
      if ( $_SESSION["seat"] == NULL){ 
       $_SESSION["seat"] =  $_GET['seat'];
      }
    $ticket = $_GET['id'];
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
               <a class ="nav-link" href="http://cloud1.thinkwebstore.com/~delter/mapPage.php"> Closest Airport</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
  
    <!-- Page Content purchases/order-->
    <div class="container">
      <h1 class="mt-5">Add A Ticket</h1>
      <div class="form-group">
      <label for="fname">Name:</label>
      <input type="text" class="form-control"  id="fName" name="fName">
      <label for="email">Email:</label>
      <input type="text" class="form-control"  id="email" name="email">
      <label for="address">Address:</label>
      <input type="text" class="form-control" id="address" name="address">
      <label for="dob">Date of Birth</label>
      <input type="date" class="form-control" id="dob" name="dob"
        placeholder="Pick DOB date">      
      <input type="hidden" class="form-control"  id="ticket" name="ticket" value = '<?php echo htmlspecialchars($_GET['id'])?>'>
      </div>
  
         <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
 
      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" onclick="return confirm('Purchase Confirmed!')" >Confirm Purchase</button>
      </div>
      </form>
   
     
    
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>