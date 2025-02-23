<?php

include "header.html";
include "connect.php";

$selectedName=$_GET['name'];

$query = $conn->prepare("SELECT * FROM owners WHERE owners.name = :name;");
$query->bindValue(':name', $selectedName);
$query->execute();
$ownerDetails=$query->fetch();

$query2 = $conn->prepare("SELECT dogs.name, breeds.name AS breed_name FROM owners, dogs, breeds WHERE owners.name = :name AND dogs.owner_id = owners.id AND dogs.breed_id = breeds.id;");
$query2->bindValue(':name', $selectedName);
$query2->execute();
$listOfDogs=$query2->fetchAll();

?>

<div class="content">
	<p><a href="index.php"><<< Back to list</a></p>
	<?php
  	if($ownerDetails){
  		echo "<h1>Details for $selectedName</h1>";
		echo "<p>Address: {$ownerDetails['address']}</p>";
		echo "<p>Email:  <a href = 'mailto: '. $ownerDetails[email]>{$ownerDetails['email']}</a></p>";
		echo "<p>Phone: {$ownerDetails['phone']}</p> <br>";
		echo "<p>Dogs Registered: </p>";
		if($listOfDogs){
			$count = 1;
   			foreach ($listOfDogs as $dog) {
   				echo "<li>";
        		echo "$count: {$dog['name']} | {$dog['breed_name']}";
        		echo "</li>";
        		$count = $count + 1;
 			}
 		} else{
   		 echo "This owner has not registered any dogs";
 		}

	} else {
		echo "<p>We can't find any owners under this name.</p>";
	}
	?>

</div>
</body>
</html>

<?php

include "footer.html";

?>