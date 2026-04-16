-- ============================================================
-- Migration: 001_create_bibliotecas_table
-- Description: Create the bibliotecas table
-- ============================================================

CREATE TABLE IF NOT EXISTS `bibliotecas` (
    `id`               VARCHAR(36)   NOT NULL,
    `nombre`           VARCHAR(255)  NOT NULL,
    `direccion`        VARCHAR(255)  NOT NULL,
    `ciudad`           VARCHAR(100)  NOT NULL,
    `pais`             VARCHAR(100)  NOT NULL,
    `telefono`         VARCHAR(20)   NOT NULL,
    `email`            VARCHAR(255)  NOT NULL,
    `horario_apertura` VARCHAR(5)    NOT NULL COMMENT 'Formato HH:MM',
    `horario_cierre`   VARCHAR(5)    NOT NULL COMMENT 'Formato HH:MM',
    `num_libros`       INT UNSIGNED  NOT NULL DEFAULT 0,
    `num_usuarios`     INT UNSIGNED  NOT NULL DEFAULT 0,
    `es_publica`       TINYINT(1)    NOT NULL DEFAULT 0,
    `web`              VARCHAR(500)  NOT NULL DEFAULT '',
    `created_at`       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_bibliotecas_nombre` (`nombre`),
    KEY `idx_bibliotecas_ciudad` (`ciudad`),
    KEY `idx_bibliotecas_pais`   (`pais`)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
