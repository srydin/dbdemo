<?php
include ('../private/includes/initialize.php');
include ('../private/includes/header.php');
$is_post = $_POST ?? false;
$create = false;
if ($is_post){
    $create = create_item($_POST);
    if ($create > 0){
        redirect_to("edit.php?ID=" . $create . "&new=1");
    }
}
?>
<?php
if ($create){
    $msg = " $create ? $create : 'It worked!'";
    echo "
    <div class=\"alert alert-primary\" role=\"alert\">
      $msg
    </div>
    ";
}
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>

<h1>
    New Invoice
</h1>

<form method="post">
    <div class="form-group">
        <label>Client</label>
        <input class="form-control" type="text" name="client">
    </div>
    <div class="form-group">
        <label>Amount</label>
        <input class="form-control" type="number" name="amount">
    </div>
    <div class="form-group">
        <label>Memo</label>
        <textarea name="memo" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Create">
    </div>
</form>


<?php
include ('../private/includes/footer.php');
?>
