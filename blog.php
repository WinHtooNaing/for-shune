<?php


 session_start();
 require 'config/config.php';
 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  
  header("Location: login.php");
  
 }
 if($_SESSION['role']  != 0){
  header("Location: login.php");
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="assets/img/favicon.ico">
<title>MOOKTUU</title>
<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<!-- Fonts -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/css/mediumish.css" rel="stylesheet">



</head>
<body>

<!-- Begin Nav
================================================== -->
<nav class="navbar navbar-toggleable-md navbar-light bg-white fixed-top mediumnavigation">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="container">
	<!-- Begin Logo -->
	<a class="navbar-brand" href="index.php" >
		<h3>Shune</h3>
	
	</a>
	<!-- End Logo -->
	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<!-- Begin Menu -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
			<a class="nav-link" href="index.php">Stories <span class="sr-only">(current)</span></a>
			</li>
            <li class="nav-item">
			<a class="nav-link" href="blog.php">Blog</a>
			</li>
			
			<li class="nav-item">
			<a class="nav-link" href="author.php">Author</a>
			</li>
		</ul>
		<!-- End Menu -->
		<!-- Begin Search -->
		
		<!-- End Search -->
	</div>
</div>
</nav>







<div class="container">
	<!-- <div class="mainheading">
		<h1 class="sitelead">ရွှန်းကိုချစ်တယ့်အကြောင်း နေ့တိုင်းတင်မည်</h1>
		<p class="lead">
			 အချစ်နွံမှာ နစ်မွန်းနေလို့ပါကွာ
		</p>
	</div> -->



	<section class="recent-posts">
	<div class="section-title">
		<h2><span>All Stories</span></h2>
	</div>
	<?php 
      if(!empty($_GET['pageno'])){
		$pageno = $_GET['pageno'];
	  }else{
		$pageno = 1;
	  }
	  $numOfrecs = 9;
	  $offset = ($pageno - 1) *  $numOfrecs ;

	
		$stmtrw = $pdo->prepare("SELECT * FROM posts ORDER BY id ");
	$stmtrw->execute();
	$rawResult = $stmtrw ->fetchAll();

	$total_pages = ceil(count($rawResult) / $numOfrecs);


	$stmtAsc = $pdo->prepare("SELECT * FROM posts ORDER BY id  LIMIT $offset,$numOfrecs");
	$stmtAsc->execute();
	$resultAsc = $stmtAsc ->fetchAll();
?>
	<div class="card-columns listrecent">

	<?php
            if($resultAsc){
            
			for ($i = 0; $i <  count($resultAsc); $i++) {
				$value = $resultAsc[$i];
                        
    ?>


		<!-- begin post -->
		<div class="card">
			<a href="post.php?id=<?php echo $value['id']?>">
				<img class="img-fluid" src="admin/images/<?php echo $value['image']?>" alt="" style="height:250px;width:100%;object-fit:cover;">
			</a>
			<div class="card-block">
				<h2 class="card-title"><a href="post.php?id=<?php echo $value['id']?>"><?php echo $value['title']?></a></h2>
				<h4 class="card-text"><?php echo substr($value['content'],0,150); ?></h4>
				<div class="metafooter">
					<div class="wrapfooter">
						<span class="meta-footer-thumb">
						<a href="author.php"><img class="author-thumb" src="dist/img/my.jpg" alt="Sal"></a>
						</span>
						<span class="author-meta">
						<span class="post-name"><a href="author.php">win htoo naing</a></span><br/>
						<span class="post-date"><?php echo date('d-m-Y',strtotime($value['created_at'])) ?></span>
						</span>
						<span class="post-read-more"><a href="post.php?id=<?php echo $value['id']?>" title="Read Story"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path></svg></a></span>
					</div>
				</div>
			</div>
		</div>
		<!-- end post -->
		<?php
         
		}
	}
?>
   

		

	</div>
	</section>
	<!-- End List Posts
	
	
	================================================== -->
	<nav aria-label="Page navigation example" style="display:flex;justify-content :center">
                  <ul class="pagination">
                    <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
                      <a href="<?php if($pageno<=1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>" class="page-link">Previous</a>

                    </li>
                    <li class="page-item"><a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>">
                      <a href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>" class="page-link">Next</a>
                    </li>
                    <li class="page-item"><a href="?pageno=<?php echo $total_pages ?>" class="page-link">Last</a></li>
                  </ul>
              </nav>

	<!-- Begin Footer
	================================================== -->
	<div class="footer">
		<p class="pull-left">
			 Copyright &copy; 2023 shune blog
		</p>
		<p class="pull-right">
			 design by <a target="_blank" href="https://github.com/winhtoonaing">win htoo naing</a>
		</p>
		<div class="clearfix">
		</div>
	</div>
	<!-- End Footer
	================================================== -->

</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
