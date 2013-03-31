<?php include "_base/check.auth.php"; ?>
<?php 
    switch ($role) {
        case 'p':
        case 'd':
        case 'r':
            $error = new MedWave\Model\Error('Authenitcation', '1004', 'Invalid Permissions to view User Management Page');
            $_SESSION['error'] = serialize($error);
            header('Location: /'.$core->getBaseDir().'/home');
            break;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="media/js/jquery.min.js"></script>
</head>
<body >
    <header class="header">
        <?php include '_base/auth.header.php'; ?>
    </header>
    <div class="content">   
        <div class="content-wrapper">
            <div class="content-header">
                <a href="./user-add" class="btn">Add User</a>
            </div>
            <div class="users" id="user-list">
                <?php include "_users/user.list.php"; ?>
            </div>
            <div class="tableChange">
                <a href="./doctor-list">Doctor List</a>  
            </div>
        </div>
    </div>
    <footer class="footer">
        <?php include '_base/auth.footer.php'; ?>
    </footer>
</body>

</html>