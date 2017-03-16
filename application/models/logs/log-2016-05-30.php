<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-05-30 01:00:27 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-05-30 01:00:34 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 01:00:49 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 01:00:54 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 97
ERROR - 2016-05-30 01:00:54 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 111
ERROR - 2016-05-30 01:00:54 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 125
ERROR - 2016-05-30 01:00:54 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 139
ERROR - 2016-05-30 01:00:54 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 01:00:57 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 01:20:50 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/reports/development_summary.php 83
ERROR - 2016-05-30 01:20:51 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:40:02 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-05-30 03:40:04 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:40:08 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:40:10 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 97
ERROR - 2016-05-30 03:40:10 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 111
ERROR - 2016-05-30 03:40:10 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 125
ERROR - 2016-05-30 03:40:10 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 139
ERROR - 2016-05-30 03:40:11 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:40:16 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:40:21 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:50:52 --> 404 Page Not Found: Reports/all_list_report
ERROR - 2016-05-30 03:50:59 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:54:25 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:55:31 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 03:58:28 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 03:58:28 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 03:59:43 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 04:01:00 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 04:13:10 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 04:16:56 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:52:07 --> 404 Page Not Found: Images/trans_emblem.png
ERROR - 2016-05-30 07:52:12 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:52:31 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:52:34 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 97
ERROR - 2016-05-30 07:52:34 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 111
ERROR - 2016-05-30 07:52:34 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 125
ERROR - 2016-05-30 07:52:34 --> Severity: Notice --> Trying to get property of non-object /home/ecoh/public_html/ecohca/application/views/building/list_building.php 139
ERROR - 2016-05-30 07:52:35 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:52:37 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:52:55 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:55:28 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 07:56:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY r.`material_identi`' at line 1 - Invalid query: SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` =6 AND r.`system_ID` IN ( 79,2,2,2,80,2,2,2,3,3,3,3,1,1,2 ) AND r.`material_identi` IN (12,13,14,15,16,17,18,19,20,21,22,23,24,25,26) AND r.`r_hazard` = 'Confirmed Asbestos' AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good` =300 AND r.`poor` =200 AND r.`fair` =50 AND r.`debris` = GROUP BY r.`material_identi`
ERROR - 2016-05-30 07:56:35 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:04:21 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:04:21 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:04:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY r.`material_identi`' at line 1 - Invalid query: SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` =6 AND r.`system_ID` IN ( 79,2,2,2,80,2,2,2,3,3,3,3,1,1,2 ) AND r.`material_identi` IN (12,13,14,15,16,17,18,19,20,21,22,23,24,25,26) AND r.`r_hazard` = 'Confirmed Asbestos' AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good` =300 AND r.`poor` =200 AND r.`fair` =50 AND r.`debris` = GROUP BY r.`material_identi`
ERROR - 2016-05-30 08:04:36 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/ecoh/public_html/ecohca/application/controllers/Reports.php:2712) /home/ecoh/public_html/ecohca/system/core/Common.php 568
ERROR - 2016-05-30 08:07:57 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:07:57 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:08:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ecoh/public_html/ecohca/application/controllers/Reports.php 2734
ERROR - 2016-05-30 08:08:55 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:08:55 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:08:58 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:08:58 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:09:09 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:09:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY r.`material_identi`' at line 1 - Invalid query: SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` =6 AND r.`system_ID` IN ( 79,2,2,2,80,2,2,2,3,3,3,3,1,1,2 ) AND r.`material_identi` IN (12,13,14,15,16,17,18,19,20,21,22,23,24,25,26) AND r.`r_hazard` = 'Confirmed Asbestos' AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good` =160 AND r.`poor` =0 AND r.`fair` =0 AND r.`debris` = GROUP BY r.`material_identi`
ERROR - 2016-05-30 08:09:11 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/ecoh/public_html/ecohca/application/controllers/Reports.php:2712) /home/ecoh/public_html/ecohca/system/core/Common.php 568
ERROR - 2016-05-30 08:16:31 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:16:31 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:16:38 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:16:38 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:17:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY r.`material_identi`' at line 1 - Invalid query: SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` =6 AND r.`system_ID` IN ( 79,2,2,2,80,2,2,2,3,3,3,3,1,1,2 ) AND r.`material_identi` IN (12,13,14,15,16,17,18,19,20,21,22,23,24,25,26) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good` =2000 AND r.`poor` =0 AND r.`fair` =0 AND r.`debris` = GROUP BY r.`material_identi`
ERROR - 2016-05-30 08:17:03 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/ecoh/public_html/ecohca/application/controllers/Reports.php:2712) /home/ecoh/public_html/ecohca/system/core/Common.php 568
ERROR - 2016-05-30 08:21:36 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:21:36 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:21:40 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 08:21:40 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 08:21:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND r.`fair` = AND r.`debris` = GROUP BY r.`material_identi`' at line 1 - Invalid query: SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` =6 AND r.`system_ID` IN ( 79,2,2,2,80,2,2,2,3,3,3,3,1,1,2 ) AND r.`material_identi` IN (12,13,14,15,16,17,18,19,20,21,22,23,24,25,26) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good` =2000 AND r.`poor` = AND r.`fair` = AND r.`debris` = GROUP BY r.`material_identi`
ERROR - 2016-05-30 08:21:51 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/ecoh/public_html/ecohca/application/controllers/Reports.php:2712) /home/ecoh/public_html/ecohca/system/core/Common.php 568
ERROR - 2016-05-30 09:38:04 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 09:38:04 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 09:44:24 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 09:44:24 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 09:45:32 --> 404 Page Not Found: Assets/js
ERROR - 2016-05-30 09:45:32 --> 404 Page Not Found: Assets/images
ERROR - 2016-05-30 10:09:38 --> 404 Page Not Found: Assets/images
