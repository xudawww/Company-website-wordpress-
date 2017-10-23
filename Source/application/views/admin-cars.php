<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Cars
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>welcome"><i class="fa fa-cube"></i> Home</a></li>
         <li>><a href="<?php echo base_url(); ?>welcome/view_practice">Manage Car Types</a></li>
         <li class="active">View Car types</li>
      </ol>
   </section>
   <!-- Main content -->	
   <section class="content">
      <div class="row">
	  <div class="col-md-12">
			<?php
				    if($this->session->flashdata('message')) {
				    $message = $this->session->flashdata('message');
					?>
					<div class="alert alert-<?php echo $message['class']; ?>">
					<button class="close" data-dismiss="alert" type="button">×</button>
					<?php echo $message['message']; 
					?>
					</div>
					<?php
					}
               
            ?>
			</div>
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-warning">
               <div class="box-header with-border">
                  <h3 class="box-title">Add Car Type</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"   data-parsley-validate="" class="validate" >
                  <div class="box-body">
                     <div class="col-md-12">
									
					       
		
						<div class="form-group">
						<label for="exampleInputEmail1">Car Type Name</label>
						<input type="text" class="form-control" name="practice_name" id="practice_name" value=""  placeholder="Enter car type"  required =" " />
							
								</div>
						

						
						
                     </div>
					 
                     <!-- /.box -->
                  </div>
                  <div class="box-footer">
                     <button type="submit" id="r2" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">View Car Type Details</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="hidden">ID</th>
                           <th>Car Type Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($law as $rawinfo){		 
                           ?>
                        <tr>
                           <td class="hidden"><?php echo $rawinfo->id; ?></td>
                           <td class="center"><?php echo $rawinfo->car_type; ?></td>
                           <td class="center">	
						       
							  <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>admin/edit_cardetails/<?php echo $rawinfo->id; ?>">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
							   
							   
                              
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>admin/delete_cardetails/<?php echo $rawinfo->id; ?>" onClick="return doconfirm()"> 
                              <i class="fa fa-fw fa-trash"></i>Delete</a>           
                             
								 
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th class="hidden">ID</th>
                           <th>Car Type Name</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>
		 
		 
         <!-- /.col -->
      </div>
   </section>
</div>
<!-- /.row -->
<!-- /.content -->
		<SCRIPT>
		<script>
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
</script>
</SCRIPT>		

    
