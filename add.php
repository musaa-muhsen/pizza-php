<?php 

include('config/db_connect.php');
// if data is sent to us this if condition will deal with it before we send the page back (information on top)
// if there is no action required just send back the html page as it is.
// basically this will run if the submit button is clicked 
/*
if(isset($_GET['submit'])) {
    // print_r($_GET);
    echo $_GET['email'];
    echo $_GET['title'];
    echo $_GET['ingredients'];
    // $_GET this is a global 
} 
*/
// the initial value when page loads 
$title = $email = $ingredients = '';

// store the errors handling both if empty or theres a problem with the content 
$errors = array('email' => '', 'title' => '', 'ingredients' => ''); 


if(isset($_POST['submit'])) {
    
     // check email 
     if (empty($_POST['email'])) {
        $errors['email'] =  'A email is required <br />';
     } else {
        //echo htmlspecialchars($_POST['email']) . '<br />';
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL )) {
            //echo 'email must be a valid email address'; 
             $errors['email'] = 'email must be a valid email address';   
           }
     }

    // check title
    if (empty($_POST['title'])) {
        $errors['title'] = 'A title is required <br />';
     } else {
        // echo htmlspecialchars($_POST['title']); old one 
        // The preg_match() function returns whether a match was found in a string.
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            //echo "Title must be letters and spaces only";
            $errors['title'] = "Title must be letters and spaces only";
        }
    }
    
    // check ingredients 
  
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] =  'A ingredients is required <br />';
     } else {
       // echo htmlspecialchars($_POST['ingredients']); 
       $ingredients = $_POST['ingredients'];
       if(!preg_match('/^([a-zA-Z\s]+),(\s*[a-zA-Z\s]*)*$/', $ingredients)) {
          //echo 'Ingredients must be a comma separated list';
          $errors['ingredients'] = 'Ingredients must be a comma separated list';
         }
    }



// htmkspecialchars = converts to html entities strings code 
// $_GET this is a global 
// xss = cross site scripting attacks, this can be solved by htmlspecialchars()

// $errors = array('email' => '', 'title' => '', 'ingredients' => ''); 
// array_filter — Filters elements of an array using a callback function
// If no callback is supplied, all empty entries of array will be removed.
// so if have any values in the assaitive array then it's true 
if (array_filter($errors)) {
    // if there is an error 
   } else {
       // protecting data going into the database by mysqli_real... function 
       $email = mysqli_real_escape_string($conn, $_POST['email']);
       $title = mysqli_real_escape_string($conn, $_POST['title']);
       $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
   
       // create sql data to add, pizzas is the name of the table then the values to add in order id and timestamp are added automatically  
       $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title', '$email', '$ingredients')";
       
       //check if saved to db and 
       if (mysqli_query($conn, $sql)) {
       // if there are no errors relocate to the index.php 
   
         header('Location: index.php');
       } else {
           // check the error like node.js
           echo 'query error: ' . mysqli_error($conn);
       }
   }
  
} // end of POST check 




?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>

<section class="container grey-text">
   <h4 class="center">Add a Pizza</h4>
   <!--  action is what file on the server will run to deal (process/do something with it) with this data -->
   <form action="add.php" method="POST" class="white">

       <label for="email">Your Email:</label>
       <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
       <div class="red-text"><?php echo $errors['email']; ?></div>

       <label for="title">Pizza Title:</label>
       <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
       <div class="red-text"><?php echo $errors['title']; ?></div>


       <label for="ingredients">Ingredients (comma separated):</label>
       <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
       <div class="red-text"><?php echo $errors['ingredients']; ?></div>

       
       <div class="center">
       <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
       </div>
   
   </form>
   
</section>

<?php include('templates/footer.php'); ?>
</html>