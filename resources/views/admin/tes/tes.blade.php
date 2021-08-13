<?php
    $response_ = json_decode(json_encode($response), true);   
    echo $response_['aktivitas_waktu'].'<br>';
    echo $response_['aktivitas_id'].'<br>';
    echo $response_['aktivitas'].'<br>';
    echo $response_['lab_akuns_id'].'<br>';
    echo $response_['lab_akuns_nama'].'<br>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>