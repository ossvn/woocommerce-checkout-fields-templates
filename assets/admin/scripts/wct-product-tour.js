(function($) {
  "use strict";
  
  if ( typeof wct_step === 'undefined' || wct_step == '' ) {
    return false;
  }

  var tour = wct_tour;

  function init_tour(){

    var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();

    if (state && state.indexOf('wct-product-tour:') === 0) {
      // Already started the tour at some point!
      hopscotch.startTour(tour);

    }else{

        if($('#ossvn-admin-header').length){$('html,body').animate({scrollTop: $("#ossvn-admin-header").offset().top},'slow');}
        mgr.removeAllCallouts();
        hopscotch.startTour(tour);

    }
  }

  hopscotch.registerHelper('wct_hopscotch_end', function() {

    var ajax_url = ossvn_ajax_url.ajax_url,
    tour_done = 'aaa',
    step = wct_step;
    $.ajax({
      type: 'POST',
      url: ajax_url,
      data: {
        action: 'save_product_tour',
        tour_done: tour_done,
        step: step
      },
      
      success: function(data)
      {
        //console.log(step);
        ///done
      }

    });

  });

  $(document).ready(function() {

    init_tour();

  });

})(jQuery);