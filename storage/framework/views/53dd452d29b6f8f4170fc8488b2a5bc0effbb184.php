<div class="profile-menu">
    <div class="profile-menu__container">
        <?php foreach($_profilemenu as $_pm): ?>
          <a href="<?php echo e(url($_pm->alias)); ?>" class="<?php echo e(strpos($_pm->alias, $_la) !== false ? 'active' : ''); ?>">
          	<?php echo e($_pm->name); ?><?php echo $_pm->icon && strlen(trim($_pm->icon)) ? '<span class="icon '.$_pm->icon.'"></span>' : ''; ?>

          </a>
        <?php endforeach; ?>
    </div>
</div>
