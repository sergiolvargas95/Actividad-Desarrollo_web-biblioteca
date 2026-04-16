-- ============================================================
-- Migration: 000_create_users_table
-- Description: Create the users table
-- ============================================================

CREATE TABLE IF NOT EXISTS `users` (
    `id`         VARCHAR(36)                                NOT NULL,
    `name`       VARCHAR(255)                               NOT NULL,
    `email`      VARCHAR(255)                               NOT NULL,
    `password`   VARCHAR(255)                               NOT NULL,
    `role`       ENUM('ADMIN', 'USER', 'GUEST')             NOT NULL,
    `status`     ENUM('ACTIVE', 'INACTIVE', 'PENDING', 'BLOCKED') NOT NULL DEFAULT 'PENDING',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`),
    KEY `idx_users_role`   (`role`),
    KEY `idx_users_status` (`status`)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
