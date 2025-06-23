<?php
include '../config/connection.php';

if (isset($_POST['updatedelivery'])) {


    $patientID = trim($_POST['patientid']);
    $deliveryid = trim($_POST['deliveryid']);
    $dateAdmitted = trim($_POST['dateAdmitted']);

    $laborTypes = isset($_POST['labor']) ? $_POST['labor'] : [];
    $laborTime = trim($_POST['laborTime']);
    $laborDate = trim($_POST['laborDate']);
    $laborDurationHrs = trim($_POST['laborHrs']);
    $laborDurationMins = trim($_POST['laborMins']);

    $cervixTime = trim($_POST['CervixTime']);
    $cervixDate = trim($_POST['CervixDate']);
    $cervixHrs = trim($_POST['CervixHrs']);
    $cervixMins = trim($_POST['CervixMins']);

    $babyTime = trim($_POST['BabylaborTime']);
    $babyDate = trim($_POST['BabylaborDate']);
    $babyHrs = trim($_POST['babyHrs']);
    $babyMins = trim($_POST['babyMins']);

    $placentaTime = trim($_POST['PlacentaTime']);
    $placentaDate = trim($_POST['PlacentaDate']);
    $placentaHrs = trim($_POST['PlacentaHrs']);
    $placentaMins = trim($_POST['PlacentaMins']);

    $physician = trim($_POST['physician']);

    $labor = [
        'labor' => [
            'types' => $laborTypes,
            'time' => $laborTime,
            'date' => $laborDate,
            'duration' => [
                'hrs' => $laborDurationHrs,
                'mins' => $laborDurationMins
            ]
        ],
        'cervix' => [
            'time' => $cervixTime,
            'date' => $cervixDate,
            'duration' => [
                'hrs' => $cervixHrs,
                'mins' => $cervixMins
            ]
        ],
        'baby' => [
            'time' => $babyTime,
            'date' => $babyDate,
            'duration' => [
                'hrs' => $babyHrs,
                'mins' => $babyMins
            ]
        ],
        'placenta' => [
            'time' => $placentaTime,
            'date' => $placentaDate,
            'duration' => [
                'hrs' => $placentaHrs,
                'mins' => $placentaMins
            ]
        ]
    ];
    $jsonDatalabor = json_encode($labor);

    $gravida = trim($_POST['gravida']);
    $para = trim($_POST['para']);
    $fullTerm = trim($_POST['fullTerm']);
    $premature = trim($_POST['premature']);
    $abortion = trim($_POST['abortion']);
    $noOfLiving = trim($_POST['noOfLiving']);

    $placentaExpelled = isset($_POST['placentaExpelled']) ? $_POST['placentaExpelled'] : [];
    $placentaExpelled = array_map('trim', $placentaExpelled);

    

    $umbilicalCordCm = htmlspecialchars(trim($_POST['cm']));

// Handle 'None' checkbox for umbilicalCord (loops at neck)
$umbilicalCordNone = isset($_POST['umbilicalCordNone']) ? 'None' : '';
$umbilicalCordNoNexk = ($umbilicalCordNone === 'None') ? '' : htmlspecialchars(trim($_POST['no_nexk']));

// Handle 'None' checkbox for umbilicalCordLoops (other abnormalities)
$umbilicalCordLoopsNone = isset($_POST['umbilicalCordLoopsNone']) ? 'None' : '';
$umbilicalCordLoops = ($umbilicalCordLoopsNone === 'None') ? '' : htmlspecialchars(trim($_POST['umbilicalCordLoops']));

$placentaOther = htmlspecialchars(trim($_POST['placentaOther']));
$bloodLossAntepartum = htmlspecialchars(trim($_POST['bloodLossAntepartum']));
$bloodLossIntrapartum = htmlspecialchars(trim($_POST['bloodLossIntrapartum']));
$bloodLossPostpartum = htmlspecialchars(trim($_POST['bloodLossPostpartum']));
$totalBloodLoss = htmlspecialchars(trim($_POST['totalBloodLoss']));

// Construct the placenta data array
$placenta = [
    'placenta' => [
        'expelled' => $placentaExpelled
    ],
    'umbilicalCord' => [
        'cm' => $umbilicalCordCm,
        'loops_at_neck' => $umbilicalCordNoNexk,
        'loops' => $umbilicalCordLoops,
        'none' => $umbilicalCordNone,
        'loopsNone' => $umbilicalCordLoopsNone
    ],
    'other' => $placentaOther,
    'bloodLoss' => [
        'antepartum' => $bloodLossAntepartum,
        'intrapartum' => $bloodLossIntrapartum,
        'postpartum' => $bloodLossPostpartum,
        'total' => $totalBloodLoss
    ]
];

$jsonDataplacenta = json_encode($placenta);

    
    

    $methodDelivery = isset($_POST['method']) ? json_encode($_POST['method']) : '[]';
    $Episiotomy = isset($_POST['Episiotomy']) ? json_encode($_POST['Episiotomy']) : '[]';
    $Laceration = isset($_POST['Laceration']) ? json_encode($_POST['Laceration']) : '[]';
    $Anethesia = isset($_POST['Anethesia']) ? json_encode($_POST['Anethesia']) : '[]';
    $Analgesia = isset($_POST['Analgesia']) ? json_encode($_POST['Analgesia']) : '[]';
    $condition = isset($_POST['condition']) ? json_encode($_POST['condition']) : '[]';
    $urinary_Bladder = isset($_POST['urinary_bladder']) ? json_encode($_POST['urinary_bladder']) : '[]';
    $uterus = isset($_POST['uterus']) ? json_encode($_POST['uterus']) : '[]';

    $pregnancy = trim($_POST['pregnancy']);
    $not_Related = trim($_POST['not_related']);
    $complications = trim($_POST['complications']);
    $handledBy = trim($_POST['handledBy']);
    $assistedBy = trim($_POST['assistedBy']);
    $physician = trim($_POST['physician']);
    $dateAdmitted = trim($_POST['dateAdmitted']);

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("UPDATE tbl_birthroom
    SET dateAdmitted = :dateAdmitted, 
         patient_id = :patient_id,
        gravida = :gravida, 
        para = :para, 
        fullTerm = :fullTerm, 
        premature = :premature, 
        abortion = :abortion, 
        noOfLiving = :noOfLiving, 
        labor = :labor, 
        placenta = :placenta, 
        method_delivery = :method_delivery, 
        Episiotomy = :Episiotomy, 
        Laceration = :Laceration, 
        Anethesia = :Anethesia, 
        Analgesia = :Analgesia, 
        `condition` = :condition, 
        urinary_bladder = :urinary_bladder, 
        uterus = :uterus, 
        pregnancy = :pregnancy, 
        not_related = :not_related, 
        complications = :complications, 
        Handled_by = :handled_by, 
        assisted_by = :assisted_by, 
        physician = :physician
    WHERE roomID  = :delivery_id");


        $stmt->execute([
           
            ':delivery_id' => $deliveryid,
            ':patient_id' => $patientID,
            ':dateAdmitted' => $dateAdmitted,
            ':gravida' => $gravida,
            ':para' => $para,
            ':fullTerm' => $fullTerm,
            ':premature' => $premature,
            ':abortion' => $abortion,
            ':noOfLiving' => $noOfLiving,
            ':labor' => $jsonDatalabor,
            ':placenta' => $jsonDataplacenta,
            ':method_delivery' => $methodDelivery,
            ':Episiotomy' => $Episiotomy,
            ':Laceration' => $Laceration,
            ':Anethesia' => $Anethesia,
            ':Analgesia' => $Analgesia,
            ':condition' => $condition,
            ':urinary_bladder' => $urinary_Bladder,
            ':uterus' => $uterus,
            ':pregnancy' => $pregnancy,
            ':not_related' => $not_Related,
            ':complications' => $complications,
            ':handled_by' => $handledBy,
            ':assisted_by' => $assistedBy,
            ':physician' => $physician
        ]);

        $con->commit();
        $_SESSION['status'] = "Delivery record updated successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: ../birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}



