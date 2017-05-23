          <div class="panel panel-default" id="panelBuffer" style="display: none;">
            <div class="panel-heading" role="tab" id="headingBuffer">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#leftMenu" href="#collapseBuffer" aria-expanded="true" aria-controls="collapseBuffer">
                  <i class="fa fa-list-alt"></i>
                  วิเคราะห์ข้อมูล
                </a>

              </h4>
            </div>
            <div id="collapseBuffer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingBuffer">
              <div class="panel-body" style="height:450px;overflow:auto;">
                
                <form>
                  <div class="form-group">
                    <label for="bufferType">เลือกข้อมูล</label>
                    <select id="bufferType" class="form-control">
                      <option value="hospital">ตำแหน่งโรงพยาบาล</option>
                      <option value="unemployed">ลงทะเบียนหางาน</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">ละติจูด</label>
                    <input type="text" class="form-control" id="bufferLat" placeholder="ละติจูด">
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">ลองติจูด</label>
                    <input type="text" class="form-control" id="bufferLng" placeholder="ลองติจูด">
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">กำหนดรัศมี</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="bufferDistance" placeholder="รัศมี">
                      <span class="input-group-addon">กิโลเมตร</span>
                    </div>
                  </div>                
                  
                  <button type="button" class="btn btn-primary" id="confirmBuffer">ยืนยัน</button> 
                </form>

              </div>
            </div>
          </div>