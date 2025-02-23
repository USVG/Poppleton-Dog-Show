<?php

include "connect.php";
include "header.html";

$query1 = "SELECT COUNT(DISTINCT owners.id) AS owner_count FROM owners, entries, dogs WHERE owners.id = dogs.owner_id AND dogs.id = entries.dog_id;";
$resultset = $conn->query($query1);
$ownerQuery = $resultset->fetch();

$query2 = "SELECT COUNT(DISTINCT dogs.id) AS dog_count FROM owners, entries, dogs WHERE dogs.id = entries.dog_id;";
$resultset = $conn->query($query2);
$dogQuery = $resultset->fetch();

$query3 = "SELECT COUNT(DISTINCT events.id) AS event_count FROM events, competitions WHERE events.id = competitions.event_id;";
$resultset = $conn->query($query3);
$eventQuery = $resultset->fetch();

$query4 = "SELECT d.name AS name, b.name AS breed_name, AVG (e.score) AS average_score, o.name AS owners_name, o.email AS owners_email FROM dogs d, breeds b, entries e, owners o WHERE d.id = e.dog_id AND b.id = d.breed_id AND o.id = d.owner_id GROUP BY e.dog_id, b.name HAVING COUNT(dog_id) > 1 ORDER BY average_score DESC LIMIT 10;";
$resultset = $conn->query($query4);
$dogList = $resultset->fetchAll();

?>

<div class="content">
	<?php
	echo "<h1>Welcome to Poppleton Dog Show! This year {$ownerQuery["owner_count"]} owners entered {$dogQuery["dog_count"]} dogs in {$eventQuery["event_count"]} events!</h1>";
	echo "<p>The following is a list of current top 10 dogs in terms of average score.<p><br>";


	if($dogList){
	$count = 1;
    foreach ($dogList as $dog) {

        echo "<li>";
        echo "$count: Name: {$dog["name"]} | Breed: {$dog["breed_name"]} <br> Average Score: {$dog["average_score"]} | Owners Name: <a href='owner_information.php?name={$dog["owners_name"]}'>{$dog["owners_name"]}</a> | Owners Email: <a href = 'mailto: '. $dog[owners_email]>$dog[owners_email]</a>";
        echo "</li> <br>";
        $count = $count + 1;
    	}
 	} else{
    echo "No records found";
 	}

	?> 

</div>

<?php

include "footer.html";

?>
