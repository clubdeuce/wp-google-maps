<?php
/**
 * The basic map template
 *
 * @var string $map_id
 * @var array  $map_params
 * @var array  $markers
 * @var array  $info_windows
 */
?>
<div id="<?php echo $map_id; ?>" class="google-map" style="height: 400px; width: 100%;"></div>
<script type="application/javascript">
	jQuery(document).ready(function() {
		generate_map(
			"<?php echo esc_js($map_id); ?>",
			<?php echo json_encode($map_params); ?>,
			<?php echo json_encode($markers); ?>,
			<?php echo json_encode($info_windows); ?>
		);
	});
</script>
