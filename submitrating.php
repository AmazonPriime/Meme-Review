<!DOCTYPE html>

<?php
    include 'functions.php';
	$conn = connectdb();
	$ip = get_client_ip_env();
?>

<html lang="en">
    <head>
         <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- Other meta tags -->
        <meta name="description" content="Welcome to the PewDiePie Meme Review website, here you can find every meme that PewDiePie has featured and rated in his 'Meme Review' series! You can also rate the memes and see the average rating amongst other users!">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        
        <!-- My CSS and JS -->
        <link rel="stylesheet" type="text/css" href="resources/css/default.css">
        <script type="text/javascript" src="resources/js/default.js"></script>

        <!-- Title and Icon -->
        <title>Meme Review • Based on PewDiePie's YouTube Series</title>
        <link rel="shortcut icon" href="https://yt3.ggpht.com/-rJq9gk1QIis/AAAAAAAAAAI/AAAAAAAAAAA/Kx4wkvKOfxY/s288-mo-c-c0xffffffff-rj-k-no/photo.jpg" type="image/x-icon"/>
    </head>
	
    <body>
		<?php
			$rating = $_POST['rating'];
			$meme = $_POST['meme'];
			
			$query = "SELECT id FROM userratings WHERE userid='$ip' AND meme='$meme'";
			$rows = mysqli_query($conn, $query);
			
			if (mysqli_num_rows($rows)==0){
				$query = "INSERT INTO userratings (userid, userrating, meme) VALUES ('$ip', '$rating', '$meme')";
				$rows = mysqli_query($conn, $query);
				
				$query = "UPDATE memelist SET totaluserratings=totaluserratings+1 WHERE memeid='$meme'";
				$rows = mysqli_query($conn, $query);
				
				$query = "UPDATE memelist SET userrating=($total/totaluserratings) WHERE memeid='$meme'";
				$rows = mysqli_query($conn, $query);
			}else{
				$query = "UPDATE userratings SET userrating='$rating' WHERE userid='$ip' AND meme='$meme'";
				$rows = mysqli_query($conn, $query);
				
				$query = "SELECT SUM(userrating) AS total FROM userratings WHERE meme='$meme'";
				$rows = mysqli_query($conn, $query);
				$ratings = mysqli_fetch_assoc($rows);
				$total = $ratings['total'];
				
				$query = "UPDATE memelist SET userrating=($total/totaluserratings) WHERE memeid='$meme'";
				$rows = mysqli_query($conn, $query);
			}
			
			mysqli_close($link);
			
			echo '<script>window.location.href = "index.php"</script>';
		?>
	
        <!-- Required for animated rainbow text -->
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="resources/js/default.js"></script>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </body>
</html>