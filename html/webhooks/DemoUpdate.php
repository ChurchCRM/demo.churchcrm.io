<?php

require_once 'webhookconfig.php';

function playbackSQLtoDatabase($fileName, $mysqli) {
  $query = '';
  $restoreQueries = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($restoreQueries as $line) {
    if ($line != '' && strpos($line, '--') === false) {
      $query .= $line;
      if (substr($query, -1) == ';') {
        #echo $query;
        $mysqli->query($query);
        $query = '';
      }
    }
  }
}

function resetDatabase($dbHost, $dbName, $dbUsername, $dbPassword,$delPath, $version=null) {
  echo "deleting all tables\r\n";
  $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
  $mysqli->query('SET foreign_key_checks = 0');
  if ($result = $mysqli->query("SHOW TABLES")) {
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
      $mysqli->query('DROP TABLE IF EXISTS ' . $row[0]);
    }
  }

  $mysqli->query('SET foreign_key_checks = 1');
  echo "installing from new schema\r\n";
  playbackSQLtoDatabase($delPath."/mysql/install/Install.sql", $mysqli);
  playbackSQLtoDatabase($delPath."/mysql/upgrade/update_config.sql", $mysqli);
  playbackSQLtoDatabase($delPath."/mysql/upgrade/rebuild_nav_menus.sql", $mysqli);
  if($mysqli->query('UPDATE user_usr SET usr_NeedPasswordChange = 0 where usr_UserName = "Admin" '))
  {
    echo "Set AdminPassword.\r\n";
  }
 
  if ($version)
  {
    echo "setting version to ". $version."\r\n";
    $qs = "INSERT INTO version_ver (ver_version, ver_update_start,ver_update_end) VALUES ('" . $version . "', now(), now());";
    if($mysqli->query($qs))
    {
      echo "Updated Version Table\r\n";
    }
  }
    
   $result = $mysqli->query("SELECT * FROM version_ver");
    
    $row = $result->fetch_assoc();
    echo "Version Check: ".$row['ver_version']."\r\n";
    
  
  $mysqli->close();
}

function delTree($dir) {
  $files = array_diff(scandir($dir), array('.', '..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}

if(isset($_POST['demoKey']) && $_POST['demoKey'] == $DEMOPUSHKEY )
{

  $target_dir = dirname(dirname(__FILE__))."/temp/";
  $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
  
  if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) 
  {
    $branchName =  $_POST['branch'];
    $commitHash =  $_POST['commitHash'];
    
    echo "The file ". basename( $_FILES["fileupload"]["name"]). " has been uploaded.\r\n";
    echo "Commit Hash: " . $commitHash;
    
    $delPath = dirname(dirname(__FILE__))."/".$branchName;
   
    delTree($delPath);

    $p = new ZipArchive;
    $p->open($target_file);
    $p->extractTo($target_dir);  //extract the code\
    $p->close();
    rename($target_dir."/churchcrm",$delPath); // move the repository from the temp folder to the root

    $srcComposer = json_decode(file_get_contents($delPath."/composer.json"));
    $srcComposer -> commitHash = $commitHash;
    file_put_contents($delPath."/composer.json",json_encode($srcComposer));
    $version = $srcComposer->version;
    
    copy(dirname(__FILE__) . "/configFiles/" . $branchName . "/Include/Config.php", $delPath."/Include/Config.php"); //copy any config files necessary
    resetDatabase('localhost', "krystoco_demo_crm_".$branchName, $DBUSERNAME, $DBPASSWORD, $delPath,$version);

    
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
  
}
else
{
  echo "Incorrect or missing build password";
}


exit;