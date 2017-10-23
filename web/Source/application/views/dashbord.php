<!DOCTYPE html>
<html>
  <?php
	 include "includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include "includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
		
		
		<section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
		  
		       <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
				<?php 
$query = $this->db->query("Select count(id) as count From `bookingdetails`  ");
$row = $query->row('bookingdetails');
				?>
                  <h3><?php echo $row->count;?></h3>
                  <p>Booking</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url();?>admin/pointdriver" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			
			
			
		
		
		 <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
				<?php 
$query = $this->db->query("Select count(id) as count From `driver_details`  ");
$row = $query->row('driver_details');
				?>
                  <h3><?php echo $row->count;?></h3>
                  <p>Driver</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo base_url();?>admin/view_driver" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			
			 <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
				<?php 
$query = $this->db->query("Select count(id) as count From `userdetails` where user_status='Active'  ");
$row = $query->row('userdetails');
				?>
                  <h3><?php echo $row->count;?></h3>
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url();?>admin/dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
		
			
			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                <?php 
$query = $this->db->query("SELECT DISTINCT country FROM visits");
$row = $query->num_rows;
				?>
                  <h3><?php echo $row;?></h3>
                  <p>Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			
			
			
			</div>
		  <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable ui-sortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                  <!--li class="active"><a href="#donut-chart" data-toggle="tab"></a></li>
                  <li><a href="#sales-chart" data-toggle="tab"></a></li-->
                  <li class="pull-left header"><i class="fa fa-inbox"></i> Booking</li>
                </ul>
                <div class="tab-content no-padding" style='padding-bottom:20px !important;'>
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="donut-chart" style="position: relative; height: 300px;"></div>
                  <div class="chart tab-pane" id="s" style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.nav-tabs-custom -->

              <!-- Chat box -->
              <!-- /.box (chat box) -->

              <!-- TO DO List -->
             

              <!-- quick email widget -->
             
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!--button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button-->
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->

                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">
                    Visitors
                  </h3>
                </div>
                <div class="box-body">
                  <div id="world-map" style="height: 250px; width: 100%;"></div>
                </div><!-- /.box-body-->
                <div class="box-footer no-border">
                  <div class="row">
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <div id="sparkline-1"></div>
                      <div class="knob-label"></div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <div id="sparkline-2"></div>
                      <div class="knob-label"></div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center">
                      <div id="sparkline-3"></div>
                      <div class="knob-label"></div>
                    </div><!-- ./col -->
                  </div><!-- /.row -->
                </div>
              </div>
              <!-- /.box -->

            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    <?php
	 include"includes/admin-footer.php";
	 ?>


      
     
    </div><!-- ./wrapper -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    
    <!-- jQuery 2.1.4 -->
     <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/knob/jquery.knob.js"></script>
	
    <!-- DataTables -->
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/flot/jquery.flot.min.js"></script>
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/flot/jquery.flot.resize.min.js"></script>
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/flot/jquery.flot.pie.min.js"></script>
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/flot/jquery.flot.categories.min.js"></script>
 
	 <!-- chart -->
   
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url();?>assets/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	
   
    <?php
   $query = $this->db->query("Select `purpose`,count(id) as count From `bookingdetails` Group by `purpose`  ");
   $rows =$query->result();
   //$arr[]='Month,Point';
   //print_r($query->result());
   foreach ($query->result()  as $row) {
	
	 $purpose[] = $row->purpose;
	 $count[]= $row->count;
    }
$color=array("#3c8dbc","#0073b7","#00c0ef","#0073b7");

$query1 = $this->db->query("Select `country`,count(id) as count From `visits` Group by `country`  ");

?>
  
 <script>
   $(function () {
       
        var data = [], totalPoints = 100;

        var donutData = [
		<?php
		for($i=0;$i<4;$i++){
			?>
		
          {label: "<?php echo $purpose[$i];?>  ", data: <?php echo $count[$i];?>, color: "<?php echo $color[$i];?>"},
		  <?php
		}?>
          
        ];
        $.plot("#donut-chart", donutData, {
          series: {
            pie: {
              show: true,
              radius: 1,
              innerRadius: 0.5,
              label: {
                show: true,
                radius: 2 / 3,
                formatter: labelFormatter,
                threshold: 0.1
              }

            }
          },
          legend: {
            show: false
          }
        });
        /*
         * END DONUT CHART
         */

		      });

      /*
       * Custom Label formatter
       * ----------------------
       */
      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + "<br>"
                + Math.round(series.percent) + "%</div>";
      }
	   $(".knob").knob();

  //jvectormap data
  var visitorsData = {
	  
   <?php
	foreach ($query1->result()  as $row1) {
	 
	  
	 
	 $purpose = $row1->country;
	 $count= $row1->count;
	 echo '"'.$purpose.'":'.$count.',';
	
    }
  ?>
  
  };
  //World map by jvectormap
  $('#world-map').vectorMap({
    map: 'world_mill_en',
    backgroundColor: "transparent",
    regionStyle: {
      initial: {
        fill: '#e4e4e4',
        "fill-opacity": 1,
        stroke: 'none',
        "stroke-width": 0,
        "stroke-opacity": 1
      }
    },
    series: {
      regions: [{
          values: visitorsData,
          scale: ["#92c1dc", "#ebf4f9"],
          normalizeFunction: 'polynomial'
        }]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != "undefined")
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
    }
  });


    </script>
	 
  </body>
</html>
