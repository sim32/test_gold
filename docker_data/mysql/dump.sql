SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

ALTER DATABASE `test_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `tbl_role`(`id`, `title`) VALUES (1,'administrator'),(2,'user');
INSERT INTO `tbl_user` (`id`, `name`, `phone`, `email`, `role_id`) VALUES
(1, 'admin', '74951234567', 'admin@admin.ru', 1);