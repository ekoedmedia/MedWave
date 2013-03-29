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
            <div class="users">
                <?php include "_users/list.php"; ?>
            </div>
        </div>
    </div>
    <div id="">
                <select id="tableType" width="1000"  STYLE="width: 200px" onchange="changeTable();">
                        <option >Users</option>
                        <option >Persons</option>
                        <option >Doctors</option>
                                
            </div>
    <footer class="footer">
        <?php include '_base/auth.footer.php'; ?>
    </footer>
<script>
    function changeTable(){
        var tableType=document.getElementById("tableType");
        var ttype=tableType.options[tableType.selectedIndex].value;
        var xmlhttp;
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
            }
        }
        if (ttype=="persons"){
            xmlhttp.open("POST","persons.php",true);
         
            xmlhttp.send(""); 
       }
        if (ttype=="users"){
            xmlhttp.open("POST","persons.php",true);
            xmlhttp.send(""); 
       }
        if (ttype=="Doctors"){

            xmlhttp.open("POST","doctor-list.php",true);            
            //xmlhttp.send("?CMD=updateUser&name="+document.getElementById("nameInput").value+"&lastName="+document.getElementById("lastNameInput").value); 
       }
    }
</script>
</body>

</html>o