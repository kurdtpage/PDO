# PDO
## Select
Placeholders no, single row:
```
$a_json['sql'] = $pdo->niceQuery($sql);
$stmt = $pdo->run($sql);
if ($table = $stmt->fetch()) {
    $a_json['id'] = $table['id'];
} else {
    //no data
}
```
Placeholders no, multiple rows:
```
$params = ['id' => $id];
$a_json['sql'] = $pdo->niceQuery($sql, $params);
$stmt = $pdo->run($sql, $aprams);
if ($table = $stmt->fetch()) {
    $a_json['id'] = $table['id'];
} else {
    //no data
}
```
Placeholders yes, single row:
```
$a_json['sql'] = $pdo->niceQuery($sql);
$stmt = $pdo->run($sql);
while ($table = $stmt->fetch()) {
    $a_json['id'] = $table['id'];
}
```
Placeholders yes, multiple rows:
```
$params = ['id' => $id];
$a_json['sql'] = $pdo->niceQuery($sql, $params);
$stmt = $pdo->run($sql, $aprams);
while ($table = $stmt->fetch()) {
    $a_json['id'] = $table['id'];
}
```

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
