document.addEventListener("DOMContentLoaded", () => {
    const sortOrder = document.getElementById("sortOrder");
    const employeeTable = document.getElementById("employeeTable");
    const rows = Array.from(employeeTable.querySelectorAll("tbody tr"));
    const employeeTableContainer = document.getElementById("employeeTableContainer");
    const employeeDetails = document.getElementById("employeeDetails");
    const goBackButton = document.getElementById("goBackButton");
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const content = document.querySelector(".content");
    const searchForm = document.getElementById("searchForm");
    const convertToPdfButton = document.querySelector(".convert-to-pdf");

    // Function to sort rows
    const sortRows = (order) => {
        const sortedRows = rows.sort((a, b) => {
            const nameA = a.cells[1].textContent.toLowerCase();
            const nameB = b.cells[1].textContent.toLowerCase();
            if (order === "asc") {
                return nameA.localeCompare(nameB);
            } else {
                return nameB.localeCompare(nameA);
            }
        });

        // Clear and re-append sorted rows
        const tbody = employeeTable.querySelector("tbody");
        tbody.innerHTML = "";
        sortedRows.forEach((row) => tbody.appendChild(row));
    };

    // Event listener for sort dropdown
    sortOrder.addEventListener("change", (e) => {
        sortRows(e.target.value);
    });

    // Default sort (A-Z)
    sortRows("asc");

    // Add click event to rows
    rows.forEach((row) => {
        row.addEventListener("click", () => {
            const employeeID = row.getAttribute("data-id");
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "view_employee.php";

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "EmployeeID";
            input.value = employeeID;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        });
    });

    // Go Back Button
    goBackButton.addEventListener("click", () => {
        employeeDetails.style.display = "none";
        employeeTableContainer.style.display = "block";
        goBackButton.style.display = "none";
    });

    // Go Back Button Functionality
    if (goBackButton) {
        goBackButton.addEventListener("click", function () {
            // Hide the employee details section
            if (employeeDetails) {
                employeeDetails.style.display = "none";
            }

            // Show the search form and employee table
            if (searchForm) {
                searchForm.style.display = "block";
            }
            if (employeeTableContainer) {
                employeeTableContainer.style.display = "block";
            }

            // Hide the Convert to PDF button
            if (convertToPdfButton) {
                convertToPdfButton.style.display = "none";
            }

            // Hide the Go Back button
            goBackButton.style.display = "none";
        });
    }
});