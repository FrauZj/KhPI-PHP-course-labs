-- Дамп бази даних `started`
-- Створено: 2025-10-23 09:28:03

--
-- Структура таблиці `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--
INSERT INTO `users` VALUES ('1', '123', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-10-23 09:16:11'),
('2', '333', 'admin222@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-10-23 09:23:41'),
('3', '4444', 'rr@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-10-23 09:26:38'),
('4', '3335455', '222rr@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-10-23 09:27:31');

