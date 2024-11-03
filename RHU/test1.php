<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Room Record</title>
  <style>
    body {
    font-family: Arial, sans-serif;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
}

.section {
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
}

h1, h2 {
    text-align: center;
}

label {
    display: block;
    margin-top: 10px;
}

input[type="text"], input[type="number"], input[type="date"], input[type="time"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}

input[type="checkbox"] {
    margin-right: 5px;
}

button {
    display: block;
    width: 100px;
    margin: 20px auto;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #45a049;
}

  </style>
</head>
<body>
    <div class="container">
        <h1>LUTAYAN RHU BIRTHING CENTER</h1>
        <h2>Delivery Room Record</h2>
        <form>
            <div class="section">
                <label for="patientName">Patient's Name:</label>
                <input type="text" id="patientName" name="patientName">
                
                <label for="age">Age:</label>
                <input type="number" id="age" name="age">
                
                <label for="dateAdmitted">Date Admitted:</label>
                <input type="date" id="dateAdmitted" name="dateAdmitted">
                
                <label for="gravidity">Gravida:</label>
                <input type="number" id="gravidity" name="gravidity">
                
                <label for="parity">Para:</label>
                <input type="number" id="parity" name="parity">
                
                <label for="fullTerm">Full Term:</label>
                <input type="number" id="fullTerm" name="fullTerm">
                
                <label for="premature">Premature:</label>
                <input type="number" id="premature" name="premature">
                
                <label for="abortion">Abortion:</label>
                <input type="number" id="abortion" name="abortion">
                
                <label for="living">No. of Living:</label>
                <input type="number" id="living" name="living">
            </div>
            
            <div class="section">
                <h3>Labor:</h3>
                <label for="laborTime">Time:</label>
                <input type="time" id="laborTime" name="laborTime">
                
                <label for="laborDate">Date:</label>
                <input type="date" id="laborDate" name="laborDate">
                
                <fieldset>
                    <legend>Stage of Labor:</legend>
                    <label for="stage1">I</label>
                    <input type="checkbox" id="stage1" name="stage1">
                    <label for="stage2">II</label>
                    <input type="checkbox" id="stage2" name="stage2">
                    <label for="stage3">III</label>
                    <input type="checkbox" id="stage3" name="stage3">
                </fieldset>
                
                <label for="durationHours">Duration (Hours):</label>
                <input type="number" id="durationHours" name="durationHours">
                
                <label for="durationMinutes">Minutes:</label>
                <input type="number" id="durationMinutes" name="durationMinutes">
            </div>
            
            <div class="section">
                <h3>Placenta:</h3>
                <label for="expelledCompletely">Expelled Completely:</label>
                <input type="checkbox" id="expelledCompletely" name="expelledCompletely">
                
                <label for="retained">Retained for Method of Expulsion:</label>
                <input type="checkbox" id="retained" name="retained">
                
                <label for="spontaneous">Spontaneous:</label>
                <input type="checkbox" id="spontaneous" name="spontaneous">
                
                <label for="assisted">Assisted:</label>
                <input type="checkbox" id="assisted" name="assisted">
                
                <label for="manualExtraction">Manual Extraction:</label>
                <input type="checkbox" id="manualExtraction" name="manualExtraction">
            </div>
            
            <div class="section">
                <h3>Method of Delivery:</h3>
                <label for="nsvd">NSVD:</label>
                <input type="checkbox" id="nsvd" name="nsvd">
                
                <label for="ltcs">LTCS:</label>
                <input type="checkbox" id="ltcs" name="ltcs">
                
                <label for="forceps">Forceps:</label>
                <input type="checkbox" id="forceps" name="forceps">
            </div>
            
            <div class="section">
                <label for="handledBy">Handled by:</label>
                <input type="text" id="handledBy" name="handledBy">
                
                <label for="assistedBy">Assisted by:</label>
                <input type="text" id="assistedBy" name="assistedBy">
                
                <label for="physician">Physician on duty:</label>
                <input type="text" id="physician" name="physician">
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
