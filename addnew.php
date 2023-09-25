<?php
// Database connection file intigrition
include 'connection.php';

if (isset($_POST['submit'])) {
  // make variables 
  $name = $_POST['name'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $class = $_POST['std'];
  $profile = $_FILES['dp']['name'];
  $tmp = $_FILES['dp']['tmp_name'];
  move_uploaded_file($tmp, 'temp_img/' . $profile);

  // using prepared statement
  $stmt = $conn->prepare("Insert into crud1 (Name, Email, Mobile, Class, Profile) values (?,?,?,?,?)");
  $stmt->bind_param("sssss", $name, $email, $mobile, $class, $profile);

  if ($stmt->execute()) {
    header('Location: ./');

    echo "<script type='text/javascript'>alert('Data inserted successfully');</script>";
  } else {
    header('Location: ./');

    echo "<script type='text/javascript'>alert('Error: " . $stmt->error . "');</script>";
  }

  $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CRUD</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <section class="bg-[#fff] py-[20px] w-[100#] h-[100vh] flex items-center justify-center">
    <main class="bg-[#e6e6e6] max-w-[600px] overflow-hidden rounded-lg">
      <div class="bg-[#ccd] p-[10px_20px]">
        <h1 class="text-[30px] font-bold text-[#5e63b6] inline"><a href="./index.html">PHP CRUD</a></h1>
      </div>

      <h1 class="text-[22px] border-b-2 border-[#5e63b6] p-[0_20px]">Add New</h1>
      <form method="post" action="" class="p-[10px_20px] w-[400px] m-auto" enctype="multipart/form-data">
        <div class="grid">
          <label class="text-[18px]" for="name">Name</label>
          <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text"
            name="name" id="name" />
        </div>
        <div class="grid">
          <label class="text-[18px] mt-[5px]" for="email">Email</label>
          <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2"
            type="email" name="email" id="email" />
        </div>
        <div class="grid">
          <label class="text-[18px] mt-[5px]" for="mobile">Mobile No.</label>
          <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text"
            name="mobile" id="mobile" />
        </div>
        <div class="grid">
          <label class="text-[18px] mt-[5px]" for="std">Class</label>
          <input class="outline-0 bg-transparent focus:shadow-xl p-[3px_10px] border-[#5e63b680] border-b-2" type="text"
            name="std" id="std" />
        </div>
        <div class="grid">
          <label class="text-[18px] mt-[5px]" for="dp">Profile</label>
          <input class="outline-[#5e63b680]" type="file" name="dp" id="dp" />
        </div>
        <input class="bg-[#5e63b6] p-[3px_10px] mt-[10px] cursor-pointer rounded text-[#e6e6e6] tracking-[1px]"
          name="submit" type="submit" value="Submit">
      </form>
    </main>
  </section>
</body>

</html>