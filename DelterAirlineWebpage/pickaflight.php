<!DOCTYPE html>
<html lang="en">
  <?php 
    $Destination =""; $Children =""; $Adults =""; $departingLocation =""; $Name=""; $TotalIncome =545; 
    

  ?>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Select a Flight</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/logo-nav.css" rel="stylesheet">

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
      
      <h1 class="mt-5">Select a Flight</h1>

      <form name="search" action="pickaflight.php" method="POST" class="form-inline">
      
      <div class="form-group">
      <label for="Name">Name:</label>
      <input type="text" class="form-control -sm" value="<?php if($Name){ echo $Name; } ?>" id="Name" name="Name">
      </div>

      <div class="form-group">
      <label for="depatingLocation">Departure location:</label>
      <select class="form-control" id="departingLocation" name="departingLocation">
        <option value="Atlanta">Atlanta</option>
        <option value="Starkville">Starkville</option>
      </select>
      </div>
      <div class="form-group">
      <label for="Destination">Destination:</label>
      <select class="form-control" id="Destination" name="Destination" >
        <option value="Starkville">Starkville</option>
        <option value="Atlanta">Atlanta</option>
      </select>
      </div>


      <div class="form-group">
      <label for="Adults">Adults:</label>
      <select class="form-control" id="Adults" name="Adults">  
        <option value = 0>0</option>
        <option value = 1>1</option>
        <option value = 2>2</option>
        <option value = 3>3</option>
        <option value = 4>4</option>
        <option value = 5>5</option> 
        <option value = 6>6</option>
        <option value = 7>7</option>
        <option value = 8>8</option>      
      </select>
      </div>

     <div class="form-group">
      <label for="Children">Children:</label>
      <select class="form-control" id="Children" name="Children">  
        <option value = 0>0</option>
        <option value = 1>1</option>
        <option value = 2>2</option>
        <option value = 3>3</option>
        <option value = 4>4</option>
        <option value = 5>5</option> 
        <option value = 6>6</option>
        <option value = 7>7</option>
        <option value = 8>8</option>       
      </select>
      </div>
      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" >Submit</button>
      </div>
      </form>
      <?php 
        if (isset($_POST['submit'])){
          $Destination = $_POST['Destination'];
          $departingLocation = $_POST['departingLocation'];
          $departingLocation = $_POST['departingLocation'];
          $Adults = $_POST['Adults'];
          $Children = $_POST['Children'];
        } 
      ?>
      <table class="table table-hover" id ="search" >
        <thead>
          <tr>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Departure Time</th>
            <th>Availible Tickets</th>
            <th>Price<th>
          </tr>
        </thead>
          <tbody>
            <?php $counter = 2;
                  $rowID = 1;
            ?>
            

            <?php
            while($counter >=0){
              echo "<tr onClick=location.href='confirmPurchase.php' class ='tablerows' id =$rowID>";
              echo "<td>";
              echo $departingLocation;
              echo "</td>";
              echo "<td>";
              echo $Destination;
              echo "</td>";
              echo "<td>";
              echo $Adults;
              echo "</td>";
              echo "<td>";
              echo $Children;
              echo "</td>";
              echo "<td>";
              echo $Name;
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
