//////////////////////////////
$(function () {
  // function AudioPlay() {
  //   this.audio = '';
  //   this.database = '';
  //   this.current = '';
  //   this.nexButton = $('.next');
  //   this.init();
  // }
  //
  // AudioPlay.prototype.init = function () {
  //   this.nextButton.on('click', this.next);
  // }
  // AudioPlay.prototype.next = function () {
  //
  // }
  // AudioPlay.prototype.prev = function () {
  //
  // }
  //
  // new AudioPlay();

  // 选择合适的数据结构
  // web开发的数据结构都被各种各样的数据库接手
  // 表

  var audio = $("#audio").get(0);
  var database = [
    {id: 1, name: '歌曲1', artist: '歌手1', src: '1.mp3'},
    {id: 2, name: '歌曲2', artist: '歌手2', src: '2.mp3'},
    {id: 3, name: '歌曲3', artist: '歌手3', src: '3.mp3'},
    {id: 4, name: '歌曲4', artist: '歌手4', src: '4.mp3'}
  ];
  var current = 0;
  audio.src = database[current].src;

  ////////////////////////
  $(database).each(function (i, v) {
    $(`
      <li>
        <span>${v.name}</span>
        <div class="delete">x</div>
      </li>
    `).appendTo('#play-list');
  });

  ///////////////////////////////
  var playList = $('#play-list');
  playList.on('click', 'li', function () {
    current = $(this).index();
    audio.src = database[current].src;
    audio.play();
  });

  ////////////////////////
  function display() {
    if (database.length) {
      $('.info .song').html(database[current].name);
      $('.info .artist').html(database[current].artist);
      playList.find('li').removeClass('active')
        .eq(current).addClass('active');
    } else {
      $('.info .song').html('');
      $('.info .artist').html('');
    }
  }

  $(audio).on('play', display);

  /////////////////////////////////

  function prev() {
    current -= 1;
    current = current < 0 ? database.length - 1 : current;
    audio.src = database[current].src;
    audio.play();
  }

  function next() {
    current += 1;
    current = current === database.length ? 0 : current;
    audio.src = database[current].src;
    audio.play();
  }

  $('.prev').on('click', prev);

  $('.next').on('click', next);

  ///////////////////////////////////////////////
  playList.on('click', '.delete', function () {
    var li = $(this).closest('li');
    var index = li.index();
    li.remove();
    database.splice(index, 1);
    if (index > current) {
      ///
    } else if (index === current) {
      if (database.length) {
        current -= 1;
        next();
      } else {
        audio.src = '';
        current = null;
        display();
      }
    } else if (index < current) {
      current -= 1;
    }
    return false;
  });

});