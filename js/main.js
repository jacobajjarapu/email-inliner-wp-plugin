(function() {
  'use strict';
  document.getElementById('copy_btn').addEventListener('click', copy, true);
  
  function copy(e) {
    e.preventDefault();
    var t = e.target;
    var c = t.dataset.copytarget;
    var inp = (c ? document.querySelector(c): null);

    if (inp && inp.select) {
      inp.select();
      try {
        document.execCommand('copy');
        inp.blur();
        t.innerHTML = 'Copied';
        t.style.backgroundColor = '#00C642';
        setTimeout(function() {
          t.innerHTML = 'Copy'
          t.style.backgroundColor = 'rgba(0,0,0,0.4)';
        }, 3000);
      } catch(err) {
        alert('please press Ctrl/Cmd+C to copy');
      }
    }
  }
})();

jQuery(document).ready(function($){
  var inlinerUrl = $('#inliner_url').val();
  var permalink = $('#permalink').val();

  $.ajax({
    method: 'GET',
    url: inlinerUrl,
    data: {
      url: permalink,
    },
    success: function(res) {
      var result = res.html;
      
      result = result.replace(/\\/g, '');
      result = result.replace(/’/g, '\'');
      result = result.replace(/\s&\s/g, ' &amp; ');
      result = result.replace('…', '&hellip;');
      result = result.replace('https://fonts.googleapis.com/css?family=Lato:400,700,400italic', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,700;0,800;0,900;1,500;1,700;1,800;1,900&display=swap');

      
      $('#inlined_text').val(result);
    },
    error: function(err) {
      $('#inlined_text').val(JSON.stringify(err));
    }
  })
});
