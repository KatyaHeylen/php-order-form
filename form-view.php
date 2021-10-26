<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<?php

$_SESSION['street'] = htmlentities($_POST['street']);
$_SESSION['streetnumber'] = htmlentities($_POST['streetnumber']);
$_SESSION['city'] = htmlentities($_POST['city']);
$_SESSION['zipcode'] = htmlentities($_POST['zipcode']);
$_SESSION['email'] = htmlentities($_POST['email']);

$email = $street = $streetnumber = $city = $zipcode = " ";

if (!isset($_POST["email"]) || ($_POST["street"]) || ($_POST["streetnumber"]) || ($_POST["city"]) || ($_POST["zipcode"])) {
    $error = "All fields are required";
}
else {
    $email = test_input(($_POST["email"]));  // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
}
if (is_numeric($_POST["streetnumber"])) {
    $error = "The input is numeric";
}
elseif (is_numeric($_POST["zipcode"])) {
    $error = "The input is numeric";
}
else {
    $error = "The input is not numeric";
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
    whatIsHappening();

?>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>

    <span class="alert alert-warning" role="alert"><?php print_r("*$error");?></span>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php print_r($_SESSION['email']);?>"/>
            </div>
        </div>

        <fieldset>
            <legend>Address<sup>*</sup></legend>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php print_r($_SESSION["street"]);?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php print_r($_SESSION["streetnumber"]);?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php print_r($_SESSION["city"]);?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php print_r($_SESSION["zipcode"]);?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        <?php
        $cost = $_GET["products"]["price"];
        foreach ($cost as $price){
        echo $cost."<br />";}


        ?>
        <label>
            <input type="checkbox" name="express_delivery" value="5" />
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>