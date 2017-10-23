 <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 3.1.1
        </div>
        <strong>Copyright &copy; 2015-2016 <a href="http://www.techware.co.in/">Techware Solution</a>.</strong> All rights reserved.
      </footer>
	  <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
      
	  <script>
   $(document).ready(function(){
	  
       var url      = window.location.href;
      $('.sidebar-menu li a').each(function(){
        var li_url=$(this).attr('href');
          if(li_url==url){
           $(this).parents('li').addClass('active');
           }
        });

   
   });
       
   </script>