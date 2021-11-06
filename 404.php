<!doctype html>
<html lang="en">
    <head>
        <title>Welcome admin</title>
    </head>
    <body>
        peritangatan anda harus berstatus <?php echo isset ($_GET['level']?$_GET['level']:'administrator'); ?>
    </body>
</html>