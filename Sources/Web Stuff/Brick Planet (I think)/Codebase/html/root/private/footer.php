<?php

	if ($DisplayAds == true) {

		echo '
		<div class="advert-container-footer">
			<!-- Responsive -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-5035877450680880"
				 data-ad-slot="8645193052"
				 data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
		';

	}

	echo '
					</div>
					</div>
				</div>
			</div>
			<div class="site-footer">
				<div class="grid-x grid-margin-x">
					';
					
					if (!$AUTH && $_SERVER['SCRIPT_NAME'] != '/index.php' || $AUTH) {
					
						if ($_SERVER['SCRIPT_NAME'] != '/store/new/index.php') {
							
							echo '
							<div class="sidebar-shrink shrink cell no-margin">
								&nbsp;
							</div>
							';
							
						}
					
					}
					
					echo '
					<div class="auto cell no-margin">
						<div class="grid-container">
							<div class="grid-x grid-margin-x">
								<div class="large-2 large-offset-1 medium-3 medium-offset-0 small-4 small-offset-1 cell">
									<div class="footer-title">NAVIGATE</div>
									<ul class="footer-links">
										<li><a href="'.$serverName.'">Home</a></li>
										<li><a href="'.$serverName.'/store/">Store</a></li>
										<li><a href="'.$serverName.'/forum/">Forum</a></li>
										<li><a href="'.$serverName.'/upgrade/">Upgrade</a></li>
									</ul>
								</div>
								<div class="large-2 large-offset-1 medium-3 medium-offset-0 small-4 small-offset-2 cell">
									<div class="footer-title">ABOUT</div>
									<ul class="footer-links">
										<li><a href="'.$serverName.'/about/terms-of-service/">Terms of Service</a></li>
										<li><a href="'.$serverName.'/about/privacy-policy/">Privacy Policy</a></li>
										<li><a href="https://jobs.brickcreate.com/about-us/">About Us</a></li>
										<li><a href="https://blog.brickcreate.com" target="_blank">Blog</a></li>
									</ul>
								</div>
								<div class="large-2 large-offset-1 medium-3 medium-offset-0 small-4 small-offset-1 cell">
									<div class="footer-title">SUPPORT</div>
									<ul class="footer-links">
										<li><a href="https://helpme.brickcreate.com/hc/en-us/articles/115000015368">Contact Us</a></li>
										<li><a href="https://helpme.brickcreate.com/hc/en-us" target="_blank">Help Center</a></li>
										<li><a href="#">Legal</a></li>
										<li><a href="https://jobs.brickcreate.com/">Careers</a></li>
									</ul>
								</div>
								<div class="large-2 large-offset-1 medium-3 medium-offset-0 small-4 small-offset-2 cell">
									<div class="footer-title">SOCIAL MEDIA</div>
									<ul class="footer-links social-media">
										<li><a href="https://www.facebook.com/Brick CreateGame" target="_blank"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
										<li><a href="https://www.twitter.com/Brick CreateGame" target="_blank"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
										<li><a href="https://www.twitch.tv/GameBrick Create" target="_blank"><i class="fa fa-twitch"></i><span>Twitch</span></a></li>
										<li><a href="https://www.youtube.com/channel/UCRmWPKzFQmz-I1MxTssqM2g" target="_blank"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>
									</ul>
								</div>
							</div>
							<div class="footer-divider"></div>
							<div class="footer-text">&copy; Copyright '.date('Y').' Brick Create Inc. All rights reserved.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="'.$serverName.'/assets/js/vendor/foundation.js"></script>
		<script src="'.$serverName.'/assets/js/'.$JSFile.'"></script>
	</body>
</html>
';