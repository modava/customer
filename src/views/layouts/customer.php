<?php
\modava\customer\assets\CustomerAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<?php echo $content ?>
<?php $this->endContent(); ?>
