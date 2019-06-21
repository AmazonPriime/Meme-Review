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
        <div class="container center-align">
            <!-- Title -->
            <span class="display-4 title text color-text-flow">Meme Review</span>
            
            <!-- Nav -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand text color-text-flow" href="#">Meme Review</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse justify-content-md-center collapse" id="navbar1">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">home<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="overall.php">overall</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq.php">faq</a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Information Box -->
            <div class="justify-align">
                <h1 class="display-4" id="info-header">Welcome...</h1>
                <p class="lead" id="info-body">to the <span class="text color-text-flow">PewDiePie Meme Review</span> website, here you can find every meme that <span class="text color-text-flow">PewDiePie</span> has featured and rated in his '<a href="https://www.youtube.com/playlist?list=PLYH8WvNV1YEn_iiBMZiZ2aWugQfN1qVfM" target="_blank">Meme Review</a>' series! You can also rate the memes and see the average rating amongst other users!</p>
            </div>
            
            <!-- Divider -->
            <hr>
            
            <!-- Sorting -->
            <div class="btn-group">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort Memes </button>
                <div class="dropdown-menu">
                    <a href="index.php?sort=newold"><button class="dropdown-item" type="button">New-Old</button></a>
                    <a href="index.php?sort=oldnew"><button class="dropdown-item" type="button">Old-New</button></a>
                    <a href="index.php?sort=highlow"><button class="dropdown-item" type="button">High-Low Rating</button></a>
                    <a href="index.php?sort=lowhigh"><button class="dropdown-item" type="button">Low-High Rating</button></a>
                    <a href="index.php?sort=random"><button class="dropdown-item" type="button">Random</button></a>
                </div>
            </div>
            <br>
			<?php
				@ $sort = $_GET['sort'];
				switch ($sort){
                    case "newold":
                        $sortby = "date DESC";
						echo '<p class="text-muted">Sorted by: <span class="dynamic-info">New-Old</span></p>';
                        break;
                    case "oldnew":
                        $sortby = "date ASC";
						echo '<p class="text-muted">Sorted by: <span class="dynamic-info">Old-New</span></p>';
                        break;
                    case "highlow":
                        $sortby = "userrating DESC";
						echo '<p class="text-muted">Sorted by: <span class="dynamic-info">Rating High-Low</span></p>';
                        break;
                    case "lowhigh":
                        $sortby = "userrating ASC";
						echo '<p class="text-muted">Sorted by: <span class="dynamic-info">Rating Low-High</span></p>';
                        break;
                    case "random":
                        $sortby = "RAND()";
						echo '<p class="text-muted">Sorted by: <span class="text color-text-flow">RANDOM</span></p>';
                        break;
                    default:
                        $sortby = "date DESC";
						echo '<p class="text-muted">Sorted by: <span class="dynamic-info">New-Old</span></p>';
                }
				$query = "SELECT memeid, meme, pewdrating, userrating, image, link, date FROM memelist ORDER BY ".$sortby;
			?>
			
			
			<!-- 
			$query = "SELECT userrating FROM userratings WHERE userid=$ip AND meme=$memes['memeid']";
							$nrows = mysqli_query($conn, $query);
							if (mysqli_num_rows($nrows)==0){
								$userrating = 0;
							}else{
								$user = mysqli_fetch_array($nrows);
								$userrating = $user['userrating'];
							}
							
			$newrows = mysqli_query($conn, "SELECT userrating FROM userratings WHERE userid=$id AND meme=$memes['memeid']");
								$user = mysqli_fetch_array($newrows));
			-->
			
			
            <!-- Memes -->
			<div class="row">
				<?php
					$rows = mysqli_query($conn, $query);
					if (mysqli_num_rows($rows)==0){
						echo "Database is empty, idk why. Broken. Maybe. What's it to you?";
					}else{
						while ($memes = mysqli_fetch_array($rows)){
				?>
				<div class="col">
					<div class="card card-meme mx-auto">
						<img src="resources/images/<?php echo $memes['image']; ?>" class="card-img-top img-fluid img-meme">
						<div class="card-body left-align">
							<h5 class="card-title"><?php echo $memes['meme']; ?></h5>
							<p class="card-text font-weight-bold">PewDiePie Rating: <span class="font-weight-normal"><?php echo $memes['pewdrating']; ?></span><br>Avg. User Rating: <span class="font-weight-normal"><?php echo $memes['userrating']; ?></span><br>Date: <span class="font-weight-normal"><?php echo $memes['date']; ?></span><br>YT Link: <span class="font-weight-normal"><a href="<?php echo $memes['link']; ?>">LINK</a></span>							
							
							<?php 
								$nquery = "SELECT userrating FROM userratings WHERE userid='".$ip."' AND meme=".$memes['memeid'];
								$nrows = mysqli_query($conn, $nquery);
								if (mysqli_num_rows($nrows)==0){
									$userrating = "Not Rated";
								}else{
									$user = mysqli_fetch_array($nrows);
									$userrating = $user['userrating'];
								}
							?>
							
							<br>Your Rating: <span class="font-weight-normal"><?php echo $userrating; ?></span></p>
							<form name="rating-form" action="submitrating.php" method="post">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<label class="input-group-text" for="rating">Rate</label>
									</div>
									<select class="custom-select" id="rating" name="rating" onchange="this.form.submit()">
										<option selected>Select Rating</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
									<input type="hidden" name="meme" id="meme" value="<?php echo $memes['memeid']; ?>">
								</div>
							</form>
							<div class="center-align"><a href="meme.php?meme=<?php echo $memes['memeid']; ?>"><button class="btn">More Info</button></a></div>
						</div>
					</div>
				</div>
				<?php
						}
					}
					mysqli_close($conn);
				?>
				<br>
			</div>
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="center-align container">
                <span class="text-muted">© 2018 Luke Holland</span>
            </div>
        </footer>
        
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