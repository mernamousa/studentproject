<?php
  require_once "includes/conn.php";
  require_once "includes/helpers.php";
  require_once 'includes/logged.php';
  

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(!empty($_POST['teacher_id'])){
    try{
      $sql = "INSERT INTO `classes` (`className`, `price`, `capacity` ,`age_from`,`age_to`,`time_from`,`time_to`,`published`, `image`,`teacher_id`) 
      VALUES (?, ?, ?, ? ,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $className= $_POST['className'];
      $price= $_POST['price'];
      $capacity= $_POST['capacity'];
      $age_from= $_POST['age_from'];
      $age_to= $_POST['age_to'];
      $time_from= $_POST['time_from'];
      $time_to= $_POST['time_to'];
      $teacher_id= $_POST['teacher_id'];
      if(isset($_POST['published'])){
      $published =1;
      }else{
        $published = 0;
      }
      
      require_once 'includes/addImage.php';
        
      dd($stmt);
        $stmt->execute([$className, $price, $capacity, $age_from, $age_to, $time_from,  $time_to, $published, $image_name, $teacher_id]); 
        
        header('Location: classes.php');    
      die();
    }catch(PDOException $e){
    $error = "Connection failed: " . $e->getMessage();
      }  
    }  
  }
$sqlTeacher =" SELECT * FROM `teachers`"; 
$stmtTeacher = $conn->prepare($sqlTeacher);
$stmtTeacher->execute();
$teachers = $stmtTeacher->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/main.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <main>
    <?php
      require_once "includes/nav.php";
    ?>
      <div class="container my-5">
        <div class="bg-light p-5 rounded">
          <h2 class="fw-bold fs-2 mb-5 pb-2">Add Class</h2>
          <form action="" method="POST" class="px-md-5" enctype="multipart/form-data">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Class Name:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  placeholder="e.g. Art & Design"
                  class="form-control py-2"
                  name="className"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Teacher:</label
              >
              <div class="col-md-10">
                <select  id="" class="form-control py-1" name="teacher_id">
                <option>Select Teacher</option>
			            <?php  foreach($teachers as $teacher){ ?>
                <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['fullName']; ?></option>
			           <?php 
                   }
                 ?>
                </select>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Price:</label
              >
              <div class="col-md-10">
                <input
                  type="number"
                  step="0.1"
                  placeholder="Enter price"
                  class="form-control py-2"
                  name="price"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Capacity:</label
              >
              <div class="col-md-10">
                <input
                  type="number"
                  step="1"
                  placeholder="Enter catpacity"
                  class="form-control py-2"
                  name="capacity"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Age:</label
              >
              <div class="col-md-10">
                <label for="" class="form-label">From <input type="number" name="age_from" class="form-control"></label>
                <label for="" class="form-label">To <input type="number" name="age_to" class="form-control"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Time:</label
              >
              <div class="col-md-10">
                <label for="" class="form-label">From <input type="time" name="time_from" class="form-control"></label>
                <label for="" class="form-label">To <input type="time"  name="time_to"class="form-control"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Published:</label
              >
              <div class="col-md-10">
                <input
                  type="checkbox"
                  class="form-check-input"
                  style="padding: 0.7rem;"
                  name="published"
                />
              </div>
            </div>
            <hr>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Image:</label
              >
              <div class="col-md-10">
                <input
                  type="file"
                  class="form-control"
                  style="padding: 0.7rem;"
                  name="image"
                />
              </div>
            </div>
            <div class="text-md-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Add Class
            </button>
          </div>
          <?php
            if(isset($error)) {
            ?>
            <div style="color: #ee0002; padding: 5px;">
              <?php echo $error ?>
            </div>
            <?php
            }
            ?>
          </form>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>