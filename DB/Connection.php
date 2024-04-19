    <?php
require_once 'config.php';
final class Connection
{
    private static ?self $instance = null;
    private static ?PDO $connection = null;
    private static string $dsn = 'mysql:host=' . DB_HOST .';port='. DB_PORT . ';dbname='. DB_NAME;
    private static string $username = DB_USERNAME;
    private static string $password = DB_PASSWORD;


    private function __construct()
    {
        try {
            self::$connection = new PDO(
                self::$dsn,
                self::$username,
                self::$password
            );
        } catch (PDOException $e) {
            echo "PDO Connection Error: " . $e->getMessage();
        }
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getConnection(): ?PDO
    {
        return self::$connection;
    }
}

$pdo = Connection::getInstance()::getConnection();
$queryGetMessages = "SELECT users.name, users.email, users.avatar, messages.message, messages.file, messages.date
    FROM users
    INNER JOIN messages
    ON users.id=messages.user_id;";

$qryMessages = $pdo->prepare($queryGetMessages);
$qryMessages->execute();
print_r($qryMessages->fetchAll(PDO::FETCH_ASSOC));