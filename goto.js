// JavaScript Document
$(function(){
	/*
	$("#top").click(function(){

		//$("html,body").animate({scrollTop:500px},900);
	
		$("html,body").animate({scrollTop:0},900,"easeOutBounce");

		return false;

	});
	*/
	$('#toA').click(function(){
	$('html,body').animate({scrollTop:$('#A_class').offset().top}, 800);	
	}); //代表一個完整的執行區塊
	
	$('#toB').click(function(){
	$('html,body').animate({scrollTop:$('#B_class').offset().top}, 800); 
	}); 
	
	$('#toC').click(function(){
	$('html,body').animate({scrollTop:$('#C_class').offset().top}, 800); 
	}); 
	
	$('#toF').click(function(){
	$('html,body').animate({scrollTop:$('#F_class').offset().top}, 800); 
	}); 
	
	$('#toG').click(function(){
	$('html,body').animate({scrollTop:$('#G_class').offset().top}, 800); 
	}); 
	
	$('#toH').click(function(){
	$('html,body').animate({scrollTop:$('#H_class').offset().top}, 800)
	}); 
	
	$('#toI').click(function(){
	$('html,body').animate({scrollTop:$('#I_class').offset().top}, 800)
	}); 
	
	$('#toJ').click(function(){
	$('html,body').animate({scrollTop:$('#J_class').offset().top}, 800)
	}); 
	
	$('#toK').click(function(){
	$('html,body').animate({scrollTop:$('#K_class').offset().top}, 800)
	}); 
	
	$('#toL').click(function(){
	$('html,body').animate({scrollTop:$('#L_class').offset().top}, 800)
	}); 
	
	$('#toM').click(function(){
	$('html,body').animate({scrollTop:$('#M_class').offset().top}, 800)
	}); 
	
	
	
	$("#up").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	$("#up2").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	
	$("#up3").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	
	$("#up4").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	
	$("#up5").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	
	$("#up6").click(function(){

		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
			$body.animate({
				scrollTop: 0
			}, 600);

		return false;

	})
	
});
