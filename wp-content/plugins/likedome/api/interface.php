<?php
	### pre_common_member_verify
	### e.g. wp-content/plugins/likedome/likedome.php?opt=['methodname']&type=1&flag=1
	rcpInterface();
	function rcpInterface() {
		global $wpdb, $user_identity, $user_ID;
		if(!empty($_REQUEST['opt'])) {
			header('Content-Type: text/html; charset='.get_option('blog_charset').'');
			switch($_REQUEST['opt']) {
				case 'competition':
					if(!empty($user_identity)) {
						$pollip_user = htmlspecialchars(addslashes($user_identity));
					} elseif(!empty($_COOKIE['comment_author_'.COOKIEHASH])) {
						$pollip_user = htmlspecialchars(addslashes($_COOKIE['comment_author_'.COOKIEHASH]));
					} else {
						$pollip_user = __('Guest', 'wp-polls');
						// TODO 
						echo "<html><head></head><body>需要登陆才可以报名.</body></html>";
						exit;
					}
					$pollip_userid = intval($user_ID);
					
					
					break;
				default:
					echo "string2";exit;
					$poll_id = $temp_poll_id;
			}
		}
	}
	?>