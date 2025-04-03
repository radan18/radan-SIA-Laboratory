<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Grades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            setInterval(fetchStudents, 10000);


            fetchStudents();

            function fetchStudents() {
                $.ajax({
                    url: "/api/students", 
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        let rows = '';
                        response.forEach(student => {
                            let midterm = student.grades ? parseFloat(student.grades.midterm) || 'N/A' : 'N/A';
                            let final = student.grades ? parseFloat(student.grades.final) || 'N/A' : 'N/A';
                            let cumulative = (midterm !== 'N/A' && final !== 'N/A') ? ((midterm + final) / 2).toFixed(2) : 'N/A';
                            
          
                            let remarks = (cumulative !== 'N/A' && cumulative >= 4.0) ? 'Failed' : 'Passed';

                            rows += `
                            <tr>
                                <td>${student.id_number}</td>
                                <td>${student.firstname} ${student.middlename || ''} ${student.lastname}</td>
                                <td>${student.department.name}</td>
                                <td>${midterm}</td>
                                <td>${final}</td>
                                <td>${cumulative}</td>
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
