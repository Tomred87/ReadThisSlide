<link href="MainMenu.css" type="text/css" rel="stylesheet" />
<?php
session_start();
?>

<html>
<head>
<meta charset="utf-8">
<title>Shopping Page</title>
</head>

<body>
<?php
	include("Connect_Database.php")
?>

<?php
	$selectBooks = "select * from books";
	$results = mysqli_query($connect, $selectBooks);
?>

<?php
	date_default_timezone_set("America/Los_Angeles");
	$currentTime = date("Y-m-d H:i:s");
	#print ($currentTime);
?>


<?php 
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$id = $_SESSION['id'];
?>
<form action="logout.php" method="post">
<input type="submit" name="logout" value="logout">
</form>

<ul class="ul_css">
<li class="li_css">
	<a class="li_css_a" href="shopping.php?<?php print "name=$name&email=$email&id=$id"; ?>" /> shopping
	</a>
</li>
<li class="li_css">
	<a class="li_css_a" href="selling.php?<?php print "name=$name&email=$email&id=$id"; ?>" /> selling
	</a>
</li>
<li class="li_css">
	<a class="li_css_a" href="profile.php?<?php print "name=$name&email=$email&id=$id"; ?>" /> profile
	</a>
</li>
</ul>
<h1 style="text-align: center"> Shopping Cart</h1>
<table align="center" border=2 width=400>
	<tr>
		<th>
			Title
		</th>
		<th>
			Name
		</th>
		<th>
			Post Time
		</th>
		<th>
			Book Picture
		</th>
		<th>
			Subject
		</th>
		<th>
			Price
		</th>
	</tr>

<?php
if (empty($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}

/*
$_SESSION['cart'] = array();
*/

if (isset($_POST['purchaseAll'])) {
	while ($row = mysqli_fetch_assoc($results)) {
		$size = count($_SESSION['cart']);
			for ($x = 0; $x < $size; $x++) {
				if ($_SESSION['cart'][$x] == $row['bookId']) {
					$insertBook = "INSERT INTO purchased VALUES (null, '" . $row['name'] . "', '" . $row['title'] . "', '" . $row['description'] . "', '" . $currentTime . "',
				'" . $row['picpath'] . "', '" . $row['subject'] . "', '" . $row['price'] . "', '" . $row['nameID'] . "', '" . $_SESSION['name'] . "', '" . $_SESSION['id'] . "')";
				
				$insert = mysqli_query($connect, $insertBook);
				
				$deleteBook = "delete from books where name = '" . $row['name'] ."' AND  title = '" . $row['title'] ."'";
				$delete = mysqli_query($connect, $deleteBook);
				}
			}
			
		}	
		$_SESSION['cart'] = array();
	header("Location: mainMenu.php");
}

else if (isset($_POST['shoppingCart'])) {
	$selectBooks = "select * from books";
	$results = mysqli_query($connect, $selectBooks);
	$size = count($_SESSION['cart']);
	$totalPrice = 0;
	while($row = mysqli_fetch_assoc($results)) {
		for ($x = 0; $x < $size; $x++) {
			if ($_SESSION['cart'][$x] == $row['bookId']) {
				$totalPrice = $totalPrice + $row['price'];
				print "<tr>";
		print "<td>";
		print ($row["title"]);
		print "</td>";
		print "<td>";
		print ($row["name"]);
		print "</td>";
		print "<td>";
		print ($row["date"]);
		print "</td>";
		print "<td>";
		print "<img src='";
		print $row["picpath"] . "' height=50 width=50>";
		print "</td>";
		print "<td>";
		print ($row["subject"]);
		print "</td>";
		print "<td>";
		print ($row["price"]);
		print "</td>";
		print "</tr>";
			}
		}
	}
		print "Total Price: ";
		print $totalPrice;
}


else {
while($row = mysqli_fetch_assoc($results)) {
	if ($_SESSION['name'] != $row['name']) {
			if ($_GET['bookId'] == $row['bookId']) {
			$arrlength = count($_SESSION['cart']);
		
			if ($arrlength == 0) {
				$update = "UPDATE books SET incart = 1 where bookId = '" . $_GET['bookId'] ."' ";
				$updateNow = mysqli_query($connect, $update);
			array_push($_SESSION['cart'], $_GET['bookId']);	
			}
			else {
				$value = false;
			for ($x = 0; $x < $arrlength; $x++) {	
				if ($_SESSION['cart'][$x] == $_GET['bookId']) {
				$value = true;									
				}
			}
			if ($value == false) {
				$update = "UPDATE books SET incart = 1 where bookId = '" . $_GET['bookId'] ."'";
				$updateNow = mysqli_query($connect, $update);
			array_push($_SESSION['cart'], $_GET['bookId']);
				}
			}
			}
		  }	
		}
		$selectBooks = "select * from books";
	$results = mysqli_query($connect, $selectBooks);
	$size = count($_SESSION['cart']);
	$totalPrice = 0;
	while($row = mysqli_fetch_assoc($results)) {
		for ($x = 0; $x < $size; $x++) {
			if ($_SESSION['cart'][$x] == $row['bookId']) {
				$totalPrice = $totalPrice + $row['price'];
				print "<tr>";
		print "<td>";
		print ($row["title"]);
		print "</td>";
		print "<td>";
		print ($row["name"]);
		print "</td>";
		print "<td>";
		print ($row["date"]);
		print "</td>";
		print "<td>";
		print "<img src='";
		print $row["picpath"] . "' height=50 width=50>";
		print "</td>";
		print "<td>";
		print ($row["subject"]);
		print "</td>";
		print "<td>";
		print ($row["price"]);
		print "</td>";
		print "</tr>";
			}
		}
	}

		print "Total Price: ";
		print $totalPrice;
	}
	
		

?>
</table>

<form action="shoppingCartArray.php" method="post">
		<input type ="submit" name="purchaseAll" value="Purchase">
</form>





</body>
</html>








