# Seed Data for National Centralised Patient Portal

This document provides sample (seed) data for the National Centralised Patient Portal (NCPP) database, compatible with both MySQL and SQLite. This data is intended for demonstration and testing purposes.

## 1. Users Table

```sql
-- MySQL & SQLite
INSERT INTO users (id, username, password_hash, email, role) VALUES
(1, 'chipo.banda', 'health', 'chipo.banda@example.com', 'patient'),
(2, 'mutale.mwanza', 'health', 'mutale.mwanza@example.com', 'patient'),
(3, 'dr.mulenga', 'health', 'dr.mulenga@example.com', 'provider'),
(4, 'dr.tembo', 'health', 'dr.tembo@example.com', 'provider'),
(5, 'admin.user', 'health', 'admin.user@example.com', 'admin');
```

## 2. Patients Table

```sql
-- MySQL & SQLite
INSERT INTO patients (patient_id, user_id, first_name, last_name, date_of_birth, gender, address, phone_number, nhima_id) VALUES
(101, 1, 'Chipo', 'Banda', '1990-05-15', 'Female', '123 Main St, Lusaka', '+260971234567', 'NHIMA001'),
(102, 2, 'Mutale', 'Mwanza', '1988-11-22', 'Male', '456 Oak Ave, Ndola', '+260962345678', 'NHIMA002');
```

## 3. Providers Table

```sql
-- MySQL & SQLite
INSERT INTO providers (provider_id, user_id, first_name, last_name, specialty, phone_number, email, medical_license_number) VALUES
(201, 3, 'Dr. Monde', 'Mulenga', 'General Practitioner', '+260953456789', 'dr.mulenga@example.com', 'MLN001'),
(202, 4, 'Dr. Chanda', 'Tembo', 'Pediatrician', '+260974567890', 'dr.tembo@example.com', 'MLN002');
```

## 4. Appointments Table

```sql
-- MySQL & SQLite
INSERT INTO appointments (id, patient_id, provider_id, appointment_date, reason, status, notes) VALUES
(1, 101, 201, '2024-07-20 10:00:00', 'Routine Checkup', 'scheduled', 'Patient requested morning slot.'),
(2, 102, 202, '2024-07-21 14:30:00', 'Child Vaccination', 'completed', 'Vaccine administered successfully.'),
(3, 101, 202, '2024-07-25 09:00:00', 'Follow-up', 'scheduled', NULL);
```

## 5. Medical Records Table

```sql
-- MySQL & SQLite
INSERT INTO medical_records (id, patient_id, provider_id, record_date, record_type, description, file_url) VALUES
(1, 101, 201, '2023-01-10', 'diagnosis', 'Common cold, prescribed antibiotics.', NULL),
(2, 102, 202, '2023-03-05', 'prescription', 'Paracetamol 500mg, 2 tablets daily for 3 days.', NULL),
(3, 101, 201, '2023-06-20', 'test_result', 'Blood test: Normal.', 'http://example.com/results/blood_test_chipo.pdf');
```

## 6. Messages Table

```sql
-- MySQL & SQLite
INSERT INTO messages (id, sender_id, receiver_id, subject, message_body, is_read) VALUES
(1, 1, 3, 'Appointment Inquiry', 'Can I reschedule my appointment for next week?', 0),
(2, 3, 1, 'Re: Appointment Inquiry', 'Please call the clinic to reschedule.', 1),
(3, 2, 4, 'Question about medication', 'Is it normal to feel drowsy after taking this?', 0);
```

## 7. Care Plans Table

```sql
-- MySQL & SQLite
INSERT INTO care_plans (id, patient_id, provider_id, plan_name, description, start_date, end_date, status) VALUES
(1, 101, 201, 'Diabetes Management Plan', 'Includes diet, exercise, and medication adherence.', '2024-01-01', '2024-12-31', 'active'),
(2, 102, 202, 'Asthma Action Plan', 'Steps to take during an asthma attack.', '2023-09-01', NULL, 'active');
```

## 8. Test Results Table

```sql
-- MySQL & SQLite
INSERT INTO test_results (id, patient_id, provider_id, test_name, result_value, units, reference_range, result_date, notes, file_url) VALUES
(1, 101, 201, 'Complete Blood Count', 'Normal', NULL, 'Normal Range', '2023-06-15 11:00:00', 'Routine checkup.', 'http://example.com/results/cbc_chipo.pdf'),
(2, 102, 202, 'X-Ray Chest', 'Clear', NULL, 'No abnormalities', '2023-03-01 10:30:00', 'Pre-vaccination screening.', 'http://example.com/results/xray_mutale.pdf');
```

## 9. Medications Table

```sql
-- MySQL & SQLite
INSERT INTO medications (id, patient_id, provider_id, medication_name, dosage, frequency, start_date, end_date, notes) VALUES
(1, 101, 201, 'Metformin', '500mg', 'Twice daily', '2024-01-01', NULL, 'For diabetes management.'),
(2, 102, 202, 'Salbutamol Inhaler', '2 puffs', 'As needed', '2023-09-01', NULL, 'For asthma relief.');
```

## 10. Billing Table

```sql
-- MySQL & SQLite
INSERT INTO billing (id, patient_id, invoice_number, service_description, amount, invoice_date, due_date, status, payment_date) VALUES
(1, 101, 'INV001', 'Consultation Fee', 250.00, '2024-07-20', '2024-08-20', 'pending', NULL),
(2, 102, 'INV002', 'Vaccination Service', 150.00, '2024-07-21', '2024-08-21', 'paid', '2024-07-21');
```

## 11. Reports Table

```sql
-- MySQL & SQLite
INSERT INTO reports (id, report_name, description, generated_by, file_url) VALUES
(1, 'Monthly Patient Summary', 'Summary of patient activities for July 2024.', 5, 'http://example.com/reports/monthly_summary_jul2024.pdf');
```

## 12. FAQ Table

```sql
-- MySQL & SQLite
INSERT INTO faq (id, question, answer, category) VALUES
(1, 'How do I book an appointment?', 'You can book an appointment through the Appointments section of the portal.', 'Appointments'),
(2, 'How can I view my test results?', 'Test results are available in the Results section once processed by your provider.', 'Results');
```

## 13. Support Tickets Table

```sql
-- MySQL & SQLite
INSERT INTO support_tickets (id, patient_id, subject, description, status, priority) VALUES
(1, 101, 'Login Issue', 'Cannot log in to my account after password reset.', 'open', 'high'),
(2, 102, 'Medical Record Discrepancy', 'A record from 2022 is missing from my history.', 'in_progress', 'medium');
```