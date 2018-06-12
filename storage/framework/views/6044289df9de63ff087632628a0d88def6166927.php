<div class="profile-menu">
    <div class="profile-menu__container">
        <?php foreach($_profilemenu as $_pm): ?>
          <a href="<?php echo e(url($_pm->alias)); ?>" class="<?php echo e(strpos($_pm->alias, $_la) !== false ? 'active' : ''); ?>"><?php echo e($_pm->name); ?></a>
        <?php endforeach; ?>
    </div>
</div>
