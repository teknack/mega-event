$(document).ready(function(){

/* Button which shows and hides div with a id of "post-details" */
$( ".toggle-visibility" ).click(function() {

  var target_selector = $(this).attr('data-target');
  var $target = $( target_selector );

  if ($target.is(':hidden'))
  {
    $target.show();
  }
  else
  {
    $target.hide();
  }

  console.log($target.is(':hidden'));
  });
});
