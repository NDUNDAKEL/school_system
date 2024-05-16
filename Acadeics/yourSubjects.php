<?php 
    echo "
    <style>
    .register {
        margin-left: 250%;
        margin-right: 40px;
        width: 100%;
    }
    
    table {
        border-collapse: collapse;
        width: 70%;
        margin: 10% auto;
    }
    
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    tr:hover {
        background-color: #f5f5f5;
    }
    
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    a {
        display: inline-block;
        width: auto;
        height: 20px;
        border-radius: 5px;
        color: white;
        padding: 5px;
        cursor: pointer;
        text-decoration: none;
    }
    
    th {
        background-color: orange;
        color: white;
    }
    #add{
        background: blue;
        margin-right: 10%;
        border: none;
        border-radius: 5%;
        color: white;
        padding:10px;
        cursor:pointer;
    }
    </style>
    <center>
    <h4 style='color:green;'>Welcome {$row['name']}</h4>
    <div class='register'>               
   
    </center>
    <table>
    <thead>
        <tr>
            <th>Subject Code</th>
            <th>Name</th>
            <th>Teacher ID</th>
            <th>Form doing the Subject</th>
            <th>Term subject is done</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>";

    $query = 'SELECT * FROM subjects'; // corrected query string
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['subject_id'] . '</td>'; // corrected closing td tag
            echo '<td>' . $row['name'] . '</td>'; // corrected closing td tag
            echo '<td style="color:green;">' . $row['teacher_id'] . '</td>'; // corrected quotes
            echo '<td style="color:green;">' . $row['form_doing'] . '</td>'; // corrected quotes
            echo '<td style="color:green;">' . $row['term_done'] . '</td>'; // corrected quotes
            echo '<td>';
            echo '<a style="background-color:yellow; color:black;" href="?editSubject='. $row['subject_id'] . '">Edit</a> | ';
            echo '<a style="background-color:red; color:white;" href="?deleteSubject='.$row['subject_id'] . '" onclick="return confirm(\'Are you sure you want to delete this subject?\')">Delete</a>';
            echo '</td>'; // corrected closing td tag
            echo '</tr>';
        }
    } else {
        echo "<tr style='color:red;'><td colspan='6'>No subjects found.</td></tr>"; // corrected colspan and closing td tag
    }
    mysqli_close($conn);
    echo "
    </tbody>
    </table>

    </div>
    ";
    ?>
   