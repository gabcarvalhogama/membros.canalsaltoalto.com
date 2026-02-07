ALTER TABLE `csa_users` 
ADD COLUMN `referral_code` VARCHAR(50) DEFAULT NULL AFTER `user_type`,
ADD COLUMN `referred_by` INT(11) DEFAULT NULL AFTER `referral_code`;

ALTER TABLE `csa_users`
ADD UNIQUE INDEX `idx_referral_code` (`referral_code`);
