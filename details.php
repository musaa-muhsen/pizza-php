<?php 

include('config/db_connect.php');

// name="delete' input value 
if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    // echo $id_to_delete; // the id number below is 1 = 1 etc 
    $sqlDelete = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sqlDelete)) {
        // success 
        header('Location: index.php');
    }  {
        // failure
        echo 'query error: ' . mysqli_error($conn);

    }


}


// check GET request id param // so if id is present inside the URL then is going to pass 
if (isset($_GET['id'])) {


    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql so 1 = 1
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get the query result 
    $result = mysqli_query($conn, $sql);

    // fetch result in array format // so that fetches this one result as an associative array 
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
    //print_r($pizza);
    

}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container center">
   <?php if($pizza): ?>
   <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
   <p>Created by: <?php htmlspecialchars($pizza['email']); ?></p>
   <p><?php echo date($pizza['created_at']); ?></p>
   <h5>Ingredients:</h5>
   <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

   <!-- delete form , hidden input is going to contain the id we want to delete -->
   <form action="details.php" method="POST">
      <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] /* this comes from = $pizza = mysqli_fetch_assoc($result);*/?>">
      <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
  </form>
   <?php else: ?>
   <h5>No such pizza exists!</h5>
   <?php endif; ?>
</div>


<?php include('templates/footer.php'); ?>


</html>