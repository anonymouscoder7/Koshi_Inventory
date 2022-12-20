<?php
include_once "db.php";
include_once "header.php";
include_once "sidebar.php";
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Employee', 'Count'],
          
          <?php 

                  $sql = "SELECT staff_type.staff_type, staff.staff_type_id, COUNT(*) as 'num' FROM staff, staff_type WHERE staff.staff_type_id=staff_type.staff_type_id GROUP BY staff_type.staff_type";
                  $result = $connection->query($sql);
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      $staffType=$row["staff_type"];
                      $staffCount=$row["num"];
                      echo ( "['$staffType', $staffCount], ");
                    }
                  }
          ?>
        ]);

        var options = {
          title: 'Employees According To Positions',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
<style>
#piechart_3d{
		width: 400px; 
		height: 400px;
	        margin-left : 300px;
            }
#barchart_values{
		width: 400px; 
		height: 400px;
	        margin-left : 800px;
		margin-top :-400px;
            }
#calendar_basic{
		width: 1000px; 
		height: auto;
	        margin-left : 300px;
            }


</style>
 <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Type", "Category", { role: "style" } ],
       
        <?php 
            include_once 'db.php';
            $sqlarray = array("SELECT SUM(booking.total_price) as sum FROM booking WHERE booking.payment_status=1", "SELECT SUM(booking.total_price) as sum FROM booking WHERE booking.payment_status=0", "SELECT SUM(staff.salary) as sum FROM staff", "SELECT SUM(complaint.budget) as sum FROM complaint");
                $stackexp = array();
                foreach($sqlarray as $sql){
                  // echo $sql;
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $temp=(float)$row["sum"];
                  array_push($stackexp,$temp);
              
                }
              }
            }
            $grandTotal=array_sum($stackexp);
            $incomeData= ($stackexp[0]/ $grandTotal)*100;
            $pendingData= ($stackexp[1]/ $grandTotal)*100;
            $mainData= ($stackexp[3]/ $grandTotal)*100;
            $salaryData= ($stackexp[2]/ $grandTotal)*100;
        ?>

        ["Maintanence", <?php echo($mainData) ?>, "#b87339"],
        ["Salary", <?php echo($salaryData) ?>, "silver"],
        ["Income", <?php echo($incomeData) ?>, "gold"],
        ["Pending Payment", <?php echo($pendingData) ?>, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Hotel income and till date",
        width: 410,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
  <script type="text/javascript">
      google.charts.load("current", {packages:["calendar"]});
      google.charts.setOnLoadCallback(drawChart);

   function drawChart() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Room Booked' });
       dataTable.addRows([
        <?php 

          $stack = array();
            $sql = "SELECT booking.check_in, COUNT(*) FROM booking GROUP BY booking.check_in";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $newDate=$row["check_in"];
                $newDateCount=$row["COUNT(*)"];
                  $headers = explode(' ', $newDate);
                  $headerstwo = explode('-', $headers[0]);
                  
                echo ("[new Date(".$headerstwo[2].", ".$headerstwo[1].", ".$headerstwo[0]."),".$newDateCount." ],");
                array_push($stack, $headerstwo[2]);
              }
            }
            rsort($stack);
            $data = ((int)$stack[0] - (int)$stack[count($stack)-1])*200;
          
            
        ?>
        ]);

       var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

       var options = {
         title: "Reserved Room on Different Day",
         height: <?php echo ($data);?> ,
         noDataPattern: {
           backgroundColor: '#76a7fa',
           color: '#a0c3ff'
         },
         calendar: {
            cellColor: {
              stroke: '#76a7fa',
              strokeOpacity: 0.5,
              strokeWidth: 1,
            }
          }
       };

       chart.draw(dataTable, options);
   }
</script>
  </head>
  <body>
    <div id="piechart_3d"></div>
    <div id="barchart_values"></div><br><br><br>
    <div id="calendar_basic"></div>
  </body>
</html>
<?php
include_once "footer.php";
?>
