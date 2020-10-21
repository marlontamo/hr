<script>
	const warnafter = "<?php echo get_system_config('other_settings', 'warnafter') ?>";
	const redirafter = "<?php echo get_system_config('other_settings', 'redirafter') ?>";
	const base_url = '<?php echo base_url($lang) ?>/';
	const root_url = '<?php echo base_url() ?>';
	const mobileapp = true;
	<?php if( isset( $user ) ) : ?>
		const user_id = <?php echo $user['user_id'].';'; 
		unset($user['user_id']);
		foreach( $user as $var => $value ):?>
			const user_<?php echo $var?> = '<?php echo $value?>';
		<?php endforeach;
	endif;?>
</script>

<script src="<?php echo theme_path() ?>language/<?php echo $user_language ?>/common_lang.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.min.js"></script>


