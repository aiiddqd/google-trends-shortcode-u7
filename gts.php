<?php
/*
* Plugin Name: Google Trends Shortcode
* Description: Shortcode [gtrends words="wordpress"] for display Google Trends
* Author: uptimnizt
* Author URI: ${TM_HOMEPAGE}
* Version: 0.1
*/

namespace uptimizt;

/**
 * Description class
 */
class GoogleTrendsShortcode {

  /**
   * The init
   */
  public static function init(){
    add_shortcode('gtrends', [__CLASS__, 'render_shortcode']);
  }

  /**
   * render_shortcode
   */
  public static function render_shortcode($atts){

      ob_start();
      if(empty($atts['words'])){
          return 'no words';
      }

      $words = $atts['words'];
      $words_array = explode(',', $words);

      $keywords = '';
      foreach ($words_array as $word) {
          $keywords .= sprintf('{"keyword":"%s","geo":"RU","time":"today 5-y"},', $word);
      }

      $keywords = rtrim($keywords, ',');


      ?>
        <script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1937_RC01/embed_loader.js"></script>
        <script type="text/javascript">
          trends.embed.renderExploreWidget(
              "TIMESERIES",
              {
                  "comparisonItem":[
                        <?= $keywords ?>
                   ],
                   "category":0,
                   "property":""
              },
              {
                  "exploreQuery":"date=today%205-y&geo=RU&q=<?= $words ?>",
                  "guestPath":"https://trends.google.ru:443/trends/embed/"
              }
          );
      </script>
      <?php

      $html = ob_get_clean();


      return $html;
  }



}


GoogleTrendsShortcode::init();
