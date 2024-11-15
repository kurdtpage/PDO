# PDO
## Select
```
╔══════════╤═════════════════════════════════════════╤══════════════════════════════════════════════════╗
║          │ Placeholders no (query)                 │ Placeholders yes (prepare, execute)              ║
╟──────────┼─────────────────────────────────────────┼──────────────────────────────────────────────────╢
║ Single   │                                         │ $params = ['id' => $id];                         ║
║ row      │ $a_json['sql'] = $pdo->niceQuery($sql); │ $a_json['sql'] = $pdo->niceQuery($sql, $params); ║
║          │ $stmt = $pdo->run($sql);                │ $stmt = $pdo->run($sql, $params);                ║
║          │ if ($table = $stmt->fetch()) {          │ if ($table = $stmt->fetch()) {                   ║
║          │     $a_json['id'] = $table['id'];       │     $a_json['id'] = $table['id'];                ║
║          │ } else {                                │ } else {                                         ║
║          │     //no data                           │     //no data                                    ║
║          │ }                                       │ }                                                ║
╟──────────┼─────────────────────────────────────────┼──────────────────────────────────────────────────╢
║ Multiple │                                         │ $params = ['id' => $id];                         ║
║ rows     │ $a_json['sql'] = $pdo->niceQuery($sql); │ $a_json['sql'] = $pdo->niceQuery($sql, $params); ║
║          │ $stmt = $pdo->run($sql);                │ $stmt = $pdo->run($sql, $params);                ║
║          │ while ($table = $stmt->fetch()) {       │ while ($table = $stmt->fetch()) {                ║
║          │     $a_json['id'] = $table['id'];       │     $a_json['id'] = $table['id'];                ║
║          │ }                                       │ }                                                ║
╚══════════╧═════════════════════════════════════════╧══════════════════════════════════════════════════╝
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
