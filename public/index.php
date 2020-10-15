<?php
include ('../private/includes/initialize.php');
include ('../private/includes/header.php');

$records = get_all();
$update = $_GET['delete'] ?? false;
if ($update){
    echo "
    <div class=\"alert alert-primary\" role=\"alert\">
      It worked!
    </div>
    ";
}
?>
<h1>
    Invoices
</h1>
<?php
if ( $records[0]['ID']) { ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Client</th>
            <th scope="col">Amount</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        <?php
        foreach ($records as $record){
            echo "
                <tr>
                    <td> " . $record['ID'] . "</td>
                    <td> " . $record['client'] . "</td>
                    <td> " . $record['amount'] . "</td>
                    <td><a href='edit.php?ID=" . $record['ID']  . "'>Edit</a></td>
                    <td><a class='text-danger' href='delete.php?ID=" . $record['ID']  . "'>Delete</a></td>
                </tr>
                ";
        }
        ?>

        </tbody>
    </table>

    <?php
}
else {
    echo "<p>None yet... <a href='new.php'>create a new one</a>!</p>";
}
if ($update){
    $obj = new DB_OPS(['ID' => $update]);
    $sql = $obj->delete_sql();
} else {
    $sql = "SELECT * FROM " . OBJECT_TABLE;
}
?>
<hr>
<h3>SQL</h3>
<form>
    <div class="form-group">
        <input class="form-control" type="text" value="<?php echo $sql; ?>">
    </div>
</form>
<?php

include ('../private/includes/footer.php');
?>
