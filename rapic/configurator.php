<form class="form-plugin" action="<?php $_config = unserialize(File::open(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt')->read()); echo $config->url_current; ?>/update" method="post">
  <input name="token" type="hidden" value="<?php echo Guardian::makeToken(); ?>">
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_rapic_title_ad_code; ?></span>
    <span class="grid span-5">
      <textarea name="ad_code" class="input-block"><?php echo $_config['ad_code']; ?></textarea>
    </span>
  </label>
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_rapic_title_ad_css; ?></span>
    <span class="grid span-5">
      <textarea name="ad_css" class="input-block"><?php echo $_config['ad_css']; ?></textarea>
    </span>
  </label>
  <div class="grid-group">
    <span class="grid span-1"></span>
    <span class="grid span-5"><button class="btn btn-primary btn-update" type="submit"><i class="fa fa-check-circle"></i> <?php echo $speak->update; ?></button></span>
  </div>
</form>