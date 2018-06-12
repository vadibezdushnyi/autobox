var __ = new Object;
__.domain = "/";
__.captcha_url = __.domain + 'get_captcha?v=';
__.cart_xls = {};
__.matches = [];
__.matches_ignored = [];
__.ajax = function(req, callback) {
  $.ajax({
    url: this.domain + 'ajax',
    type: 'post',
    data: req,
    headers: { "X-CSRF-TOKEN" : $('[name="_token"]').val() },
    dataType: 'json',
    success: function (data) {
      if(data.token_mismatch) document.location.reload();
      if(data.status=='success') callback(null, data);
      else callback(data, null);
    }
  });
};

__.ajaxy = function(req, callback) {
  $.ajax({
    url: this.domain + 'ajax',
    type: 'post',
    data: req,
    headers: { "X-CSRF-TOKEN" : $('[name="_token"]').val() },
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if(data.status=='success')
        callback(null, data);
      else
        callback(data, null);
    }
  });
};

__.set_locale = function(e, locale) {
  e.preventDefault();
  if(!locale) return null;
  this.ajax({ a:'set_locale', l:locale }, function(err, res) {
    if(res) {
      document.location.reload();
    }
  });
};

__.resetForm = function() {
  $(event.target).parents('form').find('input').each(function() {
    $(this).val($(this).attr('data-default'));
  })
};

__.search = function(query) {
  $('#search-results').bootloader('show');
  var req = {
    a: 'search',
    q: query
  };
  this.ajax(req, function(err, res) {
    if(res) {
      $('#search-results').bootloader('hide').find('.content').html(res.html);
      cs.initCounterInput();
      cs.initModal();
    }
  });
};

__.auth = function(event) {
  var btnclck = $(event.target).attr('onclick');
  var form = $('#auth-form');
  $(form)
  .find('.field-block--invalid').removeClass('field-block--invalid').end()
  .find('.form-message').html('').hide();

  var req = {
    a: 'auth',
    e: $(form).find('input#login').val(),
    p: $(form).find('input#password').val(),
  };

  if(req.e.length < 6) {
    $(form).find('input#login').focus().parents('label').addClass('field-block--invalid');
    return null;
  }

  if(req.p.length < 6) {
    $(form).find('input#password').focus().parents('label').addClass('field-block--invalid');
    return null;
  }

  this.ajax(req, function(err, res) {
    if(res) {
      $(form).find('.form-message').html(res.message).show();
      document.location.reload();
    } else {
      $(form).find('.form-message').html(err.message).show();
    }
  });
};

__.register = function(e) {
  var form = $(e.target).parents('form');
  var button = $(e.target);
  var onclick = '__.register(event)';
  $(form)
  .find('.field-block--invalid').removeClass('field-block--invalid').end()
  .find('.form-message').html('').hide();

  var login = $('#registration-login');
  var pass = $('#registration-password');
  var passc = $('#registration-password-confirmation');
  var fname = $('#registration-name');
  var lname = $('#registration-surname');
  var company = $('#registration-company');
  var country = $('#registration-country');
  var street = $('#registration-street');
  var town = $('#registration-town');
  var zip = $('#registration-zip');
  var phone = $('#registration-telephone');
  var email = $('#registration-email');
  var website = $('#registration-website');
  var turnover = $('#registration-turnover');
  var captcha = $('#registration-captcha');

  if(login.val().length < 6) {
    $(login).parents('label').addClass('field-block--invalid');
    login.focus();
    return null;
  }
  if(pass.val().length < 6) {
    $(pass).parents('label').addClass('field-block--invalid');
    pass.focus();
    return null;
  }
  if(passc.val() !== pass.val()) {
    $(passc).parents('label').addClass('field-block--invalid');
    passc.focus();
    return null;
  }
  if(fname.val().length < 2) {
    $(fname).parents('label').addClass('field-block--invalid');
    fname.focus();
    return null;
  }
  if(lname.val().length < 2) {
    $(lname).parents('label').addClass('field-block--invalid');
    lname.focus();
    return null;
  }
  if(company.val().length < 2) {
    $(company).parents('label').addClass('field-block--invalid');
    company.focus();
    return null;
  }
  if(street.val().length < 2) {
    $(street).parents('label').addClass('field-block--invalid');
    street.focus();
    return null;
  }
  if(town.val().length < 2) {
    $(town).parents('label').addClass('field-block--invalid');
    town.focus();
    return null;
  }
  if(zip.val().length < 2) {
    $(zip).parents('label').addClass('field-block--invalid');
    zip.focus();
    return null;
  }
  if(!parseInt(country.attr('data-value'))) {
    $(country).parents('label').addClass('field-block--invalid');
    country.focus();
    return null;
  }
  if(phone.val().length < 2) {
    $(phone).parents('label').addClass('field-block--invalid');
    phone.focus();
    return null;
  }
  if(!email.val().isEmail()) {
    $(email).parents('label').addClass('field-block--invalid');
    email.focus();
    return null;
  }
  if(turnover.val().length < 2) {
    $(turnover).parents('label').addClass('field-block--invalid');
    turnover.focus();
    return null;
  }
  if(captcha.val().length < 4) {
    $(captcha).parents('label').addClass('field-block--invalid');
    captcha.focus();
    return null;
  }
  $(form).parents('.modal__container').bootloader('show');
  var req = {
    a:'register',
    login:$(login).val(),
    pass:$(pass).val(),
    passc:$(passc).val(),
    fname:$(fname).val(),
    lname:$(lname).val(),
    company:$(company).val(),
    country:parseInt($(country).attr('data-value')),
    street:$(street).val(),
    town:$(town).val(),
    zip:$(zip).val(),
    phone:$(phone).val(),
    email:$(email).val(),
    website:$(website).val(),
    turnover:$(turnover).val(),
    captcha:$(captcha).val()
  };
  button.attr('onclick', 'return null;');
  this.ajax(req, function(err, res) {
    button.attr('onclick', onclick);
    $(form).parents('.modal__container').bootloader('hide');
    if(res) {
      $(form).hide().after($('<h3>').text(res.message).css({
      	'color':'#fff',
      	'text-align':'center',
      	'font-size':'32px',
      	'letter-spacing':'1px'
      }));
      // setTimeout(document.location.reload.bind(document.location), 3000);
    } else {
      $(form).find('.form-message').html(err.message).show();
      if(err.code) {
        switch (err.code) {
          case 101:
            $(login).focus();
            $(login).parents('label').addClass('field-block--invalid');
            break;
          case 102:
            $(captcha).focus();
            $(captcha).parents('label').addClass('field-block--invalid');
            break;
          default:
            break;
        }
      }
    }
  });
  return null;
};

__.signup = function(e) {
  var form = $(e.target).parents('form');
  $(form)
  .find('.field-block--invalid').removeClass('field-block--invalid').end()
  .find('.form-message').html('').hide();

  var login = $('#signup-login');
  var pass = $('#signup-password');
  var passc = $('#signup-password-confirmation');
  var fname = $('#signup-name');
  var lname = $('#signup-surname');
  var company = $('#signup-company');
  var country = $('#signup-country');
  var street = $('#signup-street');
  var town = $('#signup-town');
  var zip = $('#signup-zip');
  var phone = $('#signup-telephone');
  var email = $('#signup-email');
  var website = $('#signup-website');
  var turnover = $('#signup-turnover');
  var captcha = $('#signup-captcha');

  if(login.val().length < 6) {
    $(login).parents('label').addClass('field-block--invalid');
    login.focus();
    return null;
  }
  if(pass.val().length < 6) {
    $(pass).parents('label').addClass('field-block--invalid');
    pass.focus();
    return null;
  }
  if(passc.val() !== pass.val()) {
    $(passc).parents('label').addClass('field-block--invalid');
    passc.focus();
    return null;
  }
  if(fname.val().length < 2) {
    $(fname).parents('label').addClass('field-block--invalid');
    fname.focus();
    return null;
  }
  if(lname.val().length < 2) {
    $(lname).parents('label').addClass('field-block--invalid');
    lname.focus();
    return null;
  }
  if(company.val().length < 2) {
    $(company).parents('label').addClass('field-block--invalid');
    company.focus();
    return null;
  }
  if(street.val().length < 2) {
    $(street).parents('label').addClass('field-block--invalid');
    street.focus();
    return null;
  }
  if(town.val().length < 2) {
    $(town).parents('label').addClass('field-block--invalid');
    town.focus();
    return null;
  }
  if(zip.val().length < 2) {
    $(zip).parents('label').addClass('field-block--invalid');
    zip.focus();
    return null;
  }
  if(!parseInt(country.attr('data-value'))) {
    $(country).parents('label').addClass('field-block--invalid');
    country.focus();
    return null;
  }
  if(phone.val().length < 2) {
    $(phone).parents('label').addClass('field-block--invalid');
    phone.focus();
    return null;
  }
  if(!email.val().isEmail()) {
    $(email).parents('label').addClass('field-block--invalid');
    email.focus();
    return null;
  }
  if(turnover.val().length < 2) {
    $(turnover).parents('label').addClass('field-block--invalid');
    turnover.focus();
    return null;
  }
  if(captcha.val().length < 4) {
    $(captcha).parents('label').addClass('field-block--invalid');
    captcha.focus();
    return null;
  }

  var req = {
    a:'register',
    login:$(login).val(),
    pass:$(pass).val(),
    passc:$(passc).val(),
    fname:$(fname).val(),
    lname:$(lname).val(),
    company:$(company).val(),
    country:parseInt($(country).attr('data-value')),
    street:$(street).val(),
    town:$(town).val(),
    zip:$(zip).val(),
    phone:$(phone).val(),
    email:$(email).val(),
    website:$(website).val(),
    turnover:$(turnover).val(),
    captcha:$(captcha).val()
  };

  this.ajax(req, function(err, res) {
    if(res) {
      $(form).hide().after($('<h3>').text(res.message).css({
      	'color':'#fff',
      	'text-align':'center',
      	'font-size':'32px',
      	'letter-spacing':'1px'
      }));
      // setTimeout(document.location.reload.bind(document.location), 3000);
    } else {
      $(form).find('.form-message').html(err.message).show();
      if(err.code) {
        switch (err.code) {
          case 101:
            $(login).focus();
            $(login).parents('label').addClass('field-block--invalid');
            break;
          case 102:
            $(captcha).focus();
            $(captcha).parents('label').addClass('field-block--invalid');
            break;
          default:
            break;
        }
      }
    }
  });
  return null;
}

__.passwordRecovery = function() {
  $('.recovery .response-window').html('');
  $('.recovery *').removeClass('required');
  var button = event.target,
      form = $(button).parents('form'),
      req = {
        a: 'password_change',
        p: $(form).find('[name="password-old"]').val(),
        np: $(form).find('[name="password-new"]').val(),
        nc: $(form).find('[name="password-new-confirm"]').val(),
      };

  if(req.p.length < 6) return $(form).find('[name="password-old"]').focus();
  if(req.np.length < 6) return $(form).find('[name="password-new"]').focus();
  if(req.np != req.nc) return $(form).find('[name="password-new-confirm"]').focus();

  $('.profile-form-container').bootloader('show');

  this.ajax(req, function(err, res) {
    if(res) {
      $(form)[0].reset();
      $(form).find('.message-success').html(res.message).show(100);
    } else {
      $(form).find('.message-error').html(err.message).show(100);
    }
    $('.profile-form-container').bootloader('hide');
  });
}

__.emailFeedback = function(e) {
  var form = $(e.target).parents('form');
  $(form)
  .find('label').removeClass('field-block--invalid').end()
  .find('.form-message').html('').hide();
  var email = $('#feedback-email');
  var message = $('#feedback-message');
  var captcha = $('#feedback-captcha');

  if(!email.val().isEmail()) {
    $(email).parents('label').addClass('field-block--invalid');
    email.focus();
    return null;
  }  

  if(message.val().length < 5) {
    $(message).parents('label').addClass('field-block--invalid');
    message.focus();
    return null;
  }

  if(captcha.val().length < 4) {
    $(captcha).parents('label').addClass('field-block--invalid');
    captcha.focus();
    return null;
  }

  var req = {
    a: 'email_feedback',
    email: $(email).val(),
    message: $(message).val(),
    captcha: $(captcha).val()
  };

  this.ajax(req, function(err, res) {
    if(res) {
      $(form)[0].reset();
      $(form).find('.message').html(res.message).show();
      setTimeout(function() {
        $('.js_modal-close').trigger('click');
      }, 3000);
    } else {
      $(form).find('.message').html(err.message).show();
    }
  });
};

__.recovery = function(e) {
  var form = $(e.target).parents('form');
  $(form).find('.message').html("");
  $(form)
  .find('label').removeClass('field-block--invalid').end()
  .find('.form-message').html('').hide();
  var email = $('#recovery-email');
  var captcha = $('#recovery-captcha');

  if(email.val().length < 6) {
    $(email).parents('label').addClass('field-block--invalid');
    email.focus();
    return null;
  }

  if(captcha.val().length < 4) {
    $(captcha).parents('label').addClass('field-block--invalid');
    captcha.focus();
    return null;
  }

  var req = {
    a: 'password_recovery',
    email: $(email).val(),
    captcha: $(captcha).val()
  };

  this.ajax(req, function(err, res) {
    if(res) {
      $(form)[0].reset();
      $(form).hide().after($('<h3>').text(res.message).css({
      	'color':'#fff',
      	'text-align':'center',
      	'font-size':'32px',
      	'letter-spacing':'1px'
      }));
      setTimeout(function() {
        $('.js_modal-close').trigger('click');
        $(form).show().next('h3').remove();
      }, 3000);
    } else {
      $(form).find('.message').html(err.message).show();
    }
  });

};

__.discard = function(e) {
  $(e.target).parents('form').find('input').each(function() {
    if(!$(this).hasAttr('readonly')) $(this).val($(this).attr('data-buffer'));
  });
};

__.saveChanges = function(e) {
  var form = $(e.target).parents('form');
  $(form).find('label').removeClass('field-block--invalid');
  $(form).find('.form-message').html($(form).find('.form-message').attr('data-default')).invisible();
  var fname = $('#profile-name');
  var lname = $('#profile-surname');
  var company = $('#profile-company');
  var country = $('#profile-country');
  var street = $('#profile-street');
  var town = $('#profile-town');
  var zip = $('#profile-zip');
  var phone = $('#profile-telephone');
  var email = $('#profile-email');
  var website = $('#profile-website');
  var turnover = $('#profile-turnover');
  var profile = $('#profile-account');

  if(fname.val().length < 2) {
    $(fname).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    fname.focus();
    return null;
  }
  if(lname.val().length < 2) {
    $(lname).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    lname.focus();
    return null;
  }
  if(company.val().length < 2) {
    $(company).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    company.focus();
    return null;
  }
  if(street.val().length < 2) {
    $(street).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    street.focus();
    return null;
  }
  if(town.val().length < 2) {
    $(town).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    town.focus();
    return null;
  }
  if(zip.val().length < 2) {
    $(zip).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    zip.focus();
    return null;
  }
  if(!parseInt(country.attr('data-value'))) {
    $(country).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    country.focus();
    return null;
  }
  if(phone.val().length < 2) {
    $(phone).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    phone.focus();
    return null;
  }
  if(!email.val().isEmail()) {
    $(email).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    email.focus();
    return null;
  }
  if(turnover.val().length < 2) {
    $(turnover).parents('label').addClass('field-block--invalid');
    $(form).find('.message-error').visible();
    turnover.focus();
    return null;
  }

  var req = {
    a:'save_profile',
    fname:$(fname).val(),
    lname:$(lname).val(),
    company:$(company).val(),
    country:parseInt($(country).attr('data-value')),
    street:$(street).val(),
    town:$(town).val(),
    zip:$(zip).val(),
    phone:$(phone).val(),
    email:$(email).val(),
    website:$(website).val(),
    turnover:$(turnover).val(),
    profile:$(profile).val()
  };

  this.ajax(req, function(err, res) {
    if(res) {
      $(form).find('.form-message.message-success').html(res.message).visible();
      setTimeout(function() {
        $(form).find('.form-message').html('&nbsp;').invisible();
      }, 3000);
    } else {
      $(form).find('.form-message.message-error').html(err.message).visible();
    }
  });

};

__.toCart = function(id, qty, com, vin) {
  var self = this;
  var req = {
    a: 'to_cart',
    p: parseInt(id),
    q: isDefined(qty) ? parseInt(qty) : 1,
    c: isDefined(com) ? com : false,
    v: isDefined(vin) ? vin : false
  };
  $('#search-results').bootloader('show');
  this.ajax(req, function(err, res) {
    if(res) {
      if(req.q) {
        $('.cart-main').show(),
        $('.cart-empty-container').hide();
        self.refreshCart();
      }
    }
  $('#search-results').bootloader('hide');
  });
};

__.updateQty = function(id, event) {
  var self = this;
  // $('#cart-table').bootloader('show');
  this.ajax({a:'update_qty', p:parseInt(id), q:parseInt($(event.target).val())}, function(err, res) {
    if(res) {
      // $(event.target).parents('td').siblings('.cell-total').attr('data-sort', res.amount).find('b').html(res.amount);
      // $(event.target).parents('td').siblings('.cell-factor-price').attr('data-sort', res.price).find('b').html(res.price);
      // $('.total_amount').html(res.cart.total);
      // $('.total_qty').html(res.cart.qty);
      // $('#header-cart .price').html(res.cart.total + '&euro;');
      // $('#header-cart .amount').html(res.cart.qty);
      self.refreshCart();
    }
    // $('#cart-table').bootloader('hide');
  });
};

__.updateComment = function(id, event) {
  $('#cart-table').bootloader('show');
  this.ajax({a:'update_comment', p:parseInt(id), q:$(event.target).val()}, function(err, res) {
    if(res) {
      $('#cart-table').bootloader('hide');
    }
  });
};

__.updateVin = function(id, event) {
  $('#cart-table').bootloader('show');
  this.ajax({a:'update_vin', p:parseInt(id), q:$(event.target).val()}, function(err, res) {
    if(res) {
      $('#cart-table').bootloader('hide');
    }
  });
};


__.cartReplacementPopup = function(e) {
  var self = e.target;
  var idx = parseInt($(self).attr('data-idx'));
  var modal = $('.modal__window[data-modal-type="product-replacement"]');
  modal.addClass('active');
  modal.find('.modal__container').bootloader('show');
  this.ajax({a:'get_replacement', p:idx}, function(err, res) {
    if(res) {
      modal.find('.modal__content__container').html(res.content);
    }
    modal.find('.modal__container').bootloader('hide');
  });
};

__.cartReplacement = function(pid, sku) {
  var modal = $('.modal__window[data-modal-type="product-replacement"]');
  var self = this;
      pid = parseInt(pid);
      sku = typeof sku === typeof undefined ? 0 : sku;
  modal.find('.modal__container').bootloader('show');
  this.ajax({a:'cart_replacement', p:pid, s:sku}, function(err, res) {
    if(res) self.refreshCart();
    modal.find('.modal__container').bootloader('hide');
    modal.removeClass('active');
  });
};

__.removeFromCartPopup = function(e) {
  var self = e.target;
  var id = parseInt($(self).attr('data-idx'));
  var table = $(self).parents('table').first();
  var tr = $(self).parents('tr').first();
  var overlay = $('#remove_overlay');
  overlay.appendTo(table);

  var width = $(tr).css('width');
  var height = $(tr).css('height');
  var row = $(tr).position();
  bottomTop = row.top;
  bottomLeft = row.left;

  overlay.css({
    'z-index': 9999,
    'position': 'absolute',
    'display': 'table',
    'top': bottomTop,
    'left': bottomLeft,
    'width': width,
    'height': height,
    'background': 'rgba(27, 27, 27, 0.9)',
    'text-align': 'center'
  }).slideDown(0);

  overlay.find('.confirm').attr('onclick', '__.removeFromCart('+id+', event)');
  overlay.find('.confirm, .decline').on('click', function() {
    overlay.slideUp(0); overlay.find('.confirm').attr('onclick', '');
  });
};

__.removeFromOrderPopup = function(e) {
  var self = e.target;
  var id = parseInt($(self).attr('data-idx'));
  var table = $(self).parents('table').first();
  var tr = $(self).parents('tr').first();
  var overlay = $('#remove_overlay');
  overlay.appendTo(table);

  var width = $(tr).css('width');
  var height = $(tr).css('height');
  var row = $(tr).position();
  bottomTop = row.top;
  bottomLeft = row.left;

  overlay.css({
    'z-index': 9999,
    'position': 'absolute',
    'display': 'table',
    'top': bottomTop,
    'left': bottomLeft,
    'width': width,
    'height': height,
    'background': 'rgba(27, 27, 27, 0.9)',
    'text-align': 'center'
  }).slideDown(0);

  overlay.find('.confirm').attr('onclick', '__.removeFromOrder('+id+', event)');
  overlay.find('.confirm, .decline').on('click', function() {
    overlay.slideUp(0); overlay.find('.confirm').attr('onclick', '');
  });
};

__.clearCartPopup = function(e) {
  var table = $('#cart-table');
  var overlay = $('#remove_overlay');
  overlay.appendTo(table);

  var width = $(table).css('width');
  var height = $(table).css('height');
  bottomTop = 0;
  bottomLeft = 0;

  overlay.css({
    'z-index': 9999,
    'position': 'absolute',
    'display': 'table',
    'top': bottomTop,
    'left': bottomLeft,
    'width': width,
    'height': height,
    'background': 'rgba(27, 27, 27, 0.9)',
    'text-align': 'center'
  }).slideDown(0);

  overlay.find('.confirm').attr('onclick', '__.clearCart()');
  overlay.find('.confirm, .decline').on('click', function() {
    overlay.slideUp(0); overlay.find('.confirm').attr('onclick', '');
  });
};

__.removeFromCart = function(id, event) {
  $('#cart-table').bootloader('show');
  this.ajax({a:'remove_from_cart', p:parseInt(id)}, function(err, res) {
    if(res) {
      var tr = $('#cart-table tr[data-product="'+parseInt(id)+'"]');
      $(tr).fadeOut(300, function() {
        $(tr).remove();
        if(!$('#cart-table tbody tr').length)
          $('.cart-main').hide(), $('.cart-empty-container').show();
      });
      $('.total_amount').html(res.cart.total);
      $('.total_vat_amount').html(res.cart.vtotal);
      $('.total_qty').html(res.cart.qty);
      $('#header-cart .price').html(res.cart.total + '&euro;');
      $('#header-cart .amount').html(res.cart.qty);
      $('#order_create_btn').removeClass('disabled').attr('onclick', '__.createOrder()');
    }
    $('#cart-table').bootloader('hide');
  });
};

__.clearCart = function() {
  $('#cart-table').bootloader('show');
  this.ajax({a:'clear_cart'}, function(err, res) {
    $('#cart-table').bootloader('hide');
    if(res) {
      $('#cart-table tbody tr').each(function(el) {
        $(this).fadeOut(100, function() {
          $(this).remove();
          if(!$('#cart-table tbody tr').length) $('.cart-main').hide(), $('.cart-empty-container').show();
        });
      });
      $('.total_amount').html(res.cart.total);
      $('.total_qty').html(res.cart.qty);
      $('#header-cart .price').html(res.cart.total + '&euro;');
      $('#header-cart .amount').html(res.cart.qty);
      $('#order_create_btn').removeClass('disabled').attr('onclick', '__.createOrder()');
    }
  });
};

__.createOrder = function() {
  var self = this;
  var button = $('#order_create_btn');
  var click = $(button).attr('onclick');
  $(button).removeAttr('onclick');
  $('#cart-table').bootloader('show');
  var comment = $('#order_comment').val(); 
  self.ajax({a:'create_order', c:comment, i:self.matches_ignored}, function(err, res) {
    if(res) {
      if(res.ordered) {
        self.matches_ignored = [];
        $(button).attr('onclick', click);
        $('.total_amount').html(0);
        $('.total_qty').html(0);
        $('#header-cart .price').html(0 + '&euro;');
        $('#header-cart .amount').html(0);
        $('#cart-table tbody tr').remove();
        $('.cart-main').hide();
        $('.cart-empty-container').html(res.message).show();
      } else {
        $(button).addClass('disabled');
        $('.cart-empty-container.notification').show(50);
      }
      $('#claimed_to_refill').text(res.refill);
    }
    $('#cart-table').bootloader('hide');
  });
};

__.cartImport = function(e, order) {
  var self = this,
      isorder = ( typeof order === typeof undefined || !order ? 0 : 1 ),
      modal = $('.modal__window[data-modal-type="add-products"]'),
      result_modal = $('.modal__window[data-modal-type="add-products-result"]'),
      form = $(modal).find('form'),
      errors = $(modal).find('.tab.active').find('.message-error'),
      success = $(modal).parents('.tab.active').find('.message-success'),
      button = $(modal).find('.tab.active button.submit'),
      click = $(button).attr('onclick'),
      import_method = parseInt($(form).find('.js_tabs-trigger.active').attr('data-tab')),   /* 1-text, 2-excel */
      columns_delimiter = parseInt($(form).find('[name="columns-delimiter"]:checked').val()),  /* 1-tab, 2-semicolon */
      columns_format = parseInt($(form).find('[name="columns-format"]:checked').val()),  /* 1-pqc, 2-pqcv */
      columns_limit = columns_format == 1 ? 4 : 5,
      products = [];

  $(form).find('.form-message').html('&nbsp;').invisible();

  switch (import_method) {
    /* TEXT IMPORT */
    case 1:
      var imported_text = $(form).find('[name="import-area"]').val(),
          // imported_text = "1003736 \t 1 \t test 1 \n 1005519 \t 1 \t test 2 \n 1005532 \t 1 \t test 3 \n 1007767 \t 1 \t test 4 \n 1013938 \t 1 \t test 5 \n 1018219 \t 2 \t test 6 \n 1112750932811 \t 3 \t test 7 \n",
          delimeters = /[\t;]/;
          delimeter = columns_delimiter == 1 ? "\t" : ";",
          rows = imported_text.split("\n");

          if(!imported_text.trim().length) {
            $(errors).html('Nothing to import').visible();
            return null;
          }

          for(var row in rows) {
            if(typeof rows[row] != 'string' || !rows[row].trim().length) {
               rows.splice(row, 1); break;
            }
            var product = rows[row].indexOf(delimeter) >= 0
            ? rows[row].split(delimeters /* use @var delimeter for strict splitting */, columns_limit)
            : rows[row].split(delimeters, columns_limit);
            products.push(product);
          }
    break;
    /* TEXT IMPORT */

    /* XLS IMPORT */
    case 2:
      if(JSON.stringify(this.cart_xls) === JSON.stringify({})) {
        $(errors).html('Nothing to import').visible();
        return null;
      }
      products = this.cart_xls.map(function(value) {
        return value.splice(0, columns_limit);
      });
    break;
    /* XLS IMPORT */

    default:
    break;
  }

  $(button).removeAttr('onclick');
  $(modal).find('.modal__wrapper').bootloader('show');

  this.ajax({a: 'cart_import', p: products, o: isorder}, function(err, res) {
    self.importDiscard();
    $(modal).find('.modal__wrapper').bootloader('hide');
    if(res) {
      $(button).attr('onclick', click);
      $(modal).removeClass('active');
      $('#import-matches-count').html(res.added_count);
      $('#import-errors-count').html(res.errors_count);
      $('#import-results-table tbody').html(res.table);
      if(parseInt(res.errors_count)) $(result_modal).addClass('active');
      if(parseInt(res.added_count)) self.refreshCart();
      self.matches = res.matches;
      self.initPreDebuggingTable();
    } else {
      $(form).find('.form-message.message-error').html(err.message).visible();
    }
  });
};

__.initDebuggingTable = function() {
  var self = this;
  var to_cart = function(id, qty, com, vin, sku, tabs) {
    var tabs_papa = $(tabs).closest('.i-brand__block');
    var added_message = $(tabs_papa).find('.i-brand-msg-quanity');
    var parts = $(tabs).find('.import-finish-row[data-sku="'+sku+'"]');
    $('.active .modal__wrapper').bootloader('show');
    self.ajax({a: 'to_cart', p: parseInt(id), q: parseInt(qty), c: com, v: vin}, function(err, res) {
      if(res) {
        parts.fadeOut(200, function() { 
          $(this).remove();
          if(!$(tabs).find('.import-finish-row').length) {
            tabs.slideUp(150);
            added_message.html(parseInt(tabs.added)).parent().addClass('active');
          }
        });
        $('.cart-main').show(),
        $('.cart-empty-container').hide();
        self.refreshCart();
      }
      $('.active .modal__wrapper').bootloader('hide');
    });
  };  
  var to_cart_pack = function(products, tabs) {
    var tabs_papa = $(tabs).closest('.i-brand__block');
    var added_message = $(tabs_papa).find('.i-brand-msg-quanity');
    $('.active .modal__wrapper').bootloader('show');
    self.ajax({a: 'to_cart_pack', p:products}, function(err, res) {
      if(res) {
        tabs.slideUp(150);
        added_message.html(parseInt(res.added)).parent().addClass('active');
        $('.cart-main').show(),
        $('.cart-empty-container').hide();
        self.refreshCart();
      }
      $('.active .modal__wrapper').bootloader('hide');
    });
  };  
  var wrapper = $('#import-finish-table');
  wrapper.find('.table-import-tab').each(function() {
    var tab = $(this);
    var tabs = $(tab).closest('.js_tabs-scope');
    var tab_products_trigger = $(tab).find('.import-finish-add-all');
    var added_message = tab.find('.i-brand-msg-quanity');
    tabs.added = tab.find('.import-finish-row').length;
    tab_products_trigger.off().on('click', function() {
      var products = tab.find('.import-finish-row').map(function() {
        return {
          spare: parseInt($(this).attr('data-spare')),
          qty: parseInt($(this).attr('data-qty')),
          sku: $(this).attr('data-sku'),
          vin: $(this).attr('data-vin'),
          com: $(this).attr('data-com')
        };
      }).get();
      to_cart_pack(products, tabs);
    });
    tab.find('.import-finish-row').each(function() {
      var row = $(this);
      var spare = parseInt($(row).attr('data-spare'));
      var qty = parseInt($(row).attr('data-qty'));
      var sku = $(row).attr('data-sku');
      var vin = $(row).attr('data-vin');
      var com = $(row).attr('data-com');
      var product_trigger = $(row).find('.import-finish-add');
      product_trigger.off().on('click', function() {
        to_cart(spare, qty, com, vin, sku, tabs);
      });
    });
  });
};

__.loadImportFinishTable = function() {
  var self = this;
  self.matches = self.matches.filter(function(e) {
    if(e) { e.qty = parseInt(e.qty); e.matches = null; e.matches_unique = null; } 
    return !!e;
  });
  $('.modal__window[data-modal-type="add-products-result"]').removeClass('active');
  $('.modal__window[data-modal-type="add-products-finish"]').addClass('active');
  $('.active .modal__wrapper').bootloader('show');
  this.ajax({a: 'cart_import_finish', p:self.matches}, function(err, res) {
    $('.active .modal__wrapper').bootloader('hide');
    if(res) {
      // self.debugImportFinishTable(res);
      self.refreshCart();
      $('#import-finish-table').html(res.table);
      self.initDebuggingTable();
      cs.initTabs();
    }
  });    
};

__.debugImportFinishTable = function(res) {
  for(var x in res.producers) {
    console.group(res.producers[x].name);
      for(var g in res.producers[x].groups) {
        console.group(g);
        for(var s in res.producers[x].groups[g].suppliers) {
          console.group(res.producers[x].groups[g].suppliers[x].name);
          console.table(res.producers[x].groups[g].suppliers[x].products);
          console.groupEnd();
        }
        console.groupEnd();
      }
    console.groupEnd();
  }
}

__.initPreDebuggingTable = function() {
  var self = this;
  cs.initDropdowns();
  var to_debug = self.matches.filter(function(e) { return e && e.predebugging; });
  if(!to_debug.length) self.loadImportFinishTable();

  var table = $('#import-results-table tbody');

  var find_product = function(row, group_id) {
    var match = self.matches[group_id];
    $('.active .modal__wrapper').bootloader('show');
    self.ajax({a:'cart_import', p:[[match.sku, match.qty, match.com, match.vin]]}, function(err, res) {
      $('.active .modal__wrapper').bootloader('hide');
      if(res) {
        var new_row = $(res.table).attr('data-solution', group_id);
        $(row).replaceWith(new_row);
        var match = res.matches.pop();
        if(match && match.debugging) {
          self.matches[group_id] = match;
        } else {
          self.matches[group_id] = null;
          $('.cart-main').show(),
          $('.cart-empty-container').hide();
          $('#import-errors-count').text(parseInt($('#import-errors-count').text()) - 1);
          $('#import-matches-count').text(res.added_count + parseInt($('#import-matches-count').text()));
          cs.initDropdowns();
          self.refreshCart();
        }
        self.initPreDebuggingTable();
      }
    });
  }

  $('#import-results-table-clear').off().on('click', function() {
    $('.active .modal__wrapper').bootloader('show');
    $('#import-results-table tbody tr').each(function() {
      var group_id = parseInt($(this).attr('data-solution'));
      $('#import-errors-count').text(parseInt($('#import-errors-count').text()) - 1);
      if(self.matches.hasOwnProperty(group_id)) self.matches[group_id] = null;
    });
    $('.active .modal__wrapper').bootloader('hide');
    self.loadImportFinishTable();
  });

  $('.matches-pre-debugging').each(function() {
    var row = this;
    var group_id = parseInt($(row).attr('data-solution'));
    var add_trigger = $(row).find('.btn-i-apply');
    var remove_trigger = $(row).find('.btn-i-delete');
    var qty_input = $(row).find('input[name="qty"]');
    var qty_trigger = $(row).find('.qty_trigger.active');
    var sku_input = $(row).find('input[name="sku"]');
    var sku_trigger = $(row).find('.sku_trigger.active');
    var producer_select = $(row).find('input[name="maker"]');
    var producer_error = $(row).find('.error-producer');
    var qty_error = $(row).find('.error-quantity');
    var sku_error = $(row).find('.error-partcode');
    var errors_wrapper = $(row).find('.i-errors-ct');
    add_trigger.off().on('click', function() {
      if($(this).hasClass('active')) {
        $(row).fadeOut(200, function() { 
          $('#import-errors-count').text(parseInt($('#import-errors-count').text()) - 1);
          $(row).remove();
          if(!table.find('tr').length) self.loadImportFinishTable();
        });
      }
    });
    remove_trigger.off().on('click', function() {
      if($(this).hasClass('active')) {
        $(row).fadeOut(200, function() {
          if(self.matches.hasOwnProperty(group_id)) {
            self.matches_ignored.push(self.matches[group_id]);
            self.matches[group_id] = null;
          }
          $('#import-errors-count').text(parseInt($('#import-errors-count').text()) - 1);
          $(row).remove();
          if(!table.find('tr').length) self.loadImportFinishTable();
        });
      }
    });
    producer_select.off().on('change', function() {
      var mf = parseInt(producer_select.val());
      if(mf) producer_error.addClass('fixed');
      if(self.matches.hasOwnProperty(group_id)) self.matches[group_id].mf = mf;
      check_errors();
    });
    qty_trigger.off().on('click', function() {
      var qty = parseInt(qty_input.val());
      if(qty) qty_error.addClass('fixed'); 
      if(self.matches.hasOwnProperty(group_id)) self.matches[group_id].qty = qty;
      check_errors();
    });
    sku_trigger.off().on('click', function() {
      var sku = sku_input.val();
      if(sku.length > 1 && self.matches.hasOwnProperty(group_id)) {
        self.matches[group_id].sku = sku;
        find_product(row, group_id);
      }
    });
    var check_errors = function() {
      if(errors_wrapper.find('.active').length == errors_wrapper.find('.active.fixed').length) {
        if(self.matches.hasOwnProperty(group_id)) self.matches[group_id].solved = true;
        add_trigger.addClass('active');
      }
    }
  });
};

__.importDiscard = function() {
  __.cart_xls = {};
  $('#import-xls-input').val('');
  $('#import-xls-input-name').val('');
  $('#import-area').val('');
};

__.read_xls = function(e) {
  var self = this,
      rABS = false,
      files = e.target.files,
      f = files[0],
      reader = new FileReader();
  reader.onload = function(e) {
    var data = e.target.result;
    if(!rABS) data = new Uint8Array(data);
    var workbook = XLSX.read(data, {type: rABS ? 'binary' : 'array'});

    var to_array = function(workbook) {
      var result = [];
      workbook.SheetNames.forEach(function(sheetName) {
        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header:1});
        if(roa.length) {
          roa.forEach(function(list) {
            result.push(list);
          });
        }
      });
      return result;
    };

    self.cart_xls = to_array(workbook);
  };
  if(rABS) reader.readAsBinaryString(f); else reader.readAsArrayBuffer(f);
};

__.refreshCart = function()  {
  $('#cart-table').bootloader('show');
  this.ajax({a:'refresh_cart'}, function(err, res) {
    if(res) {
      $('.total_amount').html(res.cart.total);
      $('.total_vat_amount').html(res.cart.vtotal);
      $('.total_qty').html(res.cart.qty);
      $('#header-cart .price').html(res.cart.total + '&euro;');
      $('#header-cart .amount').html(res.cart.qty);
      if(typeof destroyCartTable === 'function') destroyCartTable($('#cart-table'));
      if(parseInt(res.cart.qty)) {
        $('.cart-main').show();
        $('.cart-empty-container.emptiness').hide();        
      }
      $('#cart-table tbody').html(res.cart.table);
      if(typeof initCartTable === 'function') initCartTable($('#cart-table'));
    }
    $('#cart-table').bootloader('hide');
  });
};

__.filterOrders = function() {
  $('#orders-table').bootloader('show');
  var req = {};
  req.a = 'filter_orders';
  req.start = $('#order-date-start').val();
  req.end = $('#order-date-end').val();
  req.code = $('#order-partcode').val();
  req.keyword = $('#order-keyword').val();

  this.ajax(req, function(err, res) {
    if(res) {
      $('#orders-table tbody').html(res.table);
    }
    $('#orders-table').bootloader('hide');
  });
};

__.filterDiscounts = function() {
  $('#discounts-table').bootloader('show');
  req = {};
  req.brand = $('#discounts-brand').val();
  req.group = $('#discounts-group').val();

  $('#discounts-table tbody>tr').each(function() {
    var brand = String($(this).attr('data-brand')).trim().toLowerCase(),
        group = String($(this).attr('data-group')).trim().toLowerCase();
    if(brand.startsWith(req.brand) && group.startsWith(req.group))
      $(this).show();
    else
      $(this).hide();
  });

  $('#discounts-table').bootloader('hide');
};

__.filterReset = function() {
  $('.sort-ordering [name="sort-dir"]').last().attr('checked', true);
  $('.js_dropdown-option').first().trigger('click');
};

__.filterProducts = function() {
  var code = $('#order-partcode').val();
  var sort_field = $('input[name="sort-field"]').val();
  var sort_dir = $('input[name="sort-dir"]:checked').val();

  $('#order-table>tbody>tr').each(function() {
    var partcode = String($(this).attr('data-partcode'));
    if(partcode.startsWith(code)) $(this).show();
    else $(this).hide();
  });

  $('#order-table>tbody').sort(function(a, b) {
    var aval = $(a).find('.' + sort_field).attr('data-sort');
    var bval = $(b).find('.' + sort_field).attr('data-sort');
    aval = $.isNumeric(aval) || $.isNumeric(bval) ? parseFloat(aval) : aval;
    bval = $.isNumeric(bval) || $.isNumeric(aval) ? parseFloat(bval) : bval;
    return sort_dir == 1 ? aval > bval : aval < bval;
  }).appendTo('#order-table');

  if(!$('#order-table>tbody>tr:visible').length) {
    var tr = '<tr class="empty"><td class="cell-watch" colspan="14"><div class="cell-value"><h4>Nothing were found</h4></div></td></tr>';
    $('#order-table tbody').first().prepend(tr);
  } else {
    $('#order-table tbody>tr.empty').remove();
  }
};

__.filterPricelists = function() {
  var code = String($('#filter-pricelists-input').val()).toLowerCase();
  $('#prices-table tbody>tr').each(function() {
    var partcode = String($(this).attr('data-filter')).trim().toLowerCase();
    if(partcode.startsWith(code)) $(this).show();
    else $(this).hide();
  });
};

__.removeFromOrder = function(id, event) {
  $('#order-table').bootloader('show');
  this.ajax({a:'remove_from_order', p:parseInt(id)}, function(err, res) {
    if(res) {
      var tr = $('#order-table tr[data-product="'+parseInt(id)+'"]');
      $(tr).fadeOut(300, function() {
        $(tr).next('.row-details').remove();
        $(tr).remove();
        if(!$('#order-table>tbody>tr').length)
          $('#order-table').hide(), $('.cart-empty-container').show();
      });
      $('.total_qty').html(res.order.products);
      $('.total_instock').html(res.order.instock);
      $('.total_sent').html(res.order.sent);
      $('.total_netto').html(res.order.netto);
      $('.total_brutto').html(res.order.brutto);
      $('.total_amount').html(res.order.brutto);
    }
    $('#order-table').bootloader('hide');
  });
};

__.orderImport = function(e) {
  this.cartImport(e, true);
};

__.toOrder = function(id, qty, com, vin) {
  var oid = $('#order-identifier').val();
  var increment = 1;
  if(!oid) return null;
  $(event.target).removeAttr('onclick');
  var self = this;
  var req = {
    a: 'to_order',
    o: oid,
    p: parseInt(id),
    q: isDefined(qty) ? parseInt(qty) : 1,
    c: isDefined(com) ? com : false,
    v: isDefined(vin) ? vin : false
  };
  this.ajax(req, function(err, res) {
    if(res) {
      $('#order-table').show();
      $('.cart-empty-container').hide();
      $('.total_qty').html(res.order.products);
      $('.total_instock').html(res.order.instock);
      $('.total_sent').html(res.order.sent);
      $('.total_netto').html(res.order.netto);
      $('.total_brutto').html(res.order.brutto);
      $('.total_amount').html(res.order.brutto);
      $('#order-table>tbody').append(res.tr);
      $('.js_btn-order-details').off().on('click', function(e) {
        $(this).closest('tr').toggleClass('active').next('tr').toggleClass('active');
      });
      $('#order-table>tbody td.cell-order-number').each(function() {
        $(this).attr('data-sort', increment).find('.cell-value b').text(increment);
        ++increment;
      });
    }
  });
};

__.removeOrder = function() {
  var self = this;
  var oid = $('#order-identifier').val();
  if(!oid) return null;
  event.preventDefault();
  this.ajax({a:'remove_order', o:oid}, function(err, res) {
    if(res) {
      $('.delete-order-block').html(res.message);
      setTimeout(function() { document.location.replace(self.domain + 'profile/orders') }, 3000);
    }
  });
};

__.sendContactMessage = function(e) {
  var req = {};
  var form = $(e.target).parents('form');
  var formResponse = $(e.target).siblings('.message-container').find('.message');

  formResponse.html('&nbsp;');
  form.find('label').removeClass('field-block--invalid');
  req.a = 'contact_message';
  req.n = $('#contact-form-name').val();
  req.e = $('#contact-form-email').val();
  req.m = $('#contact-form-message').val();

  if(req.n.length < 2) {
      return $('#contact-form-name').focus().parents('label').addClass('field-block--invalid');
  }
  if(!req.e.isEmail()) {
      return $('#contact-form-email').focus().parents('label').addClass('field-block--invalid');
  }
  if(req.m.length < 10) {
      return $('#contact-form-message').focus().parents('label').addClass('field-block--invalid');
  }

  $('.section-contact-form').bootloader('show');
  this.ajax(req, function(err, res) {
    if(res) {
      form[0].reset();
      formResponse.html(res.message);
    } else {
      formResponse.html(err.message);
    }
    $('.section-contact-form').bootloader('hide');
  });
};

__.stm = function(close) {
  var self = this;
  var form = $('#ticket-message-form');
  var form_error = form.find('.form-message.error');
  var req = {};
  req.action = 'send_ticket_message';
  req.close = is_defined(close) && close ? 1 : 0;
  req.message = form.find('[name="message"]').val();
  req.order = parseInt($('#ticket-chat-identify').val());

  if(req.message.length < 5 || req.message.length > 500) {
    return form.find('[name="message"]').focus();
  }

  form.bootloader('show');
  var formData = new FormData(form[0]);
  formData.append("a", req.action);
  formData.append("order", req.order);

  this.ajaxy(formData, function(err, res) {
    if(res) {
      form[0].reset();
      $('.filebox span').text('');
      self.load_ticket_chat();
    }
    form.bootloader('hide');
  });
}

__.load_ticket_chat = function(wrapper, page) {
  var wrapper = is_defined(wrapper) && wrapper.length ? wrapper : $('#ticket-chat-wrapper');
  if(!wrapper.length) return null;
  var self = this;
  var req = {};
  req.a = 'load_order_chat';
  req.page = is_defined(page) ? parseInt(page) : 1;
  req.sorting = parseInt($('input#ticket-chat-sorting').val()) || 0;
  req.ticket = parseInt($('input#ticket-chat-identify').val()) || 0;
  $('.ticket-chat-loader').bootloader('show');
  this.ajax(req, function(err, res) {
    if(res) {
      wrapper.html(res.html);
      self.init_chat_pagination(wrapper, res.pagi);
    }
    $('.ticket-chat-loader').bootloader('hide');
  });
}

__.init_chat_pagination = function(wrapper, pagi) {
  var self = this;
  self.pages_list = pagi.list;
  $('.pagination').html(pagi.html);
  $('.pagination a.link:not(.active)').each(function() {
    $(this).on('click', function() {
      var page = parseInt($(this).attr('data-page'));
      if(page && self.pages_list.includes(page)) self.load_ticket_chat(wrapper, page);
    })
  });
}

__.init_ticket_chat_form = function(wrapper) {
  if(!wrapper.length) return null;
  var self = this;
  $('input#ticket-chat-sorting').on('change', function(e) {
    e.preventDefault();
    self.load_ticket_chat(wrapper);
  });

  var socket = io('http://185.168.131.63:3000');
  socket.on('autoboxws:App\\Events\\MessageReceived', function(data) {
      var order_id = parseInt($('input#ticket-chat-identify').val());
      if(order_id == data.order_id) self.load_ticket_chat(wrapper, 1);
  });

}

/* binds */
$(document).ready(function() {
  __.init_ticket_chat_form($('#ticket-chat-wrapper'));
  __.load_ticket_chat($('#ticket-chat-wrapper'));
  $('form').find('input, textarea').on('keydown', function(e) {
    var key = String(e.key);
    if(key.match(/[а-яё]/ig)) {
      e.preventDefault();
      e.stopPropagation();
    }
  });
  $('#auth-form input').on('keyup', function(e) {
    if(e.keyCode == 13) __.auth(e);
  });
  $('#import-xls-input').on('change', function(e) {
    var self = this,
        file = $(this).prop('files')[0];
    if(file && 'name' in file) {
      var filename = file.name;
      var ext = filename.split('.').pop();
      if(!['xlsx','xls'].includes(ext)) {
        $(self).val('');
        filename = '';
      } else {
        __.read_xls(e);
      }
      $('#import-xls-input-name').val(filename);
    }
  });
  $('.phone_only').on('keypress', function(e) {
    var accepted = ['1','2','3','4','5','6','7','8','9','0','-','(',')'];
    return accepted.includes(e.key);
  });
  $('.amount_only').on('keypress', function(e) {
    var accepted = ['1','2','3','4','5','6','7','8','9','0','.'];
    return accepted.includes(e.key);
  });
  $('.captcha-view').click(function() {
    var self = this;
    $(self).attr('src', __.captcha_url + new Date().getTime());
  });
  $('.modal__window').on('open', function(e, p) {
    var modal = $('.modal__window[data-modal-type="' + p.modalType + '"]');
    if($(modal).find('.captcha-view').length) {
      setTimeout(function() {
          $(modal).find('.captcha-view').attr('src', __.captcha_url + new Date().getTime());
      }, 200);
    }
  });
  $('#search-form').on('submit', function(e) {
    e.preventDefault();
  });
  $('#search-form [type="submit"]').on({
    click: function(e) {
      var query = $('#search-form input').val();
      e.stopPropagation();
      e.preventDefault();
      if(query.length) __.search(query);
      return null;
    }
  });
  $('#search-form input').on({
    keydown: function(e) {
      var query = $('#search-form input').val();
      if(e.keyCode === 13 && query.length) {
        e.stopPropagation();
        e.preventDefault();
        __.search(query);
      }
      return null;
    }
  });
  if($('#search-form input').length && $('#search-form input').val().length)
    $('#search-form [type="submit"]').trigger('click');
});
/* binds */

/* extends & polyfills */
$.prototype.blur = function(size) {
  $(this).css({
    '-webkit-filter': size ? 'blur('+size+'px)' : '',
    '-moz-filter': size ? 'blur('+size+'px)' : '',
    '-o-filter': size ? 'blur('+size+'px)' : '',
    '-ms-filter': size ? 'blur('+size+'px)' : '',
    'filter': size ? 'blur('+size+'px)' : ''
  });
  return this;
};

$.prototype.bootloader = function(act) {
    var self = this;
    var styles =
    ".bootloader{position: absolute;top: 0;left: 0;width: 100%;height: 100%;min-height: 70px;background: rgba(0, 0, 0, 0.8);z-index: 99;text-align: center;}"+
    ".bootloader:before {content: '';display: inline-block;vertical-align: middle;height: 100%;}"+
    ".bootloader .process{vertical-align: middle;position: relative;width: auto;display: inline-block;font-size:40px;}"+
    ".bootloader .spinner{position: relative; z-index: -1; width: 100%; height: 100%; -webkit-animation: rotate 3s infinite linear;"+
    "-o-animation: rotate 3s infinite linear;-moz-animation: rotate 3s infinite linear; -ms-animation: rotate 3s infinite linear;}"+
    ".bootloader .spinner-wrapper{margin: auto;width: 123px;height: 123px;padding: 15px;background: url('/public/img/loader/1.png') right top no-repeat;}"+
    "@-webkit-keyframes rotate {from { -webkit-transform: rotate( 0deg ); } to { -webkit-transform: rotate( 360deg );}}"+
    "@keyframes rotate {from { -webkit-transform: rotate( 0deg ); } to { -webkit-transform: rotate( 360deg );}}";

    var html = '<div class="bootloader" style="display:none;">'+
                    '<style>'+styles+'</style>'+
                    '<span class="process">'+
                        '<div class="spinner-wrapper">'+
                          '<img class="spinner" src="/public/img/loader/2.png" alt="">'+
                        '</div>'+
                    '</span>'+
                '</div>';

    if(act=='show') {
        $(self).css('position','relative').find('.content').blur(2).end()
        .find('.bootloader').remove().end()
        .prepend(html).find('.bootloader').fadeIn(300);
    } else if(act=='hide') {
        $(self).css('position','relative').find('.content').blur(0).end().find('.bootloader').fadeOut(300, function() { $(this).remove() });
    }
    return self;
}

if(typeof isDefined !== "function") {
  var isDefined = function(v) {
    return typeof v !== typeof undefined;
  };
}

String.prototype.isEmail = function() {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(this);
};

if(!$.prototype.hasAttr) {
  $.prototype.hasAttr = function(attr) {
    var attr = $(this).attr(attr);
    return typeof attr !== typeof undefined && attr !== false;
  };
}

if(!$.prototype.visible) {
  $.prototype.visible = function() {
    $(this).css('visibility','visible');
    return this;
  };
}

if(!$.prototype.invisible) {
  $.prototype.invisible = function() {
    $(this).css('visibility','hidden');
    return this;
  };
}

if(!String.prototype.startsWith) {
  String.prototype.startsWith = function(str) {
    return str.length > 0 && this.substring(0, str.length) === str;
  }
}

if (!Array.prototype.includes) {
  Array.prototype.includes = function(searchElement/*, fromIndex*/) {
    'use strict';
    var O = Object(this);
    var len = parseInt(O.length) || 0;
    if (len === 0) {
      return false;
    }
    var n = parseInt(arguments[1]) || 0;
    var k;
    if (n >= 0) {
      k = n;
    } else {
      k = len + n;
      if (k < 0) {
        k = 0;
      }
    }
    while (k < len) {
      var currentElement = O[k];
      if (searchElement === currentElement ||
         (searchElement !== searchElement && currentElement !== currentElement)
      ) {
        return true;
      }
      k++;
    }
    return false;
  };
}

function is_numeric(mixed) {
  return !isNaN(mixed);
};

if(typeof is_defined !== "function") {
  var is_defined = function(mixed) {
    return typeof mixed !== typeof undefined;
  };
}

/* extends & polyfills */

'use strict';
;( function ( document, window, index )
{
  var inputs = document.querySelectorAll( '.inputfile' );
  Array.prototype.forEach.call( inputs, function( input )
  {
    var label  = input.nextElementSibling,
      labelVal = label.innerHTML;

    input.addEventListener( 'change', function( e )
    {
      var fileName = '';
      if( this.files && this.files.length > 1 )
        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
      else
        fileName = e.target.value.split( '\\' ).pop();

      if( fileName )
        label.querySelector( 'span' ).innerHTML = fileName;
      else
        label.innerHTML = labelVal;
    });

    // Firefox bug fix
    input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
    input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
  });
}( document, window, 0 ));
