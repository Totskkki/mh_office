<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Date Picker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <style>
        .datepicker {
            max-width: 300px;
        }
    </style>
</head>
<body>

<input type="text" id="datepicker" class="datepicker" placeholder="Select dates">

<script src="https://cdn.jsdelivr.net/npm/moment/moment.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/plugins/multiple-date/multiple-date.min.js"></script>
<script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker'),
        format: 'YYYY-MM-DD',
        onSelect: function(date) {
            console.log(this.getDates()); // Outputs selected dates
        },
        multiple: true, // Enables multiple date selection
        disableDayFn: function(date) {
            // Optionally disable specific dates or days
            return date.getDay() === 0; // Example: disable Sundays
        }
    });
</script>

</body>
</html>
