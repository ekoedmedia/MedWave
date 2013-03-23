<?php

/****************************\
 By: Jeremy Smereka
     Amir Salimi
 ----------------------------
 User Controller
 Provides Authentication,
 User Updating, and User
 Creation.
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
        public function authenticate() {
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
                    $sql = "SELECT * FROM users WHERE user_name=:username AND password=:password"; ##TODO: Change query to join with persons table
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();
                    // If count is 0, then throw an error
                    if ($stmt->rowCount() == 0) {
                        $_SESSION['error'] = serialize($error_1001);
                        header("Location: /".$this->getBaseDir()."/");
                    } else {
                        // Get the result and head to destination
                        $result = $stmt->fetch(\PDO::FETCH_LAZY);
                        $_SESSION['logged'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $result->class;
                        header("Location: /".$this->getBaseDir()."/".$this->getDestination());
                    }
                }
            }
        }

        /**
         * Takes in User Object and persists to 
         * database provided the data is pertinent to it.
         */
        public function updateData() {}

        /**
         * Creates User from a User Object
         * that is persisted to the database.
         */
        public function createUser() {}

        /**
         * Destroys User session so that
         * they are no longer logged in.
         */
        public function unauthenticate() {
            session_destroy();
            session_start();
            $success = new SuccessModel('Authentication', 'You were successfully logged out.');
            $_SESSION['success'] = serialize($success);
            header("Location: /".$this->getBaseDir()."/");
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
