<?php	
			//Recent Uploads Get Link 
			//$wp2ytUserAccount = ($_GET['wp2ytUserAccount']) 
			$account = $_GET['account'];	
			
			$url = "http://gdata.youtube.com/feeds/api/users/" . $account . "/uploads?v=2&alt=json";

			$data = json_decode(@file_get_contents($url),true);

			$info = $data["feed"];

			$video = $info["entry"];

			$nVideo = count($video);
					
?>				
			
			<script>
			jQuery(document).ready(function() {	
				jQuery('.wp2yt-video-thumbnail').mouseenter(function() {
					jQuery(this).stop().fadeTo(375,.5);
					jQuery(this).prev().fadeIn();
					jQuery(this).mouseleave(function() {
						jQuery(this).stop().fadeTo(375,1);
						jQuery(this).prev().fadeOut();
					});
					
				});
			});	
			</script>
			<div class="title_and_video_count_div"> 
			<?php
					echo "<h4>Recent ".$info["title"]['$t'].'</h4>';
					echo "<b><i>Number of Videos: ".$nVideo."</i></b>";
			?>
				</div>	

			<div class="scrollable-content">
			
			<?php for($i=0;$i<25;$i++){ ?>
			
			<?php if($nVideo == '0') : ?>
				<div class="no_videos_error" style="width:714px; padding-bottom:15px;">
					<h3 style="color:red;"><img alt='' style="margin-right:10px; margin-bottom:0px; border:none; height:14px;" src="<?php echo plugins_url( '/wp2yt-uploader/includes/images/red-x.png' );?>"> OH NO! <img alt='' style="margin-left:10px; margin-bottom:0px; border:none; height:14px;" src="<?php echo plugins_url( '/wp2yt-uploader/includes/images/red-x.png' );?>"></h3>
						<p><i>It appears that there is currently no content on <?php echo '<b>'.$account.'</b>'; ?>'s YouTube channel. If you are sure there are videos, double  
						check that you have entered the account name properly. </i></p>
						<br/>
						<br/>
						<li style="padding-left:15px; font-size:11px;"><i><b style="color:green;">Tip:</b> If the account name was mistyped you will receive this error.</i></li>
						</div>	
					<?php break; ?> <!-- break loop -->
				</div>
				
			<!-- if loop returns no video title break loop -->
			<?php elseif(@$video[$i]['title']['$t'] == '') : ?>
					<?php break; ?> <!-- break loop -->	
			
			<!-- if title is found -->	
			<?php elseif($video[$i]['title']['$t'] !== '') : ?>		
			
			
			<div id="videos" style="display:inline; float:left; padding:1em;">
			
				<!-- add if statement -->
				
				<div class="titlebox">

				<?php
					//Print Video Title
					echo "<a class='wp2yt-title-link' href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'>".$video[$i]['title']['$t']; ?>
				   </div>

				<div class="imagebox"><!-- start imagebox div -->
					<?php echo "<a href='http://www.youtube.com/watch?feature=player_embedded&v=".$video[$i]['media$group']['yt$videoid']['$t']."' target='_blank'><span class='wp2yt-preview-image-overlay'><span style='font-size:4em;' class='wp2yt-icon-play'><i> </i></span></span><img class='wp2yt-video-thumbnail' alt='' src='".$video[$i]['media$group']['media$thumbnail'][1]['url']."' /></a><br />"; ?>

					<!-- add a preview button -->
					<div class="wp-2-yt-buttons">
						<a class="button-primary preview-yt-video-btn" target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>"><span class="wp2yt-icon-play"><i> </i></span></a>						
						<button class="btn btn-small btn-success insert-video-to-post-btn"><span class="icon-forward"><i> </i></span>Insert to Post</button>
						<button class="btn btn-small btn-danger wp2yt-delete-video-btn" onclick="wp2yt_delete_video.call(this)"><span class="icon-remove"><i> </i></span></button>
					</div>

					</div><!--end imagebox --> 
					
					<div class="statsBox"><!--start statsBox -->
							
						<div class="viewBox"><?php if (@$video[$i]['yt$statistics']["viewCount"] == 0) { echo '<p>Total Views: 0</p>'; } else { echo "<p>Total Views:".@$video[$i]['yt$statistics']["viewCount"].'</p><br/>'; } ?> </div> <!-- end viewBox -->
						<div class="likeBox"><?php if (@$video[$i]['yt$rating']["numLikes"] == 0) { echo '<p>Total Likes: 0</p>'; } else { echo "<p>Total Likes:".@$video[$i]['yt$rating']["numLikes"].'</p><br/>'; } ?> </div> 	<!-- end likeBox -->

					</div><!-- end statsBox -->

					<div id="descriptionDiv" style="padding-top:.3em; width:500px;overflow:hidden; max-height:155px; min-height:145px;"> 

					<?php

					// add description

					echo "<p><b>Description:</b> ".$video[$i]['media$group']['media$description']['$t'].'<br/></p>';

					?> </div> <!-- end descriptionDIV --> 

					<div id="embedLinkDiv" style="width:500px; padding-top:.5em;">
					<input name="uniqueVideoID" type="hidden" value="<?php echo $video[$i]['media$group']['yt$videoid']['$t']; ?>">
						<?php echo  htmlentities('[iframe]<iframe width="640" height="480" src="http://www.youtube.com/embed/') . $video[$i]['media$group']['yt$videoid']['$t'] . htmlentities('" frameborder="0" allowfullscreen="1"></iframe>[/iframe]'); ?>
					
					</div> <!-- end enbedDiv div -->				
					
			</div> <!-- end videos div -->
		<?php endif; ?>
						<?php

						}
								
?>