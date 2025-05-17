<?php include 'functions/sidebar.php'; ?>
<?php
// Include database connection
include 'functions/connector.php';

// Fetch statistics
// Count males and females
$genderQuery = "SELECT Gender, COUNT(*) as count FROM BasicInformation GROUP BY Gender";
$genderResult = $conn->query($genderQuery);
$genderData = [];
while ($row = $genderResult->fetch_assoc()) {
    $genderData[$row['Gender']] = $row['count'];
}

// Count people with comorbidities
$comorbiditiesQuery = "SELECT COUNT(DISTINCT EmployeeID) as count FROM WithComorbidities WHERE HasComorbidities = 'Yes'";
$comorbiditiesResult = $conn->query($comorbiditiesQuery);
$comorbiditiesCount = $comorbiditiesResult->fetch_assoc()['count'];

// Count people who underwent an operation
$operationQuery = "SELECT COUNT(DISTINCT EmployeeID) as count FROM Operations";
$operationResult = $conn->query($operationQuery);
$operationCount = $operationResult->fetch_assoc()['count'];

// Males with/without comorbidities
$maleWithComorb = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN WithComorbidities w ON b.EmployeeID = w.EmployeeID
    WHERE b.Gender = 'Male' AND w.HasComorbidities = 'Yes'")->fetch_assoc()['count'];

$maleWithoutComorb = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN WithComorbidities w ON b.EmployeeID = w.EmployeeID
    WHERE b.Gender = 'Male' AND (w.HasComorbidities = 'No' OR w.HasComorbidities IS NULL)")->fetch_assoc()['count'];

// Females with/without comorbidities
$femaleWithComorb = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN WithComorbidities w ON b.EmployeeID = w.EmployeeID
    WHERE b.Gender = 'Female' AND w.HasComorbidities = 'Yes'")->fetch_assoc()['count'];

$femaleWithoutComorb = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN WithComorbidities w ON b.EmployeeID = w.EmployeeID
    WHERE b.Gender = 'Female' AND (w.HasComorbidities = 'No' OR w.HasComorbidities IS NULL)")->fetch_assoc()['count'];

// Males with/without operation
$maleWithOp = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN Operations o ON b.EmployeeID = o.EmployeeID
    WHERE b.Gender = 'Male' AND o.EmployeeID IS NOT NULL")->fetch_assoc()['count'];

$maleWithoutOp = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN Operations o ON b.EmployeeID = o.EmployeeID
    WHERE b.Gender = 'Male' AND o.EmployeeID IS NULL")->fetch_assoc()['count'];

// Females with/without operation
$femaleWithOp = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN Operations o ON b.EmployeeID = o.EmployeeID
    WHERE b.Gender = 'Female' AND o.EmployeeID IS NOT NULL")->fetch_assoc()['count'];

$femaleWithoutOp = $conn->query("SELECT COUNT(DISTINCT b.EmployeeID) as count
    FROM BasicInformation b
    LEFT JOIN Operations o ON b.EmployeeID = o.EmployeeID
    WHERE b.Gender = 'Female' AND o.EmployeeID IS NULL")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" href="styles/statistics.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="styles/sidebar.css"> <!-- Include sidebar styles -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Statistics</h1>

        <!-- Gender Distribution Chart -->
        <div class="chart-container">
            <canvas id="genderChart"></canvas>
        </div>

        <!-- Comorbidities Chart -->
        <div class="chart-container">
            <canvas id="comorbiditiesChart"></canvas>
        </div>

        <!-- Operations Chart -->
        <div class="chart-container">
            <canvas id="operationsChart"></canvas>
        </div>

        <div class="chart-container">
            <canvas id="comorbidityByGenderChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="operationByGenderChart"></canvas>
        </div>
    </div>

    <script id="genderData" type="application/json">
        <?php echo json_encode([
            'labels' => array_keys($genderData),
            'datasets' => [[
                'label' => 'Number of People',
                'data' => array_values($genderData),
                'backgroundColor' => ['#36A2EB', '#FF6384'], // Blue for males, red for females
                'borderColor' => ['#36A2EB', '#FF6384'],
                'borderWidth' => 1
            ]]
        ]); ?>
    </script>

    <script id="comorbiditiesData" type="application/json">
        <?php echo json_encode([
            'labels' => ['With Comorbidities', 'Without Comorbidities'],
            'datasets' => [[
                'label' => 'Number of People',
                'data' => [$comorbiditiesCount, array_sum($genderData) - $comorbiditiesCount],
                'backgroundColor' => ['#FFCE56', '#4BC0C0'], // Yellow and teal
                'borderColor' => ['#FFCE56', '#4BC0C0'],
                'borderWidth' => 1
            ]]
        ]); ?>
    </script>

    <script id="operationsData" type="application/json">
        <?php echo json_encode([
            'labels' => ['Underwent Surgery', 'Did Not Undergo Surgery'],
            'datasets' => [[
                'label' => 'Number of People',
                'data' => [$operationCount, array_sum($genderData) - $operationCount],
                'backgroundColor' => ['#9966FF', '#FF9F40'], // Purple and orange
                'borderColor' => ['#9966FF', '#FF9F40'],
                'borderWidth' => 1
            ]]
        ]); ?>
    </script>

    <script id="comorbidityByGenderData" type="application/json">
        <?php
        echo json_encode([
            'labels' => ['Males With', 'Males Without', 'Females With', 'Females Without'],
            'datasets' => [[
                'label' => 'Comorbidities',
                'data' => [
                    (int)$maleWithComorb,
                    (int)$maleWithoutComorb,
                    (int)$femaleWithComorb,
                    (int)$femaleWithoutComorb
                ],
                'backgroundColor' => ['#36A2EB', '#B2DFFC', '#FF6384', '#FFB1C1']
            ]]
        ]);
        ?>
    </script>

    <script id="operationByGenderData" type="application/json">
        <?php
        echo json_encode([
            'labels' => ['Males With', 'Males Without', 'Females With', 'Females Without'],
            'datasets' => [[
                'label' => 'Operations',
                'data' => [
                    (int)$maleWithOp,
                    (int)$maleWithoutOp,
                    (int)$femaleWithOp,
                    (int)$femaleWithoutOp
                ],
                'backgroundColor' => ['#36A2EB', '#B2DFFC', '#FF6384', '#FFB1C1']
            ]]
        ]);
        ?>
    </script>
    <script src="scripts/statistics.js"></script>
    <script src="scripts/sidebar.js"></script>
</body>
</html>