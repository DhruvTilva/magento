<?php



$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE {$this->getTable('vendor_address')} (
  `address_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  ALTER TABLE {$this->getTable('vendor_address')}
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `vendor_id` (`vendor_id`);

  ALTER TABLE {$this->getTable('vendor_address')}
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  ALTER TABLE {$this->getTable('vendor_address')}
  ADD CONSTRAINT `vendor_address_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES {$this->getTable('vendor')} (`vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

");

$installer->endSetup();