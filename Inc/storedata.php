<?php // Αποθήκευση δεδομένων προσωρινά (για browsers που δεν δέχονται την html5)

session_start();
if(isset($_POST['BusName']))
{

    $_SESSION["BusName"] = $_POST['BusName'];
}
if(isset($_POST["Address"]))
{
    $_SESSION["Address"] = $_POST["Address"];
}
if(isset($_POST["Phone"]))
{
    $_SESSION["Phone"] = $_POST["Phone"];
}
if(isset($_POST["BusinessID"]))
{
    $_SESSION["BusinessID"] = $_POST["BusinessID"];
}
if(isset($_POST["Description"]))
{
    $_SESSION["Description"] = $_POST["Description"];
}
echo "imidedomena";
?>
