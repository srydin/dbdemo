<?php
include ('../private/includes/initialize.php');
include ('../private/includes/header.php');
$ID = $_GET['ID'] ?? false;
$success = $_GET['success'] ?? false;
$delete = false;

if ($_GET['confirm']){
    $result = delete_item($ID);
    if ($result){
        redirect_to('/?delete=' . $ID);
    }
}
else {
    $result = select_item($ID);
}

?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Delete</li>
    </ol>
</nav>

<h1>
    Delete Invoice
</h1>

<p>Are you sure you want to delete invoice #<?php echo $result['ID']; ?>?</p>
<form>
    <div class="form-group">
        <label>ID</label>
        <input name="ID" value="<?php echo $result['ID']; ?>" class="form-control" type="text" readonly>
    </div>
    <div class="form-group">
        <label>Client</label>
        <input name="client" value="<?php echo $result['client']; ?>" class="form-control" type="text" readonly>
    </div>
    <div class="form-group">
        <label>Amount</label>
        <input name="amount" value="<?php echo $result['amount']; ?>" class="form-control" type="number" readonly>
    </div>
    <div class="form-group">
        <label>Memo</label>
        <textarea name="memo" class="form-control" readonly><?php echo $result['memo']; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
    <input type="hidden" name="confirm" value="1">
    <input type="hidden" name="ID" value="<?php echo $result['ID']; ?>">
</form>


<?php
include ('../private/includes/footer.php');
?>
