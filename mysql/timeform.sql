/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.1.41 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `` (
	`form_id` int ,
	`form_code` varchar ,
	`form` varchar ,
	`status_id` tinyint ,
	`can_view` tinyint ,
	`can_delete` tinyint ,
	`is_leave` tinyint ,
	`special_leave` tinyint ,
	`with_credits` tinyint ,
	`is_blanket` tinyint ,
	`only_male` tinyint ,
	`only_female` tinyint ,
	`hr_validation` tinyint ,
	`class` varchar ,
	`description` text (196605),
	`order_by` int ,
	`deleted` tinyint 
); 
insert into `` (`form_id`, `form_code`, `form`, `status_id`, `can_view`, `can_delete`, `is_leave`, `special_leave`, `with_credits`, `is_blanket`, `only_male`, `only_female`, `hr_validation`, `class`, `description`, `order_by`, `deleted`) values('21','HL','Home Leave','0','1','1','1','0','1','1','0','0','0','fa fa-square-o',NULL,'0','0');
insert into `` (`form_id`, `form_code`, `form`, `status_id`, `can_view`, `can_delete`, `is_leave`, `special_leave`, `with_credits`, `is_blanket`, `only_male`, `only_female`, `hr_validation`, `class`, `description`, `order_by`, `deleted`) values('22','LIP','Leave Incentive Program','0','1','1','1','0','1','1','0','0','0','fa fa-square-o',NULL,'0','0');
insert into `` (`form_id`, `form_code`, `form`, `status_id`, `can_view`, `can_delete`, `is_leave`, `special_leave`, `with_credits`, `is_blanket`, `only_male`, `only_female`, `hr_validation`, `class`, `description`, `order_by`, `deleted`) values('23','FLV','Force Leave','0','1','1','0','0','0','0','0','0','0','fa fa-square-o',NULL,'0','0');
