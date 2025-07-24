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


---- /// AppLists :: Generic list data used in entire application

INSERT INTO applist(ListType, ListCode, ListText, Active)
values
('Status', 'Active', 'Active', 1),
('Status', 'Open', 'Open', 1),
('Status', 'Closed', 'Closed', 1),
('Status', 'Deleted', 'Deleted', 1),
('Status', 'Inactive', 'Inactive', 1),
('Status', 'Draft', 'Draft', 1),
('Status', 'Final', 'Final', 1),
('Status', 'Archived', 'Archived', 1);


INSERT INTO AppList(ListType, ListCode, ListText, Active)
values
('OrganisationType', 'Private', 'Public', 1),
('OrganisationType', 'Public', 'Open', 1);


INSERT INTO AppList(ListType, ListCode, ListText, Active)
VALUES
('MedicalInstitutionCategory', 'Teaching', 'Specialist', 1),
('MedicalInstitutionCategory', 'Specialist', 'Specialist', 1),
('MedicalInstitutionCategory', 'General', 'General', 1);


INSERT INTO AppList(ListType, ListCode, ListText,  Active)
VALUES
('IdentificationType', 'NationalId', 'National ID', 1),
('IdentificationType', 'Passport', 'Passport', 1),
('IdentificationType', 'DriversLicence', 'Drivers Licence', 1);


INSERT INTO applist(ListType, ListCode, ListText, ListDescription, Active)
values
('MedicalServiceCategory', 'Primary', 'Primary Care', 'Basic healthcare services including general consultations and chronic disease management', 1),
('MedicalServiceCategory', 'Specialist', 'Specialist Care', 'Specialized medical services provided by trained specialists', 1),
('MedicalServiceCategory', 'Diagnostics', 'Diagnostics', 'Tests and procedures to identify medical conditions', 1),
('MedicalServiceCategory', 'Emergency', 'Emergency Care', 'Immediate treatment for acute medical conditions', 1),
('MedicalServiceCategory', 'Preventive', 'Preventive Care', 'Services focused on disease prevention and health maintenance', 1),
('MedicalServiceCategory', 'Mental', 'Mental Health', 'Services for psychological and emotional well-being', 1),
('MedicalServiceCategory', 'Rehab', 'Rehabilitation', 'Therapies to restore function after illness or injury', 1),
('MedicalServiceCategory', 'Surgical', 'Surgical', 'Medical procedures involving operative techniques', 1),
('MedicalServiceCategory', 'Maternal', 'Maternal', 'Healthcare services for pregnancy and childbirth', 1),
('MedicalServiceCategory', 'Pediatric', 'Pediatric Care', 'Medical services specifically for children', 1);




--- AppList :: ListType => AppointmentStatus
INSERT INTO AppList(ListType, ListCode, ListText, ListDescription, Active)
values
('AppointmentStatus', 'Pending', 'Pending', 'The appointment has been requested but not yet confirmed', 1),
('AppointmentStatus', 'Confirmed', 'Confirmed', 'The appointment has been scheduled and confirmed', 1),
('AppointmentStatus', 'Cancelled', 'Cancelled', 'The appointment has been cancelled by either the patient or the practitioner', 1),
('AppointmentStatus', 'Completed', 'Completed', 'The appointment has taken place', 1),
('AppointmentStatus', 'Rescheduled', 'Rescheduled', 'The appointment has been moved to a new date or time', 1),
('AppointmentStatus', 'NoShow', 'No Show', 'The patient did not attend the appointment without prior cancellation', 1);




--
-- Table structure for table AppPrivilege
--

DROP TABLE IF EXISTS AppPrivilege;
CREATE TABLE IF NOT EXISTS AppPrivilege (
  
  Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Code varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  Name varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  Active tinyint(1) NOT NULL DEFAULT '1',

  DateCreated datetime NULL DEFAULT CURRENT_TIMESTAMP,
  CreatedBy varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ModifiedBy varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table AppRole
--

DROP TABLE IF EXISTS AppRole;
CREATE TABLE IF NOT EXISTS AppRole (

  Id int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (Id),
  Code varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY UNQ_AppRole_Code (Code),
  Name varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  Active tinyint(1) NOT NULL DEFAULT '1',

  ViewLevelId int DEFAULT NULL,
  CONSTRAINT FK_AppRole_ViewLevel_Id  FOREIGN KEY (ViewLevelId) REFERENCES AppList (Id),
  Description varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,

  DateCreated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CreatedBy varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ModifiedBy varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO AppRole (Code, Name, Description) VALUES
('Insurance', 'Insurance', 'Health insurance provider'),
('Practitioner', 'Practitioner', 'Medical practitioner'),
('Institution', 'Institution', 'Health institution'),
('Client', 'Client', 'Client or patient');



DROP TABLE IF EXISTS AppUser;
CREATE TABLE IF NOT EXISTS AppUser (

  Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  UUID varchar(255) DEFAULT NULL,

  PrimaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  SecondaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PrimaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  SecondaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PrimaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  SecondaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  Name varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  
  RoleId int,
  CONSTRAINT FK_AppUser_Role_Id FOREIGN KEY(RoleId) REFERENCES AppRole(Id),


  Active tinyint(1) DEFAULT '1',
  Password varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  FailedLoginAttempts int DEFAULT NULL,
  AccountIsLocked tinyint(1) DEFAULT NULL,
  ChangePasswordNextLogin tinyint(1) DEFAULT NULL,
  PasswordExpiryDate datetime DEFAULT NULL,
  PasswordChangedDate datetime DEFAULT NULL,
  ActivationCode varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  ActivationCodeExpiresIn int DEFAULT NULL,
  AccountActivated tinyint(1) DEFAULT NULL,
  ActivationCodeSentOn datetime DEFAULT NULL,

  StatusId int DEFAULT NULL,
  CONSTRAINT FK_AppUser_Status_Id FOREIGN KEY(StatusId) REFERENCES AppList(Id),

  CreateNewPasswordOnActivate tinyint(1) DEFAULT NULL,
  Firstname varchar(450) COLLATE utf8mb4_general_ci DEFAULT NULL,
  Lastname varchar(450) COLLATE utf8mb4_general_ci DEFAULT NULL,
  DateActivated datetime DEFAULT NULL,
  Salt varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  Username varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,

  DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
  CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO AppUser (Name, RoleId, Firstname, Lastname, PrimaryEmail, Username, Password, Salt) VALUES
('Bwalya Chisanga', (SELECT Id FROM AppRole WHERE Code = 'Client' LIMIT 1), 'Bwalya', 'Chisanga', 'bwalya.chisanga@mail.com', 'bwalya.chisanga@mail.com', 'ef967f5643e8cc73b1edef68bd540624', '@#$%fsIlikecbu(4@!~#$%*^%$'),

('Bwalya Chisanga', (SELECT Id FROM AppRole WHERE Code = 'Insurance' LIMIT 1), 'Bwalya', 'Chisanga', 'bwalya.chisanga@mail.com', 'bwalya.chisanga@mail.com', 'ef967f5643e8cc73b1edef68bd540624', '@#$%fsIlikecbu(4@!~#$%*^%$'),

('Bwalya Chisanga', (SELECT Id FROM AppRole WHERE Code = 'Practitioner' LIMIT 1), 'Bwalya', 'Chisanga', 'bwalya.chisanga@mail.com', 'bwalya.chisanga@mail.com', 'ef967f5643e8cc73b1edef68bd540624', '@#$%fsIlikecbu(4@!~#$%*^%$');



CREATE TABLE MedicalService(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

CategoryId INT, -- MedicalServiceCategory
CONSTRAINT  FK_MedicalService_Category_Id  FOREIGN KEY (CategoryId)  REFERENCES AppList(Id),

Code VARCHAR(255),
Name TEXT,
Description TEXT,

Duration INT,
DurationUnit VARCHAR(50),

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO MedicalService(CategoryId, Code, Name, Description, Duration, DurationUnit)
VALUES
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Primary' LIMIT 1),
    'GeneralConsultation', 
    'General Consultation', 
    'Basic medical consultation with a general practitioner', 
    30,
    'Minutes'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Primary' LIMIT 1),
    'ChronicDiseaseManagement', 
    'Chronic Disease Management', 
    'Ongoing care for conditions like diabetes, hypertension, etc.', 
    45,
    'Minutes'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Specialist' LIMIT 1),
    'CardiologyConsultation', 
    'Cardiology Consultation', 
    'Heart health evaluation by a cardiologist', 
    60,
    'Minutes'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Specialist' LIMIT 1),
    'DermatologyConsultation', 
    'Dermatology Consultation', 
    'Skin condition evaluation and treatment', 
    30,
    'Minutes'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Diagnostics' LIMIT 1),
    'XRAY', 
    'X-ray Imaging', 
    'Radiological imaging for bone and some soft tissue evaluation', 
    30,
    'Minutes'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Emergency' LIMIT 1),
    'EmergencyRoom', 
    'Emergency Room Visit', 
    'Immediate care for acute medical conditions', 
    0,
    'varies'
),
(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Preventive' LIMIT 1),
    'Vaccination', 
    'Vaccination', 
    'Administration of preventive immunizations', 
    15,
    'Minutes'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Preventive' LIMIT 1),
    'HealthScreening', 
    'Health Screening', 
    'Comprehensive health check-up', 
    90,
    'Minutes'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Preventive' LIMIT 1),
    'HealthScreening', 
    'Health Screening', 
    'Comprehensive health check-up', 
    90,
    'Minutes'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Mental' LIMIT 1),
    'PsychotherapySession', 
    'Psychotherapy Session', 
    'Mental health counseling session', 
    50,
    'Minutes'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Rehab' LIMIT 1),
    'PhysicalTherapy', 
    'Physical Therapy', 
    'Rehabilitation exercises and treatment', 
    45,
    'Minutes'
),


(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Surgical' LIMIT 1),
    'MinorSurgery', 
    'Minor Surgical Procedure', 
    'Outpatient surgical interventions', 
    0,
    'varies'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Maternal' LIMIT 1),
    'PrenatalCheckUp', 
    'Prenatal Check-up', 
    'Pregnancy monitoring and care', 
    30,
    'minutes'
),

(
    (SELECT Id FROM AppList WHERE ListType = 'MedicalServiceCategory' AND ListCode = 'Pediatric' LIMIT 1),
    'ChildWellnessVisit', 
    'Child Wellness Visit', 
    'Routine health check for children', 
    30,
    'minutes'
);


--- Insurance Providers
CREATE TABLE InsuranceProvider(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

Code VARCHAR(255),
Name TEXT,

TypeId INT, -- OrganisationType - -Public or Private
CONSTRAINT  FK_InsuranceProvider_Type_Id  FOREIGN KEY (TypeId)  REFERENCES AppList(Id),

PostalBox TEXT,
PhysicalAddressStreet TEXT,
PhysicalAddressCity TEXT,
Website TEXT,
PrimaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
PrimaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
PrimaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- InsuranceProviderPlan
CREATE TABLE InsuranceProviderPlan(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

InsuranceProviderId INT, 
CONSTRAINT  FK_InsuranceProviderPlan_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

Code VARCHAR(255),
Name TEXT,

CoveragePercentage INT,
Features TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE InsuranceProviderPlanService(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

InsuranceProviderId INT, 
CONSTRAINT  FK_InsuranceProviderPlanService_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

ServiceId INT, 
CONSTRAINT  FK_InsuranceProviderPlanService_MedicalService_Id  FOREIGN KEY (ServiceId)  REFERENCES MedicalService(Id),

CoveragePercentage INT,
Details TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
);



-------------////////// Client Info
CREATE TABLE Client(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

UserId INT NOT NULL,
CONSTRAINT  FK_Client_User_Id  FOREIGN KEY (UserId)  REFERENCES AppUser(Id) ,

Gender VARCHAR(6), -- Only Male and Female are the recognised genders in the system
DateOfBirth DATE,

IdentificationTypeId INT,
CONSTRAINT FK_Client_IdentificationType_Id FOREIGN KEY (IdentificationTypeId) REFERENCES AppList(Id),
IdentificationNumber VARCHAR(50),

PhysicalAddress TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE ClientInsurancePlan(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientInsurancePlan_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

PlanId INT,
CONSTRAINT  FK_ClientInsurancePlan_Plan_Id  FOREIGN KEY (PlanId)  REFERENCES InsuranceProviderPlan(Id),

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;





------------/////////// Medical Institutions
CREATE TABLE MedicalInstitution(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

Code VARCHAR(255),
Name TEXT,

TypeId INT, -- OrganisationType
CONSTRAINT  FK_MedicalInstitution_Type_Id  FOREIGN KEY (TypeId)  REFERENCES AppList(Id),

CategoryId INT, -- MedicalInstitutionCategory
CONSTRAINT  FK_MedicalInstitution_Category_Id  FOREIGN KEY (CategoryId)  REFERENCES AppList(Id),

PostalBox TEXT,
PhysicalAddressStreet TEXT,
PhysicalAddressCity TEXT,
Website TEXT,
PrimaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryEmail varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
PrimaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryTelephone varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
PrimaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
SecondaryMobile varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

BedCapacity INT,

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE MedicalInstitutionService(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

InstitutionId INT,
CONSTRAINT  FK_MedicalInstitutionService_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

ServiceId INT,
CONSTRAINT  FK_MedicalInstitutionService_Service_Id  FOREIGN KEY (ServiceId)  REFERENCES MedicalService(Id),

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



---------//////// Medical Practitioners
CREATE TABLE MedicalStaff(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

UserId INT NOT NULL,
CONSTRAINT  FK_MedicalStaff_User_Id  FOREIGN KEY (UserId)  REFERENCES AppUser(Id),

Gender VARCHAR(6), -- Only Male and Female are the recognised genders in the system
DateOfBirth DATE,

IdentificationTypeId INT,
CONSTRAINT FK_Client_IdentificationType_Id FOREIGN KEY (IdentificationTypeId) REFERENCES AppList(Id),
IdentificationNumber VARCHAR(50),

PhysicalAddress TEXT,
Workplace TEXT,

Qualifications TEXT, -- "MBChB", "MMed Pediatrics
Specialty TEXT, -- Pediatrics
LicenseNumber TEXT, -- HPCZ-54321

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

---------/// Section :: Client Medical Records


----  ClientAppointment : holds latest appointment status

CREATE TABLE ClientAppointment (

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientAppointment_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider id
CONSTRAINT  FK_ClientAppointment_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution id
CONSTRAINT  FK_ClientAppointment_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

ServiceId INT, -- medical service id
CONSTRAINT  FK_ClientAppointment_InsuranceProvider_Id  FOREIGN KEY (ServiceId)  REFERENCES MedicalService(Id),

OnDate DATE, -- first scheduled date
AtTime TIME, -- first scheduled time
StatusId INT, -- ListType => AppointmentStatus.. Current appointment status

InternalNotes TEXT,
NotesToClient TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- Track trail of client appointments
CREATE TABLE ClientAppointmentTrail(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

AppointmentId INT, 
CONSTRAINT  FK_ClientAppointment_FromStatus_Id  FOREIGN KEY (AppointmentId)  REFERENCES ClientAppointment(Id),

OnDate DATE, -- first scheduled date
AtTime TIME, -- first scheduled time

FromStatusId INT,
CONSTRAINT  FK_ClientAppointmentTrail_FromStatus_Id  FOREIGN KEY (FromStatusId)  REFERENCES AppList(Id),

ToStatusId INT,
CONSTRAINT  FK_ClientAppointmentTrail_ToStatus_Id  FOREIGN KEY (ToStatusId)  REFERENCES AppList(Id),

InternalNotes TEXT,
NotesToClient TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 



CREATE TABLE ClientMedication(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientMedication_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientMedication_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution dispensing
CONSTRAINT  FK_ClientMedication_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

MedicineName TEXT,
MedicineDosage TEXT,
IntakeFrequency VARCHAR(50),
StartDate DATE,
EndDate DATE,

DatePrescribed DATE,
PrescribedBy TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE ClientAllergy(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientAllergy_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientAllergy_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientAllergy_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

DateRecorded DATE,
ObservedBy TEXT,

Allergen TEXT,
Reaction TEXT,
Severity VARCHAR(50),

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE ClientProcedure(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientProcedure_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientProcedure_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientProcedure_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

DatePerformed DATE,
PerformedBy TEXT,

ProcedureType TEXT,
Reason TEXT,
Details TEXT,
Outcome VARCHAR(50),

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE ClientVital(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientVital_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientVital_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientVital_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

Vital TEXT, -- example : Blood pressure, heart rate, weight, height, temprature
VitalValue TEXT, 

DateRecorded DATE,
RecordedBy TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE ClientLabResult(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientLabResultClient_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientLabResult_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientLabResult_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

TestName TEXT, 

ResultValue TEXT, 
ResultStatus TEXT, -- Examples : Normal, BelowNormal, AboveNormal, CriticalLow, CriticalHigh
ReferenceRange TEXT,

ReferenceRangeUnits VARCHAR(255),

DateRequested DATETIME,
RequestedBy TEXT,

ResultDate DATETIME,
ResultedBy TEXT, 

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE ClientCondition(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientCondition_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientCondition_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientCondition_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

ConditionName TEXT,
DateDiagnosed DATE,
DiagnosedBy TEXT,
Details TEXT,
CurrentStatus VARCHAR(255), -- Active, Absent, ...etc

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE ClientVaccination(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientCondition_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientCondition_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientCondition_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

VaccineName TEXT,
Reason TEXT, -- Routine, Condition, Prevention, PublicHealth, TravelRequirement,... etc
DateAdministered DATE,
AdministeredBy TEXT,
DosesRequired INT, --
DosesRemaining INT,
NextDoseDate DATE, 
CurrentStatus VARCHAR(255), -- NoneTaken, Completed,  ...etc

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE ClientInvoice(
 
Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

ClientId INT,
CONSTRAINT  FK_ClientInvoice_Client_Id  FOREIGN KEY (ClientId)  REFERENCES Client(Id),

InsuranceProviderId INT, --  Insurance provider covering cost
CONSTRAINT  FK_ClientInvoice_InsuranceProvider_Id  FOREIGN KEY (InsuranceProviderId)  REFERENCES InsuranceProvider(Id),

InstitutionId INT, -- medical institution
CONSTRAINT  FK_ClientInvoice_Institution_Id  FOREIGN KEY (InstitutionId)  REFERENCES MedicalInstitution(Id),

Details TEXT, 
InvoiceNumber TEXT,
InvoicedBy TEXT,
InvoiceDate DATETIME,
InvoiceAmount DECIMAL(18,2), -- total invoice value
Balance DECIMAL(18,2), -- Derived from payments and invoice amount

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE ClientInvoiceItem(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

InvoiceId INT,
CONSTRAINT  FK_ClientInvoiceItem_Invoice_Id  FOREIGN KEY (ServiceId)  REFERENCES InvoiceId(Id),

ServiceId INT, -- service being billed for
CONSTRAINT  FK_ClientInvoiceItem_Service_Id  FOREIGN KEY (ServiceId)  REFERENCES MedicalService(Id),

Details TEXT, 
AmountPaid DECIMAL(18,2),
PaymentMode VARCHAR(255), -- DebitCard, Cash, BankTransfer, MobileMoney
PaymentDetails TEXT,

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE ClientPayment(

Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Reference varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
UUID varchar(255) DEFAULT NULL,

InvoiceId INT,
CONSTRAINT  FK_ClientPayment_Invoice_Id  FOREIGN KEY (InvoiceId)  REFERENCES ClientInvoice(Id),

ServiceId INT, -- specific service the client is requried to pay for, where - the service not covered at all by insurance scheme or coverage percentage for service is not sufficient
CONSTRAINT  FK_CClientPayment_Service_Id  FOREIGN KEY (ServiceId)  REFERENCES MedicalService(Id),

Details TEXT, 
PaymentReference TEXT,
PaidBy TEXT,
AmountPaid DECIMAL(18,2),
PaymentStatus VARCHAR(255), -- 

DateCreated datetime DEFAULT CURRENT_TIMESTAMP,
CreatedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
DateModified  datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ModifiedBy varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
