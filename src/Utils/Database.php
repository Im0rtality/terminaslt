<?php

namespace Utils;

class Database
{
    private $link;

    public $log = array();

    public function __construct($host, $user, $pass, $database)
    {
        $this->link = mysql_connect($host, $user, $pass);
        if (!$this->link) {
            throw new \Exception('Could not connect: ' . mysql_error());
        }
        $dbSelected = mysql_select_db($database, $this->link);
        if (!$dbSelected) {
            throw new \Exception('Can\'t use database: ' . mysql_error());
        }
        mysql_set_charset('utf8');
    }

    public function rawQuery($query)
    {
        $result    = mysql_query($query);
        $this->log = array($query, is_bool($result) ? $result : true);

        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            throw new \Exception($message);
        }

        $data = null;
        if (is_resource($result)) {
            $data = array();
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }

            mysql_free_result($result);
        }

        return $data;
    }

    public function insert($table, $fields, $values)
    {
        $fields = sprintf('(%s)', implode(',', $fields));
        $values = sprintf('("%s")', implode('","', $this->escape($values)));
        $query  = sprintf('INSERT INTO `%s` %s VALUES %s', $table, $fields, $values);

        return $this->rawQuery($query);
    }

    public function select($table, $fields, $where = array(), $order = null, $limit = null)
    {
        $fields = $this->buildFields($fields);
        $sWhere = $this->buildWhere($where);
        $query = $this->buildQuery($table, $fields, $order, $limit, $sWhere);

        return $this->rawQuery($query);
    }

    public function update($table, $fields, $values, $where = array(), $limit = null)
    {
        $sfields = '';
        for ($i = 0; $i < count($fields); $i++) {
            $sfields .= sprintf(', %s = %s', $fields[$i], $this->escape($values[$i]));
        }
        $sfields = ltrim($sfields, ', ');

        if (is_array($where)) {
            $swhere = '';
            foreach ($where as $key => $value) {
                $value = $this->escape($value);
                if (is_string($value)) {
                    $value = '"' . $value . '"';
                }
                $swhere .= sprintf(' AND (%s = %s)', $key, $value);
            }
            $swhere = empty($where) ? '' : ' WHERE ' . ltrim($swhere, ' AND ');
        } else {
            $swhere = ' WHERE ' . $where;
        }

        $query = sprintf(
            'UPDATE %s SET %s %s%s',
            $table,
            $sfields,
            $swhere,
            ($limit !== null) ? ' LIMIT ' . $limit : ""
        );

        // debug($query);
        return $this->rawQuery($query);
    }

    public function escape($data)
    {
        if (is_array($data)) {
            foreach ($data as &$field) {
                if (is_string($field)) {
                    $field = mysql_real_escape_string($field);
                }
            }
        } elseif (is_string($data)) {
            return mysql_real_escape_string($data);
        }

        return $data;
    }

    public function __destruct()
    {
        mysql_close($this->link);
    }

    /**
     * @param $table
     * @param $fields
     * @param $order
     * @param $limit
     * @param $swhere
     *
     * @return string
     */
    protected function buildQuery($table, $fields, $order, $limit, $swhere)
    {
        $query = sprintf(
            'SELECT %s FROM `%s` %s%s%s',
            $fields,
            $table,
            $swhere,
            ($order !== null) ? ' ORDER BY ' . $order : "",
            ($limit !== null) ? ' LIMIT ' . $limit : ""
        );
        return $query;
    }

    /**
     * @param $fields
     *
     * @return string
     */
    protected function buildFields($fields)
    {
        $fields = sprintf('%s', (is_array($fields) ? implode(',', $fields) : $fields));
        return $fields;
    }

    /**
     * @param $where
     *
     * @return string
     */
    protected function buildWhere($where)
    {
        if (is_array($where)) {
            $swhere = '';
            foreach ($where as $key => $value) {
                $value = $this->escape($value);
                if (is_string($value)) {
                    $value = '"' . $value . '"';
                }
                $swhere .= sprintf(' AND (%s = %s)', $key, $value);
            }
            $swhere = empty($where) ? '' : ' WHERE ' . ltrim($swhere, ' AND ');
            return $swhere;
        } else {
            $swhere = ' WHERE ' . $where;
            return $swhere;
        }
    }
}
