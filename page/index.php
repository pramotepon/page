<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
</head>

<body style="margin-top: 10px;">
 <?php
// เชื่อมต่อฐานข้อมูล
 $con = mysqli_connect('localhost', 'root', '', 'test');
// กำหนดตัวแปรให้แสดงหน้าละเท่าไหร่
 $perpage = 5;
// ถ้ามีการกดเปลี่ยนหน้าให้เก็บค่าที่กดเปลี่ยนหน้าเก็บค่าไว้ที่ $page ถ้าไม่มี $page=1 คือหน้าแรก
 if (isset($_GET['page'])) {
 $page = $_GET['page'];
 } else {
 $page = 1;
 }
 // $start กำหนดจุดเรื่อมต้นในการเรียกข้อมูล โดยเริ่มจาก 0 $start = (1-1)*5 = 0 คือเริ่มเรียกข้อมูลจากแถวที่ 0,1,2,3,4 
 // ถ้า $page=2 จะเป็น $start = (2-1)*5=5 คือ 5,6,7,8,9
 $start = ($page - 1) * $perpage;
 // เรียกข้อมูลเฉพาะหน้าที่เราคลิ๊กคือ เลือกข้อมูลทั้งหมดจากตารางเมมเบอร์ จำกัดข้อมูลที่ $start=0 เป็นจำนวน $perpage=5 ข้อมูล
 $sql = "SELECT * FROM member LIMIT {$start} , {$perpage} ";
 $query = mysqli_query($con, $sql);
 ?>
 <div class="container">
 <div class="row">
 <div class="col-lg-12">
 <table class="table table-bordered table-hover">
 <thead>
 <tr>
 <th>#</th>
 <th>Username</th>
 <th>Password</th>
 <th>Firstname</th>
 </tr> 
 </thead>
 <tbody>
 <?php while ($result = mysqli_fetch_assoc($query)) { ?>
 <tr>
 <td><?php echo $result['mem_id']; ?></td>
 <td><?php echo $result['mem_username']; ?></td>
 <td><?php echo $result['mem_password']; ?></td>
 <td><?php echo $result['mem_fname']; ?></td>
 </tr>
 <?php } ?>
 </tbody>
 </table>
 <?php
// โค้ดส่วนแสดงจำนวนหน้าทั้งหมด << 1 2 3 4 5 >>
// SELECT ข้อมูลทั้งหมดเพื่อให้ตัวแปร $total_page เก็บค่าจำนวนหน้าทั้งหมดว่ามีเท่าไหร่
 $sql2 = "SELECT * FROM member";
 $query2 = mysqli_query($con, $sql2);
 $total_record = mysqli_num_rows($query2);
// $total_page = ปัดเศษขึ้น(จำนวนข้อมูลทั่งหมด / จำนวนข้อมูลที่จะให้แสดง) 21/5 = 4.3 เศษปัดขึ้นจึงเป็น 5
 $total_page = ceil($total_record / $perpage);
 ?>
<!-- ปุ่มเปลี่ยนหน้า !-->
 <nav>
 <ul class="pagination">
<!-- กลับไปหน้าแรกสุด page=1 !-->
 <li>
 <a href="index.php?page=1" aria-label="Previous">
 <span aria-hidden="true">&laquo;</span>
 </a>
 </li>
<!-- // !-->
<!-- ใช้ Loop for ในการทำปุ่มซ้ำไปเรื่อยๆ จนเท่ากับจำนวน หน้าที่เรามีทั้งหมด $total_page !-->
 <?php for($i=1;$i<=$total_page;$i++){ ?>
 <li><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
 <?php } ?>
<!-- // !-->
<!-- ปุ่มไปหน้าสุดท้าย เหมือนกับปุ่มไปหน้าแรกสุดโดยใช้จำนวนหน้าที่เรามีทั้งหมดมา GET ค่า ?page=$total_page !-->
 <li>
 <a href="index.php?page=<?php echo $total_page;?>" aria-label="Next">
 <span aria-hidden="true">&raquo;</span>
 </a>
 </li>
<!-- !-->
 </ul>
 </nav>
 </div>
 </div>
 </div> <!-- /container -->
 </body>

</html>