$(function () {
  var num = $('#num').val();
  var page = 1;
  var timerId;

  var handelScroll = function () {
    var windowH = $(window).height();
    var contentH = $('.container').outerHeight();
    var scrollH = $(window).scrollTop();
    // 触底
    if (scrollH > contentH - windowH - 100) {
      clearTimeout(timerId);
      timerId = setTimeout(function () {
        page += 1;
        if (page > 4) {
          $(window).off('scroll', handelScroll);
          return;
        }
        $.get({url: '/index/get_more', data: {page: page}})
          .done(function (res) {
            $(res).each(function (i, v) {
              $(`<div class="album" data-id="${v.id}">
                    <div class="pic" style="background-image:url(${v.pic})"></div>
                    <div class="desc">${v.name}</div>
                    <div class="play"></div>
                 </div>`).appendTo('.container');
            })
          })
      }, 100);
    }
  };
  $(window).on('scroll', handelScroll);

  $('.button').on('touchstart', function () {
    $('.mini-player').addClass('active');
  });

  var database = [];

  $('.container').on('touchstart', '.album', function () {
    var id = $(this).attr('data-id');
    $.get('/index/get_music', {albumId: id})
      .done(function (res) {
        database = res;
        render();
      })
  })


});