<?php 
  
include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");

   

    if(isset($_GET["term"])) {
        $term = $_GET["term"];
        
      }
      else {
      	exit("You must enter search term");
      }


      if(isset($_GET["type"])) {
        $type = $_GET["type"];
        
      }
      else {
      	  $type = "sites";
      }

      if(isset($_GET["page"])) {
        $page = $_GET["page"];
        
      }
      else {
      	  $page = "1";
      }



    

 ?>

<!DOCTYPE html>
<html>
<head>
	
	<title>Welcome to Toogle</title>
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>

	<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body>


<div class="wrapper">
	<div class="header">

		<div class="headerContent">
			<div class="logoContainer">
				<a href="index.php">
				  <img src="assets/images/tooglelogo.png.png">
			    </a>
			</div>

			<div class="searchContainer">
				<form action="search.php" method="GET">
					
					<div class="searchBarContainer">
						<input type="hidden" name="type" value="<?php echo $type;  ?>">
						<input class="searchBox" type="text" name="term" value="<?php echo $term; ?>">
						<button class="searchButton">
							<img src="assets/images/icons/searches.png">
						</button>

					</div>

				</form>
				
			</div>
			
		</div>
            <div class="tabsContainer">
            	
            	<ul class="tabList">
            		<li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
            			<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>Sites</a>
            		</li>

            		<li>
            			<a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a>
            		
            		</li>
            		
            	</ul>
            </div>		
		
	</div>

	<div class="mainResultsSection">

		<?php 
		if($type == "sites"){
			$resultsProvider = new SiteResultsProvider($con);
            $pageSize = 20;

		}
         else {
         	$resultsProvider = new ImageResultsProvider($con);
            $pageSize = 30;

         }


         $numResults = $resultsProvider->getNumResults($term);

         echo "<p class='resultsCount'>$numResults results found</p>";


         echo $resultsProvider->getResultsHtml($page, $pageSize, $term);


		 ?>
		

	</div>


	<div class="paginationContainer">
		
	        <div class="pageButtons" >
	        <div class="pageNumberContainer">
	        	<img src="assets/images/pageStart.png">
	        </div>

	        <?php 
              
              $pagesToShow =10;
              $numPages = ceil($numResults / $pageSize);
              $pagesLeft = min($pagesToShow, $numPages);

              $currentPage = $page - floor($pagesToShow / 2);


              if($currentPage < 1) {
              	$currentPage = 1;
              }

              if($currentPage + $pagesLeft > $numPages + 1){
              	$currentPage = ($numPages + 1) - $pagesLeft;
              }



              while($pagesLeft != 0 && $currentPage <= $numPages) {

              	if($currentPage == $page) {
              			echo "<div class='pageNumberContainer'>

                     <img src='assets/images/pageSelected.png'>
                     <span class='pageNumber'>$currentPage</span>   


              	</div>";

              	}
              	else{
              			echo "<div class='pageNumberContainer'>
	              			<a href='search.php?term=$term&type=$type&page=$currentPage'>

	                     <img src='assets/images/page.png'>
	                     <span class='pageNumber'>$currentPage</span>  
	                     </a> 


              	</div>";
              	}

              	
              	$currentPage++;
              	$pagesLeft--;

              }

	         ?>




	         <div class="pageNumberContainer">
	        	<img src="assets/images/pageEnd.png">
	        </div>
	    </div>

	</div>

</div>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script type="text/javascript" src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>







</body>
</html>