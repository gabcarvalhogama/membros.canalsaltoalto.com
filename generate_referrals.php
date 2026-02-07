<?php
// Não vamos incluir o autoload para evitar usar a classe DB original que está falhando
// require_once __DIR__ . '/application/autoload.php';

echo "Iniciando migração de códigos de indicação (Direct PDO)...\n";

try {
    // Tentando conectar com 127.0.0.1 para evitar problemas de resolução de localhost no Windows
    $dsn = "mysql:host=127.0.0.1;dbname=u364550838_csa;charset=utf8mb4";
    $username = "u364550838_csa";
    $password = "4;bo#sQ/d2O";
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set lc_time_names="pt_BR"');
    
    $db = new PDO($dsn, $username, $password, $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    die("Falha na conexão: " . $e->getMessage() . "\n");
}



$sql = $db->query("SELECT iduser, firstname, lastname FROM csa_users WHERE referral_code IS NULL");
$users = $sql->fetchAll(PDO::FETCH_OBJ);

echo "Encontrados " . count($users) . " usuários para processar.\n";

$count = 0;
foreach ($users as $user) {
    // Gerar código: 3 primeiras letras do nome (limpo) + ID + 2 caracteres aleatórios
    $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', $user->firstname);
    $cleanName = strtoupper(substr($cleanName, 0, 3));
    if (strlen($cleanName) < 3) {
        $cleanName = str_pad($cleanName, 3, 'X');
    }
    
    // Gerar string aleatória de 3 caracteres
    $randomStr = strtoupper(substr(md5(uniqid()), 0, 3));
    
    $referralCode = $cleanName . $user->iduser . $randomStr;
    
    // Atualizar usuário
    $update = $db->prepare("UPDATE csa_users SET referral_code = :code WHERE iduser = :id");
    try {
        $result = $update->execute([
            ':code' => $referralCode,
            ':id' => $user->iduser
        ]);
        
        if ($result) {
            $count++;
            echo "Usuário {$user->iduser}: Código {$referralCode} gerado.\n";
        }
    } catch (Exception $e) {
        echo "Erro ao gerar código para usuário {$user->iduser}: " . $e->getMessage() . "\n";
    }
}

echo "Migração concluída! {$count} usuários atualizados.\n";
