<?php
/*
Plugin Name: Tilvitnanir 
Plugin URI: http://tilvitnun.is/
Description: Random quotes in Icelandic. Tilvitnanir og málshættir til að sýna á Wordpress blogginu þínu.
Version: 1.0
Author: Hákon Ágústsson
Author URI: http://www.Tilvitnun.is
*/
/*  Copyright 2010  Hákon Ágústsson (email : info@Tilvitnun.is)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

error_reporting(E_ALL);

if (!class_exists("tilvitnun_widget")) {

   class tilvitnun_widget {
      public function tilvitnun_widget() { //constructor
      }

      public function control(){
         echo 'tilvitnun.com widget control panel';
      }

      public function widget($args){
         echo $args['before_widget'];
         echo $args['before_title'] . 'Tilvitnanir' . $args['after_title'];
         echo '<noscript>Your browser needs to support javascript to view Tilvitnun</noscript><div id=\'tilvitnun_quote\'>?</div><div id=\'tilvitnun_author\'>?</div>';
         echo $args['after_widget'];
      }

      public function tilvitnunjs ( ) {
/*          wp_enqueue_script( 'tilvitnunjs', path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/js/tilvitnun.js") );*/
        echo  '
<script type="text/javascript">
    function fnc(obj) {
       eval(\'var v=\'+obj.d);

       if (!v.Quote) 
          v.Quote = "?";

       if (!v.Author)
          v.Author = "?";

       document.getElementById(\'tilvitnun_quote\').innerHTML = v.Quote;
       document.getElementById(\'tilvitnun_author\').innerHTML = v.Author;

       document.getElementById(\'tilvitnun_author\').innerHTML = "<a href=\"http://www.tilvitnun.is/showquotes.aspx?id=" + v.Id + "\">- " + v.Author + "</a>"

    }
 </script>  
 <script type="text/javascript" src="http://api.tilvitnun.is/photoquotes.asmx/PhotoQuoteGetJson?callback=fnc"></script>';
      }

      public function register(){
         register_sidebar_widget('tilvitnun_widget', array(&$this, 'widget'));
         // callback is tilvitnun_widget::widget
         register_widget_control('tilvitnun_widget', array(&$this, 'control'));
         // callback is tilvitnun_widget::control
      }

   } // end class

}

if (class_exists("tilvitnun_widget")) {
   $tilvitnun_plugin = new tilvitnun_widget();
}

if (isset($tilvitnun_plugin)) {
   // Actions
   add_action('widgets_init', array(&$tilvitnun_plugin, 'register'));
   add_action('wp_footer', array(&$tilvitnun_plugin, 'tilvitnunjs'));

}

?>