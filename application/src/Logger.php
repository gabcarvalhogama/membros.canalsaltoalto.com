<?php
/**
 * DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY
 */
class Logger {
    public static function log($level, $message, $userId = null) {
        try {
            $sql = DB::open()->prepare("INSERT INTO csa_logs (`user_id`, `level`, `message`) VALUES (:user_id, :level, :message)");
            return $sql->execute([
                ':user_id' => $userId,
                ':level' => $level,
                ':message' => $message
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao registrar log: " . $e->getMessage());
        }
    }
}
