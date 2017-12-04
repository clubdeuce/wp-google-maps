<?php
use Clubdeuce\WPGoogleMaps\Map_View;
/**
 * The basic map template
 *
 * @var Map_View $this
 */
$model = $this->_model;
?>
<div id="<?php echo $model->html_id(); ?>" class="wp-google-map"></div>
<script type="application/javascript">
	jQuery(document).ready(function() {
		generate_map(
			"<?php echo esc_js($model->html_id()); ?>",
			<?php $this->the_map_params(); ?>,
			<?php echo json_encode($this->_make_markers_args()); ?>,
			<?php echo json_encode($this->_make_info_windows()); ?>
		);
	});
</script>
