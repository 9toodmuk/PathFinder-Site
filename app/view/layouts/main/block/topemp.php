<?php
use Config\Database;
$conn = Database::connection();
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-building" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['FeaturedEmployer']?></span>
    </div>
    <div class="actions">
      <a href="job/employer" class="btn">
        <?=$lang['More']?>
      </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row margin-bottom-30">
    <?php
      $sql = "SELECT * FROM company LIMIT 8;";
      $query = $conn->query($sql);
      while($row = $query->fetch_assoc()) {
    ?>
      <div class="col-md-3">
        <div class="card margin-bottom-10">
          <div class="company-img">
            <a href="/job/employer/<?php echo $row["id"] ?>"><img src="/uploads/logo_images/<?php echo $row["logo"] ?>"></a>
          </div>
        </div>
      </div>
      <?php
        }
      ?>
  </div>
</div>
</div>
