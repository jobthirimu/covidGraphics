<?php

//phpinfo(); 

// Initialize the cURL session 
$ch = curl_init($url);

// Inintialize directory name where 
// file will be save 
$dir = '../data/';

// Use basename() function to return 
// the base name of file  
$file_name = basename($url);

// Save file into file location 
$save_file_loc = $dir . $file_name;

// Open file  sudo chmod -R 777 /path/to/directory
$fp = fopen($save_file_loc, 'wb');

// It set an option for a cURL transfer 
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

// Perform a cURL session 
curl_exec($ch);

// Closes a cURL session and frees all resources 
curl_close($ch);

// Close file 
fclose($fp);
  
echo "Download completato";

?>
