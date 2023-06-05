<?php



$installer = $this;

$installer->startSetup();

$installer->run("


ALTER TABLE {$this->getTable('vendor')}
  ADD PRIMARY KEY (`vendor_id`);

ALTER TABLE {$this->getTable('vendor')}
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

");

$installer->endSetup();