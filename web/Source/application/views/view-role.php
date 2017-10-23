<?php
if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMC Admin </title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php
	 include"uploads/admin_header.php";
	 ?>
          

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Promo Code Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Promo Code Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                 <?php
								 
								  
						$this->db->select('C.rol_id,B.rolename as rolename,A.pages as pages');
$this->db->from('pages A');// I use aliasing make joins easier
$this->db->join('role_permission C', 'A.p_id = C.page_id');
$this->db->join('role B', 'B.r_id= C.rol_id');


$query = $this->db->get();
 
 
 
                     //tblanswers
                 
             
                 
 ?>
                            
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Pages</th>
                                            
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php
									$i = 0;
									foreach ($query->result() as $row){
										$index = $row->rolename;
										$items = array($index);
										
										 $items[]=$row->pages;
										
										 
										 $item[$items[0]][]=$items[1];
										 $item[$items[0]]["id"]=$row->rol_id;
										 //print_r($row);
										 ?>
                                         <?php
									}
									
									/*echo '<pre>',print_r($item),'</pre>';*/
									foreach($item as $key => $v)
{
   ?>
   
                                        <tr class="odd gradeX" >
                                        
                                           <td><?php  echo $key; ?></td>
                                           <td><?php   echo implode(",",$v);  ?></td>
                                           <td><a href="<?php echo base_url();?>admin/edit_role?r_id=<?php echo $v['id'] ;?>" >Edit</a> &nbsp;&nbsp;<a href="0#" title="<?php echo $v['id'] ;?>" class="delete">Delete</a> </td>
                                           
                                           </tr>
									<?PHP
									}
										?>

                                    
                                    </tbody>
                                   
                                </table>                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <!-- /.row -->
            
            <!-- /.row -->
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
		
		
		$('.delete').click(function(){	
							
			var r = confirm("Are you sure want to delete Role ");
			if (r == true) {
				var th=$(this);			
				var rol_id = $(this).attr('title');
				
				
				$.ajax({
					url:'<?php echo base_url();?>admin/role_delete',
					type:'post',
					data:{'rol_id':rol_id},
					success:function(cancel){
					console.log(cancel);
					if(cancel==1){
					th.hide();
					location.reload();
					
					
					
					}
					else{
					alert("err");
					}
					}
				});  								
			}
						   
});				
    });
    </script>

</body>

</html>
<?php
}
else{
	$this->load->view('admin-login');
}
?>