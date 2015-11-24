(function ($, Drupal) {

  "use strict";

  Drupal.localfav = Drupal.localfav || {};

  Drupal.theme.hcBlockContent = function () {
    return '<div class="block" id="block-favorite"><h2>Your favorite</h2><div class="content"></div></div>';
  };

  Drupal.localfav.generateFavList = function (localFavsData) {
    // Get data from the localStorage if their are not provided.
    if (typeof localFavsData === 'undefined') {
      var localFavsSerial = localStorage.getItem('Drupal.localFavs');
      if (localFavsSerial) {
        localFavsData = JSON.parse(localFavsSerial);
      }
    }
    if (localFavsData) {
      var list = document.createElement('ul');
      localFavsData.forEach(function (fav) {
        var item = document.createElement('li');
        item.innerHTML = fav;
        list.appendChild(item);
      });
      $('#sidebar-first .region-sidebar-first #block-favorite .content').append(list);
    }
  };

  /**
   * Add favorite link before titles.
   */
  Drupal.behaviors.setLocalFavorite = {
    attach: function (context, settings) {
      // Add the favorite block.
      if (!document.getElementById('block-favorite')) {
        $('#sidebar-first .region-sidebar-first').append(Drupal.theme('hcBlockContent'));
        Drupal.localfav.generateFavList();
      }
      // Add favorite link to the page (for now based on node title).
      var text = document.createTextNode('favorite');
      var link = document.createElement('a');
      link.setAttribute('href', '#');
      link.setAttribute('class', 'js-localfav');
      link.appendChild(text);
      $('article .node__title:not(.js-favorite-processed)').before(link).addClass('js-favorite-processed');

      // Bind event to store favorite in the localStorage.
      $('.js-localfav').once().click(function () {
        var newFav = $(this).next('.node__title').html();
        var localFavsSerial = localStorage.getItem('Drupal.localFavs');
        if (localFavsSerial == null) {
          var localFavsData = new Array();
        }
        else {
          var localFavsData = JSON.parse(localFavsSerial);
        }
        localFavsData.push(newFav);
        localStorage.setItem('Drupal.localFavs', JSON.stringify(localFavsData));
        $('#sidebar-first .region-sidebar-first #block-favorite').replaceWith(Drupal.theme('hcBlockContent'));
        Drupal.localfav.generateFavList(localFavsData);
      });
    }
  };

})(jQuery, Drupal);
