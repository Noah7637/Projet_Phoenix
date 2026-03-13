<?php


namespace ProjetA2Phoenix2026\Models;

class UserManager {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = new \PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8', USER, PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    public function create(string $username, string $email, string $password): int {
        // vérifie unicité avant insert pour éviter exception de contrainte
        if ($this->existsByUsername($username)) {
            throw new \RuntimeException('username_exists');
        }
        if ($this->existsByEmail($email)) {
            throw new \RuntimeException('email_exists');
        }

        $stmt = $this->pdo->prepare('INSERT INTO tp_accounts (username, email, password) VALUES (:username, :email, :password)');
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function find(string $username): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM tp_accounts WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user) $this->ensureIdKey($user);
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM tp_accounts WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) $this->ensureIdKey($user);
        return $user ?: null;
    }

    public function store(string $username, string $email, string $password): int {
        // wrapper compatible : utilise create
        return $this->create($username, $email, $password);
    }

    public function existsByEmail(string $email): bool {
        $stmt = $this->pdo->prepare('SELECT 1 FROM tp_accounts WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return (bool)$stmt->fetchColumn();
    }

    public function existsByUsername(string $username): bool {
        $stmt = $this->pdo->prepare('SELECT 1 FROM tp_accounts WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        return (bool)$stmt->fetchColumn();
    }

    public function getBdd()
    {
        return $this->pdo;
    }

    private function ensureIdKey(array &$user): void {
        if (!isset($user['id'])) {
            foreach (['user_id', 'ID', 'uid', 'userid', 'userId'] as $possible) {
                if (isset($user[$possible])) {
                    $user['id'] = $user[$possible];
                    break;
                }
            }
        }
    }

    public function find2($name, $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tp_accounts WHERE username = ? AND id_account = ?");
        $stmt->execute(array(
            $name,
            $id
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "ProjetA2Phoenix2026\Models\User");

        return $stmt->fetch()->getId();
    }
}