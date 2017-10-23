<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Car Type Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>welcome"><i class="fa fa-user"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>welcome/edit_practicedetails">Car Type Details</a></li>
         <li class="active">Edit Car Type</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <?php
               if($this->session->flashdata('message')) {
               $message = $this->session->flashdata('message');
               ?>
            <div class="alert alert-<?php echo $message['class']; ?>">
               <button class="close" data-dismiss="alert" type="button">×</button>
               <?php echo $message['message']; ?>
            </div>
            <?php
               }
               ?>
         </div>
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-warning">
               <div class="box-header with-border">
                  <h3 class="box-title">Edit Car Type Name</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                      <div class="col-md-6">
                    <div class="form-group has-feedback">
					   <label for="exampleInputEmail1">Car Type</label>
                      <input type="text" class="form-control required" name="car_type" value="<?php echo $data->car_type; ?>" id="car_type"  placeholder="Enter car type name" required =" " >
<span class="glyphicon  form-control-feedback"></span>                   
				   </div>
					
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>

