<?php

/****************************\
 By: Jeremy Smereka
     Amir Salimi
 ----------------------------
 User Controller
 Provides Authentication,
 User Updating, and User
 Creation and removal

 doctor removal
\****************************/

namespace MedWave\Controller {

    use MedWave\Model\User as UserModel;
    use MedWave\Model\Error as ErrorModel;
    use MedWave\Model\Success as SuccessModel;

    class User {

        protected $destination;
        protected $dbHandle;
        protected $baseDir;

        /**
         * Construction executes Dynamic Function
         * @var String cmd 
         * @var String destination
         * @var Object SQLite
         */
        public function __construct($cmd, $destination = null, &$dbHandle, $baseDir)
        {
            $this->setBaseDir($baseDir);
            $this->setDestination($destination);
            $this->dbHandle = $dbHandle;
            if (method_exists($this, $cmd)){
                $this->$cmd(); //Dynamic Function Calling
            } else {
                throw new \InvalidArgumentException("Method $cmd() does not exist in object ".get_class($this));
            }
        }

        /**
         * Returns TRUE or FALSE depending on 
         * if authentication is successful based
         * on variables passed into function.
         */
        public function authenticate() 
        {
            $error_1000 = new ErrorModel('Authentication', '1000', 'Username and/or Password left blank.');
            $error_1001 = new ErrorModel('Authentication', '1001', 'Username and/or Password incorrect or User does not exist.');

            // Checks if post values are set.
            if (!isset($_POST['user_name']) || !isset($_POST['password'])) {
                $_SESSION['error'] = serialize($error_1000);
                header("Location: /".$this->getBaseDir()."/");
            } else {
                $username = $_POST['user_name'];
                $password = $_POST['password'];
                // Testing if trimmed input is valid
                if (trim($username) == "" || trim($password) == "") {
                    $_SESSION['error'] = serialize($error_1000);
                    header("Location: /".$this->getBaseDir()."/");
                } else {
                    // Querying of Database to See if User Exists
                    $sql = "SELECT COUNT(*) AS count, class, user_name FROM users WHERE user_name=:username AND password=:password"; 
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();
                    $results = $stmt->fetch(\PDO::FETCH_LAZY);

                    // If count is 0, then throw an error
                    if ($results->count != 1) {
                        $_SESSION['error'] = serialize($error_1001);
                        header("Location: /".$this->getBaseDir()."/");
                    } else {
                        // Get the result and head to destination
                        $_SESSION['logged'] = true;
                        $_SESSION['username'] = $results->user_name;
                        $_SESSION['role'] = $results->class;
                        header("Location: /".$this->getBaseDir()."/".$this->getDestination());
                    }
                }
            }
        }

        /**
         * Add Family Doctor
         */
        public function addDoctor()
        {
            $this->authCheck(); // Check if Authenticated
            $error_10000 = new ErrorModel('Add Doctor', '10000', 'Doctor or Patient left blank');
            $error_10001 = new ErrorModel('Add Doctor', '10001', 'Doctor is already Family Doctor of Patient');
            $success = new SuccessModel('Add Doctor', 'Successfully added Family Doctor');

            if (!isset($_POST['patient']) || !isset($_POST['doctor'])) {
                $_SESSION['error'] = serialize($error_10000);
                header("Location: /".$this->getBaseDir()."/doctor.add");
            } else {
                $sql = "SELECT COUNT(*) AS count FROM family_doctor WHERE patient_name=:patient AND doctor_name=:doctor";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(":doctor" => $_POST['doctor'], ":patient" => $_POST['patient']));
                $result = $stmt->fetch(\PDO::FETCH_LAZY);
                if ($result->count != 0){
                    $_SESSION['error'] = serialize($error_10001);
                    header("Location: /".$this->getBaseDir()."/doctor.add");
                } else {
                    $sql = "INSERT INTO family_doctor (doctor_name, patient_name) VALUES (:doctor, :patient)";
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->execute(array(":doctor" => $_POST['doctor'],
                                         ":patient" => $_POST['patient']));
                    $_SESSION['success'] = serialize($success);
                    header("Location: /".$this->getBaseDir()."/".$this->getDestination());
                }
            }
        }

        /**
         * Removes user from account list
         */
        public function removeFamilyDoctor()
        {
            $this->authCheck(); // Check if Authenticated
            $error_11000 = new ErrorModel('RemoveFamilyDoctor', '11000', 'User not valid.');
            $success = new SuccessModel('RemoveFamilyDoctor', 'Successfully removed the user: '.$_POST['user']);

            // Checks if is valid, and is not current user
            if (!isset($_POST['patient']) || !isset($_POST['doctor'])){
                $_SESSION['error'] = serialize($error_11000);
                header("Location: /".$this->getBaseDir()."/doctor.add");
            } else {
                $sql = "DELETE FROM family_doctor WHERE patient_name=:patient AND doctor_name=:doctor";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(":patient" => $_POST['patient'], ":doctor" => $_POST['doctor']));

                $_SESSION['success'] = serialize($success);
                header('Location: /'.$this->getBaseDir().'/'.$this->getDestination());
            }
        }

        /**
         * Add User
         */
        public function addUser()
        {
            
            $this->authCheck(); // Check if authenticated
            $error_4000 = new ErrorModel('addUser', '4000', 'First Name exceeds maximum length of 24 characters.');
            $error_4001 = new ErrorModel('addUser', '4001', 'Last Name exceeds maximum length of 24 characters.');
            $error_4002 = new ErrorModel('addUser', '4002', 'Address exceeds maximum length of 128 characters.');
            $error_4003 = new ErrorModel('addUser', '4003', 'Email exceeds maximum length of 128 characters.');
            $error_4004 = new ErrorModel('addUser', '4004', 'Email not in valid format: user@domain.com');
            $error_4005 = new ErrorModel('addUser', '4005', 'Phone number has maximum length of 10 digits.');
            $error_4006 = new ErrorModel('addUser', '4006', 'Email is already registered.');
            $error_4006 = new ErrorModel('addUser', '4007', 'User already registered.');
            $success = new SuccessModel('addUser', 'You have added the account successfully.');            

            $sql = "SELECT COUNT(*) AS count FROM persons WHERE email=:email AND user_name<>:user";
            $stmt = $this->dbHandle->prepare($sql);
            $stmt->execute(array(':email' => $_POST['email'],
                                 ':user' => $_POST['username']));
            $results = $stmt->fetch(\PDO::FETCH_LAZY);

            // First Name length check
            if ($_POST['fname'] != "" && strlen(trim($_POST['fname'])) > 24) {
                $_SESSION['error'] = serialize($error_4000);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Last Name length check
            } elseif ($_POST['lname'] != "" && strlen(trim($_POST['lname'])) > 24) {
                $_SESSION['error'] = serialize($error_4001);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Address length check
            } elseif ($_POST['address'] != "" && strlen(trim($_POST['address'])) > 128) {
                $_SESSION['error'] = serialize($error_4002);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Email length check
            } elseif ($_POST['email'] != "" && strlen(trim($_POST['email'])) > 128) {
                $_SESSION['error'] = serialize($error_4003);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Phone number length & valid check
            } elseif ($_POST['phone'] != "" && (strlen(trim($_POST['phone'])) > 10 || !is_numeric($_POST['phone']))) {
                $_SESSION['error'] = serialize($error_4005);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Email valid check
            } elseif ($_POST['email'] != "" && !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = serialize($error_4004);
                header("Location: /".$this->getBaseDir()."/user.add");
            } elseif ($results->count > 0) {
                $_SESSION['error'] = serialize($error_4006);
                header("Location: /".$this->getBaseDir()."/user.add");
            // Everything is good, insert or update db
            } else {
                $sql = "SELECT COUNT(*) AS count FROM persons WHERE user_name=:name";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(':name' => $_POST['username']));
                $results = $stmt->fetch(\PDO::FETCH_LAZY);
                if ($results->count == 1){
                    $_SESSION['error'] = serialize($error_4007);
                    header("Location: /".$this->getBaseDir()."/user.add");
                } else {
                    $sql = "INSERT INTO users (user_name, password, class, date_registered) VALUES (:username, :password, :class, :date_registered)";
                    $stmt = $this->dbHandle->prepare($sql);
                    $date = strtotime($_POST['date_registered']);
                    $stmt->execute(array(":class" => $_POST['role'],
                                         ":password" => $_POST['password'],
                                         ":username" => $_POST['username'],
                                         ":date_registered" => date("Y-m-d", $date)));

                    $sql = "INSERT INTO persons (first_name, last_name, address, email, phone, user_name) VALUES (:fname, :lname, :address, :email, :phone, :name)";
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':fname', $_POST['fname']);
                    $stmt->bindParam(':lname', $_POST['lname']);
                    $stmt->bindParam(':address', $_POST['address']);
                    $stmt->bindParam(':email', $_POST['email']);
                    $stmt->bindParam(':phone', $_POST['phone']);
                    $stmt->bindParam(':name', $_POST['username']);
                    $stmt->execute();

                    $_SESSION['success'] = serialize($success);
                    header("Location: /".$this->getBaseDir()."/".$this->getDestination());
                }
            }
        }
        
        /**
         * Takes user input and stores it into the database.
         */
        public function updateUser() 
        {
            $this->authCheck(); // Check if authenticated

            $error_4000 = new ErrorModel('UpdatePerson', '4000', 'First Name exceeds maximum length of 24 characters.');
            $error_4001 = new ErrorModel('UpdatePerson', '4001', 'Last Name exceeds maximum length of 24 characters.');
            $error_4002 = new ErrorModel('UpdatePerson', '4002', 'Address exceeds maximum length of 128 characters.');
            $error_4003 = new ErrorModel('UpdatePerson', '4003', 'Email exceeds maximum length of 128 characters.');
            $error_4004 = new ErrorModel('UpdatePerson', '4004', 'Email not in valid format: user@domain.com');
            $error_4005 = new ErrorModel('UpdatePerson', '4005', 'Phone number has maximum length of 10 digits.');
            $error_4006 = new ErrorModel('UpdatePerson', '4006', 'Email is already registered.');
            $success = new SuccessModel('UpdatePerson', 'You have updated '.$_POST["username"].'\'s account information successfully.');

            $sql = "SELECT COUNT(*) AS count FROM persons WHERE email=:email AND user_name<>:user";
            $stmt = $this->dbHandle->prepare($sql);
            $stmt->execute(array(':email' => $_POST['email'],
                                 ':user' => $_POST['username']));
            $results = $stmt->fetch(\PDO::FETCH_LAZY);

            // First Name length check
            if ($_POST['fname'] != "" && strlen(trim($_POST['fname'])) > 24) {
                print $error_4000->getMessage();
            // Last Name length check
            } elseif ($_POST['lname'] != "" && strlen(trim($_POST['lname'])) > 24) {
                print $error_4001->getMessage();
            // Address length check
            } elseif ($_POST['address'] != "" && strlen(trim($_POST['address'])) > 128) {
                print $error_4002->getMessage();
            // Email length check
            } elseif ($_POST['email'] != "" && strlen(trim($_POST['email'])) > 128) {
                print $error_4003->getMessage();
            // Phone number length & valid check
            } elseif ($_POST['phone'] != "" && (strlen(trim($_POST['phone'])) > 10 || !is_numeric($_POST['phone']))) {
                print $error_4005->getMessage();
            // Email valid check
            } elseif ($_POST['email'] != "" && !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                print $error_4004->getMessage();
            } elseif ($results->count > 0) {
                print $error_4006->getMessage();
            // Everything is good, insert or update db
            } else {
                $sql = "SELECT COUNT(*) AS count FROM persons WHERE user_name=:name";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(':name' => $_POST['username']));
                $result = $stmt->fetch(\PDO::FETCH_LAZY);
                if ($result->count == 1){
                    $sql = "UPDATE persons SET first_name=:fname, last_name=:lname, address=:address, email=:email, phone=:phone WHERE user_name=:name";
                } else {
                    $sql = "INSERT INTO persons (first_name, last_name, address, email, phone, user_name) VALUES (:fname, :lname, :address, :email, :phone, :name)";
                }
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->bindParam(':fname', $_POST['fname']);
                $stmt->bindParam(':lname', $_POST['lname']);
                $stmt->bindParam(':address', $_POST['address']);
                $stmt->bindParam(':email', $_POST['email']);
                $stmt->bindParam(':phone', $_POST['phone']);
                $stmt->bindParam(':name', $_POST['username']);
                $stmt->execute();

                $sql = "UPDATE users SET password=:password, date_registered=:date_registered
                WHERE user_name=:username";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(":password"=>$_POST['password'],
                                     ":username"=>$_POST['username'],
                                     ":date_registered"=>urldecode($_POST['date_registered'])));


                print $success->getMessage();
            }



        }

        /**
         * Update Person information (via account page)
         */
        public function updatePerson() 
        {
            $this->authCheck(); // Check if authenticated

            $error_4000 = new ErrorModel('UpdatePerson', '4000', 'First Name exceeds maximum length of 24 characters.');
            $error_4001 = new ErrorModel('UpdatePerson', '4001', 'Last Name exceeds maximum length of 24 characters.');
            $error_4002 = new ErrorModel('UpdatePerson', '4002', 'Address exceeds maximum length of 128 characters.');
            $error_4003 = new ErrorModel('UpdatePerson', '4003', 'Email exceeds maximum length of 128 characters.');
            $error_4004 = new ErrorModel('UpdatePerson', '4004', 'Email not in valid format: user@domain.com');
            $error_4005 = new ErrorModel('UpdatePerson', '4005', 'Phone number has maximum length of 10 digits.');
            $error_4006 = new ErrorModel('UpdatePerson', '4006', 'Email is already registered.');
            $success = new SuccessModel('UpdatePerson', 'You have updated your account information successfully.');

            $sql = "SELECT COUNT(*) AS count FROM persons WHERE email=:email AND user_name<>:user";
            $stmt = $this->dbHandle->prepare($sql);
            $stmt->execute(array(':email' => $_POST['email'],
                                 ':user' => $_SESSION['username']));
            $results = $stmt->fetch(\PDO::FETCH_LAZY);

            // First Name length check
            if ($_POST['fname'] != "" && strlen(trim($_POST['fname'])) > 24) {
                $_SESSION['error'] = serialize($error_4000);
                header("Location: /".$this->getBaseDir()."/account");
            // Last Name length check
            } elseif ($_POST['lname'] != "" && strlen(trim($_POST['lname'])) > 24) {
                $_SESSION['error'] = serialize($error_4001);
                header("Location: /".$this->getBaseDir()."/account");
            // Address length check
            } elseif ($_POST['address'] != "" && strlen(trim($_POST['address'])) > 128) {
                $_SESSION['error'] = serialize($error_4002);
                header("Location: /".$this->getBaseDir()."/account");
            // Email length check
            } elseif ($_POST['email'] != "" && strlen(trim($_POST['email'])) > 128) {
                $_SESSION['error'] = serialize($error_4003);
                header("Location: /".$this->getBaseDir()."/account");
            // Phone number length & valid check
            } elseif ($_POST['phone'] != "" && (strlen(trim($_POST['phone'])) > 10 || !is_numeric($_POST['phone']))) {
                $_SESSION['error'] = serialize($error_4005);
                header("Location: /".$this->getBaseDir()."/account");
            // Email valid check
            } elseif ($_POST['email'] != "" && !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = serialize($error_4004);
                header("Location: /".$this->getBaseDir()."/account");
            } elseif ($results->count > 0) {
                $_SESSION['error'] = serialize($error_4006);
                header("Location: /".$this->getBaseDir()."/account");
            // Everything is good, insert or update db
            } else {
                $sql = "SELECT COUNT(*) AS count FROM persons WHERE user_name=:name";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(':name' => $_SESSION['username']));
                $result = $stmt->fetch(\PDO::FETCH_LAZY);
                if ($result->count == 1){
                    $sql = "UPDATE persons SET first_name=:fname, last_name=:lname, address=:address, email=:email, phone=:phone WHERE user_name=:name";
                } else {
                    $sql = "INSERT INTO persons (first_name, last_name, address, email, phone, user_name) VALUES (:fname, :lname, :address, :email, :phone, :name)";
                }
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->bindParam(':fname', $_POST['fname']);
                $stmt->bindParam(':lname', $_POST['lname']);
                $stmt->bindParam(':address', $_POST['address']);
                $stmt->bindParam(':email', $_POST['email']);
                $stmt->bindParam(':phone', $_POST['phone']);
                $stmt->bindParam(':name', $_SESSION['username']);
                $stmt->execute();

                $_SESSION['success'] = serialize($success);

                header("Location: /".$this->getBaseDir()."/".$this->getDestination());
            }

        }

        /**
         * Changes account password.
         */
        public function changePassword()
        {
            $this->authCheck(); // Check if Authenticated

            $error_5000 = new ErrorModel('PasswordChange', '5000', 'One or more fields left blank.');
            $error_5001 = new ErrorModel('PasswordChange', '5001', 'New Password does not match Confirm Passowrd.');
            $error_5002 = new ErrorModel('PasswordChange', '5002', 'Old Password is not correct.');
            $success = new SuccessModel('PasswordChange', 'Password successfully updated.');

            $sql = "SELECT password FROM users WHERE user_name=:name";
            $stmt = $this->dbHandle->prepare($sql);
            $stmt->execute(array(":name" => $_SESSION['username']));

            $results = $stmt->fetch(\PDO::FETCH_LAZY);
            
            // Check if any are blank.
            if (trim($_POST['old_password']) == "" || trim($_POST['new_password']) == "" || trim($_POST['confirm_password']) == "") {
                $_SESSION['error'] = serialize($error_5000);
                header("Location: /".$this->getBaseDir()."/account");
            // Check if New Password = Confirm Password
            } elseif (trim($_POST['new_password']) != trim($_POST['confirm_password'])) {
                $_SESSION['error'] = serialize($error_5001);
                header("Location: /".$this->getBaseDir()."/account");
            // Check if Old Password is Correct
            } elseif (trim($_POST['old_password']) != $results->password) {
                $_SESSION['error'] = serialize($error_5002);
                header("Location: /".$this->getBaseDir()."/account");
            } else {
                $sql = "UPDATE users SET password=:password WHERE user_name=:name";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(":password" => trim($_POST['confirm_password']), ":name" => $_SESSION['username']));

                $_SESSION['success'] = serialize($success);

                header("Location: /".$this->getBaseDir()."/".$this->getDestination());
            }
        }

        /**
         * Destroys User session so that
         * they are no longer logged in.
         */
        public function unauthenticate() 
        {
            session_destroy();
            session_start();
            $success = new SuccessModel('Authentication', 'You were successfully logged out.');
            $_SESSION['success'] = serialize($success);
            header("Location: /".$this->getBaseDir());
        }


        /**
         * Makes sure user is logged in
         * if they are not it redirects the user
         * to the sites base directory.
         */
        private function authCheck()
        {
            if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
                session_destroy();
                session_start();
                $baseDir = $core->getBaseDir();
                $error = new ErrorModel('Authentication', '1002', 'You are not authenticated.');
                $_SESSION['error'] = serialize($error);
                header("Location: /".$baseDir);
            }
        }

        /***************************\
         Getter and Setter Functions
        \***************************/

        /**
         * Sets Destination URL
         */
        public function setBaseDir($baseDir)
        {
            $this->baseDir = $baseDir;
        }

        /**
         * Gets Destintation URL
         * @return String destination
         */
        public function getBaseDir()
        {
            return $this->baseDir;
        }

        /**
         * Sets Destination URL
         */
        public function setDestination($destination)
        {
            $this->destination = $destination;
        }

        /**
         * Gets Destintation URL
         * @return String destination
         */
        public function getDestination()
        {
            return $this->destination;
        }

    }

}
