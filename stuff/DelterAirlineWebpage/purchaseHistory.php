<!DOCTYPE html>
<html lang="en">
  <?php 
    session_start();
    $Destination =""; $departingLocation =""; $TicketID=""; $Price=""; $TotalIncome= $_SESSION['TotalIncome'];
    $Name=""; 
    $purchasehistoryURL ='http://35.188.55.177/api/v1.0/purchases';  $purchaseQuery = '';
    

  ?>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Purchase History</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/history.css" rel="stylesheet">

  </head>

  <body>

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

    <!-- Page Content -->
    <div class="container">
      <h1 class="mt-5">Purchase History</h1>
      <form name="search" action="purchasehistory.php" method="POST" class="form-inline">

      <div class="form-group">
      <label for="TicketID">Ticket Id Number:</label>
      <input type="text" class="form-control" value="<?php if($TicketID){ echo $TicketID; } ?>" id="TicketID" name="TicketID">
      </div>

      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" >Submit</button>
      </div>
      </form>
      <?php
      $url_final = $purchasehistoryURL . '?' . $purchaseQuery;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $purchasehistoryURL);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, $url_final);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec ($ch);
        curl_close ($ch);
        $array = (json_decode($return, true));
        print_r($array);
      ?>
      <?php 
        if (isset($_POST['submit'])){
          $TicketID = $_POST['TicketID'];
        }
        foreach ($array as $level1) {
            foreach ($level1['purchases'] as $next) {
              foreach($next['ticket'] as $values){
                  echo $values . ',';
                }
                  
                
              }                
            
        }
      ?>
      <table class="table table-hover" id ="search" >
        <thead>
          <tr>
            <th></th>
            <th>Ticket ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Departure Location</th>
            <th>Arrival Location<th>
          </tr>
        </thead>
          <tbody>
            <?php $counter = 2;
                  $rowID = 1;
            ?>
            

            <?php
            while($counter >=0){
              echo "<tr class ='tablerows' id =$rowID>";
              echo "<td>";
              echo $TicketID;
              echo "</td>";
              echo "<td>";
              echo $TicketID;
              echo "</td>";
              echo "<td>";
              echo $TicketID;
              echo "</td>";
              echo "<td>";
              echo $TicketID;
              echo "</td>";
              echo "</tr>";
              $counter--;
            } 
            ?>
          </tbody>
      </table>  
    </div>
    
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
