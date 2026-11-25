<?php
// Shop functionality goes here
$db=new PDO('sqlite:' . __DIR__ . '/../storage/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    phone TEXT NOT NULL,
    total_AmountDue INTEGER DEFAULT 0,
    total_AmountPaid INTEGER DEFAULT 0,
    total_AmountRemaining INTEGER DEFAULT 0,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");
//ADD NEW CUSTOMER
if(isset($_POST['add'])){
    $stmt = $db->prepare("INSERT INTO products (name, phone,AmountDue) VALUES (:name, :phone, :AmountDue)");
    $stmt->execute([
        ':name' => $_POST['name'],
        ':phone' => $_POST['phone'],
        ':AmountDue' => $_POST['AmountDue']
    ]);
    header("Location: shop.php");exit;
}
//AMOUNT PAID
if(isset($_POST['pay'])){
    $stmt = $db->prepare("UPDATE products SET total_AmountPaid = total_AmountPaid + :AmountPaid, total_AmountRemaining = total_AmountDue - (total_AmountPaid + :AmountPaid) WHERE id = :id");
    $stmt->execute([
        ':AmountPaid' => $_POST['AmountPaid'],
        ':id' => $_POST['id']
    ]);
    header("Location: shop.php");exit;
}
//NEW AMOUNT DUE
if(isset($_POST['update'])){
    $stmt = $db->prepare("UPDATE products SET total_AmountDue = total_AmountDue + :AmountDue, total_AmountRemaining = total_AmountDue - total_AmountPaid WHERE id = :id");
    $stmt->execute([
        ':AmountDue' => $_POST['AmountDue'],
        ':id' => $_POST['id']
    ]);
    header("Location: shop.php");exit;
}
//SEARCH
$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $db->prepare("SELECT * FROM products WHERE name LIKE :search OR phone LIKE :search");
    $stmt->execute([':search' => "%$search%"]);
} else {
    $stmt = $db->query("SELECT * FROM products");
}
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document </title>
    <meta charset="utf-8">
    <style>
        body{font-family: Arial; background:#f5f5f5; padding:20px; max-width:900px; margin:auto}
        .box{background:white; padding:20px; border-radius:10px; margin-bottom:20px}
        input{padding:10px; margin:5px; width:200px; font-size:16px}
        button{padding:10px 20px; background:#25D366; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px}
     .card{background:fff; padding:15px; border:1px solid #ddd;border-radius: 5px; margin-bottom: 10px;}
     .pending{color:red; font-weight: bold; font-size: 20px;}
     </style>
</head>
<body>
    <h2>Book Management</h2>
    <div class="box">
        <h3>Add New Customer</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="number" name="AmountDue" placeholder="Amount Due" required>
            <button type="submit" name="add">Add Customer</button>
        </form>
    </div>
    <div class="box">
        <h3>Search Customers</h3>
        <form method="GET">
            <input type="text" name="search" placeholder="Search by name or phone" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <h2>All Customers(<?= count($customers) ?>)</h2>
    <?php foreach ($customers as $c): 
        $left=$c['total_AmountDue'] - $c['total_AmountPaid'];?>
    <div class="card">
        <b style= "font-size:20px"><?= htmlspecialchars($c['name']) ?></b> - <?= htmlspecialchars($c['phone']) ?></br>
        Total.Taken:Rs. <?= $c['total_AmountDue'] ?>|Paid:Rs <?= $c['total_AmountPaid'] ?><br>
        <span class="pending">Pending:Rs. <?= $left ?></span></br><br>
        <form method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <input type="number" name="AmountPaid" placeholder="Amount Paid" required>
            <button type="submit" name="pay">Pay</button>
        </form>
     </div>
     <?php endforeach; ?>
</body>
</html>
