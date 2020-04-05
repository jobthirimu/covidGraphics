<?php
global $db;

echo "<script>console.log('" . $fName . "')</script>";
// $fName=$file_name;
// $fName = explode('.',$file_name, -1)[0];

// get structure from csv and insert db
ini_set('auto_detect_line_endings', TRUE);
$percorso = "../data/" . $fName . "/" . $file_name;
//echo $percorso;
$handle = fopen($percorso, 'r');
$data = fgetcsv($handle);
$fields = array();
$field_count = 0;
$unique = "";
array_push($fields, "id int(11) NOT NULL primary key AUTO_INCREMENT"); //creo il campo id
for ($i = 0; $i < count($data); $i++) { //leggo il file csv
    $f = strtolower(trim($data[$i]));
    if ($f) {
        // normalize the field name, strip to 30 chars if too long
        $f = substr(preg_replace('/[^0-9a-z]/', '_', $f), 0, 30);
        $field_count++;

        if ($field_count == 1) {
            $unique = $f;
        }
        if ($f == "long") {
            $f = "longi";
        }
        $fields[] = $f . ' VARCHAR(50)';
    }
}
$sql = "";
if($fName == "andamentoMondiale"){
    $fName=explode('.',basename($url))[0];
    $sql = "CREATE TABLE IF NOT EXISTS `$fName` (" . implode(', ', $fields) . ",UNIQUE KEY `key` (`province_state`,`country_region`)" . ')';
}else if ($fName == "andamentoNazionale") {
    $sql = "CREATE TABLE IF NOT EXISTS `$fName` (" . implode(', ', $fields) . ",UNIQUE($unique)" . ')';
} else if ($fName == "andamentoRegionale") {
    $sql = "CREATE TABLE IF NOT EXISTS `$fName` (" . implode(', ', $fields) . ",UNIQUE KEY `key` (`data`,`denominazione_regione`)" . ')';
} else if ($fName == "andamentoProvinciale") {
    $sql = "CREATE TABLE IF NOT EXISTS `$fName` (" . implode(', ', $fields) . ",UNIQUE KEY `key` (`data`,`codice_provincia`)" . ')';
}
echo "<br><br>" . $sql . "<br><br>";
if (!$db->query($sql)) {
    echo $db->error;
}
while (($data = fgetcsv($handle)) !== FALSE) {
    $fields = array();
    for ($i = 0; $i < $field_count; $i++) {
        $fields[] = '\'' . addslashes($data[$i]) . '\'';
    }
    $sql = "Insert ignore into `$fName` values(null," . implode(', ', $fields) . ')';
    //echo "<br><br>" . $sql . "<br><br>";
    if (!$db->query($sql)) {
        echo $db->error;
    }
}
ini_set('auto_detect_line_endings', FALSE);
fclose($handle);
