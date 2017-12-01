<!DOCTYPE html>
<html lang="en">
  <?php 
    $Destination =""; $departingLocation =""; $Price="";  $Seat = array(); $SeatNumber = ''; $TicketId = '';
    $priceArray = array(); $array=''; $ticket = array(); $available = array(); $tableArrivingLocation =array(); $tablDepartingLocation =array();
    $email=NULL; $fName=NULL; $username=Null; $address= Null;  
    $dob=NULL; $flighturl = 'http://35.193.165.105/api/v1.1/flights';
  
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
      <button id="add" type="submit" name="add"  class="btn btn-default" onclick="return confirm('Ticket Added')" >Add Ticket</button>
      </div>
      </form>
    

    </div> 
    <div class="container">
      <h1 class="mt-5">Remove A Ticket</h1>
      <div class="form-group">
      <label for="fname">Name:</label>
      <input type="text" class="form-control"  id="fName" name="fName">
      
      <button id="delete" type="submit" name="delete"  class="btn btn-default" onclick="return confirm('Ticket Delted!')" >Remove Ticket</button>
      </div>
      </form>
    </div>  
    <div class="container">
      
      <h1 class="mt-5">Select a Flight</h1>

      <?php 
      
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $flighturl);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec ($ch);
        curl_close ($ch);
    
        ?>    
      <table class="table table-hover" id ="search" >
        <thead>
          <tr>
            <th></th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Availiblty </th> 
            <th>Seats</th>
            <th>Price</th>
            <th>Ticket Id </th>
          </tr>
        </thead>
          <tbody>
            <?php 

              $counter = 0;
              $rowID = 1;
              $array = (json_decode($return, true));
              if(is_array($array)){
              foreach ($array as $level1) { 
                  foreach($level1 as $values)   { 
                     foreach($values['tickets'] as $moos){
                          array_push($Seat, $moos['seat_number']);
                          array_push($ticket, $moos['id']);
                          array_push($priceArray,$moos['price']);
                          array_push($available,$moos['available']);
                          array_push($tablDepartingLocation, $values['fromLocation']);
                          array_push($tableArrivingLocation, $values['toLocation']);
                     }
                  }
      
                
              }
            }
                $totalRow = count($Seat);
            ?>
            

            <?php
            while($counter  < $totalRow){
              echo "<tr onClick=location.href='http://cloud1.thinkwebstore.com/~delter/confirmPurchase.php?id=".$ticket[$counter]."&seat=".$Seat[$counter]."&destination=".$Destination."&departingLocation=".$departingLocation."' class ='tablerows' id =$rowID>";
              echo "<td>";
              echo $rowID;
              echo "</td>";
              echo "<td>";
              echo $tablDepartingLocation[$counter];
              echo "</td>";
              echo "<td>";
              echo $tableArrivingLocation[$counter];
              echo "</td>";;
              echo "<td>";
              echo $available[$counter];
              echo "</td>";
              echo "<td>";
              echo $Seat[$counter];
              echo "</td>";
              echo "<td>";
              echo "$". $priceArray[$counter];
              echo "</td>";
              echo "<td>";
              echo $ticket[$counter];
              echo "</td>";
              echo "</tr>";
              $counter++;
              $rowID++;
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