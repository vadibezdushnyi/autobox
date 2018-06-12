<?php if(!SIGNEDIN): ?>
<!-- Authorization modal window -->
<div class="modal__window modal__window--bg modal__window--authorization" data-modal-type="authorization">
	<div class="modal__bg">
		<div class="col-left">
			<div class="image" style="background-image: url('<?php echo e(url('/public/img/content/modal-bg1.jpg')); ?>')"></div>
			<div class="modal-logo"><img src="<?php echo e(url('/public/img/content/logo.png')); ?>" alt="Autobox"></div>
		</div>
		<div class="col-right">

		</div>
	</div>

	<!-- Each authorization form has own modal__wrapper -->
	<!-- Registration form -->
    <div class="modal__wrapper js_modal-part" data-modal-part="1">
        <div class="modal__container">
        	<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title"><?php echo e($_authmodals->text_10); ?></h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
    	</div>
			<div class="modal__content">
				<div class="modal__content__container">
					<div class="modal-body">
						<form class="form-style" autocomplete="off">
							<div class="fields-container">

								<div class="fields-row">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_11); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" name="registration-login" style="display:none;">
											<input type="text" id="registration-login" name="registration-login" autocomplete="off">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_25); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_12); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="password" name="registration-password" style="display:none">
											<input type="password" id="registration-password" name="registration-password" autocomplete="off">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_26); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_13); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="password" name="registration-password-confirmation" style="display:none">
											<input type="password" id="registration-password-confirmation" name="registration-password-confirmation" autocomplete="off">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_27); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_14); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-name" name="registration-name">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_28); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_15); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-surname" name="registration-surname">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_29); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_16); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-company" name="registration-company">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_30); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_17); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-street" name="registration-street">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_31); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--3">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_18); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-town" name="registration-town">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_32); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_19); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-zip" name="registration-zip">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_33); ?></span>
									</label>

									<label class="col field-block field-block--list">
										<span class="field-block__title"><?php echo e($_authmodals->text_20); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-country" name="registration-country" data-value="0">
											<span class="appearance"><span></span></span>
											<div class="field-list" style="background-color:#0e0e0e;">
													<ul>
														<?php foreach($_countries as $country): ?>
															<li><a href="" class="element" data-value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></a></li>
														<?php endforeach; ?>
													</ul>
											</div>
											<button type="button" class="btn btn-field-list icon icon-arrow-down2"></button>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_34); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_21); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="tel" id="registration-telephone" name="registration-telephone" class="phone_only">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_35); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_22); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="email" id="registration-email" name="registration-email">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_36); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_23); ?></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-website" name="registration-website">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_37); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_24); ?><span class="field-block__title__star">*</span></span>
										<span class="field-block__input-container">
											<input type="text" id="registration-turnover" name="registration-turnover" class="amount_only">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_38); ?></span>
									</label>
								</div>

								<div class="fields-row fields-row--2 fields-row--captcha">
									<div class="col captcha-block">
										<img src="<?php echo e(url('/get_captcha')); ?>" class="captcha-view">
									</div>

									<label class="col field-block">
										<span class="field-block__input-container">
											<input type="text" name="captcha" id="registration-captcha">
											<span class="appearance"><span></span></span>
										</span>
									</label>
								</div>

							</div>

							<div class="form-footer">
								<div class="form-message icon icon-attention" style="display:none;">
									<?php echo e($_authmodals->text_39); ?>

								</div>
								<div class="two-cols">
									<div class="col-left">
										<button type="button" class="btn btn-red" onclick="__.register(event)"><?php echo e($_authmodals->text_40); ?></button>
										<div class="message-container">
											<div class="message"><?php echo e($_authmodals->text_41); ?></div>
										</div>
									</div>
									<div class="col-right">
										<div class="links"><a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2"><?php echo e($_authmodals->text_42); ?></a><span class="dash"></span>
											<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="3"><?php echo e($_authmodals->text_43); ?></a></div>
									</div>
								</div>
							</div>

	            		</form>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Login form -->
	<div class="modal__wrapper js_modal-part" data-modal-part="2">
		<div class="modal__container">
			<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title"><?php echo e($_authmodals->text_1); ?></h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
			</div>

			<div class="modal__content">
				<div class="modal__content__container">
					<div class="modal-body">
						<form class="form-style" id="auth-form" autocomplete="off">
							<div class="fields-container">

								<div class="fields-row fields-row--2">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_2); ?></span>
										<span class="field-block__input-container">
											<input type="text" name="login" style="display:none;">
											<input type="text" id="login" name="login" autocomplete="off">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_4); ?></span>
									</label>

									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_3); ?></span>
										<span class="field-block__input-container">
											<input type="password" name="password" style="display:none;">
											<input type="password" id="password" name="password" autocomplete="off">
											<span class="appearance"><span></span></span>
										</span>
										<span class="error-message"><?php echo e($_authmodals->text_5); ?></span>
									</label>
								</div>

							</div>

							<div class="form-footer">
								<div class="form-message icon icon-attention" style="display:none;">
									<?php echo e($_authmodals->text_39); ?>

								</div>
								<div class="two-cols">
									<div class="col-left">
										<button type="button" class="btn btn-red" onclick="__.auth(event)"><?php echo e($_authmodals->text_6); ?></button>
										<div class="message-container">
											<div class="message"><?php echo e($_authmodals->text_7); ?></div>
										</div>
									</div>
									<div class="col-right">
										<div class="links"><a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1"><?php echo e($_authmodals->text_8); ?></a><span class="dash"></span>
											<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="3"><?php echo e($_authmodals->text_9); ?></a></div>
									</div>
								</div>
							</div>

		        		</form>
		        	</div>
		        </div>
		    </div>
		</div>
	</div>

	<!-- Password Recovery form -->
	<div class="modal__wrapper js_modal-part" data-modal-part="3">
		<div class="modal__container">
			<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title"><?php echo e($_authmodals->text_44); ?></h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
			</div>

			<div class="modal__content">
				<div class="modal__content__container">
					<div class="modal-body">
						<form class="form-style">
							<div class="fields-container">

								<div class="fields-row">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_authmodals->text_45); ?></span>
										<span class="field-block__input-container">
											<input type="text" id="recovery-email" name="recovery-email">
											<span class="appearance"><span></span></span>
										</span>
									</label>
								</div>

								<div class="fields-row fields-row--2 fields-row--captcha">
									<div class="col captcha-block">
										<img src="<?php echo e(url('/get_captcha')); ?>" class="captcha-view">
									</div>

									<label class="col field-block">
										<span class="field-block__input-container">
											<input type="text" name="captcha" id="recovery-captcha">
											<span class="appearance"><span></span></span>
										</span>
									</label>
								</div>

							</div>

							<div class="form-footer">
								<div class="two-cols">
									<div class="col-left">
										<button type="button" class="btn btn-red" onclick="__.recovery(event)"><?php echo e($_authmodals->text_46); ?></button>
										<div class="message-container">
											<div class="message"><?php echo e($_authmodals->text_47); ?></div>
										</div>
									</div>
									<div class="col-right">
										<div class="links"><a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="2"><?php echo e($_authmodals->text_48); ?></a><span class="dash"></span>
											<a href="" class="js_modal-open" data-modal-type="authorization" data-modal-part="1"><?php echo e($_authmodals->text_49); ?></a></div>
									</div>
								</div>
							</div>

		        		</form>
		        	</div>
		        </div>

            </div>

        </div>
    </div>


</div>
<!-- End of Authorization modal window -->
<?php endif; ?>

<!-- Authorization modal window -->
<div class="modal__window modal__window--bg modal__window--authorization" data-modal-type="email-feedback">
	<div class="modal__bg">
		<div class="col-left">
			<div class="image" style="background-image: url('<?php echo e(url('/public/img/content/modal-bg1.jpg')); ?>')"></div>
			<div class="modal-logo"><img src="<?php echo e(url('/public/img/content/logo.png')); ?>" alt="Autobox"></div>
		</div>
		<div class="col-right">

		</div>
	</div>

	<!-- Password Recovery form -->
	<div class="modal__wrapper js_modal-part" data-modal-part="1">
		<div class="modal__container">
			<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title"><?php echo e($_contactmodals->text_50); ?></h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
			</div>

			<div class="modal__content">
				<div class="modal__content__container">
					<div class="modal-body">
						<form class="form-style">
							<div class="fields-container">

								<div class="fields-row">
									<label class="col field-block">
										<span class="field-block__title"><?php echo e($_contactmodals->text_51); ?></span>
										<span class="field-block__input-container">
											<input type="text" id="feedback-email" name="feedback-email" value="<?php echo e(SIGNEDIN ? $_user->email : ''); ?>">
											<span class="appearance"><span></span></span>
										</span>
									</label>
								</div>
								<div class="fields-row">
									<div class="col">
									    <label class="field-block field-block--textarea">
									        <span class="field-block__title"> 
											<?php echo e($_contactmodals->text_52); ?><span class="field-block__title__star">*</span></span>
									        <span class="field-block__input-container">
									            <textarea id="feedback-message" name="contact-message"></textarea>
									            <span class="appearance"><span></span></span>
									        </span>
									    </label>
									</div>
								</div>

								<div class="fields-row fields-row--2 fields-row--captcha">
									<div class="col captcha-block">
										<img src="<?php echo e(url('/get_captcha')); ?>" class="captcha-view">
									</div>

									<label class="col field-block">
										<span class="field-block__input-container">
											<input type="text" name="captcha" id="feedback-captcha">
											<span class="appearance"><span></span></span>
										</span>
									</label>
								</div>

							</div>

							<div class="form-footer">
								<div class="col-full">
									<button type="button" class="btn btn-red" onclick="__.emailFeedback(event)"><?php echo e($_contactmodals->text_53); ?></button>
									<div class="message-container">
										<div class="message"><?php echo e($_contactmodals->text_54); ?></div>
									</div>
								</div>
							</div>

		        		</form>
		        	</div>
		        </div>

            </div>

        </div>
    </div>
</div>
