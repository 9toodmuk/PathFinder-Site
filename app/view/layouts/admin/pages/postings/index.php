<?php
use Controller\Admin\Employer;
use Controller\Admin\Postings;
use Controller\Admin\Categories\JobController;
?>
      <div class="row">
          <div class="col-lg-12">
            <div class="alert" id="errorbox" style="display:none;"></div>
              <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col col-xs-6">
                        <h3 class="panel-title">รายชื่อตำแหน่งงาน</h3>
                      </div>
                      <div class="col col-xs-6 text-right">
                          <a href="/admin/postings/add/" class="btn btn-primary"><em class="fa fa-plus"></em> เพิ่ม</a>
                      </div>
                    </div>
                  </div>
                  <div class="panel-body">
                    <table width="100%" class="table table-hover" id="datatables">
                      <thead>
                        <tr>
                          <th width="5%">ID</th>
                          <th>ชื่อตำแหน่ง</th>
                          <th>บริษัท</th>
                          <th>หมวดหมู่</th>
                          <th><em class="fa fa-cog"></em></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $postings = Postings::getAllPostings();
                          while($row = $postings->fetch_assoc()) {
                        ?>
                        <tr id="g<?php echo $row['id'] ?>">
                          <td width="20px" id="tid<?php echo $row['id'] ?>"><?php echo $row["id"] ?></td>
                          <td><?php echo $row["name"] ?></td>
                          <td><?php $emp = Employer::loadEmployer($row["company_id"]); echo $emp['name']; ?></td>
                          <td><?php $cat = JobController::loadCategories($row["category_id"]); echo $cat['name']; ?></td>
                          <td align="center">
                            <?php
                              if(Postings::checkFeaturedJob($row['id']) <= 0){
                                echo "<a class='btn btn-default btn-xs' onclick='featuredJob(this)' href='#".$row['id']."'><em class='fa fa-star'></em></a>";
                              }else{
                                echo "<a class='btn btn-warning btn-xs' onclick='featuredJob(this)' href='#".$row['id']."'><em class='fa fa-star'></em></a>";
                              }
                            ?>
                            <a class="btn btn-default btn-xs" href="/admin/postings/edit/<?php echo $row["id"] ?>"><em class="fa fa-pencil"></em></a>
                            <a class="btn btn-danger btn-xs" href="#" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-trash"></em></a>
                          </td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
              </table>
              </div>
              <div class="panel-footer">
                <div class="row">
              </div>
            </div>
          </div>
        </div>
      </div>

  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title custom_align" id="Heading">ลบใบประกาศนี้</h4>
        </div>
        <div class="modal-body">

          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบใบประกาศนี้?</div>

        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function featuredJob(element){
      var id = $(element).attr("href").replace("#","");
      var button = $(element);
      $.ajax({
        url: '/admin/postings/featured/',
        type: 'POST',
        data: {id: id},
        success: function (result) {
          if(result == "Success"){
            if(button.hasClass('btn-default')){
              button.removeClass('btn-default');
              button.addClass('btn-warning');
            }else if(button.hasClass('btn-warning')){
              button.removeClass('btn-warning');
              button.addClass('btn-default');
            }
            $("#errorbox").removeClass('alert-danger');
            $("#errorbox").addClass('alert-success');
            $("#errorbox").html('<?=$lang['AlertSuccessText']?>');
            $("#errorbox").fadeIn();
            $("#errorbox").delay(3000).fadeOut(300);
          }else{
            $("#errorbox").removeClass('alert-success');
            $("#errorbox").addClass('alert-danger');
            $("#errorbox").html('<?=$lang['AlertErrorText']?>');
            $("#errorbox").fadeIn();
            $("#errorbox").delay(3000).fadeOut(300);
          }
        }
      });
    }

    $('#delete').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('book-id');
      $(e.currentTarget).find('a.btn-success').attr("href","/admin/postings/delete/"+id+"/");
    });
  </script>
