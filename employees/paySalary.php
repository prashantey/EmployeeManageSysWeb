<?php

function paySalary($targetId, $targetNum, $amountToPay) {
    $file_path = __DIR__ . "/../employeesDetails/employeeRec.dat";
    $tempFile_path = __DIR__ . "/../employeesDetails/temp.txt";
    $file = fopen($file_path, "r");
    $tempFile = fopen($tempFile_path, "a");
    if (!$file) {
        return array(
            "IsSuccess" => false,
            "message" => "Error opening employeeRec.dat file"
        );
    }

    $employeeFound = false;
    while ($line = fgets($file)) {
        $employeeData = explode("\t", $line);
        if (count($employeeData) >= 9) {
            list($id, $name, $number, $age, $address, $salaryAmt, $salaryPaid, $dueSalary,$totalSalary) = $employeeData;
            if ($id == $targetId && $number == $targetNum) {
                $salaryAmt = (int)$salaryAmt;
                $salaryPaid = (int)$salaryPaid;
                $dueSalary = (int)$dueSalary;
                $totalSalary = (int)$totalSalary;
                
                
                
                if ($dueSalary == 0) {
                    fclose($file);
                    fclose($tempFile);
                    unlink($tempFile_path);
                    return array(
                        "IsSuccess" => false,
                        "message" => "Salary Already Paid"
                    );
                }elseif($amountToPay > $dueSalary){
                    fclose($file);
                    fclose($tempFile);
                    unlink($tempFile_path);
                    return array(
                        "IsSuccess" => false,
                        "message" => "Salary Too High Compared to Due Salary.."
                    );
                }

                $salaryPaid += $amountToPay;
                $dueSalary = $salaryAmt - $salaryPaid;
                $totalSalary += $amountToPay;
                
                if ($dueSalary <= 0) {
                    $salaryPaid = 0;
                    $dueSalary = $salaryAmt;
                }
                
                

                fwrite($tempFile, "$id\t$name\t$number\t$age\t$address\t$salaryAmt\t$salaryPaid\t$dueSalary\t$totalSalary\n");
                $employeeFound = true;
            } else {
                fwrite($tempFile, $line);
            }
        }
    }

    fclose($file);
    fclose($tempFile);

    if ($employeeFound) {
        unlink($file_path);
        rename($tempFile_path, $file_path);
        return array(
            "IsSuccess" => true
        );
    } else {
        unlink($tempFile_path);
        return array(
            "IsSuccess" => false,
            "message" => "Employee Not Found With That ID Or Number"
        );
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) && isset($_POST["amount_to_pay"]) && isset($_POST["number"])) {
        $employeeId = $_POST["id"];
        $amountToPay = $_POST["amount_to_pay"];
        $employeeNumber = $_POST["number"];

        $result = paySalary($employeeId, $employeeNumber, $amountToPay);
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        $response = array(
            "IsSuccess" => false,
            "message" => "Missing parameters"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    $response = array(
        "IsSuccess" => false,
        "message" => "Invalid request method"
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
