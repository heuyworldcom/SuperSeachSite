<?php
if( isset($_GET['auth']) || isset($_POST['action'])){
}else{
    exit('You do not have authorized access.');
}

require_once 'classes/cnnprops.class.php';
require_once 'classes/dbops.class.php';
require_once 'classes/retval.class.php';
require_once 'classes/transactions.class.php';
require_once 'classes/tools.class.php';
require_once 'classes/datagrabber.class.php';
require_once 'classes/errors.class.php';
require_once 'classes/mypdo.class.php';
require_once 'classes/dbqueries.class.php';

function GetAhash(){
	$currentNanoSecond = (int) (microtime(true) * 1000000000);
	$randomHash = hash('ripemd160', $currentNanoSecond.date('Y-m-d H:m:s').$currentNanoSecond);
	return $randomHash;
}

$is_local = ( $_SERVER['REQUEST_URI'] == '/xampp/supersearch/default.php' ) ? true : false;

$action = "";
$polls_data = "";
$polls_html = "";
$itsme = false;

if(isset($_SERVER['REMOTE_ADDR'])){
	if($_SERVER['REMOTE_ADDR']=='24.250.48.133'){
		$itsme = true;
	}
}

$cnnprops = new ConnectionProperties();
$errors = new clsErrors();
$dbops = new clsDBOps();
$DataGrabber = new DataGrabber($is_local);
$ret = new clsRetval();
$Tools = new clsTools();

if(isset($_POST)){
	if(isset($_POST['action'])){
		$action = $_POST['action'];
	}
}

$hash = GetAhash();

	

$web_url = ($is_local===true) ? "http://localhost:81/xampp/supersearch.com/" : "http://www.phpdeveloperpro.com/supersearch/";

/*
[{"Name":"C# ASP.NET"},{"Url":"https://www.google.com/search?q="},{"ShortDesc":"X"},{"SearchPrefix":"c# asp.net"},{"action":"save_search"}]
Array
(
    [action] => execute
    [params] => Array
        (
            [0] => Array
                (
                    [Name] => C# ASP.NET
                )

            [1] => Array
                (
                    [Url] => https://www.google.com/search?q=
                )

            [2] => Array
                (
                    [ShortDesc] => X
                )

            [3] => Array
                (
                    [SearchPrefix] => c# asp.net
                )

            [4] => Array
                (
                    [action] => save_search
                )

        )

)
Array
(
    [action] => execute
    [params] => Array
        (
            [0] => Array
                (
                    [action] => get_supersearches
                )

        )

)

*/

// Fake out site and default to View Searches
/*
if($action==''){
    $_POST['action'] = 'execute';
    $action = 'execute';
    $_POST['params'] = array( '0' => array( 'action' => 'get_supersearches' ) );
 }
*/

if($action!=''){
	switch($action){
        case "execute":
            $executeAction = false;
            $aryParams = $_POST['params'];
            $executeAction = $Tools->FindExecuteAction( $aryParams );
            switch($executeAction){
                case "get_supersearches":
                    $dbq = new DBQueries();
                    $dbq->set_UserId(1);
                    $dbq->set_Active(1);
                    
                    $sql = $dbq->GetSuperSearchs();

                    if($sql!==false){
                        $ret = $dbops->ExecuteSelectQuery( new ConnectionProperties() , $sql );
                        $ret->retval['html'] = $Tools->BuildSuperSearchsTable( $ret );
                        $ret->retval['action'] = 'get_supersearches';
                        $ret->retval['target_div'] = 'div_view_searches';
                    }
                    unset( $dbq );
                    echo json_encode( $ret );
                break;
                case "save_search":
                    $sql = $Tools->BuildSaveSearchSql( $aryParams );
                    $ret = $dbops->ExecuteInsertQuery( new ConnectionProperties() , $sql );
                    if($ret->retval['status']=='OK'){
                        $ret->retval['search_saved']=1;
                    }else{
                        $ret->retval['search_saved']=0;
                    }
                    
                    echo json_encode( $ret );
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
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
          <link rel='stylesheet' id='layerslider-css'  href='css/menubar.css' type='text/css' media='all' />
          <link rel='stylesheet' id='styles-css'  href='css/styles.css' type='text/css' media='all' />
         
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
                    case "btn_supersearch_submit":
                        if(ValidateForm()===true){
                            var objJson = [];
                            $.each($('.requred'), function (index, value) {
                                var item = {}
                                item[this.id]=$("#"+this.id).val();
                                objJson.push(item);
                            });
                            item={}
                            item['action']='save_search';
                            objJson.push(item);
                            Execute(objJson);
                        }
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

  <!-- BEGIN DATA DRIVEN MENU -->
  <?php
        $dbq = new DBQueries();
        $ret = new clsRetval();
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
                unset ( $dbq, $sql, $ret, $Tools );
            }
        }
    ?>
    <!-- END DATA DRIVEN VIEW SEARCHES -->
    </div>


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
 
  </body> 
</html>

<?php 
} // End: if($action!='')
?>