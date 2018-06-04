<html>
  <head>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Lato">
    <style>
      body {
        font-family: 'Lato', serif;
        font-size: 16px;
        color: #444444;
      }
    </style>
    
  </head>
  <body>
<div style="font-size:24px;font-width:bold;width:100%;background-color:#DDDDDD;vertical-align: top;padding:0 0 0 0;"><img src="http://1000logos.net/wp-content/uploads/2017/04/PG-Logo.png" alt="" height="42" width="84">
<div style="display:inline-block;;vertical-align: top;padding-top:10px">VIP Selector</div></div> 
<?php

$updatedFields = 0;
for ($i = 1; $i <= 5; $i++) {
    if(strlen($_POST["VIP".$i])>0)
        $updatedFields = 1;
}

if($updatedFields){
    $databaseName = getenv('database');
    $password = getenv('SQLAZURECONNSTR_password');
    $user = getenv('user');
    $serverName = getenv('server');
    $fullServerName = $serverName.".database.windows.net";
    $connectionInfo = array( "Database"=>$databaseName, "UID"=>$user."@".$serverName, "PWD"=>$password);
    $conn = sqlsrv_connect( $fullServerName, $connectionInfo);
    
    if( $conn ) {
         //
    }else{
         echo "Connection to the database could not be established.<br />";
         die( print_r( sqlsrv_errors(), true));
    }
    
    $sql = "DROP TABLE vips;";
    $stmt = sqlsrv_query( $conn, $sql);
    $sql = "CREATE TABLE vips (emailaddr varchar(255));";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    for ($i = 1; $i <= 5; $i++) {
        if(strlen($_POST["VIP".$i])>0){
            $sql = "INSERT INTO vips (emailaddr) VALUES (?)";
            $params = array($_POST["VIP".$i]);
            
            $stmt = sqlsrv_query( $conn, $sql, $params);
            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    }
    
    echo "<font size=\"5\" color=\"green\">Changes saved!</font><br><br>";
}

?>

<div style="width:100%;align:center">
    <div style="width:400px;margin-left:auto;margin-right:auto">
        <p style="font-size:20px">Type in E-mail addresses of your VIP's:</p>
        <form action="index.php" method="post">
            VIP #1:<input style="margin-left:20px" type="text" name="VIP1" value=""><br>
            VIP #2:<input style="margin-left:20px" type="text" name="VIP2" value=""><br>
            VIP #3:<input style="margin-left:20px" type="text" name="VIP3" value=""><br>
            VIP #4:<input style="margin-left:20px" type="text" name="VIP4" value=""><br>
            VIP #5:<input style="margin-left:20px" type="text" name="VIP5" value=""><br><br>
            <div style="width:100%;align:center"><input type="submit" value="Submit"></div>
        </form>
    </div>
</div>
</body>
</html>