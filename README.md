# PDO
## Select
![image](https://github.com/user-attachments/assets/0555dc3a-d5d7-4b05-b695-24cb9feeddb6)

## Insert
```
$sql = 'INSERT INTO users (
	first, last
) VALUES (
	:first, :last
)';
$params = [
	'first' => $first,
	'last' => $last,
];
$a_json['sql'] = $pdo->niceQuery($sql, $params);
$pdo->run($sql, $params);
$id = $pdo->lastInsertId();
```

## Update
```
$sql = 'UPDATE users SET
	first = :first,
	last = :last
WHERE
	id = :id';
$params = [
	'first' => $first,
	'last' => $last,
	'id' => $id,
];
$a_json['sql'] = $pdo->niceQuery($sql, $params);
$pdo->run($sql, $params);
$affected_rows = $stmt->rowCount();
```
