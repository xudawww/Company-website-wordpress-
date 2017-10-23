 

   <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                        
                                        
                                        
                                        <div class="headerfare">
                                        <div class="col-sm-6">
                                        	<ul class="popuplist">
                                            	 <li class="bestfares">Search </li>
                                                <li><input type="text" placeholder="Starting" name="email1" class="field8 fare-results"></li>
                                               
                                            </ul>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-sm-6">
                                        
                                        	<div class="daynightwap">
                                            
                                           
                          					  <div class="nightwrap faretimings" attr="night" data-value='night'>
                                				<i class="icon1"><img src="<?php echo base_url();?>assets/images/nighticon.png"/></i><br>
                                				<p>(<span>10:00PM-6:00AM</span>)</p>
                            				  </div>
                            				  <div class="daywrap faretimings active" attr="day"  data-value='day'>
                               					 <i class="icon2"><img src="<?php echo base_url();?>assets/images/dayicon.png"/></i><br>
                                				<p>(<span>6:00AM-10:00PM</span>)</p>
                           					 </div>
                        				  </div>
                                        </div>
                                     </div>   
                                     
                                     
                                     
                                        	
                                        
                                        	<div class="tabpopup">
                                    <ul class="tabs" data-persist="true">
                                    
                                    	 <li><a href="#view1" class="current point fare-lists" title="point-to-point">Point to Point</a></li> 
                                         <li><a href="#view2" class="fare-lists" title="airport-to">Airport</a></li>
                                         <li><a href="#view3" class="fare-lists" title="hourly-to">Hourly Rental</a></li>
                                         <li><a href="#view4" class="fare-lists" title="out-to">Outstation</a></li>
                                                  
                                    </ul>
                          
           <div class="table">                          
        <div class="tabcontents">
            <div id="view1" class="point-to-point ddd" >
                <div class="col-sm-12">
                              		
                                    
                                    
                                    <div class="carprice">
                                    
                                    	<ul class="taxiinfohead2">
                                        	<li>Car</li>
                                            <li>&nbsp;</li>
                                            <li>&nbsp;</li>
                                            <li>Fare</li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                        <?php
										$mesr = $row->measurements;
										$str = $row->currency;
										$s = explode(',',$str);
									     
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Point to Point Transfer'");
											 
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                            <hr class="horrizontalline">
                                        <ul class="taxiinfo1 dino-list point-to-point  <?php echo $row1['timetype'];?>" >
                                        	 
                                            <li class="img-width">
                                            <img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>" /></li>
                                            <li class="blankspace"> </li>
                                            <li class="cartype2"><p class="taxiname"><?php echo $row1['cartype'];?></p></li>
                                            <li class="middileone6">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['intailrate'];?> for the first <?php echo $row1['intialkm'];?>.00 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1];?>  <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?> )</p>
                    								
                							</li>
                                            
                                        </ul>
                                        <?php
											  }
											 
											  ?>
                                        
                                       
                                        
                                        
                                    </div>
                                    
                                    
									</div>
                                    
                                    
                                    
                              
                              </div>
                
            </div>
            <div id="view2"  class="airport-to ddd">
                  <div class="col-sm-12">
                              		
                                     <div class="carprice">
                                   
                                    	<ul class="taxiinfohead3">
                                        	<li>Car</li>
                                            <li>&nbsp;</li>
                                            <li>To Airport</li>
                                            
                                            <li>From Airport</li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                         <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Airport Transfer'");
											
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                              <hr class="horrizontalline">
                                        <ul class="taxiinfo3 airport-to <?php echo $row1['timetype'];?>">
                                        	
                                            <li class="img-width"><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"></li>
                                            <li class="cartype"><p class="taxiname"><?php echo $row1['cartype'];?></p></li>
                                            <li class="middileone6">
                                            		<p class="taxiname2"><?php echo $s[1] ;?> <?php echo $row1['intailrate'];?>.00  for the first  <?php echo $row1['intialkm'];?>.0 <?php echo $mesr;?></p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?>)</p>
                                            </li>
                                            <li class="paddingzero going">
               										<p class="taxiname"><?php echo $s[1] ;?>  <?php echo $row1['fromintailrate'];?>.00 for the first <?php echo $row1['fromintialkm'];?>.0 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00 / <?php echo $mesr;?>)</p>
                    								
                							</li>
                                        </ul>
                                      
                                        <?php
											  }
											  
										?>
                                        
                                        
                                     
                     		      </div>
               				 </div>            
       					 </div>
            
            
            </div>
            <div id="view3" class="hourly-to ddd">
                
                <div class="col-sm-12">
                              		
                                    <div class="carprice">
                                    
                                    	<ul class="taxiinfohead2">
                                        	<li>Car</li>
                                            <li>&nbsp;</li>
                                            <li>&nbsp;</li>
                                              <li>&nbsp;</li>
                                            <li>Fare</li>
                                           
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                         
                                         <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Hourly Rental'");
											
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                            <hr class="horrizontalline">
                                        <ul class="taxiinfo1 hourly-to <?php echo $row1['timetype'];?>">
                                        	
                                            <li class="img-width"><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"></li>
                                            <li class="blanckspace2"> </li>
                                            <li class="cartype"><p class="taxiname"><?php echo $row1['cartype'];?></p></li>
                                            <li class="blanckspace2"> </li>
                                            <li class="middileone4">
               										<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00 </p>
                									<p class="taxicondi">(<?php echo $row1['package'];?> )</p>
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
											  
											  ?>
                                       
                                        
                                        
                                    </div>
                                    
                                    
									</div>
                                    
                                    
                                    
                              
                              </div>
                
                
                
                
            </div>
            
            <div id="view4" class="out-to ddd" >
                <div class="col-sm-12">
                              		
                                     <div class="carprice">
                                     
                                    	<ul class="taxiinfohead3">
                                        	<li>Car</li>
                                            <li>&nbsp;</li>
                                            <li>Oneway</li>
                                            
                                            <li>Round</li>
                                        </ul>
                                       
                                        <div class="table-bgwhite">
                                        <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Outstation Transfer'");
											
											
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                             <hr class="horrizontalline">
                                        <ul class="taxiinfo4 out-to  <?php echo $row1['timetype'];?>">
                                        	
                                            <li class="img-width"><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"></li>
                                            <li class="cartype3"><p class="taxiname"><?php echo $row1['cartype'];?></p></li>
                                            <li class="middileone7">
                                            		<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00</p>
                									
                                            </li>
                                            <li class="paddingzero">
               										<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00</p>
                									
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
									 
											  ?>
                                       
                                        
                                                                                
                                     
                     		      </div>
               				 </div>            
       					 </div>
            </div>
            
            
        </div>
        </div>
    </div>
                                        
              </div>                              
                                            
                                        </div>
                                    </div>
                                  </div>
                                   <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
       <script type="text/javascript">
			$(document).ready(function($){
				
									    $('.night').hide();
									 
										   $('.faretimings').click(function(){
											  
											 var a =$(this).data('value');
											 $('.faretimings').removeClass('active');
											 $(this).addClass('active');
											 $('.day').hide();
											 $('.night').hide();
											 $('.'+a).show();
											 var titlec = $('li.selected a.fare-lists ').attr('title');
											
										var length1 = $.find('.'+titlec+'.'+a).length;
										
										if(length1 == 0){
											
											$('.'+titlec+'.ddd').html('<p class="views23">No Results</p>');
										}else{
											
											$('.'+titlec+'.ddd').show();
										}
										  });	
										$('.icon-freechart').click(function(){
																		$('.daywrap').click()
																		 });
																		 
						
							$('.fare-results').on("keyup click input", function () {
								
							
							
if (this.value.length > 0) {
	var a =$('.faretimings.active').data('value');
	
	 var titlec = $('li.selected a.fare-lists ').attr('title');
	
  $('.'+titlec+'.'+a).hide().filter(function () {
    return $(this).text().toLowerCase().indexOf($(".fare-results").val().toLowerCase()) != -1;
  }).show();
  
}
else {
	
  $('.'+titlec+'.'+a).hide();
}
});
			 });
										 
                                    
             </script>   
                                   <script>


/* http://www.menucool.com/tabbed-content Free to use. v2013.7.6 */
(function(){var g=function(a){if(a&&a.stopPropagation)a.stopPropagation();else window.event.cancelBubble=true;var b=a?a:window.event;b.preventDefault&&b.preventDefault()},d=function(a,c,b){if(a.addEventListener)a.addEventListener(c,b,false);else a.attachEvent&&a.attachEvent("on"+c,b)},a=function(c,a){var b=new RegExp("(^| )"+a+"( |$)");return b.test(c.className)?true:false},j=function(b,c,d){if(!a(b,c))if(b.className=="")b.className=c;else if(d)b.className=c+" "+b.className;else b.className+=" "+c},h=function(a,b){var c=new RegExp("(^| )"+b+"( |$)");a.className=a.className.replace(c,"$1");a.className=a.className.replace(/ $/,"")},e=function(){var b=window.location.pathname;if(b.indexOf("/")!=-1)b=b.split("/");var a=b[b.length-1]||"root";if(a.indexOf(".")!=-1)a=a.substring(0,a.indexOf("."));if(a>20)a=a.substring(a.length-19);return a},c="mi"+e(),b=function(b,a){this.g(b,a)};b.prototype={h:function(){var b=new RegExp(c+this.a+"=(\\d+)"),a=document.cookie.match(b);return a?a[1]:this.i()},i:function(){for(var b=0,c=this.b.length;b<c;b++)if(a(this.b[b].parentNode,"selected"))return b;return 0},j:function(b,d){var c=document.getElementById(b.TargetId);if(!c)return;this.l(c);for(var a=0;a<this.b.length;a++)if(this.b[a]==b){j(b.parentNode,"selected");d&&this.d&&this.k(this.a,a)}else h(this.b[a].parentNode,"selected")},k:function(a,b){document.cookie=c+a+"="+b+"; path=/"},l:function(b){for(var a=0;a<this.c.length;a++)this.c[a].style.display=this.c[a].id==b.id?"block":"none"},m:function(){this.c=[];for(var c=this,a=0;a<this.b.length;a++){var b=document.getElementById(this.b[a].TargetId);if(b){this.c.push(b);d(this.b[a],"click",function(b){var a=this;if(a===window)a=window.event.srcElement;c.j(a,1);g(b);return false})}}},g:function(f,h){this.a=h;this.b=[];for(var e=f.getElementsByTagName("a"),i=/#([^?]+)/,a,b,c=0;c<e.length;c++){b=e[c];a=b.getAttribute("href");if(a.indexOf("#")==-1)continue;else{var d=a.match(i);if(d){a=d[1];b.TargetId=a;this.b.push(b)}else continue}}var g=f.getAttribute("data-persist")||"";this.d=g.toLowerCase()=="true"?1:0;this.m();this.n()},n:function(){var a=this.d?parseInt(this.h()):this.i();if(a>=this.b.length)a=0;this.j(this.b[a],0)}};var k=[],i=function(e){var b=false;function a(){if(b)return;b=true;setTimeout(e,4)}if(document.addEventListener)document.addEventListener("DOMContentLoaded",a,false);else if(document.attachEvent){try{var f=window.frameElement!=null}catch(g){}if(document.documentElement.doScroll&&!f){function c(){if(b)return;try{document.documentElement.doScroll("left");a()}catch(d){setTimeout(c,10)}}c()}document.attachEvent("onreadystatechange",function(){document.readyState==="complete"&&a()})}d(window,"load",a)},f=function(){for(var d=document.getElementsByTagName("ul"),c=0,e=d.length;c<e;c++)a(d[c],"tabs")&&k.push(new b(d[c],c))};i(f);return{}})()


</script>