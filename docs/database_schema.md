# Database Schema for National Centralised Patient Portal

This document outlines the proposed database schema for the National Centralised Patient Portal (NCPP), designed to be compatible with both MySQL and SQLite for demonstration and production environments.

## 1. Users Table

Stores general user information, including authentication credentials. This table will be used for both patients and providers.

**MySQL:**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    role ENUM('patient', 'provider', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**SQLite:**
```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    email TEXT UNIQUE,
    role TEXT NOT NULL CHECK(role IN ('patient', 'provider', 'admin')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);
```

## 2. Patients Table

Stores specific information for patient users.

**MySQL:**
```sql
CREATE TABLE patients (
    patient_id INT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    address TEXT,
    phone_number VARCHAR(20),
    nhima_id VARCHAR(50) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE patients (
    patient_id INTEGER PRIMARY KEY,
    user_id INTEGER NOT NULL UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    date_of_birth TEXT,
    gender TEXT CHECK(gender IN ('Male', 'Female', 'Other')),
    address TEXT,
    phone_number TEXT,
    nhima_id TEXT UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 3. Providers Table

Stores specific information for healthcare provider users.

**MySQL:**
```sql
CREATE TABLE providers (
    provider_id INT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255),
    phone_number VARCHAR(20),
    email VARCHAR(255) UNIQUE,
    medical_license_number VARCHAR(100) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE providers (
    provider_id INTEGER PRIMARY KEY,
    user_id INTEGER NOT NULL UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    specialty TEXT,
    phone_number TEXT,
    email TEXT UNIQUE,
    medical_license_number TEXT UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 4. Appointments Table

Stores patient appointment details.

**MySQL:**
```sql
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    provider_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    reason TEXT,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE appointments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    provider_id INTEGER NOT NULL,
    appointment_date TEXT NOT NULL,
    reason TEXT,
    status TEXT DEFAULT 'scheduled' CHECK(status IN ('scheduled', 'completed', 'cancelled')),
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE CASCADE
);
```

## 5. Medical Records Table

Stores patient medical history and records.

**MySQL:**
```sql
CREATE TABLE medical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    provider_id INT,
    record_date DATE NOT NULL,
    record_type VARCHAR(100) NOT NULL, -- e.g., 'diagnosis', 'prescription', 'test_result'
    description TEXT,
    file_url VARCHAR(255), -- URL to a stored file (e.g., PDF of test results)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

**SQLite:**
```sql
CREATE TABLE medical_records (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    provider_id INTEGER,
    record_date TEXT NOT NULL,
    record_type TEXT NOT NULL,
    description TEXT,
    file_url TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

## 6. Messages Table

Stores secure messages between patients and providers.

**MySQL:**
```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL, -- user_id of sender
    receiver_id INT NOT NULL, -- user_id of receiver
    subject VARCHAR(255),
    message_body TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sender_id INTEGER NOT NULL,
    receiver_id INTEGER NOT NULL,
    subject TEXT,
    message_body TEXT NOT NULL,
    sent_at TEXT DEFAULT CURRENT_TIMESTAMP,
    is_read INTEGER DEFAULT 0, -- 0 for FALSE, 1 for TRUE
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 7. Care Plans Table

Stores personalized care plans for patients.

**MySQL:**
```sql
CREATE TABLE care_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    provider_id INT NOT NULL,
    plan_name VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE,
    status ENUM('active', 'completed', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE care_plans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    provider_id INTEGER NOT NULL,
    plan_name TEXT NOT NULL,
    description TEXT,
    start_date TEXT NOT NULL,
    end_date TEXT,
    status TEXT DEFAULT 'active' CHECK(status IN ('active', 'completed', 'archived')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE CASCADE
);
```

## 8. Test Results Table

Stores details of laboratory and diagnostic test results.

**MySQL:**
```sql
CREATE TABLE test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    provider_id INT,
    test_name VARCHAR(255) NOT NULL,
    result_value VARCHAR(255),
    units VARCHAR(50),
    reference_range VARCHAR(100),
    result_date DATETIME NOT NULL,
    notes TEXT,
    file_url VARCHAR(255), -- URL to a stored file (e.g., PDF of lab report)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

**SQLite:**
```sql
CREATE TABLE test_results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    provider_id INTEGER,
    test_name TEXT NOT NULL,
    result_value TEXT,
    units TEXT,
    reference_range TEXT,
    result_date TEXT NOT NULL,
    notes TEXT,
    file_url TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

## 9. Medications Table

Stores patient medication details.

**MySQL:**
```sql
CREATE TABLE medications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    provider_id INT,
    medication_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(100),
    frequency VARCHAR(100),
    start_date DATE NOT NULL,
    end_date DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

**SQLite:**
```sql
CREATE TABLE medications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    provider_id INTEGER,
    medication_name TEXT NOT NULL,
    dosage TEXT,
    frequency TEXT,
    start_date TEXT NOT NULL,
    end_date TEXT,
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(provider_id) ON DELETE SET NULL
);
```

## 10. Billing Table

Stores patient billing and invoice details.

**MySQL:**
```sql
CREATE TABLE billing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    invoice_number VARCHAR(100) UNIQUE NOT NULL,
    service_description TEXT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    invoice_date DATE NOT NULL,
    due_date DATE,
    status ENUM('paid', 'pending', 'cancelled') DEFAULT 'pending',
    payment_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE billing (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    invoice_number TEXT UNIQUE NOT NULL,
    service_description TEXT NOT NULL,
    amount REAL NOT NULL,
    invoice_date TEXT NOT NULL,
    due_date TEXT,
    status TEXT DEFAULT 'pending' CHECK(status IN ('paid', 'pending', 'cancelled')),
    payment_date TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
);
```

## 11. Reports Table

Stores information about generated reports (e.g., summary reports, analytics).

**MySQL:**
```sql
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_name VARCHAR(255) NOT NULL,
    description TEXT,
    generated_by INT, -- user_id of the generator (admin/provider)
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_url VARCHAR(255), -- URL to the generated report file
    FOREIGN KEY (generated_by) REFERENCES users(id) ON DELETE SET NULL
);
```

**SQLite:**
```sql
CREATE TABLE reports (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    report_name TEXT NOT NULL,
    description TEXT,
    generated_by INTEGER, -- user_id of the generator (admin/provider)
    generated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    file_url TEXT,
    FOREIGN KEY (generated_by) REFERENCES users(id) ON DELETE SET NULL
);
```

## 12. FAQ Table

Stores Frequently Asked Questions and their answers.

**MySQL:**
```sql
CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**SQLite:**
```sql
CREATE TABLE faq (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);
```

## 13. Support Tickets Table

Stores patient support requests.

**MySQL:**
```sql
CREATE TABLE support_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
);
```

**SQLite:**
```sql
CREATE TABLE support_tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    patient_id INTEGER NOT NULL,
    subject TEXT NOT NULL,
    description TEXT NOT NULL,
    status TEXT DEFAULT 'open' CHECK(status IN ('open', 'in_progress', 'closed')),
    priority TEXT DEFAULT 'medium' CHECK(priority IN ('low', 'medium', 'high')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
);
```