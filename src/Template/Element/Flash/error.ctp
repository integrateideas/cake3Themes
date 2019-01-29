<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-danger alert-dismissable" onclick="this.classList.add('hidden');">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<?= $message ?>
</div>
