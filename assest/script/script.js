//Error Message
let timeout;

function showErrorMsg(message) {
    const errorMsg = document.getElementById('errorMsg');
    errorMsg.textContent = message;
    errorMsg.style.display = 'block';
    timeout = setTimeout(function () {
        errorMsg.style.display = 'none';
    }, 5000);
}
function clearErrorMsg() {
    const errorMsg = document.getElementById('errorMsg');
    clearTimeout(timeout);
    errorMsg.style.display = 'none';
}

const errorMsg = document.getElementById('errorMsg');
errorMsg.addEventListener('mouseover', function () {
    clearTimeout(timeout);
});

errorMsg.addEventListener('mouseout', function () {
    timeout = setTimeout(function () {
        errorMsg.style.display = 'none';
    }, 5000);
});

// Toggle Design
let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 100;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if (top >= offset && top < offset + height) {

            navLinks.forEach(links => {

                links.classList.remove('active');
                document.querySelector('header nav a[href*=' + id + ']').classList.add('active');

            });
        }
    });
}
let header = document.querySelector("header");

header.classList.toggle("sticky", window.scrollY > 100);

menuIcon.classList.remove('bx-x');
navbar.classList.remove('active');


//AddEmployee Validation
function addEmployeeVal() {
    let id = document.getElementById('id').value;
    let name = document.getElementById('name').value;
    let number = document.getElementById('number').value;
    let age = document.getElementById('age').value;
    let address = document.getElementById('address').value;
    let salaryamt = document.getElementById('salaryamt').value;

    if (id == '') {
        showErrorMsg("Enter Employee Id")
        return false
    } else if (isNaN(id)) {
        showErrorMsg("Enter Valid Employee Id")
        return false
    } else if (age === "") {
        showErrorMsg("Enter Employee Age")
        return false
    } else if (isNaN(age)) {
        showErrorMsg("Enter Valid Age")
        return false
    } else if (name === "") {
        showErrorMsg("Enter Employee Name")
        return false
    } else if (address === '') {
        showErrorMsg("Enter Employee Address")
        return false
    } else if (number === "") {
        showErrorMsg("Enter Employee Number")
        return false
    } else if (isNaN(number)) {
        showErrorMsg("Enter a valid Number")
        return false
    } else if (number.length < 10) {
        showErrorMsg("Enter a valid Number")
        return false
    } else if (salaryamt === "") {
        showErrorMsg("Enter Salary Amount")
        return false
    } else if (isNaN(salaryamt)) {
        showErrorMsg("Enter Valid Salary Amount")
        return false
    } else {
        return true
    }
}
// Form paysalary Valadition
function paySalary() {
    let id = document.getElementById('iid').value;
    let name = document.getElementById('namee').value;
    let number = document.getElementById('numberr').value;
    let amountToPay = document.getElementById('amount_to_pay').value;

    if (id == '') {
        showErrorMsg("Enter Emploee Id")
        return false
    } else if (isNaN(id)) {
        showErrorMsg("Enter Valid Id")
        return false
    } else if (number === "") {
        showErrorMsg("Enter Emploee Number")
        return false
    } else if (isNaN(number)) {
        showErrorMsg("Enter a Valid Number")
        return false
    } else if (name === "") {
        showErrorMsg("Enter Emploee Name")
        return false
    } else if (amountToPay === '') {
        showErrorMsg("Enter Amount To Pay")
        return false
    } else if (isNaN(amountToPay)) {
        showErrorMsg("Enter Amount in Number")
        return false
    } else {
        return true
    }


}

// Form searchEmployee Valadition
function searchEmployee() {
    let id = document.getElementById('idd').value;
    if (id == "") {
        showErrorMsg("Enter Employee id to search..");
        return false
    } else if (isNaN(id)) {
        showErrorMsg("Employee Id must be a Number...")
        return false;
    } else {
        return true;

    }
}

// Fetching AddEmployee Form
function submitForm(event) {
    event.preventDefault();

    const form = new FormData(document.getElementById('contactForm'));
    if (addEmployeeVal()) {
        fetch('/../../employees/addEmployee.php', {
            method: 'POST',
            body: form
        })
            .then(response => response.json())
            .then(data => {
                if (data.IsSuccess) {
                    Swal.fire({
                        title: "Employee added Successfully",
                        icon: "success"
                    });
                    document.getElementById('contactForm').reset();
                } else {
                    Swal.fire({
                        title: data.message,
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}


// Fetching paySalary Form
function submitPayForm(event) {
    event.preventDefault();
    const payForm = new FormData(document.getElementById("process_salary"));
    
    const employeeId = payForm.get("id");
    const amountToPay = payForm.get("amount_to_pay");
    
    if (employeeId && amountToPay) {
        fetch('/../../employees/paySalary.php', {
            method: 'POST',
            body: payForm
        })
        .then(response => response.json())
        .then(data => {
            if (data.IsSuccess) {
                Swal.fire({
                    title: "Salary Paid Successfully",
                    icon: "success"
                });
                document.getElementById('process_salary').reset();
            } else {
                Swal.fire({
                    title: data.message,
                    icon: "error"
                });
            }
        })
        .catch(error => {
            console.log("Error", error);
        });
    }
}