<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * CodeIgniter IP Helper
 *
 * 
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Takaaki Kurihara
 */

   /**
     * get only host address from IP adress
     *
     * @access  private
     * @return  void
     */

     if ( ! function_exists('myhtmlview'))
     {
        function myhtmlview($contents, $search)
        {
                //echo "search = $search <br>";
                if (!empty($search)){
                    //echo "$search <br>";
                    $array = explode(" ", $search);
                    $keywordCondition = [];
                    foreach ($array as $keyword) {

                      // only 1byte
                      //$contents = preg_replace("/\b($keyword)\b/i", "<font color=\"red\">$0</font>", $contents);

                      // multi byte
                      //$contents = mb_eregi_replace("$keyword", "<font color=\"red\">\\0</font>", $contents);
                      $contents = mb_eregi_replace("$keyword", "[######]\\0[/######]", $contents);

                    }
                    $contents = str_replace('[######]', "<font color=\"red\">", $contents);
                    $contents = str_replace('[/######]', "</font>", $contents);
                }


                //for eijiro
                $contents = str_replace('■', "<br>■", $contents);
                $contents = str_replace('◆', "<br>◆", $contents);

                echo "$contents";
        }
    }
