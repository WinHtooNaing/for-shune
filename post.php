<?php


 session_start();
 require 'config/config.php';

 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  
  header("Location: login.php");
  
 }


      $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
      $stmt->execute();
      $result = $stmt ->fetchAll();
      
      $blogId = $_GET['id'];
      
      
      $stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
      $stmtcmt->execute();
      $cmResult = $stmtcmt ->fetchAll();
      
      $auResult=[];
      if($cmResult){
        foreach($cmResult as $key => $value){
          $authorId = $cmResult[$key]['author_id'];
        $stmtau = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
        $stmtau->execute();
        $auResult[] = $stmtau ->fetchAll();
        }
      }

      


     
      if($_POST){


        
          if(empty($_POST['comment']) ){
            if(empty($_POST['comment'])){
              $cmtName = "Comment can be required";
            }
          }else{
            $comment = $_POST['comment'];
       
      
           
            $stmt = $pdo -> prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
            $result = $stmt->execute(
                array(':content' => $comment, ':author_id' => $_SESSION['user_id'],':post_id'=> $blogId)
            );
            if($result){
                header("Location: post.php?id=".$blogId);
            }
          }  

       
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
<link href="https://fonts.googleapis.com/css?family=Righteous%7CMerriweather:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/css/mediumish.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-white fixed-top mediumnavigation">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="container">
	<!-- Begin Logo -->
	<a class="navbar-brand" href="index.php" >
		<h3>Shune</h3>
	
	</a>
	
</div>
</nav>

<div class="container">
	<div class="row">

		<!-- Begin Fixed Left Share -->
		<div class="col-md-2 col-xs-12">
			
		</div>
		<!-- End Fixed Left Share -->

		<!-- Begin Post -->
		<div class="col-md-8 col-md-offset-2 col-xs-12">
			<div class="mainheading">

				
				<!-- End Top Menta -->

				<h1 class="posttitle"><?php echo $result[0]['title'] ?></h1>

			</div>

			<!-- Begin Featured Image -->
			<img class="featured-image img-fluid" src="admin/images/<?php echo $result[0]['image'] ?>" alt="">
			<!-- End Featured Image -->

			<!-- Begin Post Content -->
			<div class="article-post">
				<p>
				<?php echo $result[0]['content'] ?><br><br>
				<h3>Comments</h3>
				</p>
				<div class="card-footer card-comments">
                <div class="card-comment">
                  <?php 
                  if($cmResult){
                    ?>
                    <div class="comment-text" style="margin-left:0px !important">
                    <?php 
                    foreach($cmResult as $key => $value){
                    ?>
                    <span class="username">
                      <b><?php print_r($auResult[$key][0]['name']) ?></b><br>
                      <p class="text-muted float-right"><?php echo date('d-m-Y',strtotime($value['created_at'])) ?></p>
                    </span><!-- /.username -->
                    <?php echo $value['content'] ?>
					<br>
                    <?php }?>
                   
                    </div>
					

                  <?php  
                  }
                  ?>
                </div>
              </div>
				
			</div>
			<form action="" method="post">
                  <div class="img-push">
                  <p style="color: red;"><?php echo empty($cmtName) ? '' : $cmtName ?></p>
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
			<!-- End Post Content -->

			<!-- Begin Tags -->
			
			<!-- End Tags -->

		</div>
		<!-- End Post -->

	</div>
</div>
<!-- End Article
================================================== -->

<div class="hideshare"></div>

<!-- Begin Related
================================================== -->

<?php 
      $stmtRan = $pdo->prepare("SELECT * FROM posts ORDER BY RAND() LIMIT 3");
      $stmtRan->execute();
      $resultRan = $stmtRan ->fetchAll();
?>
<div class="graybg">
	<div class="container">
		<div class="row listrecent listrelated">

		<?php
                    if($resultRan){
                      $i =1;
                      foreach($resultRan as $value){
                    ?>
			<!-- begin post -->
			<div class="col-md-4">
				<div class="card">
					<a href="post.php?id=<?php echo $value['id']?>">
					<img class="img-fluid img-thumb" src="admin/images/<?php echo $value['image']?>" alt="" style="height:250px;width:100%;object-fit:cover">
					</a>
					<div class="card-block">
						<h2 class="card-title"><a href="post.php?id=<?php echo $value['id']?>"><?php echo $value['title']?></a></h2>
						<div class="metafooter">
							<div class="wrapfooter">
								<span class="meta-footer-thumb">
								<a href="author.php"><img class="author-thumb" src="dist/img/my.jpg" alt="Sal"></a>
								</span>
								<span class="author-meta">
								<span class="post-name"><a href="author.php">winhtoonaing</a></span><br/>
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
                    $i++;
                    }
                  }
                    ?>

		</div>
	</div>
</div>
<!-- End Related Posts
================================================== -->

<!-- Begin Twitter Timeline
================================================== -->

<!-- End Twitter Timeline
================================================== -->

<!-- Begin AlertBar
================================================== -->
<div class="alertbar">
	<div class="container text-center">
		 &nbsp;ဒီ blog က တစ်ယောက်သော သူအတွက် သာ <a href="index.php" class="btn subscribe">Back</a>
	</div>
</div>
<!-- End AlertBar
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
		
		<div class="clearfix">
		
		</div>
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
<script src="assets/js/mediumish.js"></script>
</body>
</html>
