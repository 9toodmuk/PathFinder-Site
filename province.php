<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "thai_province";

    $conn = mysqli_connect($host,$user,$pass,$database);
    date_default_timezone_set("Asia/Bangkok");
    mysqli_set_charset($conn,"UTF8");

    $sql = "SELECT provinces.PROVINCE_NAME_ENG as province FROM provinces";
    $result = $conn->query($sql);

    // $provinces = array();
    // while($row = mysqli_fetch_assoc($result)){
    //     array_push($provinces, $row);
    // }

    // echo json_encode($provinces);

    $sql = "SELECT districts.DISTRICT_NAME_ENG as name, amphures.AMPHUR_NAME_ENG as district, zipcodes.zipcode as postcode FROM districts JOIN amphures ON districts.AMPHUR_ID = amphures.AMPHUR_ID JOIN zipcodes ON zipcodes.district_code = districts.DISTRICT_CODE";
    // $sql = "SELECT amphures.AMPHUR_NAME_ENG as name, provinces.PROVINCE_NAME_ENG as province FROM amphures JOIN provinces ON amphures.PROVINCE_ID = provinces.PROVINCE_ID";
    $result = $conn->query($sql);
    
    $amphures = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($amphures, $row);
    }

    echo json_encode($amphures);
?>