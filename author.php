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
	<!-- begin logo -->
	<a class="navbar-brand" href="index.php" >
	<h3>Shune</h3>
	
	</a>
	<?php 
      $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $result = $stmt ->fetchAll();
?>
	<!-- end logo -->
	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<!-- begin menu -->
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
		<!-- end menu -->
		<!-- begin search -->
		<!-- <form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="text" placeholder="Search">
			<span class="search-icon"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M20.067 18.933l-4.157-4.157a6 6 0 1 0-.884.884l4.157 4.157a.624.624 0 1 0 .884-.884zM6.5 11c0-2.62 2.13-4.75 4.75-4.75S16 8.38 16 11s-2.13 4.75-4.75 4.75S6.5 13.62 6.5 11z"></path></svg></span>
		</form> -->
		<!-- end search -->
	</div>
</div>
</nav>
<!-- End Nav
================================================== -->

<!-- Begin Top Author Page
================================================== -->
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 col-md-offset-2">
			<div class="mainheading">
				<div class="row post-top-meta authorpage">
					<div class="col-md-10 col-xs-12">
						<h1>Win Htoo Naing</h1>
						<span class="author-description">ငါ့အကြောင်းပြောရမယ်ဆိုရင်တော့ ပုံမှန်ပါပဲကွ အများကတော့ အရက်သမားလို့ ခေါ်ကြတယ်ကွာ တချို့ကလည်း ဘိန်းစွဲ နေတယ် ထင်တယ်တယ့် သူတို့အဲ့ဒီလိုပြောလည်း ငါဘာမှမဖြစ်ပါဘူးကွာ ဟုတ်သလိုလို ရှိနေတာကိုး

ဒါပေမယ့် သူတို့အဲ့လိုပြောတိုင်း ငါအမြဲတမ်း သောက်ဖြစ်တယ် သောက်တိုင်းလဲ သူတို့ကပြောတယ် သူတို့ကပြောတိုင်းလည်း ငါကသောက်ပြန်ရော ဘုရားရှင်ဟောခဲ့တာ တကယ်မှန်တာဟ သံသရာ လည်တယ်ဆိုတာ </span>
						<div class="sociallinks"><a   href="https://www.facebook.com/win.h.naing.77398"><i class="fa fa-facebook"></i></a> <span class="dot"></span> <a href="https://github.com/winhtoonaing"><i class="fa fa-github"></i></a></div>
						<a  href="https://github.com/winhtoonaing" class="btn follow">Follow</a>
					</div>
					<div class="col-md-2 col-xs-12">
						<img class="author-thumb" src="dist/img/my.jpg" alt="Sal">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Top Author Meta
================================================== -->

<!-- Begin Author Posts
================================================== -->
<div class="graybg authorpage">
	<div class="container">
		<div class="listrecent listrelated">


		<?php
            if($result){
            
			for ($i = 0; $i < 3; $i++) {
				$value = $result[$i];
                        
    ?>
				<!-- begin post -->

				<div class="authorpostbox">
					<div class="card">
						<a href="post.php?id=<?php echo $value['id']?>">
						<img class="img-fluid img-thumb" src="admin/images/<?php echo $value['image']?>" alt="">
						</a>
						<div class="card-block">
							<h2 class="card-title"><a href="post.php?id=<?php echo $value['id']?>"><?php echo $value['title'] ?></a></h2>
              <h4 class="card-text"><?php echo $value['content'] ?></h4>
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
				</div>
				<!-- end post -->
				<?php
         
		}
	}
?>

				

		</div>
	</div>
</div>
<!-- End Author Posts
================================================== -->

<!-- Begin Twitter Timeline
================================================== -->
<!-- End Twitter Timeline
================================================== -->

<!-- Begin Footer
================================================== -->
<div class="container">
	<div class="footer">
	  <p class="pull-left">
	    Copyright &copy; 2023 shune blog
	  </p>
	  <p class="pull-right">
	  <div class="float-right d-none d-sm-inline">
    <a href="logout.php" type="button" class="btn btn-primary">Logout</a>
  </div>
	  </p>
	<div class="clearfix"></div>
	</div>
</div>
<!-- End Footer
================================================== -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
