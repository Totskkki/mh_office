document.addEventListener('DOMContentLoaded', () => {
    $.ajax({
        url: 'ajax/vitalsigns.php', // URL of your PHP script
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Initialize arrays for chart data
            let labels = [];
            let pulseData = [];
            let tempData = [];

            // Process the data and extract necessary values
            data.forEach(item => {
                const formattedDateTime = formatDate(item.date_shift) + ' ' + convertTo12HourFormat(item.time);
                labels.push(formattedDateTime); // Use formatted date and time as labels
                pulseData.push(item.cr); // Use 'cr' for pulse data
                tempData.push(item.temp); // Use 'temp' for temperature data
            });

            // Define chart options
            var options = {
                chart: {
                    height: 300,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: "smooth",
                    width: 2,
                    colors: ["#FF0000", "#0000CC"],
                },
                series: [
                    {
                        name: "Pulse",
                        data: pulseData // Use dynamic pulse data
                    },
                    {
                        name: "Temperature",
                        data: tempData // Use dynamic temperature data
                    }
                ],
                grid: {
                    borderColor: "#ccd2da",
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        },
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 10,
                        left: 0,
                    },
                },
                xaxis: {
                    categories: labels, // Use dynamic labels
                    tickAmount: 10,
                    labels: {
                        rotate: -45,
                        trim: true
                    },
                },
                yaxis: {
                    labels: {
                        show: true,
                    },
                },
                colors: ["red", "blue"],
                markers: {
                    size: 0,
                    opacity: 0.3,
                    colors: ["#0a50d8", "#57637B"],
                    strokeColor: "#ffffff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    },
                },
            };

            // Create and render the chart
            var chart = new ApexCharts(document.querySelector("#lineGraph"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });

    // Function to format date as "Month Year" (e.g., "August 2024")
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { month: 'long', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Function to convert 24-hour time to 12-hour format with AM/PM
    function convertTo12HourFormat(time24) {
        let [hours, minutes] = time24.split(':');
        hours = parseInt(hours, 10);
        minutes = parseInt(minutes, 10);

        // Determine AM or PM suffix
        const suffix = hours >= 12 ? 'PM' : 'AM';

        // Convert hours from 24-hour to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // Handle midnight (0 hours)

        // Format hours and minutes as two digits
        const formattedHours = hours.toString().padStart(2, '0');
        const formattedMinutes = minutes.toString().padStart(2, '0');

        // Return formatted time
        return `${formattedHours}:${formattedMinutes} ${suffix}`;
    }
});
