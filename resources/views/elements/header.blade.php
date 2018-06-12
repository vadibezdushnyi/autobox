<!-- Page header -->
<header class="page-header">
	<div class="page-wrapper">
		<div class="page-container">
			<a href="{{ url('/') }}" class="logo"><img src="{{ url('/public/img/content/logo.png') }}" alt="Autobox"></a>

			<div class="top-panel">
				<a href="tel: {{ $_socials->phone_number }}" class="tel icon icon-telephone2">{{ $_socials->phone_number }}</a>
				<a href="" class="mail-link icon icon-mail js_modal-open" data-modal-type="email-feedback" data-modal-part="1"></a>
				<div class="login-links">
					@if(SIGNEDIN)
						<a href="{{ url('/cart') }}" class="cart-link icon icon-cart" id="header-cart"><span class="amount">{{ $_cart->qty }}</span><span class="price">{{ $_cart->total }}&euro;</span></a>
					@else
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2">{{ $_header->text_1 }}</a>
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1">{{ $_header->text_2 }}</a>
					@endif
				</div>
				@if(isset($_languages))
					<div class="languages">
						<a href="javascript:void(0)" class="language icon icon-arrow-down4">
							<img src="{{ url('/public/img/icons-general/flags/'.$_language->icon) }}" alt="en">{{ $_language->title }}
						</a>
						<ul class="languages__list">
							@foreach ($_languages as $k => $_l)
								<li onclick="__.set_locale(event, '{{ $k }}')">
									<a href="javascript:void(0)">
										<img src="{{ url('/public/img/icons-general/flags/'.$_l->icon) }}" alt="en">{{ $_l->title }}
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				@endif
				
				<div class="header-search">
					<button type="button" class="btn-search-mobile icon icon-search js_header-search-mobile"></button>
					<form method="get" action="{{ url('/products/') }}">
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
			@if(SIGNEDIN)
				<a href="{{ url('/logout') }}" class="btn-logout icon icon-logout"></a>
			@endif
			<div class="header-menu">
				<nav>
					<ul>
					@foreach($_headmenuall as $menu)
						@if(!SIGNEDIN && !$menu->signedin_only || SIGNEDIN)
						<li class="{{ !empty($menu->submenu) ? 'has-submenu' : '' }}">
							<a href="{{ !strlen($menu->alias) ? 'javascript:void(0)' : url($menu->alias) }}">{{ $menu->name }}</a>
							@if(!empty($menu->submenu))
							<span class="plus"></span>
							<div class="submenu">
								<div class="page-wrapper">
									<ul>
										@foreach($menu->submenu as $submenu)
											@if(!SIGNEDIN && !$submenu->signedin_only || SIGNEDIN)
											<li>
												<a href="{{ !strlen($submenu->alias) ? 'javascript:void(0)' : url($submenu->alias) }}">{{ $submenu->name }}</a>
											</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
							@endif
						</li>
						@endif
					@endforeach

					@if(SIGNEDIN)
						@foreach($_headmenusin as $index => $menu)
						<li class="logged-link {{ !$index ? 'logged-link--first' : '' }} {{ !empty($menu->submenu) ? 'has-submenu' : '' }}">
							<a href="{{ !strlen($menu->alias) ? 'javascript:void(0)' : url($menu->alias) }}">{{ $menu->name }}</a>
							@if(!empty($menu->submenu))
							<span class="plus"></span>
							<div class="submenu">
								<div class="page-wrapper">
									<ul>
										@foreach($menu->submenu as $submenu)
										<li>
											<a href="{{ !strlen($submenu->alias) ? 'javascript:void(0)' : url($submenu->alias) }}">{{ $submenu->name }}</a>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
							@endif
						</li>
						@endforeach
					@endif
					</ul>
				</nav>

				<div class="mobile-header-bottom">
					<a href="tel: {{ $_socials->phone_number }}" class="tel icon icon-telephone2">{{ $_socials->phone_number }}</a>
					<a href="" class="mail-link icon icon-mail js_modal-open" data-modal-type="email-feedback" data-modal-part="1"></a>
					<div class="login-links">
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2">{{ $_header->text_1 }}</a>
						<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1">{{ $_header->text_2 }}</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</header>
<!-- End of Page header -->
