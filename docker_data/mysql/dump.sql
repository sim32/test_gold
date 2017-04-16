SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `tbl_permission` (
  `id` int(11) NOT NULL,
  `route` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tbl_permission` (`id`, `route`, `role_id`) VALUES
  (1, 'user/login', NULL),
  (2, 'user/index', 1),
  (3, 'user/index', 2),
  (4, 'admin/index', 1),
  (5, 'admin/edit', 1),
  (6, 'admin/delete', 1);

CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tbl_role` (`id`, `title`) VALUES
  (1, 'administrator'),
  (2, 'user');

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tbl_user` (`id`, `name`, `phone`, `email`, `password`, `role_id`, `active`) VALUES
  (1, 'admin', '74951234567', 'admin@admin.ru', '805bd059fc14f9971538cee40c3a7c0b', 1, 1);

ALTER TABLE `tbl_permission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `tbl_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;