<html>
    <body>

<?php
require_once 'header.php';
?>
        <div class="row card">
          <div class="card logo-bg-b darken-1" style="margin-bottom:0 !important;">
              <div class="card-content white-text" style="padding: 5px !important; ">
            <p style="color:white;"><b>Categories &nbsp;
                <i class="material-icons right">menu</i>
            </b></p>
            </div>
          </div>
        <div class="card white " style="margin-top:0 !important; margin-bottom:0 !important;">
            <div class="card-content white-text" style="padding: 5px !important; ">
                <ul>
        <?php
mysqli_data_seek($serv_cat, 0);
            while($row = mysqli_fetch_array($serv_cat)) {
?>
        <li>
            <a href="<?php  echo Crm::root()."Services/".$row[0]; ?>"><?php echo $row[0]; ?></a>
        </li>
<?php
            }
            ?>
            </ul>
            </div>
          </div>
        </div>
    </body>
</html>