<form class="form-plugin" action="<?php $rapic_config = File::open(PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS . 'config.txt')->unserialize(); echo $config->url_current; ?>/update" method="post">
  <?php echo Form::hidden('token', $token); ?>
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_rapic_title_ad_code; ?></span>
    <span class="grid span-5"><?php echo Form::textarea('ad_code', $rapic_config['ad_code'], null, array('class' => array('textarea-block', 'textarea-expand', 'code'))); ?></span>
  </label>
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_rapic_title_ad_css; ?></span>
    <span class="grid span-5"><?php echo Form::textarea('ad_css', $rapic_config['ad_css'], null, array('class' => array('textarea-block', 'textarea-expand', 'code'))); ?></span>
  </label>
  <div class="grid-group">
    <span class="grid span-1"></span>
    <span class="grid span-5"><?php echo Jot::button('action', $speak->update); ?></span>
  </div>
</form>