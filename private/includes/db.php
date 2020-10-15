<?php
include('dbinfo.php');
define("OBJECT_TABLE",'invoices');

class DB_OPS {
    // Properties
    public $ID;
    public $client;
    public $amount;
    public $memo;
    // Methods
    public function __construct($args = []){
        $this->ID = $args['ID'] ?? NULL;
        $this->client = $args['client'] ?? NULL;
        $this->amount = (int) $args['amount'] ?? NULL;
        $this->memo = $args['memo'] ?? NULL;
    }
    public function create_sql(){
        $timestamp = mt_rand(1, time());
        $randomDate = date("Y-m-d", $timestamp);
        return "INSERT INTO " . OBJECT_TABLE . " VALUES (NULL, '$this->client','$this->amount','$this->memo','$randomDate')";
    }
    public function edit_sql(){
        return $sql = "UPDATE " . OBJECT_TABLE . " SET client = '$this->client', amount = '$this->amount', memo = '$this->memo' WHERE ID = '$this->ID'";
    }
    public function delete_sql(){
        return "DELETE FROM " . OBJECT_TABLE . " WHERE ID = '$this->ID'";
    }
}


// Create connection
function connect_to_db(){
    $servername = DB_HOST;
    $username = DB_USER;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function query_db($sql){
    $conn = connect_to_db();
    return $conn->query($sql);
}

function select_data($sql){
    $conn = connect_to_db();
    $result = $conn->query($sql);

    $arr = [];

    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            array_push($arr,$row);
        }
    }

    if (count($arr) === 1){
        return $arr[0];
    }
    else {
        return $arr;
    }
}

function get_all(){
    $conn = connect_to_db();
    $sql = "SELECT * FROM " . OBJECT_TABLE;
    $result = $conn->query($sql);
    $arr = [];
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            array_push($arr,$row);
        }
    }
    return $arr ? $arr : false;
}

function select_item($ID){
    $sql = "SELECT * FROM " . OBJECT_TABLE . " WHERE ID = '$ID'";
    return select_data($sql);
}


function update_item($id,$item){
    $conn = connect_to_db();
    $obj = new DB_OPS($item);
    $sql = $obj->edit_sql();
    return $conn->query($sql);
}

function create_item($item){
    $conn = connect_to_db();

    $obj = new DB_OPS($item);
    $sql = $obj->create_sql();

    $success = $conn->query($sql);
    if ($success){
        return $conn->insert_id;
    }
    else {
        return false;
    }
}

function delete_item($ID){
    $conn = connect_to_db();
    $obj = new DB_OPS(['ID' => $ID]);
    $sql = $obj->delete_sql();
    return $conn->query($sql);
}

function demo_data(){
    $conn = connect_to_db();

    $clients = [
        'Wendys',
        'Pizza Hut',
        'McDonalds',
        'Bank of America',
        'Honeywell',
        'Google',
        'Facebook',
        'Rackspace',
        'DigitalOcean',
        'ConsumerAffairs',
        'Mailchimp',
        'Zazzle',
        'Quickbooks',
        'Square',
        'Consulting People',
        'Accountants Inc',
        'Landlords LLC',
        'Local Liquors'
    ];

    $memos = [
        'Dinner',
        'Breakfast',
        'Breakfast',
        'Checks',
        'Air Conditioning',
        'Ads',
        'More Ads',
        'Servers',
        'Load Balancer',
        'Marketing Stuff',
        'Email',
        'Water Bottles',
        'Invoicing',
        'Advice',
        'Tax prep',
        'Rent',
        'Booze'
    ];

    $i = 0;
    foreach ($clients as $client){
        $sql = "INSERT INTO invoices VALUES (NULL, '$client',";
        $sql .= "'" . rand(1,1000) . "',";
        $sql .= "'" . $memos[$i] . "',";

        $timestamp = mt_rand(1, time());

        //Format that timestamp into a readable date string.
        $randomDate = date("Y-m-d", $timestamp);
        $sql .= "'" . $randomDate . "'";

        $sql .= ")";
        echo $sql;
        var_dump($conn->query($sql));
    }
}
