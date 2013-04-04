/*
 *  File name:  setup.sql
 *  Function:   to create the initial database schema for the CMPUT 391 project,
 *              Winter Term, 2012
 *  Author:     Prof. Li-Yan Yuan
 *  Modified:   Jeremy Smereka & Amir Salimi
 */
DROP TABLE IF EXISTS persons;
DROP TABLE IF EXISTS family_doctor;
DROP TABLE IF EXISTS pacs_images;
DROP TABLE IF EXISTS radiology_record;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS radiology_search;


CREATE TABLE users (
   user_name varchar(24),
   password  varchar(24),
   class     char(1),
   date_registered date,
   CHECK (class in ('a','p','d','r')),
   PRIMARY KEY(user_name)
) ENGINE=InnoDB;

CREATE TABLE persons (
   user_name  varchar(24),
   first_name varchar(24),
   last_name  varchar(24),
   address    varchar(128),
   email      varchar(128),
   phone      char(10),
   PRIMARY KEY(user_name),
   UNIQUE (email),
   FOREIGN KEY (user_name) REFERENCES users (user_name)
) ENGINE=InnoDB;


CREATE TABLE family_doctor (
   doctor_name  varchar(24),
   patient_name varchar(24),
   FOREIGN KEY(doctor_name) REFERENCES users (user_name),
   FOREIGN KEY(patient_name) REFERENCES users (user_name),
   PRIMARY KEY(doctor_name,patient_name)
) ENGINE=InnoDB;


CREATE TABLE radiology_record (
   record_id   int,
   patient_name varchar(24),
   doctor_name varchar(24),
   radiologist_name varchar(24),
   test_type   varchar(24),
   prescribing_date date,
   test_date    date,
   diagnosis    varchar(128),
   description   varchar(1024),
   PRIMARY KEY(record_id),
   FOREIGN KEY(patient_name) REFERENCES users (user_name),
   FOREIGN KEY(doctor_name) REFERENCES users (user_name),
   FOREIGN KEY(radiologist_name) REFERENCES users (user_name)
) ENGINE=InnoDB;

CREATE TABLE pacs_images (
   record_id   int,
   image_id    int,
   thumbnail   blob,
   regular_size blob,
   full_size    blob,
   PRIMARY KEY(record_id,image_id),
   FOREIGN KEY(record_id) REFERENCES radiology_record (record_id)
) ENGINE=InnoDB;

CREATE TABLE radiology_search (  
   record_id int,  
   patient_name varchar(24),  
   diagnosis varchar(128),  
   description varchar(1024),  
   PRIMARY KEY (record_id),  
   FULLTEXT KEY patient_name (patient_name),  
   FULLTEXT KEY diagnosis (diagnosis),  
   FULLTEXT KEY description (description),  
   FULLTEXT KEY searchkey (patient_name, diagnosis, description)
) ENGINE=MyISAM;