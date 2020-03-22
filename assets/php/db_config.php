<?php
    define('DB_SERVER'   , 'localhost');
    define('DB_USERNAME' , 'root');
    define('DB_PASSWORD' , '');
    define('DB_DATABASE' , "covid");  //creare il database covid altrimenti non funziona
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    $fName=$file_name;
    $fName = explode('.',$file_name, -1)[0];

    // get structure from csv and insert db
    ini_set('auto_detect_line_endings', TRUE);
    $handle = fopen("../data/". $file_name, 'r');
    // first row, structure
    if (($data = fgetcsv($handle)) === FALSE) {
        echo "Cannot read from csv $fName";
        die();
    }
    $fields = array();
    $field_count = 0;
    $unique="";
    for ($i = 0; $i < count($data); $i++) {
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

    $sql = "CREATE TABLE `$fName` (" . implode(', ', $fields) .",UNIQUE($unique)". ')';
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
    fclose($handle);
    ini_set('auto_detect_line_endings', FALSE);
?>