<?php
use Controller\User\Profile;
use Controller\Timeline\Notification;

$notifications = Notification::getByRecipient($_SESSION['social_id']);
$currentuser = Profile::profileLoad($_SESSION['social_id']);
$currentuser = mysqli_fetch_array($currentuser);
?>

<nav class="navbar navbar-findcond navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
      <a class="navbar-brand banner" href="/"><img src="/themes/images/logos/IconColor.png" height="50px"/></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell-o"></i>
            <span id="notinums" class="label label-danger"></span>
          </a>
          <ul class="dropdown-menu" id="notification" role="menu">
            <ul>

            </ul>
            <li class="divider"></li>
            <li><a href="#" class="text-center">View All</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$currentuser['first_name']?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/user/<?=$_SESSION['social_id']?>"><?=$lang['MyAccount']?></a></li>
            <!-- <li><a href="/user/messages/"><?=$lang['MyMessages']?></a></li> -->
            <?php
              if($currentuser['user_group'] == '3'){
            ?>
            <li class="divider"></li>
            <li><a href="/admin/"><?=$lang['GotoAdminPage']?></a></li>
            <?php } ?>
            <li class="divider"></li>
            <li><a href="/user/settings/"><?=$lang['Settings']?></a></li>
            <li><a href="/home/logout/"><?=$lang['LogOut']?></a></li>
          </ul>
        </li>
      </ul>

			<form id="topsearch" class="navbar-form search-form" role="search">
        <div class="input-group">
          <input type="text" class="form-control" name="query" placeholder="<?=$lang["SearchTerm"]?>">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><span id="search_concept"><i class="fa fa-search" aria-hidden="true"></i></span></button>
          </span>
        </div>
			</form>
    </div>
  </div>
</nav>

<script type="text/javascript">
    $('form#topsearch').submit(function(event) {
      event.preventDefault();
      var query = $('input[name="query"]').val();
      window.location.href = "/search/term/"+query;
    });
</script>
