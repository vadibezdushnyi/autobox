<!-- Page header -->
<header class="page-header">
	<div class="page-wrapper">
		<div class="page-container">
			<a href="<?php echo e(url('/')); ?>" class="logo"><img src="<?php echo e(url('/public/img/content/logo.png')); ?>" alt="Autobox"></a>

			<div class="top-panel">
				<a href="tel: <?php echo e($_socials->phone_number); ?>" class="tel icon icon-telephone2"><?php echo e($_socials->phone_number); ?></a>
				<a href="" class="mail-link icon icon-mail js_modal-open" data-modal-type="email-feedback" data-modal-part="1"></a>
				<div class="login-links">
					<?php if(SIGNEDIN): ?>
						<a href="<?php echo e(url('/cart')); ?>" class="cart-link icon icon-cart" id="header-cart"><span class="amount"><?php echo e($_cart->qty); ?></span><span class="price"><?php echo e($_cart->total); ?>&euro;</span></a>
					<?php else: ?>
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2"><?php echo e($_header->text_1); ?></a>
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1"><?php echo e($_header->text_2); ?></a>
					<?php endif; ?>
				</div>
				<?php if(isset($_languages)): ?>
					<div class="languages">
						<a href="javascript:void(0)" class="language icon icon-arrow-down4">
							<img src="<?php echo e(url('/public/img/icons-general/flags/'.$_language->icon)); ?>" alt="en"><?php echo e($_language->title); ?>

						</a>
						<ul class="languages__list">
							<?php foreach($_languages as $k => $_l): ?>
								<li onclick="__.set_locale(event, '<?php echo e($k); ?>')">
									<a href="javascript:void(0)">
										<img src="<?php echo e(url('/public/img/icons-general/flags/'.$_l->icon)); ?>" alt="en"><?php echo e($_l->title); ?>

									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				
				<div class="header-search">
					<button type="button" class="btn-search-mobile icon icon-search js_header-search-mobile"></button>
					<form method="get" action="<?php echo e(url('/products/')); ?>">
						<button type="submit" class="btn-search icon icon-search js_header-search-submit"></button>
						<label>
								<input type="text" placeholder="Partcode" name="q" class="input-search">
						</label>
						<button type="button" class="btn-close icon icon-cross2 js_header-search-close"></button>
					</form>
				</div>

				<div class="btn-burger js_menu-btn">
					<span></span>
				</div>
			</div>
			<?php if(SIGNEDIN): ?>
				<a href="<?php echo e(url('/logout')); ?>" class="btn-logout icon icon-logout"></a>
			<?php endif; ?>
			<div class="header-menu">
				<nav>
					<ul>
					<?php foreach($_headmenuall as $menu): ?>
						<?php if(!SIGNEDIN && !$menu->signedin_only || SIGNEDIN): ?>
						<li class="<?php echo e(!empty($menu->submenu) ? 'has-submenu' : ''); ?>">
							<a href="<?php echo e(!strlen($menu->alias) ? 'javascript:void(0)' : url($menu->alias)); ?>"><?php echo e($menu->name); ?></a>
							<?php if(!empty($menu->submenu)): ?>
							<span class="plus"></span>
							<div class="submenu">
								<div class="page-wrapper">
									<ul>
										<?php foreach($menu->submenu as $submenu): ?>
											<?php if(!SIGNEDIN && !$submenu->signedin_only || SIGNEDIN): ?>
											<li>
												<a href="<?php echo e(!strlen($submenu->alias) ? 'javascript:void(0)' : url($submenu->alias)); ?>"><?php echo e($submenu->name); ?></a>
											</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<?php endif; ?>
						</li>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if(SIGNEDIN): ?>
						<?php foreach($_headmenusin as $index => $menu): ?>
						<li class="logged-link <?php echo e(!$index ? 'logged-link--first' : ''); ?> <?php echo e(!empty($menu->submenu) ? 'has-submenu' : ''); ?>">
							<a href="<?php echo e(!strlen($menu->alias) ? 'javascript:void(0)' : url($menu->alias)); ?>"><?php echo e($menu->name); ?></a>
							<?php if(!empty($menu->submenu)): ?>
							<span class="plus"></span>
							<div class="submenu">
								<div class="page-wrapper">
									<ul>
										<?php foreach($menu->submenu as $submenu): ?>
										<li>
											<a href="<?php echo e(!strlen($submenu->alias) ? 'javascript:void(0)' : url($submenu->alias)); ?>"><?php echo e($submenu->name); ?></a>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					<?php endif; ?>
					</ul>
				</nav>

				<div class="mobile-header-bottom">
					<a href="tel: <?php echo e($_socials->phone_number); ?>" class="tel icon icon-telephone2"><?php echo e($_socials->phone_number); ?></a>
					<a href="" class="mail-link icon icon-mail js_modal-open" data-modal-type="email-feedback" data-modal-part="1"></a>
					<div class="login-links">
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2"><?php echo e($_header->text_1); ?></a>
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1"><?php echo e($_header->text_2); ?></a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</header>
<!-- End of Page header -->
