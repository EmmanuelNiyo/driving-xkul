
<?php include('includes/session.php')?>
<?php include('includes/config.php')?>


<?php
if (isset($_GET['delete'])) {
  $delete = $_GET['delete'];
  $sql = "DELETE FROM note where note_id = ".$delete;
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Note removed Successfully');</script>";
      echo "<script type='text/javascript'> document.location = 'insert-notes.php'; </script>";
    
  }
}

 if(isset($_POST['submit'])){
        
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $note=mysqli_real_escape_string($conn,$_POST['note']);
        // $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

        $fname = $_FILES['image']['name'];

			  $ftemp = $_FILES['image']['tmp_name'];

			  $fsize = $_FILES['image']['size'];

			  $ftype = $_FILES['image']['type'];

			  $ferror = $_FILES['image']['error'];

        date_default_timezone_set("Central Africa Time");
        $time_now = date("h:i:sa");

        // <?php
            // echo "The time is " . date("h:i:sa");
        // 

        if($ferror === 0){
          if ($fsize < 70485760){

                $destination = 'imagess/'.$fname;

                move_uploaded_file($ftemp, $destination);

                $query = "INSERT INTO note(user_id,title,note,name,time_in) VALUES('$session_id','$title','$note','$destination','$time_now')";
                  $done = mysqli_query($conn,$query);

                  if(mysqli_query($conn, $query)){
                    echo "<script>alert('Note Added Successfully');</script>";
          
                  }else{
                      //failure
                      echo 'query error: '. mysqli_error($conn);
                  }


          }
        }

     }

    //********************Selection********************
     $query = "SELECT * FROM note WHERE user_id = \"$session_id\" ";

    if(mysqli_query($conn, $query)){

        // get the query result
        $result = mysqli_query($conn, $query);

        // fetch result in array format
        $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);

        // print_r($notesArray);

    }else{
        //failure
        echo 'query error: '. mysqli_error($conn);
    }
?>

<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>Note</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <div class="navbar-header aside-md">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="imagess/logo.png" class="m-r-sm">Notebook</a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="dropdown">
          <?php $query= mysqli_query($conn,"select * from users where user_id = '$session_id'")or die(mysqli_error());
                $row = mysqli_fetch_array($query);
            ?>

          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="images/profile.jpg">
            </span>
            <?php echo $row['username']; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li class="divider"></li>
            <!--li>
              <a href="logout.php" data-toggle="ajaxModal" >Logout</a>
            </li-->
          </ul>
        </li>
      </ul>      
    </header>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
                    <li  class="active">
                      <a href="notebook.php" class="active">
                        <i class="fa fa-pencil icon">
                          <b class="bg-info"></b>
                        </i>
                        <span>Notes</span>
                        <li class="menu-item-has-children dropdown">
                     <a href="index.php" > CREATE EXAM </a>
                  </li>
				      <li class="menu-item-has-children dropdown">
                     <a href="exam_list.php" > EXAMS </a>
                  </li>
				      <li class="menu-item-has-children dropdown">
                     <a href="create_period.php" > CREATE EXAM PERIOD </a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="exam_period.php" > EXAM PERIOD </a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <!-- <a href="ReportStudent.php" > REPORT </a> -->
                     <a href="#" > REPORT </a>
                     <ul>
                        <li class="menu-item-has-children dropdown"><a href="ReportStudent.php">REPORT: STUDENT LIST</a></li>
                        <li class="menu-item-has-children dropdown"><a href="ReportStudent.php">REPORT: STUDENT GRADES</a></li>
                        

                     </ul>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="insert-notes.php"> CREATE NOTES </a>
                  </li>
                  
                      </a>
                    </li>
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">
              <div id="invite" class="dropup">                
                <section class="dropdown-menu on aside-md m-l-n">
                  <section class="panel bg-white">
                    <header class="panel-heading b-b b-light">
                      <?php $query= mysqli_query($conn,"select * from users where user_id = '$session_id'")or die(mysqli_error());
                        $row = mysqli_fetch_array($query);
                      ?>
                      <?php echo $row['username']; ?> <i class="fa fa-circle text-success"></i>
                    </header>
                    <div class="panel-body animated fadeInRight">
                      <p><a href="https://www.youtube.com/channel/UCGnh6Xo-GhfNw4q7w9z1YxA/playlists" target="_blank" class="btn btn-sm btn-facebook"><i class="fa fa-fw fa-youtube"></i> Invite from Youtube</a></p>
                    </div>
                  </section>
                </section>
              </div>
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
              <div class="btn-group hidden-nav-xs">
                <button type="button" title="Contacts" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#invite"><i class="fa fa-youtube"></i></button>
              </div>
            </footer>
          </section>
        </aside>
        <!-- /.aside -->
        <section id="content">
          <section class="hbox stretch">
                  <aside class="aside-lg bg-light lter b-r">
                    <div class="wrapper">
                      <h4 class="m-t-none">Add Note</h4>
                      <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                          <label>Title</label>
                          <input name="title" type="text" placeholder="Title" class="input-sm form-control">
                        </div>
                        <div class="form-group">
                        <input type="file" name="image" id="image" />
                        </div>

                        <strong><label>Categories</label></strong>
                        <select class="input-sm form-control" aria-label=".form-select-lg example">
                          <option selected>Open this select menu</option>
                          <option value="1">Traffic Sign</option>
                          <option value="2">Highway</option>
                          <option value="3">Landway</option>
                          </select> <br>

                          <label>Sub_Categories</label>
                          <select class="input-sm form-control" aria-label=".form-select-lg example">
                          <option selected>Open this select menu</option>
                          <option value="1"></option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                          </select>

                        <div class="form-group">
                          <label>Note</label>
                          <textarea name="note" class="form-control" rows="8" data-minwords="8" data-required="true" placeholder="Take a Note ......"></textarea>
                        </div>
                        <div class="m-t-lg"><button class="btn btn-sm btn-default" name="submit" id="insert" type="submit">Add an event</button></div>
                      </form>
                    </div>
                </aside>
                <aside class="bg-white">
                  <section class="vbox">
                    <header class="header bg-light bg-gradient">
                      <ul class="nav nav-tabs nav-white">
                        <li class="active"><a href="#activity" data-toggle="tab"><h4 style = "text-transform:uppercase;"><b>Note Details</b></h4></a></li>
                      </ul>
                    </header>
                    <section class="scrollable">
                      <div class="tab-content">
                        <div class="tab-pane active" id="activity">
                          <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                            <li></li>
                            <?php foreach($notesArray as $note){ ?>
                            <li class="list-group-item">
                                <div class="btn-group pull-right">
                                    <a href="edit-notes.php?edit=<?php echo $note['note_id'];?>"><button type="button" class="btn btn-sm btn-default" title="Show"><i class="fa fa-eye"></i></button></a>
                                    <a href="insert-notes.php?delete=<?php echo $note['note_id'];?>"><button type="button" class="btn btn-sm btn-default" title="Remove"><i class="fa fa-trash-o bg-danger"></i></button></a>
                                  </div>
                                <h3 style = "text-transform:uppercase;"><b><?php echo $note['title'] ?></b></h3>
                                                
                                <img src="<?php echo $note["name"] ?>" height="100" width="100" class="img-thumnail" />  

                                <p><?php echo substr($note['note'], 0, 200)?></p>
                                <small class="block text-muted text-info"><i class="fa fa-clock-o text-info"></i> <?php echo $note['time_in'] ?></small>
                                <?php } ?>
                            </li>
                          </ul>
                        </div>
                        <div class="tab-pane" id="events">
                          <div class="text-center wrapper">
                            <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                          </div>
                        </div>
                        <div class="tab-pane" id="interaction">
                          <div class="text-center wrapper">
                            <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                          </div>
                        </div>
                      </div>
                    </section>
                  </section>
                </aside>
                <aside class="col-lg-4 b-l">
                  <section class="vbox">
                    <section class="scrollable">
                      <div class="wrapper">
                        <section class="panel panel-default">
                          <?php
                             $get_note = mysqli_query($conn,"select * from note WHERE user_id = \"$session_id\" LIMIT 1") or die(mysqli_error());
                             while ($row = mysqli_fetch_array($get_note)) {
                             $id = $row['note_id'];
                                 ?>
                          <h4 style = "text-transform:uppercase;" class="font-thin padder"><b><?php echo $row['title']; ?></b></h4>
                          <ul class="list-group">
                            <li class="list-group-item">
                                <p><?php echo $row['note']; ?> </p>
                            </li>
                          </ul>
                          <?php } ?> 
                        </section>
                        <section class="panel clearfix bg-info lter">
                          <div class="panel-body">
                            <a href="#" class="thumb pull-left m-r">
                              <img src="imagess/profile.jpg" class="img-circle">
                            </a>
                            <div class="clear">
                              <a href="#" class="text-info">@kpeng EMMANUEL <i class="fa fa-twitter"></i></a>
                              <small class="block text-muted">2,415 followers / 225 tweets</small>
                              <a href="https://www.youtube.com/channel/UCGnh6Xo-GhfNw4q7w9z1YxA/playlists" target="_blank" class="btn btn-xs btn-success m-t-xs">Subscribe</a>
                            </div>
                          </div>
                        </section>
                      </div>
                    </section>
                  </section>              
                </aside>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/libs/underscore-min.js"></script>
<script src="js/libs/backbone-min.js"></script>
<script src="js/libs/backbone.localStorage-min.js"></script>  
<script src="js/libs/moment.min.js"></script>
<!-- Notes -->
<script src="js/apps/notes.js"></script>
<script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>

</body>
</html>