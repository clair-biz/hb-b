<html>
    <head>
        <?php require_once 'stylesheets.html';?>
    </head>
<body>
<section class="body" >
    <section class="preloader" ></section>
    <section class="content" >
<?php
require_once 'data.php';


$q=Base::generateResult("select disp_name,cat_name,vend_open_time,vend_close_time,city_served,area_served,vend_rating,vend_rating_off,vs_from,vs_for,vs_pay_status from vend_subscription,users,category where vend_subscription.u_id=users.u_id and category.cat_id=vend_subscription.cat_id and u_name='".$_SESSION['user']."'");
$vs_for="";
if($row=mysqli_fetch_array($q)){

    if(!empty($row[9]))
    $vs_for=$row[9];
    
    $vs_from=$row[8];
$date = date_create($vs_from);

str_replace("Annual", "Year", $vs_for);
$vs_for= explode(" ", $vs_for);
$vs_f=$vs_for[1];

$noofmonths=0;
if($vs_for[1]=="Annual")
$noofmonths=$vs_for[0]*12;

elseif($vs_for[1]=="Half")
$noofmonths=$vs_for[0]*6;

if($noofmonths==12)
    $vs_for="1 Year";
elseif($noofmonths==6)
    $vs_for="6 Months";

elseif($noofmonths>12) {
    $y=intval($noofmonths/12);
    $noofmonths=(intval($noofmonths%12));

    if($y==1)
    $vs_for=$y." Year";
    else
    $vs_for=$y." Years";
    
    if($noofmonths>0)
        if($noofmonths==1)
        $vs_for.=" $noofmonths Month";
        else
        $vs_for.=" $noofmonths Months";
}

?>
    <div class="container-fluid row" style="margin-top: 40px;">
<div class="card col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
    <h5 class="card-header"><b><?php echo $row[0]; ?></b></h5>
    <div class="card-body">
        <table width="100%" class="table table-striped table-responsive table-bordered table-hover">
                                <tbody>
        <tr>
            <th class="">Serving </th>
            <td><?php echo $row[1]; ?></td>
        </tr>
        <?php if(!is_null($row[2]) && !is_null($row[3])) { ?>
        <tr>
            <th class="">Service Timings </th>
            <td><?php echo $row[2]." - ".$row[3]; ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <th class="">City </th>
            <td><?php echo $row[4];
            if(!is_null($row[5]))
                echo " in ".$row[5]." Area";
            ?></td>
        </tr>
        <tr>
            <th class="text-center" colspan="2">Subscription Details </th>
        </tr>
        <tr>
            <th class="" >From </th>
            <td><?php echo date_format($date,'d-m-Y'); ?></td>
        </tr>
        <tr>
            <th class="" >Expiring on </th>
            <td><?php
            $val= explode(" ", $row[9]);
            $val1= strtolower($val[1]);
            echo date_format(date_add($date,date_interval_create_from_date_string("$noofmonths months")),"d-m-Y"); ?></td>
        </tr>
        <?php if($vs_for!="") { ?>
        <tr>
            <th class="" >Requested Renewal for </th>
            <td><?php echo $vs_for; ?></td>
        </tr>
        <?php 
            }
        ?>
        <tr>
            <th class="" >Extend Subscription </th>
            <td>
            <form action="extend-subsc.php" method="post">
            <div class="row">
        <div class="col-md-4 col-sm-6 form-group">
           <input type="text" class="form-control" autocomplete="off" id="for_val" name="for_val" value="1" />
            <label for="for_val">Subscription Plan<font style="color:red">*</font>:</label>
        </div>
        <div class="col-md-4 col-sm-6">
           <select class="form-control" id="for" name="for" >
               <option selected value="Annual">Year</option>
                    <option value="Half Annual">Half Year</option>
                </select>
        </div>
                    <div class="col-md-4 col-sm-12 text-center submit-btn">
                <button id="submit-vendor-extend" type="submit" name="user" value="<?php echo $_SESSION["user"]; ?>" class="btn waves-effect waves-light" style="margin-bottom: 75px;">Request
                <i class="material-icons right">send</i>
                </button>
                </div>
	</div>
            </form>
</td>
        </tr>
    </tbody>
    <tbody>
                            </table>
    </div>
</div>

<?php 
}
?>

    </div>
    </section>
    </body>
</html>