<?php
use Config\Database;
$conn = Database::connection();
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-tag" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['FeaturedCategories']?></span>
    </div>
    <div class="actions">
      <a href="/job/categories/" class="btn">
        <?=$lang['More']?>
      </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row text-center margin-bottom-30">
    <?php
      $sql = "SELECT * FROM job_categories WHERE parent_id IS NULL ORDER BY RAND() LIMIT 6;";
      $query = $conn->query($sql);
      $i = 1;
      while($row = $query->fetch_assoc()) {
        if($i != 1){
          if($i%2 != 0){
            echo '</div>';
            echo '<div class="row text-center margin-bottom-30">';
          }
        }
    ?>
      <div class="col-md-6">
        <a class="btn btn-sq-lg btn-cat" href="/job/categories/<?php echo $row["id"] ?>/">
          <span class="position"></span>
          <span class="icon"><i class="<?php echo $row["icon"] ?> fa-4x" aria-hidden="true"></i></span>
          <span class="title"><?php echo $row["name"] ?></span>
        </a>
      </div>
    <?php
        $i = $i+1;
      }
    ?>
    </div>
  </div>
</div>
