<?php
if( isset($_GET['auth0rize']) || isset($_POST['action'])){
}else{
    die('You do not have authorized access.');
}

require_once 'classes/cnnprops.class.php';
require_once 'classes/dbops.class.php';
require_once 'classes/retval.class.php';
require_once 'classes/tools.class.php';
require_once 'classes/errors.class.php';
require_once 'classes/dbqueries.class.php';
require_once 'classes/endecrypt.class.php';
require_once 'classes/dataformatconstants.class.php';
require_once 'classes/htmlobjectsconstants.class.php';

function GetAhash(){
	$currentNanoSecond = (int) (microtime(true) * 1000000000);
	$randomHash = hash('ripemd160', $currentNanoSecond.date('Y-m-d H:m:s').$currentNanoSecond);
	return $randomHash;
}

$DataFormatConstants = new DataFormatConstants();
$HtmlObjectConstants = new HtmlObjectConstants();
	
$is_local = ( $_SERVER['REQUEST_URI'] == '/xampp/supersearch/default.php' ) ? true : false;

$action = "";
$polls_data = "";
$polls_html = "";
$itsme = false;

if(isset($_SERVER['REMOTE_ADDR'])){
	if($_SERVER['REMOTE_ADDR']=='YOUR_LIVE_IP_ADDRESS'){
		$itsme = true;
	}
}

if(isset($_POST)){
	if(isset($_POST['action'])){
		$action = $_POST['action'];
	}
}

$hash = GetAhash();

$web_url = ($is_local===true) ? "YOUR_LOCAL_WEB_ADDRESS" : "YOUR_LIAVE_WEB_ADDRESS";

if($action!=''){
	switch($action){
        case "execute":
            $Tools = new clsTools();
            $executeAction = false;
            $aryParams = $_POST['params'];
            $executeAction = $Tools->FindExecuteAction( $aryParams );
            switch($executeAction){
                case "create_account":
                    $dbops = new clsDBOps();
                    $dbq = new DBQueries();
                    $ret = new clsRetval();
                    
                    $sql = $dbq->DoesUserExistSql($_POST['params']);
                    $ret = $dbops->ExecuteSelectQuery( new ConnectionProperties() , $sql );

                    if($ret->retval['status']=='OK'){
                        // User exists
                        $ret->retval['msg'] = 'User already exists';
                        $ret->retval['status'] = 'notOK';
                    }else{
                        $sql = $dbq->GetInsertNewAccountSql($_POST['params']);
                        $ret = $dbops->ExecuteInsertQuery( new ConnectionProperties() , $sql );
                    }

                    unset( $dbq, $dbops );
                    echo json_encode( $ret );

                break;
                case "get_supersearches":
                    $dbops = new clsDBOps();
                    $dbq = new DBQueries();
                    $dbq->set_UserId(1);
                    $dbq->set_Active(1);
                    $ret = new clsRetval();
                    
                    $sql = $dbq->GetSuperSearchs();

                    if($sql!==false){
                        $ret = $dbops->ExecuteSelectQuery( new ConnectionProperties() , $sql );
                        $ret->retval['html'] = $Tools->BuildSuperSearchsTable( $ret );
                        $ret->retval['action'] = 'get_supersearches';
                        $ret->retval['target_div'] = 'div_view_searches';
                    }
                    unset( $dbq, $dbops );
                    echo json_encode( $ret );
                break;
                case "save_search":
                break;
            }
			break;
		default:
			break;
	}
}else{

?>
<!DOCTYPE html>
<html lang="en"> 
      <head> 
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta http-equiv="content-type" content="text/html; charset=utf-8"> 

          <!-- Load CSS First -->
          <link rel='stylesheet' id='layerslider-css'  href='css/menubar.css?r=<?php echo GetAhash(); ?>' type='text/css' media='all' />
          <link rel='stylesheet' id='styles-css'  href='css/styles.css?r=<?php echo GetAhash(); ?>' type='text/css' media='all' />
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
          <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/assets/css/docs.min.css?r=<?php echo GetAhash(); ?>">

          <!-- Then Load JS -->
          
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw="  crossorigin="anonymous"></script>
          
         
          <title>SuperSearcher</title> 
          <style>
         </style>
          <script>
              $(function() {

                var user_acces='<?php echo GetAhash(); ?>';

                function ValidateForm(){
                    var isValid = true;
                    $.each($('.requred'), function (index, value) {
                        if($("#"+this.id).val()==''){
                            $("#"+this.id).addClass('purple');
                            isValid = false;
                            return false;
                        }else{
                            $("#"+this.id).removeClass('purple');
                        }
                    });
                    return isValid;
                } //End ValidateForm

                function ValidateAccountForm(){
                    var isValid = true;
                    $.each($('.create_account_required'), function (index, value) {
                        if($("#"+this.id).val()==''){
                            $("#"+this.id).addClass('purple');
                            isValid = false;
                            return false;
                        }else{
                            $("#"+this.id).removeClass('purple');
                        }
                    });
                    return isValid;
                } //End ValidateForm

            function ClearTextBox( id ){
                $("input#"+id).val('');
            }

            $(document).click(function(e){
                // Hide all sections before showing just one
                if(e.target.id.substr(0,9)=='a_section'){
                    $(".div_section").hide();
                }

                switch(e.target.id){
                    case "btn_createaccount_submit":
                        if(ValidateAccountForm()===true){
                            var objJson = [];
                            $.each($('.create_account_required'), function (index, value) {
                                var item = {}
                                item[this.id]=$("#"+this.id).val();
                                objJson.push(item);
                            });
                            item={}
                            item['action']='create_account';
                            objJson.push(item);
                            Execute(objJson);
                        }
                        break;
                    case "a_section_create_account":
                        $("div#div_section_create_account").show();
                        break;
                    case "a_section_help":
                        $("div#div_section_help").show();
                        break;
                    case "btn_supersearch_submit":
                        break;
                    case "a_section_create_search":
                        $("div#div_create_search").show();
                        break;
                    case "a_section_view_searches":
                        var objJson = [];
                        var item = {}
                        item['action'] = 'get_supersearches';
                        objJson.push(item);
                        Execute(objJson);
                        $("div#div_view_searches").show();
                        break;
                }
                
            }); // End doc.click

                function Execute(jsonParams){
                    jQuery.ajax({
                data: { 
                    'action': 'execute',
                    'params': jsonParams,
                },

                dataType: 'json',
                type: 'POST',
                url: 'default.php',
                cache: false,

                success: function(ret) {
                //$('textarea#ta_debugger').show().html(ret);return false;
                
                if(ret.retval.status=='OK'){
                    if (typeof ret.retval.html !== 'undefined') {
                        $("div#"+ret.retval.target_div).html(ret.retval.html);
                    }
                    if(typeof ret.retval.search_saved !== 'undefined'){
                        if(ret.retval.search_saved==1){
                            alert('Search Saved!');
                        }
                    }
                }else{
                    alert(ret.retval.msg);
                }
                },

                error: function( jqXHR, textStatus, errorThrown ){
                //alert(errorThrown);
                alert( 'AJAX ERROR : Status = ' + textStatus + ', errorThrown = ' + errorThrown );}
                }); // End: jQuery Ajax

                } // End: Execute()

               }); // End: docu.ready
          </script>
      </head> 
  <body> 
  <input type="hidden" id="hf_god_privileges" value="<?php echo GetAhash(); ?>"/>

  <textarea id="ta_debugger" style="display:none;" cols="50" rows="10"></textarea>

  <h1 style="width:100%;align:center;" class="programHeader">SuperSearch</h1>

  <!-- BEGIN DATA DRIVEN MENU -->
  <?php
        $dbq = new DBQueries();
        $ret = new clsRetval();
        $dbops = new clsDBOps();
        $Tools = new clsTools();
        $sql = $dbq->GetMainMenu();
        $ret = $dbops->ExecuteSelectQuery( new ConnectionProperties() , $sql );
        echo $Tools->BuildSuperSearchsMainMenu( $ret );
        unset ( $dbq, $sql, $ret, $Tools );
  ?>
  <!-- END DATA DRIVEN MENU -->

  
    <!-- BEGIN DATA DRIVEN VIEW SEARCHES -->
    <div class="div_section" id="div_view_searches" style="display:block; width:45%;">
    <?php
        if( $action == '' ){
            $ret = new clsRetval();
            $dbq = new DBQueries();
            $Tools = new clsTools();
            $dbq->set_UserId(1);
            $dbq->set_Active(1);
            
            $sql = $dbq->GetSuperSearchs();

            if( $sql !== false ){
                $ret = $dbops->ExecuteSelectQuery( new ConnectionProperties() , $sql );
                echo $Tools->BuildSuperSearchsTable( $ret );
            }
            
            unset ( $dbq, $sql, $ret, $Tools );
        }
    ?>
    <!-- END DATA DRIVEN VIEW SEARCHES -->
    </div>

    <!-- HELP FORM -->
    <div class="divTable div_section" id="div_section_help" style="display:none;"> <!-- START divTable -->
    <h3>
        <blockquote>
        SuperSearch is a Search Helper SPA (Single Page Application) written in PHP (7 OOP), HTML5, CSS, & jQuery<br/><br/>

        Create Searchboxes with prefix search terms. For example: prefix: c# asp.net images When other terms are entered into the <br/>
        searchbox like "jpeg png" and the Search Button is clicked a google search is done on: c# asp.net images jpeg png<br/><br/>

        The tool removes the need to enter repetative prefix terms when searching multiple times for a project<br/><br/>

        To create a new search follow this:<br/><br/>
        <img src="images/create_search.jpg" width="467" height="427" style="border:1px solid black;width:467px;height:427px;" alt="Create New Search"/><br/><br/>
        Then click on View Searches to see it added to the page.<br/><br/>
        The menu and sub-menues are data driven now .. works really neat<br/>

        </blockquote>
    </h3>
    </div>

    <!-- BEGIN CREATE ACCOUNT -->
    <div class="divTable div_section" id="div_section_create_account" style="display:none;">
	<div class="divTable"> 
		<div class="divTableRow">
			<div class="divTableCell">
      	Username<br/>
				<input type="text" id="user_name" name="user_name" value="" class="create_account_required"/>
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
      	Email Address<br/>
				<input type="text" id="user_email" name="user_email" value="" class="create_account_required"/>
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
      	Password<br/>
				<input type="password" id="user_pswd" name="user_pswd" value="" class="create_account_required"/>
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
				<input type="submit" id="btn_createaccount_submit" name="btn_createaccount_submit"/>
			</div>
		</div>
	</div> 
    </div>
    <!-- END CREATE ACCOUNT -->

    <!-- CREATE SEARCH -->
    <div class="divTable div_section" id="div_create_search" style="display:none;"> <!-- START divTable -->
        <div class="divTableRow">
            <div class="divTableCell">
        Name<br/>
                <input class="requred" type="text" id="Name" name="Name" value=""/>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell">
        Url (eg. google, yahoo, etc..)<br/>
                <input class="requred" type="text" id="Url" name="Url" value="https://www.google.com/search?"/>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell">
        ShortDesc<br/>
                <input class="requred" type="text" id="ShortDesc" name="ShortDesc" value=""/>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell">
        SearchPrefix (eg. c# asp.net)<br/>
                <input class="requred" type="text" id="SearchPrefix" name="SearchPrefix" value=""/>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell">
                <input type="submit" id="btn_supersearch_submit" name="btn_supersearch_submit"/>
            </div>
        </div>
    </div> <!-- END CREATE SEARCH -->
    <div style="width:100%;text-align:right;"><p></p>&nbsp;&nbsp;&copy;2019 LateNiteWare.com&nbsp;&nbsp;&nbsp;&nbsp;</div>
  </body> 
</html>

<?php 
} // End: if($action!='')
?>
