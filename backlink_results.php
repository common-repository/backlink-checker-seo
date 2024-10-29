<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$user_ID = get_current_user_id();
if($user_ID && is_super_admin( $user_id )) {
	$domain = "";
	$max = 0;
	$domain	=	esc_url($_POST['link']);
	$max	=	intval($_POST['max']);
	$bing_search_api_key = sanitize_text_field($_POST['API']);
	$key_remember = sanitize_text_field($_POST['remember']);
	$new_api = sanitize_text_field($_POST['new_api']);
	$new_apiKey = sanitize_text_field($_POST['new_apiKey']);
	if(!empty($key_remember)){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "backlinkSEO"; 
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		api_key varchar(1024) NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		$wpdb->insert( 
			$table_name, 
			array( 
				'time' => current_time( 'mysql' ), 
				'api_key' => $bing_search_api_key, 
			) 
		);
	}elseif(!empty($new_api)){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "backlinkSEO"; 
		$wpdb->insert( 
			$table_name, 
			array( 
				'time' => current_time( 'mysql' ), 
				'api_key' => $new_apiKey, 
			) 
		);
		$bing_search_api_key = $new_apiKey;
		}	?>
	<script>
	$( document ).ready(function() {
	var headertext = [],
	headers = document.querySelectorAll("#miyazaki th"),
	tablerows = document.querySelectorAll("#miyazaki th"),
	tablebody = document.querySelector("#miyazaki tbody");
	
	for(var i = 0; i < headers.length; i++) {
	  var current = headers[i];
	  headertext.push(current.textContent.replace(/\r?\n|\r/,""));
	} 
	for (var i = 0, row; row = tablebody.rows[i]; i++) {
	  for (var j = 0, col; col = row.cells[j]; j++) {
		col.setAttribute("data-th", headertext[j]);
	  } 
	}
	});
	</script>
		<br />
		<div class="container" style="background-color:#FFF;">
				<br />
				<div class="row">
					<div class="col-md-10">
						<div class="alert alert-info" role="alert">
							<h3 style="word-break: break-all;">"<b><?php echo $domain; ?></b>" Referral Links Building Report</h3>
						</div>
					</div>
					<div class="col-md-2"></div>
				 </div>
				
				<div class="row">
					<div class="col-md-10">
						<div class="table-responsive">
						<table id="miyazaki">
							<thead>
								<tr>
									<th>#
									<th>Domain
									<th>Linking Page
								
							<tbody>
		<?php
        $sarray = array();
        $sarray[] = "#|DELIMITER|Linking Domain|DELIMITER|Linking Page URL|DELIMITER|Linking Page Title";
		if(substr($domain, 0, 7) == "http://")	$domain	=	substr_replace($domain, "", 0, 7);
		if(substr($domain, 0, 8) == "https://")	$domain	=	substr_replace($domain, "", 0, 8);

		if($bing_search_api_key == ""){
					echo '<tr><td><i>Please enter API key!</i>';
					exit();
					}
		if($domain == ""){
			echo '<tr><td colspan="3" align="center"><i>Please enter domain!</i></td></tr>';
			exit();
		}else{
			$url	=	"http://" . $domain;
			$domain	=	parse_url($url);
			$url = $domain['host'];
			$domain	=	str_replace("www.","",$url);
			$url	=	"http://" . $domain;
			
	$class = "row2";
	$count = "1";			
 	for($i=0;$i<=$max;$i=$i+50){
 	
           
    $ServiceRootURL =  'https://api.cognitive.microsoft.com/bing/v5.0/';                    
    $WebSearchURL = $ServiceRootURL . 'search?count=50&offset='.$i.'&q=';

    $request = $WebSearchURL . urlencode("inbody:'$domain'");
    
	$process = curl_init($request);
	curl_setopt($process, CURLOPT_HTTPHEADER, array("Ocp-Apim-Subscription-Key: $bing_search_api_key"));
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($process);
	curl_close($process);
	
    $jsonobj = json_decode($response,true); 
    if(!empty($jsonobj)){
    foreach($jsonobj['webPages']['value'] as $value)
    { 
	$class = ($class == "row2")? "row1":"row2";
    			$rurl = $value['url'];
    			preg_match('#&r=(.*?)&p=#is',$rurl,$lurl);
    			$lurl = urldecode($lurl[1]);
				$ltitle = trim($value['name']);
				$ldomain = str_replace("www.", "", $lurl);
				$lpage = '<a href="'.$lurl.'" target="_blank">'.$ltitle.'</a>';				
				if($domain != $ldomain){									
					echo '<tr class="'.$class.'"><td>'.$count.'</td><td>'.$ldomain.'</td><td>'.$lpage.'</td></tr>';
					$sarray[] = "$count|DELIMITER|$ldomain|DELIMITER|$lurl|DELIMITER|$ltitle";					
					$count++;
				}    	
    }

    if($jsonobj['webPages']['totalEstimatedMatches'] < $i+50) break;
	
	}
	else{
	echo "<strong>Please Enter Vaild Bing Search API Key!!!</strong>";
		}
	}
		
}
											
	
								?>
						</table>
						</div>
					</div>
					<div class="col-md-2"></div>
				</div>
				<br /><br />
		</div>
	<?php include("includes/footer.php"); 
}?>