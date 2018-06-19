            <div class="lazy slider homebiz-slider" style=" max-height: 100% !important;">
                <?php
                for($i=1;$i<=7;$i++) {
                if($i!=6) {
                ?>
                            <div class="slick-slide slide slide-has-caption">
                    <a href="<?php echo "http://".$_SERVER["SERVER_NAME"]."/StartSelling"; ?>">
                        <img class=" responsive-img" style="height: 200px !important; width: auto !important;
                         display: block !important; margin-left: 0px !important;"
                         src="<?php echo "http://".$_SERVER["SERVER_NAME"]."/assets/images/slide$i.jpg"; ?>" 
                         onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/large.png';" />
                    </a>
                          </div>
                <?php
                }
                elseif($i==6) {
                ?>
                            <div class="slick-slide slide slide-has-caption">
                                <a href="<?php echo "http://".$_SERVER["SERVER_NAME"]."/HowItWorks"; ?>">
                    <img class=" responsive-img" style="height: 200px !important; width: auto !important;
                         display: block !important; margin-left: 0 !important;"
                         src="<?php echo "http://".$_SERVER["SERVER_NAME"]."/assets/images/slide$i.jpg"; ?>" 
                         onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/large.png';" />
                                </a>
                          </div>
                <?php
                }
                else {
                ?>
                            <div class="slick-slide slide slide-has-caption">
                    <img class=" responsive-img" style="height: 200px !important; width: auto !important;
                         display: block !important; margin-left: 0 !important;"
                         src="<?php echo "http://".$_SERVER["SERVER_NAME"]."/assets/images/slide$i.jpg"; ?>" 
                         onError="this.onerror=null;this.src='http://www.homebiz365.in/uploads/images/large.png';" />
                          </div>
                <?php
                }
                }
                ?>
      </div>
