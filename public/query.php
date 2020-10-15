<?php
include ('../private/includes/initialize.php');
include ('../private/includes/header.php');
$is_post = $_POST ?? false;
if ($is_post){
    $update = query_db($_POST['query']);
}

if ( $update ){
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
        <li class="breadcrumb-item active" aria-current="page">Query</li>
    </ol>
</nav>

<h1>
    Query DB
</h1>
<?php
if ( $update ) {
    echo "<code>";
    if ($update->num_rows > 0) {
        // output data of each row
        $no = 0;
        while($row = $update->fetch_assoc()) {
            var_dump($row);
            echo "<br>";
        }
    } else {
        echo "0 results";
    }
    echo "</code>";
}
?>
<form method="post">
    <div class="form-group">
        <textarea name="query" class="form-control"><?php echo $_POST['query'] ?? ""; ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-warning" type="submit" value="Query">
    </div>
</form>
<hr>
<?php

if ($is_post){
    $sql = $_POST['query'];
} else $sql = "";
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
