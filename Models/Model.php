<?php 
abstract class Model {
    protected static string $table;
    protected static string $primary_key = "id";


    public static function find(mysqli $conc, int $id) {
        $sql = sprintf("SELECT * FROM %s WHERE %s = ?", 
                      static::$table, 
                      static::$primary_key);
        
        $query = $conc->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $conc) {
        $sql = sprintf("SELECT * FROM %s", static::$table);
        
        $query = $conc->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()) {
            $objects[] = new static($row);
        }

        return $objects;
    }

    public static function create(mysqli $conc, array $data): bool {
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));

    $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, $columns, $placeholders);

    $stmt = $conc->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: " . $conc->error;
        return false;
    }

    $types = str_repeat("s", count($data)); 
    $stmt->bind_param($types, ...array_values($data));

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error: " . $stmt->error;
        return false;
    }
}


    public function update(mysqli $conc, array $data): bool {
        $setClause = implode(" = ?, ", array_keys($data)) . " = ?";
        $types = str_repeat("s", count($data) + 1); 
        
        $sql = sprintf("UPDATE %s SET %s WHERE %s = ?", 
                    static::$table, 
                    $setClause, 
                    static::$primary_key);
        
        $values = array_values($data);
        $values[] = $this->{static::$primary_key};
        
        $stmt = $conc->prepare($sql);
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }

}