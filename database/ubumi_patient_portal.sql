DROP TABLE IF EXISTS AppList;
CREATE TABLE IF NOT EXISTS AppList (
  Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ListType varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  ListValue int DEFAULT NULL,
  ListOrder int DEFAULT NULL,
  ListCode text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  ListText text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  ListActionText text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  ListDescription text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,

  SysOptionOnly tinyint(1) DEFAULT '0',
  IsDefaultOption tinyint(1) DEFAULT '0',
  Active tinyint(1) DEFAULT '1',
  SubListType varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,

  DateCreated datetime NULL DEFAULT CURRENT_TIMESTAMP,
  CreatedBy varchar(455) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  DateModified datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ModifiedBy varchar(455) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO applist(ListType, ListCode, ListText, ListDescription, Active)
values
('HealthServiceCategory', 'Primary', 'Primary Care', 'Basic healthcare services including general consultations and chronic disease management', 1),
('HealthServiceCategory', 'Specialist', 'Specialist Care', 'Specialized medical services provided by trained specialists', 1),
('HealthServiceCategory', 'Diagnostics', 'Diagnostics', 'Tests and procedures to identify medical conditions', 1),
('HealthServiceCategory', 'Emergency', 'Emergency Care', 'Immediate treatment for acute medical conditions', 1),
('HealthServiceCategory', 'Preventive', 'Preventive Care', 'Services focused on disease prevention and health maintenance', 1),
('HealthServiceCategory', 'Mental', 'Mental Health', 'Services for psychological and emotional well-being', 1),
('HealthServiceCategory', 'Rehab', 'Rehabilitation', 'Therapies to restore function after illness or injury', 1),
('HealthServiceCategory', 'Surgical', 'Surgical', 'Medical procedures involving operative techniques', 1),
('HealthServiceCategory', 'Maternal', 'Maternal', 'Healthcare services for pregnancy and childbirth', 1),
('HealthServiceCategory', 'Pediatric', 'Pediatric Care', 'Medical services specifically for children', 1);





-- Table: Users
CREATE TABLE `Users` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `role` VARCHAR(20) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `last_login` DATETIME
);

-- Table: InsuranceProviders
CREATE TABLE `InsuranceProviders` (
    `insurance_provider_id` INT AUTO_INCREMENT PRIMARY KEY,
    code TEXT,
    `name` TEXT NOT NULL,
    `contact_info` VARCHAR(255)
);

-- Table: Patients
CREATE TABLE `Patients` (
    `patient_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNIQUE NOT NULL,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `date_of_birth` DATE,
    `gender` VARCHAR(10),
    `phone_number` VARCHAR(20),
    `address` VARCHAR(255),
    `city` VARCHAR(50),
    `state` VARCHAR(50),
    `zip_code` VARCHAR(10),
    `insurance_provider_id` INT,
    `policy_number` VARCHAR(50),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`),
    FOREIGN KEY (`insurance_provider_id`) REFERENCES `InsuranceProviders`(`insurance_provider_id`)
);

-- Table: Providers
CREATE TABLE `Providers` (
    `provider_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNIQUE NOT NULL,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `specialty` VARCHAR(100),
    `phone_number` VARCHAR(20),
    `email` VARCHAR(100),
    `address` VARCHAR(255),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`)
);

-- Table: Services
CREATE TABLE `Services` (
    `service_id` INT AUTO_INCREMENT PRIMARY KEY,
    `service_name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `duration_minutes` INT,
    `price` DECIMAL(10, 2)
);

-- Table: Appointments
CREATE TABLE `Appointments` (
    `appointment_id` INT AUTO_INCREMENT PRIMARY KEY,
    `patient_id` INT NOT NULL,
    `provider_id` INT NOT NULL,
    `service_id` INT NOT NULL,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    `notes` TEXT,
    FOREIGN KEY (`patient_id`) REFERENCES `Patients`(`patient_id`),
    FOREIGN KEY (`provider_id`) REFERENCES `Providers`(`provider_id`),
    FOREIGN KEY (`service_id`) REFERENCES `Services`(`service_id`)
);

-- Table: MedicalRecords
CREATE TABLE `MedicalRecords` (
    `record_id` INT AUTO_INCREMENT PRIMARY KEY,
    `patient_id` INT NOT NULL,
    `record_type` VARCHAR(50) NOT NULL,
    `record_date` DATETIME NOT NULL,
    `description` TEXT,
    `provider_id` INT,
    FOREIGN KEY (`patient_id`) REFERENCES `Patients`(`patient_id`),
    FOREIGN KEY (`provider_id`) REFERENCES `Providers`(`provider_id`)
);

-- Table: Medications
CREATE TABLE `Medications` (
    `medication_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `dosage` VARCHAR(50),
    `frequency` VARCHAR(50),
    `start_date` DATE,
    `end_date` DATE,
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: Allergies
CREATE TABLE `Allergies` (
    `allergy_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `allergen` VARCHAR(100) NOT NULL,
    `reaction` TEXT,
    `severity` VARCHAR(20),
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: Procedures
CREATE TABLE `Procedures` (
    `procedure_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `date_performed` DATE,
    `outcome` TEXT,
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: Vitals
CREATE TABLE `Vitals` (
    `vital_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `blood_pressure` VARCHAR(20),
    `heart_rate` INT,
    `temperature` DECIMAL(5, 2),
    `weight` DECIMAL(6, 2),
    `height` DECIMAL(5, 2),
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: LabResults
CREATE TABLE `LabResults` (
    `lab_result_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `test_name` VARCHAR(100) NOT NULL,
    `result_value` VARCHAR(100),
    `units` VARCHAR(20),
    `reference_range` VARCHAR(50),
    `result_date` DATE,
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: Conditions
CREATE TABLE `Conditions` (
    `condition_id` INT AUTO_INCREMENT PRIMARY KEY,
    `record_id` INT UNIQUE NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `diagnosis_date` DATE,
    `status` VARCHAR(50),
    FOREIGN KEY (`record_id`) REFERENCES `MedicalRecords`(`record_id`)
);

-- Table: Billing
CREATE TABLE `Billing` (
    `bill_id` INT AUTO_INCREMENT PRIMARY KEY,
    `patient_id` INT NOT NULL,
    `appointment_id` INT,
    `service_id` INT,
    `bill_date` DATE NOT NULL,
    `amount` DECIMAL(10, 2) NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    `due_date` DATE,
    FOREIGN KEY (`patient_id`) REFERENCES `Patients`(`patient_id`),
    FOREIGN KEY (`appointment_id`) REFERENCES `Appointments`(`appointment_id`),
    FOREIGN KEY (`service_id`) REFERENCES `Services`(`service_id`)
);