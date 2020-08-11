<?php
/* ########################################################

Coding project: ezyVet Development Practical task
Description: Simple PHP shopping cart
Date project started: 11/08/20
Date project completed: 11/08/20
Author: Samuel L. Way

 ########################################################*/
SESSION_START();
// ######## please do not alter the following code ########
$products = [
[ "name" => "Sledgehammer", "price" => 125.75 ],
[ "name" => "Axe", "price" => 190.50 ],
[ "name" => "Bandsaw", "price" => 562.131 ],
[ "name" => "Chisel", "price" => 12.9 ],
[ "name" => "Hacksaw", "price" => 18.45 ],
];
// ########################################################
$product = array();
$price = array();
foreach ($products as $p){
	array_push($product, $p['name']);			//array containing all the product names
	array_push($price, $p['price']);			//array containing all the product prices
	//adds each product and price to arrays used to build the shopping list
}
//check if the session has any products, if not then add each product to the session.
if(!isset($_SESSION["total"])){
	$_SESSION["total"] = 0;
	for ($i=0; $i< count($product); $i++){
		$_SESSION["quantity"][$i] = 0;		//number of chosen product in cart
		$_SESSION["price"][$i] = 0;			//individual price
		$_SESSION["t_price"][$i] = 0; 		//total price
		//creates variables for each product in the product array
	}
}
//if add is sent then add item to the cart (increase total number of item to current items + 1)
if(isset($_GET["add"])){
	$i = $_GET["add"];
	$_SESSION["cart"][$i] = $i;
	$quantity = $_SESSION["quantity"][$i] += 1;
	$_SESSION["price"][$i] = $price[$i];
	$_SESSION["quantity"][$i] = $quantity;
	$_SESSION["t_price"][$i] = $price[$i] * $quantity;
	header('Location:http://localhost/shoppingcart');		//this needs to be changed to whatever the directory of the index file is
	//adds 1 of the chosen product to cart
 }
//if delete is sent then remove item from the cart (total number of items - 1), if quantity of items is <=0 remove the item from the cart.
if(isset($_GET["delete"])){
	$i = $_GET["delete"];
	$quantity = $_SESSION["quantity"][$i];
	$quantity = $quantity - 1;
	$_SESSION["quantity"][$i] = $quantity;
	//remove 1 of the chosen product from the cart
	if($quantity == 0){
		$_SESSION["t_price"][$i] = 0;
		unset($_SESSION["cart"][$i]);
		//remove the item from the cart entirely if the quantity of items equals zero
	}else{
		$_SESSION["t_price"][$i] = $price[$i] * $quantity;
		//updates price total
	}
	header('Location:http://localhost/shoppingcart');		//this needs to be changed to whatever the directory of the index file is
}
?>
<h1>Product List</h1>
<table>
	<tr>
	<th>Product Name</th>
	<th width="20px"></th>
	<th>Price</th>
	<th width="20px"></th>
	<th>Add Product</th>
	</tr>
<?php
for ($i=0; $i< count($product); $i++) {
?>
	<tr>
	<td><?php echo($product[$i]); ?></td>
	<td width="20px"></td>
	<td><?php echo number_format(($price[$i]), 2, '.', ''); ?></td>
	<td width="20px"></td>
	<td><a href="?add=<?php echo($i); ?>">Add to cart</a></td>
	</tr>
 <?php
 }
 ?>
	</table>
	<br><br><br>
	<h2>Cart</h2>
	<table>
		<tr>
			<th>Product Name</th>
			<th width="20px"></th>
			<th>Price</th>
			<th width="20px"></th>
			<th>Quantity</th>
			<th width="20px"></th>
			<th>Total</th>
			<th width="20px"></th>
			<th>Remove product</th>
			</tr>
<?php
if ( isset($_SESSION["cart"]) ) {
?>
<?php
$total = 0;
foreach ( $_SESSION["cart"] as $i ) {
?>
	<tr>
		<td><?php echo( $product[$_SESSION["cart"][$i]] ); ?></td>
		<td width="20px"></td>
		<td><?php echo number_format(( $_SESSION["price"][$i] ), 2, '.', ''); ?></td> <!--quantitys formatted to output the price to 2dp -->
		<td width="20px"></td>
		<td><?php echo( $_SESSION["quantity"][$i] ); ?></td>
		<td width="20px"></td>
		<td><?php echo number_format(( $_SESSION["t_price"][$i] ), 2, '.', ''); ?></td> <!--quantitys formatted to output the total to 2dp -->
		<td width="20px"></td>
		<td><a href="?delete=<?php echo($i); ?>">Remove from cart</a></td>
	</tr>
<?php
	$total = $total + $_SESSION["t_price"][$i]; //adds the total price of each item to the overall total each time the loop itterates.
}
$_SESSION["total"] = $total;
 ?>
	<tr>
		<td colspan="7">Total : <?php echo number_format(($total), 2, '.', ''); ?></td> <!--quantitys formatted to output the total to 2dp -->
	</tr>
</table>
<?php
}
?>