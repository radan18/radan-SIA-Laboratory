<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Grades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-light bg-dark p-3">Student Grades</h2>
        <table id="studentsTable" class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Midterm</th>
                    <th>Final</th>
                    <th>Cumulative Grade</th>
                    <th>Grade Equivalent</th>
                    <th>Remarks</th>  <!-- Added Remarks column -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fetch students every 10 seconds
            setInterval(fetchStudents, 10000);

            // Initial fetch on page load
            fetchStudents();

            function fetchStudents() {
                $.ajax({
                    url: "/api/students", // Replace with actual API endpoint
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        let rows = '';
                        response.forEach(student => {
                            let midterm = student.grades ? parseFloat(student.grades.midterm) || 'N/A' : 'N/A';
                            let final = student.grades ? parseFloat(student.grades.final) || 'N/A' : 'N/A';
                            let cumulative = (midterm !== 'N/A' && final !== 'N/A') ? ((midterm + final) / 2).toFixed(2) : 'N/A';
                            
                            // Convert Cumulative Grade to Grade Equivalent (adjust scale as needed)
                            let gradeEquivalent = cumulative !== 'N/A' ? parseFloat(cumulative) : 'N/A';

                            // Determine Remarks: "Passed" if Grade Equivalent is ≤ 3.0, otherwise "Failed"
                            let remarks = (gradeEquivalent !== 'N/A' && gradeEquivalent <= 3.0) ? 'Passed' : 'Failed';

                            rows += `
                            <tr>
                                <td>${student.id_number}</td>
                                <td>${student.firstname} ${student.middlename || ''} ${student.lastname}</td>
                                <td>${student.department.name}</td>
                                <td>${midterm}</td>
                                <td>${final}</td>
                                <td>${cumulative}</td>
                                <td>${gradeEquivalent}</td>
                                <td>${remarks}</td>
                            </tr>
                            `;
                        });

                        $('#studentsTable tbody').html(rows);
                    },
                    error: function() {
                        console.error('Error fetching students data');
                    }
                });
            }
        });
    </script>
</body>
</html>
