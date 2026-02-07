ALTER TABLE `csa_users` ADD COLUMN `referral_code` VARCHAR(50) UNIQUE DEFAULT NULL AFTER `user_type`;
ALTER TABLE `csa_users` ADD COLUMN `referred_by` INT(11) DEFAULT NULL AFTER `referral_code`;
