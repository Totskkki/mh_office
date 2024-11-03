<?php
include './config/connection.php';



?>



<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        canvas {
            width: 300px;
            /* Change the width to your desired value */
            height: 150px;
            /* Change the height to your desired value */
            border: 1px solid black;
            /* Optional: add a border to see the canvas boundaries */
        }
    </style>
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand px-3 py-2 d-flex align-items-center">
                    <!-- <a href="index.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a> -->
                </div>
                <!-- App brand ends -->

                <!-- Sidebar menu starts -->
                <?php include './config/sidebar.php'; ?>
                <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <?php include './config/header.php'; ?>
                <!-- App header ends -->



                <!-- App body starts -->
                <div class="app-body">

                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    ?>
                        <?php ?>

                    <?php


                    }

                    ?>
                    <!-- Container starts -->
                    <div class="container-fluid">

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12 col-xl-12">
                                <!-- Breadcrumb start -->
                                <ol class="breadcrumb mb-1">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Home</a>

                                    </li>
                                    <li class=" breadcrumb-active">

                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    Birthing records
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Birthing Count by Barangay</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="areaGraph"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row end -->
                        <!-- <canvas id="deliveriesChart"></canvas> -->



                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title"> <span> <a href="maternity.php" type="button" class="btn btn-primary float-end">
                                                    <i class="icon-chevron-left"></i> Back

                                                </a></span></h5>
                                        <!-- <h5 class="card-title" > Back</h5> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12">
                                            <div class="d-flex gap-2 justify-content-end mb-2">


                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="all_patients" class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient Name</th>
                                                        <th>Date</th>

                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                        <?php
                                                        $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*,b.*,
                                                                         (SELECT MAX(c.created_at) 
                                                                    FROM tbl_complaints AS c 
                                                                    WHERE c.patient_id = users.patientID 
                                                                    AND c.status = 'Done' 
                                                                    AND c.consultation_purpose = 'Birthing') AS latest_complaint_date
                                                                FROM tbl_patients AS users 
                                                                LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                                                                LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                                                                LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                                                                LEFT JOIN tbl_birth_info AS b ON users.patientID = b.patient_id
                                                                WHERE complaints.status = 'Done' 
                                                                AND complaints.consultation_purpose = 'Birthing'
                                                                AND b.patient_id IS NOT NULL
                                                                GROUP BY users.patientID 
                                                                ORDER BY users.patientID DESC";
                                                        $stmtUsers = $con->prepare($query);
                                                        $stmtUsers->execute();

                                                        ?>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $count = 0;
                                                    while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                                                        $count++;
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $count; ?></td>

                                                            <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>

                                                            <td><?php echo date('F j, Y', strtotime($row['date'])); ?></td>

                                                            <td>
                                                                <?php

                                                                if ($row['status'] == 'Done') {
                                                                    echo '<span class="badge bg-success">Done</span>';
                                                                } else {
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="records_birthing_all.php?id=<?php echo $row['patient_id'] ?>" button class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary"
                                                                    data-bs-title="View">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                            </td>



                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->





                </div>
                <!-- Container ends -->

            </div>
            <!-- App body ends -->



            <!-- App footer start -->
            <?php include './config/footer.php'; ?>
            <!-- App footer end -->

        </div>
        <!-- App container ends -->

    </div>
    <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->

    <!-- Apex Charts -->
    <script src="../assets/vendor/apex/apexcharts.min.js"></script>




    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>



    <script>
        $(document).ready(function() {
            $("#all_patients").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [10, 20, 50, 100],
            });
        });
    </script>

    <!-- <script>
        // Fetch the data from the PHP script
        fetch('ajax/birth_count.php')
            .then(response => response.json())
            .then(data => {
                // Data fetched from the PHP script
                console.log(data);
                var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                var chartData = {
                    labels: labels,
                    datasets: []
                };

                // For each barangay, create a dataset
                for (var barangay in data) {
                    var deliveryData = new Array(12).fill(0); // 12 months

                    for (var month in data[barangay]) {
                        deliveryData[month - 1] = data[barangay][month];
                    }

                    chartData.datasets.push({
                        label: barangay,
                        data: deliveryData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    });
                }

                // Create the chart
                var ctx = document.getElementById('deliveriesChart').getContext('2d');
                var deliveriesChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script> -->

    <!-- <script>
        $(document).ready(function() {
            $.ajax({
                url: 'ajax/birth_count.php', // Update this to the actual path of your PHP file
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Process the response to fit the chart series format
                    var seriesData = [];
                    var categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                    // Extracting series for each barangay
                    $.each(response, function(brgy, data) {
                        var monthlyData = [];
                        for (var i = 1; i <= 12; i++) {
                            monthlyData.push(data[i] || 0); // Fill missing months with 0
                        }
                        seriesData.push({
                            name: brgy, // Barangay name
                            data: monthlyData // Monthly data for the barangay
                        });
                    });



                    // Update your chart options with the dynamic data
                    var options = {
                        chart: {
                            height: 300,
                            type: 'area',
                            toolbar: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                            colors: ['#0a50d8', '#57637B', '#D6DAE3']
                        },
                        series: seriesData, // This is populated dynamically
                        grid: {
                            borderColor: '#ccd2da',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 10,
                                left: 0
                            }
                        },
                        xaxis: {
                            categories: categories // This represents months
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        colors: ['#0a50d8', '#57637B', '#D6DAE3'],
                        markers: {
                            size: 0,
                            opacity: 0.7,
                            colors: ['#0a50d8', '#57637B', '#D6DAE3'],
                            strokeColor: '#ffffff',
                            strokeWidth: 2,
                            hover: {
                                size: 7
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#areaGraph"), options);

                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        });
    </script> -->
    <!-- 
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'ajax/birth_count.php', // Ensure the path is correct
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var seriesData = [];
                    var categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                    // Process each barangay's data
                    $.each(response, function(brgy, data) {
                        if (brgy !== 'Total Transferred') {
                            var normalData = [];
                            for (var i = 1; i <= 12; i++) {
                                normalData.push(data[i] || 0); // Normal deliveries
                            }

                            seriesData.push({
                                name: brgy,
                                data: normalData
                            });
                        } else {
                            var transferredData = [];
                            for (var i = 1; i <= 12; i++) {
                                transferredData.push(data[i] || 0); // Transferred cases
                            }

                            seriesData.push({
                                name: 'Total Transferred',
                                data: transferredData,
                                color: '#ff0000'
                            });
                        }
                    });

                    var options = {
                        chart: {
                            height: 300,
                            type: 'area',
                            toolbar: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        series: seriesData, // Series data
                        grid: {
                            borderColor: '#ccd2da',
                            strokeDashArray: 5, 
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 10,
                                left: 0
                            }
                        },
                        xaxis: {
                            categories: categories
                        },
                        yaxis: {
                            labels: {
                                show: true // Show y-axis labels
                            },
                            title: {
                                text: 'Total Population', // Set y-axis label
                                style: {
                                    color: '#000000', // Label color
                                    fontSize: '12px', // Label font size
                                    fontWeight: 'bold', // Label font weight
                                }
                            }
                        },
                        colors: ['#0a50d8', '#ff5733'], // Adjusted colors for normal and transferred
                        markers: {
                            size: 0,
                            opacity: 0.7,
                            strokeColor: '#ffffff',
                            strokeWidth: 2,
                            hover: {
                                size: 7
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#areaGraph"), options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        });
    </script> -->


    <script>
        // $(document).ready(function() {
        //     $.ajax({
        //         url: 'ajax/birth_count.php', // Ensure the path is correct
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(response) {
        //             var seriesData = [];
        //             var categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        //             // Process each barangay's data
        //             $.each(response, function(brgy, data) {
        //                 if (brgy !== 'Total Referred') {
        //                     var normalData = [];
        //                     for (var i = 1; i <= 12; i++) {
        //                         normalData.push(data[i] || 0); // Normal deliveries
        //                     }

        //                     seriesData.push({
        //                         name: brgy,
        //                         data: normalData
        //                     });
        //                 }
        //             });

        //             // Process total referred data
        //             var referredData = [];
        //             for (var i = 1; i <= 12; i++) {
        //                 referredData.push(response['Total Referred'][i] || 0); // Referred cases
        //             }

        //             seriesData.push({
        //                 name: 'Total Referred',
        //                 data: referredData,
        //                 color: '#ff0000'
        //             });

        //             var options = {
        //                 chart: {
        //                     height: 300,
        //                     type: 'area',
        //                     toolbar: {
        //                         show: false
        //                     }
        //                 },
        //                 dataLabels: {
        //                     enabled: false
        //                 },
        //                 stroke: {
        //                     curve: 'smooth',
        //                     width: 2
        //                 },
        //                 series: seriesData, // Series data
        //                 grid: {
        //                     borderColor: '#ccd2da',
        //                     strokeDashArray: 5,
        //                     xaxis: {
        //                         lines: {
        //                             show: true
        //                         }
        //                     },
        //                     yaxis: {
        //                         lines: {
        //                             show: false
        //                         }
        //                     },
        //                     padding: {
        //                         top: 0,
        //                         right: 0,
        //                         bottom: 10,
        //                         left: 0
        //                     }
        //                 },
        //                 xaxis: {
        //                     categories: categories
        //                 },
        //                 yaxis: {
        //                     labels: {
        //                         show: true // Show y-axis labels
        //                     },
        //                     title: {
        //                         text: 'Total Population', // Set y-axis label
        //                         style: {
        //                             color: '#000000', // Label color
        //                             fontSize: '12px', // Label font size
        //                             fontWeight: 'bold', // Label font weight
        //                         }
        //                     }
        //                 },
        //                 colors: ['#0a50d8', '#ff5733'], // Adjusted colors for normal and transferred
        //                 markers: {
        //                     size: 0,
        //                     opacity: 0.7,
        //                     strokeColor: '#ffffff',
        //                     strokeWidth: 2,
        //                     hover: {
        //                         size: 7
        //                     }
        //                 }
        //             };

        //             var chart = new ApexCharts(document.querySelector("#areaGraph"), options);
        //             chart.render();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("An error occurred: " + error);
        //         }
        //     });
        // });
    </script>


    <!-- <script>
        $(document).ready(function() {
            $.ajax({
                url: 'ajax/birth_count.php', // Ensure the path is correct
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Log the response for debugging

                    var seriesData = [];
                    var categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                    // Process each barangay's data
                    $.each(response, function(brgy, data) {
                        if (brgy !== 'Total Referred') {
                            var normalData = [];
                            for (var i = 1; i <= 12; i++) {
                                normalData.push(data[i] || 0); // Use 0 if data is undefined
                            }

                            seriesData.push({
                                name: brgy,
                                data: normalData
                            });
                        }
                    });

                    // Process total referred data
                    var referredData = [];
                    for (var i = 1; i <= 12; i++) {
                        referredData.push((response['Total Referred'] && response['Total Referred'][i]) || 0); // Handle undefined
                    }

                    seriesData.push({
                        name: 'Total Referred',
                        data: referredData,
                        color: '#ff0000'
                    });

                    var options = {
                        chart: {
                            height: 300,
                            type: 'area',
                            toolbar: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        series: seriesData, // Series data
                        grid: {
                            borderColor: '#ccd2da',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 10,
                                left: 0
                            }
                        },
                        xaxis: {
                            categories: categories
                        },
                        yaxis: {
                            labels: {
                                show: true // Show y-axis labels
                            },
                            title: {
                                text: 'Total Population',
                                style: {
                                    color: '#000000',
                                    fontSize: '12px',
                                    fontWeight: 'bold',
                                }
                            }
                        },
                        colors: ['#0a50d8', '#ff5733'],
                        markers: {
                            size: 0,
                            opacity: 0.7,
                            strokeColor: '#ffffff',
                            strokeWidth: 2,
                            hover: {
                                size: 7
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#areaGraph"), options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        });
    </script> -->

    <script>
    $(document).ready(function() {
        $.ajax({
            url: 'ajax/birth_count.php', // Ensure the path is correct
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);  // Log the response for debugging

                var seriesData = [];
                var categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                // Process each barangay's data
                $.each(response, function(brgy, data) {
                    if (brgy !== 'Total Referred') {
                        var normalData = [];
                        for (var i = 1; i <= 12; i++) {
                            normalData.push(data[i] || 0); // Use 0 if data is undefined
                        }

                        seriesData.push({
                            name: brgy,
                            data: normalData
                        });
                    }
                });

                // Process total referred data
                var referredData = [];
                for (var i = 1; i <= 12; i++) {
                    referredData.push((response['Total Referred'] && response['Total Referred'][i]) || 0); // Handle undefined
                }

                seriesData.push({
                    name: 'Total Referred',
                    data: referredData,
                    color: '#ff0000'
                });

                var options = {
                    chart: {
                        height: 350, // Increased height for better visibility
                        type: 'area',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: true // Enable zooming
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    series: seriesData, // Series data
                    grid: {
                        borderColor: '#ccd2da',
                        strokeDashArray: 5, 
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 10,
                            left: 0
                        }
                    },
                    xaxis: {
                        categories: categories,  // Keep the months as x-axis categories
                        title: {
                            text: 'Months',
                            style: {
                                color: '#000000',
                                fontSize: '12px',
                                fontWeight: 'bold',
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: true // Show y-axis labels
                        },
                        title: {
                            text: 'Total Population',
                            style: {
                                color: '#000000',
                                fontSize: '12px',
                                fontWeight: 'bold',
                            }
                        }
                    },
                    legend: {
                        position: 'bottom', // Move legend to bottom to avoid cluttering
                        horizontalAlign: 'center'
                    },
                    colors: ['#0a50d8', '#ff5733', '#2b908f', '#f9a3a4', '#90ee7e'], // Add more colors for variety
                    markers: {
                        size: 3, // Smaller marker size to avoid overlap
                        opacity: 0.9,
                        strokeColor: '#ffffff',
                        strokeWidth: 2,
                        hover: {
                            size: 6
                        }
                    },
                    tooltip: {
                        shared: true, // Enable shared tooltip for better comparison
                        intersect: false
                    }
                };

                var chart = new ApexCharts(document.querySelector("#areaGraph"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + error);
            }
        });
    });
</script>





</body>



</html>