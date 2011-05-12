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

 function backendPluginFormLoad(showStandby_marginTop,sectionToReplace){

}



 var byPassKeyUp=false;

 $("#submitForm :input").live('keyup',function(buttonPressed){
 
  if (!byPassKeyUp){
   var nameOfInput=$(this).attr("name");
   var keyCode=buttonPressed.keyCode;

   // PREVIEW PANE
   if (nameOfInput=="keywords"){
   $("#previewPane").css("display","inline");
   var temp=$(this).val().split("\n");
   var temp1="";
   $(temp).each(function(index,value){
    temp1=temp1+"<li>"+value;
   });
   $("#previewPane").html("<p>Your Keyword Phrases</p><ol>"+temp1+"</ol>");
  }
  
   // CHARS LEFT
   if ($(this).siblings("h2").find("span").html() && $(this).data("maxChars")){
   var maxChars=$(this).data("maxChars");
   var charsRemaining=maxChars-$(this).val().length;
   if (charsRemaining<1) charsRemaining=0;
   $(this).siblings("h2").find("span").html("Chars Left: "+charsRemaining);
  }
  
   // CHECK THIS
   if($(this).data("checkThis")){
    var error="";
    if ($(this).data("checkThis")=="URL"){
    var baseURL=$(this).val();
    if (baseURL.substring(0,7)!="http://"){
     error="URL must begin with http://";
    } else if (!/^(http):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(baseURL)){
     error="Invalid URL";
    }
   }
    if ($(this).data("minChars")){
    threshold=$(this).data("minChars");
    currentValue=$(this).val().length;
    if (currentValue<threshold){
     error="Too short (Minimum "+threshold+" characters, you have "+currentValue+")";
    }
   }
    if ($(this).data("maxChars")){
    threshold=$(this).data("maxChars");
    currentValue=$(this).val().length;
    if (currentValue>threshold){
     error="Too long (No more than "+threshold+" characters)";
    }
   }
    if ($(this).data("minLines")){
    threshold=$(this).data("minLines");
    temp=$(this).val().split("\n");
    currentValue=temp.length;
    if (currentValue<threshold){
     error="Not enough. (Must have at least "+threshold+" lines)";
    }
   }
   
    if (!error){
    var proceedToExternalValidateThis=false;
    var externallyValidateAfter=$(this).data("externallyValidateAfter");
    if (externallyValidateAfter=="linefeed" && buttonPressed.keyCode==13){
     error=proceedToExternalValidateThis();
    } 
   }
    if (error){
    validateFail($(this),error);
   } else {
     validatePass($(this));
    } 
   }
  } else {
   byPassKeyUp=false;
  } 
 }); 
 $("#signupNavBar a").live('click',function(e){
  e.preventDefault();
  byPassKeyUp=false;
  $("#submitForm input[name='goTo']").val($(this).data("goTo"));
  $("#submitForm input[name='subGoTo']").val($(this).data("subGoTo"));
  backendPluginFormLoad("100","#submitForm","#homePageDiv");
 });
 $("#submitForm").live('submit',function(e){
  e.preventDefault();
  byPassKeyUp=true; // IN CASE USER HITS ENTER TO SUBMIT THE FORM
  var anyProblems=false;
  var error="";
  $("#submitForm div").children(":input").each(function(){
   if($(this).data("checkThis")){
    if ($(this).data("externallyValidateAfter")=="submitButton"){
     validateFail($(this),"Confirming URL");
     var temp=$.ajax({
      type: 'POST',
      url: adminAjaxDir+"?_wpnonce="+$("#_wpnonce").val(),
      async: false,
      data: { action: 'stearns_AJAX_handler', goTo: 'validateSignupEntry', subGoTo: $(this).attr("name"), additionalParams: $(this).attr("value") },
     }).responseText;
     var temp1=temp.split("|||");
     var error=temp1[1];
     if (error=="valid"){
      validatePass($(this));
     } else {
      validateFail($(this),error);
     } 
    }
    var pColor=rgb2hex($(this).siblings("p").css("color"));
    if (pColor=="#BD1A00") anyProblems=true;
   }
  }); 
  if (!anyProblems) backendPluginFormLoad("100","submitForm","#homePageDiv");
 });
 $("#showVideoButton").live('click',function(e){
  e.preventDefault();
  subGoTo=$(this).parent().attr('helpBox');
  $("#helpBox_BG").css("display","block");
  $("#helpBox_BG").show("blind","slow",function(){
   $("#helpBox_FG").css("display","block");
   $("#helpBox_FG").css("left",($(window).width()-$("#helpBox_FG").outerWidth())/2);
   backendPluginSimpleLoad('250','helpBoxContent',subGoTo,'#helpBox_FG');
  });
 }); 
 $("#xOut").live('click',function(e){
  e.preventDefault(e);
  $("#helpBox_BG").css("display","none");
  $("#helpBox_FG").css("display","none");
 }); 

});
