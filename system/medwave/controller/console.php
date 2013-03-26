<?php

/****************************\
 By: Jeremy Smereka
     Amir Salimi
 ----------------------------
 Console Controller
 Provides Authentication,
 User Updating, and User
 Creation.
\****************************/

namespace MedWave\Controller {

    use MedWave\Model\User as UserModel;
    use MedWave\Model\Error as ErrorModel;
    use MedWave\Model\Success as SuccessModel;

    class Console {

        protected $dbHandle;
        protected $fp;
        protected $colors;

        /**
         * Construction executes Dynamic Function
         * @var String cmd 
         * @var String destination
         * @var Object SQLite
         */
        public function __construct(&$dbHandle, &$fp, $colors)
        {
            $this->dbHandle = $dbHandle;
            $this->fp = $fp;
            $this->colors = $colors;
        }


        /**
         * Prompts for Username, Password, and Role to create a new User
         */
        public function createUser() 
        {
            print "\n";
            print $this->colors->colorString("Desired User Name (Max 24): ", 'white', null);
            $name = $this->promptName(); // Prompts for Username
            print $this->colors->colorString("Desired Password (Max 24): ", 'white', null);
            $pass = $this->promptPassword(); // Prompts for Password
            print $this->colors->colorString("Desired Role (p, a, d, r): ", 'white', null);
            $role = $this->promptRole(); // Prompts for Role

            // Insert User into Database
            $sql = "INSERT INTO users (user_name, password, class, date_registered) VALUES (:name, :pass, :class, now())";
            $stmt = $this->dbHandle->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':class', $role);
            $stmt->execute();

            print "\nA user with the credentials:";
            print "\n\nUsername: ".$name."\nPassword: ".$pass."\nRole: ".$role."\n";
            print "\nhas been created and may now login.\n\n";

            exit(0);
        }


        /**
         * Installs database from SQL file
         */
        public function installDatabase()
        {
            print "\n";
            print $this->colors->colorString("!!!WARNING!!!\nUsing this command will destroy the database if it is already created!\nProceed with caution.", 'white', 'red');
            print "\n\nType YES to proceed, or exit to stop.\n";
            while (empty($confirm)) {
                $confirm = fgets($this->fp, 1024);
                if ($confirm == "exit\n") {
                    exit(0);
                } elseif ($confirm != "YES\n") {
                    $confirm = null;
                    print "Invalid, please try again: ";
                }
            }

            // Database Installation
            $sql = file_get_contents("system/setup.sql");
            try {
                $this->dbHandle->exec($sql);
            } catch (\Exception $e) {
                print $e->getMessage();
            }

            print "\n\nDatabase has been successfully installed.\n";
            exit(0);
        }

        /******************************\
                Private Functions
        \******************************/


        ##TODO: Put in checks for User accounts with that nane
        /**
         * Prompts user for username
         * @return string Name
         */
        private function promptName()
        {
            while (empty($name)) {
                $name = fgets($this->fp, 1024);
                // Remove newline and check length
                $name = str_replace(array("\r", "\r\n", "\n"), '', $name);    
                if (strlen($name) > 24 || strlen($name) == 0){
                    $name = null;
                    print $this->colors->colorString("Error: User Name must be maximum 24 characters long.", 'black', 'red');
                    print $this->colors->colorString("\nTry Again: ", 'white', null);
                } elseif (!preg_match('/^[a-z0-9_-]{3,24}$/i', $name)) {
                    $name = null;
                    print $this->colors->colorString("Error: User Name must contain Alphanumeric characters and underscores only.", 'black', 'red');
                    print $this->colors->colorString("\nTry Again: ", 'white', null);
                }
            }
            return $name;
        }


        /**
         * Prompts user for password
         * @return string password
         */
        private function promptPassword()
        {
            while (empty($pass)) {
                $pass = fgets($this->fp, 1024);
                // Remove newline and check length
                $pass = str_replace(array("\r", "\r\n", "\n"), '', $pass);    
                if (strlen($pass) > 24 || strlen($pass) == 0){
                    $pass = null;
                    print $this->colors->colorString("Error: User Password must be maximum 24 characters long.", 'black', 'red');
                    print $this->colors->colorString("\nTry Again: ", 'white', null);
                }
            }
            return $pass;
        }


        /**
         * Prompts user for role
         * @return char role
         */
        private function promptRole()
        {
            while (empty($role)) {
                $role = fgets($this->fp, 1024);
                // Remove newline and check length
                $role = str_replace(array("\r", "\r\n", "\n"), '', $role);    
                if (!preg_match('/^[adpr]$/', $role)) {
                    $role = null;
                    print $this->colors->colorString("Error: Role can only be one of: a, d, p, r", 'black', 'red');
                    print $this->colors->colorString("\nTry Again: ", 'white', null);
                }
            }
            return $role;
        }

    }

}
