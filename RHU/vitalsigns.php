
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Signs Graph</title>
    <!-- Include Chart.js -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <script src="../plugins/chart.js/Chart.min.js"></script>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap for card layout (optional) -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Vital Signs Chart</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="vitalSignsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


function convertTo12HourFormat(dateTime) {
  
    let [date, time24] = dateTime.split(' ');
    let [hours, minutes] = time24.split(':');
    hours = parseInt(hours, 10);
    minutes = parseInt(minutes, 10);

  
    const suffix = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; 

    
    const formattedHours = hours.toString().padStart(2, '0');
    const formattedMinutes = minutes.toString().padStart(2, '0');

   
    return `${date} ${formattedHours}:${formattedMinutes} ${suffix}`;
}
document.addEventListener('DOMContentLoaded', () => {
    $.ajax({
        url: 'ajax/vitalsigns.php', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
           
            let labels = [];
            let pulseData = [];
            let tempData = [];

          
            data.forEach(item => {
                const formattedDateTime = convertTo12HourFormat(item.date_shift + ' ' + item.time);
                labels.push(formattedDateTime);
                pulseData.push(item.cr); 
                tempData.push(item.temp);
            });

            // Initialize the chart
            const ctx = document.getElementById('vitalSignsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels, // Use dynamic labels
                    datasets: [
                        {
                            label: 'Pulse',
                            borderColor: 'red',
                            fill: false,
                            data: pulseData 
                        },
                        {
                            label: 'Temp',
                            borderColor: 'blue',
                            fill: false,
                            data: tempData
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
});

</script>

</body>
</html>
