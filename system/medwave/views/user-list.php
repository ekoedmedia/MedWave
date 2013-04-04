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
    <title>MedWave | User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
    <link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="media/js/jquery.min.js"></script>
    <script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="media/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() { 
            $("[rel='date']").datepicker();
        });
    </script>
</head>
<body >
    <header class="header">
        <?php include '_base/auth.header.php'; ?>
    </header>
    <div class="container-extra-wide">   
        <ul class="nav nav-tabs">
            <li><a href="./user.add"><i class="icon-plus-sign"></i> Add User</a></li>
            <li class="pull-right"><a href="./analysis">Data Analysis</a></li>
            <li class="pull-right"><a href="./report-gen">Report Generating</a></li>
            <li class="pull-right active"><a href="./user-list">Manage Users</a></li>
        </ul>
        <ul class="nav nav-pills">
            <li class="active"><a href="./user-list">User List</a></li>
            <li><a href="./doctor-list">Doctor List</a></li>
        </ul>

        <div class="users" id="user-list">
            <?php include "_users/user.list.php"; ?>
        </div>
    </div>
    <footer class="footer">
        <?php include '_base/auth.footer.php'; ?>
    </footer>
</body>

</html>