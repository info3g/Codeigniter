<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-12-13 00:20:23 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 00:28:28 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 00:28:37 --> Query error: Unknown column 'b.district' in 'field list' - Invalid query: SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand, b.district, b.development FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a WHERE r.`building_ID` =6 AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.`system_ID`, r.`access`
ERROR - 2016-12-13 00:28:37 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 620
ERROR - 2016-12-13 00:30:03 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 00:45:45 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 00:45:51 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:17:55 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:18:00 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:18:11 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:18:14 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:27:18 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:28:01 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:28:36 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:28:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:28:42 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:29:00 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:29:05 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:29:05 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:29:16 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:29:17 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:29:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:29:44 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:29:58 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:29:59 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:30:37 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:30:37 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:30:51 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:30:51 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:31:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:31:18 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:38:11 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:38:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:38:18 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:39:12 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:39:22 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:39:26 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:39:26 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:39:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:39:38 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:40:34 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:40:34 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:44:00 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:44:00 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:44:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:44:20 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:45:17 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:45:17 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:45:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:45:41 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:45:55 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:45:57 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:48:11 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:48:11 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:48:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:48:39 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:52:14 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:52:14 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:52:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:52:27 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:56:08 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:56:09 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 01:56:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 01:56:16 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 01:56:27 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 01:56:29 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:14:44 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:14:44 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:17:37 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:17:40 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:17:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 02:17:55 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 02:20:41 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:20:41 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:21:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 02:21:06 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 02:23:41 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:23:41 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:23:57 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:24:35 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:25:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AND `trash` =0' at line 1 - Invalid query: SELECT `location_id` FROM `location` WHERE `l_id` IN ( 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 93, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67, 67,  ) AND `trash` =0
ERROR - 2016-12-13 02:25:39 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 599
ERROR - 2016-12-13 02:30:03 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:30:03 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:33:38 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:33:38 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:34:57 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:34:58 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:35:08 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:35:08 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 02:50:09 --> 404 Page Not Found: Reports/district_summary
ERROR - 2016-12-13 02:50:12 --> Severity: Parsing Error --> syntax error, unexpected end of file /home/ginfo/public_html/ecohca/application/controllers/Reports.php 1262
ERROR - 2016-12-13 02:51:57 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 02:51:57 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 04:55:56 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-12-13 04:56:04 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 04:56:19 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 04:56:32 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:49:34 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:49:46 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:49:58 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:50:36 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:53:27 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:54:07 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 05:54:11 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:12:41 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:12:58 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:14:01 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:14:05 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:15:07 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:15:07 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:22:52 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:22:54 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:25:46 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:25:46 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:33:16 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:33:16 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:39:09 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:39:09 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:44:20 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:44:20 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:45:59 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:45:59 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:46:11 --> Severity: Error --> Unsupported operand types /home/ginfo/public_html/ecohca/application/controllers/Reports.php 2069
ERROR - 2016-12-13 06:47:18 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:47:20 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:49:50 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:49:51 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:51:04 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:51:04 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:52:42 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:52:42 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:53:57 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:53:58 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 06:54:51 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 06:54:51 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:17:44 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:17:44 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:20:49 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:20:51 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:23:55 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:23:55 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:38:41 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:39:21 --> Severity: Error --> Call to undefined method Location_model::get_development_name_b() /home/ginfo/public_html/ecohca/application/controllers/Reports.php 2034
ERROR - 2016-12-13 07:40:25 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:40:38 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:40:51 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:42:07 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:42:15 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:43:08 --> Severity: Error --> Call to undefined method Location_model::get_development_name_b() /home/ginfo/public_html/ecohca/application/controllers/Reports.php 2034
ERROR - 2016-12-13 07:44:17 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:44:17 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:44:24 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:44:26 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:44:36 --> Severity: Error --> Call to undefined method Location_model::get_development_name_b() /home/ginfo/public_html/ecohca/application/controllers/Reports.php 2034
ERROR - 2016-12-13 07:46:03 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:46:04 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:46:15 --> Severity: Error --> Call to undefined method Location_model::get_development_name_b() /home/ginfo/public_html/ecohca/application/controllers/Reports.php 2034
ERROR - 2016-12-13 07:47:28 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:47:28 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:49:30 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:49:30 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:49:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT development FROM `building` where `building_ID` = 
ERROR - 2016-12-13 07:49:54 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 630
ERROR - 2016-12-13 07:50:11 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:50:12 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:51:14 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:51:15 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:51:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT development FROM `building` where `building_ID` = 
ERROR - 2016-12-13 07:51:26 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 630
ERROR - 2016-12-13 07:52:22 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:52:22 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:52:31 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:52:34 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 07:52:44 --> Query error: Unknown column 'building_ID' in 'where clause' - Invalid query: SELECT development FROM `building` where `building_ID` = 6
ERROR - 2016-12-13 07:52:44 --> Severity: Error --> Call to a member function result() on a non-object /home/ginfo/public_html/ecohca/application/models/Building_model.php 630
ERROR - 2016-12-13 07:54:30 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 07:54:30 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:08:19 --> 404 Page Not Found: Assets/css
ERROR - 2016-12-13 08:08:20 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:08:24 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:08:35 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:08:37 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:08:39 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:09:22 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:09:36 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:09:39 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:09:53 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:09:56 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 08:19:10 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-12-13 08:20:10 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 09:17:27 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-12-13 09:17:30 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 10:00:52 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 10:01:02 --> 404 Page Not Found: Assets/images
ERROR - 2016-12-13 10:02:42 --> 404 Page Not Found: Assets/images
