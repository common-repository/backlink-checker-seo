<?php
/*
Plugin Name: Backlink Checker SEO
Description: Backlink Checker show instant result of earned backlinks to your site.
Version: 1.0
Author: metricbuzz, taniafi786
Author URI: https://www.metricbuzz.com
License: GPLv2 or later
*/

// create custom plugin menu
add_action('admin_menu', 'BCS_AdminMenu');
function BCS_AdminMenu() {
	add_menu_page('Backlink Checker SEO','Backlink Checker SEO', 'administrator', __FILE__,'BCS_FormData', plugins_url('/images/icon.png', __FILE__) );
	//enqueue scripts and styles
    wp_enqueue_style( 'style-bootstrap', plugins_url('css/bootstrap.min.css',__FILE__));
	}

function BCS_FormData(){
$user_ID = get_current_user_id();
if($user_ID && is_super_admin( $user_id )) {
	  
	$data_link = sanitize_text_field( $_POST['data_link'] );
	if( !empty($data_link) && $data_link == 'Find Backlinks' ) {
	check_admin_referer( 'bcs_nonce_field' );
	   if(!empty($data_link)){
		  // process form data
		  include 'backlink_results.php'; 
		}
	}else{?>
    	<br /><br />
        <div class="container" style="background-color:#FFF;">

        <div class="row">
                        <div class="col-md-6">
        
                            <h2><strong>Backlink Checker</strong></h2>
                            <p>Have you ever wonder how your site is linking to other sites?<br />
                             What content other bloggers are linking to your pages?</p>
                            <p>Backlink Checker shows an instant result of earned backlinks to your site.</p>
                            <p>Below is the guide showing users how to get a free Bing API Key:</p>
                            <p>** How the Backlink report data is shown?</p>
                            <p>The tool is using 'Bing Web Search API', you can sign up and get free 1000 report data for each month, if the search exceeds the free report data, then the tool will stop reporting until the start of the new month. You can also pay for the extra report API data.</p>
                         <p>Get a <strong>free Bing API Key</strong> here:<br />
                             https://www.microsoft.com/cognitive-services/en-us/bing-web-search-api</p>
                            <p><strong>Demo API Key</strong>: 3e1c968176b844c7b61d7f80948e12be </p>
                        </div>
                        <div class="col-md-4">
                         <p>&nbsp;</p>
                         <p>&nbsp;</p>
                         <p><br>
                          <!-- Animation grpahic -->
                          <img class="img-responsive" src="<?php echo plugins_url( 'images/backlink checker data.gif', __FILE__ );?>" alt="backlink checker data"/></p>
        
                        </div>
                    </div>
        
		<div class="row">
			<div class="col-md-6">
				<form name="form1" method="post" action="">
                <?php 
				global $wpdb;
				$table_name = $wpdb->prefix . 'backlinkSEO';
				$results = $wpdb->get_row("SELECT * FROM ".$table_name." ORDER BY time DESC" );
				if($results){
					?>
                <label for="inputAPI">Saved Bing Search API Key</label>
				<input type="text" name="API" id="API" class="form-control" value="<?php echo $results->api_key; ?>" readonly="readonly">
				<br />
                <input type="checkbox" name="new_api" onclick="ShowHideDiv(this)"> Do you want enter new API key?<br>
				<div id="newApiKey" style="display: none" class="form-group">
                <label for="inputAPI">Enter Bing Search API Key</label>
				<input type="text" name="new_apiKey" id="new_apiKey" class="form-control" placeholder="Enter Bing Search API Key">
				</div>
				<?php }
				else{?>
				<div class="form-group">
					<label for="inputAPI">Enter Bing Search API Key</label>
					<input type="text" name="API" id="API" class="form-control" placeholder="Enter Bing Search API Key" required>
				</div>
                <div class="form-group">
                <input type="checkbox" name="remember"> Remember API key<br>
                </div>
                <?php }?>
                <div class="form-group">
					<label for="exampleInputEmail1">Enter-Top Level Domain</label>
					<input type="text" name="link" id="link" class="form-control" placeholder="Enter Domain Name" required>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Check up to 1000 Backlinks</label>
					<select class="form-control" name="max" required>
						<option value='0' selected>50</option>
						<option value='50'>100</option>
						<option value='200'>250</option>
						<option value='450'>500</option>
						<option value='700'>750</option>
						<option value='950'>1000</option>            
					</select>
				</div><?php wp_nonce_field( 'bcs_nonce_field' ); ?>
				<input type="submit" class="btn btn-primary" name="data_link" value="Find Backlinks">
				
			</form>
				
			</div>
			<div class="col-md-4"></div>
		</div>
		<br>
	<div class="row">
    <div class="col-md-2"></div>
		<div class="col-md-3">
           <img class="img-responsive" src="<?php echo plugins_url( 'images/your-site-backlinks-report.png', __FILE__ );?>" alt="backlink checker"/>
       	</div>
           <div class="col-md-4">
               <img class="img-responsive" src="<?php echo plugins_url( 'images/backlink checker.png', __FILE__ );?>" alt="backlink checker Tool"/>
           </div>
           <div class="col-md-2"></div>
      </div>
  <br><br></div>
		<?php include("includes/footer.php"); 
		}?>
<style type="text/css">
			
		div.fw-body li {
			padding: 0.33em 0.5em;
		}
		div.fw-body li ul {
			margin-top: 0;
		}

		#usedBy div {
			height: 93px;
			line-height: 93px;
		}
		#usedBy img {
			vertical-align: middle;
			margin: 0 auto;
		}

		div.grid.margin {
			margin-bottom: 1em;
		}

		ul.blog_link_list {
			margin: 0;
		}
		
		.row{
		   margin-right:-15px;
		   margin-left:-15px;
		}
		img,.img-responsive,.thumbnail a>img,.thumbnail>img{display:block;max-width:100%;height:auto}
		table#miyazaki { 
		 margin: 0 auto;
		 border-collapse: collapse;
		 font-family: Agenda-Light, sans-serif;
		 font-weight: 100; 
		 background: #333; color: #fff;
		 text-rendering: optimizeLegibility;
		 border-radius: 5px; 
		}
		table#miyazaki caption { 
		 font-size: 2rem; color: #444;
		 margin: 1rem;
		 background-size: contain;
		 background-repeat: no-repeat;
		 background-position: center left, center right; 
		}
		table#miyazaki thead th { font-weight: 300; }
		table#miyazaki thead th, table#miyazaki tbody td { 
		 padding: .8rem; font-size: 1.4rem;
		}
		table#miyazaki tbody td { 
		 padding: .8rem; font-size: 1.4rem;
		 color: #444; background: #eee; 
		}
		table#miyazaki tbody tr:not(:last-child) { 
		 border-top: 1px solid #ddd;
		 border-bottom: 1px solid #ddd;  
		}
		
		@media screen and (max-width: 610px) {
		 table#miyazaki caption { background-image: none; }
		 table#miyazaki thead { display: none; }
		 table#miyazaki tbody td { 
		   display: block; padding: .6rem; 
		 }
		 table#miyazaki tbody tr td:first-child { 
		   background: #666; color: #fff; 
		 }
		   table#miyazaki tbody td:before { 
		   content: attr(data-th); 
		   font-weight: bold;
		   display: inline-block;
		   width: 6rem;  
		 }
		
		}
</style>
<script type="text/javascript">
    function ShowHideDiv(new_api) {
        var newApiKey = document.getElementById("newApiKey");
        newApiKey.style.display = new_api.checked ? "block" : "none";
    }
</script>
<?php }
}