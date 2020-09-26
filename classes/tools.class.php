<?php
if(!class_exists('clsTools')){
	class clsTools{
		
		var $retval;
		var $today;
		public $queryType='';
		
		function __construct(){
			$this->today = date( 'Y-m-d' );
			$this->retval = array('status'=>'notOK', 'msg'=>'');
		}		
		
		public function BuildSuperSearchsMainMenu($ret_main){
			$dbq = new DBQueries();
			$dbops = new clsDBOps();
			$ret_sub = new clsRetval();

			$html  = '<nav class="navbar navbar-expand-sm" display="flex;">'.PHP_EOL;
			$html .= '  <div class="container-fluid" style="margin-top:20px;"><div class="collapse navbar-collapse">'.PHP_EOL;
			$html .= str_repeat(" ", 4)."<ul>".PHP_EOL;

			/*
                    [0] => Array
                        (
                            [main_menu_id] => 2
                            [main_menu_name] => Home
                            [main_menu_url] => 
                            [div_id] => a_section_home
						)
			*/

			if($ret_main->retval['status']=='OK'){
				foreach( $ret_main->retval['record_set'] as $main_k ){
					$sql = $dbq->GetSubMenues( $main_k['main_menu_id'] );
					$ret_sub = $dbops->ExecuteSelectQuery( new ConnectionProperties(), $sql );
					if($ret_sub->retval['status']=='OK'){
						$html .= str_repeat(" ", 6).'<li style="padding-left:10px;"><a id="'.$main_k['div_id'].'">'.$main_k['main_menu_name'].'<span class="caret"></span></a>'.PHP_EOL;
						$html .= str_repeat(" ", 8).'<div>'.PHP_EOL;
						$html .= str_repeat(" ", 10).'<ul>'.PHP_EOL;
						foreach( $ret_sub->retval['record_set'] as $sub_k ){
							$html .= str_repeat(" ", 12).'<li style="padding-left:10px;"><a id="'.$sub_k['sub_id'].'">'.$sub_k['sub_menu_name'].'</a></li>'.PHP_EOL;
						}
						$html .= str_repeat(" ", 10).'</ul>'.PHP_EOL;
						$html .= str_repeat(" ", 8).'</div>'.PHP_EOL;
						$html .= str_repeat(" ", 6).'</li>'.PHP_EOL;
					}else{
						$html .= str_repeat(" ", 6).'<li style="padding-left:10px;"><a id="'.$main_k['div_id'].'">'.$main_k['main_menu_name'].'</a></li>'.PHP_EOL;
					}
				}
			}

			$html .= str_repeat(" ", 4).'</ul>'.PHP_EOL;
			$html .= '</div>  </div>  </nav>'.PHP_EOL;

			

			return $html;
		}

		public function BuildSuperSearchsTable($retval){
			$html='';
			$script_search='';
			$script_clear='';

			/*
				[ID] => 9
				[user_id] => 1
				[created_date] => 2019-12-26 22:12:39
				[active] => 1
				[name] => C# ASP.NET
				[url] => https://www.google.com/search?q=
				[shortdesc] => Things about C#
				[searchprefix] => c# asp.net

				<button type="button" class="btn btn-info btn-lg" ng-click="serverFiles()" style="margin-left: 10px"><span class="glyphicon glyphicon-remove yellow"></span></button>
			*/
			
			$script = str_repeat(" ", 4).'<script>'.PHP_EOL;
			$html .= str_repeat(" ", 4).'<div class="divTable">'.PHP_EOL;
			if($retval->retval['status']=='OK'){
				foreach( $retval->retval['record_set'] as $k => $v ){
					$html .= str_repeat(" ", 10).'<div class="divTableRow">'.PHP_EOL;
					$html .= str_repeat(" ", 12).'<div class="divTableCell divBold">'.$v['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$v['shortdesc'].'</div>'.PHP_EOL;
					$html .= str_repeat(" ", 10).'</div>'.PHP_EOL;
					$html .= str_repeat(" ", 10).'<div class="divTableRow">'.PHP_EOL;
					$html .= str_repeat(" ", 12).'<div class="divTableCell"><input type="text" id="tb_search_'.$v['ID'].'" value="" placeholder="'.$v['searchprefix'].'"/>&nbsp;<span id="spn_'.$v['ID'].'" class="glyphicon glyphicon-remove glyph-red"></span>&nbsp;&nbsp;<button id="btn_search_'.$v['ID'].'">Search</button></div>'.PHP_EOL;
					$html .= str_repeat(" ", 10).'</div>'.PHP_EOL;
					$q = "q=".urlencode($v['searchprefix']);
					$oq = "oq=".urlencode($v['searchprefix']);

					$script_search .=  str_repeat(" ", 10).'$("button#btn_search_'.$v['ID'].'").click(function(){ var oOpen_'.$v['ID'].' = window.open("'.$v['url'].$q.' " + $("input#tb_search_'.$v['ID'].'").val() + "&'.$oq.' " + $("input#tb_search_'.$v['ID'].'").val(), "_blank"); });'.PHP_EOL;
					$script_clear .=  str_repeat(" ", 10).'$("span#spn_'.$v['ID'].'").click(function(){ $("input#tb_search_'.$v['ID'].'").val(""); });'.PHP_EOL;
				}
			}
			$html .= str_repeat(" ", 4).'</div>';

			$script .= $script_search.PHP_EOL;
			$script .= $script_clear;
			$script .= str_repeat(" ", 4).'</script>'.PHP_EOL;
			
			return $html.PHP_EOL.$script;
		}

		public function BuildSaveSearchSql( $aryParams ){
			return "";
		}

		public function CleanSql($sql){
			$sql = str_ireplace("insert","",$sql);
			$sql = str_ireplace("update","",$sql);
			$sql = str_ireplace("delete","",$sql);
			$sql = str_ireplace("drop","",$sql);
			$sql = str_ireplace("alter","",$sql);
			$sql = str_ireplace("create","",$sql);
			return $sql;
		}

		public function FindExecuteAction($paramArray){
			$executeAction=false;
			foreach($paramArray as $k=>$v){ 
				foreach($v as $k1=>$v1){ 
					if($k1 == 'action'){ 
						$executeAction = $v1; 
					break; 
					} 
				} 
			}

			return $executeAction;
		}

		public function AreAllNumeric( $aryIn, $aryFormat ){
			$tf=true;
			if (is_array($aryIn)){
				switch($aryFormat){
					case _NON_INDEXED_ARRAY:
						foreach($aryIn as $v){
							if (!is_numeric($v)) {
								$tf=false;
								break;
							}
						}
					break;
					case _INDEXED_ARRAY:
						foreach($aryIn as $k=>$v){
							if (!is_numeric($v)) {
								$tf=false;
								break;
							}
						}
					break;
					default:
					$tf=false;
					break;
				}
			}else{
				$tf=false;
			}
			return $tf;
		}
		public function queryToArray($qry)
		{
				$result = array();
				//string must contain at least one = and cannot be in first position
				if(strpos($qry,'=')) {
	
				 if(strpos($qry,'?')!==false) {
				   $q = parse_url($qry);
				   $qry = $q['query'];
				  }
				}else {
						return false;
				}
	
				foreach (explode('&', $qry) as $couple) {
						list ($key, $val) = explode('=', $couple);
						$result[$key] = $val;
				}
	
				return empty($result) ? false : $result;
		}
	public function strip_quotes( $strIn, $aryMoreToStrip=false ){
			$strIn = str_replace("'","",$strIn);
			$strIn = str_replace('"',"",$strIn);
			if(is_array($aryMoreToStrip)){
				foreach($aryMoreToStrip as $symbol){
					$strIn = str_replace($symbol,"",$strIn);
				}
			}
			return $strIn;
		}
	}
}
