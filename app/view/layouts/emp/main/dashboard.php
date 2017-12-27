<div class="row">

  <div class="col-md-9">
    <?php include_once 'app/view/layouts/emp/main/block/empdetail.php'; ?>
    <?php include_once 'app/view/layouts/emp/main/block/lastpostings.php'; ?>
    <?php include_once 'app/view/layouts/emp/main/block/lastapp.php'; ?>
  </div>

    <div class="col-md-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">0</div>
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

    <div class="col-md-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-envelope-open fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">0</div>
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

</div>
