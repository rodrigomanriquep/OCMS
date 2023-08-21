<?php


class Staff {
    //Database connection
    private $db;

    //Constructor
    public function __construct($db) {
        $this->db = $db;
        echo "\nNew Staff created.\n";
    }
    //Methods

    //Staff create.
    public function insert($firstName, $lastName, $email, $phone, $role) {
        $sql = "INSERT INTO staff (firstName, lastName, email, phone, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $role);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    //Select individual staff
    public function selectOne($staffID) {
        $sql = "SELECT * FROM staff WHERE StaffID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    //Staff delete.
    public function delete($staffID) {
        $sql = "DELETE FROM staff WHERE staffID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $staffID);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    //Staff update.
    public function update($staffID, $firstName, $lastName, $email, $phone) {
        $sql = "UPDATE staff SET FirstName=?, LastName=?, Email=?, Phone=? WHERE StaffID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $phone, $staffID);

        $sql2 = "UPDATE staff_login SET email=? WHERE staffID=?";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bind_param("si", $email, $staffID);

        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
        $stmt2->close();
     }

    //Get a list of all staff members.
    public function selectAll() {
        $sql = "SELECT * FROM staff";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $staffs = array();
            while ($row = $result->fetch_assoc()) {
                $staffs[] = $row;
            }
            return $staffs;
        } else {
            return false;
        }
    }

    //Get a list of all patients who have not yet been approved by a staff member.
    public function getPendingApprovals() {
        $sql = "SELECT * FROM patients WHERE approval=0";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $patients = array();
            while ($row = $result->fetch_assoc()) {
                $patients[] = $row;
            }
            return $patients;
        } else {
            return false;
        }
    }
    //Staff must be able to approve patient accounts.
    public function approvePatientAccount($patientID) {
        $sql = "UPDATE patients SET approval=1 WHERE patientID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $patientID);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    //Staff must be able to generate annual/monthly reports using portions of these medical records.
    //GenerateReports: Allow the Staff to Generate monthly and annual reports which include: 1) total patients visit for each doctor; 2) every patient’s visit summary (how many times for each doctors); 3) top 3 medicines prescribed to patients across the clinic.
    public function generateReport($month = null, $year) {
        if ($month) {
            $startDate = $year . '-' . $month . '-01';
            $endDate = date("Y-m-t", strtotime($startDate));
        } else {
            $startDate = $year . '-01-01';
            $endDate = $year . '-12-31';
        }

        $sql = "SELECT doctors.firstName, doctors.lastName, COUNT(visits.doctorID) AS 'Total Visits'
            FROM visits INNER JOIN doctors ON visits.doctorID=doctors.doctorID
            WHERE visits.date BETWEEN ? AND ? GROUP BY visits.doctorID";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return false;
        }
        $stmt->close();
    }

    //Generate patient visit summary
    //Every patient’s visit summary (how many times for each doctors)
    public function generatePatientVisitSummary($month = null, $year) {
        if ($month) {
            $startDate = $year . '-' . $month . '-01';
            $endDate = date("Y-m-t", strtotime($startDate));
        } else {
            $startDate = $year . '-01-01';
            $endDate = $year . '-12-31';
        }

        $sql = "SELECT patients.PatientID, patients.firstName AS patientFirstName, patients.lastName AS patientLastName, doctors.firstName AS doctorFirstName, doctors.lastName AS doctorLastName, COUNT(visits.VisitID) AS visitCount
            FROM visits
            INNER JOIN doctors ON visits.doctorID = doctors.doctorID
            INNER JOIN patients ON visits.patientID = patients.patientID
            WHERE visits.date BETWEEN ? AND ?
            GROUP BY visits.patientID, visits.doctorID";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return false;
        }
        $stmt->close();
    }

    public function generateTopMedicines($month = null, $year) {
        if ($month) {
            $startDate = $year . '-' . $month . '-01';
            $endDate = date("Y-m-t", strtotime($startDate));
        } else {
            $startDate = $year . '-01-01';
            $endDate = $year . '-12-31';
        }

        $sql = "SELECT prescriptions.Medicine, COUNT(prescriptions.PrescriptionID) AS prescriptionCount
            FROM prescriptions
            INNER JOIN visits ON prescriptions.VisitID = visits.VisitID
            WHERE visits.date BETWEEN ? AND ?
            GROUP BY prescriptions.Medicine
            ORDER BY prescriptionCount DESC
            LIMIT 3";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return false;
        }
        $stmt->close();
    }

}
 ?>
