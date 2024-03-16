<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        h1 {
            text-align: center;
        }

        body {
            background: #636381;
            color: black
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            text-align: center;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Employee Details</h1>

    <?php
    
    $file_path = __DIR__ . "/../employeesDetails/employeeRec.dat";
    $file = fopen($file_path, "r");

    echo '<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Age</th>
        <th>Address</th>
        <th>Salary</th>
        <th>Salary Paid</th>
        <th>Due Salary</th>
        <th>TotalSalary<br>Received</th>
    </tr>
    </thead>
    <tbody>';
    
    while ($line = fgets($file)) {
        $employeeData = explode("\t", $line);
        if (count($employeeData) >= 9) {
            list($id, $name, $number, $age, $address, $salaryAmt, $salaryPaid, $dueSalary, $totalSalary) = $employeeData;
    
            echo '<tr>
                <td>' . $id . '</td>
                <td>' . $name . '</td>
                <td>' . $number . '</td>
                <td>' . $age . '</td>
                <td>' . $address . '</td>
                <td>' . $salaryAmt . '</td>
                <td>' . $salaryPaid . '</td>
                <td>' . $dueSalary . '</td>
                <td>' . $totalSalary . '</td>
            </tr>';
        }
    }
    echo '</tbody></table>';

    fclose($file);
    ?>

</body>

</html>