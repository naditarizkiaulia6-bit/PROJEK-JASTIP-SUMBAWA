<?php
$host = "localhost";     
$user = "root";          
$pass = "";              
$db   = "jastip_sumbawa1"; 

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
<?php
include "config.php";

$sql = "tbl_agen"; // ganti "orders" dengan nama tabelmu
$result = $conn->query($sql);

$orders = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
}

echo json_encode($orders); // nanti bisa dipakai di JS
?>
<?php
include "config.php";

$item   = $_POST['item_name'];
$qty    = $_POST['quantity'];
$userId = $_POST['user_id'];

$sql = "INSERT INTO orders (user_id, item_name, quantity, status) VALUES ('$userId','$item','$qty','pending')";
$conn->query($sql);
?>
const formData = new FormData();
formData.append("item_name", "Barang X");
formData.append("quantity", 2);
formData.append("user_id", 1);

fetch("add_order.php", {
  method: "POST",
  body: formData
})
.then(res => res.text())
.then(res => console.log(res));
