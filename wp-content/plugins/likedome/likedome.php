<?php
/*
Plugin Name: Likedome
Plugin URI: http://www.ammob.com
Description: 活动报名,比赛等.
Version: 1.0.1
Author: Mob
Author URI: http://www.ammob.com
*/

### Load WP-Config File If This File Is Called Directly
define( 'LIKEDOME_PLUGINS_ROOT', dirname( __FILE__ ) );
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/classes.php');
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/templatespart.php');

if ( !defined('LIKEDOME_DEFINE_SETTING_NAME') ) :
	
define('LIKEDOME_DEFINE_SETTING_NAME', 'plugin_likedome_define_settings');
define('LIKEDOME_INTEGRATION_SETTING_NAME', 'plugin_likedome_integration_settings');

class Likedome {
	
	var $define_settings;
	var $integration_settings;
	var $sync_login_cookie;
	var $sync_logout_cookie;
	
	function Likedome() {
		__construct();
	}

	function __construct() {
		
		$this->define_settings = get_option(LIKEDOME_DEFINE_SETTING_NAME);
		$this->integration_settings = get_option(LIKEDOME_INTEGRATION_SETTING_NAME);

		if ( !file_exists( dirname( __FILE__ ) . '/config.php' ) && !empty( $this->define_settings ) ) {
			$fp = fopen( dirname( __FILE__ ) . '/config.php', 'w' );
			fwrite( $fp, "<?php\n" );
			foreach ( $this->define_settings as $k => $v ) {
				fwrite( $fp, "define('$k', '$v');\n" );
			}
			fwrite( $fp, "?>\n" );
			fclose( $fp );
		}
		
		// Load dialect
		// add_action( 'init', array( &$this, 'load_dialect' ) );
		// add_action( 'init', array( &$this, 'clear_cookie' ) );
		// Give notice
		// add_action( 'admin_notices', array( &$this, 'notices' ) );
		// Add Admin menu for ucenter integration
		add_action( 'admin_menu', array( &$this, 'add_menu_page' ) );
		// Clean up when deactivate
		// add_action( 'deactivated_plugin', array( &$this, 'deactivated_plugin' ) );
		// Activate
		// add_action( 'activated_plugin', array( &$this, 'activated_plugin' ) );
		// Load css
		// add_action( 'admin_head', array( &$this, 'load_css' ) );
	}


	function add_menu_page() {
		// add admin menu add_menu_page(page_title, menu_title, access_level/capability, file, [function], [icon_url]);
		if (function_exists('add_menu_page')) {
			add_menu_page("比赛管理", "比赛管理", 'administrator', 'likedome-introduction', '', plugins_url('likedome/images/logo.png'));
		}
		// add_submenu_page(parent, page_title, menu_title, access_level/capability, file, [function]);
		if (function_exists('add_submenu_page')) {
			add_submenu_page('likedome-introduction', "功能简介", "功能简介", 'administrator', 'likedome-introduction', array( &$this, 'submenu_introduction' ));
            add_submenu_page('likedome-introduction', "比赛类别", "比赛类别", 'administrator', 'likedome/admin/matchtype.php');
			add_submenu_page('likedome-introduction', "管理比赛", "管理比赛", 'administrator', 'likedome/admin/match.php');
            add_submenu_page('likedome-introduction', "管理队伍", "管理队伍", 'administrator', 'likedome/admin/group.php');
            add_submenu_page('likedome-introduction', "管理选手", "管理选手", 'administrator', 'likedome/admin/member.php');
            add_submenu_page('likedome-introduction', "数据排行", "数据排行", 'administrator', 'likedome/admin/ranklist.php');
            add_submenu_page('likedome-introduction', "数据审核", "数据审核", 'administrator', 'likedome/admin/audit.php');
			// add_options_page('FeedBurner', 'FeedBurner', 8, basename(__FILE__), 'ol_feedburner_options_subpanel');
		}
	}
	
	function submenu_introduction() {
		echo '<div class="wrap">';
		echo '<h2>'. '功能介绍' . '</h2>';
		echo '管理来动网比赛项目.';
		echo '</div>';
	}
	
	function submenu_define_settings() {
		$page_options = 'UC_CONNECT,UC_DBHOST,UC_DBUSER,UC_DBPW,UC_DBNAME,UC_DBCHARSET,UC_DBTABLEPRE,UC_DBCONNECT,UC_KEY,UC_API,UC_CHARSET,UC_IP,UC_APPID,UC_PPP';
		$options = get_option( UCENTER_DEFINE_SETTING_NAME );

		if ( $_POST['page_options'] )
			$post_options = explode( ',', stripslashes( $_POST['page_options'] ) );

		if ( $post_options ) {
			foreach ( $post_options as $post_option ) {
				$post_option = trim( $post_option );
				$value = isset( $_POST[$post_option] ) ? trim( $_POST[$post_option] ) : false;
				$options[$post_option] = $value;
			}
			update_option( UCENTER_DEFINE_SETTING_NAME, $options );
			$fp = fopen( dirname( __FILE__ ) . '/config.php', 'w' );
			fwrite( $fp, "<?php\n" );
			foreach ( $options as $k => $v ) {
				fwrite( $fp, "define('$k', '$v');\n" );
			}
			fwrite( $fp, "?>\n" );
			fclose( $fp );
	?>
	<div class="updated"><p><strong>设置已保存</strong></p></div>
	<?php
		}
		echo '<div class="wrap">';
		echo "<h2>" . __( 'match', 'her' ) . "</h2>";
	?>
	<form name="ucenter-setting" method="post" action="">
		<input type="hidden" name="page_options" value="<?php echo $page_options ?>">

		<table>
		<?php foreach ( explode( ',', stripslashes( $page_options ) ) as $option ):?>
			<tr>
				<td><?php echo $option ?> </td>
				<td><input type="text" name="<?php echo $option ?>" value="<?php echo $options[$option]; ?>" size="50"></td>
			</tr>
		<?php endforeach ?>
	</table>

		<p class="submit">
		<input type="submit" name="Submit" value="<?php _e( 'Update Options', 'ucenter' ) ?>" />
		</p>

	</form>
	</div>
	<?php
	}

	function submenu_integration_settings() {
		$page_options = 'ucenter_password_override,ucenter_credit_name,ucenter_credit_unit,ucenter_credit_per_comment,ucenter_credit_per_post,ucenter_enable_mail_box,ucenter_enable_customize_icon,ucenter_enable_friend,ucenter_enable_credit';
		$options = get_option( UCENTER_INTEGRATION_SETTING_NAME );

		if ( $_POST['page_options'] )
			$post_options = explode( ',', stripslashes( $_POST['page_options'] ) );

		if ( $post_options ) {
			foreach ( $post_options as $post_option ) {
				$post_option = trim( $post_option );
				$value = isset( $_POST[$post_option] ) ? trim( $_POST[$post_option] ) : false;
				$options[$post_option] = $value;
			}
			update_option( UCENTER_INTEGRATION_SETTING_NAME, $options );
	?>
	<div class="updated"><p><strong><?php _e( 'Options saved.', 'ucenter' ); ?></strong></p></div>
	<?php
		}
		echo '<div class="wrap">';
		echo "<h2>" . __( 'Ucenter Integration Settings', 'ucenter' ) . "</h2>";
	?>
	<form name="ucenter-setting" method="post" action="">
		<input type="hidden" name="page_options" value="<?php echo $page_options ?>">

		<table>
			<tr>
				<td width='150px'><?php _e( 'Password Override', 'ucenter' ) ?></td>
				<td><input type="checkbox" name="ucenter_password_override" value="1" <?php checked( '1', $options['ucenter_password_override'] ); ?> /></td>
			</tr>
			<tr><td></td><td><?php _e( '<strong>RECOMMENDATION: Enable This Option.</strong> If enable this option, user\'s password in ucenter will override that in wordpress when encounter pair(user, password) confliction between ucenter and wordpress. If disable this option, confliction will make login fail.<strong><br >WARNINGS: OPERATION WHEN YOU CLEARLY UNDERSTAND ITS MEANING!</strong>', 'ucenter' ) ?></td></tr>

			<tr>
				<td><?php _e( 'Credit Name', 'ucenter' ) ?></td>
				<td><input type="text" name="ucenter_credit_name" value="<?php echo $options['ucenter_credit_name']; ?>"/></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Credit Unit', 'ucenter' ) ?></td>
				<td><input type="text" name="ucenter_credit_unit" value="<?php echo $options['ucenter_credit_unit']; ?>"/></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Credit Per Comment', 'ucenter' ) ?></td>
				<td><input type="text" name="ucenter_credit_per_comment" value="<?php echo $options['ucenter_credit_per_comment']; ?>"/></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Enable Mail Box', 'ucenter' ) ?></td>
				<td><input type="checkbox" name="ucenter_enable_mail_box" value="1" <?php checked( '1', $options['ucenter_enable_mail_box'] ); ?> /></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Enable Customize Icon', 'ucenter' ) ?></td>
				<td><input type="checkbox" name="ucenter_enable_customize_icon" value="1" <?php checked( '1', $options['ucenter_enable_customize_icon'] ); ?> /></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Enable Friend', 'ucenter' ) ?></td>
				<td><input type="checkbox" name="ucenter_enable_friend" value="1" <?php checked( '1', $options['ucenter_enable_friend'] ); ?> /></td>
			</tr>
			<tr><td></td><td></td></tr>

			<tr>
				<td><?php _e( 'Enable Credit', 'ucenter' ) ?></td>
				<td><input type="checkbox" name="ucenter_enable_credit" value="1" <?php checked( '1', $options['ucenter_enable_credit'] ); ?> /></td>
			</tr>
			<tr><td></td><td></td></tr>

		</table>

		<p class="submit">
		<input type="submit" name="Submit" value="<?php _e( 'Update Options', 'ucenter' ) ?>" />
		</p>

	</form>
	</div>
	<?php
	}
}
$likedomeClass = new Likedome;
endif;
?>
