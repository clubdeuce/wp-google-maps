<?php
use Clubdeuce\WPGoogleMaps\Map_View;
/**
 * The basic map template
 *
 * @var Map_View $this
 */
$model = $this->_model;
?>
<div id="<?php echo $map_id; ?>" class="google-map" style="height: 400px; width: 100%;"></div>
<script type="application/javascript">
	jQuery(document).ready(function() {
		generate_map(
			"<?php echo esc_js($model->html_id()); ?>",
			<?php echo json_encode($model->make_args()); ?>,
			<?php echo json_encode($this->_make_markers_args()); ?>,
			<?php echo json_encode($this->_make_info_windows()); ?>
		);
	});
</script>
