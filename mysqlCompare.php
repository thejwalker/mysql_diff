<?php
	
	class MysqlCompare {

		public $dbinfo;
		public $db1;
		public $db2; 

		function __construct() {
			$this->dbinfo = parse_ini_file("db.settings.ini", 'db1');
			try {
				$this->db1 = new PDO('mysql:host='.$this->dbinfo['db1']['host'].';dbname='.$this->dbinfo['db1']['dbname'], $this->dbinfo['db1']['username'], $this->dbinfo['db1']['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			} catch(Exception $e) {
				print "There was a problem connecting to DB1.  Please check the settings within db.settings.ini.";
				die();
			}
			try {
				$this->db2 = new PDO('mysql:host='.$this->dbinfo['db2']['host'].';dbname='.$this->dbinfo['db2']['dbname'], $this->dbinfo['db2']['username'], $this->dbinfo['db2']['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			} catch(Exception $e) {
				print "There was a problem connecting to DB2.  Please check the settings within db.settings.ini.";
				die();
			}
		}


		function getDBOne() {
			try { 
				$stmt = $this->db1->query("SHOW tables FROM ".$this->dbinfo['db1']['dbname']);
				$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
		   		$dbase_one = array();
		   		foreach($tables as $table) {
		   			$fields = $this->db1->query("SHOW FIELDS FROM ".$table);
		   			$table_fields = $fields->fetchAll(PDO::FETCH_ASSOC);
		   			$dbase_one[$table] = $table_fields;
		   		}
		   		return $dbase_one;
			} catch(Exception $e) {
				print "There was a problem running the query on your DB1:<br><br>";
				print $e->getMessage();
				die();
			}
		}
		
		function getDBTwo() {
			try {
				$stmt = $this->db2->query("SHOW tables FROM ".$this->dbinfo['db2']['dbname']);
		   		$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
		   		$dbase_two = array();
		   		foreach($tables as $table) {
		   			$fields = $this->db2->query("SHOW FIELDS FROM ".$table);
		   			$table_fields = $fields->fetchAll(PDO::FETCH_ASSOC);
		   			$dbase_two[$table] = $table_fields;
		   		}
				return $dbase_two;
			} catch(Exception $e) {
				print "There was a problem running the query on your DB2:<br><br>";
				print $e->getMessage();
				die();
			}
		}


		function getDBNameOne() {
			return $this->dbinfo['db1']['dbname'];
		}

		function getDBNameTwo() {
			return $this->dbinfo['db2']['dbname'];
		}

		function compareDatabases() {
			
			try {

				$one = $this->getDBOne();
				$two = $this->getDBTwo();

				// TABLE DIFFS
				$diffOne = array_diff(array_keys($one), array_keys($two));
				$diffTwo = array_diff(array_keys($two), array_keys($one));

				$intOne = array();
				$intTwo = array();

				// LOOP THROUGH ONE CHECKING DIFFERENCES ON TWO
				$retOne = array();
				foreach($one as $key=>$val) {
					if(!isset($two[$key])) {
						$retOne[$key]['class'] = 'diff';
					} else {
						$retOne[$key]['class'] = null;
						foreach($val as $k=>$v) {
							$retOne[$key][$k]['name'] = $v['Field'];

							if(!isset($two[$key][$k]) || (isset($two[$key][$k]) && $two[$key][$k]['Field'] != $v['Field'])) {
								$retOne[$key][$k]['class'] = 'diff';
							} else {
								$retOne[$key][$k]['class'] = null;
								foreach($v as $x=>$y) {
									if($two[$key][$k][$x] != $y) {
										$retOne[$key][$k][$x] = array('val'=>$y, 'class'=>'diff');
									} else {
										$retOne[$key][$k][$x] = array('val'=>$y, 'class'=>null);
									}
								}
							}
						}
					}
				}

				$retTwo = array();
				foreach($two as $key=>$val) {
					if(!isset($one[$key])) {
						$retTwo[$key]['class'] = 'diff';
					} else {
						$retTwo[$key]['class'] = null;
						foreach($val as $k=>$v) {
							$retTwo[$key][$k]['name'] = $v['Field'];
							if(!isset($one[$key][$k]) || (isset($one[$key][$k]) && $one[$key][$k]['Field'] != $v['Field'])) {
								$retTwo[$key][$k]['class'] = 'diff';
							} else {
								$retTwo[$key][$k]['class'] = null;
								foreach($v as $x=>$y) {
									if($one[$key][$k][$x] != $y) {
										$retTwo[$key][$k][$x] = array('val'=>$y, 'class'=>'diff');
									} else {
										$retTwo[$key][$k][$x] = array('val'=>$y, 'class'=>null);
									}
								}
							}
						}
					}
				}

				return array($retOne, $retTwo);

			} catch(Exception $e) {
				print $e->getMessage();
				die();
			}

		}

	}