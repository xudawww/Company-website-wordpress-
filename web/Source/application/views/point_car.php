


                                                        <div class="col-lg-4">
                                                            <div class="select-car">
															  <h5>Select Car</h5>
                                                                <div class="sl-car">
																  <?php foreach($fetch_car as $fetchcar){ ?>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio"  value="<?php echo $fetchcar['cartype']; ?>" class="second" name="car_type"><span><img src="<?php echo base_url();?>assets/img/home/car-vector.png"/></span><span><?php echo $fetchcar['cartype']; ?></span></label>
                                                                        </div>
                                                                    </div>
																	<input type='hidden' value="<?php echo $fetchcar['timetype']; ?>" name="timetype" id="timetype">
																  <?php } ?>
                                                                      </div>


                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="fare">
                                                                <h5>Fare</h5>
                                                                <ul>
																 
																  <?php foreach($fetch_car as $fetchcar){  ?>
                                                              <li>Initial fare for <?php echo $fetchcar['intialkm']; ?> KM  Rs<?php echo $fetchcar['intailrate']; ?>Total fare for <?php echo $fetchcar['total_dist']; ?> KM Rs<?php echo $fetchcar['total_rate']; ?></li>      
                                                                     <?php } ?>
                                                                </ul>

                                                            </div>
                                                        </div>
														
													 