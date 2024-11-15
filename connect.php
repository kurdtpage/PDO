<?php

/*
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
*/

class MyPDO extends PDO {
	public function run($sql, $data = [])
	{
		if (count($data) == 0) {
			$stmt = $this->query($sql);
		} else {
			$stmt = $this->prepare($sql);
			$stmt->execute($data);
		}
		return $stmt;
	}

	/**
	 * Prints out nice SQL
	 * @param {string} $sql The SQL query, this will have named placeholders prefaced with a colon
	 * @param {array} $data The data that goes in the placeholders of the string
	 * @returns Nice SQL string
	 */
	public function niceQuery($sql, $data)
	{
		// Loop through each key-value pair in the data array
		foreach ($data as $key => $value) {
			// Create a placeholder string to match named placeholders in the SQL
			$placeholder = ':' . $key;
			// Replace the named placeholder with the corresponding value in the SQL string
			$sql = str_replace($placeholder, '"' . $value . '"', $sql);
		}
		// Return the modified SQL string
		return $sql;
	}
}

require_once 'credentials.php';

$dsn = "mysql:host=$hostname;dbname=$database;charset=$char_set";
$options = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new MyPDO($dsn, $username, $password, $options);
