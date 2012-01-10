<?php
/*
Plugin Name: Link A Dink
Plugin URI: http://wordpress-plugins.biggnuts.com/link-a-dink/
Description: Replace strings with links (or other words I guess).  
Version: 1.8
Author: Dax "The Hammer" Herrera
Author URI: http://www.biggnuts.com
*/

/*UPDATES

3.30.07
Fixed for WP 2.1

12.20.06
Adds hyperlinks in comment text too.

9.29.06
Oops!  The plugin was still messing up words inside tags.  I fixed that.

8.22.06
LAD now ignores words that are already in hyperlinks

8.4.06
Made the plugin only look for single words
set $lad_single_words to false if you want to replace everything

*/

$lad_single_words = true;

function lad_install() {
  global $table_prefix, $wpdb;
  $table_name = $table_prefix . "link_a_dink";

  $sql = "CREATE TABLE ".$table_name." (
          id int NOT NULL auto_increment,
          find_word TEXT NOT NULL,
          replace_word TEXT NOT NULL,
          UNIQUE KEY id (id)
          );";
  require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
  dbDelta($sql);
}

if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
   add_action('init', 'lad_install');
}

function lad_add_options(){
  if(function_exists('add_options_page')){
    add_options_page('Link A Dink', 'Link A Dink', 9, basename(__FILE__), 'lad_options_subpanel');
  }
}


switch($_POST['action']){
case 'Add Dude':
  global $table_prefix, $wpdb, $user_level;
  $table_name = $table_prefix . "link_a_dink";

  $add_word = $_POST["add_word"];
  $rep_word = $_POST["rep_word"];
  
  if($add_word != "" ){
    $insert = "INSERT INTO ".$table_name." (find_word, replace_word) VALUES ('$add_word', '$rep_word')";
    $wpdb->query( $insert);
  } 
  
  break;
case 'Remove':
   global $table_prefix, $wpdb, $user_level;
   $table_name = $table_prefix . "link_a_dink";

  //remove the guy with this ID
  if($_POST["selfind"]){
    $remove = "DELETE FROM ".$table_name." WHERE id=".$_POST["selfind"];
    $results = $wpdb->query( $remove );
  }
  break;
  
}

function lad_options_subpanel(){
  global $table_prefix, $wpdb, $user_level;
  $table_name = $table_prefix . "link_a_dink";
   
?>
<div class="wrap"> 
  <h2><?php _e('Link A Dink', 'wpro') ?></h2> 
  <form name="form1" method="post">
	<fieldset class="options">
		<legend><?php _e('What words are we doing here', 'wpro') ?></legend>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
		  <tr valign="top">
		  <td colspan=2>Link words all over your blog.</td>
		  </tr>
		  <tr valign="top">
			<th><?php _e('Link a dinks', 'wpro') ?></th>
      <td width=700><select name='selfind' style="width: 100%;" size='10'>

<?php

  $finds = $wpdb->get_results("SELECT id, find_word, replace_word FROM {$table_name}", ARRAY_A);
  if(sizeof($finds)){
    foreach($finds as $find)
      echo "<option value=".$find["id"].">".$find["find_word"]." -> ".htmlentities($find["replace_word"])."\n";
  }

?>

      </select></td> 
      <td align="left">
      <input type=submit name="action" value="Remove">
      </td>
		  </tr> 

      <tr>
        <td></td>
        <td>Find: <input type=text name="add_word" id="add_word"> Replace: <input type=text name="rep_word" id="repword"> <input type=submit value="Add Dude" name="action"></td>
      </tr>
		</table>
	</fieldset>
	
  </form> 
</div> 
<?php 

}

function replace_ok($fwords, $rwords, $content)
{
  global $lad_single_words;

  $rcontent = "";
  if($lad_single_words)
    $ncon = preg_split("/\b".$fwords[0]."\b/i", $content); //match words only
  else
    $ncon = explode($fwords[0], $content); //match everything
  
  $f = array_shift($fwords);
  $r = array_shift($rwords);

  for($i = 0; $i < sizeof($ncon); $i+=1)
  {
    $con = $ncon[$i];
    
    if(sizeof($fwords))
      $con = replace_ok($fwords, $rwords, $con);
      
  
    if($i < sizeof($ncon)-1)
      $rcontent .= $con.$r;
    else
      $rcontent .= $con;
    
  }
  
  return $rcontent;
}

function ReplaceOne($in, $out, $content){
   if (strpos($content, $in) !== false){
        $pos = strpos($content, $in);
       return substr($content, 0, $pos) . $out . substr($content, $pos+strlen($in));
   } else {
       return $content;
   }
}

function lad_the_content($content)
{

	global $wpdb, $table_prefix, $user_level, $post;
  $table_name = $table_prefix . "link_a_dink";
 
  $find_words = array();
  $rep_words = array();
  $finds = $wpdb->get_results("SELECT find_word, replace_word FROM {$table_name}", ARRAY_A);
  
  $links = array();
  $tags = array();
  if(sizeof($finds)){
  
    //strip all the existing links out first .
    $pattern = '/(<(?:[^<>]+(?:"[^"]*"|\\\'[^\']*\\\')?)+>)/';
    //$html_string = '<html><body><p class="a<weird>name">The <a href="http://www.google.com">classname</a> is not seen as a <a href="http://www.yahoo.com">different</a> tag</p></body></html>';
    $html_array = preg_split ($pattern, $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $inlink = false;
    $content = "";
    for($i = 0; $i < sizeof($html_array); $i+=1){
      $chunk = $html_array[$i];
      if((strpos($chunk, "<a") == 0 && strpos($chunk, "<a") !== false) || (strpos($chunk, "<A") == 0 && strpos($chunk, "<A") !== false)){
        //strip out all three link parts and replace with a ***
        $links[] = $chunk.$html_array[++$i].$html_array[++$i];
        $content .= "!@#$%^&*()";
      }elseif((strpos($chunk, "<") == 0 && strpos($chunk, "<") !== false)){
        //this means it is a random tag, so strip it and hold it
        $tags[] = $chunk;
        $content .= "!@#T%^&*()";
      }
      else
        $content .= $chunk;
    }

    foreach($finds as $find){
      $find_words[] = $find['find_word'];
      $repl_words[] = $find['replace_word'];
    }
  }
  
  if(sizeof($find_words))
    $content = replace_ok($find_words, $repl_words, $content);

  foreach($tags as $tag){
    $content = ReplaceOne("!@#T%^&*()", $tag, $content);
  }

  foreach($links as $link){
    $content = ReplaceOne("!@#$%^&*()", $link, $content);
  }


  return $content;
}

add_action('admin_menu', 'lad_add_options');
add_filter('the_content', 'lad_the_content');
add_filter('comment_text', 'lad_the_content');

?>