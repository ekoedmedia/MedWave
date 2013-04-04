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
            $this->authCheck(); // Check if authenticated
            
            $error_7000 = new ErrorModel('Upload', '7000', 'Some fields are blank left blank.');
            $error_7001 = new ErrorModel('Upload', '7001', 'Record ID is already in database.');
            $error_7002 = new ErrorModel('Upload', '7002', 'Error uploading files, please try again.');
            $success = new SuccessModel('Upload', 'Successfully added Radiology Record to Database.');
            
            // Checks if post record id is set.
            if (!isset($_POST["record_id"]) || empty($_POST['record_id']) || trim($_POST['record_id']) == "") {
                $_SESSION['error'] = serialize($error_7000);
                header("Location: /".$this->getBaseDir()."/uploading-module");
            } else {
                $record_id = trim($_POST["record_id"]);
                $sql = "SELECT record_id FROM radiology_record WHERE record_id=:id";
                $stmt = $this->dbHandle->prepare($sql);
                $stmt->execute(array(":id" => $record_id));
                $result = $stmt->rowCount();

                // Check if record id already exists in Database
                if ($result == 1) {
                    $_SESSION['error'] = serialize($error_7001);
                    header("Location: /".$this->getBaseDir()."/uploading-module");
                } else {

                    $patient = $_POST["patientName"];
                    $doctor_name = $_POST["doctorName"];
                    $radiologist_name = $_POST["radiologistName"];
                    $test_type = $_POST["test_type"];
                    $prescribing_date = date("Y-m-d", strtotime($_POST["prescribing_date"]));
                    $test_date = date("Y-m-d", strtotime($_POST["test_date"]));
                    $diagnosis = $_POST["diagnosis"];
                    $description = $_POST["description"];
            
                    // Insert of Record into Database
                    $sql = "INSERT INTO radiology_record
                            (record_id,patient_name,doctor_name,radiologist_name,test_type,
                                    prescribing_date,test_date,diagnosis,description)
                            VALUES (:record_id,:patient_name,:doctor_name,:radiologist_name,:test_type,
                                    :prescribing_date,:test_date,:diagnosis,:description)"; 
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':record_id', $record_id);
                    $stmt->bindParam(':patient_name', $patient);
                    $stmt->bindParam(':doctor_name', $doctor_name);
                    $stmt->bindParam(':radiologist_name', $radiologist_name);
                    $stmt->bindParam(':prescribing_date', $prescribing_date);
                    $stmt->bindParam(':test_type', $test_type);
                    $stmt->bindParam(':diagnosis', $diagnosis);
                    $stmt->bindParam(':test_date', $test_date);                    
                    $stmt->bindParam(':description', $description);

                    try {
                        $stmt->execute();
                    } catch (\Exception $e) {
                        print $e->getMessage();
                    }

                    // Insert of Record into Database for Search
                    $sql = "INSERT INTO radiology_search
                            (record_id, patient_name, diagnosis, description)
                            VALUES (:record_id, :patient_name, :diagnosis, :description)"; 
                    $stmt = $this->dbHandle->prepare($sql);
                    $stmt->bindParam(':record_id', $record_id);
                    $stmt->bindParam(':patient_name', $patient);
                    $stmt->bindParam(':diagnosis', $diagnosis);                  
                    $stmt->bindParam(':description', $description);

                    try {
                        $stmt->execute();
                    } catch (\Exception $e) {
                        print $e->getMessage();
                    }

                    $result = count($_FILES["uploadedfile"]["name"]);
                    for ($i = 0; $i < $result; $i++){
                        // Moves file temporarily
                        if (!move_uploaded_file($_FILES["uploadedfile"]["tmp_name"][$i], 'system/tmp/upload.jpeg')) {
                            $_SESSION['error'] = serialize($error_7002);
                            header("Location: /".$this->getBaseDir()."/uploading-module");
                        } else {
                            // Resize for Thumbnail Size
                            $imagine = new \Imagine\Gd\Imagine();
                            $thumbnail = $imagine->open('system/tmp/upload.jpeg');
                            $thumbnail->resize(new \Imagine\Image\Box(100, 100));

                            // Resize for Regular Size
                            $normal = $imagine->open('system/tmp/upload.jpeg');
                            $box = $normal->getSize();
                            $normal->resize(new \Imagine\Image\Box(ceil($box->getWidth()/2), ceil($box->getHeight()/2)));

                            // Insert Data into Database for Images
                            $sql = "INSERT INTO pacs_images (record_id, image_id, thumbnail, regular_size, full_size) 
                                    VALUES (:record_id, :image_id, :thumb, :regular_size, :full_size)";
                            $fullImg = file_get_contents('system/tmp/upload.jpeg');
                            $stmt = $this->dbHandle->prepare($sql);
                            $stmt->bindParam(':record_id', $record_id);
                            $stmt->bindParam(':image_id', $i);
                            $thumbnail_var = $thumbnail->get("jpeg");
                            $stmt->bindParam(':thumb', $thumbnail_var);
                            $normal_var = $normal->get("jpeg");
                            $stmt->bindParam(':regular_size', $normal_var);
                            $stmt->bindParam(':full_size', $fullImg);

                            try {
                                $stmt->execute();
                            } catch (\Exception $e) {
                                print $e->getMessage();
                            }

                            unlink('system/tmp/upload.jpeg');
                        }
                    }

                    $_SESSION['success'] = serialize($success);
                    header("Location: /".$this->getBaseDir()."/".$this->getDestination());
                }   
            }
        }

        /**
         * Takes in User Object and persists to 
         * database provided the data is pertinent to it.
         */
        public function updateData() {}


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
