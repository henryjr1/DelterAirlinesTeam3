<!DOCTYPE html>
<html lang="en">
  <?php
    session_start(); 
    $Destination =NULL; $Children =""; $Adults =""; $departingLocation =NULL; $Name=""; $TotalIncome = $_SESSION['TotalIncome'];
    $ExpectedDeparture=''; $ExpectedArrival=''; $tablDepartingLocation = NULL; $tableArrivingLocation = NULL; 
    $Seat = array(); $SeatNumber = ''; $TicketId = ''; $ticket = array(); $priceArray = array(); 
    $url ="http://35.193.165.105/api/v1.1/Flight-Search";
    $query ="";
    function getImage($location){
      if ($location == "Atlanta%2C%20GA"){
          echo  "<img src='https://maps.googleapis.com/maps/api/staticmap?center=Hartsfield+Jackson+Atlanta+International,Atlanta,GA&zoom=12&size=400x400&key=AIzaSyDhR32QX2WI2aym_eQNTWvb7urWIVjWqxM' alt='Atlanta Airport'>" ;
      }
      if ($location == "Starkville%2C%20MS"){
          echo  "<img src='https://maps.googleapis.com/maps/api/staticmap?center=Golden+Triangle+Airport,Starkville,MS&zoom=12&size=400x400&key=AIzaSyDhR32QX2WI2aym_eQNTWvb7urWIVjWqxM' alt='Atlanta Airport'>" ;
      }
    }
  
    
  ?>
  <script>
  </script>
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
      <label for="depatingLocation">Departure location:</label>
      <select class="form-control" id="departingLocation" name="departingLocation">
        <option  disabled selected value>select an option</option>
        <option value="Atlanta%2C%20GA">Atlanta</option>
        <option value="Starkville%2C%20MS">Starkville</option>
      </select>
      </div>
      <div class="form-group">
      <label for="Destination">Destination:</label>
      <select class="form-control" id="Destination" name="Destination" >
        <option disabled selected value>select an option</option>
        <option value="Starkville%2C%20MS">Starkville</option>
        <option value="Atlanta%2C%20GA">Atlanta</option>
      </select>
      </div>
      <div class="container">
      <div class="row">
        <div class="col-sm-push-1">
            <div class="form-group">
                <label for="departure-date">Expected Departure</label>
                <input type="date" class="form-control" id="departure-date" name="startDate"
                       placeholder="Pick departure date">
            </div>
        </div>

        <div class="col-sm-push-1">
            <div class="form-group">
                <label for="arrival-date">Expected Arrival</label>
                <input type="date" class="form-control" id="arrival-date" name="endDate"
                       placeholder="Pick arrival date">
            </div>
        </div>
   
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
 


      <div>
      <button id="submit" type="submit" name="submit"  class="btn btn-default" >Submit</button>
      </div>
      </div>
      </div>
      </form>
      <?php 
        if (isset($_POST['submit'])){ 
          $Destination = $_POST['Destination'];
          $departingLocation = $_POST['departingLocation'];
          $ExpectedDeparture = $_POST['startDate'];
          $ExpectedArrival = $_POST['endDate'];
        } 
        if ($Destination != NULL){
          if ($query !=NULL){
            $query .= '&';
          }
          $query .= 'toLocation=' . $Destination;  
        }
        if ($Destination != ''){
          if ($query !=''){
            $query .= '&';
          }
          $query .= 'fromLocation=' . $departingLocation;
        }
        if ($Destination != ''){
          if ($query !=''){
            $query .= '&';
          }
          $query .= 'startDate=' . $ExpectedDeparture;
        }
        if ($Destination != ''){
          if ($query !=''){
            $query .= '&';
          }
          $query .= 'endDate=' . $ExpectedArrival;
        }
        
        $url_final = $url . '?' . $query;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, $url_final);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec ($ch);
        curl_close ($ch);
        
            $_SESSION['departingLocation'] = $departingLocation;
            $_SESSION['Destination'] = $Destination;
        ?>    
      <table class="table table-hover" id ="search" >
        <thead>
          <tr>
            <th></th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Availible Seats</th>
            <th>Price<th>
          </tr>
        </thead>
          <tbody>
            <?php 

              $counter = 0;
              $rowID = 1;
              $array = (json_decode($return, true));
              if(!empty($array)){
              foreach ($array as $level1) { 
                  foreach($level1 as $values)   { 
                      $tablDepartingLocation = $values['fromLocation'];
                      $tableArrivingLocation = $values['toLocation'];
                     foreach($values['tickets'] as $moos){
                          if ($moos['available'] == 1){
                          array_push($Seat, $moos['seat_number']);
                          array_push($ticket, $moos['id']);
                          array_push($priceArray,$moos['price']);
                        }
                     }
                  }
              } 
              }      
                
                $totalRow = count($Seat);
            ?>
            

            <?php
            while($counter  < $totalRow){
              echo "<tr onClick=location.href='confirmPurchase.php?id=".$ticket[$counter]."&seat=".$Seat[$counter]."' class ='tablerows' id =$rowID>";
              echo "<td>";
              echo $rowID;
              echo "</td>";
              echo "<td>";
              echo $tablDepartingLocation;
              echo "</td>";
              echo "<td>";
              echo $tableArrivingLocation;
              echo "</td>";;
              echo "<td>";
              echo $Seat[$counter];
              echo "</td>";
              echo "<td>";
              echo "$". $priceArray[$counter];
              echo "</td>";
              echo "</tr>";
              $counter++;
              $rowID++;
            } 
            ?>
          </tbody>
      </table>  
    </div>
    <?php 
    
    getimage($Destination)
  ?>

    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
