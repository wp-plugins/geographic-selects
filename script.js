jQuery(document).ready(function($) {
 var adminAjaxDir=$("#adminAjaxLoc").val();

 $("#geographicSelectsOptions :input").live('click',function(e){
  e.preventDefault();
  if ($(this).attr("name")=="addCountryToOptGroup") return;
  var currentForm=$(this).parents("form").attr("name");
  var params={};

  $("#"+currentForm+" :input").not(":input[type=radio][checked=false]").not(":input[type=checkbox][checked=false]").each(function(index,value){
   params[$(value).attr("name")]=$(value).val();
  });
  
  params["formName"]=currentForm;
  
  imageMarginLeft=Math.round((parseInt($("#"+currentForm+"_div").css('width'))-220)/2);
  $("#"+currentForm+"_div").html('<p style=\"color: #5F818A; font-size: 25px; text-align: center; padding-top: 25px;\">Standby...</p>');

  params['action']='geographicSelects_AJAX_handler';	

  $("#"+currentForm+"_div").load(adminAjaxDir,params, function(response, status, xhr) {
   if (status=="error") $("#"+currentForm+"_div").html('Sorry, your browser is having trouble communicating with our server at this time.');
  });

 });
});
