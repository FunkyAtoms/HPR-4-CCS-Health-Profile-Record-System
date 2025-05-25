<?php
include 'functions/connector.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['EmployeeID'])) {
    $employeeID = $_GET['EmployeeID'];

    // Fetch employee basic information
    $stmt = $conn->prepare("SELECT * FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $result = $stmt->get_result();
    $employeeData = $result->fetch_assoc();

    if (!$employeeData) {
        header("Location: update_employee.php?error=Employee not found.");
        exit();
    }

    // Fetch comorbidities
    $stmt = $conn->prepare("SELECT * FROM Comorbidities WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $comorbidities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch surgeries
    $stmt = $conn->prepare("SELECT * FROM Operations WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $surgeries = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch school clinic records
    $stmt = $conn->prepare("SELECT * FROM SchoolClinicRecord WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $clinicRecords = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    // Combine all data into one array
    $employeeData['Comorbidities'] = $comorbidities;
    $employeeData['Surgeries'] = $surgeries;
    $employeeData['ClinicRecords'] = $clinicRecords;

    // Pass data back to update_employee.php
    header("Location: update_employee.php?EmployeeID=$employeeID&data=" . urlencode(json_encode($employeeData)));
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['UpdateEmployee'])) {
    // Update employee basic information
    $employeeID = $_POST['EmployeeID'];
    $lastName = $_POST['LastName'];
    $firstName = $_POST['FirstName'];
    $middleInitial = $_POST['MiddleInitial'];
    $position = $_POST['Position'];
    $birthdate = $_POST['Birthdate'];
    $age = $_POST['Age'];
    $gender = $_POST['Gender'];
    $civilStatus = $_POST['CivilStatus'];
    $address = $_POST['Address'];
    $height = $_POST['Height'];
    $weight = $_POST['Weight'];
    $foodAllergies = $_POST['FoodAllergies'];
    $contactNumber = $_POST['ContactNumber'];
    $emergencyContactPerson = $_POST['EmergencyContactPerson'];
    $emergencyContactRelationship = $_POST['EmergencyContactRelationship'];
    $emergencyContactNumber = $_POST['EmergencyContactNumber'];

    $sql = "UPDATE BasicInformation 
            SET LastName = ?, FirstName = ?, MiddleInitial = ?, Position = ?, Birthdate = ?, Age = ?, Gender = ?, CivilStatus = ?, Address = ?, Height = ?, Weight = ?, FoodAllergies = ?, ContactNumber = ?, EmergencyContactPerson = ?, EmergencyContactRelationship = ?, EmergencyContactNumber = ?
            WHERE EmployeeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssi",
        $lastName,
        $firstName,
        $middleInitial,
        $position,
        $birthdate,
        $age,
        $gender,
        $civilStatus,
        $address,
        $height,
        $weight,
        $foodAllergies,
        $contactNumber,
        $emergencyContactPerson,
        $emergencyContactRelationship,
        $emergencyContactNumber,
        $employeeID
    );

    if (!$stmt->execute()) {
        header("Location: update_employee.php?error=Error updating record: " . $conn->error);
        exit();
    }

    // Delete all old comorbidities, surgeries, and clinic records for this employee
    $conn->query("DELETE FROM Comorbidities WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM Operations WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM SchoolClinicRecord WHERE EmployeeID = '$employeeID'");

    // Append Comorbidities
    if (isset($_POST['ComorbiditiesDetails'])) {
        foreach ($_POST['ComorbiditiesDetails'] as $index => $details) {
            $details = $conn->real_escape_string($details);
            $medication = $conn->real_escape_string($_POST['MaintenanceMedication'][$index]);
            $dosage = $conn->real_escape_string($_POST['MedicationAndDosage'][$index]);

            $sql = "INSERT INTO Comorbidities (EmployeeID, ComorbiditiesDetails, MaintenanceMedication, MedicationAndDosage)
                    VALUES ('$employeeID', '$details', '$medication', '$dosage')";
            $conn->query($sql);
        }
    }

    // Append Surgeries
    if (isset($_POST['OperationName'])) {
        foreach ($_POST['OperationName'] as $index => $name) {
            $name = $conn->real_escape_string($name);
            $date = $conn->real_escape_string($_POST['DatePerformed'][$index]);

            $sql = "INSERT INTO Operations (EmployeeID, OperationName, DatePerformed)
                    VALUES ('$employeeID', '$name', '$date')";
            $conn->query($sql);
        }
    }

    // Append School Clinic Records
    if (isset($_POST['VisitDate'])) {
        foreach ($_POST['VisitDate'] as $index => $visitDate) {
            $visitDate = $conn->real_escape_string($visitDate);
            $complaints = $conn->real_escape_string($_POST['Complaints'][$index]);
            $intervention = $conn->real_escape_string($_POST['Intervention'][$index]);
            $nurse = $conn->real_escape_string($_POST['NurseOnDuty'][$index]);

            $sql = "INSERT INTO SchoolClinicRecord (EmployeeID, VisitDate, Complaints, Intervention, NurseOnDuty)
                    VALUES ('$employeeID', '$visitDate', '$complaints', '$intervention', '$nurse')";
            $conn->query($sql);
        }
    }

    // Update WithComorbidities
    $withComorbidities = $_POST['WithComorbidities'];
    // Check if a record exists for this employee
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM WithComorbidities WHERE EmployeeID = ?");
    $checkStmt->bind_param("i", $employeeID);
    $checkStmt->execute();
    $count = $checkStmt->get_result()->fetch_row()[0];
    $checkStmt->close();

    if ($count > 0) {
        // Update existing record
        $updateStmt = $conn->prepare("UPDATE WithComorbidities SET HasComorbidities = ? WHERE EmployeeID = ?");
        $updateStmt->bind_param("si", $withComorbidities, $employeeID);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO WithComorbidities (EmployeeID, HasComorbidities) VALUES (?, ?)");
        $insertStmt->bind_param("is", $employeeID, $withComorbidities);
        $insertStmt->execute();
        $insertStmt->close();
    }

    // Update UnderwentSurgery (similar logic as WithComorbidities)
    $underwentSurgery = $_POST['UnderwentSurgery'];
    // Check if a record exists
    $checkStmt2 = $conn->prepare("SELECT COUNT(*) FROM UnderwentSurgery WHERE EmployeeID = ?");
    $checkStmt2->bind_param("i", $employeeID);
    $checkStmt2->execute();
    $count2 = $checkStmt2->get_result()->fetch_row()[0];
    $checkStmt2->close();

    if ($count2 > 0) {
        // Update existing record
        $updateStmt2 = $conn->prepare("UPDATE UnderwentSurgery SET HasUndergoneSurgery = ? WHERE EmployeeID = ?"); // Changed column name
        $updateStmt2->bind_param("si", $underwentSurgery, $employeeID);
        $updateStmt2->execute();
        $updateStmt2->close();
    } else {
        // Insert new record
        $insertStmt2 = $conn->prepare("INSERT INTO UnderwentSurgery (EmployeeID, HasUndergoneSurgery) VALUES (?, ?)");  // Changed column name
        $insertStmt2->bind_param("is", $underwentSurgery, $employeeID);
        $insertStmt2->execute();
        $insertStmt2->close();
    }

    header("Location: index.php?success=1");
    exit();
}

$conn->close();
?>