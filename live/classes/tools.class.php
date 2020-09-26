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

			$html  = "<nav>".PHP_EOL;
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
						$html .= str_repeat(" ", 6).'<li><a id="'.$main_k['div_id'].'">'.$main_k['main_menu_name'].'<span class="caret"></span></a>'.PHP_EOL;
						$html .= str_repeat(" ", 8).'<div>'.PHP_EOL;
						$html .= str_repeat(" ", 10).'<ul>'.PHP_EOL;
						foreach( $ret_sub->retval['record_set'] as $sub_k ){
							$html .= str_repeat(" ", 12).'<li><a id="'.$sub_k['sub_id'].'">'.$sub_k['sub_menu_name'].'</a></li>'.PHP_EOL;
						}
						$html .= str_repeat(" ", 10).'</ul>'.PHP_EOL;
						$html .= str_repeat(" ", 8).'</div>'.PHP_EOL;
						$html .= str_repeat(" ", 6).'</li>'.PHP_EOL;
					}else{
						$html .= str_repeat(" ", 6).'<li><a id="'.$main_k['div_id'].'">'.$main_k['main_menu_name'].'</a></li>'.PHP_EOL;
					}
				}
			}

			$html .= str_repeat(" ", 4).'</ul>'.PHP_EOL;
			$html .= '</nav>'.PHP_EOL;

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
			*/

			$script = str_repeat(" ", 4).'<script>'.PHP_EOL;
			$html .= str_repeat(" ", 4).'<div class="divTable">';
			if($retval->retval['status']=='OK'){
				foreach( $retval->retval['record_set'] as $k => $v ){
					$html .= str_repeat(" ", 8).'<div class="divTableRow">'.PHP_EOL;
					$html .= str_repeat(" ", 10).'<div class="divTableCell">'.$v['name'].'</div><div class="divTableCell">'.$v['shortdesc'].'</div>'.PHP_EOL;
					$html .= str_repeat(" ", 8).'</div>'.PHP_EOL;
					$html .= str_repeat(" ", 8).'<div class="divTableRow">'.PHP_EOL;
					$html .= str_repeat(" ", 10).'<div class="divTableCell"><input type="text" id="tb_search_'.$v['ID'].'" value=""/>&nbsp;<span id="spn_'.$v['ID'].'" class="glyphicon glyphicon-remove"></span></div><div class="divTableCell"><button id="btn_search_'.$v['ID'].'">Search</button></div>'.PHP_EOL;
					$html .= str_repeat(" ", 8).'</div>'.PHP_EOL;
					$q = "q=".urlencode($v['searchprefix']);
					$oq = "oq=".urlencode($v['searchprefix']);

					$script_search .=  str_repeat(" ", 8).'$("button#btn_search_'.$v['ID'].'").click(function(){ var oOpen_'.$v['ID'].' = window.open("'.$v['url'].$q.' " + $("input#tb_search_'.$v['ID'].'").val() + "&'.$oq.' " + $("input#tb_search_'.$v['ID'].'").val(), "_blank"); });'.PHP_EOL;
					$script_clear .=  str_repeat(" ", 8).'$("span#spn_'.$v['ID'].'").click(function(){ $("input#tb_search_'.$v['ID'].'").val(""); });'.PHP_EOL;
					//$script_clear_funk .= str_repeat(" ",8).' ClearTextBox( tb_search_'.$v['ID'].' );'.PHP_EOL;
				}
			}
			$html .= str_repeat(" ", 4).'</div>';
			//$script .= $script_clear_funk;
			$script .= $script_search.PHP_EOL;
			$script .= $script_clear;
			$script .= str_repeat(" ", 4).'</script>'.PHP_EOL;
			
			return $html.PHP_EOL.$script;
		}

		public function BuildSaveSearchSql($aryParams){
			$sqlKeys="";
			$sqlVals="";
			$sqlMain = "INSERT INTO supersearch(`user_id`,`created_date`,";

			foreach($aryParams as $k=>$v){ 
				foreach($v as $k1=>$v1){ 
					if($k1 != 'action'){ 
						$v1 = $this::CleanSql($v1);
						$sqlKeys .= "`".$this::CleanSql($k1)."`,";
						$sqlVals .= "'".addslashes($v1)."',";
					} 
				} 
			}

			$sqlVals = substr($sqlVals,0,strlen($sqlVals)-1);
			$sqlKeys = substr($sqlKeys,0,strlen($sqlKeys)-1);
			$sqlMain .= $sqlKeys.") VALUES('1','".date('Y-m-d H:m:s')."',".$sqlVals.");";

			return $sqlMain;
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