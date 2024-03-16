<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SearchEmployee</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
        h1{
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

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #636363;
        }
    </style>
    </head>
    <body>
    <?php
   if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $employeeId = $_GET["id"];
    $file_path = __DIR__ . "/../employeesDetails/employeeRec.dat";
    $file = fopen($file_path, "r");
    
    echo("<h1>Details of employee  $employeeId</h1>");
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

    $found = false;

    while ($line = fgets($file)) {
        $employeeData = explode("\t", $line);

        if (count($employeeData) >= 9) {
            list($id, $name, $number, $age, $address, $salaryAmt, $salaryPaid, $dueSalary,$totalSalary) = $employeeData;

            if ($id == $employeeId || $number == $employeeId) {
                echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $name . '</td>
                        <td>' . $number . '</td>
                        <td>' . $age . '</td>
                        <td>' . $address . '</td>
                        <td>' . $salaryAmt . '</td>
                        <td>' . $salaryPaid . '</td>
                        <td>' . $dueSalary . '</td>
                        <td>' . $totalSalary .'</td>
                    </tr>';
                $found = true;
            }
        }
    }

    echo '</tbody></table>';
    fclose($file);

    if (!$found) {
        echo '<script>
        Swal.fire({
            title: "No results found for  ' . $employeeId . '",
            icon: "error"
        });
        setTimeout(function() {
            window.history.back();
        }, 5000);    </script>';
    }
}
    ?>
</body>
</html>