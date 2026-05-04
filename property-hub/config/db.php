<?php
$conn = mysqli_connect("localhost", "root", "", "property_hub");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>