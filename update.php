<?php
include 'connection.php';

$edit = $_GET['edit'];
if(isset($_GET['edit'])){
    $stmtF= $conn->prepare("select * from crud1 where ID = ?");
    $stmtF->bind_param('i', $edit);
    
    if($stmtF->execute()){
        $result = $stmtF->get_result(); 
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Error: ". $stmtF->error ."'); window.location.href = './'</script>";
    }
    
}

if(isset($_POST['update'])){
    
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $class=$_POST['std'];
    $profile=$_FILES['dp']['name'];
    $tmp=$_FILES['dp']['tmp_name'];
    move_uploaded_file($tmp,'temp_img/' . $profile);

    $stmtU = $conn->prepare("UPDATE crud1 SET `Name` = ?, `Email` = ?, `Mobile` = ?, `Class` = ?, `Profile` = ? Where `ID` = ?");
    $stmtU->bind_param("ssssss",$name,$email,$mobile,$class,$profile,$edit);
    $stmtU->execute();

    header("Location:./");

    $stmtU->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <section class="bg-[#fff] py-[20px] w-[100#] h-[100vh] flex items-center justify-center">
      <main
        class="bg-[#e6e6e6] max-w-[600px] overflow-hidden rounded-lg"
      >
        <div class="bg-[#ccd] p-[10px_20px]">
          <h1 class="text-[30px] font-bold text-[#5e63b6] inline"><a href="./">PHP CRUD</a></h1>
        </div>

        <h1 class="text-[22px] border-b-2 border-[#5e63b6] p-[0_20px]">Update Profile</h1>
        <form method="post" action="" class="p-[10px_20px] w-[400px] m-auto" enctype="multipart/form-data">
          <div class="grid">
            <label class="text-[18px]" for="name">Name</label>
            <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text" name="name" id="name" value="<?php echo $row['Name'] ?>" />
          </div>
          <div class="grid">
            <label class="text-[18px] mt-[5px]" for="email">Email</label>
            <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="email" name="email" id="email" value="<?php echo $row['Email'] ?>" />
          </div>
          <div class="grid">
            <label class="text-[18px] mt-[5px]" for="mobile">Mobile No.</label>
            <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text" name="mobile" id="mobile" value="<?php echo $row['Mobile'] ?>" />
          </div>
          <div class="grid">
            <label class="text-[18px] mt-[5px]" for="std">Class</label>
            <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text" name="std" id="std" value="<?php echo $row['Class'] ?>" />
          </div>
          <div class="grid">
            <label class="text-[18px] mt-[5px]" for="dp">Profile</label>
            <input class="outline-[#5e63b680]" type="file" name="dp" id="dp" value="<?php echo $row['Profile'] ?>" />
          </div>
          <input class="bg-[#5e63b6] p-[3px_10px] mt-[10px] cursor-pointer rounded text-[#e6e6e6] tracking-[1px]" type="submit" value="Submit" name="update">
        </form>
      </main>
    </section>
  </body>
</html>

