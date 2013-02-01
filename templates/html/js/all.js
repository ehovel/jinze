$(document).ready(function(){
	 /* all=============all */
	 
		//outline
	$(".thumbnail a,.productInfo .btn_addnew,#logo a,.txt_btn").bind("focus",function(){
		if(this.blur){
			this.blur();
		};
	});	
	
		//remind_close
	$(".remind_close").click(function(){
		$(this).parent(".remind").hide();
	});
	
		//img hover border
	$(".equExh  li .img170").hover(function(){
		$(this).addClass("hoverImg");
	},function(){
		$(this).removeClass("hoverImg");
	});
	
		//popoUp close
	$(".popoUp .btn_close").click(function(){
		$(this).parent(".popoUp").hide();
	});
	$(".popoUp .btn_close").hover(function(){
		 $(this).addClass("btn_close_hover");
	},function(){
		$(this).removeClass("btn_close_hover");		
	});
		//filter	
	var timeFilterHover,timeFilterOut;
	$(".filter .select_item").hover(function(){
		_this = $(this);
		clearTimeout(timeFilterOut);
		timeFilterHover = setTimeout(function(){
			_this.find(".select_list").show().parents(".filter_tools_item").siblings().find(".select_list").hide()
		},120);
	},function(){
		clearTimeout(timeFilterHover);
		timeFilterOut = setTimeout(function(){
			_this.find(".select_list").hide();
		},350);
	})
	
	
		//btn hover
	$(".txt_btn").hover(function(){
		$(this).addClass("txt_btn_hover");
	},function(){
		$(this).removeClass("txt_btn_hover");
	})
	
		//newsletter pop
	var timer;
	$("#JS_newsletter_pop_link").click(function(){
		$("#JS_newsletter_pop").slideToggle();
	});
	
	$("#JS_newsletter_pop").hover(function(){
		clearTimeout(timer);
	},function(){
		timer = setTimeout(function(){
			$("#JS_newsletter_pop").slideUp();
		},5000)
	})
	
		$("#JS_newsletter_pop .btn_close").click(function(){
		$("#JS_newsletter_pop").slideUp();
	});

		//inquiry_fill
	$(".inquiry_fill .btnMoreoption").click(function(){
		$(this).toggleClass("btnMoreoptionHide");
		if($(this).text()=="More options"){
			$(this).text("Hide options");
		}else{
			$(this).text("More options");
		}
		$(".inquiry_fill .moreoptions").slideToggle(100);
		return false;
	})
		//validate
	$("#form_validate").validate({
        errorClass: 'error'
    });	
	
		//form input foucs
	$(".forms input,.forms .input_text,.forms .text,.forms textarea").focusin(function() {
  	$(this).addClass("input_focus");
	});
	$(".forms input,.forms .input_text,.forms .text,.forms  textarea").focusout(function() {
  	$(this).removeClass("input_focus");
	});


		//index cat carousel
	$("#indexProSlide").carousel({
			btnNext: ".index_pro .next",
			btnPrev: ".index_pro .prev",
			scrolls:1,
			auto:false,
			circular: false,
			visible:5
		});


		//promo
	$("#promo a").addClass("bigimg");
	$("#promo .bigimg img").banner_thaw({
		thumbObj:"#promo ul li",
		thumbNowClass:"current",
		changeTime:3000
	});
	
	
		//gallery
	$(".zoom").zoom({
		xzoom: 300,
		yzoom: 300,
		offset: 10,
		position: "right",
		lens:1
	});
	
	if($(".thumbnail_slide > ul > li").length > 0){
		$(".thumbnail_slide").carousel({
			btnNext: ".thumbnail .next",
			btnPrev: ".thumbnail .prev",
			scrolls:1,
			auto:false,
			mouseWheel: true,
			circular: false,
			visible:5
		}).mousewheel(function(){
			return false;
		});
	}
	
	var small_img = 40;
	var mid_img = 300;
	$(".thumbnail ul li:first").addClass("hover");
	var thumbTimeHover,thumbTimeOut;
	$(".thumbnail ul li").hover(function(){
		var _this=$(this);
		clearTimeout(thumbTimeOut);
		thumbTimeHover = setTimeout(function(){
			_this.addClass("hover").siblings().removeClass("hover");
			$("#picture").attr("src",_this.find('img').attr("src").replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
			$("#picture").attr("big",_this.find('img').attr("src").replace("_" + small_img + "x" + small_img,""));
		},150)
    },function(){
		var _this=$(this);
		clearTimeout(thumbTimeHover);
    });
	$(".thumbnail ul li").click(function(){
		return false;
	})
	
		//comments
	$("a[name='do_show_review_form']").unbind().bind('click keyup',function(e){
		$("#detail").find('.tab_content > div:first').css({display: "none"}); 
		$("#detail .tab_holder li").attr("className","");
		$("div.sendInquiry").show();
		$("div.sendInquiry").css({display: "block"}); 
		$("#detail #JS_sendInquiry_tab").attr("className","current");		
		var targetOffset = $("div.sendInquiry").offset().top;
        $('html,body').animate({scrollTop: targetOffset}, 1000);
		return false;
	});
	
	
		//detail tab
	$(".tab_holder > li").each(function(index){
		$(".tab_holder > li:first").addClass("current");
		$(".tab_content .tab_panel:first").show();
		$(".tab_content .tab_panel").not(":first").hide();
		$(this).click(function(){
			var _this=this;
			$(_this).addClass("current").siblings().removeClass("current");
			$(_this).parent(".tab_holder").siblings(".tab_content").find(".tab_panel").eq(index).show().siblings().hide();
		})
	});
	
	 $("a.lightbox").lightBox();
	 
		//Payment productInfo
	var counter = 0;
	$(".productInfo .btn_addnew").click(function(){
		counter++;
		var _str = '<li><div class="item item_sku"><label class="label" for="detail_'+counter+'">SKU:<b>*</b></label><input type="text" id="detail_'+counter+'" name="sku[]" class="input_text input_text_sku required" /></div><div class="item"><label class="label" for="qty_detail_'+counter+'">Qty:<b>*</b></label><input type="text" id="qty_detail_'+counter+'" name="qty[]" value="1" class="input_text input_text_qty" onkeyup="clearNoNum(this)" onblur="check_qty(this);"  maxlength="100" /></div><div id="product_detail_'+counter+'" class="item item_action"><span class="pro_delete icon btn">&chi;</span></div></li>';
		$(".productInfo ul").append(_str);
		return false;
	});
	$(".productInfo .pro_delete").live("click",function(){
		$(this).parent(".item_action").parent("li").remove();
	});
	
				//certification carousel
	$(".certImg").carousel({
			btnNext: ".certImgBox .next",
			btnPrev: ".certImgBox .prev",
			scrolls:1,
			auto:false,
			circular: false,
			visible:5
		});
	
		//product small to big
	$(".certImg li").click(function(){
		$(this).addClass("selected").siblings().removeClass("selected");													
		$(".certBigImg").find("img").attr("src",$(this).find("img").attr("src").replace("small","big"));
		$(".certBigImg a").attr("href",$(this).find("img").attr("src").replace("small","big"));
        return false;
    });




})