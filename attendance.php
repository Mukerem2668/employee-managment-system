<form action="save_attendance.php" method="POST">
    <table class="table">
        <thead>
            <tr>
                <th>ሰራተኛ/Employee</th>
                <th>ሁኔታ/Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
             include('db.php');

            $employees = mysqli_query($conn, "SELECT * FROM employees WHERE status='Active'");
            while($emp = mysqli_fetch_assoc($employees)) {
                echo "<tr>
                    <td>{$emp['full_name']}</td>
                    <td>
                        <input type='radio' name='status[{$emp['id']}]' value='Present' checked> መጥቷል
                        <input type='radio' name='status[{$emp['id']}]' value='Absent'> አልመጣም
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">መዝግብ/Submit Attendance</button>
</form>