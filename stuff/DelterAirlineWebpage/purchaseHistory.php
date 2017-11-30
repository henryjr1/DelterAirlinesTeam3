<!DOCTYPE html>
<html lang="en">
  <?php 
    session_start();
    $Destination =""; $departingLocation =""; $TicketID=""; $Price="";
    $Name=""; 
    $purchasehistoryURL ='http://35.193.165.105/api/v1.1/purchases';  $purchaseQuery = '';
    

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

  <script  type="text/javascript">
    function httpGet(theUrl) 
    {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
        xmlHttp.send( null );
        var myData = eval("(" + xmlHttp.responseText + ")");
        var purchases = myData.purchase_history.purchases; 
        var html = '<tr><th>Ticket ID</th>' +
                   '<th>Flight ID</th>' +
                   '<th>Availability</th>' +
                   '<th>Price</th>' +
                   '<th>Seat Number</th></tr>';
        
        for (var i = 0; i < purchases.length; i++)
        {
            html += '<tr><td>' + purchases[i].ticket.id 
                 + '</td><td>' + purchases[i].ticket.flight_id 
                 + '</td><td>' + purchases[i].ticket.available 
                 + '</td><td>$' + purchases[i].ticket.price 
                 + '</td><td>' + purchases[i].ticket.seat_number 
                 + '</td></tr>';
        }


        document.getElementById('table').innerHTML += '<table border="1">' + html + '</table>';
    }       
</script>

  <body onload="httpGet('http://35.193.165.105/api/v1.1/purchases')">

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
              <p class="nav-link" href="http://cloud1.thinkwebstore.com/~delter/purchaseHistory.php">Purchase History</p>
            </li>
            <li class="nav-item">
               <a class ="nav-link" href="http://cloud1.thinkwebstore.com/~delter/mapPage.php"> Closest Airport</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div align="center" id='table'></div>    
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
