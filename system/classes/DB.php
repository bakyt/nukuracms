<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
class DB{
	private static $set=null;
	private $conf;
	private $mysqli_connect;
	private $page = array();
	public function __construct(){
		self::setDatabase();
	}
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	private function setDatabase(){
		$Config = Configuration::set();
		$this->mysqli_connect = mysqli_connect($Config->get('DB_HOST'), $Config->get('DB_USER'), $Config->get('DB_PASS'), $Config->get('DB_NAME')) or die('error');
	}
	public function query($sql){
		try{
			$query = mysqli_query($this->mysqli_connect, $sql);
		}
		catch (MySQLDuplicateKeyException $e) {
		// duplicate entry exception
			$e->getMessage();
		}
		catch (MySQLException $e) {
			// other mysql exception (not duplicate key entry)
			$e->getMessage();
		}
		catch (Exception $e) {
			// not a MySQL exception
			$e->getMessage();
		}
		return $query;
	}
	public function insert($table, $values){
		$table = '`'.$table.'`';
		return self::query("INSERT INTO $table VALUES $values") or die('Errors insert into mysqli');
	}
	public static function itemParser($query){
		$i=0;
		while($item = $query->fetch_assoc()){
			$result[$i] = $item;
			$i++;
		}
		return $result;
	}
	public function importSqlFile($filename) {
		if (!file_exists($filename)) {
			return 'Database менен байланышууда ката кетти, киргизилген маалыматтарды текшериңиз.';
		}
		// Temporary variable, used to store current query
		$templine = '';
		$lines = file($filename);
		foreach ($lines as $line) {
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '') continue;
			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';') {
				// Perform the query
				self::query($templine) or $notice = 1;
				// Reset temp variable to empty
				$templine = '';
			}
		}
		return $notice;
	}
	public function sqlTableExport($table, $path){
		$mysqli = self::set();
		$result        = $mysqli->query('SELECT * FROM ' . $table);
        $fields_amount = $result->field_count;
        $rows_num      = $mysqli->affected_rows;
        $res           = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine    = $res->fetch_row();
        $content .= "\n\n" . $TableMLine[1] . ";\n\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0)
        {
            while ($row = $result->fetch_row())
            { //when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0)
                {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++)
                {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j]))
                    {
                        $content .= '"' . $row[$j] . '"';
                    }
                    else
                    {
                        $content .= '""';
                    } if ($j < ($fields_amount - 1))
                    {
                        $content.= ',';
                    }
                }
                $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num)
                {
                    $content .= ";";
                }
                else
                {
                    $content .= ",";
                } $st_counter = $st_counter + 1;
            }
		}
		$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		$hd = fopen($path, "wb");
		$e = fwrite($hd, $content);
		fclose($path);
		if ($e == -1) return false;
		else return true;
	}
}
?>