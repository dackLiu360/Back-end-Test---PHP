<?php

require 'config.php';

$statement = <<<EOS

    DROP TABLE IF EXISTS `users`, `addresses`, `cities`, `states`;

    CREATE TABLE `users`
    (
        `id`       BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
        `username` VARCHAR(255) NOT NULL,
        `password` VARCHAR(255) NOT NULL
    );
    
    ALTER TABLE `users`
    ADD UNIQUE `users_username_unique`(`username`);

    CREATE TABLE `addresses`
    (
        `id`      BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
        `fk_user` BIGINT UNSIGNED NOT NULL,
        `address` VARCHAR(255) NOT NULL
    );

    ALTER TABLE `addresses`
    ADD CONSTRAINT `addresses_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES
    `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

    ALTER TABLE `addresses`
    ADD UNIQUE `addresses_fk_user_unique`(`fk_user`);

    CREATE TABLE `cities`
    (
        `id`      BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
        `fk_user` BIGINT UNSIGNED NOT NULL,
        `city`    VARCHAR(255) NOT NULL
    );

    ALTER TABLE `cities`
    ADD CONSTRAINT `cities_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES
    `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

    ALTER TABLE `cities`
    ADD UNIQUE `cities_fk_user_unique`(`fk_user`);

    CREATE TABLE `states`
    (
        `id`      BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
        `fk_user` BIGINT UNSIGNED NOT NULL,
        `state`   VARCHAR(255) NOT NULL
    );

    ALTER TABLE `states`
    ADD CONSTRAINT `states_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES
    `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

    ALTER TABLE `states`
    ADD UNIQUE `states_fk_user_unique`(`fk_user`);

EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
?>