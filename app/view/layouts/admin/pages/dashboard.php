<?php
use Controller\Admin\Postings;
use Controller\Admin\Applications;
use Controller\Admin\Users;
use Controller\Admin\Employer;
use Controller\Utils\Utils;
?>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-building fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo Employer::employerCount(); ?></div>
                        <div><?=$lang['Employers']?></div>
                    </div>
                </div>
            </div>
            <a href="/admin/employer/">
                <div class="panel-footer">
                    <span class="pull-left"><?=$lang['Details']?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo Postings::postingsCount(); ?></div>
                        <div><?=$lang['Postings']?></div>
                    </div>
                </div>
            </div>
            <a href="/admin/postings/">
                <div class="panel-footer">
                    <span class="pull-left"><?=$lang['Details']?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-envelope-open fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo Applications::applicationCount(); ?></div>
                        <div><?=$lang['Applications']?></div>
                    </div>
                </div>
            </div>
            <a href="/admin/applications/">
                <div class="panel-footer">
                    <span class="pull-left"><?=$lang['Details']?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo Users::usersCount(); ?></div>
                        <div><?=$lang['Users']?></div>
                    </div>
                </div>
            </div>
            <a href="/admin/users/">
                <div class="panel-footer">
                    <span class="pull-left"><?=$lang['Details']?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> <?=$lang['Last Postings']?>
            </div>
            <div class="panel-body">
              <table class="table">
                <thead>
                  <tr>
                    <th><?=$lang['Title']?></th>
                    <th><?=$lang['Employer']?></th>
                    <th><?=$lang['Posted Date']?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $lastpostings = Postings::getLastPostings();
                    while ($row = $lastpostings->fetch_array()){
                  ?>
                  <tr>
                    <td><?=$row['name']?></td>
                    <td><?=Employer::getEmployerName($row['company_id']);?></td>
                    <td><?=$row['created_at']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> <?=$lang['Last Applications']?>
            </div>
            <div class="panel-body">
              <table class="table">
                <thead>
                  <tr>
                    <th><?=$lang['Username']?></th>
                    <th><?=$lang['Position']?></th>
                    <th><?=$lang['Status']?></th>
                    <th><?=$lang['Apply Date']?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = Applications::loadLastApplication();
                    while($row = $query->fetch_assoc()){
                  ?>
                  <tr>
                    <td>[<?php echo $row["user_id"] ?>] <?php echo Users::getUserName($row["user_id"]) ?></td>
                    <td>[<?php echo $row["job_id"] ?>] <?php echo Postings::getPostingName($row["job_id"]) ?></td>
                    <td><?php echo $row["status"] ?></td>
                    <td><?php echo $row["created_at"] ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
      <div class="panel panel-default">
          <div class="panel-heading">
              <i class="fa fa-bell fa-fw"></i> Notifications Panel
          </div>
          <div class="panel-body">
              <div class="list-group">
                  <a href="#" class="list-group-item">
                      <i class="fa fa-tasks fa-fw"></i> ตำแหน่งงานล่าสุด
                      <span class="pull-right text-muted small"><em><?=Utils::time_elapsed_string(Postings::getLastestPostingsDate());?></em>
                      </span>
                  </a>
                  <a href="#" class="list-group-item">
                      <i class="fa fa-envelope-open fa-fw"></i> ใบสมัครงานล่าสุด
                      <span class="pull-right text-muted small"><em>12 minutes ago</em>
                      </span>
                  </a>
                  <a href="#" class="list-group-item">
                      <i class="fa fa-user fa-fw"></i> สมัครสมาชิกล่าสุด
                      <span class="pull-right text-muted small"><em>27 minutes ago</em>
                      </span>
                  </a>
              </div>
          </div>
      </div>
    </div>
</div>
