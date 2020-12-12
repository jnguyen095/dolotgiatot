alter table oc_customer drop column firstname;
ALTER TABLE `oc_customer` CHANGE `lastname` `fullname` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `oc_customer` add unique(telephone);