/**
 * Fonctions jQuery du thème
 */
jQuery(document).ready(function($) {

  // Liste
  $('.wp-block-column ul').each(function(index, elem) {
      //console.log(index, elem);
      $(elem).toggleClass("w3-ul");
  });

  // liens fichier dans liste
  $('.wp-block-column li a').each(function(index, elem) {
      //console.log(index, elem);
      if ($(elem).attr('href').indexOf('.pdf') >= 0) {
        $(elem).prepend('<i class="fa fa-file-pdf-o fa-fw w3-large w3-text-red"></i>');
      } else if ($(elem).attr('href').indexOf('.doc') >= 0) {
        $(elem).prepend('<i class="fa fa-file-word-o fa-fw w3-large w3-text-indigo"></i>');
      } else if ($(elem).attr('href').indexOf('.xls') >= 0) {
        $(elem).prepend('<i class="fa fa-file-excel-o fa-fw w3-large w3-text-teal"></i>');
      } else if ($(elem).attr('href').indexOf('.ods') >= 0) {
        $(elem).prepend('<i class="fa fa-file-o fa-fw w3-large w3-text-teal"></i>');
      } else if ($(elem).attr('href').indexOf('.odt') >= 0) {
        $(elem).prepend('<i class="fa fa-file-text-o fa-fw w3-large w3-text-indigo"></i>');
      } else if ($(elem).attr('href').indexOf('.ott') >= 0) {
        $(elem).prepend('<i class="fa fa-file-text-o fa-fw w3-large w3-text-indigo"></i>');
      } else {
        $(elem).prepend('<i class="fa fa-file-o fa-fw w3-large w3-text-purple"></i>');
      }
      //console.log($(elem).attr('href'));
  });

  // Widget Fichier de Gutenbert
  $('.wp-block-file a').each(function(index, elem) {
      //console.log(index, elem);
      $(elem).toggleClass("w3-text-theme w3-large");
      $(elem).css('text-decoration', 'none');
      if ($(elem).attr('href').indexOf('.pdf') >= 0) {
          $(elem).prepend('<i class="fa fa-file-pdf-o fa-fw w3-xlarge"></i>');
      } else {
          $(elem).prepend('<i class="fa fa-file-o fa-fw w3-xlarge"></i>');
      }
      //console.log($(elem).attr('href'));
  });

    // Bouton Edition d'un post
    $('.pbi_edit_post').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).toggleClass("");
        // $(elem).css('text-decoration', 'none');
        $(elem).html('<i class="fa fa-edit fa-fw w3-text-theme w3-large"></i>');
    });

    // Bouton lire la suite
    $('.more-link').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).toggleClass("w3-tag w3-theme");
        //$(elem).css('margin-bottom', '15px');
        $(elem).html('Lire la suite...');
    });

    // Gestion du cookie pbi_private_checked via une cace à cocher
    $('#pbi_private_checked_id').each(function(index, elem) {
        if (isCookie('pbi_private_checked')) {
            $(elem).attr('checked', 'checked');
        } else {
            $(elem).removeAttr('checked');
        }
    });
    $('#pbi_private_checked_id').click(function() {
        if (isCookie('pbi_private_checked')) {
            $(this).removeAttr('checked');
            removeCookie('pbi_private_checked');
        } else {
            $(this).attr('checked', 'checked');
            setCookie('pbi_private_checked', 'checked');
        }
        location.reload();
    });

    /**
     * Barre de pagination
     */
    $('.prev').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).removeClass("prev");
        $(elem).removeClass("page-numbers");
        $(elem).addClass("w3-btn w3-white");
    });
    $('.page-numbers').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).removeClass("page-numbers");
        $(elem).addClass("w3-btn w3-white");
    });
    $('.current').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).removeClass("page-numbers");
        $(elem).removeClass("current");
        $(elem).addClass("w3-btn w3-theme");
    });
    $('.next').each(function(index, elem) {
        //console.log(index, elem);
        $(elem).removeClass("next");
        $(elem).removeClass("page-numbers");
        $(elem).addClass("w3-btn w3-white");
    });


    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });

});

/**
 * setCookie : Enregsitrement d'un cookie
 * @param {string} cname nom du cookie
 * @param {string} cvalue sa valeur
 * @param {int} exdays le nombre de jours avant expiration
 */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Suppression d'un cookie
 * @param {string} cname nom du cookie
 */
function removeCookie(cname) {
    document.cookie = cname + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
}

/**
 * Obtenir la valeur d'un cookie
 * @param {string} cname nom du cookie
 */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Est que le cookie existe ?
 * @param {string} cname nom du cookie
 */
function isCookie(cname) {
    var cookie = getCookie(cname);
    if (cookie != "") {
        return true;
    } else {
        return false;
    }
}
