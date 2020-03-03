<?php

class DBConnection
{
    private $db;
    private $logFileName = "debug_pdo_error_log";

    public function __construct($dbname, $username, $password, $servername = DB_HOSTNAME)
    {
        try {
            $this->db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::ATTR_PERSISTENT => true));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            debug_log("Connection Error (__construct)\r\n" . $e->getMessage() . "\r\n" . $e->getTraceAsString(), $this->logFileName);
            responseMessage("Connection Error");
            die;
        }
    }

    final public function ExecuteSelectQuery($sql_statement, &$result_resource, &$returned_rows_count, $arrParams = array())
    {
        try {
            $result_resource = $this->db->prepare($sql_statement);
            $result_resource->execute($arrParams);
            $returned_rows_count = $result_resource->rowCount();
            return 1;
        } catch (PDOException $e) {
            debug_log("Connection Error (ExecuteSelectQuery)\r\n$sql_statement\r\n" . json_encode($arrParams) . "\r\n" . $e->getMessage() . "\r\n" . $e->getTraceAsString(), $this->logFileName);
            responseMessage("E.S.Q Error");
            die;
        }
    }

    final public function ExecuteQuery($sql_statement, &$result_resource, &$returned_rows_count, $arrParams = array())
    {
        try {
            $result_resource = $this->db->prepare($sql_statement);
            if (isNonEmptyArray($arrParams)) {
                $i = 1;
                foreach ($arrParams as $key => $param) {
                    $result_resource->bindParam($i, $$key);
                    $$key = $param;
                    $i++;
                }
            }
            $result_resource->execute();
            $returned_rows_count = $result_resource->rowCount();
            return 1;
        } catch (PDOException $e) {
            debug_log("Connection Error (ExecuteQuery)\r\n$sql_statement\r\n" . json_encode($arrParams) . "\r\n" . $e->getMessage() . "\r\n" . $e->getTraceAsString(), $this->logFileName);
            responseMessage("E.Q Error");
            die;
        }
    }

    final public function GetData($result_resource, $type = PDO::FETCH_ASSOC)
    {
        try {
            $rowCount = $result_resource->rowCount();
            if ($rowCount > 0) {
                return $result_resource->fetch($type);
            }
            return $rowCount;
        } catch (PDOException $e) {
            debug_log("Connection Error (GetData)\r\n" . $e->getMessage() . "\r\n" . $e->getTraceAsString(), $this->logFileName);
            responseMessage("G.D Error");
            die;
        }
    }

    final public function Close()
    {
        if (is_resource($this->db)) {
            $this->db = null;
        }
    }
}
