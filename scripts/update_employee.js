document.addEventListener("DOMContentLoaded", function () {
    // Add Comorbidity
    const addComorbidityButton = document.getElementById("AddComorbidity");
    const comorbiditiesContainer = document.getElementById("ComorbiditiesContainer");

    if (addComorbidityButton) {
        addComorbidityButton.addEventListener("click", function () {
            const div = document.createElement("div");
            div.innerHTML = `
                <label>Comorbidity Details:</label>
                <input type="text" name="ComorbiditiesDetails[]" required>
                <label>Maintenance Medication (Yes/No):</label>
                <select name="MaintenanceMedication[]" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <label>Medication and Dosage:</label>
                <input type="text" name="MedicationAndDosage[]" required>
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
            `;
            comorbiditiesContainer.appendChild(div);
        });
    }

    // Add Surgery
    const addSurgeryButton = document.getElementById("AddSurgery");
    const surgeryContainer = document.getElementById("SurgeryContainer");

    if (addSurgeryButton) {
        addSurgeryButton.addEventListener("click", function () {
            const div = document.createElement("div");
            div.innerHTML = `
                <label>Surgery Name:</label>
                <input type="text" name="OperationName[]" required>
                <label>Date Performed:</label>
                <input type="date" name="DatePerformed[]" required>
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
            `;
            surgeryContainer.appendChild(div);
        });
    }

    // Add Clinic Record
    const addClinicRecordButton = document.getElementById("AddClinicRecord");
    const clinicRecordContainer = document.getElementById("ClinicRecordContainer");

    if (addClinicRecordButton) {
        addClinicRecordButton.addEventListener("click", function () {
            const div = document.createElement("div");
            div.innerHTML = `
                <label>Visit Date:</label>
                <input type="date" name="VisitDate[]" required>
                <label>Complaints:</label>
                <input type="text" name="Complaints[]" required>
                <label>Intervention:</label>
                <input type="text" name="Intervention[]" required>
                <label>Nurse on Duty:</label>
                <input type="text" name="NurseOnDuty[]" required>
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
            `;
            clinicRecordContainer.appendChild(div);
        });
    }

    const employeeTableContainer = document.getElementById("employeeTableContainer");
    const employeeDetails = document.getElementById("employeeDetails");
    const searchForm = document.getElementById("searchForm");
    const goBackButton = document.getElementById("goBackButton");
    const cancelButton = document.getElementById("cancelButton");

    // Event delegation for table rows
    const employeeTable = document.getElementById("employeeTable");
    if (employeeTable) {
        employeeTable.addEventListener("click", function (event) {
            const row = event.target.closest(".employee-row");
            if (row) {
                const employeeID = row.getAttribute("data-id");
                if (employeeID) {
                    // Submit a form to load the employee details for editing
                    const form = document.createElement("form");
                    form.method = "GET";
                    form.action = "update_employee.php";

                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "EmployeeID";
                    input.value = employeeID;
                    
                    // Optionally, load employee details dynamically (if needed)
                    console.log(`Editing employee with ID: ${employeeID}`);

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
    }

    // Cancel Button
    if (cancelButton) {
        cancelButton.addEventListener("click", function () {
            const confirmCancel = confirm("Are you sure you want to cancel? All changes will be lost.");
            if (confirmCancel) {
                // Show search and table list, hide employee details
                searchForm.style.display = "block";
                employeeTableContainer.style.display = "block";
                employeeDetails.style.display = "none";
                goBackButton.style.display = "none";
                cancelButton.style.display = "none";
            }
        });
    }

    // Go Back Button
    if (goBackButton) {
        goBackButton.addEventListener("click", () => {
            employeeDetails.style.display = "none";
            employeeTableContainer.style.display = "block";
            searchForm.style.display = "block";
            goBackButton.style.display = "none";
            cancelButton.style.display = "none";
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const employeeTableContainer = document.getElementById("employeeTableContainer");
    const employeeDetails = document.getElementById("employeeDetails");
    const cancelButton = document.getElementById("cancelButton");

    // Cancel Button Functionality
    if (cancelButton) {
        cancelButton.addEventListener("click", function () {
            const confirmCancel = confirm("Are you sure you want to cancel? All changes will be lost.");
            if (confirmCancel) {
                // Show search form and table list
                searchForm.style.display = "block";
                employeeTableContainer.style.display = "block";

                // Hide the employee details form
                employeeDetails.style.display = "none";
            }
        });
    }
});