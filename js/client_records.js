document.addEventListener('DOMContentLoaded', function() {
    // Dummy Data
    let medications = [
        { id: 1, name: 'Amoxicillin', dosage: '250mg', frequency: 'Three times daily', prescribedBy: 'Dr. Mwape', datePrescribed: '2024-07-20' },
        { id: 2, name: 'Paracetamol', dosage: '500mg', frequency: 'As needed', prescribedBy: 'Dr. Banda', datePrescribed: '2024-07-18' },
        { id: 3, name: 'Hydrochlorothiazide', dosage: '25mg', frequency: 'Once daily', prescribedBy: 'Dr. Phiri', datePrescribed: '2024-07-15' }
    ];

    let testResults = [
        { id: 1, name: 'Malaria Test', datePerformed: '2024-07-22', result: 'Negative', orderedBy: 'Dr. Mwape' },
        { id: 2, name: 'HIV Test', datePerformed: '2024-07-20', result: 'Negative', orderedBy: 'Dr. Banda' },
        { id: 3, name: 'Blood Pressure Check', datePerformed: '2024-07-19', result: '120/80 mmHg', orderedBy: 'Dr. Phiri' }
    ];

    let immunizations = [
        { id: 1, name: 'Measles Vaccine', dateAdministered: '2024-07-10', administeredBy: 'Nurse Zulu' },
        { id: 2, name: 'Polio Vaccine', dateAdministered: '2024-07-05', administeredBy: 'Nurse Nkosi' }
    ];

    let allergies = [
        { id: 1, name: 'Groundnuts', reaction: 'Swelling, Difficulty breathing', severity: 'Severe', dateNoted: '2023-05-01' },
        { id: 2, name: 'Dust Mites', reaction: 'Sneezing, Runny nose', severity: 'Mild', dateNoted: '2022-03-15' }
    ];

    let conditions = [
        { id: 1, name: 'Asthma', diagnosisDate: '2023-01-20', status: 'Active', diagnosedBy: 'Dr. Mwape' },
        { id: 2, name: 'Anemia', diagnosisDate: '2024-02-10', status: 'Active', diagnosedBy: 'Dr. Banda' }
    ];

    // Render Functions
    function renderMedications() {
        const tbody = document.getElementById('medicationsTableBody');
        tbody.innerHTML = '';
        medications.forEach(med => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${med.name}</td>
                <td>${med.dosage}</td>
                <td>${med.frequency}</td>
                <td>${med.prescribedBy}</td>
                <td>${med.datePrescribed}</td>
            `;
        });
    }

    function renderTestResults() {
        const tbody = document.getElementById('testResultsTableBody');
        tbody.innerHTML = '';
        testResults.forEach(test => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${test.name}</td>
                <td>${test.datePerformed}</td>
                <td>${test.result}</td>
                <td>${test.orderedBy}</td>
                <td>
                    <button class="btn btn-sm btn-info view-edit-test-result" data-id="${test.id}" data-bs-toggle="modal" data-bs-target="#viewEditTestResultModal">View/Edit</button>
                </td>
            `;
        });
    }

    function renderImmunizations() {
        const tbody = document.getElementById('immunizationsTableBody');
        tbody.innerHTML = '';
        immunizations.forEach(imm => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${imm.name}</td>
                <td>${imm.dateAdministered}</td>
                <td>${imm.administeredBy}</td>
                <td>
                    <button class="btn btn-sm btn-info view-edit-immunization" data-id="${imm.id}" data-bs-toggle="modal" data-bs-target="#viewEditImmunizationModal">View/Edit</button>
                </td>
            `;
        });
    }

    function renderAllergies() {
        const tbody = document.getElementById('allergiesTableBody');
        tbody.innerHTML = '';
        allergies.forEach(allergy => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${allergy.name}</td>
                <td>${allergy.reaction}</td>
                <td>${allergy.severity}</td>
                <td>${allergy.dateNoted}</td>
                <td>
                    <button class="btn btn-sm btn-info view-edit-allergy" data-id="${allergy.id}" data-bs-toggle="modal" data-bs-target="#viewEditAllergyModal">View/Edit</button>
                </td>
            `;
        });
    }

    function renderConditions() {
        const tbody = document.getElementById('conditionsTableBody');
        tbody.innerHTML = '';
        conditions.forEach(condition => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${condition.name}</td>
                <td>${condition.diagnosisDate}</td>
                <td>${condition.status}</td>
                <td>${condition.diagnosedBy}</td>
                <td>
                    <button class="btn btn-sm btn-info view-edit-condition" data-id="${condition.id}" data-bs-toggle="modal" data-bs-target="#viewEditConditionModal">View/Edit</button>
                </td>
            `;
        });
    }

    // Initial Render
    renderMedications();
    renderTestResults();
    renderImmunizations();
    renderAllergies();
    renderConditions();

    // Add Medication Form Submission
    document.getElementById('addMedicationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const newMedication = {
            id: medications.length > 0 ? Math.max(...medications.map(m => m.id)) + 1 : 1,
            name: document.getElementById('medicationName').value,
            dosage: document.getElementById('medicationDosage').value,
            frequency: document.getElementById('medicationFrequency').value,
            prescribedBy: document.getElementById('medicationPrescribedBy').value,
            datePrescribed: document.getElementById('medicationDatePrescribed').value
        };
        medications.push(newMedication);
        renderMedications();
        bootstrap.Modal.getInstance(document.getElementById('addMedicationModal')).hide();
        this.reset();
    });

    // Add Test Result Form Submission
    document.getElementById('addTestResultForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const newTestResult = {
            id: testResults.length > 0 ? Math.max(...testResults.map(t => t.id)) + 1 : 1,
            name: document.getElementById('testName').value,
            datePerformed: document.getElementById('testDatePerformed').value,
            result: document.getElementById('testResult').value,
            orderedBy: document.getElementById('testOrderedBy').value
        };
        testResults.push(newTestResult);
        renderTestResults();
        bootstrap.Modal.getInstance(document.getElementById('addTestResultModal')).hide();
        this.reset();
    });

    // Add Immunization Form Submission
    document.getElementById('addImmunizationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const newImmunization = {
            id: immunizations.length > 0 ? Math.max(...immunizations.map(i => i.id)) + 1 : 1,
            name: document.getElementById('vaccineName').value,
            dateAdministered: document.getElementById('immunizationDateAdministered').value,
            administeredBy: document.getElementById('immunizationAdministeredBy').value
        };
        immunizations.push(newImmunization);
        renderImmunizations();
        bootstrap.Modal.getInstance(document.getElementById('addImmunizationModal')).hide();
        this.reset();
    });

    // Add Allergy Form Submission
    document.getElementById('addAllergyForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const newAllergy = {
            id: allergies.length > 0 ? Math.max(...allergies.map(a => a.id)) + 1 : 1,
            name: document.getElementById('allergenName').value,
            reaction: document.getElementById('allergyReaction').value,
            severity: document.getElementById('allergySeverity').value,
            dateNoted: document.getElementById('allergyDateNoted').value
        };
        allergies.push(newAllergy);
        renderAllergies();
        bootstrap.Modal.getInstance(document.getElementById('addAllergyModal')).hide();
        this.reset();
    });

    // Add Condition Form Submission
    document.getElementById('addConditionForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const newCondition = {
            id: conditions.length > 0 ? Math.max(...conditions.map(c => c.id)) + 1 : 1,
            name: document.getElementById('conditionName').value,
            diagnosisDate: document.getElementById('conditionDiagnosisDate').value,
            status: document.getElementById('conditionStatus').value,
            diagnosedBy: document.getElementById('conditionDiagnosedBy').value
        };
        conditions.push(newCondition);
        renderConditions();
        bootstrap.Modal.getInstance(document.getElementById('addConditionModal')).hide();
        this.reset();
    });

    // View/Edit Modals - Populate Data
    document.getElementById('medicationsTableBody').addEventListener('click', function(event) {
        if (event.target.classList.contains('view-edit-medication')) {
            const medId = parseInt(event.target.dataset.id);
            const medication = medications.find(med => med.id === medId);
            if (medication) {
                document.getElementById('editMedicationId').value = medication.id;
                document.getElementById('editMedicationName').value = medication.name;
                document.getElementById('editMedicationDosage').value = medication.dosage;
                document.getElementById('editMedicationFrequency').value = medication.frequency;
                document.getElementById('editMedicationPrescribedBy').value = medication.prescribedBy;
                document.getElementById('editMedicationDatePrescribed').value = medication.datePrescribed;
            }
        }
    });

    document.getElementById('testResultsTableBody').addEventListener('click', function(event) {
        if (event.target.classList.contains('view-edit-test-result')) {
            const testId = parseInt(event.target.dataset.id);
            const test = testResults.find(t => t.id === testId);
            if (test) {
                document.getElementById('editTestResultId').value = test.id;
                document.getElementById('editTestName').value = test.name;
                document.getElementById('editTestDatePerformed').value = test.datePerformed;
                document.getElementById('editTestResult').value = test.result;
                document.getElementById('editTestOrderedBy').value = test.orderedBy;
            }
        }
    });

    document.getElementById('immunizationsTableBody').addEventListener('click', function(event) {
        if (event.target.classList.contains('view-edit-immunization')) {
            const immId = parseInt(event.target.dataset.id);
            const imm = immunizations.find(i => i.id === immId);
            if (imm) {
                document.getElementById('editImmunizationId').value = imm.id;
                document.getElementById('editVaccineName').value = imm.name;
                document.getElementById('editImmunizationDateAdministered').value = imm.dateAdministered;
                document.getElementById('editImmunizationAdministeredBy').value = imm.administeredBy;
            }
        }
    });

    document.getElementById('allergiesTableBody').addEventListener('click', function(event) {
        if (event.target.classList.contains('view-edit-allergy')) {
            const allergyId = parseInt(event.target.dataset.id);
            const allergy = allergies.find(a => a.id === allergyId);
            if (allergy) {
                document.getElementById('editAllergyId').value = allergy.id;
                document.getElementById('editAllergenName').value = allergy.name;
                document.getElementById('editAllergyReaction').value = allergy.reaction;
                document.getElementById('editAllergySeverity').value = allergy.severity;
                document.getElementById('editAllergyDateNoted').value = allergy.dateNoted;
            }
        }
    });

    document.getElementById('conditionsTableBody').addEventListener('click', function(event) {
        if (event.target.classList.contains('view-edit-condition')) {
            const conditionId = parseInt(event.target.dataset.id);
            const condition = conditions.find(c => c.id === conditionId);
            if (condition) {
                document.getElementById('editConditionId').value = condition.id;
                document.getElementById('editConditionName').value = condition.name;
                document.getElementById('editConditionDiagnosisDate').value = condition.diagnosisDate;
                document.getElementById('editConditionStatus').value = condition.status;
                document.getElementById('editConditionDiagnosedBy').value = condition.diagnosedBy;
            }
        }
    });

    // View/Edit Modals - Form Submission (Update)
    document.getElementById('viewEditMedicationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const medId = parseInt(document.getElementById('editMedicationId').value);
        const medicationIndex = medications.findIndex(med => med.id === medId);
        if (medicationIndex > -1) {
            medications[medicationIndex] = {
                id: medId,
                name: document.getElementById('editMedicationName').value,
                dosage: document.getElementById('editMedicationDosage').value,
                frequency: document.getElementById('editMedicationFrequency').value,
                prescribedBy: document.getElementById('editMedicationPrescribedBy').value,
                datePrescribed: document.getElementById('editMedicationDatePrescribed').value
            };
            renderMedications();
            bootstrap.Modal.getInstance(document.getElementById('viewEditMedicationModal')).hide();
        }
    });

    document.getElementById('viewEditTestResultForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const testId = parseInt(document.getElementById('editTestResultId').value);
        const testIndex = testResults.findIndex(test => test.id === testId);
        if (testIndex > -1) {
            testResults[testIndex] = {
                id: testId,
                name: document.getElementById('editTestName').value,
                datePerformed: document.getElementById('editTestDatePerformed').value,
                result: document.getElementById('editTestResult').value,
                orderedBy: document.getElementById('editTestOrderedBy').value
            };
            renderTestResults();
            bootstrap.Modal.getInstance(document.getElementById('viewEditTestResultModal')).hide();
        }
    });

    document.getElementById('viewEditImmunizationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const immId = parseInt(document.getElementById('editImmunizationId').value);
        const immIndex = immunizations.findIndex(imm => imm.id === immId);
        if (immIndex > -1) {
            immunizations[immIndex] = {
                id: immId,
                name: document.getElementById('editVaccineName').value,
                dateAdministered: document.getElementById('editImmunizationDateAdministered').value,
                administeredBy: document.getElementById('editImmunizationAdministeredBy').value
            };
            renderImmunizations();
            bootstrap.Modal.getInstance(document.getElementById('viewEditImmunizationModal')).hide();
        }
    });

    document.getElementById('viewEditAllergyForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const allergyId = parseInt(document.getElementById('editAllergyId').value);
        const allergyIndex = allergies.findIndex(allergy => allergy.id === allergyId);
        if (allergyIndex > -1) {
            allergies[allergyIndex] = {
                id: allergyId,
                name: document.getElementById('editAllergenName').value,
                reaction: document.getElementById('editAllergyReaction').value,
                severity: document.getElementById('editAllergySeverity').value,
                dateNoted: document.getElementById('editAllergyDateNoted').value
            };
            renderAllergies();
            bootstrap.Modal.getInstance(document.getElementById('viewEditAllergyModal')).hide();
        }
    });

    document.getElementById('viewEditConditionForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const conditionId = parseInt(document.getElementById('editConditionId').value);
        const conditionIndex = conditions.findIndex(condition => condition.id === conditionId);
        if (conditionIndex > -1) {
            conditions[conditionIndex] = {
                id: conditionId,
                name: document.getElementById('editConditionName').value,
                diagnosisDate: document.getElementById('editConditionDiagnosisDate').value,
                status: document.getElementById('editConditionStatus').value,
                diagnosedBy: document.getElementById('editConditionDiagnosedBy').value
            };
            renderConditions();
            bootstrap.Modal.getInstance(document.getElementById('viewEditConditionModal')).hide();
        }
    });

    // View/Edit Modals - Delete Functionality
    document.getElementById('deleteMedicationBtn').addEventListener('click', function() {
        const medId = parseInt(document.getElementById('editMedicationId').value);
        medications = medications.filter(med => med.id !== medId);
        renderMedications();
        bootstrap.Modal.getInstance(document.getElementById('viewEditMedicationModal')).hide();
    });

    document.getElementById('deleteTestResultBtn').addEventListener('click', function() {
        const testId = parseInt(document.getElementById('editTestResultId').value);
        testResults = testResults.filter(test => test.id !== testId);
        renderTestResults();
        bootstrap.Modal.getInstance(document.getElementById('viewEditTestResultModal')).hide();
    });

    document.getElementById('deleteImmunizationBtn').addEventListener('click', function() {
        const immId = parseInt(document.getElementById('editImmunizationId').value);
        immunizations = immunizations.filter(imm => imm.id !== immId);
        renderImmunizations();
        bootstrap.Modal.getInstance(document.getElementById('viewEditImmunizationModal')).hide();
    });

    document.getElementById('deleteAllergyBtn').addEventListener('click', function() {
        const allergyId = parseInt(document.getElementById('editAllergyId').value);
        allergies = allergies.filter(allergy => allergy.id !== allergyId);
        renderAllergies();
        bootstrap.Modal.getInstance(document.getElementById('viewEditAllergyModal')).hide();
    });

    document.getElementById('deleteConditionBtn').addEventListener('click', function() {
        const conditionId = parseInt(document.getElementById('editConditionId').value);
        conditions = conditions.filter(condition => condition.id !== conditionId);
        renderConditions();
        bootstrap.Modal.getInstance(document.getElementById('viewEditConditionModal')).hide();
    });
});