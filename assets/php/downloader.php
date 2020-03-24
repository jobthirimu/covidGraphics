<?php

//phpinfo(); 

// Initialize the cURL session 
$ch = curl_init($url);
//echo "<br>url: ".$url;

// Inintialize directory name where 
// file will be save 
$dir = '../data/'.$fName."/";

// Use basename() function to return 
// the base name of file  
$file_name = basename($url);

// Save file into file location 
$save_file_loc = $dir . $file_name;

// It set an option for a cURL transfer 
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$res = curl_exec($ch);
// Perform a cURL session 
$status= curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Closes a cURL session and frees all resources 
curl_close($ch);
// Close file 
if ($status  != 404 ) {
    // Open file  sudo chmod -R 777 /path/to/directory
    if(!file_exists($save_file_loc)){
        $fp = fopen($save_file_loc, "w");
        fwrite($fp, $res);
        fclose($fp);
        echo "<br> Download completato di: " . $file_name." codice stato: ".$status ;
        include("db_config.php"); //salva la risorsa sul database alla tabella $fName
        $updated++;
    }else{
        //echo "<br> File: ".$file_name." already downloaded";
    }
} else {
}
?>
