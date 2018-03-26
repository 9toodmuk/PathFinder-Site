<?php
use App\Controller\User\Profile;
$user = Profile::profileLoad($variables[2]);
$user = mysqli_fetch_array($user);
?>

<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row panel">
		<div class="col-md-4 bg_blur">
			<?php if($variables[2] != $_SESSION['social_id']){
				$friendship = Profile::getFriendship($_SESSION['social_id'], $variables[2]);
				switch ($friendship){
					case 0:
						echo '<a style="cursor: pointer;" onclick="addfriend(this)" class="follow_btn hidden-xs" id="'.$variables[2].'">'.$lang['addfriend'].'</a>';
						break;
					case 1:
						echo '<a style="cursor: pointer;" class="follow_btn hidden-xs">'.$lang['requestsent'].'</a>';
						break;
					case 2:
						echo '<a style="cursor: pointer;" onclick="addfriend(this)" class="follow_btn hidden-xs" id="'.$variables[2].'">'.$lang['acceptrequest'].'</a>';
						break;
					case 3:
						echo '<a style="cursor: pointer;" class="follow_btn hidden-xs">'.$lang['friend'].'</a>';
						break;
				}

			}else{
				echo '<a href="/user/edit/" class="follow_btn hidden-xs">'.$lang['EditProfile'].'</a>';
			}
			?>
		</div>
    <div class="col-md-8 col-xs-12">
			<div class="picture">
				<?php if($variables[2] == $_SESSION['social_id']){ ?>
					<div class="editpicbtn" style="position:absolute; margin-top: 112px; margin-left: 85px; padding: 4px; background-color: rgba(0,0,0,0.6);">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff;"><i class="fa fa-pencil"></i> <span><?=$lang['EditBtn']?></span></a>
						  <ul class="dropdown-menu" role="menu" style="position:absolute; z-index: 999;">
						    <li>
									<a href="#" onclick="uploadProfilePic()"><?=$lang['UpdatePhoto']?></a>
								</li>
								<li>
									<a href="#" onclick="removeProfilePic()"><?=$lang['Remove']?></a>
								</li>
						  </ul>
					</div>
				<?php } ?>
				<img src="/uploads/profile_image/<?=$user['profile_image']?>" id="headerprofilepic" class="img-thumbnail" alt="">
			</div>
	    <div class="header">
	    	<h1><?=$user['first_name']?> <?=$user['last_name']?></h1>
				<?php if($variables[2] != $_SESSION['social_id']){
					echo '<a href="#" class="btn btn-info">Message</a>';
				}
				?>
	    </div>
    </div>
    </div>

	<div class="row nav">
		<div class="col-md-4">

		</div>
        <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px;">
            <a class="col-md-4 col-xs-4 well" href="/user/<?=$variables[2]?>/"><?=$lang['Timeline']?></a>
						<a class="col-md-4 col-xs-4 well" href="/user/<?=$variables[2]?>/about"><?=$lang['About']?></a>
						<a class="col-md-4 col-xs-4 well" href="/user/<?=$variables[2]?>/friend"><?=$lang['friend']?></a>
        </div>
    </div>
</div>