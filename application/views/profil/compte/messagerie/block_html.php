                
<div id="block_reser_<?php echo $bloc_numero; ?>">
                  <div class="col-md-4 col-md-offset-1">
                     <input class="date-picker-offer date-picker  required" name="date_offre[]" type="text" value="<?php echo date("d/m/Y",strtotime('+1 day')); ?>" placeholder="JJ/MM/AAAA" >
                  </div>
                  
                  <div class="col-md-3 ">
                    <div class="row">
                      <div class="col-sm-2 pad0 text-center lh40">
                         De
                      </div>
                      <div class="col-sm-10">
                          <select name="horaire_de[]" class="create_html" lid="<?php echo $bloc_numero; ?>">
                          <option value=""></option>
                          <option value="08h">08:00</option>
                          <option value="09h">09:00</option>
                          <option value="10h">10:00</option>
                          <option value="11h">11:00</option>
                          <option value="12h">12:00</option>

                          <option value="13h">13:00</option>
                          <option value="14h">14:00</option>
                          <option value="15h">15:00</option>
                          <option value="16h">16:00</option>
                          <option value="17h">17:00</option>
                          <option value="18h">18:00</option>
                          <option value="19h">19:00</option>
                          <option value="20h">20:00</option>
                          <option value="21h">21:00</option>
                          <option value="22h">22:00</option>
                          </select>
                      </div>
                    </div>
                     
                  </div>
                 <div class="col-md-3 ">
                    <div class="row">
                      <div class="col-sm-2  pad0 text-center  lh40">
                         à
                      </div>
                      <div class="col-sm-10" >
                          <select name="horaire_a[]" class="last_heure<?php echo $bloc_numero; ?>">
                          <option value=""></option>
                          <option value="08h">08:00</option>
                          <option value="09h">09:00</option>
                          <option value="10h">10:00</option>
                          <option value="11h">11:00</option>
                          <option value="12h">12:00</option>

                          <option value="13h">13:00</option>
                          <option value="14h">14:00</option>
                          <option value="15h">15:00</option>
                          <option value="16h">16:00</option>
                          <option value="17h">17:00</option>
                          <option value="18h">18:00</option>
                          <option value="19h">19:00</option>
                          <option value="20h">20:00</option>
                          <option value="21h">21:00</option>
                          <option value="22h">22:00</option>
                          </select>
                      </div>
                    </div>
                     
                  </div>

               <div class="col-md-1 ">
               <div style="margin-top:13px;">
              <a href="#" lid="<?php echo $bloc_numero; ?>" class="delete_block"><span><i class="ion-android-close"></i></span></a> 
               </div>
               </div>

</div>
