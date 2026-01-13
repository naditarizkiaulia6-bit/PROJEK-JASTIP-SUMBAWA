<?php
/* =========================
   KONFIGURASI DATABASE
========================= */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jastip_sumbawa1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

/* =========================
   PROSES TAMBAH ORDER (POST)
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $item   = $_POST['item_name'] ?? '';
    $qty    = $_POST['quantity'] ?? 0;
    $userId = $_POST['user_id'] ?? 0;

    if ($item == '' || $qty <= 0 || $userId <= 0) {
        echo "Data tidak valid";
        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO orders (user_id, item_name, quantity, status)
         VALUES (?, ?, ?, 'pending')"
    );
    $stmt->bind_param("isi", $userId, $item, $qty);

    if ($stmt->execute()) {
        echo "Pesanan berhasil ditambahkan";
    } else {
        echo "Gagal menambahkan pesanan";
    }

    $stmt->close();
    exit;
}

/* =========================
   AMBIL DATA ORDERS (GET)
========================= */
$data = [];
$sql = "SELECT * FROM orders ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Orders</title>
<style>
body { font-family: Arial; margin: 40px; }
table { border-collapse: collapse; width: 100%; margin-top: 20px; }
th, td { border: 1px solid #ccc; padding: 8px; }
th { background: #f4f4f4; }
button { padding: 6px 12px; }
</style>
</head>

<body>

<h2>Dashboard Orders</h2>

<!-- FORM TAMBAH ORDER -->
<h3>Tambah Pesanan</h3>
<form id="orderForm">
    <input type="hidden" name="user_id" value="1">

    Nama Barang:<br>
    <input type="text" name="item_name" required><br><br>

    Jumlah:<br>
    <input type="number" name="quantity" required><br><br>

    <button type="submit">Tambah</button>
</form>

<p id="result"></p>

<!-- TABEL DATA -->
<h3>Daftar Pesanan</h3>
<table>
<tr>
    <th>ID</th>
    <th>User ID</th>
    <th>Barang</th>
    <th>Jumlah</th>
    <th>Status</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['user_id']; ?></td>
    <td><?= $row['item_name']; ?></td>
    <td><?= $row['quantity']; ?></td>
    <td><?= $row['status']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- JAVASCRIPT FETCH -->
<script>
document.getElementById("orderForm").addEventListener("submit", function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        document.getElementById("result").innerText = res;
        location.reload();
    });
});
</script>

</body>
</html>
