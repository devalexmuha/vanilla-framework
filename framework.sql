-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2026 at 09:13 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `slug` text NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `name`, `description`) VALUES
(5, 'start-before-you-feel-ready', 'Start Before You Feel Ready', 'Waiting to feel ready is the quietest way to stay exactly where you are. Confidence is not the ticket you buy before the ride; it is the souvenir you collect after. Every person you admire began clumsy, unsure, and a little afraid, and they moved anyway. So take the smaller version of the brave step today: send the message, open the file, write the first ugly sentence, lace up your shoes. Motion creates a clarity that thinking never will. You do not need the whole staircase, only the courage to meet the first step. Begin now, while it still feels too soon, because too soon is simply what the beginning of something good always feels like..'),
(6, 'small-steps-big-momentum', 'Small Steps, Big Momentum', 'Big goals rarely fall in one heroic swing; they fall to the steady tap of small, repeated effort. A single push-up, one paragraph, five focused minutes, a glass of water, a short walk. These look almost too small to matter, and that is exactly their power. They are easy enough to do on your worst day, and worst days are precisely when momentum is built. Do not chase the perfect plan or the perfect mood. Chase the next tiny action, then the next, and let them stack. Consistency compounds quietly, and one morning you will look back at a mountain you climbed one pebble at a time. Keep your steps small and your streak alive; the size of the step never mattered as much as the fact that you took it.'),
(7, 'your-energy-is-contagious', 'Your Energy Is Contagious', 'Never underestimate the ripple you send into a room. A genuine smile, a kind word, a moment of patience: these travel further than you will ever see. The people around you are quietly reading your energy, and warmth spreads faster than you think. On the days you feel you have little to give, remember that lifting someone else is one of the surest ways to lift yourself. Encouragement is free, and yet it can change the entire direction of somebody\'s day, maybe their whole week. So choose to be the reason someone breathes easier. Be generous with your good mood, protect it from small annoyances, and share it on purpose. The light you carry does not shrink when you pass it on; it multiplies.'),
(8, 'progress-over-perfection', 'Progress Over Perfection', 'Perfection is a beautiful lie that keeps good work hidden in a drawer. Nothing finished is ever flawless, and nothing flawless is ever finished. The draft you are embarrassed by today is still miles ahead of the masterpiece you never started. Give yourself permission to be a beginner, to make messy attempts, to learn in public and improve in private. Every expert was once a disaster who refused to quit. Measure your day not by whether it was perfect, but by whether it moved. Did you show up? Did you try? Did you learn one small thing? Then it counted. Trade the impossible standard for a kinder, sharper question: is this better than yesterday? If the answer is yes, you are exactly where you need to be.'),
(9, 'today-is-a-fresh-page', 'Today Is a Fresh Page', 'Whatever yesterday held, it has already handed you the pen. Today arrives clean, unwritten, and completely yours to shape. You are not the mistakes you made or the chances you missed; you are what you choose to do next. Take a slow breath and notice that this moment is a genuine beginning, not a continuation of every regret you have been carrying. Set one gentle intention. Do one thing that your future self will thank you for. Let the small wins be enough, and let the hard parts feel lighter because you faced them anyway. The story is not over, and the best chapters are rarely the early ones. Pick up the pen, sit with a little hope, and write a line worth reading. This page is fresh, and so are you.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `hash`, `image_url`) VALUES
(1, 'Giraf', 'giraf@vc.com', '$2y$10$3aUxn4VmMI/70Vg7Vxl3t.JFG1sIORBZNXrE.ulYFjxbYIkt5KbjC', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
