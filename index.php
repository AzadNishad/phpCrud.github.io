<?php
// Database connection file intigration
include 'connection.php';


if (isset($_GET['del'])) {
  $del = $_GET['del'];

  // Get the profile image name associated with the row to be deleted
  $stmtGetImg = $conn->prepare("SELECT Profile FROM crud1 WHERE ID = ?");
  $stmtGetImg->bind_param("i", $del);
  $stmtGetImg->execute();
  $stmtGetImg->bind_result($imageName);
  $stmtGetImg->fetch();
  $stmtGetImg->close();

  // prepared statement
  $stmtDel = $conn->prepare("Delete from crud1 where ID = ?");
  $stmtDel->bind_param("i", $del);
  $stmtDel->execute();
  $stmtDel->close();

  // Delete the associated image file from the "temp_img" folder
  if (!empty($imageName)) {
    $imagePath = "./temp_img/" . $imageName;
    if (file_exists($imagePath)) {
      unlink($imagePath);
    }
  }

  header("Location:./");


  exit();
}

// fetch data from database
$sql = "SELECT * FROM crud1";
$result = $conn->query($sql);
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
  <section class="bg-[#fff] py-[20px] w-[100#] h-[100vh]">
    <main class="bg-[#e6e6e6] max-w-[1000px] m-auto overflow-hidden rounded-lg">
      <div class="bg-[#ccd] p-[10px_20px]">
        <h1 class="text-[30px] font-bold text-[#5e63b6] inline"><a href="./">PHP CRUD</a></h1>
        <a href="addnew.php"
          class="bg-[#5e63b6] p-[5px_8px] text-white rounded float-right my-[10px] hover:bg-[#464b9b] duration-300"><i
            class="fa-solid fa-plus"></i> ADD</a>
      </div>
      <form action="">
        <table class="w-[950px] m-[15px_auto]">
          <thead class="bg-[#8185c6] text-[#e6e6e6]">
            <th class="border-r border-[#e6e6e6]">ID</th>
            <th class="border-r border-[#e6e6e6]">Profile</th>
            <th class="border-r border-[#e6e6e6]">Name</th>
            <th class="border-r border-[#e6e6e6]">Email</th>
            <th class="border-r border-[#e6e6e6]">Mobile</th>
            <th class="border-r border-[#e6e6e6]">Class</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
              <tr class="border border-[#8185c6] m-[10px]">
                <td class="p-[5px_10px] border-r border-[#8185c6] w-[50px]">
                  <?php echo $row['ID'] ?>
                </td>
                <td class="p-[5px_10px] w-[90px] border-r border-[#8185c6]">
                  <img class="w-[70px] h-[70px]" src="./temp_img/<?php echo $row['Profile'] ?>" alt="Profile" />
                </td>
                <td class="p-[5px_10px] border-r border-[#8185c6]">
                  <?php echo $row['Name'] ?>
                </td>
                <td class="p-[5px_10px] max-w-[150px] border-r border-[#8185c6]">
                  <?php echo $row['Email'] ?>
                </td>
                <td class="p-[5px_10px] max-w-[60px] border-r border-[#8185c6]">
                  <?php echo $row['Mobile'] ?>
                </td>
                <td class="p-[5px_10px] border-r border-[#8185c6]">
                  <?php echo $row['Class'] ?>
                </td>
                <td class="p-[5px_10px] border-r border-[#8185c6] text-center max-w-[20px]">
                  <a href="./update.php?edit=<?php echo $row['ID'] ?>">
                    <i class="fa-solid fa-pen-to-square cursor-pointer text-[#00f]  hover:text-[#008000]"></i>
                  </a>
                  &nbsp;
                  &nbsp;
                  <a href="./index.php?del=<?php echo $row['ID'] ?>">
                    <i class="fa-solid fa-trash cursor-pointer text-[#00f] hover:text-[#f00] transition ease-in-out"></i>
                  </a>
                </td>
              </tr>
              <?php
            }
            $conn->close();
            ?>
          </tbody>
        </table>
      </form>
    </main>
  </section>
</body>

</html>