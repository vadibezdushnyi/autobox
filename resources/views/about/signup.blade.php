@extends('layouts.app')
@section('content')
<main class="page-content">

<style media="screen">
  .form-style.light input, .form-style.light .form-message, .form-style.light .message{
    color: #424242 !important;
  }
</style>

<!-- Section Company Profile -->
<section class="section section--content animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <div class="section-text animatable-simple">
              <h3>{!! $_page->text_2 !!}</h3>

              @if(!SIGNEDIN)
              <div class="modal__content">
          				<div class="modal__content__container">
          					<div class="modal-body">
          						<form class="form-style light" autocomplete="off">
          							<div class="fields-container">

          								<div class="fields-row">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_11 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" name="registration-login" style="display:none;">
          											<input type="text" id="signup-login" name="registration-login" autocomplete="off">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_25 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_12 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="password" name="registration-password" style="display:none">
          											<input type="password" id="signup-password" name="registration-password" autocomplete="off">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_26 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_13 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="password" name="registration-password-confirmation" style="display:none">
          											<input type="password" id="signup-password-confirmation" name="registration-password-confirmation" autocomplete="off">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_27 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_14 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-name" name="registration-name">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_28 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_15 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-surname" name="registration-surname">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_29 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_16 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-company" name="registration-company">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_30 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_17 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-street" name="registration-street">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_31 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--3">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_18 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-town" name="registration-town">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_32 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_19 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-zip" name="registration-zip">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_33 }}</span>
          									</label>

          									<label class="col field-block field-block--list">
          										<span class="field-block__title">{{ $_authmodals->text_20 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-country" name="registration-country" data-value="0">
          											<span class="appearance"><span></span></span>
          											<div class="field-list">
          													<ul>
          														@foreach($_countries as $country)
          															<li><a href="" class="element" data-value="{{ $country->id }}">{{ $country->name }}</a></li>
          														@endforeach
          													</ul>
          											</div>
          											<button type="button" class="btn btn-field-list icon icon-arrow-down2"></button>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_34 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_21 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="tel" id="signup-telephone" name="registration-telephone" class="phone_only">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_35 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_22 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="email" id="signup-email" name="registration-email">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_36 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2">
          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_23 }}</span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-website" name="registration-website">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_37 }}</span>
          									</label>

          									<label class="col field-block">
          										<span class="field-block__title">{{ $_authmodals->text_24 }}<span class="field-block__title__star">*</span></span>
          										<span class="field-block__input-container">
          											<input type="text" id="signup-turnover" name="registration-turnover" class="amount_only">
          											<span class="appearance"><span></span></span>
          										</span>
          										<span class="error-message">{{ $_authmodals->text_38 }}</span>
          									</label>
          								</div>

          								<div class="fields-row fields-row--2 fields-row--captcha">
          									<div class="col captcha-block">
          										<img src="/autobox/get_captcha" class="captcha-view">
          									</div>

          									<label class="col field-block">
          										<span class="field-block__input-container">
          											<input type="text" name="captcha" id="signup-captcha">
          											<span class="appearance"><span></span></span>
          										</span>
          									</label>
          								</div>

          							</div>

          							<div class="form-footer">
          								<div class="form-message icon icon-attention" style="display:none;">
          									{{ $_authmodals->text_39 }}
          								</div>
          								<div class="two-cols">
          									<div class="col-left">
          										<button type="button" class="btn btn-red" onclick="__.signup(event)">{{ $_authmodals->text_40 }}</button>
          										<div class="message-container">
          											<div class="message">{{ $_authmodals->text_41 }}</div>
          										</div>
          									</div>
          								</div>
          							</div>
    	            		</form>
    	            	</div>
    	            </div>
  	          </div>
              @else
                <h3>{!! $_page->text_3 !!}</h3>
              @endif
            </div>
        </div>
    </div>
</section>


</main>
@endsection
