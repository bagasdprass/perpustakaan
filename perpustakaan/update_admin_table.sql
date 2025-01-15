ALTER TABLE `admin` 
ADD COLUMN `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `id_admin` varchar(255) NOT NULL AFTER `id`; 