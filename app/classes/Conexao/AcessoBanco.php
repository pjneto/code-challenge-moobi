<?php

namespace CodeChallengeMoobi\Conexao;

class AcessoBanco
{
    private $instance;
    private $drive;
    private $host;
    private $usuario;
    private $senha;
    private $database;

    public function __construct()
    {
        $this->drive = DRIVE;
        $this->host = HOST;
        $this->database = DATABASE;
        $this->usuario = USUARIO;
        $this->senha = SENHA;
    }

    public function select($table, array $columns = [])
    {
        $query = "SELECT ";

        if (! empty($columns)) {
            $i = 0;
            $total = count($columns);

            foreach ($columns as $key => $column) {
                $i++;

                if ($i == $total) {
                    $query = $query . '`' . $column . '`';
                } else {
                    $query = $query . '`' .$column . '`' . ", ";
                }
            }
            $query = $query . " FROM {$table};";

            return $this->prepare($query, true);
        }
        
        $query = "SELECT * FROM {$table};";

        return $this->prepare($query, true);
    }

    public function selectById($table, $id, $key)
    {
        $query = "SELECT * FROM {$table} WHERE {$key} = {$id}";

        return $this->prepare($query, true);
    }

    private function prepare($query = null, $select = false)
    {
        try {
            $instance = new \PDO(
                $this->drive . ':host='. $this->host .';dbname='.$this->database.'', ''.$this->usuario.'', ''.$this->senha.''
            );
            
            if (! $select){
                return $instance;
            }

            $p_sql = $instance->prepare($query);
            $p_sql->execute();

            return $p_sql->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $th) {
           return $th->getMessage();
        }
        
    }

    public function insert($table, array $data = [])
    {
        try {
            $sql = "INSERT INTO {$table} ( ";      

            $x = count($data);
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;
                if ($i == $x) {
                    $sql = $sql . $key;
                } else {
                    $sql = $sql . $key . ', ';
                }
                    
            }
            $sql = $sql . ') VALUES (';

            $x = count($data);
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;
                if ($i == $x) {
                    $sql = $sql . ':' . $key;
                } else {
                    $sql = $sql . ':' . $key . ', ';
                }
            }
            $sql = $sql . ')';

            $cn = $this->prepare();
            $stmt = $cn->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
                
            }

            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function lastInsertId($table, $chave)
    {
        $query = "SELECT MAX({$chave}) AS {$chave} FROM {$table}";

        return $this->prepare($query, true);
    }

    public function update($table, array $data = [], $id, $chave)
    {
        try {
            $sql = "UPDATE {$table} SET ";      

            $x = count($data);
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;
                if ($i == $x) {
                    $sql = $sql . $key . ' = ' . ':' . $key;
                } else {
                    $sql = $sql . $key . ' = ' . ':' . $key.' , ';
                }     
            }
            $sql = $sql . " WHERE $chave = {$id}";

            $cn = $this->prepare();
            $stmt = $cn->prepare($sql);
            foreach ($data as $key => $value) {
                    $stmt->bindValue(":{$key}", $value);   
            }

            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($table, $id, $key)
    {
        try{
            $query = "DELETE FROM {$table} WHERE {$key} = :id";
            $cn = $this->prepare();
            $stmt = $cn->prepare($query);
            $stmt->bindValue(":id", $id); 

            return $stmt->execute();
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}