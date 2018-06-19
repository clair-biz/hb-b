<?php
require_once 'header.php';
$id=$_REQUEST["vendid"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
@import url(https://fonts.googleapis.com/icon?family=Material+Icons);

.material-icons {
    direction: ltr;
    display: inline-block;
    font-family: 'Material Icons';
    font-size: 24px;
    font-style: normal;
    font-weight: normal;
    letter-spacing: normal;
    line-height: 1;
    text-transform: none;
    white-space: nowrap;
    word-wrap: normal;
    -webkit-font-feature-settings: 'liga';
    -webkit-font-smoothing: antialiased;
}

* {
  margin: 0;
  padding: 0;
  font-family: roboto;
}

body { background: #000; }


hr {
  margin: 20px;
  border: none;
  border-bottom: thin solid rgba(255,255,255,.1);
}

div.title { font-size: 2em; }

h1 span {
  font-weight: 300;
  color: #Fd4;
}

div.stars {
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  font-size: 36px;
  color: #444;
max-width: 20% !important; 
}
input.star:checked ~ label.star:before {
  content: 'star rate';
  color: #FD4;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }


label.star:before {
  content: 'star border';
  font-family: 'Material Icons';
}
</style>

    </head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please give Rating for <?php echo Crm::getdispnamebyuid($id);?></h3>
                    </div>
                    <div class="panel-body">
  <div class="stars col-md-offset-2 col-md-8 row">
    <form role="form" method="post" action="rating1.php">
        <div class="row">
        <input class="star star-5" id="star-5" type="radio" value="5" name="star"/>
      <label class="star star-5" for="star-5"></label>
      <input class="star star-4" id="star-4" type="radio" value="4" name="star"/>
      <label class="star star-4" for="star-4"></label>
      <input class="star star-3" id="star-3" type="radio" value="3" name="star"/>
      <label class="star star-3" for="star-3"></label>
      <input class="star star-2" id="star-2" type="radio" value="2" name="star"/>
      <label class="star star-2" for="star-2"></label>
      <input class="star star-1" id="star-1" type="radio" value="1" name="star"/>
      <label class="star star-1" for="star-1"></label>
        </div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <input type="hidden" name="vendid" value="<?php echo $id; ?>" />
            <button style="left:0; right:0" class="btn btn-primary btn-block " type="submit">Submit</button>
            </div>
        </div>
    </form>
  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
 require_once 'footer.php';
 ?>
</body>

</html>
