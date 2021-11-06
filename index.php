<?php
ob_start();
include"koneksi.php";
if(!isset($_SESSION['user'])){
    session_start();
}

$pesan= "Welcome";
if(isset($_POST['username'])){
    $user = strip_tags(trim($_POST['username']));
    $pass = strip_tags(trim($_POST['password']));
    $pass1 = sha1($pass);
    if(isset($_POST['remember'])){
      setcookie("username",$user,time() + (3600 * 24));
        setcookie("password",$pass,time() + (3600 * 24));
    }else{
        unset($_COOKIE['username']);
        unset($_COOKIE['password']);
    }
    
    $sql= mysql_query("select * from user where username='$user' and password='$pass'");
    $jml = mysql_num_rows($sql);
    $r= mysql_fetch_array($sql);
    if($jml > 0){
        $_SESSION['nama']=$r['nama'];
        $_SESSION['user']=$r['username'];
        $_SESSION['pass']=$r['password'];
        $_SESSION['level']=$r['level'];
        $_SESSION['email']=$r['email'];
        $_SESSION['foto']=$r['foto'];
        if($r['level']=="admin" or $r['level']=="user"){
            header("location:admin.index.php");
        }else{
            header("location:member/index.php");
        }
        $pesan = "Username dan password valid";
    }else{
        $pesan = "Username dan Password tida valid";
    }
}
   
   if(isset($_POST['rusername'])){
       $rnama = strip_tags(trim($_POST['rnama']));
       $ruser = strip_tags(trim($_POST['rusername']));
       $rpass = strip_tags(trim($_POST['rpassword']));
       $remail = strip_tags(trim($_POST['remail']));
       $rfoto = $_FILES['rfile']['nama'];
       $rsize = $_FILES['rfile']['size'];
       $rsql = mysql_query("select * from user where username='$ruser'");
       $rjml = mysql_num_rows($sql);
       if($rjml > 0){
           ?>
<script>alert('Username <?php echo $ruser; ?> sudah ada'); history.back();</script>
<?php
       }else{
           if(rsize > 2097152){
               ?>
<script>alert('Ukuran foto terlalu besar'); history.back();</script>
<?php
           }else{
               $simpan = mysql_query("insert into user set nama='$rnama', username='$ruser', password='$rpass', ");
                   if($simpan && isset($_FILES['rfile']['name'])){
                       move_uploaded_file($_FILES['rfile']['tmp_name'],"img/".$rfoto);
                   }
           }
       }
   }
   
$limit=30;
if(!isset($_GET['halaman'])){
    $halaman = 1;
    $posisi =0;
}else{
    $halaman=$_GET['halaman'];
    $posisi = ($halaman-1)*$limit;
}
   
if(isset($_GET['sch_cari'])){
    $key = $_GET['sch_cari'];
    if(isset($_GET['kategori'])){
        $kat = $_GET['kategori'];
        $tsql = mysql_query("select * from buku where judul like '%$key%' and kategori like '%$kat%' order by isbn desc limit $posisi,$limit");
    }else{
        $tsql = mysql_query("select * from buku where judul like '%$key%' order by isbn desc limit $posisi,$limit");
    }
}else{
    $tsql = mysqli_query($koneksi,"select * from buku order by isbn desc limit $posisi,$limit");
}
   $jt = mysqli_num_rows($koneksi,$tsql);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome</title>
        <link href="css/default.css" rel="stylesheet">
        <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
        <script src="js/default.js" type="text/javascript"></script>
        <script type="text/javascript">
            function cekpass(){
                var pass = document.getElementById('rpassword').value;
                var pass1 = document.getElementById('rpassword').value;
                var pass2 = document.getElementById('rconfirm').value;
                if(pass.length < 8 && pass1!=pass2){
                    document.getElementById('msgpass').style.color="red";
                    document.getElementById('msgpass').innerHTML="Password must more than 8 character";
                    document.getElementById('rpassword').focus();
                    return false;
                }else if(pass>=8 && pass2.length<0){
                    document.getElementById('msgpass').style.color="green";
                    document.getElementById('msgpass').innerHTML="Password length is good";
                }else if(pass>=8 && pass1!=pass2){
                    document.getElementById('msgpass').style.color="red";
                    document.getElementById('msgpass').innerHTML="Password doesn't match";
                    document.getElementById('rconfirm').focus();
                    return false;
                }else if(pass>=8 && pass1==pass2){
                    document.getElementById('msgpass').style.color="blue";
                    document.getElementById('msgpass').innerHTML="Password accepted";
                }
            }
            
            function cekfile(){
                var filein = document.getElementById('rfile');
                var info = filein.files[0];
                var size = info.size;
                var mbsize = Math.round(size/1048576);
                var kbsize = Math.round(size/1024);
                if(size > 2097152){
                    document.getElementById('msgfile').style.color="red";
                    document.getElementById('msgfile').innerHTML="Your photo size is too large : "+(mbsize)+" mb";
                    document.getElementById('msgfile').focus();
                    return false;
                }else{
                    document.getElementById('msgfile').style.color="blue";
                    document.getElementById('msgfile').innerHTML="Your photo was accepted";
                }
            }
        </script>
    </head>
    <body>
        <span class="top"><img src="img/top.png" class="img-top"></span>
        <div class="login">
            <button type="button" onclick="location.href='index.php'" class="close">X</button>
            <div class="content-login">
                <div class="isi-login" id="top-login">
                    <div class="for-img-user">
                    <img src="img/user.png" class="img-user">
                        </div>
                </div>
                <div class="isi-login" id="bottom-login">
                    <div class="msglogin"></div>
                    <form target="_self" enctype="multipart/form-data" name="login" id="login" method="post">
                        <input type="text" name="username" id="username" placeholder="Username" required value="<?php echo isset($_COOKIE['username'])?$_COOKIE['username']:''; ?>">
                        <input type="password" name="password" id="password" placeholder="Password" required value="<?php echo isset($_COOKIE['password'])?$_COOKIE['password']:''; ?>">
                        <input type="checkbox" name="remember" id="remember"> Remember Me<br>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
         <div class="register">
            <button type="button" onclick="location.href='index.php'" class="close">X</button>
            <div class="content-login">
                <div class="isi-login" id="top-login">
                    <div class="for-img-user">
                    <img src="img/user.png" class="img-user">
                        </div>
                </div>
                <div class="isi-login" id="bottom-login">
                    <form target="_self" enctype="multipart/form-data" name="login" id="login" method="post">
                        <input type="text" name="rnama" id="rnama" placeholder="Nama Lengkap" required>
                        <input type="text" name="rusername" id="rusername" placeholder="Username" required>
                        <input type="password" name="rpassword" id="rpassword" placeholder="Password" required onblur="cekpass();">
                        <input type="password" name="rconfirm" id="rconfirm" placeholder="Confirm Password" required onblur="cekpass();" onfocus="cekpass();">
                        <div id="msgpass"></div><br>
                        <input type="email" name="remail" id="remail" placeholder="Email (Example@email.com)" required onfocus="cekpass();">
                        <label for="file">Pilih Foto</label><br>
                        <input type="file" name="rfile" id="rfile" onblur="cekfile();" onfocus="cekfile();" onchange="cekfile();">
                        <div id="msgfile"></div><br>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <header>
            <div class="header-atas">
                <div class="content-header">
                    <button type="button" class="btn-login">Login</button>
                    <button type="button" class="btn-regis">Register</button>
                </div>
            </div>
            <div class="header-tengah">
                <div class="content-header">
                    <div class="isi-ht" id="ht-satu"><img src="img/logo.png" class="img-logo"></div>
                    <div class="isi-ht" id="ht-dua">
                    <ul>
                        <li>menu1</li>
                        <li>menu2</li>
                        <li>menu3</li>
                        <li>menu4</li>
                        <li>menu5</li>
                    </ul>
                    </div>
                    <div class="isi-ht" id="ht-tiga">
                        <form target="_self" enctype="multipart/form-data" name="cari" id="cari" method="get">
                        <input type="search" name="sch_cari" id="sch_cari" placeholder="Search" onkeyup="this.submit();">
                        <select name="kategori" id="kategori">
                            <option disabled selected></option>
                            <?php
   
   ?>
                        </select>
                    </form>
                    </div>
                </div>
            </div>
            <div class="header-bawah">
                <div class="content-header">
                    <div class="isi-hb" id="hb-satu"></div>
                    <div class="isi-hb" id="hb-dua"></div>
                    <div class="isi-hb" id="hb-tiga"></div>
                    <div class="isi-hb" id="hb-empat"></div>
                    <div class="isi-hb" id="hb-lima"></div>
                    <div class="isi-hb" id="hb-enam"></div>
                </div>
            </div>
        </header>
        <main>
            <div class="content">
                <div class="in-content" id="top-content">
                    <?php
   if($jt > 0){
       while($ft=mysql_fetch_array($tsql)){
   ?>
                    <div class="isi-content">
                        <div class="isi-atas">
                            <img src="img/<?php ?>" class="img-isi-atas">
                        </div>
                        <div class="isi-bawah">
                        </div>
                    </div>
                    <?php
       }
   }
       ?>
                </div>
                <div class="in-content" id="bottom-content">
                    <?php
   $tsql2 = mysql_query("select * from buku");
   $jt2 = mysql_num_rows($tsql2);
   $jhal = ceil($jt2/$limit);
   if($halaman > 1){
       $prev = $halaman -1;
       echo"<a href='$_SERVER[PHP_SELF]?halaman=$prev'><< Prev</a>";
   }else{
       echo"<span class='page' current><< Prev</span>";
   }
   
for ($i=1;$i<=$jhal;$i++)
   if($i!=$halaman){
       echo"<a href='$_SERVER[PHP_SELF]?halaman=$i'>$i</a>";
   }else{
       echo"<span class='page' current>$i</span>";
   }
   
   if($halaman < $jhal){
       $next = $halaman+1;
       echo "<a href='$_SERVER[PHP_SELF]?halaman=$next'>Next >></a>";
   }else{
       echo"<span class='page' current >Next >></span>";
   }
   ?>
                </div>
            </div>
        </main>
        <footer>
            <div class="footer-atas">
                <div class="cf-atas">
                    <div class="isi-fa" id="fa-satu">
                        <div class="isi-fs" id="fs-satu"></div>
                        <div class="isi-fs" id="fs-dua"></div>
                        <div class="isi-fs" id="fs-tiga"></div>
                    </div>
                </div>
            </div>
            <div class="footer-bawah">
                <div class="cf-bawah"></div>
            </div>
        </footer>
    </body>
</html>
<?php
mysql_close($koneksi);
ob_flush();
?> 