<?php
use Controller\Utils\Address;
if($language == "en"){
  $province = Address::getAllProvince(false);
}else{
  $province = Address::getAllProvince();
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#categories,#location,#type,#level,#educationlevel').multiselect({
      includeSelectAllOption: true,
      maxHeight: 150,
      buttonWidth: '100%',
      numberDisplayed: 2,
      buttonContainer: '<div></div>',
      buttonClass: 'form-control text-left',
      nSelectedText: '<?=$lang["SearchSelected"]?>',
      nonSelectedText: '<?=$lang["SearchPleaseSelect"]?>',
      allSelectedText: '<?=$lang["SearchAll"]?>',
      selectAllText: '<?=$lang["SearchAll"]?>'
    });;
    $('#categories,#location,#type').multiselect('updateButtonText');

    $(".multiselect .caret").css('float', 'right');
    $(".multiselect .caret").css('margin-top', '8px');
  });

</script>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-search" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang["SearchTitle"]?></span>
    </div>
  </div>
  <div class="portlet-body">
    <form id="advancesearch-form" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon search-panel"><span id="search_concept"><i class="fa fa-search" aria-hidden="true"></i></span></div>
          <input type="text" class="form-control" name="term" placeholder="<?=$lang["SearchTerm"]?>">
        </div>
      </div>
      <div class="form-group">
        <label for="categories" class="control-label"><?=$lang["SearchType"]?></label>
        <select id="categories" name="categories[]" multiple="multiple" class="form-control">
            <?php
              $conn = Config\Database::connection();
              $sql = "SELECT * FROM job_categories WHERE parent_id IS NULL;";
              $query = $conn->query($sql);
              while($row = $query->fetch_assoc()) {
                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
              }
            ?>
          </select>
      </div>
      <div class="form-group">
        <label for="location" class="control-label"><?=$lang["SearchLocation"]?></label>
        <select id="location" name="location[]" multiple="multiple" class="form-control">
          <?php
            while ($row = mysqli_fetch_assoc($province)) {
              echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="type" class="control-label"><?=$lang["SearchJobEmploymentType"]?></label>
        <select id="type" name="type[]" multiple="multiple" class="form-control">
          <option value="full"><?=$lang["fulltime"]?></option>
          <option value="part"><?=$lang["parttime"]?></option>
          <option value="permanent"><?=$lang["permanent"]?></option>
          <option value="temporary"><?=$lang["temp"]?></option>
          <option value="contract"><?=$lang["contractjob"]?></option>
          <option value="internship"><?=$lang["internshipjob"]?></option>
          <option value="freelance"><?=$lang["freelance"]?></option>
        </select>
      </div>
      <p class="text-center"><button type="submit" class="btn btn-success btn-block" role="button"><i class="fa fa-search" aria-hidden="true"></i></button></p>
    </form>
  </div>
</div>

<script type="text/javascript">
  $('form#advancesearch-form').submit(function(event) {
    event.preventDefault();
    var query = this.term.value;
    var category = [];
    var location = [];
    var type = [];

    $('select#categories option').each(function(index, el) {
      if($(this).is(':selected')){
        category.push(el.value);
      }
    });

    $('select#location option').each(function(index, el) {
      if($(this).is(':selected')){
        location.push(el.value);
      }
    });

    $('select#type option').each(function(index, el) {
      if($(this).is(':selected')){
        type.push(el.value);
      }
    });

    var url = "/search/advance/";
    var firstkeyword = true;

    if(query != ''){
      if(firstkeyword){
        url = url + "?";
        firstkeyword = false;
      }else{
        url = url + "&";
      }
      url = url + "keyword=" + query;
    }

    if(category != ''){
      if(firstkeyword){
        url = url + "?";
        firstkeyword = false;
      }else{
        url = url + "&";
      }
      url = url + "category=" + category;
    }

    if(location != ''){
      if(firstkeyword){
        url = url + "?";
        firstkeyword = false;
      }else{
        url = url + "&";
      }
      url = url + "location=" + location;
    }

    if(type != ''){
      if(firstkeyword){
        url = url + "?";
        firstkeyword = false;
      }else{
        url = url + "&";
      }
      url = url + "type=" + type;
    }

    window.location.href = url;
  });
</script>
