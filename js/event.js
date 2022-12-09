$('.button').click(function(e){
  var $btn = $(this),
  $step = $btn.parents('.modal-body'),
  $stepIndex = $step.index(),
  $pag = $('.modal-header span').eq($stepIndex);
  
  console.log("Etape : " + $step.index());
  
  if ($step.index() === 0) {
    var nomEvent = document.querySelector("#nomEvenement-1").value;
    var nomClient = document.querySelector("#nomClient-1").value;
    var commentaire = document.querySelector("#commentaires-1").value;
    
      document.querySelector("#nomEvenement-2").value = nomEvent;
      document.querySelector("#nomClient-2").value = nomClient;
      document.querySelector("#commentaires-2").value = commentaire;
  
    // console.log(document.querySelector("#select-metier2").value);
  }
  
  if($step.index() < 2) {
    step1($step, $pag);
  } else {
    step3($step, $pag);
  }

});
  
function step1($step, $pag){
  //console.log("function step 1 " + 'step1');
  // animate the step out
  $step.addClass('animate-out');
    
  // animate the step in
  setTimeout(function(){
    $step.removeClass('animate-out is-showing')
    .next().addClass('animate-in');
    $pag.removeClass('is-active bg_orange')
    .next().addClass('is-active bg_orange');
  }, 600);
    
    // after the animation, adjust the classes
  setTimeout(function(){
    $step.next().removeClass('animate-in')
    .addClass('is-showing');
      
  }, 1200);
}
  
function step3($step, $pag){
  console.log('3');
  
  // animate the step out
  $step.parents('.modal-wrap').addClass('animate-up');
  
  setTimeout(function(){
    $('.rerun-button').css('display', 'inline-block');
  }, 300);
}
  
$('.rerun-button').click(function(){
  $('.modal-wrap').removeClass('animate-up')
  .find('.modal-body')
  .first().addClass('is-showing')
  .siblings().removeClass('is-showing');
  $('.modal-header span').first().addClass('is-active bg_orange')
  .siblings().removeClass('is-active bg_orange');
  $(this).hide();
});
  