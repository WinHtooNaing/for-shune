<?php
 require '../config/config.php';
 session_start();
 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  
  header("Location: login.php");
  
 }
 if($_SESSION['role']  != 1){
  header("Location: login.php");
  
 }
 


 if(isset($_POST['search']) && !empty($_POST['search'])){  // ဒီလို သုံးမရ ဘူးဖြစ်နေတယ် if($_POST['search']){}
  setcookie('search',$_POST['search'],time() + (86400 * 30), "/");
 }else{
  if(empty($_GET['pageno'])){
    unset($_COOKIE['search']);
    setcookie('search',null,-1,'/');
  }
 }





?>

<?php include('header.html'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Table</h3>
              </div>

              <?php
              if(!empty($_GET['pageno'])){
                $pageno = $_GET['pageno'];
              }else{
                $pageno = 1;
              }
              $numOfrecs = 3;
              $offset = ($pageno - 1) *  $numOfrecs ;

              if(empty($_POST['search']) && empty($_COOKIE['search'])){
                $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
            $stmt->execute();
            $rawResult = $stmt ->fetchAll();

            $total_pages = ceil(count($rawResult) / $numOfrecs);


            $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
            $stmt->execute();
            $result = $stmt ->fetchAll();
              }else {
               
                $searchKey = isset($_POST['search']) ? $_POST['search'] : (isset($_COOKIE['search']) ? $_COOKIE['search'] : '');

                // $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'] ; ရေးမရဘူး ဖြစ်နေတယ်
                $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
               
            $stmt->execute();
            $rawResult = $stmt ->fetchAll();

            $total_pages = ceil(count($rawResult) / $numOfrecs);


            $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
            $stmt->execute();
            $result = $stmt ->fetchAll();
                }
            
              ?>

              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="add.php" class="btn btn-success" type="button">New Blog Post</a>
                </div>
                <br/>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 200px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                      $i =1;
                      foreach($result as $value){
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['title']; ?></td>
                      <td><?php echo substr($value['content'],0,50); ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this item')"
                             type="button" class="btn btn-danger">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                    $i++;
                    }
                  }
                    ?>
                    
                  </tbody>
                </table><br>

                
                <nav aria-label="Page navigation example" style="float:right">
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
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->

            
          </div>
          
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html'); ?>
