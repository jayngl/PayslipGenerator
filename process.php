
<!-- Name: Jordain Crosse -->
<!-- ID# 20216461 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="court.png">
    <title>Employee Details</title>
</head>
<body>
<header class="navbar">
    <h1 class="logo"><img src="court.png" alt="">AW&H Employee Portal</h1>
    <nav>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About US</a></li>
            <li><a href="#">Services</a></li>
            <li><button>Logout</button></li>
        </ul>
    </nav>
</header>
<section class="hero">
    <div class="hero-content">
        <h2>Welcome to AW&H Employee Portal</h2>
        <hr>
        <p>Welcome to Arkwright, Wyndham & Huxley, where legal excellence meets unwavering dedication. With a rich history spanning decades, our esteemed firm has been a cornerstone in providing exceptional legal services to our clients. At Arkwright, Wyndham & Huxley, we pride ourselves on our commitment to integrity, professionalism, and delivering optimal outcomes for every case we undertake.</p>
    </div>
</section>

<div class="container">
    <h1>Employee Details Form</h1>
    <form action="process.php" method="POST">
        <label for="ein">Employee Identification Number (EIN):</label>
        <input type="text" id="ein" name="ein" required>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="qualification">Current Highest Qualification:</label>
        <select id="qualification" name="qualification" required>
            <option value="ASC">ASC. DEG.</option>
            <option value="BSC">BSC. DEG.</option>
            <option value="MSC">MSC. DEG.</option>
            <option value="PHD">PHD. DEG.</option>
        </select>
        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" required>
        <label for="deductions">Deductions:</label>
        <input type="number" id="deductions" name="deductions" required>
        <label for="trn">Tax Registration Number (TRN):</label>
        <input type="text" id="trn" name="trn" required>
        <label for="bank_branch">Bank Branch:</label>
        <input type="text" id="bank_branch" name="bank_branch" required>
        <label for="ban">Bank Account Number (BAN):</label>
        <input type="text" id="ban" name="ban" required>
        <button type="submit">Submit</button>
    </form>
</div>
<center><h1>Employee Payslip:</h1></center>
</body>
</html>
<?php

class Employee {
    protected $ein;
    protected $name;
    protected $qualification;
    protected $salary;
    protected $deductions;
    protected $trn;
    protected $bank_branch;
    protected $ban;

    public function __construct($ein, $name, $qualification, $salary, $deductions, $trn, $bank_branch, $ban) {
        $this->ein = $ein;
        $this->name = $name;
        $this->qualification = $qualification;
        $this->salary = $salary;
        $this->deductions = $deductions;
        $this->trn = $trn;
        $this->bank_branch = $bank_branch;
        $this->ban = $ban;
    }

    public function displayData() {
        echo "<h2>Employee Details</h2>";
        echo "<p>EIN: " . $this->ein . "</p>";
        echo "<p>Name: " . $this->name . "</p>";
        echo "<p>Qualification: " . $this->qualification . "</p>";
        echo "<p>Salary: $" . $this->salary . "</p>";
        echo "<p>Deductions: $" . $this->deductions . "</p>";
        echo "<p>TRN: " . $this->trn . "</p>";
        echo "<p>Bank Branch: " . $this->bank_branch . "</p>";
        echo "<p>BAN: " . $this->ban . "</p>";
    }
}

class ValidateEmployee {
    public static function validate($data) {
        $errors = [];
        
        if (empty($data['ein'])) {
            $errors[] = "Employee Identification Number (EIN) is required.";
        }

        if (empty($data['name'])) {
            $errors[] = "Name is required.";
        }

        if (empty($data['qualification'])) {
            $errors[] = "Qualification is required.";
        } elseif (!in_array($data['qualification'], ['ASC', 'BSC', 'MSC', 'PHD'])) {
            $errors[] = "Invalid qualification.";
        }

        if (empty($data['salary']) || !is_numeric($data['salary']) || $data['salary'] <= 0) {
            $errors[] = "Salary must be a positive number.";
        }

        if (empty($data['deductions']) || !is_numeric($data['deductions']) || $data['deductions'] < 0) {
            $errors[] = "Deductions must be a non-negative number.";
        }

        if (empty($data['trn'])) {
            $errors[] = "Tax Registration Number (TRN) is required.";
        }

        if (empty($data['bank_branch'])) {
            $errors[] = "Bank Branch is required.";
        }

        if (empty($data['ban'])) {
            $errors[] = "Bank Account Number (BAN) is required.";
        }

        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors];
        }
        
        return ['valid' => true];
    }
}

class SalaryInformation extends Employee {
    public function displayData() {
        parent::displayData();
        $bonus = 0;
        switch ($this->qualification) {
            case 'ASC':
                $bonus = 50000;
                break;
            case 'BSC':
                $bonus = 40000;
                break;
            case 'MSC':
                $bonus = 30000;
                break;
            case 'PHD':
                $bonus = 20000;
                break;
        }
        $net_pay = $this->salary - $this->deductions;
        echo "<h2>Pay Slip</h2>";
        echo "<p>Bonus: $" . $bonus . "</p>";
        echo "<p>Net Pay: $" . $net_pay . "</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validated = ValidateEmployee::validate($_POST);
    if ($validated) {
        $employee = new SalaryInformation($_POST['ein'], $_POST['name'], $_POST['qualification'], $_POST['salary'], $_POST['deductions'], $_POST['trn'], $_POST['bank_branch'], $_POST['ban']);
        $employee->displayData();
    } else {
        echo "Data validation failed. Please check your inputs and try again.";
    }
}
?>

<!-- “I CERTIFY THAT I HAVE NOT GIVEN OR RECEIVED ANY UNAUTHORIZED
ASSISTANCE ON THIS ASSIGNMENT”. -->
