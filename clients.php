<?php
session_start();

//sends user back to login if they try to just run /clients.php in url.
if(!$_SESSION['loggedInUser']){
    header("Location: index.php");
}

include('includes/connection.php');

$query = "SELECT * FROM clients";
$result = mysqli_query($conn, $query);


if(isset($_GET['alert'])) {
    if ($_GET['alert'] == 'success') {
        $alertMessage = "<div class='alert alert-success'>New client added!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    else if($_GET['alert'] == 'updatesuccess') {
        $alertMessage = "<div class='alert alert-success'>Client updated!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    else if($_GET['alert'] == 'deleted') {
        $alertMessage = "<div class='alert alert-success'>Client deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}


mysqli_close($conn);

include('includes/header.php');
?>



<h1>Client Address Book</h1>

<?php echo $alertMessage; ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>

    <?php
    
    if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['address'] . "</td><td>" . $row['company'] . "</td><td>" . $row['notes'] . "</td>";
            
            echo '<td><a href="edit.php?id=' . $row['id'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no clients!</div>";
    }

    mysqli_close($conn);

    ?>

    

    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>