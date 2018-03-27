(function() {
  'use strict';
  document.body.addEventListener('click', copy, true);

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

$(document).ready(function() {
  var inlinerUrl = $('#inliner_url').val();
  var permalink = $('#permalink').val();

  $.ajax({
    method: 'GET',
    url: inlinerUrl,
    data: {
      url: permalink,
    },
    success: function(res) {
      $('#inlined_text').val(res.html.replace(/\\/g, ''));
    },
    error: function(err) {
      $('#inlined_text').val(JSON.stringify(err));
    }
  })
});