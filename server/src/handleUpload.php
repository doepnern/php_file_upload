<?php
$uploaddir = '/var/www/uploads/';
$allowedFileTypes = array("image/bmp","image/jpeg","image/jpg", "image/png","image/svg+xml","image/webp","application/pdf");
//max file size in bytes: 5mb
$allowedMaxFileSize = 5000000;

$formattedFiles = array();
// files in besser lesbares format bringen und informationen aus files holen statt auf $_FILES verlassen
if(!isset($_FILES["userfile"]["name"])){
    header('Content-Type: application/json');
    echo json_encode(setError("Keine Dateien ausgewählt."));
    exit();
}
$numFiles = count($_FILES["userfile"]["name"]);
for($i = 0; $i < $numFiles; $i++){
    $tmpName =  $_FILES["userfile"]["tmp_name"][$i];
    $type = "unknwown";
    $size = 0;
    if(!($tmpName == "") && file_exists($tmpName)){
        $size = filesize($_FILES["userfile"]["tmp_name"][$i]);
        $get_file_info = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($get_file_info, $tmpName);
    }
    $formattedFiles[$i] = [
        "name" => $_FILES["userfile"]["name"][$i],
        "tmp_name" => $_FILES["userfile"]["tmp_name"][$i],
        "error" => $_FILES["userfile"]["error"][$i],
        "size" => $size,
        "type" => $type
    ];
}

function setError($err){
    $errObj = array("status" => "Error: " . $err, "error" => true);
    return $errObj;
}

$fileResponses = array();

foreach($formattedFiles as $key => $value){
    $uploadfileName = $uploaddir . basename($value['name']);

    $err = $value["error"];
    if($err == UPLOAD_ERR_INI_SIZE || $err == UPLOAD_ERR_FORM_SIZE || $value["size"] > $allowedMaxFileSize) {
        $fileResponses[$key] = setError("Die ausgewählte Datei ist zu groß.");
        continue;
    }
    if($err == UPLOAD_ERR_OK){
        if (!in_array($value['type'], $allowedFileTypes)) {
            $fileResponses[$key] = setError("Die ausgewählte Datei vom typ: ".$file["type"]." ist nicht erlaubt.");
            continue;
        }
        if(move_uploaded_file($value['tmp_name'], $uploadfileName)){
            $fileResponses[$key]["status"] = "Datei erfolgreich hochgeladen.";
            $fileResponses[$key]["error"] = false;
            $fileResponses[$key]["name"] = $value['name'];
            $fileResponses[$key]["type"] = $value['type'];
            $fileResponses[$key]["size"] = $value['size'];
            $fileResponses[$key]["upload_location"] = $uploadfileName;
            continue;
        } 
    } 
    $fileResponses[$key] = setError("Fehler beim Hochladen der Datei.");
    error_log("Fehler in move_uploaded_file " . $value['tmp_name'] . " " . $uploadfileName . " " . $err);
}


header('Content-Type: application/json');
echo json_encode($fileResponses);
exit();

?>