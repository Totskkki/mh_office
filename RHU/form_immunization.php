<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Immunization Record</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        .info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .info div {
            display: flex;
            flex-direction: column;
        }

        .info label {
            margin-bottom: 5px;
            color: #555;
        }

        .info input[type="text"], .info input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .info input[type="radio"] {
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #ffcc00;
            color: #333;
            font-weight: 600;
        }

        table td {
            background-color: #fff;
        }

        table td input[type="date"], table td input[type="text"] {
            width: 100%;
            border: none;
            padding: 5px;
            box-sizing: border-box;
        }

        table td input[type="date"] {
            font-family: 'Open Sans', sans-serif;
        }

        footer p {
            font-size: 12px;
            color: #666;
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }

        select {
            width: 100%;
            padding: 5px;
            border: none;
            background-color: rgba(255, 255, 255, 0.6);
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Child Immunization Record</h1>
        <div class="info">
            <div>
                <label>Child's name:</label>
                <input type="text" name="child_name">
            </div>
            <div>
                <label>Date of birth:</label>
                <input type="date" name="dob">
            </div>
            <div>
                <label>Place of birth:</label>
                <input type="text" name="place_of_birth">
            </div>
            <div>
                <label>Address:</label>
                <input type="text" name="address">
            </div>
            <div>
                <label>Mother's name:</label>
                <input type="text" name="mother_name">
            </div>
            <div>
                <label>Father's name:</label>
                <input type="text" name="father_name">
            </div>
            <div>
                <label>Birth height:</label>
                <input type="text" name="birth_height">
            </div>
            <div>
                <label>Birth weight:</label>
                <input type="text" name="birth_weight">
            </div>
            <div>
                <label>Sex:</label>
                <input type="radio" name="sex" value="male"> Male
                <input type="radio" name="sex" value="female"> Female
            </div>
            <div>
                <label>Health Center:</label>
                <input type="text" name="health_center">
            </div>
            <div>
                <label>Barangay:</label>
                <input type="text" name="barangay">
            </div>
            <div>
                <label>Family no.:</label>
                <input type="text" name="family_no">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Bakuna</th>
                    <th>Doses</th>
                    <th>Petsa ng bakuna (MM/DD/YY)</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="bcg_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>1</td>
                    <td><input type="date" name="bcg_date"></td>
                    <td><input type="text" name="bcg_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="hepB_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine" selected>Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>1</td>
                    <td><input type="date" name="hepB_date"></td>
                    <td><input type="text" name="hepB_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="pentavalent_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)" selected>Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>3</td>
                    <td>
                        <input type="date" name="pentavalent_date1">
                        <input type="date" name="pentavalent_date2">
                        <input type="date" name="pentavalent_date3">
                    </td>
                    <td><input type="text" name="pentavalent_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="opv_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)" selected>Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>3</td>
                    <td>
                        <input type="date" name="opv_date1">
                        <input type="date" name="opv_date2">
                        <input type="date" name="opv_date3">
                    </td>
                    <td><input type="text" name="opv_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="ipv_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)" selected>Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>2</td>
                    <td>
                        <input type="date" name="ipv_date1">
                        <input type="date" name="ipv_date2">
                    </td>
                    <td><input type="text" name="ipv_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="pcv_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)" selected>Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)">Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>3</td>
                    <td>
                        <input type="date" name="pcv_date1">
                        <input type="date" name="pcv_date2">
                        <input type="date" name="pcv_date3">
                    </td>
                    <td><input type="text" name="pcv_remarks"></td>
                </tr>
                <tr>
                    <td>
                        <select name="mmr_vaccine">
                            <option value="BCG Vaccine">BCG Vaccine</option>
                            <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                            <option value="Pentavalent Vaccine (DPT-Hep B-HIB)">Pentavalent Vaccine (DPT-Hep B-HIB)</option>
                            <option value="Oral Polio Vaccine (OPV)">Oral Polio Vaccine (OPV)</option>
                            <option value="Inactivated Polio Vaccine (IPV)">Inactivated Polio Vaccine (IPV)</option>
                            <option value="Pneumococcal Conjugate Vaccine (PCV)">Pneumococcal Conjugate Vaccine (PCV)</option>
                            <option value="Measles, Mumps, Rubella Vaccine (MMR)" selected>Measles, Mumps, Rubella Vaccine (MMR)</option>
                        </select>
                    </td>
                    <td>2</td>
                    <td>
                        <input type="date" name="mmr_date1">
                        <input type="date" name="mmr_date2">
                    </td>
                    <td><input type="text" name="mmr_remarks"></td>
                </tr>
            </tbody>
        </table>

        <footer>
            <p>Sa column ng Petsa ng bakuna, isulat ang petsa ng pagbibigay ng bakuna ayon sa kung pang-ilang dose ito. Sa column ng Remarks, isulat ang petsa ng pagbabalik para sa susunod na dose, o anumang mahalagang impormasyon na maaaring makaapekto sa pagbabakuna ng bata.</p>
        </footer>
    </div>
</body>
</html>
