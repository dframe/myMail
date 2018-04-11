--
-- Struktura tabeli dla tabeli `mails`
--

CREATE TABLE `mails` (
  `mail_id` int(11) NOT NULL,
  `mail_name` varchar(255) NOT NULL,
  `mail_address` varchar(255) NOT NULL,
  `mail_sender` varchar(255) DEFAULT NULL,
  `mail_subject` varchar(1024) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_enqueued` int(11) NOT NULL COMMENT 'Unix timestamp zakolejkowania',
  `mail_sent` int(11) NOT NULL DEFAULT '0' COMMENT 'Unix timestamp wyslania',
  `mail_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - nie wyslane, 1 - wyslane',
  `mail_buffer_date` datetime NOT NULL,
  `mail_send_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maile do wyslania';


--
-- Struktura tabeli dla tabeli `mails_attachments`
--

CREATE TABLE `mails_attachments` (
  `mail_attachment_id` int(11) NOT NULL,
  `mail_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`mail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `mails`
--
ALTER TABLE `mails`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

--
-- Indexes for table `mails_attachments`
--
ALTER TABLE `mails_attachments`
  ADD KEY `mail_attachment_id` (`mail_attachment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `mails_attachments`
--
ALTER TABLE `mails_attachments`
  MODIFY `mail_attachment_id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
