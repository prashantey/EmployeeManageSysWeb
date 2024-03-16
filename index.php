<?php
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$routes = [
    '/showAllEmployees' => 'employees/showAllEmployees.php',
    '/employeeRec.dat' => 'employeesDetails/employeeRec.dat',
    '/searchEmployee' => 'employees/searchEmployee.php',
    '/home' => 'pages/index.html',
];

if (isset($routes[$path])) {
    include($routes[$path]);
} elseif (!empty($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'showAllEmployees':
            include('employees/showAllEmployees.php');
            break;
        case 'employeeRec.dat':
            $file_path = 'employeesDetails/employeeRec.dat';
            if (file_exists($file_path)) {
                include($file_path);
            } else {
                http_response_code(404);
                include('pages/errors/404.php');
                exit();
            }
            break;
        case 'home':
            include('pages/index.html');
            break;
        default:
            http_response_code(404);
            include('pages/errors/404.php');
            exit();
            break;
    }
}elseif($_SERVER['HTTP_HOST'] === 'localhost:9090' && $path === '/'){
    header('Location: http://localhost:9090/home');
    exit();
}else{
    http_response_code(404);
   include('pages/errors/404.php');
    exit();
}
?>
