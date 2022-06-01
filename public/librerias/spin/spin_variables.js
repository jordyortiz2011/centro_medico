  
  //PERSONALZACIÓN DE SPIN 1
  var SPIN_OPT1 = {
                  lines: 13 // The number of lines to draw
                , length: 28 // The length of each line
                , width: 14 // The line thickness
                , radius: 42 // The radius of the inner circle
                , scale: 1 // Scales overall size of the spinner
                , corners: 1 // Corner roundness (0..1)
                , color: '#000' // #rgb or #rrggbb or array of colors
                , opacity: 0.25 // Opacity of the lines
                , rotate: 0 // The rotation offset
                , direction: 1 // 1: clockwise, -1: counterclockwise
                , speed: 1 // Rounds per second
                , trail: 60 // Afterglow percentage
                , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
                , zIndex: 2e9 // The z-index (defaults to 2000000000)
                , className: 'spinner' // The CSS class to assign to the spinner
                , top: '50%' // Top position relative to parent
                , left: '50%' // Left position relative to parent
                , shadow: false // Whether to render a shadow
                , hwaccel: false // Whether to use hardware acceleration
                , position: 'absolute' // Element positioning
    };

  //PERSONALZACIÓN DE SPIN 2 PEQUEÑO
  var SPIN_OPT2 = {
      lines: 6, // The number of lines to draw
      length: 0, // The length of each line
      width: 17, // The line thickness
      radius: 29, // The radius of the inner circle
      scale: 0.3, // Scales overall size of the spinner
      corners: 0.6, // Corner roundness (0..1)
      color: '#ff0000', // CSS color or array of colors
      fadeColor: 'transparent', // CSS color or array of colors
      speed: 0.8, // Rounds per second
      rotate: 29, // The rotation offset
      animation: 'spinner-line-fade-more', // The CSS animation name for the lines
      direction: 1, // 1: clockwise, -1: counterclockwise
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      className: 'spinner', // The CSS class to assign to the spinner
      top: '36%', // Top position relative to parent
      left: '50%', // Left position relative to parent
      shadow: '0 0 1px transparent', // Box-shadow for the lines
      position: 'absolute' // Element positioning
  };