// JavaScript Document
(function($){
 $.fn.extend({
 
 	customStyle : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {
	  
			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));			
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				// selectBoxSpanInner.text($(this).val()).parent().addClass('changed');   This was not ideal
			selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
				// Thanks to Juarez Filho & PaddyMurphy
			});
			
	  });
	  }
	}
 });
})(jQuery);

function testVar(value,type,error,input,invalid) {
	
	switch(type) {
		case 'empty' :
			if(value == '') {
				res = 1;
			} else {
				res = 0;
			}
		break;
		case 'notIs' : 
			if(value == invalid) {
				res = 1;
			} else {
				res = 0;
			}
		break;
		case 'isEqual' : 
			if(value != invalid) {
				res = 1;
			} else {
				res = 0;
			}
		break;
	}
	if(res == 1) {
		$('#'+error).fadeIn();	
		$('#'+input).css('border-color','#ff0000');	
	} else {
		$('#'+error).fadeOut();	
		$('#'+input).css('border-color','#01b8c0');	
	}
	return res;
}


function getCityList(state) {
		if(state != 0) {
			$.ajax({
					type: "POST",
					url: "/ajax/cityList/"+state,
					success: function(msg){
									$('#cityList').html(msg);
									$('.cityList').customStyle();
							 }
					});		
		}
}
function upPhoto() {
	//TODO VALIDATE EXTENSION
	$('#loader').css('display','block');
	$('#upload').submit();   
}

// JavaScript Document
$(document).ready(function(){
        
	$('.SelectBox').customStyle();
        $('#main').mouseover(function() {
                hideMenus();
        });
        $('#collumLeft').mouseover(function() {
                $('.floatBox').css('display','none');
        });
});

function showElement(element) {
	$(element).css('display','block');
}

//used in looks
function like(what,where) {
			$.ajax({
					type: "POST",
					url: "/ajax/addFeeling/",
					data: "feeling=like&what="+what+"&where="+where,
					success: function(msg){
                                                            if(msg == 'off') {
                                                                window.location = '/signin/likeLook-'+where;
                                                            } else {
                                                                $('.feelingBox').html(msg);
                                                            }
									
							 }
					});	
}
//used in items
function addFeeling(kind,item_id,feeling) {
	$.ajax({
		type: "POST",
		url: "/ajax/addFeeling/",
		data: "feeling="+kind+"&what="+feeling+"&where="+item_id,
		success: function(msg) {
                    if(msg == 'off') {
                        window.location = '/signin';
                    }
                }
            });
}

function unlike(what,where) {
		$.ajax({
					type: "POST",
					url: "/ajax/removeFeeling/",
					data: "feeling=like&what="+what+"&where="+where,
					success: function(msg){
									$('.feelingBox').html(msg);
							 }
					});	
}
function likeItem(what,where) {

    if( $('#likeBox-'+what).is(':visible')) {
         hide('likeBox-'+what);
    } else {
        show('likeBox-'+what);
        hide('dislikeBox-'+what);
    }
}
function dislikeItem(what,where) {
     if( $('#dislikeBox-'+what).is(':visible')) {
         hide('dislikeBox-'+what);
     } else {
         show('dislikeBox-'+what);
         hide('likeBox-'+what);
     }
}
function carrouselBack(element,limit) {
	if($('#'+element).position().left > limit) {
		$('#'+element).animate({"left": "-=200px"}, "slow");
	}
}

function carrouselNext(element) {
	if($('#'+element).position().left < 0) {	
	$('#'+element).animate({"left": "+=200px"}, "slow");
	}
}

function showcase(pager) {
	bid = $('#brand_id').val();
	$.ajax({
		type: "POST",
		url: "/ajax/showcaseList/",
		data: "pager="+pager + "&brand_id="+bid,
		success: function(msg){
					$('#itemslist').html(msg);
				}
	});
}

function showInGallery(linkimage) {
	$('#mainPicture').html('<img src="'+linkimage+'" >');
}

function nextItem(page,more) {
    goto('/admin/items/'+page+more); 
}

function buy(linkbuy) {
	goto(linkbuy);
}

function goto(golink) {
	window.location = golink;
}

function addComment() {
	var errors = 0;	
	errors = errors + testVar($('#comment').val(),'empty','errorComment','comment');
	
	if(errors == 0) {
		$('#addCommentForm').submit();
	}
}

function removeComment(comment_id,item_id) {
	$.ajax({
		type: "POST",
		url: "/ajax/removeComment/",
		data: "comment_id="+comment_id +
			  "&item_id="+item_id +
			  "&qtd="+$('#qtd').val(),
		success: function(msg){
		
					$('#qtd').val($('#qtd').val()-1);
					$('#comment-'+comment_id).css('display','none');
				}
	});	
}
function clearThis(objid) {
        if( ($('#'+objid).val() =='O que você procura?') || ($('#'+objid).val() == 'Quem você procura?') ) {
            $('#'+objid).val('');
        }
	
}
function dofollow(user_id) {
	$.ajax({
		type: "POST",
		url: "/ajax/dofollow/",
		data: "user_id="+user_id ,
		success: function(msg){
					$('#bt-'+user_id).html(msg);
				}
	});	
}

function dounfollow(user_id) {
	$.ajax({
		type: "POST",
		url: "/ajax/dounfollow/",
		data: "user_id="+user_id ,
		success: function(msg){
					$('#bt-'+user_id).html(msg);
				}
	});	
}

function addToCloset(bt_id,item_id) {
	
	$.ajax({
		type: "POST",
		url: "/ajax/addCloset/",
		data: "item_id="+item_id ,
		success: function(msg){
			$('#'+bt_id).html('Remover');
			$('#'+bt_id).attr('onClick',"removeToCloset('"+bt_id+"',"+item_id+")");
				}
	});	
}
function removeToCloset(bt_id,item_id) {
	$.ajax({
		type: "POST",
		url: "/ajax/removeCloset/",
		data: "item_id="+item_id ,
		success: function(msg){
			//$('#'+bt_id).html('Adicionar');
			//$('#'+bt_id).attr('onClick',"addToCloset('"+bt_id+"',"+item_id+")");
                        window.location ='/myCloset';   
			}
	});	
}

function doSearch(search_id,value,test) {
        if(test == 1) {
            q =   $('#searchBoxInputMain').val();
        } else {
            q =   $('#searchBoxInput').val();
        }
        if((q != 'O que você procura?') && (q != '')) {
            switch(search_id) {
                   case '0' :
                            window.location = '/all/q/'+q;
                    break;
                    case '1' :
                            window.location = '/clothes/q/'+q;
                    break;
                    case '3' :
                            window.location = '/shoes/q/'+q;
                    break;
                    case '2' :
                            window.location = '/bags/q/'+q;
                    break;
                    case '4' :
                            window.location = '/accessories/q/'+q;
                    break;
                    case '6' :
                            window.location = '/closets/id/'+q;
                    break;
            }
        } else {
            $('#searchBoxInput').css('border-color','red');
            alert('Insira o termo que deseja buscar');
        }
}


function showModal(url){
    $.ajax({
		type: "POST",
		url: url,
		success: function(msg){
			$('#modal').html(msg);
                         $('#black').fadeIn();
                        $('#modal').fadeIn();
                        $('#modalBox').fadeIn();
		}
	});
}
function closeModal(){
    $('#black').fadeOut();
    $('#modal').fadeOut();
    $('#modalBox').fadeOut();
}
function hide(item_id) {
    $('#'+item_id).fadeOut();
}
function show(item_id) {
    $('#'+item_id).fadeIn();
}
function showFloatBox(item_id) {
    myTimer=setTimeout('openFloatBox('+item_id+')', 500);
}
function clearFloat() {
    clearTimeout(myTimer);
}

function openFloatBox(item_id) {
            $('.floatBox').fadeOut();
            if($('#floatBoxView'+item_id).val() == 0) {
                     $('#floatBoxView'+item_id).attr('value',1);
                    $.ajax({
                                type: "POST",
                                url: "/app/floatBox/",
                                data: "item_id="+item_id ,
                                success: function(msg){
                                    $('#floatBox'+item_id).html(msg);
                                   $('#floatBox'+item_id).fadeIn();

                                }
                        });
        } else {
             $('#floatBoxView'+item_id).attr('value',1);
            $('#floatBox'+item_id).fadeIn();
        }


}

function closeFloater(item_id) {
    $('#floatBoxView'+item_id).attr('value',2);
      window.setTimeout('hideFloater(\''+item_id+'\')', 1000);
}

function hideFloater(item_id) {
    if($('#floatBoxView'+item_id).val() == 2) {
        $('#floatBox'+item_id).fadeOut();
    }
}

function hideDelay(menu) {
       window.setTimeout('hide(\''+menu+'\')', 5000);
}

function showMenu(menu) {
    
    switch(menu) {
        case 'fashion' :
                    hideMenus();
                    $('#itemMenuFashion').attr('class','itemMenuHover');
            break;
        case 'clothes' :
                    hideMenus();
                    show('subMenuClothes')
                    $('#itemMenuClothes').attr('class','itemMenuHover');
            break;
            case 'shoes' :
                    hideMenus();
                    show('subMenuShoes');
                    $('#itemMenuShoes').attr('class','itemMenuHover');
            break;
            case 'bags' :
                    hideMenus();
                    show('subMenuBags');
                    $('#itemMenuBags').attr('class','itemMenuHover');
            break;
            case 'accessories' :
                    hideMenus();
                    show('subMenuAccessories');
                    $('#itemMenuAcessories').attr('class','itemMenuHover');
            break;
              case 'brands' :
                    hideMenus();
                    $('#itemMenuBrands').attr('class','itemMenuHover');
            break;
              case 'social' :
                    hideMenus();
                    $('#itemMenuSocial').attr('class','itemMenuHover');
            break;
              case 'myCloset' :
                    hideMenus();
                    $('#itemMenuMyCloset').attr('class','itemMenuHover');
            break;
    }

}

function hideMenus() {
        hide('subMenuClothes');
        hide('subMenuShoes');
        hide('subMenuBags');
        hide('subMenuAccessories')
        $('#itemMenuClothes').attr('class','itemMenu');
        $('#itemMenuShoes').attr('class','itemMenu');
        $('#itemMenuBags').attr('class','itemMenu');
        $('#itemMenuAcessories').attr('class','itemMenu');
         $('#itemMenuFashion').attr('class','itemMenu');
         $('#itemMenuBrands').attr('class','itemMenu');
         $('#itemMenuSocial').attr('class','itemMenu');
         $('#itemMenuMyCloset').attr('class','itemMenu');
}

function limitText(text,limit,id) {
    if(text.length > 250) {
        $('#'+id).attr('value',text.substring(0,250));
    }
}

function resendPass() {
    if($('#email').val() == '') {
        $('#email').css('border-color','red');
    } else {
        $('#resend-pass').submit();
    }
}

function saveNewPass() {
    if(($('#pass').val() == '') || ($('#pass').val() !=$('#repass').val())) {
        $('#errorLogin').css('display','inline-block');
        $('#pass').css('border-color', 'red');
        $('#repass').css('border-color', 'red');
    } else {
        $('#form').submit();
    }
}

function userItemList(pager) {
        line_id =$('#line').attr('value');
	model_id = $('#model').attr('value')
        uid =  $('#user_id').attr('value')
	$.ajax({
		type: "POST",
		url: "/ajax/showUserItemsList/",
		data: "pager="+pager + "&user_id="+uid+"&line="+line_id+ "&model="+model_id,
		success: function(msg){
					$('#itemslist').html(msg);
				}
	});
}

function sendPrivacy() {
    $('#formPrivacy').submit();
}

//Hide all brand floaters
function hideBrandFloaters() {
    $('.floatBrand').fadeOut();
}

function sendClosetByMail() {
    sucessModal();
}

function sucessModal() {
    $.ajax({
        type: "POST",
        url: "/app/sucessModal",
        success: function(msg){
                $('#containerModal').html(msg);
        }
     });
}

function selectColor() {
    $('#selectorColor').fadeIn();
}
function closeSelectColor() {
    $('#selectorColor').fadeOut();
}
function sendForm() {
       $('#form').submit();
}
function addNewItem() {
        if($('#users_id').val() == 0) {
                alert('Selecione uma marca');
        } else {
                sendForm();
        }
}

function importProduct(sku,row) {
        merchant = $('#store').val();

	$.ajax({
        type: "POST",
        url: "/admin/ajaxImport", 
        data: "sku="+sku + "&row="+row+ "&merchant="+merchant,
        success: function(msg){	
                
			if(msg == 'ok') {
				hideRow(row)
			} else {
				$('#debugAjax').html(msg);
			}   
        }
     });
}
function hideRow(row) {
	$('#tbl_row_'+row).fadeOut(500);
}


function validatePrice(amount) {

    num = amount.replace(',','.');
    num = isNaN(num) || num === '' || num === null ? 0.00 : num; 
    value = parseFloat(num).toFixed(2);
    
    $('#price').attr('value',value);
}

function editItem() {
    if($('#modelo1').val() == 0) {
       alert('Selecione uma categoria');     
    } else {
              if($('#cor1').val() == 0) {
                  alert('Selecione uma cor');   
              }  else {
                  $('#form').submit();    
              }
     }   
}

function addMidia() {
  alert($('#uploadPhoto').attr('class'));
  $('#uploadPhoto').submit();
}


function filterItems(line_id) {
        $.ajax({
                type: "POST",
                url: "/admin/filterItems", 
		data: "line_id="+line_id,
        success: function(msg){	
                
                if(msg == 'ok') {
                        window.location.reload(true);
                }  
        }
     });
}

function filterItemsModel(model_id) {
        $.ajax({
                type: "POST",
                url: "/admin/filterItemsModel", 
		data: "model_id="+model_id,
        success: function(msg){	
                
                if(msg == 'ok') {
                        window.location.reload(true);
                }  
        }
     });
}

function filterItemsFormat(format_id) {
        $.ajax({
                type: "POST",
                url: "/admin/filterItemsFormat", 
		data: "format_id="+format_id,
        success: function(msg){	
                
                if(msg == 'ok') {
                        window.location.reload(true);
                }  
        }
     });
}

function aproveItem(item_id,row) {
        $('#itemsList_row_'+row).hide();
        $.ajax({
                type: "POST",
                url: "/admin/aproveItem", 
		data: "item_id="+item_id,
        success: function(msg){	
              
     
        }
     });
}

function reproveItem(item_id,row) {
         $('#itemsList_row_'+row).hide();
        $.ajax({
                type: "POST",
                url: "/admin/reproveItem", 
		data: "item_id="+item_id,
        success: function(msg){	
              
        }
     });
}




