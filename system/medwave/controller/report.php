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

    class Report {

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
        public function generate() {
            $error_1000 = new ErrorModel('Authentication', '1000', 'some fields are blank left blank.');
                
         
            // Checks if post values are set.
            if (!isset($_POST['From']) || !isset($_POST['To']) || !isset($_POST[diagnosis])) {
                $_SESSION['error'] = serialize($error_1000);
                header("Location: /".$this->getBaseDir()."/");
            } else {
                $from = $_POST['From'];
                $to = $_POST['To'];
                $diagnosis=$_POST['diagnosis'];
                // Testing if trimmed input is valid
                if (trim($diagnosis) == "" ) {
                    $_SESSION['error'] = serialize($error_1000);
                    header("Location: /".$this->getBaseDir()."/");
                } else {
                    // Querying of Database to See if User Exists
                    $sql = "SELECT p.first_name As nameF, p.last_name As nameL, p.address As address, r.diagnosis As diagnosis
                            FROM   persons p INNER JOIN radiology_record r         
                            ON p.user_name = r.patient_name 
                            WHERE r.diagnosis=:diagnosis AND r.prescribing_date BETWEEN :From AND :To "; 
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':diagnosis', $diagnosis);
                    $stmt->bindParam(':From', $from);
                    $stmt->bindParam(':To',$to);
                    $stmt->execute();
                    // If count is 0, then throw an error

                    if ($stmt->rowCount() == 0) {
                         $_SESSION['error'] = serialize($error_1001);
                         header("Location: /".$this->getBaseDir()."/");
                     } else {
                        // Get the result and head to destination
                        try{
                            while($result = $stmt->fetch(\PDO::FETCH_LAZY)){
                                print "<tr> ";
                                print  "<td><div>".$result->nameF." ".$result->nameL."</div></td>
                                <td><div>".$result->address."</div></td>
                                <td><div>".$result->diagnosis."</div></td>";
                                print " </tr>";

                            }
                            }catch(\PDOException $e) {
                                print $e->getMessage();
                            }
                                
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
            print "2";
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
