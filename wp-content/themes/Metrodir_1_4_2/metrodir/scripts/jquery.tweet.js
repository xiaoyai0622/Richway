/*global require, exports, console */

/** @preserve
 * jquery-tweets
 *
 * Created at: 2012-10-30 16:53:39 +0100
 * Updated at: 2013-01-30 07:17:12 +0100
 *
 * Author: @ivow
 * Version: 1.0.9
 *
 * https://github.com/yvesvanbroekhoven/jquery-tweets/
 */

/*global jQuery:false window*/

(function($, window) {
  "use strict";

  var tmpl_tweet = '<a href="{{tweet_url}}"><span>{{tweet}}</span><time datetime="{{created_at_iso}}" title="{{created_at_formatted}}">{{created_at_formatted}}</time></a>';

  var plugin_name = 'jquery-tweets',
      defaults    = {
        doneCallback: null,
        tmpl_tweet: tmpl_tweet
      },
      ISODateString;

  function Tweets( element, url, options ) {
    this.element = element;
    this.url     = url;
    this.id      = this.url.hashCode();
    this.options = $.extend( {}, defaults, options );
    this.cache   = window.sessionStorage[plugin_name + this.id];

    this.init();


  }

  Tweets.prototype.init = function() {
    var _this = this;

    if ( window.JSON && window.Storage && this.cache !== undefined) {
      this.output( $.parseJSON(this.cache) );

    } else {
      $.ajax({
        dataType: 'jsonp',
        success: function( response_data ){
          if ( window.JSON && window.Storage ) {
            window.sessionStorage[plugin_name + _this.id] = JSON.stringify( response_data );
          }
          _this.output( response_data );
        },
        url: _this.url
      });

    }

  };

  Tweets.prototype.output = function( data ) {
    var _this = this,
        $ul = $('<ul />');

    $.each( data, function(idx, value) {
      var $li         = $('<li />'),
          template    = _this.options.tmpl_tweet,
          created_at  = _this.createdAt( value.created_at ),
          created_at_formatted  = created_at.getFullYear() + '-' + (created_at.getMonth() + 1) + '-' + created_at.getDate(),
          created_at_iso        = _this.createdAtISO( created_at );

      template = template
        .replace(/\{\{tweet_url\}\}/g, 'https://twitter.com/' + value.user.screen_name + '/status/' + value.id_str)
        .replace(/\{\{tweet\}\}/g, value.text)
        .replace(/\{\{created_at\}\}/g, value.created_at)
        .replace(/\{\{created_at_iso\}\}/g, created_at_iso)
        .replace(/\{\{created_at_formatted\}\}/g, created_at_formatted)
        .replace(/\{\{profile_image_url\}\}/g, value.user.profile_image_url)
        .replace(/\{\{screen_name\}\}/g, value.user.screen_name)
        .replace(/\{\{profile_image_url\}\}/g, value.user.profile_image_url);

      $li
        .append( $(template) )
        .appendTo( $ul );
    });

    $ul.appendTo( $(this.element) );

    if ( $.isFunction( this.options.doneCallback) ) {
      this.options.doneCallback.call( this.element );
    }
  };

  Tweets.prototype.createdAt = function( time_value ) {
    var values = time_value.split(" ");
    return new Date( values[1] + " " + values[2] + ", " + values[5] + " " + values[3] );
  };

  Tweets.prototype.createdAtISO = function( date ) {
    function pad(n) {
      return n < 10 ? '0' + n : n;
    }
    return date.getUTCFullYear() + '-' + pad( date.getUTCMonth() + 1 ) + '-' + pad( date.getUTCDate() )+ 'T' + pad( date.getUTCHours() ) + ':' + pad( date.getUTCMinutes() ) + ':' + pad( date.getUTCSeconds() ) + 'Z';
  }

  $.fn.tweets = function(url, options ) {
    return this.each(function() {
      if ( !$.data(this, 'plugin_' + plugin_name) ) {
        $.data(this, 'plugin_' + plugin_name, true);
        new Tweets( this, url, options );
      }
    });
  };

  // Helpers
  String.prototype.hashCode = function(){
    var hash = 0,
        i,
        character;

    if (this.length === 0) {
      return hash;
    }

    for (i = 0; i < this.length; i++) {
        character = this.charCodeAt(i);
        hash = ((hash<<5)-hash)+character;
        hash = hash & hash; // Convert to 32bit integer
    }
    return Math.abs(hash);
  };

}(jQuery, window));
