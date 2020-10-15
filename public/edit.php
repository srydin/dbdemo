<?php
include ('../private/includes/initialize.php');
include ('../private/includes/header.php');
$ID = $_GET['ID'] ?? false;
$is_post = $_POST ?? false;
$new = $_GET['new'] ?? false;
$update = false;
if ($is_post){
    $update = update_item($ID,$_POST);
}
$result = select_item($ID);

if (!$result){
    redirect_to('/');
}

if ($update || $new){
    $msg = 'It worked!';
    echo "
    <div class=\"alert alert-primary\" role=\"alert\">
      " . $msg .  "
    </div>
    ";
}
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>

<h1>
    Invoice #<?php echo $result['ID']; ?>
</h1>

<form method="post">
    <div class="form-group">
        <label>ID</label>
        <input name="ID" value="<?php echo $result['ID']; ?>" class="form-control" type="text" readonly>
    </div>
    <div class="form-group">
        <label>Client</label>
        <input name="client" value="<?php echo $result['client']; ?>" class="form-control" type="text">
    </div>
    <div class="form-group">
        <label>Amount</label>
        <input name="amount" value="<?php echo $result['amount']; ?>" class="form-control" type="number">
    </div>
    <div class="form-group">
        <label>Memo</label>
        <textarea name="memo" class="form-control"><?php echo $result['memo']; ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-warning" type="submit" value="Edit">
    </div>
    <a class="btn btn-danger" href="delete.php?ID=<?php echo $result['ID'] ?>">
        Delete
    </a>
</form>
<hr>
<?php

if ($is_post){
    $obj = new DB_OPS($_POST);
    $sql = $obj->edit_sql();
} else if ($new) {
    $obj = new DB_OPS(['ID' => $ID]);
    $obj->memo = $result['memo'];
    $obj->amount = $result['amount'];
    $obj->client = $result['client'];
    $sql = $obj->create_sql();
} else {
    $sql = "SELECT * FROM " . OBJECT_TABLE . " WHERE ID = " . $ID;
}
?>
<h3>SQL</h3>
<form>
    <div class="form-group">
        <input class="form-control" type="text" value="<?php echo $sql; ?>">
    </div>
</form>

<?php
include ('../private/includes/footer.php');
?>
