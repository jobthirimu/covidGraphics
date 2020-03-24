<?php
    global $db;
    // $fName=$file_name;
    // $fName = explode('.',$file_name, -1)[0];

    // get structure from csv and insert db
    ini_set('auto_detect_line_endings', TRUE);
    $handle = fopen("../data/".$fName."/". $file_name, 'r');
    $data = fgetcsv($handle);
    $fields = array();
    $field_count = 0;
    $unique="";

    for ($i = 0; $i < count($data); $i++) { //leggo il file csv
        $f = strtolower(trim($data[$i]));
        if ($f) {
            // normalize the field name, strip to 20 chars if too long
            $f = substr(preg_replace('/[^0-9a-z]/', '_', $f), 0, 30);
            $field_count++;

            if($field_count == 1){
                $unique = $f;
            }
            $fields[] = $f . ' VARCHAR(50)';
        }
    }
    $sql = "CREATE TABLE IF NOT EXISTS `$fName` (" . implode(', ', $fields) .",UNIQUE($unique)". ')';
    //echo "<br><br>".$sql . "<br><br>";
    $db->query($sql);
    while (($data = fgetcsv($handle)) !== FALSE) {
        $fields = array();
        for ($i = 0; $i < $field_count; $i++) {
            $fields[] = '\'' . addslashes($data[$i]) . '\'';
        }
        $sql = "Insert into `$fName` values(" . implode(', ', $fields) . ')';
        //echo "<br><br>".$sql. "<br><br>";
        $db->query($sql);
    }
    ini_set('auto_detect_line_endings', FALSE);
    fclose($handle);
?>