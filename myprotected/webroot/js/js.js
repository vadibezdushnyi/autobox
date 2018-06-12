//** ZEN JS **//
	var body_w = "100%";
	var body_h = "100%;"
	var right_zone_w = "100%";
	var standart_w = 1920;
	
	var filters_visible_count = 0;
	var f_1,f_2,f_3 = false;
	
	function on_start()
	{
		var win_w = window.innerWidth; 
		var win_h = window.innerHeight;
		
		if(win_w == undefined){//alert('IE w = '+document.body.clientWidth);
			win_w = document.body.clientWidth;
		}
		if(win_h == undefined){//alert('IE h = '+document.body.clientHeight);
			win_h = document.documentElement.offsetHeight-4;
		}
		
		body_h = (win_h-100)+'px';
		right_zone_w = (win_w-370)+'px';
	
		if(win_w >= 1920)
		{
			body_w = standart_w+"px";
			right_zone_w = (standart_w-370)+'px';
		}else
		{
			//$('.r-z-h-saving').css('margin-right','33px');
		}
		
		//$('body,html').css('width',body_w);
		 
		$('#l-z-right-menu').css('min-height',body_h);  
		$('#r-z-header').css('width',right_zone_w);
		
		$('#left-zone').css('height',win_h);
		$('#right-zone').css('min-height',win_h);
	}
	
	function reset_filter_params()
	{
		
		$('#filtr-wrap').hide();
		$('.top-filtr').hide();
		$('#but-sort-1').removeClass('r-z-h-f-search-active');
		$('#but-sort-2').removeClass('r-z-h-f-filling-active');
		$('#but-sort-3').removeClass('r-z-h-f-sorting-active');
		filters_visible_count = 0;
		f_1 = false;
		f_2 = false;
		f_3 = false;
		
		$.cookie('filter-1',0);
		$.cookie('filter-2',0);
		$.cookie('filter-3',0);
		
		
		//$('#wp-filtr-form select option')[0].prop('selected', true);
	}
	
	function open_filtr(id_number)
	{
		$('#filtr-wrap').css('border','1px solid #CCC');
		
		switch(id_number)
		{
			case 1: 
			{
				if(f_1)
				{
					f_1 = false;
					$.cookie('filter-1',0);
					filters_visible_count--;
					$('#filtr-'+id_number).hide();
					$('#but-sort-'+id_number).removeClass('r-z-h-f-search-active');
				}else
				{
					$.cookie('filter-1',1);
					f_1 = true;
					filters_visible_count++;
					$('#filtr-'+id_number).show();
					$('#but-sort-'+id_number).addClass('r-z-h-f-search-active');
				}
				break;
			}
			case 2: 
			{
				if(f_2)
				{
					f_2 = false;
					$.cookie('filter-2',0);
					filters_visible_count--;
					$('#filtr-'+id_number).hide();
					$('#but-sort-'+id_number).removeClass('r-z-h-f-filling-active');
				}else
				{
					f_2 = true;
					$.cookie('filter-2',1);
					filters_visible_count++;
					$('#filtr-'+id_number).show();
					$('#but-sort-'+id_number).addClass('r-z-h-f-filling-active');
				}
				break;
			}
			case 3: 
			{
				if(f_3)
				{
					f_3 = false;
					$.cookie('filter-3',0);
					filters_visible_count--;
					$('#filtr-'+id_number).hide();
					$('#but-sort-'+id_number).removeClass('r-z-h-f-sorting-active');
				}else
				{
					f_3 = true;
					$.cookie('filter-3',1);
					filters_visible_count++;
					$('#filtr-'+id_number).show();
					$('#but-sort-'+id_number).addClass('r-z-h-f-sorting-active');
				}
				break;
			}
			default : break;
		}
		if(filters_visible_count == 0)
		{
			$('#filtr-wrap').hide();
		}else
		{
			$('#filtr-wrap').show();
		}
	}
	
	function update_cat_pos(id,pos)
	{
		$("body").css("cursor", "progress");
		
		$.post("split/ajax/heandlers/indexHeandler.php",{action:"updateCatPos",id:id,pos:pos},function(data,status){
				if(status=='success')
				{
					$('#cat_pos_'+id).css('border-color','blue');
					setTimeout(function(){ $('#cat_pos_'+id).css('border-color','#ccc'); },200);
					setTimeout(function(){ $('#cat_pos_'+id).css('border-color','blue'); },400);
					setTimeout(function(){ $('#cat_pos_'+id).css('border-color','#ccc'); },600);
					setTimeout(function(){ $('#cat_pos_'+id).css('border-color','blue'); },800);
					setTimeout(function(){ $('#cat_pos_'+id).css('border-color','#ccc'); },1000);
				}
				$("body").css("cursor", "auto");
			},"json");
	}