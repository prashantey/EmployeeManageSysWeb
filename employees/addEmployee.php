<?php

class Employee {
    public $id;
    public $name;
    public $age;
    public $address;
    public $number;
    public $salary;
    public $salaryPaid;
    public $dueSalary;
    public $totalSalary;
}

function addEmployee() {
    $employee = new Employee();
    $employee->id = $_POST["id"];
    $employee->name = $_POST["name"];
    $employee->number = $_POST["number"];
    $employee->age = $_POST["age"];
    $employee->address = $_POST["address"];
    $employee->salary = $_POST["salaryamt"];

    $file_path = __DIR__ . "/../employeesDetails/employeeRec.dat";
    $employees = file($file_path, FILE_IGNORE_NEW_LINES);

    foreach ($employees as $emp) {
        $existingEmployee = explode("\t", $emp);
        if ($existingEmployee[0] == $employee->id) {
            $response = array(
                "IsSuccess" => false,
                "message" => "Employee with ID $employee->id already exists."
            );
            echo json_encode($response);
            return;
        }
        if ($existingEmployee[2] == $employee->number) {
            $response = array(
                "IsSuccess" => false,
                "message" => "Employee with Number $employee->number already exists."
            );
            echo json_encode($response);
            return;
        }
    }

    $file = fopen($file_path, "a");
    if ($file) {
        $salaryPaid = 0;
        $totalSalary = 0;
        $employeeDueSalary = $employee->salary;
        fwrite($file, "$employee->id\t$employee->name\t$employee->number\t$employee->age\t$employee->address\t$employee->salary\t$salaryPaid\t$employeeDueSalary\t$totalSalary\n");
        fclose($file);
        $response = array(
            "IsSuccess" => true,
            "message" => "Employee added successfully."
        );
        echo json_encode($response);
    } else {
        $response = array(
            "IsSuccess" => false,
            "message" => "Failed to add employee. Please try again later."
        );
        echo json_encode($response);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    addEmployee();
}
?>
