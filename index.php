<?php 

include('config/db_connect.php');


//query = to ask or inquire about 
// write query for all pizzas
// 'SELECT' means go and get data, * all of the columns where were getting data from, pizzas is the table // not using *
$sqlFetch = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

// make query & get result 
$result = mysqli_query($conn, $sqlFetch);

// fetch the resulting rows as an array
// that returns it as a assaitive array for us 
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory // so we don't need to hang onto it anymore 
mysqli_free_result($result);

// close connection 
mysqli_close($conn);

//print_r($pizzas);


// so altogether we've connected to the database then we've constructed a query string using select and FROM to say where it's from as well then we've got this variable called $result where we store this query that we're making via $conn 
// so we know where we connect into what database and were issuing $sql command that we have constructed that should get us this data right here from this table okay now $result it's not in a format that we can use what we need to do is fetch the data from that 
// result in format that we're going to use which is what we're doing here using this function and passing in that result that we got from the query and we say we want it back as an associative array 

 //print_r(explode(',', $pizzas[1]['ingredients']));

/*
   <?php if(count($pizzas) >= 2): ?>
   <p>there are 2 or more pizzas</p>
   <?php else: ?>
   <p>there are less than 2 pizzas</p>
   <?php endif; ?>
*/
?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<!-- rendering data to the browser -->

<h4 class="center grey-text">Pizzas!</h4>
<div class="container">
   <div class="row">

      <?php foreach($pizzas as $pizza): ?>

           <div class="col s6 md3">
               <div class="card z-depth-0">
                    <div class="card-content center">
                       <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                       <!-- explode the array, so this is going to explode the array based on the comma sign ?> -->
                         <ul>

                             <?php 
                                // so were looping over just one pizza ingredient for example - Array ( [0] => tomato [1] => cheese [2] => mushroom )
                                  foreach(explode(',', $pizza['ingredients']) as  $ingredientSingle ) { ?>
                                  <li><?php echo htmlspecialchars($ingredientSingle); ?></li>
                             <?php } ?>
                         </ul>
                    </div>               
               </div>
               <div style="background: white;" class="card-action right-align">
                  <a href="details.php?id=<?php echo $pizza['id']?>"  class="brand-text">more info</a>
               </div>
           </div>

        <?php endforeach; ?>
   </div>



</div>
<?php include('templates/footer.php'); ?>

    

</html>