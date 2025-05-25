<?php
// filepath: c:\xampp\htdocs\HPR_3\remove_employee.php
include 'functions/connector.php'; // Include database connection
include 'functions/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EmployeeID'])) {
    $employeeID = $_POST['EmployeeID'];

    // Delete related records in all referencing tables first
    $conn->query("DELETE FROM UnderwentSurgery WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM WithComorbidities WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM Comorbidities WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM Operations WHERE EmployeeID = '$employeeID'");
    $conn->query("DELETE FROM SchoolClinicRecord WHERE EmployeeID = '$employeeID'");

    // Delete employee from the database
    $stmt = $conn->prepare("DELETE FROM BasicInformation WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    if ($stmt->execute()) {
        echo "<script>alert('Employee removed successfully.');</script>";
    } else {
        echo "<script>alert('Error removing employee.');</script>";
    }
    $stmt->close();
}

// Fetch all employees
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT EmployeeID, FirstName, LastName, Position FROM BasicInformation";
if ($search !== '') {
    $searchEscaped = $conn->real_escape_string($search);
    $query .= " WHERE EmployeeID LIKE '%$searchEscaped%' OR CONCAT(FirstName, ' ', LastName) LIKE '%$searchEscaped%' OR CONCAT(LastName, ' ', FirstName) LIKE '%$searchEscaped%'";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Employee</title>
    <link rel="stylesheet" href="styles/remove_employee.css"> <!-- Use existing styles -->
    <link rel="stylesheet" href="styles/sidebar.css"> <!-- Include sidebar styles -->
</head>
<body>
    <div class="container">
        <h1>Remove Employee</h1>
        <!-- Search Bar -->
        <form method="GET" style="margin-bottom: 15px;">
            <input type="text" name="search" placeholder="Search by Employee ID or Name" value="<?php echo htmlspecialchars($search); ?>" style="padding: 7px; width: 250px; font-size: 14px; border-radius: 4px; border: 1px solid #ccc;">
            <button type="submit" style="background-color: #007BFF; color: white; padding: 7px 14px; border-radius: 4px; border: none; font-size: 14px; margin-left: 5px;">Search</button>
            <?php if ($search !== ''): ?>
                <a href="remove_employee.php" style="margin-left: 10px; color: #007BFF; text-decoration: underline; font-size: 13px;">Clear</a>
            <?php endif; ?>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['EmployeeID']; ?></td>
                            <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                            <td><?php echo $row['Position']; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to remove this employee?');">
                                    <input type="hidden" name="EmployeeID" value="<?php echo $row['EmployeeID']; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No employees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Back Button -->
        <a href="index.php" class="back-button">Back to Main Menu</a>
    </div>
    <script src="scripts/sidebar.js"></script>
</body>
</html>