          <div class="panel panel-default" id="panelWhatIf" style="display: none;">
            <div class="panel-heading" role="tab" id="headingWhatIf">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#leftMenu" href="#collapseWhatIf" aria-expanded="true" aria-controls="collapseWhatIf">
                  <i class="fa fa-list-alt"></i>
                  รายงานเชิงวิเคราะห์
                </a>

              </h4>
            </div>
            <div id="collapseWhatIf" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingWhatIf">
              <div class="panel-body" style="height:500px;overflow:auto;">
                       
                <p>เรื่อง การคาดการณ์ผู้สมัครพัฒนาฝีมือแรงงาน</p>

                <form>
                  <div class="form-group">
                    <label for="whatIfCategory">เรื่อง</label>
                    <select id="whatIfCategory" class="form-control">
                      <option value="train">การฝึกอบรมฝีมือแรงงาน</option>
                      <option value="test">การทดสอบมาตรฐานฝีมือแรงงาน</option>
                      <option value="test_economy_east">การทดสอบมาตรฐานฝีมือแรงงาน(ตะวันออก)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="whatIfBranchOccupation">กลุ่มสาขาอาชีพ</label>
                    <select id="whatIfBranchOccupation" class="form-control">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="whatIfOccupation">กลุ่มอาชีพ</label>
                    <select id="whatIfOccupation" class="form-control">
                    </select>
                  </div>       
                  <div class="form-group">
                    <label for="whatIfYear">ปีฐาน</label>
                    <select id="whatIfYear" class="form-control">
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="whatIfPredictNum">ค่าคาดการณ์ผู้จบ</label>
                    <input type="text" id="whatIfPredictNum" class="form-control">
                  </div>          

                  <div class="form-group">
                    <button type="button" class="btn btn-primary" id="whatIfconfirm">ยืนยัน</button>
                    <button type="button" class="btn btn-danger">ล้างข้อมูล</button>
                  </div>
                </form>

              </div>
            </div>
          </div>


