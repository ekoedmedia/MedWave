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

    class Upload {

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
        public function upload() {
            $error_3000 = new ErrorModel('Report', '3000', 'Some fields are blank left blank.');
                
            // Checks if post values are set.
            if (!isset($_POST["record_id"])) {
                $_SESSION['error'] = serialize($error_3000);
                header("Location: /".$this->getBaseDir()."/");
            } else {
            $record_id=$_POST["record_id"]  ;
            $patient =$_POST["patient"];
            $doctor_name=$_POST["doctor_name"];
            $radiologist_name=$_POST["radiologist_name"];
            $test_type=$_POST["test_type"];
            $prescribing_date=strtotime($_POST["prescribing_date"]);
            $test_date=strtotime($_POST["test_date"]);
            $diagnosis=$_POST["diagnosis"];
            $description=$_POST["description"];
            //$upload=$_POST["upload"];
            
                // Testing if trimmed input is valid
                if (trim($record_id == "") ) {
                    $_SESSION['error'] = serialize($error_3000);
                    header("Location: /".$this->getBaseDir()."/");
                } else {
                    // Querying of Database to See if User Exists
                    $sql = "INSERT INTO radiology_record
                            (record_id,patient_name,doctor_name,radiologist_name,test_type,
                                    prescribing_date,test_date,diagnosis,description)
                            VALUES (:record_id,:patient_name,:doctor_name,:radiologist_name,:test_type,
                                    :prescribing_date,:test_date,:diagnosis,:description)"; 
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':record_id',$record_id);
                    $stmt->bindParam(':patient_name',$patient);
                    $stmt->bindParam(':doctor_name',$doctor_name);
                    $stmt->bindParam(':radiologist_name',$radiologist_name);
                    $stmt->bindParam(':prescribing_date',$prescribing_date);
                    $stmt->bindParam(':test_type',$test_type);
                    $stmt->bindParam(':diagnosis',$diagnosis);
                    $stmt->bindParam(':test_date',$test_date);                    
                    $stmt->bindParam(':description',$description);
                    try {
                    $stmt->execute();
                    } catch (\Exception $e) {
                        print $e->getMessage();
                    }

                     var_dump($_FILES);
                     print "<br>";
                     // die();
                    $result = count($_FILES["uploadedfile"]["name"])-1;
                    for($result;$result>=0;$result--){
                        print "<br>";
                        print "filenumber".$result;
                        print "<br>";
                        print $_FILES["uploadedfile"]["tmp_name"][$result]."    ".$_FILES["uploadedfile"]["name"][$result];
                         //values(12,1,null,null,null)
                        $sql="INSERT INTO pacs_images(record_id,image_id,thumbnail,regular_size,full_size) 
                        values(:record_id,:record_id,:regular_size,:regular_size,:regular_size)";
                        $img =addslashes (file_get_contents($_FILES["uploadedfile"]["tmp_name"][$result]));
                        $stmt = $this->dbHandle->prepare($sql);
                        $stmt->bindParam(':record_id',$record_id);
                        $stmt->bindParam(':regular_size',$img);
                        print $record_id;
                        try {
                            $stmt->execute();
                        } catch (\Exception $e) {
                                print $e->getMessage();
                        }
 
                    }


                     // If count is 0, then throw an error
                   
                    
                   
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
//            print "2";
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
