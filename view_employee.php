<?php
include 'functions/connector.php';
include 'functions/sidebar.php';

$employeeData = null; // Variable to store fetched employee data

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmployeeID'])) {
    $employeeID = $_POST['EmployeeID'];

    // Fetch Basic Information
    $stmt = $conn->prepare("SELECT * FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $result = $stmt->get_result();
    $employeeData = $result->fetch_assoc();

    if ($employeeData) {
        // Fetch additional data (e.g., comorbidities, surgeries, etc.)
        $stmt = $conn->prepare("SELECT * FROM WithComorbidities WHERE EmployeeID = ?");
        $stmt->bind_param("i", $employeeID);
        $stmt->execute();
        $comorbiditiesStatus = $stmt->get_result()->fetch_assoc();

        $stmt = $conn->prepare("SELECT * FROM Comorbidities WHERE EmployeeID = ?");
        $stmt->bind_param("i", $employeeID);
        $stmt->execute();
        $comorbidities = $stmt->get_result();

        $stmt = $conn->prepare("SELECT * FROM UnderwentSurgery WHERE EmployeeID = ?");
        $stmt->bind_param("i", $employeeID);
        $stmt->execute();
        $underwentSurgeryStatus = $stmt->get_result()->fetch_assoc();

        $stmt = $conn->prepare("SELECT * FROM Operations WHERE EmployeeID = ?");
        $stmt->bind_param("i", $employeeID);
        $stmt->execute();
        $surgeries = $stmt->get_result();

        $stmt = $conn->prepare("SELECT * FROM SchoolClinicRecord WHERE EmployeeID = ?");
        $stmt->bind_param("i", $employeeID);
        $stmt->execute();
        $clinicRecords = $stmt->get_result();
    }

    $stmt->close();
}

// Fetch all employees for the table
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT EmployeeID, FirstName, LastName FROM BasicInformation";
if ($search !== '') {
    $searchEscaped = $conn->real_escape_string($search);
    $query .= " WHERE EmployeeID LIKE '%$searchEscaped%' OR CONCAT(FirstName, ' ', LastName) LIKE '%$searchEscaped%' OR CONCAT(LastName, ' ', FirstName) LIKE '%$searchEscaped%'";
}
$allEmployees = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="styles/view_employee.css">
    <link rel="stylesheet" href="styles/sidebar.css">
</head>
<body>
    <h1>View Employee Details</h1>

    <!-- Form to search using Employee ID -->
    <form method="POST" id="searchForm">
        <label for="EmployeeID">Enter Employee ID:</label>
        <input type="number" id="EmployeeID" name="EmployeeID" required>
        <button type="submit">Search</button>
    </form>

    <!-- Display Employee Data -->
    <div id="employeeDetails" style="display: <?php echo $employeeData ? 'block' : 'none'; ?>;">
        <?php if ($employeeData): ?>
            <div class="parent">
                <!-- Heading -->
                <div class="div1">
                    <h2>Employee Details</h2>
                </div>

                <!-- Basic Information -->
                <div class="div2">
                    <h3>Basic Information</h3>
                    <p><strong>Employee ID:</strong> <?php echo $employeeData['EmployeeID']; ?></p> <!-- Added -->
                    <p><strong>Name:</strong> <?php echo $employeeData['FirstName'] . " " . $employeeData['LastName']; ?></p>
                    <p><strong>Position:</strong> <?php echo $employeeData['Position']; ?></p>
                    <p><strong>Birthdate:</strong> <?php echo $employeeData['Birthdate']; ?></p>
                    <p><strong>Age:</strong> <?php echo $employeeData['Age']; ?></p>
                    <p><strong>Gender:</strong> <?php echo $employeeData['Gender']; ?></p>
                    <p><strong>Civil Status:</strong> <?php echo $employeeData['CivilStatus']; ?></p> <!-- Added -->
                    <p><strong>Address:</strong> <?php echo $employeeData['Address']; ?></p>
                    <p><strong>Height:</strong> <?php echo $employeeData['Height']; ?> ft</p> <!-- Added -->
                    <p><strong>Weight:</strong> <?php echo $employeeData['Weight']; ?> kg</p> <!-- Added -->
                    <p><strong>Food Allergies:</strong> <?php echo $employeeData['FoodAllergies']; ?></p> <!-- Added -->
                    <p><strong>Contact Number:</strong> <?php echo $employeeData['ContactNumber']; ?></p>
                    <p><strong>Emergency Contact:</strong> <?php echo $employeeData['EmergencyContactPerson'] . " (" . $employeeData['EmergencyContactRelationship'] . "), " . $employeeData['EmergencyContactNumber']; ?></p>
                </div>

                <!-- Employee Profile Image -->
                <div class="div3">
                    <h3>Profile Image</h3>
                    <?php if ($employeeData['ProfileImagePath']): ?>
                        <img src="<?php echo $employeeData['ProfileImagePath']; ?>" alt="Profile Image" width="150">
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                </div>

                <!-- With Comorbidities -->
                <div class="div4">
                    <h3>HEALTH PROFILE</h3>
                    <?php if ($comorbiditiesStatus): ?>
                        <p>WITH COMORBIDITIES (HEALTH PROBLEM): <?php echo $comorbiditiesStatus['HasComorbidities']; ?></p>
                    <?php else: ?>
                        <p>No comorbidities status available.</p>
                    <?php endif; ?>
                </div>

                <!-- Comorbidities Table -->
                <div class="div5">
                    <?php if ($comorbidities->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>DETAILS</th>
                                    <th>WITH MAINTENANCE MEDICATION</th>
                                    <th>NAME AND DOSAGE OF MAINTENANCE MEDICATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $comorbidities->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['ComorbiditiesDetails']; ?></td>
                                        <td><?php echo $row['MaintenanceMedication']; ?></td>
                                        <td><?php echo $row['MedicationAndDosage']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No comorbidities listed.</p>
                    <?php endif; ?>
                </div>
                
                
                <!-- Surgeries Table -->
                <div class="div6">
                    <h3>OPERATIONS</h3>
                    <table>
                        <tr>
                            <th>HAS UNDERGONE ANY SURGICAL PROCEDURE (EX. CESAREAN SECTION/TUMOR REMOVAL, ETC)</th>
                            <td><?php echo $underwentSurgeryStatus ? $underwentSurgeryStatus['HasUndergoneSurgery'] : 'No surgery status available'; ?></td>
                        </tr>
                    </table>

                    <?php if ($surgeries->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>OPERATION NAME</th>
                                    <th>DATE PERFORMED</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $surgeries->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['OperationName']; ?></td>
                                        <td><?php echo $row['DatePerformed']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No surgeries listed.</p>
                    <?php endif; ?>
                </div>

                <!-- School Clinic Records Table -->
                <div class="div8">
                    <h3>SCHOOL CLINIC RECORD</h3>
                    <?php if ($clinicRecords->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>VISIT DATE</th>
                                    <th>COMPLAINTS</th>
                                    <th>INTERVENTION</th>
                                    <th>NURSE ON DUTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $clinicRecords->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['VisitDate']; ?></td>
                                        <td><?php echo $row['Complaints']; ?></td>
                                        <td><?php echo $row['Intervention']; ?></td>
                                        <td><?php echo $row['NurseOnDuty']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No school clinic records found.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No employee found with the given ID. Please try again.</p>
        <?php endif; ?>
    </div>

    <!-- Table of All Employees -->
    <div id="employeeTableContainer" style="display: <?php echo $employeeData ? 'none' : 'block'; ?>;">
        <h2>All Employees</h2>
        <div class="employee-table-container">
            <label for="sortOrder">Sort by Name:</label>
            <select id="sortOrder">
                <option value="asc">A-Z</option>
                <option value="desc">Z-A</option>
            </select>
            <table id="employeeTable">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $allEmployees->fetch_assoc()): ?>
                        <tr class="employee-row" data-id="<?php echo $row['EmployeeID']; ?>">
                            <td><?php echo $row['EmployeeID']; ?></td>
                            <td><?php echo $row['LastName'] . ', ' . $row['FirstName']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back and Go Back Buttons -->
    <div class="navigation-buttons">
        <a href="index.php">Back to Main Menu</a>
        <button id="goBackButton" style="display: <?php echo $employeeData ? 'inline-block' : 'none'; ?>;">Go Back</button>
    </div>
    <!-- Convert to PDF Button -->
    <?php if ($employeeData): ?>
        <form method="POST" action="generate_pdf.php" target="_blank">
            <input type="hidden" name="EmployeeID" value="<?php echo $employeeData['EmployeeID']; ?>">
            <button type="submit" class="convert-to-pdf">Convert to PDF</button>
        </form>
    <?php endif; ?>
    <script src="scripts/view_employee.js"></script>
    <script src="scripts/sidebar.js"></script>
</body>
</html>