<?php
/*# ----------------------------------------------------------------------------
 
 Version:      1.1.2
 Author:       pouyan maleki

 Script Function:
	           send mail based on whats happend in the sait to the users.
 Licenced  to: Bebetteronline.com
 Date:  	   2012-03-04
# ----------------------------------------------------------------------------*/


/////////////////to find all users email
$psql="SELECT * FROM `fl_users` WHERE `id` !='0'";
$userMail = $DB->CacheGetAssoc( 5, $psql, FALSE, TRUE );
$allEmail=array();
	while ( list( $key, $value ) = each( $userMail ) )		 
    {	
     $allEmail["Mails"]=$userMail[$key]["email"];
	 //var_dump($allEmail["Mails"]);
	}
///////////////////we gat every bodys email
	
$q="SELECT * FROM `fl_status` WHERE `send email`='NO'";
$userStatus = $DB->CacheGetAssoc( 5, $q, FALSE, TRUE );

	while ( list( $key, $value ) = each( $userStatus ) )		 
    {	
	$userStatus["Date"]=$userStatus[ $key ]["insDate"];
	    if ($userStatus[ $key ]["statusType"] == "blogComment") {
			//create a massage
			$userStatus[ $key ]["statusMessage"] =str_replace("Kommenterade blogginlägg:", "<span>Kommenterade blogginlägg: ".$man["user"]." skrev i</span>", $userStatus[ $key ]["statusMessage"]);
			$tmpMessage="<br>Hej !</br><br>".$userStatus[ $key ]["statusMessage"]."</br>";
			
			 //find blogg contentId
            $qs=mysql_query("SELECT contentId FROM fl_comments WHERE `insDate`='".$userStatus[ $key ]["insDate"]."'");
			while ($row = mysql_fetch_array($qs, MYSQL_NUM)) {
				$qs=mysql_query("SELECT userId FROM fl_comments WHERE contentId=".$row[0]);
				while ($row = mysql_fetch_array($qs, MYSQL_NUM)) {
					   $qsl=mysql_query("SELECT email FROM fl_users WHERE id=".$row[0]);
     				   while ($rows = mysql_fetch_array($qsl, MYSQL_NUM)) {
						 sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny blogg comment",$rows[0]);
						 //sendMail($rows[0], "agneta@flator.se", "Flator.se Crew","Ny blogg comment", $tmpMessage );
	        		    }
			    }			
			}	
			//".$blogger["username"]."
			mysql_query("UPDATE `fl_status` SET`user name notifed`='ALL USER IN THIS BLOGG' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
         	mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO'"); //update send email row after sending mail
		
		}
			
	    if ($userStatus[ $key ]["statusType"] == "forum inlägg") {
		//create some message to user	
		$userStatus[ $key ]["statusMessage"] =str_replace("foruminlägg:", "<span>Foruminlägg: ".$LastWriterName["name"]." skrev i</span>", $userStatus[ $key ]["statusMessage"]);
		$tmpMessage="<br>Hej !</br><br>".$userStatus[ $key ]["statusMessage"]."</br>";  
		
		 //mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL THIS TREAD USER' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
		//mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL'"); //update send email row after sending mails	
		
		   //find forum contentId
            $qs=mysql_query("SELECT threadId FROM fl_forum_threads WHERE insDate='".$userStatus[ $key ]["insDate"]."'");
			while ($row = mysql_fetch_array($qs, MYSQL_NUM)) {
				$qs=mysql_query("SELECT userId FROM fl_forum_threads WHERE threadId=".$row[0]);
				while ($row = mysql_fetch_array($qs, MYSQL_NUM)) {
				   $qsl=mysql_query("SELECT email FROM fl_users WHERE id=".$row[0]);
				   while ($rows = mysql_fetch_array($qsl, MYSQL_NUM)) {
						 sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny foruminlägg",$rows[0]);
						 //sendMail($rows[0], "agneta@flator.se", "Flator.se Crew","Ny forumlägg", $tmpMessage );
					}
				  }			
            }  
	    
        }

	    if ($userStatus[ $key ]["statusType"] == "newFriend") {
				
	   //create a massage
		$userStatus[ $key ]["statusMessage"] = str_replace("Blev vän med:", "<span class=\"email_date\">".$UserId["user"]."Blev vän med:</span>", $userStatus[ $key ]["statusMessage"]);
		$tmpMessage="<br>Hej !</br><br>".$userStatus[ $key ]["statusMessage"]."</br>";
		
         $q=mysql_query("SELECT friendUserId FROM fl_friends WHERE userId=".$userStatus[ $key ]["userId"]); 
		    while ($row = mysql_fetch_array($q, MYSQL_NUM)) {		
				$q=mysql_query("SELECT friendUserId FROM fl_friends WHERE userId=".$row[0]); 
				while ($row = mysql_fetch_array($q, MYSQL_NUM)) {
					$qs=mysql_query("SELECT `email` FROM `fl_users` WHERE `id`=".$row[0]);
					while ($rows = mysql_fetch_array($qs, MYSQL_NUM)) {
					   sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Nya vänner ", $tmpMessage );
					   //sendMail($rows[0], "agneta@flator.se", "Flator.se Crew","Nya vänner ", $tmpMessage );
					  }			
					}
	        }	
			mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL FRIENDS' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
			mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL' AND '"); //update send email row after sending mails	
			
        }
			
	
	if ($userStatus[ $key ]["statusType"] == "addedEvent") {
			/////////////////gathering writer info////////////////////////
			$sql2="SELECT * FROM fl_users WHERE id=".$userStatus[ $key ]["userId"];
			$row = $DB->CacheGetAssoc($sql2, FALSE, TRUE );
			while ( list( $key2, $value ) = each( $row ) ){
				   $man["user"]=$row[$key2]["username"]; 
                }
		    ////////////////gathering writer info finished/////////////////	
    		mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL USER' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
			mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL'"); //update send email row after sending mails	
				
			////////////////////sending mail block//////////////////
			$userStatus[ $key ]["statusMessage"] =$userStatus[ $key ]["statusMessage"] = str_replace("Lade till event", "<span class=\"email_date\">".$man["user"]."Lade till event:</span>", $userStatus[ $key ]["statusMessage"]);
			$tmpMessage="<br>Hej !</br><br>". $userStatus[ $key ]["statusMessage"]."</br>";
			sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny forumlägg från", $tmpMessage );
			//////////////////finishing sending mail block/////////////
			}

		if ($userStatus[ $key ]["statusType"] == "photoComment") {
		
		//find photo contentId
		$q="SELECT * FROM `fl_comments` WHERE `insDate`='".$userStatus[ $key ]["insDate"]."'";
		$answer = $DB->CacheGetAssoc(5,$q, FALSE, TRUE );
			while ( list( $key, $value ) = each( $answer ) ){
				$contentId=$answer[$key]["contentId"];
				}
				
			// create a masssage
			 $sql2="SELECT * FROM fl_users WHERE id=".$userStatus[ $key ]["userId"];
			    $row = $DB->CacheGetAssoc($sql2, FALSE, TRUE );
			    while ( list( $key2, $value ) = each( $row ) ){
				   $man["user"]=$row[$key2]["username"]; 
                }
			$tmpMessage="<br>Hej!</br><br>".$man["user"]."kommenterade din photo!</br>";
        			
            $qs=mysql_query("SELECT userId FROM fl_comments WHERE contentId=".$contentId);
			while ($row = mysql_fetch_array($qs, MYSQL_NUM)) {
			   $qsl=mysql_query("SELECT email FROM fl_users WHERE id=".$row[0]);
			   while ($rows = mysql_fetch_array($qsl, MYSQL_NUM)) {
			         sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny photo comment",$rows[0] );
			         //sendMail($rows[0], "agneta@flator.se", "Flator.se Crew","Ny forumlägg från", $tmpMessage );
			    }
			  }			
            
		        ////////////////gathering writer info finished/////////////////	
    	      	//mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL USER' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
			    //mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL'"); //update send email row after sending mails		
				////////////////////sending mail block//////////////////
				
            }
			
		//if ($userStatus[ $key ]["statusType"] == "tagStatus") {

			//}

        if ($userStatus[ $key ]["statusType"] == "forumEntry") { 
		
			$q = "SELECT fl_forum_threads.*, fl_forum_cat.shortname FROM fl_forum_threads LEFT JOIN fl_forum_cat ON fl_forum_threads.catId = fl_forum_cat.id WHERE fl_forum_threads.id = '" . (int)$userStatus[ $key ]["statusMessage"] . "'";
			$forumThreadEntry = $DB->GetRow( $q, FALSE, TRUE );
			if (count($forumThreadEntry) < 1) continue;

			if ($forumThreadEntry["newThread"] == "YES") {
				$userStatus[ $key ]["statusMessage"] = '<span class="email_date">Skapade en ny forumtråd:</span> <a href="'.$baseUrl.'/forum/'.$forumThreadEntry["shortname"].'/'.$forumThreadEntry["slug"].'.html\">'.$forumThreadEntry["headline"].'</a>.';
			} 
		    ////////////////gathering writer info finished/////////////////	
    		mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL USER' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
			mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL'"); //update send email row after sending mails	
				
			////////////////////sending mail block//////////////////
			$tmpMessage="<br>Hej ".$man["user"]."!</br><br>".$userStatus[ $key ]["statusMessage"] ."</br>";
				sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny forumlägg från", $tmpMessage );
			//////////////////finishing sending mail block/////////////

		    }

		if ($userStatus[ $key ]["statusType"] == "newPhotosUploaded") {  //mail for all  
				 $sql2="SELECT * FROM fl_users WHERE id=".$userStatus[ $key ]["userId"];
			    $row = $DB->CacheGetAssoc($sql2, FALSE, TRUE );
			    while ( list( $key2, $value ) = each( $row ) ){
				   $man["user"]=$row[$key2]["username"]; 
                }
		    ////////////////gathering writer info finished/////////////////	
    		//mysql_query("UPDATE `fl_status` SET `user name notifed`='ALL USER' WHERE `send email`='NO'");  //update user id notifed row after sending mails with $UserHowGetMails[$key]["users"]
			//mysql_query("UPDATE `fl_status` SET `send email`='YES'  WHERE `send email`='NO' AND `user name notifed` !='NULL'"); //update send email row after sending mails	
				
			//CREATE A MASSAGE
			$tmpMessage="<br>Hej!</br><br>".$man["user"]."har laddat upp ett nytt photo!</br>";
			
			$q=mysql_query("SELECT friendUserId FROM fl_friends WHERE userId=6"); 
		    while ($row = mysql_fetch_array($q, MYSQL_NUM)) {		
					$qs=mysql_query("SELECT `email` FROM `fl_users` WHERE `id`=".$row[0]);
					while ($rows = mysql_fetch_array($qs, MYSQL_NUM)) {
					   sendMail("pouyan@live.se", "pooyanstudio@yahoo.com", "Flator.se Crew","Ny photo från din vänn", $rows[0] );
					   //sendMail($rows[0], "agneta@flator.se", "Flator.se Crew","Ny photo från din vänn", $tmpMessage );			
			    }
	        }		
		}
	}
echo "done look at you mail!";

?>